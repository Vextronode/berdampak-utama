@props(['project', 'isHidden' => false])

<article data-year="{{ $project->year }}" class="project-card {{ $isHidden ? 'hidden' : '' }} bg-surface border border-outline-variant rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between h-full group">
    <div class="aspect-video bg-surface-container overflow-hidden border-b border-outline-variant relative">
        @if($project->dashboard_thumbnail)
            <img src="{{ $project->dashboard_thumbnail }}" 
                 alt="Tangkapan layar dashboard {{ $project->title }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full flex flex-col items-center justify-center bg-surface-variant text-on-surface-variant p-4 text-center">
                <svg class="w-12 h-12 text-outline mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                </svg>
                <span class="font-body text-xs font-medium">Dashboard Preview 16:9</span>
            </div>
        @endif
    </div>

    <div class="p-6 flex flex-col gap-3 flex-1">
        <header class="flex flex-col gap-2">
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center px-3 py-0.5 rounded-full bg-primary-container text-on-primary-container font-body text-xs font-semibold tabular-nums">
                    {{ $project->year }}
                </span>
                <span class="inline-flex items-center px-3 py-0.5 rounded-full bg-diktisaintek-container text-on-diktisaintek-container font-body text-xs font-semibold">
                    {{ $project->partner_name }}
                </span>
            </div>
            <h3 class="font-headline font-bold text-xl text-primary group-hover:text-vibrant-utama-orange transition-colors">
                {{ $project->title }}
            </h3>
        </header>

        <p class="font-body text-sm text-on-surface-variant leading-relaxed text-pretty">
            {{ $project->summary }}
        </p>

        <div class="pt-4 mt-auto border-t border-outline-variant flex flex-col gap-2.5">
            <div class="flex items-center -space-x-2 overflow-hidden">
                @foreach($project->contributors as $contributor)
                    @if($contributor->avatar_url)
                        <img src="{{ $contributor->avatar_url }}" 
                             alt="{{ $contributor->name }}" 
                             title="{{ $contributor->name }} ({{ $contributor->role }})"
                             class="inline-block w-8 h-8 rounded-full object-cover ring-2 ring-surface">
                    @else
                        <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-container text-on-primary-container font-bold text-xs ring-2 ring-surface"
                             title="{{ $contributor->name }} ({{ $contributor->role }})">
                            {{ strtoupper(substr($contributor->name, 0, 1)) }}
                        </div>
                    @endif
                @endforeach
            </div>

            <p class="font-body text-xs text-on-surface-variant leading-relaxed">
                <strong class="font-semibold text-on-surface">Kontributor:</strong>
                @foreach($project->contributors as $index => $c)
                    <span>{{ $c->name }} (NPM: {{ $c->npm }} - {{ $c->major }}){{ !$loop->last ? ',' : '' }}</span>
                @endforeach
            </p>
        </div>
    </div>

    <footer class="px-6 pb-6 pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
        <a href="{{ route('projects.show', $project->slug) }}" 
           class="flex-1 inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-primary text-primary font-body text-sm font-semibold hover:bg-primary-container hover:text-on-primary-container transition-colors text-center">
            Lihat Detail Proyek
        </a>
        @if($project->live_url)
            <a href="{{ $project->live_url }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-lg bg-vibrant-utama-orange text-white font-body text-sm font-semibold hover:bg-secondary transition-colors text-center shadow-xs">
                <span>Kunjungi Web</span>
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        @endif
    </footer>
</article>
