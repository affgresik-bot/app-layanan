<?php

namespace App\Livewire;

use App\Enums\ServiceRequestStatus;
use App\Models\District;
use App\Models\DtsenCertificate;
use App\Models\DtsenPurpose;
use App\Models\NumberSequence;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceType;
use App\Models\StatusHistory;
use App\Models\Village;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Pengajuan Surat Keterangan DTSEN — SAPA SOSIAL')]
class PengajuanDtsen extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    // Step 1: Tujuan Penggunaan
    public ?int $dtsen_purpose_id = null;

    public string $purpose_description = '';

    // Step 2: Data Pemohon
    public string $applicant_name = '';

    public string $applicant_nik = '';

    public string $family_card_number = '';

    public string $address = '';

    public ?int $district_id = null;

    public ?int $village_id = null;

    public string $phone = '';

    // Step 2b: Data Orang yang Diterangkan (Subjek)
    public string $subject_name = '';

    public string $subject_nik = '';

    public string $relationship_to_applicant = 'diri_sendiri';

    // Step 3: Unggah Dokumen
    public $ktp_file;

    public $kk_file;

    // Step 4: Persetujuan
    public bool $agreement = false;

    // Result
    public ?string $submittedTicket = null;

    public function mount(): void
    {
        $firstPurpose = DtsenPurpose::where('is_active', true)->first();
        if ($firstPurpose) {
            $this->dtsen_purpose_id = $firstPurpose->id;
        }

        // If user logged in, prefill some info
        if (auth()->check()) {
            $user = auth()->user();
            $this->applicant_name = $user->name ?? '';
            $this->applicant_nik = $user->nik ?? '';
            $this->phone = $user->phone ?? '';
            $this->district_id = $user->district_id ?? null;
            $this->village_id = $user->village_id ?? null;
        }
    }

    public function updatedDistrictId(): void
    {
        $this->village_id = null;
    }

    public function updatedRelationshipToApplicant(): void
    {
        if ($this->relationship_to_applicant === 'diri_sendiri') {
            $this->subject_name = $this->applicant_name;
            $this->subject_nik = $this->applicant_nik;
        }
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'dtsen_purpose_id' => 'required|exists:dtsen_purposes,id',
            ], [
                'dtsen_purpose_id.required' => 'Silakan pilih tujuan penggunaan surat.',
            ]);
            $this->currentStep = 2;

            return;
        }

        if ($this->currentStep === 2) {
            $this->validate([
                'applicant_name' => 'required|string|max:255',
                'applicant_nik' => 'required|string|size:16',
                'family_card_number' => 'required|string|size:16',
                'address' => 'required|string',
                'district_id' => 'required|exists:districts,id',
                'village_id' => 'required|exists:villages,id',
                'phone' => 'required|string|min:9|max:16',
                'subject_name' => 'required|string|max:255',
                'subject_nik' => 'required|string|size:16',
                'relationship_to_applicant' => 'required|string',
            ], [
                'applicant_name.required' => 'Nama pemohon wajib diisi.',
                'applicant_nik.required' => 'NIK pemohon wajib 16 digit.',
                'applicant_nik.size' => 'NIK harus tepat 16 digit.',
                'family_card_number.required' => 'Nomor KK wajib 16 digit.',
                'family_card_number.size' => 'Nomor KK harus tepat 16 digit.',
                'address.required' => 'Alamat domisili wajib diisi.',
                'district_id.required' => 'Kecamatan wajib dipilih.',
                'village_id.required' => 'Desa/Kelurahan wajib dipilih.',
                'phone.required' => 'Nomor telepon/WhatsApp wajib diisi.',
                'subject_name.required' => 'Nama orang yang diterangkan wajib diisi.',
                'subject_nik.size' => 'NIK orang yang diterangkan harus tepat 16 digit.',
            ]);
            $this->currentStep = 3;

            return;
        }

        if ($this->currentStep === 3) {
            $this->validate([
                'ktp_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'kk_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ], [
                'ktp_file.required' => 'Dokumen KTP wajib diunggah.',
                'ktp_file.max' => 'Ukuran berkas KTP maksimal 5MB.',
                'kk_file.required' => 'Dokumen Kartu Keluarga wajib diunggah.',
                'kk_file.max' => 'Ukuran berkas Kartu Keluarga maksimal 5MB.',
            ]);
            $this->currentStep = 4;

            return;
        }
    }

    public function prevStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function submit(): void
    {
        $this->validate([
            'agreement' => 'accepted',
        ], [
            'agreement.accepted' => 'Anda harus menyetujui pernyataan keabsahan data.',
        ]);

        $ticket = DB::transaction(function () {
            $ticketNumber = NumberSequence::next('DTSEN');
            $serviceType = ServiceType::firstOrCreate(
                ['code' => 'DTSEN'],
                [
                    'name' => 'Surat Keterangan DTSEN',
                    'category' => 'Jaminan Sosial',
                    'description' => 'Surat keterangan status DTSEN dan peringkat desil.',
                    'handler' => 'dtsen',
                    'needs_assessment' => false,
                    'sla_days' => 2,
                    'is_active' => true,
                ]
            );

            // Store files to private disk
            $ktpPath = $this->ktp_file->store('documents/dtsen', 'local');
            $kkPath = $this->kk_file->store('documents/dtsen', 'local');

            $serviceRequest = ServiceRequest::create([
                'request_number' => $ticketNumber,
                'service_type_id' => $serviceType->id,
                'submitter_id' => auth()->id(),
                'applicant_name' => $this->applicant_name,
                'applicant_nik' => $this->applicant_nik,
                'family_card_number' => $this->family_card_number,
                'address' => $this->address,
                'village_id' => $this->village_id,
                'phone' => $this->phone,
                'submitted_at' => now(),
                'status' => ServiceRequestStatus::Submitted,
                'is_priority' => false,
            ]);

            DtsenCertificate::create([
                'service_request_id' => $serviceRequest->id,
                'dtsen_purpose_id' => $this->dtsen_purpose_id,
                'purpose_description' => $this->purpose_description ?: 'Keperluan resmi pemohon',
                'subject_name' => $this->subject_name,
                'subject_nik' => $this->subject_nik,
                'relationship_to_applicant' => $this->relationship_to_applicant,
            ]);

            // Requirements mapping
            $ktpReq = $serviceType->requirements()->where('name', 'ilike', '%KTP%')->first()
                ?? $serviceType->requirements()->create([
                    'name' => 'KTP Pemohon / Orang Tua',
                    'is_mandatory' => true,
                    'allowed_mimes' => 'pdf,jpg,jpeg,png',
                    'sort_order' => 1,
                ]);

            $kkReq = $serviceType->requirements()->where(function ($q) {
                $q->where('name', 'ilike', '%KK%')->orWhere('name', 'ilike', '%Kartu Keluarga%');
            })->first()
                ?? $serviceType->requirements()->create([
                    'name' => 'Kartu Keluarga (KK)',
                    'is_mandatory' => true,
                    'allowed_mimes' => 'pdf,jpg,jpeg,png',
                    'sort_order' => 2,
                ]);

            // Save documents
            ServiceRequestDocument::create([
                'service_request_id' => $serviceRequest->id,
                'service_requirement_id' => $ktpReq->id,
                'file_path' => $ktpPath,
                'original_name' => $this->ktp_file->getClientOriginalName(),
                'verification_status' => 'pending',
                'notes' => 'KTP Elektronik Asli',
            ]);

            ServiceRequestDocument::create([
                'service_request_id' => $serviceRequest->id,
                'service_requirement_id' => $kkReq->id,
                'file_path' => $kkPath,
                'original_name' => $this->kk_file->getClientOriginalName(),
                'verification_status' => 'pending',
                'notes' => 'Kartu Keluarga Asli',
            ]);

            // Log status history
            StatusHistory::create([
                'statusable_type' => ServiceRequest::class,
                'statusable_id' => $serviceRequest->id,
                'from_status' => null,
                'to_status' => ServiceRequestStatus::Submitted->value,
                'notes' => 'Permohonan diajukan melalui portal online SAPA SOSIAL.',
                'user_id' => auth()->id(),
            ]);

            return $ticketNumber;
        });

        $this->submittedTicket = $ticket;
    }

    public function render()
    {
        $purposes = DtsenPurpose::where('is_active', true)->get();
        $districts = District::orderBy('name')->get();
        $villages = $this->district_id
            ? Village::where('district_id', $this->district_id)->orderBy('name')->get()
            : collect();

        $selectedPurpose = $purposes->firstWhere('id', $this->dtsen_purpose_id);

        return view('livewire.pengajuan-dtsen', [
            'purposes' => $purposes,
            'districts' => $districts,
            'villages' => $villages,
            'selectedPurpose' => $selectedPurpose,
        ]);
    }
}
