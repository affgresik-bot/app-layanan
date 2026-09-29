<div class="flex flex-col w-full py-8 lg:py-12 bg-background min-h-[85vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 w-full">

        @if($submittedTicket)
            <!-- SUCCESS SCREEN -->
            <div class="max-w-2xl mx-auto bg-surface-container-lowest rounded-2xl p-8 sm:p-10 shadow-xl border border-surface-container text-center flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-[48px]">check_circle</span>
                </div>
                <span class="px-3.5 py-1 rounded-full bg-primary/10 text-primary font-label-sm text-label-sm font-semibold mb-3">
                    Pengajuan Berhasil Dikirim
                </span>
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                    Surat Keterangan DTSEN Berhasil Diajukan
                </h1>
                <p class="mt-2 font-body-md text-body-md text-on-surface-variant max-w-md">
                    Berkas Anda telah masuk ke sistem dan akan diperiksa oleh petugas verifikator Dinas Sosial Kabupaten Blitar.
                </p>

                <!-- Ticket Card -->
                <div class="w-full my-8 p-6 rounded-2xl bg-surface-container-low border border-surface-container flex flex-col items-center gap-3">
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nomor Tiket Anda</span>
                    <div class="flex items-center gap-3" x-data="{ copied: false }">
                        <span class="font-headline-lg text-headline-lg font-mono font-bold text-primary tracking-wider" id="ticketNumberDisplay">
                            {{ $submittedTicket }}
                        </span>
                        <button type="button"
                                @click="navigator.clipboard.writeText('{{ $submittedTicket }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="p-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors cursor-pointer"
                                title="Salin Nomor Tiket">
                            <span class="material-symbols-outlined text-[20px]" x-show="!copied">content_copy</span>
                            <span class="material-symbols-outlined text-[20px] text-primary" x-show="copied" x-cloak>done</span>
                        </button>
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Simpan atau tangkap layar nomor tiket ini untuk memantau status secara berkala.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full">
                    <a href="{{ route('cek-status', ['ticket' => $submittedTicket]) }}"
                       class="flex-1 py-3.5 px-6 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold shadow-md hover:bg-primary-container transition-all flex items-center justify-center gap-2">
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
                    <span class="text-primary font-semibold">SK DTSEN</span>
                </nav>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <!-- Step 1 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl border transition-all {{ $currentStep >= 1 ? ($currentStep === 1 ? 'bg-primary text-on-primary shadow-sm border-primary' : 'bg-surface-container-lowest text-primary border-primary') : 'bg-surface-container-low text-on-surface-variant border-surface-container' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold font-title-md shrink-0 {{ $currentStep === 1 ? 'bg-primary-fixed text-on-primary-fixed' : ($currentStep > 1 ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant') }}">
                            @if($currentStep > 1) <span class="material-symbols-outlined text-[18px]">check</span> @else 1 @endif
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[11px] uppercase tracking-wider font-semibold opacity-80">Tahap 1</span>
                            <span class="font-title-md text-sm truncate font-semibold">Tujuan Surat</span>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl border transition-all {{ $currentStep >= 2 ? ($currentStep === 2 ? 'bg-primary text-on-primary shadow-sm border-primary' : 'bg-surface-container-lowest text-primary border-primary') : 'bg-surface-container-low text-on-surface-variant border-surface-container' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold font-title-md shrink-0 {{ $currentStep === 2 ? 'bg-primary-fixed text-on-primary-fixed' : ($currentStep > 2 ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant') }}">
                            @if($currentStep > 2) <span class="material-symbols-outlined text-[18px]">check</span> @else 2 @endif
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[11px] uppercase tracking-wider font-semibold opacity-80">Tahap 2</span>
                            <span class="font-title-md text-sm truncate font-semibold">Data Pemohon</span>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl border transition-all {{ $currentStep >= 3 ? ($currentStep === 3 ? 'bg-primary text-on-primary shadow-sm border-primary' : 'bg-surface-container-lowest text-primary border-primary') : 'bg-surface-container-low text-on-surface-variant border-surface-container' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold font-title-md shrink-0 {{ $currentStep === 3 ? 'bg-primary-fixed text-on-primary-fixed' : ($currentStep > 3 ? 'bg-primary text-on-primary' : 'bg-surface-container-high text-on-surface-variant') }}">
                            @if($currentStep > 3) <span class="material-symbols-outlined text-[18px]">check</span> @else 3 @endif
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="text-[11px] uppercase tracking-wider font-semibold opacity-80">Tahap 3</span>
                            <span class="font-title-md text-sm truncate font-semibold">Unggah Dokumen</span>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex items-center gap-3 p-3 rounded-xl border transition-all {{ $currentStep === 4 ? 'bg-primary text-on-primary shadow-sm border-primary' : 'bg-surface-container-low text-on-surface-variant border-surface-container' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold font-title-md shrink-0 {{ $currentStep === 4 ? 'bg-primary-fixed text-on-primary-fixed' : 'bg-surface-container-high text-on-surface-variant' }}">
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
                
                <!-- Left Column: Step Content Form -->
                <div class="lg:col-span-8 flex flex-col gap-6">

                    <!-- STEP 1: TUJUAN PENGGUNAAN -->
                    @if($currentStep === 1)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm flex flex-col gap-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                                <span class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">assignment</span>
                                </span>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">1. Tujuan Penggunaan Surat</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Pilih peruntukan resmi surat keterangan yang dibutuhkan</p>
                                </div>
                            </div>

                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-2">
                                    Peruntukan Dokumen Keterangan <span class="text-error">*</span>
                                </label>
                                <select wire:model.live="dtsen_purpose_id"
                                        class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all">
                                    @foreach($purposes as $purp)
                                        <option value="{{ $purp->id }}">
                                            {{ $purp->name }} (Maks Desil: {{ $purp->max_decile }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('dtsen_purpose_id')
                                    <p class="mt-1 font-body-sm text-body-sm text-error">{{ $message }}</p>
                                @enderror
                            </div>

                            @if($selectedPurpose)
                                <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container flex items-start gap-3 text-on-surface-variant font-body-sm text-body-sm">
                                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">info</span>
                                    <div>
                                        <p class="font-semibold text-on-surface">Ketentuan Maksimal Desil:</p>
                                        <p class="mt-0.5">Untuk tujuan <strong>{{ $selectedPurpose->name }}</strong>, hanya dapat diterbitkan bila desil DTKS hasil pengecekan petugas adalah <strong>Desil 1 s/d {{ $selectedPurpose->max_decile }}</strong>.</p>
                                    </div>
                                </div>
                            @endif

                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-2">
                                    Catatan / Keterangan Tambahan Instansi Tujuan (Opsional)
                                </label>
                                <textarea wire:model="purpose_description"
                                          rows="3"
                                          placeholder="Contoh: Untuk syarat pendaftaran SPMB SMAN 1 Talun / Beasiswa PIP Madrasah..."
                                          class="w-full p-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"></textarea>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 2: DATA PEMOHON & SUBJEK -->
                    @if($currentStep === 2)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm flex flex-col gap-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                                <span class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">badge</span>
                                </span>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">2. Identitas Pemohon & Orang yang Diterangkan</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Lengkapi data kependudukan sesuai KTP dan KK</p>
                                </div>
                            </div>

                            <!-- Data Pemohon -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-full">
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Nama Lengkap Pemohon (Sesuai KTP) <span class="text-error">*</span>
                                    </label>
                                    <input wire:model="applicant_name" type="text"
                                           class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"
                                           placeholder="Nama lengkap pemohon"/>
                                    @error('applicant_name') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        NIK Pemohon (16 Digit) <span class="text-error">*</span>
                                    </label>
                                    <input wire:model="applicant_nik" type="text" maxlength="16"
                                           class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md font-mono focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"
                                           placeholder="3505xxxxxxxxxxxx"/>
                                    @error('applicant_nik') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Nomor Kartu Keluarga (16 Digit) <span class="text-error">*</span>
                                    </label>
                                    <input wire:model="family_card_number" type="text" maxlength="16"
                                           class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md font-mono focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"
                                           placeholder="3505xxxxxxxxxxxx"/>
                                    @error('family_card_number') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Kecamatan Domisili <span class="text-error">*</span>
                                    </label>
                                    <select wire:model.live="district_id"
                                            class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all">
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
                                            class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"
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
                                        Alamat Lengkap (RT/RW, Dusun/Jalan) <span class="text-error">*</span>
                                    </label>
                                    <textarea wire:model="address" rows="2"
                                              class="w-full p-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"
                                              placeholder="Contoh: Dusun Krajan RT 02 RW 01"></textarea>
                                    @error('address') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>

                                <div class="col-span-full">
                                    <label class="block font-label-md text-label-md text-on-surface mb-1">
                                        Nomor WhatsApp / HP Aktif <span class="text-error">*</span>
                                    </label>
                                    <input wire:model="phone" type="tel"
                                           class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"
                                           placeholder="Contoh: 081234567890"/>
                                    @error('phone') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Data Orang yang Diterangkan -->
                            <div class="pt-6 border-t border-surface-container">
                                <h3 class="font-title-md text-title-md text-on-surface font-bold mb-4">
                                    Data Orang yang Diterangkan (Subjek Surat)
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="col-span-full">
                                        <label class="block font-label-md text-label-md text-on-surface mb-1">
                                            Hubungan dengan Pemohon <span class="text-error">*</span>
                                        </label>
                                        <select wire:model.live="relationship_to_applicant"
                                                class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all">
                                            <option value="diri_sendiri">Diri Sendiri (Pemohon adalah orang yang diterangkan)</option>
                                            <option value="anak">Anak Kandung (mis. Calon Siswa / Mahasiswa)</option>
                                            <option value="orang_tua">Orang Tua (Ayah / Ibu)</option>
                                            <option value="keluarga_lain">Anggota Keluarga dalam 1 KK</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block font-label-md text-label-md text-on-surface mb-1">
                                            Nama Orang yang Diterangkan <span class="text-error">*</span>
                                        </label>
                                        <input wire:model="subject_name" type="text"
                                               class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"
                                               placeholder="Nama calon siswa / orang diterangkan"/>
                                        @error('subject_name') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block font-label-md text-label-md text-on-surface mb-1">
                                            NIK Orang yang Diterangkan <span class="text-error">*</span>
                                        </label>
                                        <input wire:model="subject_nik" type="text" maxlength="16"
                                               class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md text-body-md font-mono focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"
                                               placeholder="3505xxxxxxxxxxxx"/>
                                        @error('subject_nik') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 3: UNGGAH DOKUMEN -->
                    @if($currentStep === 3)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm flex flex-col gap-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                                <span class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">cloud_upload</span>
                                </span>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">3. Unggah Dokumen Persyaratan</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Format berkas: JPG, PNG, atau PDF (maks 5MB per berkas)</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- KTP Upload -->
                                <div class="flex flex-col gap-2">
                                    <label class="font-label-md text-label-md text-on-surface font-semibold">
                                        Foto/Scan KTP Elektronik Asli <span class="text-error">*</span>
                                    </label>
                                    <div class="border-2 border-dashed border-outline-variant rounded-2xl p-6 flex flex-col items-center justify-center text-center bg-surface-container-low hover:bg-surface-container transition-colors relative cursor-pointer">
                                        <input wire:model="ktp_file" type="file" accept="image/*,.pdf" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"/>
                                        @if($ktp_file)
                                            <span class="material-symbols-outlined text-primary text-[40px] mb-2">check_circle</span>
                                            <p class="font-label-md text-primary font-semibold truncate max-w-[200px]">{{ $ktp_file->getClientOriginalName() }}</p>
                                            <span class="font-body-sm text-xs text-on-surface-variant">Klik untuk ganti berkas</span>
                                        @else
                                            <span class="material-symbols-outlined text-outline text-[40px] mb-2">upload_file</span>
                                            <p class="font-label-md text-on-surface font-semibold">Pilih Berkas KTP</p>
                                            <span class="font-body-sm text-xs text-on-surface-variant mt-1">atau tarik berkas ke sini</span>
                                        @endif
                                    </div>
                                    @error('ktp_file') <p class="font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                                </div>

                                <!-- KK Upload -->
                                <div class="flex flex-col gap-2">
                                    <label class="font-label-md text-label-md text-on-surface font-semibold">
                                        Foto/Scan Kartu Keluarga (KK) Asli <span class="text-error">*</span>
                                    </label>
                                    <div class="border-2 border-dashed border-outline-variant rounded-2xl p-6 flex flex-col items-center justify-center text-center bg-surface-container-low hover:bg-surface-container transition-colors relative cursor-pointer">
                                        <input wire:model="kk_file" type="file" accept="image/*,.pdf" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"/>
                                        @if($kk_file)
                                            <span class="material-symbols-outlined text-primary text-[40px] mb-2">check_circle</span>
                                            <p class="font-label-md text-primary font-semibold truncate max-w-[200px]">{{ $kk_file->getClientOriginalName() }}</p>
                                            <span class="font-body-sm text-xs text-on-surface-variant">Klik untuk ganti berkas</span>
                                        @else
                                            <span class="material-symbols-outlined text-outline text-[40px] mb-2">upload_file</span>
                                            <p class="font-label-md text-on-surface font-semibold">Pilih Berkas Kartu Keluarga</p>
                                            <span class="font-body-sm text-xs text-on-surface-variant mt-1">atau tarik berkas ke sini</span>
                                        @endif
                                    </div>
                                    @error('kk_file') <p class="font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 4: TINJAU & KIRIM -->
                    @if($currentStep === 4)
                        <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-surface-container shadow-sm flex flex-col gap-6">
                            <div class="flex items-center gap-3 pb-4 border-b border-surface-container">
                                <span class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">preview</span>
                                </span>
                                <div>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">4. Tinjau Ringkasan & Kirim Pengajuan</h2>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant">Pastikan seluruh data yang diisi telah benar sebelum mengirim</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container space-y-2 text-sm">
                                    <div class="flex justify-between border-b border-surface-container pb-2">
                                        <span class="text-on-surface-variant">Tujuan Penggunaan:</span>
                                        <span class="font-semibold text-on-surface text-right">{{ $selectedPurpose?->name }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-surface-container pb-2">
                                        <span class="text-on-surface-variant">Nama Pemohon:</span>
                                        <span class="font-semibold text-on-surface">{{ $applicant_name }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-surface-container pb-2">
                                        <span class="text-on-surface-variant">NIK Pemohon:</span>
                                        <span class="font-mono font-semibold text-on-surface">{{ $applicant_nik }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-surface-container pb-2">
                                        <span class="text-on-surface-variant">No. Kartu Keluarga:</span>
                                        <span class="font-mono font-semibold text-on-surface">{{ $family_card_number }}</span>
                                    </div>
                                    <div class="flex justify-between border-b border-surface-container pb-2">
                                        <span class="text-on-surface-variant">Orang yang Diterangkan:</span>
                                        <span class="font-semibold text-on-surface">{{ $subject_name }} ({{ $relationship_to_applicant }})</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-on-surface-variant">WhatsApp / HP:</span>
                                        <span class="font-semibold text-on-surface">{{ $phone }}</span>
                                    </div>
                                </div>

                                <div class="p-4 rounded-xl bg-primary/10 border border-primary/20 text-on-surface font-body-sm text-body-sm">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input wire:model="agreement" type="checkbox" class="mt-1 w-5 h-5 rounded text-primary focus:ring-primary accent-primary"/>
                                        <span>
                                            Saya menyatakan dengan sadar bahwa data dan dokumen yang saya berikan adalah sah dan benar. Apabila ditemukan ketidaksesuaian, saya bersedia menerima konsekuensi hukum sesuai ketentuan yang berlaku. <span class="text-error font-bold">*</span>
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
                                    class="py-3 px-8 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold shadow-md hover:bg-primary-container transition-all flex items-center gap-2 cursor-pointer">
                                <span>Lanjutkan</span>
                                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </button>
                        @else
                            <button wire:click="submit" type="button"
                                    class="py-3.5 px-8 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold shadow-lg hover:bg-primary-container transition-all flex items-center gap-2 cursor-pointer">
                                <span class="material-symbols-outlined text-[20px]">send</span>
                                <span>Kirim Permohonan Sekarang</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Sidebar Checklist & Help -->
                <div class="lg:col-span-4 flex flex-col gap-6 sticky top-28">
                    <div class="bg-surface-container-lowest rounded-2xl p-6 border border-surface-container shadow-sm flex flex-col gap-4">
                        <h3 class="font-title-md text-title-md text-on-surface font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-[20px]">verified</span>
                            <span>Ketentuan Pengajuan</span>
                        </h3>
                        <div class="space-y-3 font-body-sm text-body-sm text-on-surface-variant">
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">check_circle</span>
                                <span>Wajib memiliki NIK dan KK Kabupaten Blitar yang valid di Dukcapil.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">check_circle</span>
                                <span>Petugas akan mengecek desil keluarga di sistem SIKS-NG Kementerian Sosial.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">check_circle</span>
                                <span>Surat bertanda QR Code verifikasi resmi Kepala Dinas Sosial Kab. Blitar.</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary text-[24px] shrink-0">support_agent</span>
                        <div class="text-on-surface-variant font-body-sm text-body-sm">
                            <p class="font-semibold text-on-surface">Butuh Bantuan Operator?</p>
                            <p class="mt-1">Petugas kami di kantor desa/kelurahan siap mendampingi pengisian permohonan Anda.</p>
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>
