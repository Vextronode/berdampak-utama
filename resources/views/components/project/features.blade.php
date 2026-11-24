@props(['features'])

@if(!empty($features))
<section class="bg-surface border border-outline-variant rounded-xl p-6 sm:p-8 flex flex-col gap-6">
    <h2 class="font-headline font-bold text-xl sm:text-2xl text-primary">
        Fitur Kunci Sistem
    </h2>

    <ul class="flex flex-col gap-5">
        @foreach($features as $feature)
            <li class="flex items-start gap-4">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-primary-container text-on-primary-container shrink-0 mt-0.5">
                    <x-feature-icon :icon="$feature['icon'] ?? 'check'" class="w-5 h-5" />
                </span>
                <div class="flex flex-col gap-1">
                    <h3 class="font-headline font-semibold text-base sm:text-lg text-primary">
                        {{ $feature['title'] }}
                    </h3>
                    @if(!empty($feature['description']))
                        <p class="font-body text-sm text-on-surface-variant leading-relaxed">
                            {{ $feature['description'] }}
                        </p>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</section>
@endif
