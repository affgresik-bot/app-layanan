<?php

namespace App\Livewire;

use App\Models\DtsenCertificate;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Verifikasi Keaslian Surat Keterangan — SAPA SOSIAL')]
class VerifikasiSurat extends Component
{
    #[Url(as: 'code')]
    public string $code = '';

    public ?DtsenCertificate $certificate = null;

    public string $checkStatus = 'idle'; // idle, valid, expired, not_found

    public function mount(?string $code = null): void
    {
        if ($code) {
            $this->code = $code;
            $this->verify();
        } elseif (filled($this->code)) {
            $this->verify();
        }
    }

    public function verify(): void
    {
        $code = trim($this->code);
        if (empty($code)) {
            $this->checkStatus = 'idle';
            $this->certificate = null;

            return;
        }

        $cert = DtsenCertificate::with(['purpose', 'signer', 'serviceRequest'])
            ->where('verification_code', 'ilike', $code)
            ->first();

        if (! $cert) {
            $this->certificate = null;
            $this->checkStatus = 'not_found';

            return;
        }

        $this->certificate = $cert;

        if ($cert->valid_until && $cert->valid_until->isPast()) {
            $this->checkStatus = 'expired';
        } else {
            $this->checkStatus = 'valid';
        }
    }

    public function render()
    {
        return view('livewire.verifikasi-surat');
    }
}
