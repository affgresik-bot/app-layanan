<div class="flex flex-col w-full">
    <!-- Header Banner & Navigation -->
    <section class="relative w-full bg-gradient-to-b from-surface-container-high/40 via-surface-container-low/20 to-transparent py-8 lg:py-10 border-b border-surface-container">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <!-- Breadcrumbs -->
            <nav aria-label="Jalur Navigasi" class="flex items-center gap-2 font-label-md text-label-md text-on-surface-variant mb-4">
                <a class="hover:text-primary transition-colors flex items-center gap-1.5" href="{{ route('home') }}">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    <span>Beranda</span>
                </a>
                <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                <span class="text-primary font-semibold">Ajukan Layanan</span>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary font-label-sm text-label-sm mb-3">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        <span>Pelayanan Terpadu Satu Pintu Dinsos Blitar</span>
                    </div>
                    <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight leading-tight">
                        Pilih Layanan yang Anda Butuhkan
                    </h1>
                    <p class="mt-2.5 font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                        Silakan pilih salah satu layanan sosial di bawah ini. Anda dapat memeriksa persyaratan dan langsung memulai pengisian formulir pengajuan secara online.
                    </p>
                </div>
                <div class="shrink-0 flex items-center gap-3 px-4 py-3 bg-surface-container-lowest rounded-xl shadow-sm border border-surface-container">
                    <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-[24px]">verified_user</span>
                    </div>
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Layanan Resmi Pemkab Blitar</p>
                        <p class="font-title-md text-title-md text-primary font-bold">Bebas Biaya (Rp 0,-)</p>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="mt-8 bg-surface-container-lowest rounded-2xl p-3 shadow-sm border border-surface-container">
                <div class="relative w-full flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-on-surface-variant text-[22px] pointer-events-none">search</span>
                    <input wire:model.live.debounce.300ms="search"
                           class="w-full h-12 pl-12 pr-4 rounded-xl bg-surface-container-low font-body-md text-body-md text-on-surface placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest transition-all"
                           placeholder="Cari jenis layanan sosial (contoh: SK DTSEN, KIS, Bantuan Lansia, Kursi Roda)..."
                           type="search"/>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Dual-Column Interactive Layout -->
    <section class="max-w-7xl mx-auto px-6 lg:px-12 py-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Service Catalog List -->
            <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-8">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed">
                                <span class="material-symbols-outlined text-[18px]">star</span>
                            </div>
                            <h2 class="font-headline-sm text-headline-sm text-on-surface tracking-tight">Katalog Layanan Sosial</h2>
                        </div>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Klik kartu untuk melihat syarat</span>
                    </div>

                    <div class="space-y-4">
                        @foreach($services as $srv)
                            @php
                                $isSelected = $selectedService && $selectedService->id === $srv->id;
                            @endphp
                            <article wire:click="selectService('{{ $srv->code }}')"
                                     class="cursor-pointer rounded-2xl p-6 transition-all duration-200 border {{ $isSelected ? 'bg-surface-container-lowest shadow-md ring-2 ring-primary border-primary' : 'bg-surface-container-lowest border-surface-container hover:border-outline-variant hover:shadow-sm' }}">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-xl {{ $isSelected ? 'bg-primary text-on-primary' : 'bg-surface-container text-primary' }} flex items-center justify-center shrink-0 shadow-sm transition-colors">
                                            @if($srv->code === 'DTSEN')
                                                <span class="material-symbols-outlined text-[26px]">assignment_turned_in</span>
                                            @elseif($srv->code === 'PBI')
                                                <span class="material-symbols-outlined text-[26px]">health_and_safety</span>
                                            @elseif($srv->code === 'REHSOS')
                                                <span class="material-symbols-outlined text-[26px]">accessible</span>
                                            @else
                                                <span class="material-symbols-outlined text-[26px]">dataset</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                                <span class="px-2.5 py-0.5 rounded-full bg-primary/10 text-primary font-label-sm text-label-sm font-semibold">
                                                    {{ $srv->category ?? 'Layanan Sosial' }}
                                                </span>
                                                @if($srv->code === 'DTSEN' || $srv->code === 'PBI')
                                                    <span class="px-2.5 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-[11px] font-bold flex items-center gap-1">
                                                        <span class="material-symbols-outlined text-[13px]">bolt</span> Prioritas
                                                    </span>
                                                @endif
                                            </div>
                                            <h3 class="font-title-md text-title-md text-on-surface font-bold">{{ $srv->name }}</h3>
                                            <p class="mt-1 font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                                                {{ $srv->description }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="shrink-0 flex items-center justify-between md:justify-end gap-3 pt-2 md:pt-0">
                                        @if($isSelected)
                                            <span class="font-label-sm text-label-sm px-3 py-1 rounded-full bg-primary text-on-primary font-semibold flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[15px]">check_circle</span>
                                                <span>Dipilih</span>
                                            </span>
                                        @else
                                            <span class="font-label-sm text-label-sm px-3 py-1 rounded-full bg-surface-container text-on-surface-variant font-medium">
                                                Pilih
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Side Panel (Requirements & Start CTA) -->
            <div class="lg:col-span-5 xl:col-span-4 sticky top-28">
                @if($selectedService)
                    <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-7 shadow-lg border border-surface-container flex flex-col gap-6">
                        <div>
                            <div class="flex items-center gap-2 text-primary font-label-sm text-label-sm font-bold uppercase tracking-wider mb-1">
                                <span class="material-symbols-outlined text-[18px]">verified</span>
                                <span>Layanan Terpilih</span>
                            </div>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $selectedService->name }}</h3>
                            <p class="mt-1 font-body-sm text-body-sm text-on-surface-variant">
                                Estimasi Waktu Proses: <strong>{{ $selectedService->sla_days ?? 2 }} Hari Kerja</strong>
                            </p>
                        </div>

                        <!-- Requirements Checklist -->
                        <div>
                            <h4 class="font-title-md text-title-md text-on-surface font-semibold mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[20px]">fact_check</span>
                                <span>Persyaratan Berkas</span>
                            </h4>
                            <div class="space-y-2.5">
                                @forelse($selectedService->requirements as $req)
                                    <div class="flex items-start gap-2.5 text-on-surface font-body-sm text-body-sm">
                                        <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">check_circle</span>
                                        <span>{{ $req->name }} @if($req->is_mandatory) <span class="text-error font-bold">*</span> @endif</span>
                                    </div>
                                @empty
                                    <div class="flex items-start gap-2.5 text-on-surface font-body-sm text-body-sm">
                                        <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">check_circle</span>
                                        <span>KTP Elektronik Asli</span>
                                    </div>
                                    <div class="flex items-start gap-2.5 text-on-surface font-body-sm text-body-sm">
                                        <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">check_circle</span>
                                        <span>Kartu Keluarga (KK) Asli</span>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div>
                            @if($selectedService->code === 'DTSEN')
                                <a href="{{ route('layanan.dtsen') }}"
                                   class="w-full min-h-[48px] py-3.5 px-6 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold shadow-md hover:bg-primary-container transition-all flex items-center justify-center gap-2">
                                    <span>Mulai Pengajuan SK DTSEN</span>
                                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                                </a>
                            @elseif($selectedService->code === 'PBI')
                                <a href="{{ route('layanan.pbi') }}"
                                   class="w-full min-h-[48px] py-3.5 px-6 rounded-xl bg-secondary-container text-on-secondary-container font-label-lg text-label-lg font-bold shadow-md hover:brightness-105 transition-all flex items-center justify-center gap-2">
                                    <span>Mulai Pengajuan Reaktivasi PBI</span>
                                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                                </a>
                            @else
                                <a href="{{ route('layanan.dtsen') }}"
                                   class="w-full min-h-[48px] py-3.5 px-6 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold shadow-md hover:bg-primary-container transition-all flex items-center justify-center gap-2">
                                    <span>Mulai Formulir Pengajuan</span>
                                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                                </a>
                            @endif
                        </div>

                        <!-- Hint Box -->
                        <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container flex items-start gap-3">
                            <span class="material-symbols-outlined text-secondary text-[22px] shrink-0">help</span>
                            <div class="text-on-surface-variant font-body-sm text-body-sm">
                                <span class="font-semibold text-on-surface">Butuh bantuan mengisi?</span>
                                <p class="mt-0.5">Datang ke Operator Kecamatan/Desa atau Puskesos terdekat dengan membawa berkas asli.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>
</div>
