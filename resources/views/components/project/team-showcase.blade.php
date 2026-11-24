@props(['contributors'])

@php
    $count = count($contributors);
    $gridClass = match(true) {
        $count === 1 => 'grid-cols-1 max-w-md',
        $count === 2 => 'grid-cols-1 sm:grid-cols-2 max-w-2xl',
        $count === 4 => 'grid-cols-1 sm:grid-cols-2 max-w-3xl',
        default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
    };
@endphp

<section id="team-showcase-main" class="bg-surface border border-outline-variant rounded-2xl p-6 sm:p-8 flex flex-col gap-6 shadow-xs scroll-mt-28">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 border-b border-outline-variant pb-5">
        <div class="flex flex-col gap-1">
            <span class="font-headline text-xs font-semibold tracking-wider text-secondary uppercase">
                Kreator & Pengembang Sistem
            </span>
            <h2 class="font-headline font-bold text-xl sm:text-2xl text-primary">
                Tim Mahasiswa Pengembang
            </h2>
            <p class="font-body text-xs sm:text-sm text-on-surface-variant max-w-xl">
                Mahasiswa perancang arsitektur perangkat lunak, antarmuka, dan pelaksana implementasi teknis di desa mitra.
            </p>
        </div>
        <span class="self-start sm:self-auto inline-flex items-center px-3 py-1 rounded-full bg-surface-container font-mono text-xs font-medium text-on-surface-variant shrink-0 tabular-nums">
            {{ $count }} Mahasiswa
        </span>
    </div>

    <div class="grid {{ $gridClass }} gap-4 sm:gap-6">
        @forelse($contributors as $contributor)
            <div class="group bg-surface-variant/40 hover:bg-surface border border-outline-variant hover:border-primary/40 rounded-xl p-4 flex flex-col gap-4 transition-all duration-200 hover:shadow-md">
                <div class="relative aspect-[4/5] w-full rounded-lg overflow-hidden bg-surface-container border border-outline-variant/60">
                    @if($contributor->avatar_url)
                        <img src="{{ $contributor->avatar_url }}" 
                             alt="{{ $contributor->name }}" 
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-primary-container text-on-primary-container font-headline font-bold text-3xl">
                            {{ strtoupper(substr($contributor->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    <div class="absolute bottom-2.5 left-2.5 right-2.5 flex items-center justify-between pointer-events-none">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-surface/95 backdrop-blur-xs text-primary font-mono text-[11px] font-semibold border border-outline-variant/80 shadow-xs tabular-nums">
                            NPM {{ $contributor->npm }}
                        </span>
                    </div>
                </div>

                <div class="flex flex-col gap-1 min-w-0">
                    <h3 class="font-headline font-bold text-base text-primary leading-snug group-hover:text-primary-royal-indigo transition-colors truncate">
                        {{ $contributor->name }}
                    </h3>
                    <p class="font-body text-xs text-on-surface-variant font-medium">
                        {{ $contributor->major }}
                    </p>
                </div>

                <div class="mt-auto pt-3 border-t border-outline-variant/60">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-primary-container/70 text-on-primary-container font-body text-xs font-semibold">
                        {{ $contributor->role }}
                    </span>
                </div>
            </div>
        @empty
            <p class="font-body text-sm text-on-surface-variant">Belum ada data mahasiswa pengembang.</p>
        @endforelse
    </div>
</section>
