@props(['contributors'])

<section class="bg-surface border border-outline-variant rounded-xl p-6 flex flex-col gap-4 shadow-xs">
    <a href="#team-showcase-main"
       class="group flex items-center justify-between text-on-surface-variant hover:text-primary transition-colors focus:outline-none focus:ring-2 focus:ring-primary/20 rounded-md py-0.5"
       title="Kembali ke Sorotan Tim Mahasiswa">
        <span class="font-headline text-xs font-semibold tracking-wider uppercase text-on-surface-variant group-hover:text-primary transition-colors">
            Tim Mahasiswa Pengembang
        </span>
        <svg class="w-3.5 h-3.5 text-on-surface-variant/60 group-hover:text-primary transition-transform group-hover:-translate-y-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
        </svg>
    </a>

    <div class="flex flex-col divide-y divide-outline-variant">
        @forelse($contributors as $contributor)
            <div class="group/item flex items-start gap-3 py-3.5 first:pt-0 last:pb-0">
                @if($contributor->avatar_url)
                    <img src="{{ $contributor->avatar_url }}"
                         alt="{{ $contributor->name }}"
                         class="w-11 h-11 rounded-full object-cover border border-outline-variant shrink-0 ring-1 ring-primary/10">
                @else
                    <div class="w-11 h-11 rounded-full bg-primary-container text-on-primary-container font-bold text-sm flex items-center justify-center shrink-0">
                        {{ strtoupper(substr($contributor->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex flex-col gap-1 min-w-0">
                    <span class="font-headline font-semibold text-sm text-primary group-hover/item:text-primary-royal-indigo transition-colors truncate">
                        {{ $contributor->name }}
                    </span>
                    <span class="font-body text-xs text-on-surface-variant tabular-nums leading-tight">
                        NPM {{ $contributor->npm }} &bull; {{ $contributor->major }}{{ $contributor->class_year ? ' (' . $contributor->class_year . ')' : '' }}
                    </span>
                    <span class="self-start inline-flex items-center px-2.5 py-0.5 rounded-md bg-primary-container/70 text-on-primary-container font-body text-[11px] font-semibold mt-0.5">
                        {{ $contributor->role }}
                    </span>
                </div>
            </div>
        @empty
            <p class="font-body text-xs text-on-surface-variant">Belum ada data kontributor mahasiswa.</p>
        @endforelse
    </div>
</section>
