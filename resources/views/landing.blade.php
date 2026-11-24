<x-app-layout>
    <x-hero />

    <x-about />

    <section id="portofolio" data-default-year="{{ $defaultYear ?? 'semua' }}" class="py-16 sm:py-20 lg:py-24 bg-[#e7eaec] scroll-mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-2 max-w-3xl mb-8">
                <h2 class="font-headline font-bold text-2xl sm:text-3xl lg:text-4xl text-primary tracking-tight text-balance">
                    Daftar Portofolio Proyek
                </h2>
                <p class="font-body text-sm sm:text-base text-on-surface-variant leading-relaxed text-pretty">
                    Inovasi sistem informasi dan aplikasi digital terapan hasil riset pengabdian masyarakat dosen dan mahasiswa Universitas Widyatama.
                </p>
            </div>

            @if($projects->isEmpty())
                <x-empty-state
                    icon="project"
                    variant="dashed"
                    title="Belum Ada Proyek Inovasi yang Diterbitkan"
                    description="Portofolio sistem informasi dan aplikasi karya mahasiswa serta dosen Universitas Widyatama akan segera ditampilkan di sini."
                    class="max-w-xl mx-auto"
                />
            @else
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

                <div id="empty-projects-state" class="{{ $visibleProjectCount === 0 ? '' : 'hidden' }} max-w-lg mx-auto">
                    <x-empty-state
                        icon="search"
                        variant="dashed"
                        title="Tidak Ada Proyek yang Ditemukan"
                        description="Tidak ada proyek yang sesuai dengan filter tahun yang dipilih."
                    >
                        <button type="button" 
                                id="empty-reset-btn"
                                class="inline-flex items-center px-4 py-2 rounded-xl bg-primary text-white font-body text-xs font-semibold hover:bg-primary-royal-indigo transition-colors cursor-pointer shadow-xs">
                            Tampilkan Semua Proyek
                        </button>
                    </x-empty-state>
                </div>
            @endif
        </div>
    </section>

    <x-field-notes :posts="$fieldPosts" />
</x-app-layout>
