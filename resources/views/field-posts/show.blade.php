<x-app-layout :title="$post->title . ' - Catatan Lapangan | Berdampak Utama'">
    <div class="bg-surface-variant/40 min-h-screen py-10 lg:py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-8">
            <!-- Breadcrumb -->
            <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-2 text-xs font-medium text-on-surface-variant">
                <a href="{{ route('landing') }}" class="hover:text-primary transition-colors">Beranda</a>
                <span class="text-outline">/</span>
                <a href="{{ route('field-posts.index') }}" class="hover:text-primary transition-colors">Catatan Lapangan</a>
                <span class="text-outline">/</span>
                <span class="text-primary font-semibold truncate max-w-xs sm:max-w-md">{{ $post->title }}</span>
            </nav>

            <!-- Article Container -->
            <article class="bg-surface border border-outline-variant rounded-2xl overflow-hidden shadow-xs">
                @if($post->cover_image)
                    <div class="aspect-video w-full bg-surface-container overflow-hidden border-b border-outline-variant">
                        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-6 sm:p-10 lg:p-12 flex flex-col gap-6">
                    <!-- Meta Chips -->
                    <div class="flex flex-wrap items-center gap-2.5 text-xs">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container text-on-surface-container font-semibold">
                            <svg class="w-3.5 h-3.5 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                            </svg>
                            <span>{{ $post->activity_date->translatedFormat('d F Y') }}</span>
                        </span>

                        @if($post->project && $post->project->is_published)
                            <a href="{{ route('projects.show', $post->project->slug) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary-container text-on-primary-container font-semibold hover:bg-primary hover:text-white transition-colors">
                                <span>Program: {{ $post->project->title }}</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </a>
                        @endif
                    </div>

                    <!-- Headline & Lead Summary -->
                    <header class="flex flex-col gap-3 border-b border-outline-variant pb-6">
                        <h1 class="font-headline font-bold text-2xl sm:text-3xl lg:text-4xl text-primary tracking-tight leading-tight text-balance">
                            {{ $post->title }}
                        </h1>
                        @if($post->summary)
                            <p class="font-body text-base sm:text-lg text-on-surface-variant leading-relaxed text-pretty">
                                {{ $post->summary }}
                            </p>
                        @endif
                    </header>

                    <!-- Article Content -->
                    <div class="prose max-w-none font-body text-sm sm:text-base text-on-surface leading-loose space-y-4">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <!-- Related Project Card inside Article -->
                    @if($post->project && $post->project->is_published)
                        <div class="mt-4 p-5 rounded-xl bg-surface-variant border border-outline-variant flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-[11px] font-semibold uppercase tracking-wider text-secondary">Proyek Terkait Kegiatan Ini</span>
                                <h2 class="font-headline font-bold text-base text-primary">{{ $post->project->title }}</h2>
                                <p class="text-xs text-on-surface-variant">{{ $post->project->partner_name }} &bull; Tahun {{ $post->project->year }}</p>
                            </div>
                            <a href="{{ route('projects.show', $post->project->slug) }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary-royal-indigo transition-colors shadow-xs shrink-0 whitespace-nowrap">
                                <span>Lihat Detail Proyek</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </article>

            <!-- Navigation Footer -->
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('field-posts.index') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-primary hover:text-vibrant-utama-orange transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    <span>Lihat Semua Catatan Lapangan</span>
                </a>
                <a href="{{ route('landing') }}" class="text-xs sm:text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors">
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Related Articles -->
            @if($relatedPosts->isNotEmpty())
                <section class="border-t border-outline-variant pt-10 flex flex-col gap-6">
                    <h2 class="font-headline font-bold text-xl text-primary">Catatan Lapangan Lainnya</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @foreach($relatedPosts as $rel)
                            <article class="relative cursor-pointer bg-surface border border-outline-variant hover:border-primary/40 rounded-xl overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col group">
                                <div class="aspect-video bg-surface-container overflow-hidden border-b border-outline-variant">
                                    @if($rel->cover_image)
                                        <img src="{{ $rel->cover_image }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @endif
                                </div>
                                <div class="p-4 flex flex-col gap-1.5 flex-1">
                                    <span class="text-[11px] font-semibold text-on-surface-variant">{{ $rel->activity_date->translatedFormat('d F Y') }}</span>
                                    <h3 class="font-headline font-semibold text-sm text-primary group-hover:text-vibrant-utama-orange transition-colors line-clamp-2">
                                        <a href="{{ route('field-posts.show', $rel->slug) }}" class="after:content-[''] after:absolute after:inset-0">
                                            {{ $rel->title }}
                                        </a>
                                    </h3>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
</x-app-layout>
