<div class="flex flex-col w-full py-8 lg:py-12 bg-background min-h-[85vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" class="mb-4 flex items-center gap-2 text-on-surface-variant font-label-md text-label-md">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('home') }}">
                <span class="material-symbols-outlined text-[18px]">home</span>
                <span>Beranda</span>
            </a>
            <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
            <span class="text-primary font-semibold">Pengaduan Sosial</span>
        </nav>

        @if($submittedTicket)
            <!-- CONFIRMATION / SUCCESS STATE -->
            <div class="bg-surface-container-lowest rounded-2xl p-8 sm:p-10 shadow-xl border border-surface-container text-center flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-primary/10 text-primary flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-[48px]">check_circle</span>
                </div>
                <span class="px-3.5 py-1 rounded-full bg-primary/10 text-primary font-label-sm font-semibold mb-3">
                    Laporan Berhasil Diterima
                </span>
                <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                    Pengaduan Anda Telah Tercatat
                </h1>
                <p class="mt-2 font-body-md text-on-surface-variant max-w-md">
                    Terima kasih atas kepedulian Anda. Laporan permasalahan sosial ini akan segera diverifikasi dan didisposisikan ke tim penanganan Dinas Sosial.
                </p>

                <!-- Ticket Card -->
                <div class="w-full my-8 p-6 rounded-2xl bg-surface-container-low border border-surface-container flex flex-col items-center gap-3">
                    <span class="font-label-sm text-on-surface-variant uppercase tracking-wider">Nomor Laporan Pengaduan</span>
                    <div class="flex items-center gap-3" x-data="{ copied: false }">
                        <span class="font-headline-lg font-mono font-bold text-primary tracking-wider">
                            {{ $submittedTicket }}
                        </span>
                        <button type="button"
                                @click="navigator.clipboard.writeText('{{ $submittedTicket }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="p-2 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors cursor-pointer"
                                title="Salin Nomor Laporan">
                            <span class="material-symbols-outlined text-[20px]" x-show="!copied">content_copy</span>
                            <span class="material-symbols-outlined text-[20px] text-primary" x-show="copied" x-cloak>done</span>
                        </button>
                    </div>
                    <p class="font-body-sm text-xs text-on-surface-variant">Simpan nomor pengaduan ini untuk memantau tindakan petugas.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full">
                    <a href="{{ route('cek-status', ['ticket' => $submittedTicket]) }}"
                       class="flex-1 py-3.5 px-6 rounded-xl bg-primary text-on-primary font-label-lg font-bold shadow-md hover:bg-primary-container transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">manage_search</span>
                        <span>Pantau Tindak Lanjut Laporan</span>
                    </a>
                    <a href="{{ route('home') }}"
                       class="py-3.5 px-6 rounded-xl bg-surface-container text-on-surface font-label-lg font-semibold hover:bg-surface-container-high transition-colors">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        @else
            <!-- FORM PENGADUAN -->
            <div class="bg-surface-container-lowest rounded-2xl shadow-md border border-surface-container p-6 sm:p-10 flex flex-col gap-8">
                <div>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-error-container/40 text-error font-label-sm font-bold mb-2">
                        <span class="material-symbols-outlined text-[16px]">campaign</span>
                        Kanal Pengaduan Warga
                    </span>
                    <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">
                        Layanan Pengaduan & Laporan Sosial
                    </h1>
                    <p class="mt-2 font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        Laporkan permasalahan sosial (PMKS, lansia terlantar, ODGJ, disabilitas, atau kendala bansos) di lingkungan Anda. Identitas pelapor dijaga kerahasiaannya.
                    </p>
                </div>

                <form wire:submit="submit" class="flex flex-col gap-8">
                    <!-- 1. Kategori Permasalahan -->
                    <div>
                        <label class="block font-title-md text-title-md text-on-surface font-bold mb-3">
                            1. Kategori Permasalahan Sosial <span class="text-error">*</span>
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($categories as $cat)
                                <button type="button"
                                        wire:click="selectCategory({{ $cat->id }})"
                                        class="p-4 rounded-xl border text-left transition-all cursor-pointer flex flex-col gap-2 {{ $complaint_category_id === $cat->id ? 'bg-primary/10 border-primary text-primary ring-2 ring-primary/20' : 'bg-surface-container-low border-surface-container hover:bg-surface-container text-on-surface' }}">
                                    <span class="material-symbols-outlined text-[24px]">
                                        @if(str_contains(strtolower($cat->name), 'lansia'))
                                            elderly
                                        @elseif(str_contains(strtolower($cat->name), 'disabilitas'))
                                            accessible
                                        @elseif(str_contains(strtolower($cat->name), 'odgj'))
                                            psychology
                                        @elseif(str_contains(strtolower($cat->name), 'anak'))
                                            child_care
                                        @elseif(str_contains(strtolower($cat->name), 'kekerasan'))
                                            front_hand
                                        @else
                                            report_problem
                                        @endif
                                    </span>
                                    <span class="font-label-md text-label-md font-semibold leading-tight">{{ $cat->name }}</span>
                                </button>
                            @endforeach
                        </div>
                        @error('complaint_category_id') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                    </div>

                    <!-- 2. Lokasi Kejadian -->
                    <div class="pt-6 border-t border-surface-container">
                        <label class="block font-title-md text-title-md text-on-surface font-bold mb-3">
                            2. Lokasi Kejadian Permasalahan <span class="text-error">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-1">Kecamatan <span class="text-error">*</span></label>
                                <select wire:model.live="district_id" class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md focus:ring-2 focus:ring-primary outline-none transition-all">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach($districts as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                                @error('district_id') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-1">Desa / Kelurahan <span class="text-error">*</span></label>
                                <select wire:model="village_id" class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md focus:ring-2 focus:ring-primary outline-none transition-all" {{ !$district_id ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Desa / Kelurahan --</option>
                                    @foreach($villages as $v)
                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                    @endforeach
                                </select>
                                @error('village_id') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-full">
                                <label class="block font-label-md text-label-md text-on-surface mb-1">
                                    Detail Patokan Lokasi (RT/RW, Dusun, Patokan Rumah/Gedung) <span class="text-error">*</span>
                                </label>
                                <textarea wire:model="location_detail" rows="2"
                                          placeholder="Contoh: RT 03 RW 02 Dusun Tegalrejo, sebelah barat masjid Al-Huda..."
                                          class="w-full p-4 rounded-xl bg-surface-container-low text-on-surface font-body-md focus:ring-2 focus:ring-primary outline-none transition-all"></textarea>
                                @error('location_detail') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 3. Uraian Masalah -->
                    <div class="pt-6 border-t border-surface-container" x-data="{ count: 0 }">
                        <div class="flex items-center justify-between mb-2">
                            <label class="font-title-md text-title-md text-on-surface font-bold">
                                3. Uraian Permasalahan Sosial <span class="text-error">*</span>
                            </label>
                            <span class="font-label-sm text-xs text-on-surface-variant font-mono" x-text="count + ' karakter'">0 karakter</span>
                        </div>
                        <textarea wire:model="description" rows="4"
                                  @input="count = $event.target.value.length"
                                  placeholder="Jelaskan kondisi permasalahan sosial yang terjadi secara kronologis, kondisi warga yang membutuhkan bantuan, atau tindakan yang dibutuhkan..."
                                  class="w-full p-4 rounded-xl bg-surface-container-low text-on-surface font-body-md focus:ring-2 focus:ring-primary outline-none transition-all"></textarea>
                        @error('description') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                    </div>

                    <!-- 4. Lampiran Foto / Berkas (Opsional) -->
                    <div class="pt-6 border-t border-surface-container">
                        <label class="block font-title-md text-title-md text-on-surface font-bold mb-1">
                            4. Foto Bukti Pendukung (Opsional)
                        </label>
                        <p class="font-body-sm text-on-surface-variant mb-3">Foto kondisi rumah, pasien/klien, atau bukti dokumen relevan (maks 5MB per berkas)</p>
                        <input wire:model="attachments" type="file" multiple accept="image/*,.pdf"
                               class="w-full text-sm bg-surface-container-low p-3 rounded-xl border border-surface-container"/>
                        @error('attachments.*') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                    </div>

                    <!-- 5. Data Pelapor -->
                    <div class="pt-6 border-t border-surface-container">
                        <label class="block font-title-md text-title-md text-on-surface font-bold mb-1">
                            5. Identitas Pelapor <span class="text-error">*</span>
                        </label>
                        <p class="font-body-sm text-on-surface-variant mb-4 flex items-center gap-1 text-primary">
                            <span class="material-symbols-outlined text-[16px]">lock</span>
                            Identitas Anda dijamin kerahasiaannya dan hanya dipakai petugas untuk klarifikasi lapangan.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-1">Nama Pelapor <span class="text-error">*</span></label>
                                <input wire:model="reporter_name" type="text"
                                       placeholder="Nama lengkap Anda"
                                       class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md focus:ring-2 focus:ring-primary outline-none transition-all"/>
                                @error('reporter_name') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-1">Nomor WhatsApp / HP Aktif <span class="text-error">*</span></label>
                                <input wire:model="reporter_phone" type="tel"
                                       placeholder="Contoh: 081234567890"
                                       class="w-full h-12 px-4 rounded-xl bg-surface-container-low text-on-surface font-body-md focus:ring-2 focus:ring-primary outline-none transition-all"/>
                                @error('reporter_phone') <p class="mt-1 font-body-sm text-error">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-surface-container">
                        <button type="submit"
                                class="w-full py-4 px-8 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold shadow-md hover:bg-primary-container transition-all flex items-center justify-center gap-2 cursor-pointer">
                            <span class="material-symbols-outlined text-[20px]">send</span>
                            <span>Kirim Laporan Pengaduan</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif

    </div>
</div>
