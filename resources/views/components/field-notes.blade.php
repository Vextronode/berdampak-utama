@props(['posts'])

<section id="catatan-lapangan" class="bg-surface-variant border-t border-outline-variant py-16 sm:py-20 lg:py-24 scroll-mt-16 sm:scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-10">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div class="flex flex-col gap-2 max-w-2xl">
                <h2 class="font-headline font-bold text-2xl sm:text-3xl text-primary text-balance">
                    Catatan Lapangan & Dokumentasi Tim
                </h2>
                <p class="font-body text-sm sm:text-base text-on-surface-variant text-pretty leading-relaxed">
                    Dokumentasi foto dan cerita kegiatan mahasiswa serta dosen saat melatih perangkat desa dan mempresentasikan aplikasi di balai desa mitra.
                </p>
            </div>

            <a href="#catatan-lapangan" 
               data-scroll-to="catatan-lapangan"
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg border border-primary text-primary bg-surface font-body text-sm font-semibold hover:bg-primary-container focus:outline-none focus:ring-2 focus:ring-primary transition-colors self-start lg:self-auto shadow-xs cursor-pointer">
                <span>Lihat Semua Catatan Kegiatan</span>
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 items-stretch">
            @forelse($posts as $post)
                <article class="bg-surface border border-outline-variant rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col h-full group">
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
                        <div class="flex items-center gap-2 text-on-surface-variant text-xs font-semibold">
                            <svg class="w-4 h-4 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                            </svg>
                            <span>{{ $post->activity_date->translatedFormat('F Y') }}</span>
                        </div>

                        <h3 class="font-headline font-bold text-lg text-primary text-balance group-hover:text-vibrant-utama-orange transition-colors">
                            {{ $post->title }}
                        </h3>

                        <p class="font-body text-xs sm:text-sm text-on-surface-variant leading-relaxed text-pretty">
                            {{ $post->summary }}
                        </p>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-12 text-center text-on-surface-variant font-body text-sm bg-surface rounded-xl border border-outline-variant">
                    Belum ada dokumentasi catatan lapangan yang dipublikasikan.
                </div>
            @endforelse
        </div>
    </div>
</section>
