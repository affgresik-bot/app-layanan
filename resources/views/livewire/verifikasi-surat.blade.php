<div class="flex flex-col w-full py-8 lg:py-14 bg-background min-h-[85vh]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" class="mb-6 flex items-center gap-2 text-on-surface-variant font-label-md text-label-md">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('home') }}">
                <span class="material-symbols-outlined text-[18px]">home</span>
                <span>Beranda</span>
            </a>
            <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
            <span class="text-primary font-semibold">Verifikasi Keaslian Surat</span>
        </nav>

        <!-- Search Input Card -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-md border border-surface-container p-6 sm:p-8 mb-8 text-center">
            <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-[32px]">qr_code_scanner</span>
            </div>
            <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                Verifikasi Keaslian Surat Keterangan
            </h1>
            <p class="font-body-md text-body-md text-on-surface-variant mt-2 max-w-lg mx-auto leading-relaxed">
                Pindai kode QR pada lembar surat fisik atau masukkan kode verifikasi unik untuk memastikan keaslian dokumen yang diterbitkan Dinas Sosial Kabupaten Blitar.
            </p>

            <form wire:submit="verify" class="mt-8 flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px]">pin</span>
                    <input wire:model="code"
                           type="text"
                           required
                           placeholder="Masukkan kode verifikasi (contoh: VRF-DTSEN-xxxx)"
                           class="w-full h-12 pl-11 pr-4 bg-surface-container-low text-on-surface rounded-xl font-mono text-center font-bold tracking-wider focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all uppercase"/>
                </div>
                <button type="submit"
                        class="h-12 px-8 bg-primary hover:bg-primary-container text-on-primary font-label-md font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
                    <span class="material-symbols-outlined text-[20px]">verified</span>
                    <span>Periksa Keaslian</span>
                </button>
            </form>
        </div>

        <!-- 3 STATES ACCORDING TO PRD -->
        @if($checkStatus === 'valid' && $certificate)
            <!-- STATE 1: VALID (GREEN) -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-xl border-2 border-green-500 overflow-hidden">
                <div class="bg-green-600 text-white p-6 sm:p-8 text-center flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full bg-white text-green-700 flex items-center justify-center mb-3 shadow-md">
                        <span class="material-symbols-outlined text-[40px]">check_circle</span>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-green-500/40 text-white font-label-sm font-bold tracking-wider uppercase mb-1">
                        Dokumen Sah & Terverifikasi
                    </span>
                    <h2 class="font-headline-lg font-bold">Surat Asli & Masih Berlaku</h2>
                    <p class="font-body-sm text-green-100 mt-1">Diterbitkan secara resmi oleh Dinas Sosial Kabupaten Blitar</p>
                </div>

                <div class="p-6 sm:p-8 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <span class="text-on-surface-variant block text-xs mb-1">Nomor Surat Resmi:</span>
                            <span class="font-mono font-bold text-on-surface text-base">{{ $certificate->certificate_number ?? '-' }}</span>
                        </div>
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <span class="text-on-surface-variant block text-xs mb-1">Tujuan Penggunaan:</span>
                            <span class="font-bold text-primary text-base">{{ $certificate->purpose?->name ?? 'SPMB / Afirmasi' }}</span>
                        </div>
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <span class="text-on-surface-variant block text-xs mb-1">Nama Orang yang Diterangkan:</span>
                            <span class="font-bold text-on-surface text-base">{{ Str::mask($certificate->subject_name, '*', 3) }}</span>
                        </div>
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <span class="text-on-surface-variant block text-xs mb-1">NIK yang Diterangkan:</span>
                            <span class="font-mono font-bold text-on-surface text-base">{{ Str::mask($certificate->subject_nik, '*', 6, 6) }}</span>
                        </div>
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <span class="text-on-surface-variant block text-xs mb-1">Status DTKS / Desil:</span>
                            <span class="font-bold text-on-surface text-base">Terdaftar (Desil {{ $certificate->decile ?? 1 }})</span>
                        </div>
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <span class="text-on-surface-variant block text-xs mb-1">Tanggal Terbit:</span>
                            <span class="font-bold text-on-surface text-base">{{ $certificate->issued_at ? $certificate->issued_at->format('d M Y') : '-' }}</span>
                        </div>
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <span class="text-on-surface-variant block text-xs mb-1">Masa Berlaku Sampai:</span>
                            <span class="font-bold text-green-700 text-base">{{ $certificate->valid_until ? $certificate->valid_until->format('d M Y') : 'Berlaku Selama 1 Tahun Ajaran' }}</span>
                        </div>
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <span class="text-on-surface-variant block text-xs mb-1">Pejabat Penandatangan:</span>
                            <span class="font-bold text-on-surface text-base">{{ $certificate->signer?->name ?? 'Kepala Dinas Sosial Kabupaten Blitar' }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-surface-container flex items-center justify-between text-xs text-on-surface-variant">
                        <span>Kode Verifikasi: <strong class="font-mono">{{ $certificate->verification_code }}</strong></span>
                        <span class="text-green-700 font-semibold flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">verified</span> Data Valid
                        </span>
                    </div>
                </div>
            </div>

        @elseif($checkStatus === 'expired' && $certificate)
            <!-- STATE 2: KEDALUWARSA (AMBER) -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-xl border-2 border-amber-400 overflow-hidden">
                <div class="bg-amber-500 text-white p-6 sm:p-8 text-center flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full bg-white text-amber-600 flex items-center justify-center mb-3 shadow-md">
                        <span class="material-symbols-outlined text-[40px]">history_toggle_off</span>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-amber-400/40 text-white font-label-sm font-bold tracking-wider uppercase mb-1">
                        Peringatan Kedaluwarsa
                    </span>
                    <h2 class="font-headline-lg font-bold">Surat Sudah Tidak Berlaku</h2>
                    <p class="font-body-sm text-amber-100 mt-1">Masa berlaku surat ini telah berakhir pada tanggal {{ $certificate->valid_until->format('d M Y') }}</p>
                </div>

                <div class="p-6 sm:p-8 space-y-4">
                    <p class="font-body-md text-on-surface leading-relaxed">
                        Surat keterangan dengan nomor <strong>{{ $certificate->certificate_number }}</strong> tercatat sah pernah diterbitkan untuk <strong>{{ Str::mask($certificate->subject_name, '*', 3) }}</strong>, namun sudah melewati batas waktu berlakunya. Silakan ajukan permohonan baru bila masih diperlukan.
                    </p>
                    <a href="{{ route('layanan.dtsen') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-primary text-on-primary font-label-md font-bold hover:bg-primary-container transition-all">
                        <span>Ajukan Surat DTSEN Baru</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </div>

        @elseif($checkStatus === 'not_found')
            <!-- STATE 3: TIDAK DITEMUKAN (RED) -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-xl border-2 border-red-500 overflow-hidden">
                <div class="bg-red-600 text-white p-6 sm:p-8 text-center flex flex-col items-center">
                    <div class="w-16 h-16 rounded-full bg-white text-red-600 flex items-center justify-center mb-3 shadow-md">
                        <span class="material-symbols-outlined text-[40px]">gpp_bad</span>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-red-500/40 text-white font-label-sm font-bold tracking-wider uppercase mb-1">
                        Tidak Ditemukan
                    </span>
                    <h2 class="font-headline-lg font-bold">Kode Verifikasi Tidak Terdaftar</h2>
                    <p class="font-body-sm text-red-100 mt-1">Dokumen dengan kode tersebut tidak ditemukan dalam pangkalan data resmi</p>
                </div>

                <div class="p-6 sm:p-8 space-y-4">
                    <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-900 font-body-sm space-y-2">
                        <p class="font-semibold">Kemungkinan penyebab:</p>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            <li>Terjadi kesalahan pengetikan karakter kode verifikasi.</li>
                            <li>Surat belum ditandatangani secara definitif oleh pejabat yang berwenang.</li>
                            <li>Dokumen bukan diterbitkan oleh Dinas Sosial Kabupaten Blitar (waspada pemalsuan dokumen).</li>
                        </ul>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="https://wa.me/6281234567890" target="_blank"
                           class="flex-1 py-3 px-6 rounded-xl bg-surface-container text-on-surface font-label-md font-semibold hover:bg-surface-container-high transition-colors text-center">
                            Konfirmasi ke Petugas Dinas
                        </a>
                        <button type="button" @click="$wire.set('code', '')"
                                class="py-3 px-6 rounded-xl bg-primary text-on-primary font-label-md font-bold hover:bg-primary-container transition-colors">
                            Coba Kode Lain
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
