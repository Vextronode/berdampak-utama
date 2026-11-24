<x-app-layout title="Catatan Lapangan & Dokumentasi Tim | Berdampak Utama">
    <div class="bg-surface-variant/50 min-h-screen py-10 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-10">
            <!-- Breadcrumb & Header -->
            <header class="flex flex-col gap-4 border-b border-outline-variant pb-8">
                <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs font-medium text-on-surface-variant">
                    <a href="{{ route('landing') }}" class="hover:text-primary transition-colors">Beranda</a>
                    <span class="text-outline">/</span>
                    <span class="text-primary font-semibold">Catatan Lapangan</span>
                </nav>

                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                    <div class="flex flex-col gap-2 max-w-3xl">
                        <span class="font-headline text-xs font-semibold tracking-wider text-secondary uppercase">
                            Jurnal Dokumentasi Pengabdian
                        </span>
                        <h1 class="font-headline font-bold text-3xl sm:text-4xl text-primary tracking-tight">
                            Catatan Lapangan & Dokumentasi Tim
                        </h1>
                        <p class="font-body text-sm sm:text-base text-on-surface-variant leading-relaxed text-pretty">
                            Liputan lengkap kegiatan implementasi, pelatihan operator desa, dan kolaborasi mahasiswa Universitas Widyatama bersama mitra masyarakat.
                        </p>
                    </div>

                    <a href="{{ route('landing') }}#portofolio" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-outline-variant bg-surface text-xs font-semibold text-on-surface-variant hover:text-primary hover:border-primary/40 transition-colors self-start lg:self-auto shadow-xs whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>

                @if($posts->isNotEmpty() || $search !== '' || $selectedProjectSlug !== '')
                    <!-- Filter & Search Form -->
                    <form method="GET" action="{{ route('field-posts.index') }}" class="mt-2 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 pt-4">
                        <!-- Project Filter Pills -->
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('field-posts.index', $search !== '' ? ['q' => $search] : []) }}"
                               class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold transition-colors {{ $selectedProjectSlug === '' ? 'bg-primary text-white shadow-xs' : 'bg-surface border border-outline-variant text-on-surface-variant hover:border-primary hover:text-primary' }}">
                                Semua Program
                            </a>
                            @foreach($projects as $proj)
                                <a href="{{ route('field-posts.index', array_filter(['proyek' => $proj->slug, 'q' => $search])) }}"
                                   class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold transition-colors {{ $selectedProjectSlug === $proj->slug ? 'bg-primary text-white shadow-xs' : 'bg-surface border border-outline-variant text-on-surface-variant hover:border-primary hover:text-primary' }}">
                                    {{ $proj->title }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Search Input -->
                        <div class="flex items-center gap-2">
                            @if($selectedProjectSlug !== '')
                                <input type="hidden" name="proyek" value="{{ $selectedProjectSlug }}">
                            @endif
                            <div class="relative flex-1 md:w-72">
                                <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul atau kegiatan lapangan..." class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-outline-variant bg-surface text-on-surface text-xs placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                                <svg class="w-4 h-4 text-on-surface-variant absolute left-3 top-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                            <button type="submit" class="px-4 py-2 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary-royal-indigo transition-colors shadow-xs cursor-pointer">
                                Cari
                            </button>
                        </div>
                    </form>
                @endif
            </header>

            <!-- Articles Grid -->
            @if($posts->isEmpty())
                @if($search !== '' || $selectedProjectSlug !== '')
                    <x-empty-state
                        icon="search"
                        variant="dashed"
                        title="Catatan Tidak Ditemukan"
                        description="Belum ada artikel catatan lapangan yang sesuai dengan kata kunci atau filter program yang dipilih."
                        class="max-w-lg mx-auto w-full"
                    >
                        <a href="{{ route('field-posts.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary-royal-indigo transition-colors shadow-xs">
                            Tampilkan Semua Catatan
                        </a>
                    </x-empty-state>
                @else
                    <x-empty-state
                        icon="document"
                        variant="dashed"
                        title="Belum Ada Catatan Kegiatan yang Diterbitkan"
                        description="Dokumentasi kegiatan implementasi, pelatihan perangkat desa, dan liputan kolaborasi tim di lapangan akan segera tersedia di sini."
                        class="max-w-xl mx-auto w-full"
                    >
                        <a href="{{ route('landing') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary-royal-indigo transition-colors shadow-xs">
                            Kembali ke Beranda
                        </a>
                    </x-empty-state>
                @endif
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 items-stretch">
                    @foreach($posts as $post)
                        <article class="relative cursor-pointer bg-surface border border-outline-variant hover:border-primary/40 rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
                            <div class="aspect-video bg-surface-container overflow-hidden border-b border-outline-variant relative">
                                @if($post->cover_image)
                                    <img src="{{ $post->cover_image }}" 
                                         alt="{{ $post->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-surface-variant text-on-surface-variant text-xs">
                                        Dokumentasi Lapangan
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-6 flex flex-col gap-3 flex-1">
                                <div class="flex flex-wrap items-center justify-between gap-2 text-xs font-semibold">
                                    <div class="flex items-center gap-1.5 text-on-surface-variant">
                                        <svg class="w-4 h-4 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                                        </svg>
                                        <span>{{ $post->activity_date->translatedFormat('d F Y') }}</span>
                                    </div>

                                    @if($post->project)
                                        <span class="px-2 py-0.5 rounded-full bg-primary-container text-on-primary-container text-[11px] font-semibold truncate max-w-[150px]">
                                            {{ $post->project->title }}
                                        </span>
                                    @endif
                                </div>

                                <h2 class="font-headline font-bold text-lg text-primary text-balance group-hover:text-vibrant-utama-orange transition-colors">
                                    <a href="{{ route('field-posts.show', $post->slug) }}" class="after:content-[''] after:absolute after:inset-0 focus:outline-none">
                                        {{ $post->title }}
                                    </a>
                                </h2>

                                <p class="font-body text-xs sm:text-sm text-on-surface-variant leading-relaxed text-pretty">
                                    {{ $post->summary }}
                                </p>

                                <div class="mt-auto pt-3 flex items-center gap-1 text-xs font-semibold text-primary group-hover:text-vibrant-utama-orange transition-colors">
                                    <span>Baca Artikel Lengkap</span>
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($posts->hasPages())
                    <div class="pt-4">
                        {{ $posts->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
