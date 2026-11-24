<x-apanel-layout :title="'Edit Proyek: ' . $project->title">
    <div class="max-w-5xl mx-auto px-6 lg:px-8 py-8 lg:py-10">
        <!-- Breadcrumbs & Title -->
        <section class="flex flex-col gap-2 mb-8">
            <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-1.5 text-xs text-on-surface-variant font-medium">
                <a href="{{ route('apanel.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <span class="text-outline">/</span>
                <span class="text-on-surface-variant">Kelola Proyek</span>
                <span class="text-outline">/</span>
                <span class="text-primary font-semibold truncate max-w-xs">Edit: {{ $project->title }}</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="font-['Poppins'] font-bold text-2xl lg:text-3xl text-primary tracking-tight">Edit Proyek</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Perbarui informasi, dokumentasi lapangan, teknologi, atau komposisi tim mahasiswa untuk <strong class="font-semibold text-on-surface">{{ $project->title }}</strong>.</p>
                </div>
                <div class="flex items-center gap-2.5 shrink-0">
                    @if($project->is_published)
                        <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary hover:text-primary-royal-indigo transition-colors whitespace-nowrap py-2 px-3.5 rounded-xl border border-primary/30 bg-primary-container/20 hover:bg-primary-container/40 shadow-xs">
                            <span>Lihat Halaman Publik</span>
                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                        </a>
                    @endif
                    <a href="{{ route('apanel.dashboard') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors whitespace-nowrap py-2 px-3.5 rounded-xl border border-outline-variant bg-surface shadow-xs hover:border-primary/40 hover:bg-surface-variant">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        <span>Kembali ke Dasbor</span>
                    </a>
                </div>
            </div>
        </section>

        @include('apanel.projects._form', ['project' => $project])
    </div>
</x-apanel-layout>
