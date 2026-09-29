<div class="flex flex-col w-full py-8 lg:py-12 bg-background min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 w-full">

        <!-- Top Greeting Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/10 text-primary font-label-sm text-label-sm font-semibold mb-2">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    Portal Akun Warga Terdaftar
                </span>
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                    Riwayat Pengajuan Saya
                </h1>
                <p class="font-body-md text-on-surface-variant mt-1">
                    Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>. Pantau seluruh permohonan layanan dan pengaduan Anda di sini.
                </p>
            </div>
            <a href="{{ route('layanan.index') }}"
               class="self-start md:self-auto py-3 px-6 rounded-xl bg-primary text-on-primary font-label-md font-bold shadow-md hover:bg-primary-container transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Buat Pengajuan Baru</span>
            </a>
        </div>

        <!-- Metric Summary Tiles -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="p-5 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[26px]">folder_open</span>
                </div>
                <div>
                    <span class="font-label-sm text-xs text-on-surface-variant block">Total Berkas</span>
                    <span class="font-headline-lg font-bold text-on-surface">{{ $totalCount }}</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[26px]">sync</span>
                </div>
                <div>
                    <span class="font-label-sm text-xs text-on-surface-variant block">Dalam Proses</span>
                    <span class="font-headline-lg font-bold text-teal-800">{{ $inProcessCount }}</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 text-green-800 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[26px]">check_circle</span>
                </div>
                <div>
                    <span class="font-label-sm text-xs text-on-surface-variant block">Selesai / Terbit</span>
                    <span class="font-headline-lg font-bold text-green-800">{{ $completedCount }}</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-surface-container-lowest border border-surface-container shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[26px]">warning</span>
                </div>
                <div>
                    <span class="font-label-sm text-xs text-on-surface-variant block">Perlu Perbaikan</span>
                    <span class="font-headline-lg font-bold text-amber-800">{{ $revisionCount }}</span>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center gap-2 border-b border-surface-container pb-4 mb-6">
            <button wire:click="setFilter('semua')"
                    class="px-5 py-2.5 rounded-xl font-label-md transition-all cursor-pointer {{ $filter === 'semua' ? 'bg-primary text-on-primary font-bold shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                Semua Berkas ({{ $totalCount }})
            </button>
            <button wire:click="setFilter('layanan')"
                    class="px-5 py-2.5 rounded-xl font-label-md transition-all cursor-pointer {{ $filter === 'layanan' ? 'bg-primary text-on-primary font-bold shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                Layanan Sosial ({{ $serviceRequests->count() }})
            </button>
            <button wire:click="setFilter('pengaduan')"
                    class="px-5 py-2.5 rounded-xl font-label-md transition-all cursor-pointer {{ $filter === 'pengaduan' ? 'bg-primary text-on-primary font-bold shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container hover:text-on-surface' }}">
                Pengaduan Warga ({{ $complaints->count() }})
            </button>
        </div>

        <!-- TICKET LIST CARDS -->
        <div class="space-y-4">
            @php
                $showServiceRequests = in_array($filter, ['semua', 'layanan']);
                $showComplaints = in_array($filter, ['semua', 'pengaduan']);
            @endphp

            @if($showServiceRequests)
                @foreach($serviceRequests as $sr)
                    @php
                        $statusVal = $sr->status->value;
                        $badgeBg = match($statusVal) {
                            'submitted' => 'bg-blue-100 text-blue-800',
                            'document_check', 'revision_requested' => 'bg-amber-100 text-amber-800',
                            'data_verification', 'eligibility_verification', 'verification' => 'bg-purple-100 text-purple-800',
                            'awaiting_approval', 'proposed_to_ministry', 'in_process' => 'bg-teal-100 text-teal-800',
                            'issued', 'completed', 'reactivated' => 'bg-green-100 text-green-800',
                            'rejected', 'ministry_rejected' => 'bg-red-100 text-red-800',
                            default => 'bg-surface-container text-on-surface-variant',
                        };
                    @endphp
                    <div class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                @if($sr->serviceType?->code === 'DTSEN')
                                    <span class="material-symbols-outlined text-[26px]">assignment_turned_in</span>
                                @elseif($sr->serviceType?->code === 'PBI')
                                    <span class="material-symbols-outlined text-[26px]">health_and_safety</span>
                                @else
                                    <span class="material-symbols-outlined text-[26px]">folder</span>
                                @endif
                            </div>
                            <div>
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="font-mono font-bold text-on-surface text-base">{{ $sr->request_number }}</span>
                                    <span class="px-2.5 py-0.5 rounded-full font-label-sm text-xs font-bold {{ $badgeBg }}">
                                        {{ $sr->status->label() }}
                                    </span>
                                    @if($sr->is_priority)
                                        <span class="px-2 py-0.5 rounded-full bg-secondary-container/20 text-secondary text-xs font-bold">
                                            Prioritas
                                        </span>
                                    @endif
                                </div>
                                <h3 class="font-title-md text-on-surface font-semibold">{{ $sr->serviceType?->name ?? 'Pengajuan Layanan' }}</h3>
                                <p class="text-xs text-on-surface-variant mt-1">
                                    Diajukan pada: {{ $sr->submitted_at ? $sr->submitted_at->format('d M Y, H:i') : '-' }} WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 self-end sm:self-center">
                            @if($statusVal === 'revision_requested')
                                <a href="{{ route('cek-status', ['ticket' => $sr->request_number]) }}"
                                   class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-label-md text-sm font-bold transition-colors flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">upload</span>
                                    <span>Unggah Perbaikan</span>
                                </a>
                            @elseif($sr->dtsenCertificate && $sr->dtsenCertificate->verification_code)
                                <a href="{{ route('verifikasi', ['code' => $sr->dtsenCertificate->verification_code]) }}"
                                   class="px-4 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-white font-label-md text-sm font-bold transition-colors flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">download</span>
                                    <span>Bukti Sah</span>
                                </a>
                            @endif

                            <a href="{{ route('cek-status', ['ticket' => $sr->request_number]) }}"
                               class="px-4 py-2 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md text-sm font-semibold transition-colors flex items-center gap-1">
                                <span>Lihat Detail</span>
                                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

            @if($showComplaints)
                @foreach($complaints as $cmp)
                    <div class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-error-container/40 text-error flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[26px]">campaign</span>
                            </div>
                            <div>
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <span class="font-mono font-bold text-on-surface text-base">{{ $cmp->complaint_number }}</span>
                                    <span class="px-2.5 py-0.5 rounded-full font-label-sm text-xs font-bold bg-primary/10 text-primary">
                                        {{ $cmp->status->label() }}
                                    </span>
                                </div>
                                <h3 class="font-title-md text-on-surface font-semibold">Pengaduan: {{ $cmp->category?->name ?? 'Sosial' }}</h3>
                                <p class="text-xs text-on-surface-variant mt-1">
                                    Dilaporkan: {{ $cmp->reported_at ? $cmp->reported_at->format('d M Y, H:i') : '-' }} WIB
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 self-end sm:self-center">
                            <a href="{{ route('cek-status', ['ticket' => $cmp->complaint_number]) }}"
                               class="px-4 py-2 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface font-label-md text-sm font-semibold transition-colors flex items-center gap-1">
                                <span>Pantau Laporan</span>
                                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif

            @if($totalCount === 0)
                <div class="py-16 text-center bg-surface-container-lowest rounded-2xl border border-surface-container">
                    <span class="material-symbols-outlined text-[48px] text-outline">folder_off</span>
                    <h3 class="mt-2 font-headline-sm text-on-surface">Belum Ada Pengajuan</h3>
                    <p class="mt-1 font-body-md text-on-surface-variant">Anda belum pernah mengajukan layanan atau pengaduan sosial.</p>
                    <a href="{{ route('layanan.index') }}" class="mt-4 inline-block px-6 py-2.5 rounded-xl bg-primary text-on-primary font-label-md font-bold">
                        Mulai Pengajuan Sekarang
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
