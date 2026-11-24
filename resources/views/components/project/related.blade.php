@props(['relatedProjects'])

@if($relatedProjects->isNotEmpty())
<section class="border-t border-outline-variant pt-12 mt-12 flex flex-col gap-6">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
        <div>
            <h2 class="font-headline font-bold text-2xl text-primary">
                Karya Inovasi Lainnya
            </h2>
            <p class="font-body text-sm text-on-surface-variant">
                Lihat sistem informasi dan aplikasi terapan lainnya dari program Kampus Berdampak.
            </p>
        </div>
        <a href="{{ route('landing') }}#portofolio" class="text-sm font-semibold text-primary hover:text-vibrant-utama-orange transition-colors shrink-0">
            Lihat Semua Proyek &rarr;
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($relatedProjects as $rel)
            <div class="bg-surface border border-outline-variant rounded-xl p-5 flex flex-col justify-between gap-4 hover:shadow-md transition-shadow">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full bg-primary-container text-on-primary-container font-body text-xs font-semibold tabular-nums">
                            {{ $rel->year }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full bg-diktisaintek-container text-on-diktisaintek-container font-body text-xs font-semibold">
                            {{ $rel->partner_name }}
                        </span>
                    </div>
                    <h3 class="font-headline font-bold text-lg text-primary">
                        {{ $rel->title }}
                    </h3>
                    <p class="font-body text-sm text-on-surface-variant line-clamp-2">
                        {{ $rel->summary }}
                    </p>
                </div>
                <a href="{{ route('projects.show', $rel->slug) }}" 
                   class="inline-flex items-center justify-center px-4 py-2 rounded-lg border border-primary text-primary font-body text-xs font-semibold hover:bg-primary-container hover:text-on-primary-container transition-colors text-center self-start">
                    Buka Detail Proyek &rarr;
                </a>
            </div>
        @endforeach
    </div>
</section>
@endif
