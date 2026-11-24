<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Dasbor Pengelola - Berdampak Utama | Universitas Widyatama</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/logo-widyatama.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col bg-surface-variant text-on-surface antialiased selection:bg-primary selection:text-white">
    <header class="sticky top-0 z-40 bg-primary text-on-primary border-b border-primary-royal-indigo shadow-xs">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 shrink-0">
                <div class="flex items-center gap-1.5 bg-surface rounded-lg p-1.5 shrink-0 shadow-xs">
                    <img src="{{ asset('images/logo-widyatama.jpg') }}" alt="Logo Universitas Widyatama" class="w-7 h-7 object-contain">
                    <img src="{{ asset('images/diktisaintek-transparent.png') }}" alt="Logo Diktisaintek Berdampak" class="w-7 h-7 object-contain">
                </div>
                <span class="font-['Poppins'] font-semibold text-base text-on-primary hidden sm:inline">
                    Admin Berdampak Utama <span class="text-xs font-normal text-diktisaintek-container ml-1.5 px-2 py-0.5 rounded-full bg-primary-royal-indigo border border-primary-container/20">Panel Pengelola</span>
                </span>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary-royal-indigo border border-primary-container/25">
                    <svg class="w-4 h-4 text-on-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="text-xs font-medium text-on-primary">{{ $user->name }} ({{ strtoupper($user->role ?? 'Admin') }})</span>
                </div>

                <a href="{{ route('landing') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-on-primary/80 hover:text-white transition-colors duration-150">
                    <span>Web Publik</span>
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                </a>

                <form action="{{ route('apanel.logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        title="Keluar dari sesi administrasi"
                        class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-error bg-surface text-error text-xs font-semibold hover:bg-error-container transition-colors duration-150 cursor-pointer shadow-xs"
                    >
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl mx-auto w-full px-6 lg:px-8 py-8 lg:py-10">
        <section class="flex flex-col gap-2 mb-8">
            <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-1.5 text-xs text-on-surface-variant font-medium">
                <span>Admin</span>
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span class="text-primary font-semibold">Dasbor Pengelola</span>
            </nav>
            <h1 class="font-['Poppins'] text-2xl lg:text-3xl font-bold text-primary tracking-tight">
                Selamat Datang, {{ $user->name }}
            </h1>
            <p class="text-sm text-on-surface-variant max-w-3xl leading-relaxed">
                Kelola data proyek inovasi, kurasi dokumentasi tim pengembang mahasiswa, dan terbitkan catatan kegiatan lapangan.
            </p>
        </section>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-surface border border-outline-variant rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Total Proyek</span>
                    <div class="w-9 h-9 rounded-xl bg-primary-container text-primary flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-primary font-['Poppins']">{{ $projectCount }}</div>
                <p class="text-xs text-on-surface-variant mt-1">Proyek inovasi aktif terdaftar</p>
            </div>

            <div class="bg-surface border border-outline-variant rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Mahasiswa Pengembang</span>
                    <div class="w-9 h-9 rounded-xl bg-diktisaintek-container text-on-diktisaintek-container flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-primary font-['Poppins']">{{ $contributorCount }}</div>
                <p class="text-xs text-on-surface-variant mt-1">Kontributor aktif terverifikasi NPM</p>
            </div>

            <div class="bg-surface border border-outline-variant rounded-2xl p-6 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Catatan Lapangan</span>
                    <div class="w-9 h-9 rounded-xl bg-tertiary-container text-on-tertiary-container flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-primary font-['Poppins']">{{ $fieldPostCount }}</div>
                <p class="text-xs text-on-surface-variant mt-1">Dokumentasi desa mitra terbit</p>
            </div>
        </div>

        <div class="bg-surface border border-outline-variant rounded-2xl p-6 lg:p-8 shadow-xs">
            <h2 class="text-sm font-semibold text-primary uppercase tracking-wider mb-4">
                Kesiapan Modul Administrasi
            </h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-4 rounded-xl bg-surface-variant border border-outline-variant text-xs">
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 rounded-full bg-success"></span>
                        <span class="font-medium text-on-surface">Autentikasi & Pengamanan Sesi (/apanel/login)</span>
                    </div>
                    <span class="text-[11px] font-semibold text-on-success-container bg-success-container border border-success/30 px-3 py-1 rounded-full">
                        Aktif & Teruji
                    </span>
                </div>
                <div class="flex items-center justify-between p-4 rounded-xl bg-surface-variant border border-outline-variant text-xs">
                    <div class="flex items-center gap-3">
                        <span class="w-2.5 h-2.5 rounded-full bg-outline"></span>
                        <span class="font-medium text-on-surface-variant">Modul Input Proyek Baru & Pemilihan Tech Stack</span>
                    </div>
                    <span class="text-[11px] font-medium text-on-surface-variant bg-surface-container px-3 py-1 rounded-full">
                        Tahap Selanjutnya
                    </span>
                </div>
            </div>
        </div>
    </main>

    <footer class="border-t border-outline-variant py-4 bg-surface mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-xs text-on-surface-variant">
                &copy; 2026 Universitas Widyatama & Diktisaintek Berdampak. Seluruh hak cipta dilindungi.
            </p>
        </div>
    </footer>

    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
