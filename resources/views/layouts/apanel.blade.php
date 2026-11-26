<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title ?? 'Admin Panel' }} - Berdampak Utama | Universitas Widyatama</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-widyatama.png') }}">

    @vite(['resources/css/app.css', 'resources/js/apanel.js'])
</head>
<body class="min-h-full flex flex-col bg-surface-variant text-on-surface antialiased selection:bg-primary selection:text-white">
    <!-- Top Horizontal Navbar (Full-Width Navigation, NO Vertical Sidebar) -->
    <header class="sticky top-0 z-40 bg-primary text-on-primary border-b border-primary-royal-indigo shadow-xs">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('apanel.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="flex items-center gap-1.5 bg-surface rounded-lg p-1.5 shrink-0 shadow-xs transition-transform duration-150 group-hover:scale-105">
                        <img src="{{ asset('images/logo-widyatama.jpg') }}" alt="Logo Universitas Widyatama" class="w-7 h-7 object-contain">
                        <img src="{{ asset('images/diktisaintek-transparent.png') }}" alt="Logo Diktisaintek Berdampak" class="w-7 h-7 object-contain">
                    </div>
                    <span class="font-['Poppins'] font-semibold text-base text-on-primary hidden md:inline">
                        Admin Berdampak Utama
                    </span>
                </a>

                @auth
                    <nav aria-label="Navigasi Admin" class="flex items-center gap-1.5 ml-2 pl-3 border-l border-primary-container/20">
                        <a href="{{ route('apanel.dashboard') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors whitespace-nowrap {{ request()->routeIs('apanel.dashboard', 'apanel.projects.*') ? 'bg-primary-royal-indigo text-white border border-primary-container/30 shadow-xs' : 'text-on-primary/75 hover:text-white hover:bg-primary-royal-indigo/60' }}">
                            Proyek Inovasi
                        </a>
                        <a href="{{ route('apanel.field-posts.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors whitespace-nowrap {{ request()->routeIs('apanel.field-posts.*') ? 'bg-primary-royal-indigo text-white border border-primary-container/30 shadow-xs' : 'text-on-primary/75 hover:text-white hover:bg-primary-royal-indigo/60' }}">
                            Catatan Lapangan
                        </a>
                    </nav>
                @endauth
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @auth
                    <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-primary-royal-indigo border border-primary-container/25">
                        <svg class="w-4 h-4 text-on-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="text-xs font-medium text-on-primary">{{ auth()->user()->name }} ({{ strtoupper(auth()->user()->role ?? 'Admin') }})</span>
                    </div>
                @endauth

                <a href="{{ route('landing') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-on-primary/80 hover:text-white transition-colors duration-150 px-2 py-1 rounded">
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

    @if (session('status'))
        <div class="max-w-7xl mx-auto w-full px-6 lg:px-8 mt-6">
            <div class="p-4 rounded-xl bg-success-container border border-success/30 text-on-success-container flex items-center justify-between gap-3 text-sm font-medium">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-success shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-7xl mx-auto w-full px-6 lg:px-8 mt-6">
            <div class="p-4 rounded-xl bg-error-container border border-error/30 text-on-error-container text-sm">
                <div class="flex items-center gap-2 font-semibold mb-1">
                    <svg class="w-5 h-5 text-error shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    {{-- Key 'error' hanya dipakai untuk kegagalan server (Controller::failureMessage) --}}
                    <span>{{ $errors->has('error') ? 'Perubahan belum tersimpan:' : 'Terdapat beberapa kesalahan pengisian formulir:' }}</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 ml-7 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main class="flex-1 w-full">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    <footer class="border-t border-outline-variant py-4 bg-surface mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <p class="text-xs text-on-surface-variant">
                &copy; 2026 Universitas Widyatama & Diktisaintek Berdampak. Seluruh hak cipta dilindungi.
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
