<x-apanel-layout title="Tambah Proyek Baru">
    <div class="max-w-5xl mx-auto px-6 lg:px-8 py-8 lg:py-10">
        <!-- Breadcrumbs & Title -->
        <section class="flex flex-col gap-2 mb-8">
            <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-1.5 text-xs text-on-surface-variant font-medium">
                <a href="{{ route('apanel.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <span class="text-outline">/</span>
                <span class="text-on-surface-variant">Kelola Proyek</span>
                <span class="text-outline">/</span>
                <span class="text-primary font-semibold">Tambah Proyek Baru</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="font-['Poppins'] font-bold text-2xl lg:text-3xl text-primary tracking-tight">Tambah Proyek Baru</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Lengkapi informasi umum, dokumentasi lapangan, tech stack, dan daftar mahasiswa pelaksana program Berdampak Utama.</p>
                </div>
                <a href="{{ route('apanel.dashboard') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors shrink-0 whitespace-nowrap self-start sm:self-center py-2 px-3.5 rounded-xl border border-outline-variant bg-surface shadow-xs hover:border-primary/40 hover:bg-surface-variant">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    <span>Kembali ke Dasbor</span>
                </a>
            </div>
        </section>

        @include('apanel.projects._form', ['project' => null])
    </div>
</x-apanel-layout>
