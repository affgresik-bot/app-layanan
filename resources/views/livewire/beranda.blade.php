<div class="flex flex-col w-full">
    <!-- HERO SECTION -->
    <section class="relative w-full overflow-hidden bg-gradient-to-b from-surface-container-low via-surface to-background pb-16 pt-8 lg:pt-14">
        <!-- Ambient Glowing Backdrop -->
        <div class="pointer-events-none absolute -top-24 right-10 w-96 h-96 rounded-full bg-primary/10 blur-3xl"></div>
        <div class="pointer-events-none absolute top-48 -left-20 w-80 h-80 rounded-full bg-secondary-container/15 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
            <!-- Civic Badge -->
            <div class="flex items-center gap-2 mb-6">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    Portal Resmi Pelayanan Terpadu Satu Pintu
                </span>
                <span class="hidden sm:inline text-on-surface-variant font-label-sm text-label-sm">• Terhubung dengan Data Terpadu Kesejahteraan Sosial (DTKS)</span>
            </div>

            <!-- Hero Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                <!-- Left: Headline & Actions -->
                <div class="lg:col-span-7 flex flex-col">
                    <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight leading-tight">
                        Satu Pintu Layanan Sosial <span class="text-primary">Kabupaten Blitar</span>
                    </h1>
                    <p class="mt-4 font-body-lg text-body-lg text-on-surface-variant max-w-2xl leading-relaxed">
                        Ajukan layanan, sampaikan pengaduan, dan pantau prosesnya secara online dengan nomor tiket resmi langsung dari gawai Anda tanpa harus antre di kantor dinas.
                    </p>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="{{ route('layanan.index') }}"
                           class="min-h-[48px] px-7 py-3 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg shadow-md hover:bg-primary-container hover:shadow-lg transition-all flex items-center justify-center gap-2 group">
                            <span class="material-symbols-outlined text-[20px] transition-transform group-hover:translate-x-0.5">assignment_turned_in</span>
                            <span>Ajukan Layanan</span>
                            <span class="ml-1 inline-block w-2 h-2 rounded-full bg-secondary-container"></span>
                        </a>
                        <a href="{{ route('cek-status') }}"
                           class="min-h-[48px] px-7 py-3 rounded-xl bg-surface-container-lowest text-primary font-label-lg text-label-lg shadow-sm hover:bg-surface-container-high transition-all flex items-center justify-center gap-2 border border-outline-variant">
                            <span class="material-symbols-outlined text-[20px]">manage_search</span>
                            <span>Cek Status Tiket</span>
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <div class="mt-8 pt-6 flex flex-wrap items-center gap-6 text-on-surface-variant font-label-sm text-label-sm border-t border-surface-container">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[18px]">verified</span>
                            <span>100% Bebas Pungutan Biaya</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[18px]">lock</span>
                            <span>Kerahasiaan NIK Terlindungi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[18px]">bolt</span>
                            <span>Validasi Terpadu 22 Kecamatan</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Track Card -->
                <div class="lg:col-span-5" id="quick-track">
                    <div class="relative bg-surface-container-lowest rounded-2xl p-6 sm:p-8 shadow-xl border border-surface-container overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full pointer-events-none"></div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[22px]">radar</span>
                                </div>
                                <div>
                                    <h2 class="font-title-md text-title-md text-on-surface">Lacak Cepat Berkas</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Ketahui status permohonan terkini</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-surface-container text-primary font-label-sm text-label-sm font-semibold">Live</span>
                        </div>

                        <form wire:submit="trackTicket" class="flex flex-col gap-3 mt-4">
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-2" for="ticketInput">
                                    Nomor Tiket Permohonan <span class="text-error">*</span>
                                </label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px]">tag</span>
                                    <input wire:model="ticketNumber"
                                           class="w-full min-h-[48px] pl-11 pr-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary transition-all uppercase"
                                           id="ticketInput"
                                           placeholder="Contoh: DTSEN-202610-00012"
                                           required
                                           type="text"/>
                                </div>
                                @error('ticketNumber')
                                    <p class="mt-1 font-body-sm text-body-sm text-error">{{ $message }}</p>
                                @enderror
                                <p class="mt-1.5 font-body-sm text-body-sm text-on-surface-variant">Diterima melalui SMS/WhatsApp atau bukti saat pengajuan berkas.</p>
                            </div>

                            <button type="submit"
                                    class="w-full min-h-[48px] mt-2 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg shadow-md hover:bg-primary-container transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <span class="material-symbols-outlined text-[20px]">search</span>
                                <span>Lacak Berkas Sekarang</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LAYANAN UTAMA SECTION -->
    <section class="w-full py-16 bg-surface-container-low" id="layanan-utama">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-container/20 text-secondary font-label-sm text-label-sm font-semibold mb-2">
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        Layanan Prioritas Warga
                    </div>
                    <h2 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                        Tiga Layanan Paling Sering Diakses
                    </h2>
                    <p class="mt-1 font-body-md text-body-md text-on-surface-variant">
                        Prioritas penanganan online Dinas Sosial Kabupaten Blitar untuk kebutuhan mendesak masyarakat.
                    </p>
                </div>
                <a href="{{ route('layanan.index') }}" class="font-label-md text-label-md text-primary font-semibold hover:underline flex items-center gap-1">
                    <span>Lihat Semua Layanan</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>

            <!-- 3 Highlighted Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <!-- Card 1: SK DTSEN -->
                <div class="bg-surface-container-lowest rounded-2xl p-7 shadow-md border border-surface-container hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-5 group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-[32px]">assignment_turned_in</span>
                        </div>
                        <span class="inline-block px-2.5 py-1 rounded-md bg-surface-container text-primary font-label-sm text-label-sm font-semibold mb-3">
                            Pendidikan & Bantuan
                        </span>
                        <h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors">
                            Surat Keterangan DTSEN
                        </h3>
                        <p class="mt-3 font-body-md text-body-md text-on-surface-variant leading-relaxed">
                            Surat status DTKS/DTSEN dan desil resmi untuk syarat SPMB jalur afirmasi, PIP, KIP Kuliah, bantuan sosial, dan keringanan rumah sakit.
                        </p>
                    </div>
                    <div class="mt-8 pt-5 border-t border-surface-container flex items-center justify-between">
                        <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-primary">schedule</span> 1–2 Hari Kerja
                        </span>
                        <a href="{{ route('layanan.dtsen') }}"
                           class="inline-flex items-center gap-1 font-label-md text-label-md text-primary font-bold group-hover:translate-x-1 transition-transform">
                            <span>Ajukan Sekarang</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Reaktivasi KIS / PBI-JK -->
                <div class="bg-surface-container-lowest rounded-2xl p-7 shadow-md border border-surface-container hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-secondary-container/20 text-secondary flex items-center justify-center mb-5 group-hover:bg-secondary-container group-hover:text-on-secondary-container transition-colors">
                            <span class="material-symbols-outlined text-[32px]">health_and_safety</span>
                        </div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2.5 py-1 rounded-md bg-secondary-container/20 text-secondary font-label-sm text-label-sm font-bold">
                                Jaminan Kesehatan
                            </span>
                            <span class="px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-[11px] font-bold">
                                Prioritas Darurat Medis
                            </span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-secondary transition-colors">
                            Reaktivasi KIS / PBI-JK
                        </h3>
                        <p class="mt-3 font-body-md text-body-md text-on-surface-variant leading-relaxed">
                            Fasilitasi pengaktifan kembali kepesertaan BPJS Kesehatan PBI yang dinonaktifkan untuk pasien darurat medis, penyakit kronis, atau bayi baru lahir.
                        </p>
                    </div>
                    <div class="mt-8 pt-5 border-t border-surface-container flex items-center justify-between">
                        <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-secondary">flash_on</span> 24 Jam Darurat
                        </span>
                        <a href="{{ route('layanan.pbi') }}"
                           class="inline-flex items-center gap-1 font-label-md text-label-md text-secondary font-bold group-hover:translate-x-1 transition-transform">
                            <span>Ajukan Sekarang</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    </div>
                </div>

                <!-- Card 3: Pelayanan Rehabilitasi Sosial -->
                <div class="bg-surface-container-lowest rounded-2xl p-7 shadow-md border border-surface-container hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-tertiary-container/20 text-tertiary flex items-center justify-center mb-5 group-hover:bg-tertiary group-hover:text-on-tertiary transition-colors">
                            <span class="material-symbols-outlined text-[32px]">accessible</span>
                        </div>
                        <span class="inline-block px-2.5 py-1 rounded-md bg-surface-container text-tertiary font-label-sm text-label-sm font-semibold mb-3">
                            Pendampingan Warga
                        </span>
                        <h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-tertiary transition-colors">
                            Pelayanan Rehabilitasi Sosial
                        </h3>
                        <p class="mt-3 font-body-md text-body-md text-on-surface-variant leading-relaxed">
                            Penanganan terpadu untuk lansia terlantar, penyandang disabilitas, ODGJ terlantar, anak berhadapan hukum, dan korban kekerasan melalui assessment dan rujukan.
                        </p>
                    </div>
                    <div class="mt-8 pt-5 border-t border-surface-container flex items-center justify-between">
                        <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-tertiary">support</span> Pendampingan Khusus
                        </span>
                        <a href="{{ route('layanan.index') }}"
                           class="inline-flex items-center gap-1 font-label-md text-label-md text-tertiary font-bold group-hover:translate-x-1 transition-transform">
                            <span>Pelajari Alur</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Secondary Row: 3 Smaller Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <a href="{{ route('layanan.index') }}" class="p-5 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm hover:shadow-md transition-all flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0 group-hover:bg-primary group-hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined text-[24px]">dataset</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-title-md text-title-md text-on-surface font-semibold group-hover:text-primary transition-colors">Pengajuan Layanan Lainnya</h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Rekomendasi bantuan sosial, bansos terencana, dll.</p>
                    </div>
                    <span class="material-symbols-outlined text-outline group-hover:translate-x-1 transition-transform">chevron_right</span>
                </a>

                <a href="{{ route('pengaduan') }}" class="p-5 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm hover:shadow-md transition-all flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-xl bg-error-container/40 text-error flex items-center justify-center shrink-0 group-hover:bg-error group-hover:text-on-error transition-colors">
                        <span class="material-symbols-outlined text-[24px]">campaign</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-title-md text-title-md text-on-surface font-semibold group-hover:text-error transition-colors">Pengaduan Sosial</h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Laporkan permasalahan PMKS / bansos di sekitar Anda</p>
                    </div>
                    <span class="material-symbols-outlined text-outline group-hover:translate-x-1 transition-transform">chevron_right</span>
                </a>

                <a href="{{ route('verifikasi') }}" class="p-5 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm hover:shadow-md transition-all flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-xl bg-primary-container/20 text-primary flex items-center justify-center shrink-0 group-hover:bg-primary-container group-hover:text-on-primary-container transition-colors">
                        <span class="material-symbols-outlined text-[24px]">qr_code_scanner</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-title-md text-title-md text-on-surface font-semibold group-hover:text-primary transition-colors">Verifikasi Keaslian Surat</h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Validasi keaslian SK DTSEN via QR Code / Kode</p>
                    </div>
                    <span class="material-symbols-outlined text-outline group-hover:translate-x-1 transition-transform">chevron_right</span>
                </a>
            </div>
        </div>
    </section>

    <!-- STEPPER: BAGAIMANA CARANYA? -->
    <section class="w-full py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary font-label-sm text-label-sm font-semibold mb-2">
                    Alur Mudah & Transparan
                </span>
                <h2 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                    Bagaimana Cara Mengajukan Layanan?
                </h2>
                <p class="mt-2 font-body-md text-body-md text-on-surface-variant">
                    Empat langkah sederhana untuk mengajukan dan memantau surat layanan sosial Anda hingga tuntas.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
                <!-- Step 1 -->
                <div class="p-6 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm relative">
                    <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-lg mb-4">
                        1
                    </div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Pilih Jenis Layanan</h3>
                    <p class="mt-2 font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Pilih jenis layanan yang Anda butuhkan (SK DTSEN, KIS PBI, atau pengaduan sosial) di katalog.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="p-6 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm relative">
                    <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-lg mb-4">
                        2
                    </div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Isi Data & Unggah</h3>
                    <p class="mt-2 font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Lengkapi formulir identitas NIK/KK dan unggah foto/scan dokumen persyaratan yang diminta.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="p-6 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm relative">
                    <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-lg mb-4">
                        3
                    </div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Dapatkan Nomor Tiket</h3>
                    <p class="mt-2 font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Sistem secara otomatis menerbitkan nomor tiket unik resmi (contoh: DTSEN-202610-00012).
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="p-6 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm relative">
                    <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-lg mb-4">
                        4
                    </div>
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Pantau & Unduh Surat</h3>
                    <p class="mt-2 font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Pantau setiap tahap proses secara realtime dan unduh surat resmi ber-barcode saat selesai.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- INFORMASI & ARTIKEL TERBARU -->
    @if($articles->count() > 0)
        <section class="w-full py-16 bg-surface-container-low">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <span class="inline-block px-3 py-1 rounded-full bg-surface-container-high text-primary font-label-sm text-label-sm font-semibold mb-2">
                            Pusat Informasi
                        </span>
                        <h2 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                            Informasi Layanan & Pengumuman
                        </h2>
                    </div>
                    <a href="{{ route('informasi.index') }}" class="font-label-md text-label-md text-primary font-semibold hover:underline flex items-center gap-1">
                        <span>Lihat Semua Informasi</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($articles as $article)
                        <article class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-surface-container hover:shadow-md transition-shadow flex flex-col justify-between">
                            <div>
                                <span class="px-2.5 py-1 rounded-md bg-primary/10 text-primary font-label-sm text-label-sm font-semibold">
                                    {{ ucfirst($article->category) }}
                                </span>
                                <h3 class="mt-3 font-title-md text-title-md text-on-surface font-bold line-clamp-2">
                                    {{ $article->title }}
                                </h3>
                                <p class="mt-2 font-body-sm text-body-sm text-on-surface-variant line-clamp-3">
                                    {{ Str::limit(strip_tags($article->description), 140) }}
                                </p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-surface-container flex items-center justify-between text-on-surface-variant font-label-sm text-label-sm">
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : 'Terbaru' }}</span>
                                <a href="{{ route('informasi.show', $article->slug) }}" class="text-primary font-semibold hover:underline flex items-center gap-0.5">
                                    <span>Detail</span>
                                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- FAQ SECTION (ACCORDION) -->
    @if($faqs->count() > 0)
        <section class="w-full py-16 bg-surface">
            <div class="max-w-4xl mx-auto px-6">
                <div class="text-center mb-10">
                    <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary font-label-sm text-label-sm font-semibold mb-2">
                        Tanya Jawab Warga
                    </span>
                    <h2 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                        Pertanyaan yang Sering Diajukan
                    </h2>
                </div>

                <div class="flex flex-col gap-4" x-data="{ active: null }">
                    @foreach($faqs as $index => $faq)
                        <div class="bg-surface-container-lowest rounded-2xl border border-surface-container shadow-sm overflow-hidden">
                            <button @click="active = (active === {{ $index }} ? null : {{ $index }})"
                                    type="button"
                                    class="w-full px-6 py-5 flex items-center justify-between text-left font-title-md text-title-md text-on-surface font-semibold hover:text-primary transition-colors cursor-pointer">
                                <span>{{ $faq->question }}</span>
                                <span class="material-symbols-outlined text-outline transition-transform duration-200"
                                      :class="{ 'rotate-180 text-primary': active === {{ $index }} }">expand_more</span>
                            </button>
                            <div x-show="active === {{ $index }}" x-cloak x-collapse
                                 class="px-6 pb-6 font-body-md text-body-md text-on-surface-variant leading-relaxed border-t border-surface-container pt-4">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- HELP / OPERATOR PUSKESOS BANNER -->
    <section class="w-full py-12 bg-primary text-on-primary">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-on-primary/10 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-on-primary text-[32px]">support_agent</span>
                </div>
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-on-primary">Kesulitan Mengisi Formulir Online?</h3>
                    <p class="font-body-md text-body-md text-on-primary/80 mt-0.5">
                        Kunjungi Operator Desa / Puskesos di kantor desa/kelurahan terdekat. Petugas kami siap membantu pengajuan Anda.
                    </p>
                </div>
            </div>
            <a href="https://wa.me/6281234567890" target="_blank"
               class="px-6 py-3 rounded-xl bg-secondary-container text-on-secondary-container font-label-lg text-label-lg font-bold shadow-md hover:brightness-105 transition-all shrink-0 flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">chat</span>
                <span>Hubungi Layanan Bantuan</span>
            </a>
        </div>
    </section>
</div>
