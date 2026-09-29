<?php

namespace App\Livewire;

use App\Enums\ServiceRequestStatus;
use App\Models\Complaint;
use App\Models\ServiceRequest;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Cek Status Tiket & Lacak Berkas — SAPA SOSIAL')]
class CekStatus extends Component
{
    use WithFileUploads;

    #[Url(as: 'ticket')]
    public string $ticketInput = '';

    public string $identityKey = '';

    public ?ServiceRequest $serviceRequest = null;

    public ?Complaint $complaint = null;

    public ?string $errorMessage = null;

    // Revision upload
    public $revision_file;

    public string $revision_notes = '';

    public bool $revisionSuccess = false;

    public function mount(?string $ticket = null): void
    {
        if ($ticket) {
            $this->ticketInput = $ticket;
        }

        // If user is authenticated, we can attempt auto-check if ticket is provided
        if (filled($this->ticketInput) && auth()->check()) {
            $this->checkTicket();
        }
    }

    public function checkTicket(): void
    {
        $this->errorMessage = null;
        $this->serviceRequest = null;
        $this->complaint = null;

        $ticket = trim($this->ticketInput);

        if (empty($ticket)) {
            $this->errorMessage = 'Nomor tiket wajib diisi.';

            return;
        }

        // Check if it's a ServiceRequest (DTSEN, PBI, REHSOS, etc.)
        $sr = ServiceRequest::with(['serviceType', 'village.district', 'documents', 'dtsenCertificate', 'pbiReactivation', 'statusHistories'])
            ->where('request_number', 'ilike', $ticket)
            ->first();

        if ($sr) {
            // Verify privacy key if not admin/submitter
            if (! auth()->check() || (auth()->id() !== $sr->submitter_id && ! auth()->user()->hasRole(['administrator', 'petugas_dinsos']))) {
                if (empty($this->identityKey)) {
                    $this->errorMessage = 'Masukkan 4 digit terakhir NIK atau Nomor HP untuk memverifikasi kepemilikan tiket.';

                    return;
                }

                $nikLast4 = substr(preg_replace('/[^0-9]/', '', $sr->applicant_nik), -4);
                $phoneLast4 = substr(preg_replace('/[^0-9]/', '', $sr->phone), -4);
                $key = trim($this->identityKey);

                if ($key !== $nikLast4 && $key !== $phoneLast4) {
                    $this->errorMessage = '4 digit verifikasi tidak sesuai dengan data pemohon tiket ini.';

                    return;
                }
            }

            $this->serviceRequest = $sr;

            return;
        }

        // Check if it's a Complaint (ADU)
        $comp = Complaint::with(['category', 'village.district', 'attachments', 'statusHistories'])
            ->where('complaint_number', 'ilike', $ticket)
            ->first();

        if ($comp) {
            if (! auth()->check() || (auth()->id() !== $comp->reporter_id && ! auth()->user()->hasRole(['administrator', 'petugas_dinsos']))) {
                if (empty($this->identityKey)) {
                    $this->errorMessage = 'Masukkan 4 digit terakhir Nomor HP pelapor untuk verifikasi tiket pengaduan.';

                    return;
                }

                $phoneLast4 = substr(preg_replace('/[^0-9]/', '', $comp->reporter_phone), -4);
                if (trim($this->identityKey) !== $phoneLast4) {
                    $this->errorMessage = '4 digit verifikasi tidak sesuai dengan nomor HP pelapor.';

                    return;
                }
            }

            $this->complaint = $comp;

            return;
        }

        $this->errorMessage = "Nomor tiket '{$ticket}' tidak ditemukan dalam pangkalan data SAPA SOSIAL.";
    }

    public function uploadRevision(): void
    {
        $this->validate([
            'revision_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'revision_file.required' => 'Pilih berkas perbaikan yang akan diunggah.',
        ]);

        if (! $this->serviceRequest) {
            return;
        }

        $path = $this->revision_file->store('documents/revisions', 'local');

        $reqId = $this->serviceRequest->serviceType?->requirements()->first()?->id
            ?? $this->serviceRequest->serviceType?->requirements()->create([
                'name' => 'Berkas Perbaikan',
                'is_mandatory' => false,
                'allowed_mimes' => 'pdf,jpg,jpeg,png',
                'sort_order' => 99,
            ])->id;

        $this->serviceRequest->documents()->create([
            'service_requirement_id' => $reqId,
            'file_path' => $path,
            'original_name' => $this->revision_file->getClientOriginalName(),
            'verification_status' => 'pending',
            'notes' => 'Berkas perbaikan dari pemohon: '.($this->revision_notes ?: '-'),
        ]);

        $this->serviceRequest->update([
            'status' => ServiceRequestStatus::Submitted,
        ]);

        $this->serviceRequest->statusHistories()->create([
            'from_status' => ServiceRequestStatus::RevisionRequested->value,
            'to_status' => ServiceRequestStatus::Submitted->value,
            'notes' => 'Pemohon telah mengunggah perbaikan berkas.',
            'user_id' => auth()->id(),
        ]);

        $this->revisionSuccess = true;
        $this->checkTicket();
    }

    public function render()
    {
        return view('livewire.cek-status');
    }
}
