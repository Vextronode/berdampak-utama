@props([
    'title',
    'description',
    'icon' => 'document',
    'variant' => 'default',
])

<div {{ $attributes->merge([
    'class' => ($variant === 'dashed'
        ? 'bg-surface border border-dashed border-outline rounded-2xl'
        : 'bg-surface border border-outline-variant rounded-2xl shadow-xs')
        . ' px-6 py-12 sm:py-14 text-center flex flex-col items-center justify-center gap-3.5'
]) }}>
    <div class="w-14 h-14 rounded-2xl bg-primary-container/60 text-primary flex items-center justify-center shrink-0">
        @if($icon === 'project')
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
            </svg>
        @elseif($icon === 'search')
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        @else
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
            </svg>
        @endif
    </div>

    <div class="flex flex-col gap-1.5 max-w-md">
        <h3 class="font-headline font-bold text-base sm:text-lg text-primary text-balance">
            {{ $title }}
        </h3>
        <p class="font-body text-xs sm:text-sm text-on-surface-variant leading-relaxed text-pretty">
            {{ $description }}
        </p>
    </div>

    @if(trim($slot) !== '')
        <div class="pt-1 flex flex-wrap items-center justify-center gap-2.5">
            {{ $slot }}
        </div>
    @endif
</div>
