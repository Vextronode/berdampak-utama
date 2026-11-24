<x-app-layout>
    <x-hero />

    <x-about />

    <section id="portofolio" class="py-16 sm:py-20 lg:py-24 bg-[#e7eaec] scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-2 max-w-3xl mb-8">
                <h2 class="font-headline font-bold text-2xl sm:text-3xl lg:text-4xl text-primary tracking-tight text-balance">
                    Daftar Portofolio Proyek
                </h2>
                <p class="font-body text-sm sm:text-base text-on-surface-variant leading-relaxed text-pretty">
                    Inovasi sistem informasi dan aplikasi digital terapan hasil riset pengabdian masyarakat dosen dan mahasiswa Universitas Widyatama.
                </p>
            </div>

            <x-filter-bar 
                :available-years="$availableYears"
                :selected-year="$selectedYear" />

            @php
                $visibleProjectCount = $projects->filter(function ($project) use ($selectedYear) {
                    return $selectedYear === 'semua' || (string) $project->year === (string) $selectedYear;
                })->count();
            @endphp

            <div id="projects-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 items-stretch {{ $visibleProjectCount === 0 ? 'hidden' : '' }}">
                @foreach($projects as $project)
                    @php
                        $isHidden = $selectedYear !== 'semua' && (string) $project->year !== (string) $selectedYear;
                    @endphp
                    <x-project-card :project="$project" :is-hidden="$isHidden" />
                @endforeach
            </div>

            <div id="empty-projects-state" class="{{ $visibleProjectCount === 0 ? '' : 'hidden' }} py-16 px-4 text-center rounded-xl border border-dashed border-outline bg-surface-variant max-w-lg mx-auto flex flex-col items-center gap-3">
                <svg class="w-12 h-12 text-outline" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <h3 class="font-headline font-bold text-lg text-primary">Tidak Ada Proyek yang Ditemukan</h3>
                <p class="font-body text-sm text-on-surface-variant">
                    Tidak ada proyek yang sesuai dengan filter tahun yang dipilih.
                </p>
                <button type="button" 
                        id="empty-reset-btn"
                        class="mt-2 inline-flex items-center px-4 py-2 rounded-lg bg-primary text-on-primary font-body text-xs font-semibold hover:bg-primary-royal-indigo transition-colors cursor-pointer">
                    Tampilkan Semua Proyek
                </button>
            </div>
        </div>
    </section>

    <x-field-notes :posts="$fieldPosts" />

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterBtns = document.querySelectorAll('.year-filter-btn');
            const cards = document.querySelectorAll('.project-card');
            const emptyState = document.getElementById('empty-projects-state');
            const grid = document.getElementById('projects-grid');
            const emptyResetBtn = document.getElementById('empty-reset-btn');

            const activeClasses = ['bg-primary', 'text-white', 'border', 'border-primary', 'shadow-xs', 'hover:bg-primary-royal-indigo', 'hover:text-white'];
            const inactiveClasses = ['border', 'border-outline-variant', 'bg-surface', 'text-on-surface-variant', 'hover:border-primary', 'hover:text-primary', 'hover:bg-surface-variant'];

            const defaultYear = @json($defaultYear ?? 'semua');

            function applyFilter(year, updateUrl = true) {
                let visibleCount = 0;

                filterBtns.forEach(btn => {
                    const isMatch = btn.getAttribute('data-year-filter') === String(year);
                    btn.setAttribute('aria-pressed', isMatch ? 'true' : 'false');
                    if (isMatch) {
                        inactiveClasses.forEach(cls => btn.classList.remove(cls));
                        activeClasses.forEach(cls => btn.classList.add(cls));
                    } else {
                        activeClasses.forEach(cls => btn.classList.remove(cls));
                        inactiveClasses.forEach(cls => btn.classList.add(cls));
                    }
                });

                cards.forEach(card => {
                    const cardYear = card.getAttribute('data-year');
                    const show = (year === 'semua' || String(cardYear) === String(year));
                    if (show) {
                        card.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                if (emptyState) {
                    emptyState.classList.toggle('hidden', visibleCount > 0);
                }
                if (grid) {
                    grid.classList.toggle('hidden', visibleCount === 0);
                }

                if (updateUrl) {
                    const newUrl = String(year) === String(defaultYear)
                        ? window.location.pathname
                        : window.location.pathname + '?year=' + encodeURIComponent(year);
                    window.history.replaceState(null, '', newUrl);
                }
            }

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const year = this.getAttribute('data-year-filter');
                    applyFilter(year, true);
                });
            });

            if (emptyResetBtn) {
                emptyResetBtn.addEventListener('click', function () {
                    applyFilter('semua', true);
                });
            }

            const urlParams = new URLSearchParams(window.location.search);
            const initialYear = urlParams.get('year');
            if (initialYear) {
                applyFilter(initialYear, false);
            }
        });
    </script>
</x-app-layout>
