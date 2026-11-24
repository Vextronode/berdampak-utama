@props(['project'])

<div class="bg-surface border border-outline-variant rounded-xl overflow-hidden shadow-sm">
    <div class="bg-surface-container px-4 py-3 border-b border-outline-variant flex items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-error/70 inline-block"></span>
            <span class="w-3 h-3 rounded-full bg-warm-gold/70 inline-block"></span>
            <span class="w-3 h-3 rounded-full bg-success/70 inline-block"></span>
        </div>
        <div class="flex-1 max-w-md mx-auto hidden sm:flex items-center justify-center px-3 py-1 rounded-md bg-surface text-on-surface-variant font-mono text-xs border border-outline-variant truncate">
            <svg class="w-3.5 h-3.5 mr-1.5 text-success shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
            <span class="truncate">{{ parse_url($project->live_url, PHP_URL_HOST) ?? ($project->slug . '.desa-cibenda.id') }}</span>
        </div>
        <div class="text-xs font-body font-medium text-on-surface-variant">
            Rasio 16:9
        </div>
    </div>

    <div class="aspect-video bg-surface-variant overflow-hidden relative">
        @if($project->dashboard_thumbnail)
            <img src="{{ $project->dashboard_thumbnail }}" 
                 alt="Tangkapan layar dashboard {{ $project->title }}" 
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex flex-col items-center justify-center p-8 text-center text-on-surface-variant">
                <svg class="w-16 h-16 text-outline mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                </svg>
                <span class="font-body text-sm font-medium">Tampilan Antarmuka Aplikasi {{ $project->title }}</span>
            </div>
        @endif
    </div>
</div>
