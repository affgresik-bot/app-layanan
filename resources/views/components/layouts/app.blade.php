<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="web_standard" name="shell-type"/>
    <title>{{ $title ?? 'SAPA SOSIAL — Dinas Sosial Kabupaten Blitar' }}</title>
    
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-background font-body-md text-body-md text-on-surface antialiased min-h-screen flex flex-col selection:bg-primary-container selection:text-on-primary-container"
      x-data="{ mobileMenuOpen: false }">

    <!-- Top Sticky Header -->
    <header class="sticky top-0 w-full z-50 bg-surface/95 backdrop-blur-xl shadow-[0_1px_8px_rgba(0,0,0,0.04)] border-b border-surface-container">
        <div class="h-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 flex items-center justify-between gap-4">
            
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                <div class="w-10 h-10 shrink-0 transition-transform group-hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="100%" height="100%" fill="none">
                        <rect width="48" height="48" rx="12" fill="#0F766E"/>
                        <path d="M24 14C20.686 14 18 16.686 18 20C18 24.5 24 33 24 33C24 33 30 24.5 30 20C30 16.686 27.314 14 24 14Z" fill="#F59E0B" opacity="0.95"/>
                        <circle cx="24" cy="20" r="3" fill="#FFFFFF"/>
                        <path d="M14 34C14 31 18.5 29 24 29C29.5 29 34 31 34 34" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-headline-sm text-headline-sm text-primary tracking-tight leading-none group-hover:text-primary-container transition-colors">SAPA SOSIAL</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant font-medium tracking-normal mt-0.5">Dinas Sosial Kabupaten Blitar</span>
                </div>
            </a>

            <!-- Desktop Nav Navigation -->
            <nav class="hidden xl:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-3.5 py-2 rounded-xl font-label-md transition-colors {{ request()->routeIs('home') ? 'bg-primary-container text-on-primary-container font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }}">
                    Beranda
                </a>
                <a href="{{ route('informasi.index') }}"
                   class="px-3.5 py-2 rounded-xl font-label-md transition-colors {{ request()->routeIs('informasi.*') ? 'bg-primary-container text-on-primary-container font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }}">
                    Informasi Layanan
                </a>
                <a href="{{ route('layanan.index') }}"
                   class="px-3.5 py-2 rounded-xl font-label-md transition-colors {{ request()->routeIs('layanan.*') ? 'bg-primary-container text-on-primary-container font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }}">
                    Ajukan Layanan
                </a>
                <a href="{{ route('cek-status') }}"
                   class="px-3.5 py-2 rounded-xl font-label-md transition-colors {{ request()->routeIs('cek-status*') ? 'bg-primary-container text-on-primary-container font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }}">
                    Cek Status
                </a>
                <a href="{{ route('pengaduan') }}"
                   class="px-3.5 py-2 rounded-xl font-label-md transition-colors {{ request()->routeIs('pengaduan*') ? 'bg-primary-container text-on-primary-container font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }}">
                    Pengaduan
                </a>
                <a href="{{ route('verifikasi') }}"
                   class="px-3.5 py-2 rounded-xl font-label-md transition-colors {{ request()->routeIs('verifikasi*') ? 'bg-primary-container text-on-primary-container font-semibold shadow-sm' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high' }}">
                    Verifikasi Surat
                </a>
            </nav>

            <!-- User Auth / Action -->
            <div class="flex items-center gap-3">
                @auth
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" type="button"
                                class="flex items-center gap-2 p-1.5 pl-3 pr-2.5 rounded-xl bg-surface-container hover:bg-surface-container-high transition-all border border-outline-variant">
                            <span class="font-label-md text-on-surface font-semibold max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </button>
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-surface-container-lowest rounded-xl shadow-xl border border-surface-container py-2 z-50">
                            <div class="px-4 py-2 border-b border-surface-container">
                                <p class="font-label-sm text-on-surface-variant">Masuk sebagai</p>
                                <p class="font-label-md font-semibold text-on-surface truncate">{{ auth()->user()->name }}</p>
                            </div>
                            <a href="{{ route('riwayat.pengajuan') }}" class="flex items-center gap-2 px-4 py-2.5 font-label-md text-on-surface hover:bg-surface-container transition-colors">
                                <span class="material-symbols-outlined text-[20px] text-primary">history_edu</span>
                                Riwayat Pengajuan Saya
                            </a>
                            @if(auth()->user()->canAccessPanel(filament()->getPanel('admin')))
                                <a href="/admin" class="flex items-center gap-2 px-4 py-2.5 font-label-md text-on-surface hover:bg-surface-container transition-colors">
                                    <span class="material-symbols-outlined text-[20px] text-secondary">admin_panel_settings</span>
                                    Panel Admin Dinsos
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-surface-container mt-1">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2.5 font-label-md text-error hover:bg-error-container/20 transition-colors text-left">
                                    <span class="material-symbols-outlined text-[20px]">logout</span>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center min-h-[44px] px-5 rounded-xl border border-primary font-label-md text-label-md text-primary hover:bg-primary hover:text-on-primary transition-all duration-200">
                        <span class="material-symbols-outlined text-[18px] mr-1.5">lock</span>
                        Masuk / Daftar
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                        class="xl:hidden p-2 rounded-xl text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors"
                        aria-label="Buka Menu">
                    <span class="material-symbols-outlined text-[28px]" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Slide-Down Menu -->
        <div x-show="mobileMenuOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="xl:hidden bg-surface-container-lowest border-b border-surface-container px-6 py-4 shadow-xl">
            <div class="flex flex-col gap-2">
                <a href="{{ route('home') }}" class="px-4 py-3 rounded-xl font-label-md {{ request()->routeIs('home') ? 'bg-primary-container text-on-primary-container font-semibold' : 'text-on-surface hover:bg-surface-container' }}">
                    Beranda
                </a>
                <a href="{{ route('informasi.index') }}" class="px-4 py-3 rounded-xl font-label-md {{ request()->routeIs('informasi.*') ? 'bg-primary-container text-on-primary-container font-semibold' : 'text-on-surface hover:bg-surface-container' }}">
                    Informasi Layanan
                </a>
                <a href="{{ route('layanan.index') }}" class="px-4 py-3 rounded-xl font-label-md {{ request()->routeIs('layanan.*') ? 'bg-primary-container text-on-primary-container font-semibold' : 'text-on-surface hover:bg-surface-container' }}">
                    Ajukan Layanan
                </a>
                <a href="{{ route('cek-status') }}" class="px-4 py-3 rounded-xl font-label-md {{ request()->routeIs('cek-status*') ? 'bg-primary-container text-on-primary-container font-semibold' : 'text-on-surface hover:bg-surface-container' }}">
                    Cek Status Tiket
                </a>
                <a href="{{ route('pengaduan') }}" class="px-4 py-3 rounded-xl font-label-md {{ request()->routeIs('pengaduan*') ? 'bg-primary-container text-on-primary-container font-semibold' : 'text-on-surface hover:bg-surface-container' }}">
                    Pengaduan Sosial
                </a>
                <a href="{{ route('verifikasi') }}" class="px-4 py-3 rounded-xl font-label-md {{ request()->routeIs('verifikasi*') ? 'bg-primary-container text-on-primary-container font-semibold' : 'text-on-surface hover:bg-surface-container' }}">
                    Verifikasi Keaslian Surat
                </a>
                @auth
                    <a href="{{ route('riwayat.pengajuan') }}" class="px-4 py-3 rounded-xl font-label-md text-primary font-semibold hover:bg-surface-container">
                        Riwayat Pengajuan Saya
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="w-full flex-1 bg-background pt-0 pb-16 xl:pb-0">
        {{ $slot }}
    </main>

    <!-- Mobile Bottom Navigation Bar -->
    <nav class="xl:hidden fixed bottom-0 left-0 right-0 z-40 bg-surface/95 backdrop-blur-xl border-t border-surface-container shadow-lg flex items-center justify-around py-2 px-2">
        <a href="{{ route('home') }}" class="flex flex-col items-center gap-0.5 py-1 px-3 rounded-lg {{ request()->routeIs('home') ? 'text-primary font-bold' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[22px]">home</span>
            <span class="font-label-sm text-[11px]">Beranda</span>
        </a>
        <a href="{{ route('layanan.index') }}" class="flex flex-col items-center gap-0.5 py-1 px-3 rounded-lg {{ request()->routeIs('layanan.*') ? 'text-primary font-bold' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[22px]">assignment</span>
            <span class="font-label-sm text-[11px]">Layanan</span>
        </a>
        <a href="{{ route('pengaduan') }}" class="flex flex-col items-center gap-0.5 py-1 px-3 rounded-lg {{ request()->routeIs('pengaduan*') ? 'text-primary font-bold' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[22px]">campaign</span>
            <span class="font-label-sm text-[11px]">Pengaduan</span>
        </a>
        <a href="{{ route('cek-status') }}" class="flex flex-col items-center gap-0.5 py-1 px-3 rounded-lg {{ request()->routeIs('cek-status*') ? 'text-primary font-bold' : 'text-on-surface-variant' }}">
            <span class="material-symbols-outlined text-[22px]">search</span>
            <span class="font-label-sm text-[11px]">Cek Status</span>
        </a>
    </nav>

    <!-- Global Civic Footer -->
    <footer class="w-full bg-surface-container-lowest border-t border-surface-container mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12">
                
                <!-- Col 1: Instansi & Deskripsi -->
                <div class="lg:col-span-5 flex flex-col gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="100%" height="100%" fill="none">
                                <rect width="48" height="48" rx="12" fill="#0F766E"/>
                                <path d="M24 14C20.686 14 18 16.686 18 20C18 24.5 24 33 24 33C24 33 30 24.5 30 20C30 16.686 27.314 14 24 14Z" fill="#F59E0B" opacity="0.95"/>
                                <circle cx="24" cy="20" r="3" fill="#FFFFFF"/>
                                <path d="M14 34C14 31 18.5 29 24 29C29.5 29 34 31 34 34" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-headline-sm text-headline-sm text-primary tracking-tight">SAPA SOSIAL</span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant font-medium">Satu Pintu Layanan Sosial Kab. Blitar</span>
                        </div>
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed">
                        Sistem digital terpadu pelayanan publik Dinas Sosial Pemerintah Kabupaten Blitar. Mewujudkan pelayanan sosial yang transparan, akuntabel, bebas calo, dan mudah dipantau oleh seluruh masyarakat.
                    </p>
                    <div class="flex items-center gap-2 pt-2 text-primary font-label-sm text-label-sm">
                        <span class="material-symbols-outlined text-[18px]">verified</span>
                        <span>Portal Resmi Pemerintah Kabupaten Blitar</span>
                    </div>
                </div>

                <!-- Col 2: Alamat & Kontak -->
                <div class="lg:col-span-4 flex flex-col gap-3">
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Kantor Pelayanan</h3>
                    <div class="flex items-start gap-2.5 text-on-surface-variant font-body-sm text-body-sm">
                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">location_on</span>
                        <span>Jl. Raya Sebani No. 1, Kecamatan Kanigoro, Kabupaten Blitar, Jawa Timur 66171</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-on-surface-variant font-body-sm text-body-sm">
                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0">call</span>
                        <span>Hotline / WhatsApp: (0342) 801234 / 0812-3456-7890</span>
                    </div>
                    <div class="flex items-center gap-2.5 text-on-surface-variant font-body-sm text-body-sm">
                        <span class="material-symbols-outlined text-primary text-[20px] shrink-0">schedule</span>
                        <span>Senin – Jumat : 07.30 – 15.30 WIB</span>
                    </div>
                </div>

                <!-- Col 3: Tautan Cepat -->
                <div class="lg:col-span-3 flex flex-col gap-3">
                    <h3 class="font-title-md text-title-md text-on-surface font-bold">Layanan Utama</h3>
                    <ul class="flex flex-col gap-2 font-body-sm text-body-sm text-on-surface-variant">
                        <li><a href="{{ route('layanan.dtsen') }}" class="hover:text-primary transition-colors flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">chevron_right</span> Surat Keterangan DTSEN</a></li>
                        <li><a href="{{ route('layanan.pbi') }}" class="hover:text-primary transition-colors flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">chevron_right</span> Reaktivasi KIS / PBI-JK</a></li>
                        <li><a href="{{ route('layanan.index') }}" class="hover:text-primary transition-colors flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">chevron_right</span> Rehabilitasi Sosial</a></li>
                        <li><a href="{{ route('pengaduan') }}" class="hover:text-primary transition-colors flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">chevron_right</span> Pengaduan & Laporan Warga</a></li>
                        <li><a href="{{ route('verifikasi') }}" class="hover:text-primary transition-colors flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">chevron_right</span> Cek Keaslian SK DTSEN</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright & Security Notice -->
            <div class="mt-12 pt-6 border-t border-surface-container flex flex-col sm:flex-row items-center justify-between gap-4 font-label-sm text-label-sm text-on-surface-variant">
                <p>© 2026 Dinas Sosial Kabupaten Blitar. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-4">
                    <span>Terhubung dengan SIKS-NG & DTKS</span>
                    <span>•</span>
                    <a href="{{ route('cek-status') }}" class="text-primary hover:underline">Lacak Berkas</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
