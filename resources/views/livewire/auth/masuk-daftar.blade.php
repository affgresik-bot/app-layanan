<div class="flex flex-col items-center justify-center py-10 lg:py-16 bg-background min-h-[85vh]">
    <div class="w-full max-w-xl px-4 sm:px-6">

        <!-- Top Breadcrumbs -->
        <nav aria-label="Breadcrumb" class="mb-6 flex items-center justify-center gap-2 text-on-surface-variant font-label-md text-label-md">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ route('home') }}">
                <span class="material-symbols-outlined text-[18px]">home</span>
                <span>Beranda</span>
            </a>
            <span class="material-symbols-outlined text-[16px] text-outline">chevron_right</span>
            <span class="text-primary font-semibold">Portal Akun Warga</span>
        </nav>

        <!-- Auth Card Container -->
        <div class="w-full bg-surface-container-lowest rounded-2xl shadow-xl border border-surface-container p-6 sm:p-10">
            
            <!-- Auth Mode Toggle -->
            <div class="grid grid-cols-2 bg-surface-container-high p-1.5 rounded-xl mb-8">
                <button type="button" wire:click="setTab('masuk')"
                        class="py-2.5 rounded-lg font-label-lg text-label-lg transition-all cursor-pointer {{ $activeTab === 'masuk' ? 'bg-surface-container-lowest text-primary shadow-sm font-bold' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Masuk
                </button>
                <button type="button" wire:click="setTab('daftar')"
                        class="py-2.5 rounded-lg font-label-lg text-label-lg transition-all cursor-pointer {{ $activeTab === 'daftar' ? 'bg-surface-container-lowest text-primary shadow-sm font-bold' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Daftar Akun Baru
                </button>
            </div>

            @if($loginError)
                <div class="mb-6 p-4 rounded-xl bg-error-container text-on-error-container font-body-sm text-sm flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-error text-[20px] shrink-0">error</span>
                    <span>{{ $loginError }}</span>
                </div>
            @endif

            <!-- TAB 1: FORM MASUK -->
            @if($activeTab === 'masuk')
                <form wire:submit="login" class="flex flex-col gap-5">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1.5">
                            Nomor WhatsApp atau Alamat Email <span class="text-error">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">contact_phone</span>
                            <input wire:model="loginIdentifier" type="text" required
                                   placeholder="Contoh: 081234567890 atau email@domain.com"
                                   class="w-full h-12 pl-11 pr-4 bg-surface-container-low text-on-surface rounded-xl font-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"/>
                        </div>
                        @error('loginIdentifier') <p class="mt-1 font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label class="block font-label-md text-label-md text-on-surface mb-1.5">
                            Kata Sandi Akun <span class="text-error">*</span>
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">lock</span>
                            <input wire:model="password" :type="show ? 'text' : 'password'" required
                                   placeholder="Masukkan kata sandi Anda"
                                   class="w-full h-12 pl-11 pr-11 bg-surface-container-low text-on-surface rounded-xl font-body-md focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary outline-none transition-all"/>
                            <button type="button" @click="show = !show" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface cursor-pointer">
                                <span class="material-symbols-outlined text-[20px]" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                        @error('password') <p class="mt-1 font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input wire:model="remember" type="checkbox" class="w-4 h-4 rounded text-primary focus:ring-primary accent-primary"/>
                            <span class="font-body-sm text-sm text-on-surface-variant">Ingat saya</span>
                        </label>
                        <a href="https://wa.me/6281234567890" target="_blank" class="font-label-md text-sm text-primary hover:underline">
                            Lupa kata sandi?
                        </a>
                    </div>

                    <button type="submit"
                            class="w-full h-12 bg-primary hover:bg-primary-container text-on-primary font-label-lg font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 mt-2 cursor-pointer">
                        <span>Masuk ke SAPA SOSIAL</span>
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </form>
            @endif

            <!-- TAB 2: FORM DAFTAR -->
            @if($activeTab === 'daftar')
                <form wire:submit="register" class="flex flex-col gap-4">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1">
                            Nama Lengkap (Sesuai KTP) <span class="text-error">*</span>
                        </label>
                        <input wire:model="name" type="text" required placeholder="Nama lengkap sesuai KTP"
                               class="w-full h-12 px-4 bg-surface-container-low text-on-surface rounded-xl font-body-md focus:ring-2 focus:ring-primary outline-none transition-all"/>
                        @error('name') <p class="mt-1 font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1">
                            NIK (Nomor Induk Kependudukan - 16 Digit) <span class="text-error">*</span>
                        </label>
                        <input wire:model="nik" type="text" maxlength="16" required placeholder="3505xxxxxxxxxxxx"
                               class="w-full h-12 px-4 bg-surface-container-low text-on-surface rounded-xl font-mono focus:ring-2 focus:ring-primary outline-none transition-all"/>
                        @error('nik') <p class="mt-1 font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-1">
                                Nomor WhatsApp Aktif <span class="text-error">*</span>
                            </label>
                            <input wire:model="phone" type="tel" required placeholder="08xxxxxxxxxx"
                                   class="w-full h-12 px-4 bg-surface-container-low text-on-surface rounded-xl font-body-md focus:ring-2 focus:ring-primary outline-none transition-all"/>
                            @error('phone') <p class="mt-1 font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-1">
                                Alamat Email <span class="text-error">*</span>
                            </label>
                            <input wire:model="email" type="email" required placeholder="email@domain.com"
                                   class="w-full h-12 px-4 bg-surface-container-low text-on-surface rounded-xl font-body-md focus:ring-2 focus:ring-primary outline-none transition-all"/>
                            @error('email') <p class="mt-1 font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-1">
                                Buat Kata Sandi <span class="text-error">*</span>
                            </label>
                            <input wire:model="reg_password" type="password" required placeholder="Minimal 8 karakter"
                                   class="w-full h-12 px-4 bg-surface-container-low text-on-surface rounded-xl font-body-md focus:ring-2 focus:ring-primary outline-none transition-all"/>
                            @error('reg_password') <p class="mt-1 font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-1">
                                Ulangi Kata Sandi <span class="text-error">*</span>
                            </label>
                            <input wire:model="reg_password_confirmation" type="password" required placeholder="Ulangi sandi"
                                   class="w-full h-12 px-4 bg-surface-container-low text-on-surface rounded-xl font-body-md focus:ring-2 focus:ring-primary outline-none transition-all"/>
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-start gap-2.5 cursor-pointer">
                            <input wire:model="terms" type="checkbox" required class="mt-1 w-4 h-4 rounded text-primary focus:ring-primary accent-primary"/>
                            <span class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                                Saya menyetujui data identitas saya digunakan secara sah oleh Dinas Sosial Kabupaten Blitar untuk keperluan verifikasi layanan sosial dan DTKS. <span class="text-error">*</span>
                            </span>
                        </label>
                        @error('terms') <p class="mt-1 font-body-sm text-error text-xs">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="w-full h-12 bg-primary hover:bg-primary-container text-on-primary font-label-lg font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 mt-2 cursor-pointer">
                        <span>Buat Akun Warga</span>
                        <span class="material-symbols-outlined text-[20px]">person_add</span>
                    </button>
                </form>
            @endif

            <!-- Friendly Note -->
            <div class="mt-8 pt-6 border-t border-surface-container text-center">
                <p class="font-body-sm text-xs text-on-surface-variant leading-relaxed">
                    Tanpa login pun Anda tetap bisa mengajukan layanan dan memantau proses berkas dengan nomor tiket.
                </p>
                <a href="{{ route('cek-status') }}" class="inline-flex items-center gap-1 font-label-md text-sm text-primary font-semibold hover:underline mt-2">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    <span>Lacak Tiket Tanpa Login</span>
                </a>
            </div>

        </div>
    </div>
</div>
