@props([
    'availableYears' => [],
    'selectedYear' => 'semua',
])

<div class="flex flex-col gap-4 py-2 border-b border-outline-variant pb-6 mb-8">
    <div class="flex flex-wrap items-center gap-2">
        <span class="font-body text-xs sm:text-sm font-semibold text-on-surface-variant mr-1">Tahun:</span>
        
        <button type="button" 
                data-year-filter="semua"
                class="year-filter-btn inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-medium transition-all duration-200 cursor-pointer {{ $selectedYear === 'semua' ? 'bg-primary text-on-primary shadow-xs' : 'border border-outline-variant bg-surface text-on-surface-variant hover:border-primary hover:text-primary' }}">
            Semua Tahun
        </button>

        @foreach($availableYears as $year)
            <button type="button"
                    data-year-filter="{{ $year }}"
                    class="year-filter-btn inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-medium transition-all duration-200 cursor-pointer tabular-nums {{ (string)$selectedYear === (string)$year ? 'bg-primary text-on-primary shadow-xs' : 'border border-outline-variant bg-surface text-on-surface-variant hover:border-primary hover:text-primary' }}">
                {{ $year }}
            </button>
        @endforeach
    </div>
</div>
