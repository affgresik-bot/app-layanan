<?php

namespace App\Livewire;

use App\Enums\PbiReason;
use App\Enums\ServiceRequestStatus;
use App\Models\District;
use App\Models\NumberSequence;
use App\Models\PbiReactivation;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceType;
use App\Models\StatusHistory;
use App\Models\Village;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Pengajuan Reaktivasi KIS / PBI-JK — SAPA SOSIAL')]
class PengajuanPbi extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    // Step 1: Data Peserta
    public string $participant_name = '';

    public string $participant_nik = '';

    public string $bpjs_card_number = '';

    public string $deactivated_date = '';

    public ?int $district_id = null;

    public ?int $village_id = null;

    public string $address = '';

    public string $phone = '';

    // Step 2: Alasan Reaktivasi
    public string $reason = 'emergency';

    public string $health_facility_name = '';

    public string $health_letter_number = '';

    // Step 3: Unggah Dokumen
    public $ktp_file;

    public $kk_file;

    public $bpjs_file;

    public $health_letter_file;

    // Step 4: Persetujuan
    public bool $agreement = false;

    // Result
    public ?string $submittedTicket = null;

    public function mount(): void
    {
        if (auth()->check()) {
            $user = auth()->user();
            $this->participant_name = $user->name ?? '';
            $this->participant_nik = $user->nik ?? '';
            $this->phone = $user->phone ?? '';
            $this->district_id = $user->district_id ?? null;
            $this->village_id = $user->village_id ?? null;
        }
    }

    public function updatedDistrictId(): void
    {
        $this->village_id = null;
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'participant_name' => 'required|string|max:255',
                'participant_nik' => 'required|string|size:16',
                'bpjs_card_number' => 'required|string|min:10|max:20',
                'deactivated_date' => 'required|date',
                'district_id' => 'required|exists:districts,id',
                'village_id' => 'required|exists:villages,id',
                'address' => 'required|string',
                'phone' => 'required|string|min:9|max:16',
            ], [
                'participant_name.required' => 'Nama peserta wajib diisi.',
                'participant_nik.size' => 'NIK harus tepat 16 digit.',
                'bpjs_card_number.required' => 'Nomor kartu BPJS/KIS wajib diisi.',
                'deactivated_date.required' => 'Perkiraan tanggal nonaktif wajib diisi.',
                'district_id.required' => 'Kecamatan wajib dipilih.',
                'village_id.required' => 'Desa/Kelurahan wajib dipilih.',
                'phone.required' => 'Nomor telepon/WhatsApp wajib diisi.',
            ]);
            $this->currentStep = 2;

            return;
        }

        if ($this->currentStep === 2) {
            $rules = [
                'reason' => 'required|string',
            ];

            if (in_array($this->reason, ['emergency', 'chronic', 'catastrophic'])) {
                $rules['health_facility_name'] = 'required|string|max:255';
                $rules['health_letter_number'] = 'required|string|max:255';
            }

            $this->validate($rules, [
                'reason.required' => 'Silakan pilih alasan reaktivasi.',
                'health_facility_name.required' => 'Nama fasilitas kesehatan / RS wajib diisi untuk alasan medis.',
                'health_letter_number.required' => 'Nomor surat keterangan medis / faskes wajib diisi.',
            ]);
            $this->currentStep = 3;

            return;
        }

        if ($this->currentStep === 3) {
            $rules = [
                'ktp_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'kk_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'bpjs_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ];

            if (in_array($this->reason, ['emergency', 'chronic', 'catastrophic'])) {
                $rules['health_letter_file'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
            }

            $this->validate($rules, [
                'ktp_file.required' => 'Dokumen KTP wajib diunggah.',
                'kk_file.required' => 'Dokumen KK wajib diunggah.',
                'bpjs_file.required' => 'Foto Kartu BPJS/KIS wajib diunggah.',
                'health_letter_file.required' => 'Surat keterangan dari Faskes wajib diunggah untuk alasan medis.',
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
            $ticketNumber = NumberSequence::next('PBI');
            $serviceType = ServiceType::firstOrCreate(
                ['code' => 'PBI'],
                [
                    'name' => 'Reaktivasi KIS / PBI-JK',
                    'category' => 'Bantuan Medis',
                    'description' => 'Reaktivasi kepesertaan BPJS Kesehatan PBI yang dinonaktifkan.',
                    'handler' => 'pbi',
                    'needs_assessment' => false,
                    'sla_days' => 1,
                    'is_active' => true,
                ]
            );

            $isPriority = ($this->reason === 'emergency');

            // Store files
            $ktpPath = $this->ktp_file->store('documents/pbi', 'local');
            $kkPath = $this->kk_file->store('documents/pbi', 'local');
            $bpjsPath = $this->bpjs_file->store('documents/pbi', 'local');
            $healthLetterPath = $this->health_letter_file ? $this->health_letter_file->store('documents/pbi', 'local') : null;

            $serviceRequest = ServiceRequest::create([
                'request_number' => $ticketNumber,
                'service_type_id' => $serviceType->id,
                'submitter_id' => auth()->id(),
                'applicant_name' => $this->participant_name,
                'applicant_nik' => $this->participant_nik,
                'family_card_number' => $this->participant_nik, // fallback
                'address' => $this->address,
                'village_id' => $this->village_id,
                'phone' => $this->phone,
                'submitted_at' => now(),
                'status' => ServiceRequestStatus::Submitted,
                'is_priority' => $isPriority,
            ]);

            PbiReactivation::create([
                'service_request_id' => $serviceRequest->id,
                'participant_name' => $this->participant_name,
                'participant_nik' => $this->participant_nik,
                'bpjs_card_number' => $this->bpjs_card_number,
                'deactivated_date' => $this->deactivated_date,
                'reason' => PbiReason::tryFrom($this->reason) ?? PbiReason::Emergency,
                'health_facility_name' => $this->health_facility_name ?: null,
                'health_letter_number' => $this->health_letter_number ?: null,
            ]);

            // Requirements mapping
            $ktpReq = $serviceType->requirements()->where('name', 'ilike', '%KTP%')->first()
                ?? $serviceType->requirements()->create([
                    'name' => 'KTP Peserta',
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

            $bpjsReq = $serviceType->requirements()->where(function ($q) {
                $q->where('name', 'ilike', '%KIS%')->orWhere('name', 'ilike', '%BPJS%');
            })->first()
                ?? $serviceType->requirements()->create([
                    'name' => 'Kartu KIS / BPJS Kesehatan',
                    'is_mandatory' => true,
                    'allowed_mimes' => 'pdf,jpg,jpeg,png',
                    'sort_order' => 3,
                ]);

            $healthReq = $serviceType->requirements()->where(function ($q) {
                $q->where('name', 'ilike', '%Rawat Inap%')->orWhere('name', 'ilike', '%Medis%')->orWhere('name', 'ilike', '%Faskes%');
            })->first()
                ?? $serviceType->requirements()->create([
                    'name' => 'Surat Keterangan Rawat Inap / Resume Medis Faskes',
                    'is_mandatory' => true,
                    'allowed_mimes' => 'pdf,jpg,jpeg,png',
                    'sort_order' => 4,
                ]);

            // Save documents
            ServiceRequestDocument::create([
                'service_request_id' => $serviceRequest->id,
                'service_requirement_id' => $ktpReq->id,
                'file_path' => $ktpPath,
                'original_name' => $this->ktp_file->getClientOriginalName(),
                'verification_status' => 'pending',
                'notes' => 'KTP Peserta',
            ]);
            ServiceRequestDocument::create([
                'service_request_id' => $serviceRequest->id,
                'service_requirement_id' => $kkReq->id,
                'file_path' => $kkPath,
                'original_name' => $this->kk_file->getClientOriginalName(),
                'verification_status' => 'pending',
                'notes' => 'Kartu Keluarga',
            ]);
            ServiceRequestDocument::create([
                'service_request_id' => $serviceRequest->id,
                'service_requirement_id' => $bpjsReq->id,
                'file_path' => $bpjsPath,
                'original_name' => $this->bpjs_file->getClientOriginalName(),
                'verification_status' => 'pending',
                'notes' => 'Kartu BPJS/KIS',
            ]);
            if ($healthLetterPath) {
                ServiceRequestDocument::create([
                    'service_request_id' => $serviceRequest->id,
                    'service_requirement_id' => $healthReq->id,
                    'file_path' => $healthLetterPath,
                    'original_name' => $this->health_letter_file->getClientOriginalName(),
                    'verification_status' => 'pending',
                    'notes' => 'Surat Keterangan Rawat Faskes',
                ]);
            }

            StatusHistory::create([
                'statusable_type' => ServiceRequest::class,
                'statusable_id' => $serviceRequest->id,
                'from_status' => null,
                'to_status' => ServiceRequestStatus::Submitted->value,
                'notes' => 'Permohonan reaktivasi KIS diajukan via portal online SAPA SOSIAL'.($isPriority ? ' (Prioritas Darurat Medis)' : ''),
                'user_id' => auth()->id(),
            ]);

            return $ticketNumber;
        });

        $this->submittedTicket = $ticket;
    }

    public function render()
    {
        $districts = District::orderBy('name')->get();
        $villages = $this->district_id
            ? Village::where('district_id', $this->district_id)->orderBy('name')->get()
            : collect();

        return view('livewire.pengajuan-pbi', [
            'districts' => $districts,
            'villages' => $villages,
        ]);
    }
}
