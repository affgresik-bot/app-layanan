<div class="flex flex-col w-full py-8 lg:py-12 bg-background min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 w-full">

        @if($submittedTicket)
            <!-- SUCCESS SCREEN -->
            <div class="max-w-2xl mx-auto bg-surface-container-lowest rounded-2xl p-8 sm:p-10 shadow-xl border border-surface-container text-center flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-secondary-container/20 text-secondary flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-[48px]">check_circle</span>
                </div>
                <span class="px-3.5 py-1 rounded-full bg-secondary-container/20 text-secondary font-label-sm text-label-sm font-semibold mb-3">
                    Pengajuan Berhasil Dikirim
                </span>
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                    Pengajuan Reaktivasi KIS / PBI-JK Diterima
                </h1>
                <p class="mt-2 font-body-md text-body-md text-on-surface-variant max-w-md">
                    Permohonan reaktivasi kepesertaan BPJS PBI Anda telah tercatat dan langsung masuk ke antrean verifikasi Bidang Perlindungan & Jaminan Sosial.
                </p>

                <!-- Ticket Card -->
                <div class="w-full my-8 p-6 rounded-2xl bg-surface-container-low border border-surface-container flex flex-col items-center gap-3">
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nomor Tiket Anda</span>
                    <div class="flex items-center gap-3" x-data="{ copied: false }">
                        <span class="font-headline-lg text-headline-lg font-mono font-bold text-secondary tracking-wider">
                            {{ $submittedTicket }}
                        </span>
                        <button type="button"
                                @click="navigator.clipboard.writeText('{{ $submittedTicket }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="p-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors cursor-pointer"
                                title="Salin Nomor Tiket">
                            <span class="material-symbols-outlined text-[20px]" x-show="!copied">content_copy</span>
                            <span class="material-symbols-outlined text-[20px] text-secondary" x-show="copied" x-cloak>done</span>
                        </button>
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Simpan nomor tiket ini untuk memantau proses verifikasi rekomendasi dan persetujuan Kemensos.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full">
                    <a href="{{ route('cek-status', ['ticket' => $submittedTicket]) }}"
                       class="flex-1 py-3.5 px-6 rounded-xl bg-secondary-container text-on-secondary-container font-label-lg text-label-lg font-bold shadow-md hover:brightness-105 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">manage_search</span>
                        <span>Pantau Status Tiket</span>
                    </a>
                    <a href="{{ route('home') }}"
                       class="py-3.5 px-6 rounded-xl bg-surface-container text-on-surface font-label-lg text-label-lg font-semibold hover:bg-surface-container-high transition-colors">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        @else
            <!-- PROGRESS STEPPER -->
            <div class="mb-8">
                <!-- Breadcrumbs -->
                <nav aria-label="Breadcrumb" class="mb-4 flex items-center gap-2 text-on-surface-variant font-label-md text-label-md">
                    <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('home') }}">
                        <span class="material-symbols-outlined text-[18px]">home</span>
                        <span>Beranda</span>
                    </a>
                    <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                    <a class="hover:text-primary transition-colors" href="{{ route('layanan.index') }}">Ajukan Layanan</a>
                    <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
                    <span class="text-primary font-semibold">Reaktivasi KIS PBI</span>
                </nav>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <!-- Step 1 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl border transition-all {{ $currentStep >= 1 ? ($currentStep === 1 ? 'bg-secondary-container text-on-secondary-container shadow-sm border-secondary-container' : 'bg-surface-container-lowest text-secondary border-secondary-container') : 'bg-surface-container-low text-on-surface-variant border-surface-container' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold font-title-md shrink-0 {{ $currentStep === 1 ? 'bg-surface-container-lowest text-secondary' : ($currentStep > 1 ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-high text-on-surface-variant') }}">
                            @if($currentStep > 1) <span class="material-symbols-outlined text-[18px]">check</span> @else 1 @endif
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[11px] uppercase tracking-wider font-semibold opacity-80">Tahap 1</span>
                            <span class="font-title-md text-sm truncate font-semibold">Data Peserta</span>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl border transition-all {{ $currentStep >= 2 ? ($currentStep === 2 ? 'bg-secondary-container text-on-secondary-container shadow-sm border-secondary-container' : 'bg-surface-container-lowest text-secondary border-secondary-container') : 'bg-surface-container-low text-on-surface-variant border-surface-container' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold font-title-md shrink-0 {{ $currentStep === 2 ? 'bg-surface-container-lowest text-secondary' : ($currentStep > 2 ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-high text-on-surface-variant') }}">
                            @if($currentStep > 2) <span class="material-symbols-outlined text-[18px]">check</span> @else 2 @endif
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[11px] uppercase tracking-wider font-semibold opacity-80">Tahap 2</span>
                            <span class="font-title-md text-sm truncate font-semibold">Alasan Reaktivasi</span>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl border transition-all {{ $currentStep >= 3 ? ($currentStep === 3 ? 'bg-secondary-container text-on-secondary-container shadow-sm border-secondary-container' : 'bg-surface-container-lowest text-secondary border-secondary-container') : 'bg-surface-container-low text-on-surface-variant border-surface-container' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold font-title-md shrink-0 {{ $currentStep === 3 ? 'bg-surface-container-lowest text-secondary' : ($currentStep > 3 ? 'bg-secondary-container text-on-secondary-container' : 'bg-surface-container-high text-on-surface-variant') }}">
                            @if($currentStep > 3) <span class="material-symbols-outlined text-[18px]">check</span> @else 3 @endif
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[11px] uppercase tracking-wider font-semibold opacity-80">Tahap 3</span>
                            <span class="font-title-md text-sm truncate font-semibold">Unggah Dokumen</span>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl border transition-all {{ $currentStep === 4 ? 'bg-secondary-container text-on-secondary-container shadow-sm border-secondary-container' : 'bg-surface-container-low text-on-surface-variant border-surface-container' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold font-title-md shrink-0 {{ $currentStep === 4 ? 'bg-surface-container-lowest text-secondary' : 'bg-surface-container-high text-on-surface-variant' }}">
                            4
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[11px] uppercase tracking-wider font-semibold opacity-80">Tahap 4</span>
                            <span class="font-title-md text-sm truncate font-semibold">Tinjau & Kirim</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Form -->
                <div class="lg:col-span-8 flex flex-col gap-6">

                    <!-- STEP 1: DATA PESERTA -->
                    @if($currentStep === 1)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm flex flex-col gap-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                                <span class="w-10 h-10 rounded-xl bg-secondary-container/20 text-secondary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">badge</span>
                                </span>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">1. Data Peserta BPJS PBI</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Lengkapi data kepesertaan JKN-KIS yang nonaktif</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-full">
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Nama Lengkap Peserta (Sesuai KTP) <span class="text-error">*</span>
                                    </label>
                                    <input wire:model="participant_name" type="text"
                                           class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary outline-none transition-all"
                                           placeholder="Nama lengkap peserta yang akan direaktivasi"/>
                                    @error('participant_name') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        NIK Peserta (16 Digit) <span class="text-error">*</span>
                                    </label>
                                    <input wire:model="participant_nik" type="text" maxlength="16"
                                           class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md font-mono focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary outline-none transition-all"
                                           placeholder="3505xxxxxxxxxxxx"/>
                                    @error('participant_nik') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Nomor Kartu BPJS / KIS <span class="text-error">*</span>
                                    </label>
                                    <input wire:model="bpjs_card_number" type="text"
                                           class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md font-mono focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary outline-none transition-all"
                                           placeholder="0001xxxxxxxxxxxx"/>
                                    @error('bpjs_card_number') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Perkiraan Tanggal Nonaktif <span class="text-error">*</span>
                                    </label>
                                    <input wire:model="deactivated_date" type="date"
                                           class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary outline-none transition-all"/>
                                    @error('deactivated_date') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Nomor WhatsApp / HP Pemohon <span class="text-error">*</span>
                                    </label>
                                    <input wire:model="phone" type="tel"
                                           class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary outline-none transition-all"
                                           placeholder="Contoh: 081234567890"/>
                                    @error('phone') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Kecamatan Domisili <span class="text-error">*</span>
                                    </label>
                                    <select wire:model.live="district_id"
                                            class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary outline-none transition-all">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach($districts as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Desa / Kelurahan <span class="text-error">*</span>
                                    </label>
                                    <select wire:model="village_id"
                                            class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary outline-none transition-all"
                                            {{ !$district_id ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Desa / Kelurahan --</option>
                                        @foreach($villages as $v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('village_id') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-span-full">
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Alamat Lengkap Domisili <span class="text-error">*</span>
                                    </label>
                                    <textarea wire:model="address" rows="2"
                                              class="w-full p-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-secondary outline-none transition-all"
                                              placeholder="Contoh: Dusun Sumber RT 01 RW 04"></textarea>
                                    @error('address') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 2: ALASAN REAKTIVASI -->
                    @if($currentStep === 2)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm flex flex-col gap-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                                <span class="w-10 h-10 rounded-xl bg-secondary-container/20 text-secondary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">medical_services</span>
                                </span>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">2. Alasan Reaktivasi KIS / PBI</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Pilih kondisi medis / situasi yang mendasari reaktivasi</p>
                                </div>
                            </div>

                            <!-- Radio cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="border-2 rounded-2xl p-5 flex items-start gap-4 cursor-pointer transition-all {{ $reason === 'emergency' ? 'border-secondary bg-secondary-container/10 ring-1 ring-secondary' : 'border-surface-container hover:bg-surface-container-low' }}">
                                    <input wire:model.live="reason" type="radio" value="emergency" class="mt-1 w-5 h-5 accent-secondary"/>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-title-md text-title-md text-on-surface font-bold">Kondisi Darurat Medis</span>
                                            <span class="px-2 py-0.5 rounded-full bg-secondary text-on-secondary font-label-sm text-[11px] font-bold">Prioritas</span>
                                        </div>
                                        <p class="mt-1 font-body-sm text-body-sm text-on-surface-variant">
                                            Pasien sedang menjalani rawat inap intensif / IGD dan butuh penjaminan segera (24 jam).
                                        </p>
                                    </div>
                                </label>

                                <label class="border-2 rounded-2xl p-5 flex items-start gap-4 cursor-pointer transition-all {{ $reason === 'chronic' ? 'border-secondary bg-secondary-container/10 ring-1 ring-secondary' : 'border-surface-container hover:bg-surface-container-low' }}">
                                    <input wire:model.live="reason" type="radio" value="chronic" class="mt-1 w-5 h-5 accent-secondary"/>
                                    <div>
                                        <span class="font-title-md text-title-md text-on-surface font-bold">Penyakit Kronis / Rutin</span>
                                        <p class="mt-1 font-body-sm text-body-sm text-on-surface-variant">
                                            Pasien memerlukan pengobatan jangka panjang (hemodialisa, kemoterapi, jantung, dll).
                                        </p>
                                    </div>
                                </label>

                                <label class="border-2 rounded-2xl p-5 flex items-start gap-4 cursor-pointer transition-all {{ $reason === 'catastrophic' ? 'border-secondary bg-secondary-container/10 ring-1 ring-secondary' : 'border-surface-container hover:bg-surface-container-low' }}">
                                    <input wire:model.live="reason" type="radio" value="catastrophic" class="mt-1 w-5 h-5 accent-secondary"/>
                                    <div>
                                        <span class="font-title-md text-title-md text-on-surface font-bold">Penyakit Katastropik</span>
                                        <p class="mt-1 font-body-sm text-body-sm text-on-surface-variant">
                                            Penyakit berbiaya tinggi yang mengancam jiwa dan membutuhkan perawatan rujukan lanjutan.
                                        </p>
                                    </div>
                                </label>

                                <label class="border-2 rounded-2xl p-5 flex items-start gap-4 cursor-pointer transition-all {{ $reason === 'newborn' ? 'border-secondary bg-secondary-container/10 ring-1 ring-secondary' : 'border-surface-container hover:bg-surface-container-low' }}">
                                    <input wire:model.live="reason" type="radio" value="newborn" class="mt-1 w-5 h-5 accent-secondary"/>
                                    <div>
                                        <span class="font-title-md text-title-md text-on-surface font-bold">Bayi Baru Lahir dari Ibu PBI</span>
                                        <p class="mt-1 font-body-sm text-body-sm text-on-surface-variant">
                                            Pengaktifan kepesertaan bayi baru lahir dari ibu kandung peserta aktif PBI-JK.
                                        </p>
                                    </div>
                                </label>
                            </div>

                            <!-- Alert Prioritas jika darurat medis -->
                            @if($reason === 'emergency')
                                <div class="p-4 rounded-xl bg-secondary-container/20 border border-secondary/30 flex items-start gap-3">
                                    <span class="material-symbols-outlined text-secondary text-[24px] shrink-0">emergency</span>
                                    <div>
                                        <p class="font-semibold text-secondary">Pengajuan Prioritas Darurat Medis Aktif</p>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                                            Pengajuan ini akan langsung ditandai berbendera merah di dashboard petugas Dinsos dan diproses dengan SLA tanggap darurat 24 Jam.
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Medical Facility Fields -->
                            @if(in_array($reason, ['emergency', 'chronic', 'catastrophic']))
                                <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container flex flex-col gap-4">
                                    <h4 class="font-title-md text-title-md text-on-surface font-semibold flex items-center gap-2">
                                        <span class="material-symbols-outlined text-secondary text-[20px]">local_hospital</span>
                                        <span>Informasi Fasilitas Kesehatan Perujuk</span>
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block font-label-md text-label-md text-on-surface mb-1">
                                                Nama Rumah Sakit / Puskesmas <span class="text-error">*</span>
                                            </label>
                                            <input wire:model="health_facility_name" type="text"
                                                   class="w-full h-12 px-4 rounded-xl bg-surface-container-lowest text-on-surface font-body-md text-body-md focus:ring-2 focus:ring-secondary outline-none transition-all"
                                                   placeholder="Contoh: RSUD Ngudi Waluyo Wlingi"/>
                                            @error('health_facility_name') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                        </div>

                                        <div>
                                            <label class="block font-label-md text-label-md text-on-surface mb-1">
                                                Nomor Surat Keterangan Rawat Inap / Faskes <span class="text-error">*</span>
                                            </label>
                                            <input wire:model="health_letter_number" type="text"
                                                   class="w-full h-12 px-4 rounded-xl bg-surface-container-lowest text-on-surface font-body-md text-body-md focus:ring-2 focus:ring-secondary outline-none transition-all"
                                                   placeholder="Contoh: 445/123/RSUD/2026"/>
                                            @error('health_letter_number') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- STEP 3: UNGGAH DOKUMEN -->
                    @if($currentStep === 3)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm flex flex-col gap-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                                <span class="w-10 h-10 rounded-xl bg-secondary-container/20 text-secondary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">cloud_upload</span>
                                </span>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">3. Unggah Dokumen Pendukung</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Unggah berkas dalam format PDF, JPG, atau PNG (maks 5MB)</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- KTP -->
                                <div class="flex flex-col gap-2">
                                    <label class="font-label-md text-on-surface font-semibold">Foto KTP Peserta <span class="text-error">*</span></label>
                                    <div class="border-2 border-dashed border-outline-variant rounded-2xl p-6 flex flex-col items-center justify-center text-center bg-surface-container-low hover:bg-surface-container transition-colors relative cursor-pointer">
                                        <input wire:model="ktp_file" type="file" accept="image/*,.pdf" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"/>
                                        @if($ktp_file)
                                            <span class="material-symbols-outlined text-secondary text-[40px] mb-2">check_circle</span>
                                            <p class="font-label-md text-secondary font-semibold truncate max-w-[200px]">{{ $ktp_file->getClientOriginalName() }}</p>
                                        @else
                                            <span class="material-symbols-outlined text-outline text-[40px] mb-2">upload_file</span>
                                            <p class="font-label-md text-on-surface font-semibold">Pilih Berkas KTP</p>
                                        @endif
                                    </div>
                                    @error('ktp_file') <p class="font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                                </div>

                                <!-- KK -->
                                <div class="flex flex-col gap-2">
                                    <label class="font-label-md text-on-surface font-semibold">Foto Kartu Keluarga <span class="text-error">*</span></label>
                                    <div class="border-2 border-dashed border-outline-variant rounded-2xl p-6 flex flex-col items-center justify-center text-center bg-surface-container-low hover:bg-surface-container transition-colors relative cursor-pointer">
                                        <input wire:model="kk_file" type="file" accept="image/*,.pdf" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"/>
                                        @if($kk_file)
                                            <span class="material-symbols-outlined text-secondary text-[40px] mb-2">check_circle</span>
                                            <p class="font-label-md text-secondary font-semibold truncate max-w-[200px]">{{ $kk_file->getClientOriginalName() }}</p>
                                        @else
                                            <span class="material-symbols-outlined text-outline text-[40px] mb-2">upload_file</span>
                                            <p class="font-label-md text-on-surface font-semibold">Pilih Berkas KK</p>
                                        @endif
                                    </div>
                                    @error('kk_file') <p class="font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                                </div>

                                <!-- BPJS -->
                                <div class="flex flex-col gap-2">
                                    <label class="font-label-md text-on-surface font-semibold">Foto Kartu BPJS / KIS <span class="text-error">*</span></label>
                                    <div class="border-2 border-dashed border-outline-variant rounded-2xl p-6 flex flex-col items-center justify-center text-center bg-surface-container-low hover:bg-surface-container transition-colors relative cursor-pointer">
                                        <input wire:model="bpjs_file" type="file" accept="image/*,.pdf" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"/>
                                        @if($bpjs_file)
                                            <span class="material-symbols-outlined text-secondary text-[40px] mb-2">check_circle</span>
                                            <p class="font-label-md text-secondary font-semibold truncate max-w-[200px]">{{ $bpjs_file->getClientOriginalName() }}</p>
                                        @else
                                            <span class="material-symbols-outlined text-outline text-[40px] mb-2">upload_file</span>
                                            <p class="font-label-md text-on-surface font-semibold">Pilih Berkas BPJS/KIS</p>
                                        @endif
                                    </div>
                                    @error('bpjs_file') <p class="font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                                </div>

                                <!-- Surat Faskes -->
                                @if(in_array($reason, ['emergency', 'chronic', 'catastrophic']))
                                    <div class="flex flex-col gap-2">
                                        <label class="font-label-md text-on-surface font-semibold">Surat Keterangan Rawat Faskes <span class="text-error">*</span></label>
                                        <div class="border-2 border-dashed border-outline-variant rounded-2xl p-6 flex flex-col items-center justify-center text-center bg-surface-container-low hover:bg-surface-container transition-colors relative cursor-pointer">
                                            <input wire:model="health_letter_file" type="file" accept="image/*,.pdf" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"/>
                                            @if($health_letter_file)
                                                <span class="material-symbols-outlined text-secondary text-[40px] mb-2">check_circle</span>
                                                <p class="font-label-md text-secondary font-semibold truncate max-w-[200px]">{{ $health_letter_file->getClientOriginalName() }}</p>
                                            @else
                                                <span class="material-symbols-outlined text-outline text-[40px] mb-2">upload_file</span>
                                                <p class="font-label-md text-on-surface font-semibold">Pilih Surat Keterangan Faskes</p>
                                            @endif
                                        </div>
                                        @error('health_letter_file') <p class="font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- STEP 4: TINJAU & KIRIM -->
                    @if($currentStep === 4)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm flex flex-col gap-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                                <span class="w-10 h-10 rounded-xl bg-secondary-container/20 text-secondary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">preview</span>
                                </span>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">4. Konfirmasi & Kirim Permohonan</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Tinjau ringkasan sebelum meneruskan berkas ke dinas</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container space-y-2 text-sm">
                                    <div class="flex justify-between border-b border-surface-container pb-2">
                                        <span class="text-on-surface-variant">Nama Peserta:</span>
                                        <span class="font-semibold text-on-surface">{{ $participant_name }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-surface-container pb-2">
                                        <span class="text-on-surface-variant">NIK Peserta:</span>
                                        <span class="font-mono font-semibold text-on-surface">{{ $participant_nik }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-surface-container pb-2">
                                        <span class="text-on-surface-variant">Nomor BPJS/KIS:</span>
                                        <span class="font-mono font-semibold text-on-surface">{{ $bpjs_card_number }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-surface-container pb-2">
                                        <span class="text-on-surface-variant">Alasan Reaktivasi:</span>
                                        <span class="font-semibold text-secondary capitalize">{{ $reason }}</span>
                                    </div>
                                    @if($health_facility_name)
                                        <div class="flex justify-between border-b border-surface-container pb-2">
                                            <span class="text-on-surface-variant">Rumah Sakit / Faskes:</span>
                                            <span class="font-semibold text-on-surface">{{ $health_facility_name }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <span class="text-on-surface-variant">No. WhatsApp:</span>
                                        <span class="font-semibold text-on-surface">{{ $phone }}</span>
                                    </div>
                                </div>

                                <div class="p-4 rounded-xl bg-secondary-container/15 border border-secondary/30 text-on-surface font-body-sm text-body-sm">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input wire:model="agreement" type="checkbox" class="mt-1 w-5 h-5 rounded text-secondary focus:ring-secondary accent-secondary"/>
                                        <span>
                                            Saya menyatakan bahwa data kepesertaan dan surat keterangan faskes yang saya serahkan adalah sah dan dapat dipertanggungjawabkan kebenarannya. <span class="text-error font-bold">*</span>
                                        </span>
                                    </label>
                                    @error('agreement') <p class="mt-2 font-body-sm text-error font-semibold">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Wizard Buttons -->
                    <div class="flex items-center justify-between pt-2">
                        @if($currentStep > 1)
                            <button wire:click="prevStep" type="button"
                                    class="py-3 px-6 rounded-xl bg-surface-container text-on-surface font-label-md text-label-md font-semibold hover:bg-surface-container-high transition-colors flex items-center gap-1.5 cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                                <span>Kembali</span>
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if($currentStep < 4)
                            <button wire:click="nextStep" type="button"
                                    class="py-3 px-8 rounded-xl bg-secondary-container text-on-secondary-container font-label-lg text-label-lg font-bold shadow-md hover:brightness-105 transition-all flex items-center gap-2 cursor-pointer">
                                <span>Lanjutkan</span>
                                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </button>
                        @else
                            <button wire:click="submit" type="button"
                                    class="py-3.5 px-8 rounded-xl bg-secondary-container text-on-secondary-container font-label-lg text-label-lg font-bold shadow-lg hover:brightness-105 transition-all flex items-center gap-2 cursor-pointer">
                                <span class="material-symbols-outlined text-[20px]">send</span>
                                <span>Kirim Pengajuan Reaktivasi</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Sidebar Checklist & Help -->
                <div class="lg:col-span-4 flex flex-col gap-6 sticky top-28">
                    <div class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container shadow-sm flex flex-col gap-4">
                        <h3 class="font-title-md text-title-md text-on-surface font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-[20px]">timeline</span>
                            <span>Tahapan Proses Reaktivasi</span>
                        </h3>
                        <div class="space-y-3 font-body-sm text-body-sm text-on-surface-variant">
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-full bg-secondary-container/20 text-secondary flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">1</span>
                                <span>Pemeriksaan berkas dan kelayakan desil DTKS oleh petugas.</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-full bg-secondary-container/20 text-secondary flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">2</span>
                                <span>Penerbitan Surat Rekomendasi oleh Kepala Dinas Sosial.</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-full bg-secondary-container/20 text-secondary flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">3</span>
                                <span>Input usulan ke sistem SIKS-NG Kementerian Sosial RI.</span>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-6 h-6 rounded-full bg-secondary-container/20 text-secondary flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">4</span>
                                <span>Konfirmasi persetujuan Kemensos & kepesertaan aktif di BPJS.</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary text-[24px] shrink-0">local_hospital</span>
                        <div class="text-on-surface-variant font-body-sm text-body-sm">
                            <p class="font-semibold text-on-surface">Pasien Rawat Inap Darurat?</p>
                            <p class="mt-1">Laporkan segera nomor tiket kepada Petugas Informasi RS / Dinsos untuk percepatan rekomendasi 24 jam.</p>
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>
