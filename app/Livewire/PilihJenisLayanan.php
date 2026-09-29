<?php

namespace App\Livewire;

use App\Models\ServiceType;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Pilih Jenis Layanan — SAPA SOSIAL Dinas Sosial Kabupaten Blitar')]
class PilihJenisLayanan extends Component
{
    #[Url]
    public string $kategori = 'all';

    #[Url]
    public string $search = '';

    public string $selectedCode = 'DTSEN';

    public function selectService(string $code): void
    {
        $this->selectedCode = strtoupper($code);
    }

    public function render()
    {
        $services = ServiceType::query()
            ->where('is_active', true)
            ->with(['requirements' => fn ($q) => $q->orderBy('sort_order')])
            ->when(filled($this->search), fn ($q) => $q->where(function ($sub) {
                $sub->where('name', 'ilike', "%{$this->search}%")
                    ->orWhere('description', 'ilike', "%{$this->search}%");
            }))
            ->get();

        $selectedService = $services->firstWhere('code', $this->selectedCode) ?? $services->first();

        return view('livewire.pilih-jenis-layanan', [
            'services' => $services,
            'selectedService' => $selectedService,
        ]);
    }
}
