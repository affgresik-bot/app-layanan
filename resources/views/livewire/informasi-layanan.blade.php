<div class="flex flex-col w-full">
    <!-- Top Utility Bar -->
    <section class="w-full bg-surface-container py-2.5 px-6 lg:px-12 border-b border-surface-container-high">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3 text-on-surface-variant font-label-sm text-label-sm">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary text-on-primary">
                    <span class="material-symbols-outlined text-[14px]">verified</span>
                </span>
                <span class="font-medium text-on-surface">Portal Standar Pelayanan Publik Resmi (SPP) Terintegrasi UU No. 25 Tahun 2009</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5 text-primary font-semibold">
                    <span class="material-symbols-outlined text-[16px]">lock_clock</span>
                    Tanpa Biaya & Bebas Pungutan Liar (Rp 0,-)
                </span>
            </div>
        </div>
    </section>

    <!-- Header & Search Section -->
    <section class="w-full bg-surface-container-low py-10 lg:py-14 border-b border-surface-container">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <!-- Breadcrumbs -->
            <nav aria-label="Breadcrumb" class="mb-4 flex items-center gap-2 text-on-surface-variant font-label-md text-label-md">
                <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('home') }}">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    <span>Beranda</span>
                </a>
                <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                @if($selectedPage)
                    <button wire:click="clearSelected" class="hover:text-primary transition-colors cursor-pointer">Informasi Layanan</button>
                    <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                    <span class="text-primary font-semibold">{{ $selectedPage->title }}</span>
                @else
                    <span class="text-primary font-semibold">Informasi Layanan</span>
                @endif
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end mb-8">
                <div class="lg:col-span-8 flex flex-col gap-2">
                    <div class="inline-flex items-center gap-2 self-start px-3.5 py-1.5 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm uppercase tracking-wide font-semibold">
                        <span class="material-symbols-outlined text-[16px]">menu_book</span>
                        Katalog Prosedur & Syarat Resmi
                    </div>
                    <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight leading-tight">
                        Katalog & Informasi Layanan Publik Dinsos
                    </h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-3xl leading-relaxed">
                        Pelajari prosedur resmi, kriteria desil DTKS/DTSEN, persyaratan dokumen, dan estimasi waktu penyelesaian sebelum mengajukan permohonan.
                    </p>
                </div>
                <div class="lg:col-span-4 flex flex-col items-start lg:items-end justify-center">
                    <div class="bg-surface-container-lowest p-5 rounded-2xl shadow-sm border border-surface-container w-full lg:max-w-xs flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-secondary-container flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-on-secondary-fixed text-[26px]">support_agent</span>
                        </div>
                        <div>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Pusat Bantuan Warga</p>
                            <p class="font-title-md text-title-md text-on-surface font-bold">0812-3456-7890</p>
                            <p class="font-body-sm text-body-sm text-secondary font-medium">Buka Hari Ini s/d 15.30 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-md p-3 border border-surface-container mb-6">
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-outline text-[24px]">search</span>
                    <input wire:model.live.debounce.300ms="search"
                           class="w-full h-14 pl-12 pr-4 rounded-xl bg-surface-container-low font-body-md text-body-md text-on-surface placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest transition-all"
                           placeholder="Cari informasi layanan, syarat dokumen, atau dasar hukum (contoh: KIS, DTSEN, Disabilitas)..."
                           type="text"/>
                </div>
            </div>

            <!-- Filter Pills -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2">
                <button wire:click="setCategory('all')"
                        class="px-5 py-2.5 rounded-full font-label-md text-label-md shrink-0 shadow-sm flex items-center gap-1.5 transition-all cursor-pointer {{ $kategori === 'all' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest text-on-surface hover:bg-surface-container' }}">
                    <span class="material-symbols-outlined text-[18px]">apps</span>
                    Semua Layanan ({{ $pages->count() }})
                </button>
                <button wire:click="setCategory('program')"
                        class="px-5 py-2.5 rounded-full font-label-md text-label-md shrink-0 shadow-sm flex items-center gap-1.5 transition-all cursor-pointer {{ $kategori === 'program' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest text-on-surface hover:bg-surface-container' }}">
                    <span class="material-symbols-outlined text-[18px]">groups</span>
                    Program Sosial (DTSEN)
                </button>
                <button wire:click="setCategory('rehabilitation')"
                        class="px-5 py-2.5 rounded-full font-label-md text-label-md shrink-0 shadow-sm flex items-center gap-1.5 transition-all cursor-pointer {{ $kategori === 'rehabilitation' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest text-on-surface hover:bg-surface-container' }}">
                    <span class="material-symbols-outlined text-[18px]">accessible</span>
                    Rehabilitasi Sosial
                </button>
                <button wire:click="setCategory('disability')"
                        class="px-5 py-2.5 rounded-full font-label-md text-label-md shrink-0 shadow-sm flex items-center gap-1.5 transition-all cursor-pointer {{ $kategori === 'disability' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest text-on-surface hover:bg-surface-container' }}">
                    <span class="material-symbols-outlined text-[18px]">health_and_safety</span>
                    Disabilitas
                </button>
                <button wire:click="setCategory('elderly')"
                        class="px-5 py-2.5 rounded-full font-label-md text-label-md shrink-0 shadow-sm flex items-center gap-1.5 transition-all cursor-pointer {{ $kategori === 'elderly' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest text-on-surface hover:bg-surface-container' }}">
                    <span class="material-symbols-outlined text-[18px]">elderly</span>
                    Lansia & ODGJ
                </button>
                <button wire:click="setCategory('complaint')"
                        class="px-5 py-2.5 rounded-full font-label-md text-label-md shrink-0 shadow-sm flex items-center gap-1.5 transition-all cursor-pointer {{ $kategori === 'complaint' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest text-on-surface hover:bg-surface-container' }}">
                    <span class="material-symbols-outlined text-[18px]">campaign</span>
                    Pengaduan Warga
                </button>
            </div>
        </div>
    </section>

    <!-- Content Area: Detail View OR Catalog Grid -->
    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-10 w-full">
        @if($selectedPage)
            <!-- DETAIL VIEW -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left (Main Content) -->
                <div class="lg:col-span-8 flex flex-col gap-8">
                    <!-- Title & Meta -->
                    <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm">
                        <div class="flex items-center justify-between gap-4 mb-3">
                            <span class="px-3 py-1 rounded-full bg-primary/10 text-primary font-label-sm text-label-sm font-semibold">
                                Kategori: {{ ucfirst($selectedPage->category) }}
                            </span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">
                                Diperbarui: {{ $selectedPage->updated_at ? $selectedPage->updated_at->format('d M Y') : 'Terbaru' }}
                            </span>
                        </div>
                        <h2 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                            {{ $selectedPage->title }}
                        </h2>
                        
                        <!-- Description -->
                        <div class="mt-6 font-body-md text-body-md text-on-surface-variant leading-relaxed space-y-4">
                            {!! nl2br(e($selectedPage->description)) !!}
                        </div>
                    </div>

                    <!-- Persyaratan (Checklist) -->
                    @if($selectedPage->requirements)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-surface-container">
                                <span class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">fact_check</span>
                                </span>
                                <div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Persyaratan Dokumen & Ketentuan</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Dokumen yang wajib dipersiapkan sebelum pengajuan</p>
                                </div>
                            </div>
                            <div class="font-body-md text-body-md text-on-surface leading-relaxed">
                                {!! nl2br(e($selectedPage->requirements)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Alur Pelayanan (Procedure) -->
                    @if($selectedPage->procedure)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm">
                            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-surface-container">
                                <span class="w-10 h-10 rounded-xl bg-secondary-container/20 text-secondary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">timeline</span>
                                </span>
                                <div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Alur Tahapan Pelayanan</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Prosedur verifikasi hingga surat/layanan selesai</p>
                                </div>
                            </div>
                            <div class="font-body-md text-body-md text-on-surface leading-relaxed">
                                {!! nl2br(e($selectedPage->procedure)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Waktu, Lokasi & Kontak -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container shadow-sm flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[24px]">schedule</span>
                            </div>
                            <div>
                                <h4 class="font-title-md text-title-md text-on-surface font-semibold">Waktu Pelayanan</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                                    {{ $selectedPage->service_hours ?? 'Senin - Jumat: 07.30 - 15.30 WIB' }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container shadow-sm flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-secondary-container/20 text-secondary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[24px]">location_on</span>
                            </div>
                            <div>
                                <h4 class="font-title-md text-title-md text-on-surface font-semibold">Lokasi Pelayanan</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                                    {{ $selectedPage->location ?? 'Kantor Dinas Sosial / Operator Desa Kanigoro Blitar' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQs attached to this page -->
                    @if($selectedPage->faqs->count() > 0)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm" x-data="{ active: null }">
                            <h3 class="font-headline-sm text-headline-sm text-on-surface mb-6">Pertanyaan Terkait Layanan Ini</h3>
                            <div class="flex flex-col gap-3">
                                @foreach($selectedPage->faqs as $i => $faq)
                                    <div class="border border-surface-container rounded-xl overflow-hidden">
                                        <button @click="active = (active === {{ $i }} ? null : {{ $i }})"
                                                class="w-full px-5 py-4 flex items-center justify-between text-left font-title-md text-title-md text-on-surface font-semibold hover:text-primary transition-colors cursor-pointer">
                                            <span>{{ $faq->question }}</span>
                                            <span class="material-symbols-outlined text-outline" :class="{ 'rotate-180 text-primary': active === {{ $i }} }">expand_more</span>
                                        </button>
                                        <div x-show="active === {{ $i }}" x-cloak class="px-5 pb-5 text-on-surface-variant font-body-sm text-body-sm border-t border-surface-container pt-3">
                                            {{ $faq->answer }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right (Sticky Sidebar) -->
                <div class="lg:col-span-4 sticky top-28 flex flex-col gap-6">
                    <div class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container shadow-md flex flex-col gap-4">
                        <h3 class="font-title-md text-title-md text-on-surface font-bold">Ajukan Secara Online</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">
                            Mulai proses permohonan sekarang secara mandiri atau dengan bantuan operator.
                        </p>
                        @if($selectedPage->serviceType && $selectedPage->serviceType->code === 'DTSEN')
                            <a href="{{ route('layanan.dtsen') }}" class="w-full py-3.5 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-semibold text-center hover:bg-primary-container transition-colors shadow-sm">
                                Ajukan Surat Keterangan DTSEN
                            </a>
                        @elseif($selectedPage->serviceType && $selectedPage->serviceType->code === 'PBI')
                            <a href="{{ route('layanan.pbi') }}" class="w-full py-3.5 rounded-xl bg-secondary-container text-on-secondary-container font-label-lg text-label-lg font-bold text-center hover:brightness-105 transition-colors shadow-sm">
                                Ajukan Reaktivasi KIS / PBI-JK
                            </a>
                        @else
                            <a href="{{ route('layanan.index') }}" class="w-full py-3.5 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-semibold text-center hover:bg-primary-container transition-colors shadow-sm">
                                Ajukan Layanan Ini
                            </a>
                        @endif

                        <a href="{{ route('pengaduan') }}" class="w-full py-3 rounded-xl bg-surface-container text-on-surface font-label-md text-label-md text-center hover:bg-surface-container-high transition-colors">
                            Sampaikan Pengaduan
                        </a>
                    </div>

                    <!-- Formulir Unduhan -->
                    @if($selectedPage->downloadableForms->count() > 0)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container shadow-md">
                            <h4 class="font-title-md text-title-md text-on-surface font-bold mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">download</span>
                                <span>Formulir Unduhan</span>
                            </h4>
                            <div class="flex flex-col gap-3">
                                @foreach($selectedPage->downloadableForms as $form)
                                    <div class="p-3 rounded-xl bg-surface-container-low border border-surface-container flex items-center justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="font-label-md text-label-md text-on-surface font-semibold truncate">{{ $form->name }}</p>
                                            <span class="text-[11px] px-2 py-0.5 rounded bg-primary/10 text-primary font-medium">v{{ $form->version }} (berlaku)</span>
                                        </div>
                                        <a href="{{ asset($form->file_path) }}" download class="w-9 h-9 rounded-lg bg-surface-container hover:bg-primary hover:text-on-primary text-primary flex items-center justify-center shrink-0 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">download</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- CATALOG GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pages as $page)
                    <article class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-1 rounded-md bg-primary/10 text-primary font-label-sm text-label-sm font-semibold">
                                    {{ ucfirst($page->category) }}
                                </span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">
                                    {{ $page->published_at ? $page->published_at->format('d M Y') : 'Terbaru' }}
                                </span>
                            </div>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">
                                {{ $page->title }}
                            </h3>
                            <p class="mt-2.5 font-body-sm text-body-sm text-on-surface-variant line-clamp-3 leading-relaxed">
                                {{ Str::limit(strip_tags($page->description), 130) }}
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-surface-container flex items-center justify-between">
                            <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-primary">verified</span> Dinsos Blitar
                            </span>
                            <button wire:click="selectPage('{{ $page->slug }}')"
                                    class="inline-flex items-center gap-1 font-label-md text-label-md text-primary font-bold hover:underline cursor-pointer group-hover:translate-x-1 transition-transform">
                                <span>Lihat Detail</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-16 text-center bg-surface-container-lowest rounded-2xl border border-surface-container">
                        <span class="material-symbols-outlined text-[48px] text-outline">search_off</span>
                        <h3 class="mt-2 font-headline-sm text-on-surface">Tidak ada informasi yang sesuai</h3>
                        <p class="mt-1 font-body-md text-on-surface-variant">Coba gunakan kata kunci pencarian yang lain atau pilih kategori Semua.</p>
                        <button wire:click="setCategory('all')" class="mt-4 px-5 py-2 rounded-xl bg-primary text-on-primary font-label-md cursor-pointer">
                            Tampilkan Semua Layanan
                        </button>
                    </div>
                @endforelse
            </div>
        @endif
    </section>
</div>
