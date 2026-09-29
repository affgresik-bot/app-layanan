<div class="flex flex-col w-full py-8 lg:py-12 bg-background min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 w-full">

        <!-- Breadcrumb & Top Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md">
                <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('home') }}">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    <span>Beranda</span>
                </a>
                <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                <span class="text-primary font-semibold">Cek Status Tiket</span>
            </nav>
            <div class="flex items-center gap-2 bg-surface-container px-3 py-1.5 rounded-full text-on-surface-variant font-label-sm text-label-sm self-start">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                <span>Pusat Pelacakan Berkas Terintegrasi DTKS & SIKS-NG</span>
            </div>
        </div>

        <!-- SEARCH INPUT CARD -->
        <section class="bg-surface-container-lowest rounded-2xl shadow-md border border-surface-container p-6 sm:p-8 mb-8">
            <div class="max-w-3xl mb-6">
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                    Pantau Status Permohonan & Laporan Anda
                </h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                    Masukkan nomor tiket resmi beserta 4 digit terakhir NIK / No. HP untuk menjaga privasi identitas pemohon.
                </p>
            </div>

            <form wire:submit="checkTicket" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-6">
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="ticketInput">
                        Nomor Tiket Permohonan <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px]">tag</span>
                        <input wire:model="ticketInput"
                               id="ticketInput"
                               type="text"
                               required
                               placeholder="Contoh: DTSEN-202610-00012 atau PBI-202610-00007"
                               class="w-full h-12 pl-11 pr-4 bg-surface-container-low text-on-surface rounded-xl font-body-md text-body-md uppercase font-semibold tracking-wider focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"/>
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label class="block font-label-md text-label-md text-on-surface mb-2" for="identityKey">
                        4 Digit Terakhir NIK / No. HP <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px]">lock_person</span>
                        <input wire:model="identityKey"
                               id="identityKey"
                               type="text"
                               maxlength="4"
                               placeholder="4 digit terakhir"
                               class="w-full h-12 pl-11 pr-4 bg-surface-container-low text-on-surface rounded-xl font-mono text-center font-bold tracking-widest focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"/>
                    </div>
                </div>

                <div class="md:col-span-3">
                    <button type="submit"
                            class="w-full h-12 px-6 bg-primary hover:bg-primary-container text-on-primary font-label-md text-label-md font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                        <span>Cek Status</span>
                    </button>
                </div>
            </form>

            @if($errorMessage)
                <div class="mt-4 p-4 rounded-xl bg-error-container text-on-error-container font-body-sm text-body-sm flex items-center gap-3">
                    <span class="material-symbols-outlined text-error text-[20px] shrink-0">error</span>
                    <span>{{ $errorMessage }}</span>
                </div>
            @endif

            <div class="mt-4 pt-3 flex flex-wrap items-center gap-4 text-xs text-on-surface-variant border-t border-surface-container">
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-primary">verified_user</span> Privasi data terlindungi</span>
                <span>•</span>
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-secondary">speed</span> Validasi Terpadu</span>
                <span>•</span>
                <a href="https://wa.me/6281234567890" target="_blank" class="text-primary hover:underline">Lupa Nomor Tiket?</a>
            </div>
        </section>

        <!-- TRACKING RESULT AREA -->
        @if($serviceRequest)
            @php
                $statusVal = $serviceRequest->status->value;
                $statusLabel = $serviceRequest->status->label();
                $maskedName = Str::mask($serviceRequest->applicant_name, '*', 3);
                $maskedNik = Str::mask($serviceRequest->applicant_nik, '*', 6, 6);
                
                // Color mapping
                $badgeBg = match($statusVal) {
                    'submitted' => 'bg-blue-100 text-blue-800 border-blue-200',
                    'document_check', 'revision_requested' => 'bg-amber-100 text-amber-800 border-amber-200',
                    'data_verification', 'eligibility_verification', 'verification' => 'bg-purple-100 text-purple-800 border-purple-200',
                    'awaiting_approval', 'proposed_to_ministry', 'in_process' => 'bg-teal-100 text-teal-800 border-teal-200',
                    'issued', 'completed', 'reactivated' => 'bg-green-100 text-green-800 border-green-200',
                    'rejected', 'ministry_rejected' => 'bg-red-100 text-red-800 border-red-200',
                    default => 'bg-surface-container text-on-surface-variant',
                };
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left: Ticket Summary & Stepper -->
                <div class="lg:col-span-8 flex flex-col gap-6">
                    
                    <!-- REVISION ALERT (if requested) -->
                    @if($statusVal === 'revision_requested')
                        <div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-6 shadow-sm flex flex-col gap-4">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-amber-600 text-[28px] shrink-0 mt-0.5">warning</span>
                                <div>
                                    <h3 class="font-title-md text-amber-900 font-bold">Permohonan Memerlukan Perbaikan Berkas</h3>
                                    <p class="font-body-md text-amber-800 mt-1">
                                        Catatan Petugas: <strong>{{ $serviceRequest->officer_notes ?: 'Mohon periksa kembali kelengkapan atau kejelasan berkas dokumen yang diunggah.' }}</strong>
                                    </p>
                                </div>
                            </div>

                            <form wire:submit="uploadRevision" class="pt-3 border-t border-amber-200 flex flex-col gap-3">
                                <div>
                                    <label class="block font-label-md text-amber-900 mb-1">Unggah Berkas Perbaikan (PDF/JPG/PNG maks 5MB):</label>
                                    <input wire:model="revision_file" type="file" class="w-full text-sm bg-white p-2 rounded-xl border border-amber-300"/>
                                    @error('revision_file') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>
                                <input wire:model="revision_notes" type="text" placeholder="Catatan perbaikan (opsional)" class="w-full h-10 px-3 text-sm bg-white rounded-xl border border-amber-300"/>
                                <button type="submit" class="self-start py-2.5 px-6 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-label-md font-bold shadow-sm transition-all cursor-pointer">
                                    Kirim Perbaikan Berkas
                                </button>
                            </form>

                            @if($revisionSuccess)
                                <p class="text-xs text-green-700 font-bold">✓ Berkas perbaikan berhasil dikirim dan status dikembalikan ke antrean verifikasi.</p>
                            @endif
                        </div>
                    @endif

                    <!-- Summary Card -->
                    <article class="bg-surface-container-lowest rounded-2xl shadow-md border border-surface-container p-6 sm:p-8">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-surface-container">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1.5 bg-surface-container text-on-surface font-mono font-bold text-label-md rounded-xl">
                                    {{ $serviceRequest->request_number }}
                                </span>
                                <span class="px-3 py-1 rounded-full font-label-sm text-label-sm font-bold border {{ $badgeBg }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            @if($serviceRequest->is_priority)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-secondary-container/20 text-secondary font-label-sm text-label-sm font-bold self-start sm:self-auto">
                                    <span class="material-symbols-outlined text-[16px]">emergency</span>
                                    <span>Prioritas Darurat Medis</span>
                                </span>
                            @endif
                        </div>

                        <!-- Metadata Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-6">
                            <div class="p-4 bg-surface-container-low rounded-xl">
                                <span class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Pemohon</span>
                                <span class="font-title-md text-title-md text-on-surface font-semibold flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-primary text-[20px]">person</span>
                                    {{ $maskedName }}
                                </span>
                                <span class="font-body-sm text-xs text-on-surface-variant">Desa {{ $serviceRequest->village?->name ?? '-' }}</span>
                            </div>

                            <div class="p-4 bg-surface-container-low rounded-xl">
                                <span class="block font-label-sm text-label-sm text-on-surface-variant mb-1">NIK Pemohon</span>
                                <span class="font-title-md text-title-md text-on-surface font-semibold font-mono flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-primary text-[20px]">badge</span>
                                    {{ $maskedNik }}
                                </span>
                                <span class="font-body-sm text-xs text-on-surface-variant">Terverifikasi Dukcapil</span>
                            </div>

                            <div class="p-4 bg-surface-container-low rounded-xl">
                                <span class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Jenis Layanan</span>
                                <span class="font-title-md text-title-md text-primary font-semibold flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-primary text-[20px]">assignment</span>
                                    {{ $serviceRequest->serviceType?->name ?? 'Layanan Sosial' }}
                                </span>
                                <span class="font-body-sm text-xs text-on-surface-variant">Dinas Sosial Blitar</span>
                            </div>

                            <div class="p-4 bg-surface-container-low rounded-xl">
                                <span class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Waktu Diajukan</span>
                                <span class="font-title-md text-title-md text-on-surface font-semibold flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-primary text-[20px]">calendar_today</span>
                                    {{ $serviceRequest->submitted_at ? $serviceRequest->submitted_at->format('d M Y') : '-' }}
                                </span>
                                <span class="font-body-sm text-xs text-on-surface-variant">{{ $serviceRequest->submitted_at ? $serviceRequest->submitted_at->format('H:i') : '' }} WIB</span>
                            </div>

                            <div class="p-4 bg-surface-container-low rounded-xl">
                                <span class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Unit Pengelola</span>
                                <span class="font-title-md text-title-md text-on-surface font-semibold flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-primary text-[20px]">account_balance</span>
                                    Bid. Lindjamsos
                                </span>
                                <span class="font-body-sm text-xs text-on-surface-variant">Kabupaten Blitar</span>
                            </div>

                            <div class="p-4 bg-surface-container-low rounded-xl">
                                <span class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Estimasi Selesai</span>
                                <span class="font-title-md text-title-md text-secondary font-bold flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-secondary text-[20px]">timelapse</span>
                                    {{ $serviceRequest->is_priority ? '24 Jam' : '1-2 Hari Kerja' }}
                                </span>
                                <span class="font-body-sm text-xs text-on-surface-variant">Standar Pelayanan</span>
                            </div>
                        </div>

                        <!-- Certificate Action if Issued -->
                        @if($serviceRequest->dtsenCertificate && $serviceRequest->dtsenCertificate->certificate_number)
                            <div class="mt-6 p-5 rounded-2xl bg-green-50 border border-green-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-green-600 text-white flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[28px]">verified</span>
                                    </div>
                                    <div>
                                        <h4 class="font-title-md font-bold text-green-950">Surat Keterangan DTSEN Telah Diterbitkan</h4>
                                        <p class="font-body-sm text-green-800 text-xs">Nomor Surat: {{ $serviceRequest->dtsenCertificate->certificate_number }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('verifikasi', ['code' => $serviceRequest->dtsenCertificate->verification_code]) }}"
                                   class="px-5 py-2.5 rounded-xl bg-green-700 hover:bg-green-800 text-white font-label-md font-bold transition-colors shrink-0 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[18px]">qr_code</span>
                                    <span>Lihat Bukti Sah</span>
                                </a>
                            </div>
                        @endif
                    </article>

                    <!-- TIMELINE STEPPER -->
                    <div class="bg-surface-container-lowest rounded-2xl shadow-md border border-surface-container p-6 sm:p-8">
                        <h3 class="font-headline-sm text-headline-sm text-on-surface mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[24px]">linear_scale</span>
                            <span>Riwayat & Progres Tahapan Berkas</span>
                        </h3>

                        @php
                            $stages = [
                                'submitted' => 'Berkas Diajukan Pemohon',
                                'document_check' => 'Pemeriksaan Kelengkapan Berkas',
                                'verification' => 'Verifikasi Data / Kelayakan DTKS',
                                'awaiting_approval' => 'Penelaahan & Persetujuan Pejabat',
                                'issued' => 'Surat Resmi Diterbitkan / Diusulkan',
                                'completed' => 'Layanan Selesai & Ditutup',
                            ];
                        @endphp

                        <div class="relative pl-6 sm:pl-8 border-l-2 border-primary/30 space-y-8 ml-3">
                            @foreach($stages as $stageKey => $stageTitle)
                                @php
                                    // simple heuristic for progress
                                    $isPassed = match($statusVal) {
                                        'submitted' => ($stageKey === 'submitted'),
                                        'document_check', 'revision_requested' => in_array($stageKey, ['submitted', 'document_check']),
                                        'data_verification', 'eligibility_verification', 'verification' => in_array($stageKey, ['submitted', 'document_check', 'verification']),
                                        'awaiting_approval' => in_array($stageKey, ['submitted', 'document_check', 'verification', 'awaiting_approval']),
                                        'issued', 'proposed_to_ministry', 'recommendation_issued' => in_array($stageKey, ['submitted', 'document_check', 'verification', 'awaiting_approval', 'issued']),
                                        'completed', 'reactivated' => true,
                                        default => ($stageKey === 'submitted'),
                                    };
                                @endphp

                                <div class="relative">
                                    <div class="absolute -left-[35px] sm:-left-[43px] top-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs {{ $isPassed ? 'bg-primary text-on-primary ring-4 ring-primary/20' : 'bg-surface-container text-on-surface-variant' }}">
                                        @if($isPassed)
                                            <span class="material-symbols-outlined text-[16px]">check</span>
                                        @else
                                            <span class="w-2 h-2 rounded-full bg-outline"></span>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-title-md text-title-md font-semibold {{ $isPassed ? 'text-on-surface' : 'text-on-surface-variant' }}">
                                            {{ $stageTitle }}
                                        </h4>
                                        <p class="font-body-sm text-xs text-on-surface-variant mt-0.5">
                                            @if($isPassed)
                                                Terproses dalam sistem
                                            @else
                                                Menunggu tahapan sebelumnya selesai
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sidebar Info -->
                <div class="lg:col-span-4 flex flex-col gap-6 sticky top-28">
                    <div class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container shadow-sm">
                        <h4 class="font-title-md font-bold text-on-surface mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[20px]">help_center</span>
                            <span>Bantuan Pelayanan</span>
                        </h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                            Jika terdapat kendala pada permohonan Anda atau membutuhkan bantuan darurat, silakan hubungi kontak resmi Dinas Sosial:
                        </p>
                        <div class="mt-4 pt-4 border-t border-surface-container space-y-2 text-sm text-on-surface">
                            <p><strong>Hotline WA:</strong> 0812-3456-7890</p>
                            <p><strong>Telepon:</strong> (0342) 801234</p>
                            <p><strong>Jam Kerja:</strong> 07.30 - 15.30 WIB</p>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($complaint)
            <!-- COMPLAINT RESULT DISPLAY -->
            @php
                $maskedPhone = Str::mask($complaint->reporter_phone, '*', 4, 4);
            @endphp
            <div class="bg-surface-container-lowest rounded-2xl shadow-md border border-surface-container p-6 sm:p-8">
                <div class="flex items-center justify-between pb-6 border-b border-surface-container mb-6">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-error-container text-on-error-container font-label-sm font-bold">
                            Laporan Pengaduan Sosial
                        </span>
                        <h2 class="font-headline-lg font-bold text-on-surface mt-2">{{ $complaint->complaint_number }}</h2>
                    </div>
                    <span class="px-3.5 py-1.5 rounded-full font-label-md font-bold bg-primary/10 text-primary">
                        {{ $complaint->status->label() }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-6">
                    <div>
                        <span class="text-on-surface-variant block">Kategori Masalah:</span>
                        <span class="font-bold text-on-surface">{{ $complaint->category?->name ?? 'Pengaduan Sosial' }}</span>
                    </div>
                    <div>
                        <span class="text-on-surface-variant block">Lokasi Kejadian:</span>
                        <span class="font-bold text-on-surface">Desa {{ $complaint->village?->name ?? '-' }}, Kec. {{ $complaint->village?->district?->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-on-surface-variant block">Waktu Lapor:</span>
                        <span class="font-bold text-on-surface">{{ $complaint->reported_at ? $complaint->reported_at->format('d M Y H:i') : '-' }} WIB</span>
                    </div>
                    <div>
                        <span class="text-on-surface-variant block">Pelapor:</span>
                        <span class="font-bold text-on-surface">{{ Str::mask($complaint->reporter_name, '*', 3) }} ({{ $maskedPhone }})</span>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-surface-container-low mb-6">
                    <span class="text-on-surface-variant font-semibold block mb-1">Uraian Pengaduan:</span>
                    <p class="font-body-md text-on-surface">{{ $complaint->description }}</p>
                </div>

                @if($complaint->action_taken)
                    <div class="p-4 rounded-xl bg-green-50 border border-green-200">
                        <span class="text-green-900 font-bold block mb-1">Tindakan / Hasil Penanganan Petugas:</span>
                        <p class="font-body-md text-green-950">{{ $complaint->action_taken }}</p>
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>
