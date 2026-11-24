@props([
    'availableYears' => [],
    'selectedYear' => 'semua',
])

@php
    $baseClass = 'year-filter-btn inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-medium transition-all duration-200 cursor-pointer';
    $activeClass = 'bg-primary text-white border border-primary shadow-xs hover:bg-primary-royal-indigo hover:text-white';
    $inactiveClass = 'border border-outline-variant bg-surface text-on-surface-variant hover:border-primary hover:text-primary hover:bg-surface-variant';
@endphp

<div class="flex flex-col gap-4 py-2 border-b border-outline-variant pb-6 mb-8">
    <div class="flex flex-wrap items-center gap-2">
        <span class="font-body text-xs sm:text-sm font-semibold text-on-surface-variant mr-1">Tahun:</span>
        
        <button type="button" 
                data-year-filter="semua"
                aria-pressed="{{ $selectedYear === 'semua' ? 'true' : 'false' }}"
                class="{{ $baseClass }} {{ $selectedYear === 'semua' ? $activeClass : $inactiveClass }}">
            Semua Tahun
        </button>

        @foreach($availableYears as $year)
            <button type="button"
                    data-year-filter="{{ $year }}"
                    aria-pressed="{{ (string)$selectedYear === (string)$year ? 'true' : 'false' }}"
                    class="{{ $baseClass }} tabular-nums {{ (string)$selectedYear === (string)$year ? $activeClass : $inactiveClass }}">
                {{ $year }}
            </button>
        @endforeach
    </div>
</div>
