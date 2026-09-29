<?php

namespace App\Livewire;

use App\Models\InformationPage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Informasi & Prosedur Layanan — SAPA SOSIAL')]
class InformasiLayanan extends Component
{
    #[Url]
    public string $kategori = 'all';

    #[Url]
    public string $search = '';

    public ?string $slug = null;

    public function mount(?string $slug = null): void
    {
        $this->slug = $slug;
    }

    public function setCategory(string $category): void
    {
        $this->kategori = $category;
        $this->slug = null;
    }

    public function selectPage(string $slug): void
    {
        $this->slug = $slug;
    }

    public function clearSelected(): void
    {
        $this->slug = null;
    }

    public function render()
    {
        $selectedPage = null;

        if ($this->slug) {
            $selectedPage = InformationPage::query()
                ->where('slug', $this->slug)
                ->where('publish_status', 'published')
                ->with(['faqs', 'downloadableForms', 'serviceType'])
                ->first();
        }

        $pagesQuery = InformationPage::query()
            ->where('publish_status', 'published')
            ->when($this->kategori !== 'all', fn ($q) => $q->where('category', $this->kategori))
            ->when(filled($this->search), fn ($q) => $q->where(function ($sub) {
                $sub->where('title', 'ilike', "%{$this->search}%")
                    ->orWhere('description', 'ilike', "%{$this->search}%")
                    ->orWhere('requirements', 'ilike', "%{$this->search}%");
            }))
            ->latest('published_at');

        $pages = $pagesQuery->get();

        return view('livewire.informasi-layanan', [
            'pages' => $pages,
            'selectedPage' => $selectedPage,
        ]);
    }
}
