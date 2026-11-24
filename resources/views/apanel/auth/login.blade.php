<x-apanel-auth-layout>
    <div class="min-h-screen flex flex-col items-center justify-between px-6 py-10">
        <div class="w-full max-w-md flex justify-start">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-1.5 text-on-surface-variant hover:text-primary text-sm font-semibold transition-colors duration-150">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <main class="w-full max-w-md my-auto py-8">
            <div class="bg-surface border border-outline-variant rounded-2xl shadow-lg p-8 flex flex-col gap-6">
                <div class="flex flex-col items-center text-center gap-4">
                    <div class="flex items-center justify-center gap-3">
                        <img src="{{ asset('images/logo-widyatama.jpg') }}" alt="Logo Universitas Widyatama" class="w-12 h-12 object-contain rounded-xs">
                        <img src="{{ asset('images/diktisaintek-transparent.png') }}" alt="Logo Diktisaintek Berdampak" class="w-12 h-12 object-contain rounded-xs">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <h1 class="font-['Poppins'] text-2xl font-semibold text-primary text-balance">
                            Portal Pengelola Kampus Berdampak
                        </h1>
                        <p class="text-xs text-on-surface-variant text-pretty leading-relaxed">
                            Silakan masuk untuk mengelola portofolio proyek dan dokumentasi tim.
                        </p>
                    </div>
                </div>

                @if (session('status'))
                    <div class="p-3.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-3.5 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        <div>
                            <span class="font-semibold block mb-0.5">Autentikasi Gagal</span>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('apanel.login.submit') }}" method="POST" class="flex flex-col gap-4">
                    @csrf

                    <div class="flex flex-col gap-1.5">
                        <label for="admin-email" class="text-sm font-semibold text-on-surface">
                            Email Institusi / Username
                        </label>
                        <div class="relative">
                            <svg class="w-4 h-4 text-on-surface-variant absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input
                                id="admin-email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="admin@widyatama.ac.id"
                                class="w-full pl-11 pr-4 py-2.5 rounded-lg border @error('email') border-rose-500 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 @else border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary @enderror bg-surface text-on-surface text-sm placeholder:text-on-surface-variant focus:outline-hidden transition-colors"
                            >
                        </div>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="admin-password" class="text-sm font-semibold text-on-surface">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <svg class="w-4 h-4 text-on-surface-variant absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input
                                id="admin-password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan kata sandi"
                                class="w-full pl-11 pr-11 py-2.5 rounded-lg border @error('password') border-rose-500 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 @else border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary @enderror bg-surface text-on-surface text-sm placeholder:text-on-surface-variant focus:outline-hidden transition-colors"
                            >
                            <button
                                id="toggle-password"
                                type="button"
                                aria-label="Tampilkan atau sembunyikan kata sandi"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors cursor-pointer"
                            >
                                <svg id="eye-open" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg id="eye-closed" class="w-4 h-4 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-2 pt-1">
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                value="1"
                                {{ old('remember') ? 'checked' : '' }}
                                class="rounded border-outline-variant text-primary focus:ring-primary cursor-pointer"
                            >
                            <span class="text-xs text-on-surface-variant">Ingat sesi saya</span>
                        </label>
                        <a href="#lupa-sandi" class="text-xs font-semibold text-primary hover:text-vibrant-utama-orange transition-colors">
                            Lupa kata sandi?
                        </a>
                    </div>

                    <button
                        type="submit"
                        class="w-full mt-2 inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary text-on-primary font-semibold text-sm shadow-xs hover:bg-primary-royal-indigo focus-visible:outline-hidden focus-visible:ring-2 focus-visible:ring-vibrant-utama-orange transition-colors cursor-pointer"
                    >
                        <span>Masuk ke Panel Pengelola</span>
                    </button>
                </form>

                <div class="bg-surface-variant border border-outline-variant rounded-xl p-3.5 flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-primary shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        <path d="M9 12l2 2 4-4"></path>
                    </svg>
                    <p class="text-xs text-on-surface-variant text-pretty leading-relaxed">
                        Akses terbatas hanya untuk tim pengelola LPPM dan IT Universitas Widyatama.
                    </p>
                </div>
            </div>
        </main>

        <footer class="text-center">
            <p class="text-xs text-on-surface-variant">
                &copy; 2026 Universitas Widyatama.
            </p>
        </footer>
    </div>

</x-apanel-auth-layout>
