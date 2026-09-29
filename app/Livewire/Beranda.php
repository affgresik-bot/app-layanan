<?php

namespace App\Livewire;

use App\Models\Faq;
use App\Models\InformationPage;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Beranda — SAPA SOSIAL Dinas Sosial Kabupaten Blitar')]
class Beranda extends Component
{
    public string $ticketNumber = '';

    public function trackTicket(): void
    {
        $this->validate([
            'ticketNumber' => 'required|string|min:5',
        ], [
            'ticketNumber.required' => 'Nomor tiket wajib diisi.',
            'ticketNumber.min' => 'Format nomor tiket tidak valid.',
        ]);

        $this->redirect(route('cek-status', ['ticket' => trim($this->ticketNumber)]), navigate: true);
    }

    public function render()
    {
        $articles = InformationPage::query()
            ->where('publish_status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        $faqs = Faq::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(5)
            ->get();

        return view('livewire.beranda', [
            'articles' => $articles,
            'faqs' => $faqs,
        ]);
    }
}
