<x-apanel-layout title="Dasbor Pengelola">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8 lg:py-10">
        <!-- Header & Primary Action -->
        <section class="flex flex-col gap-2 mb-8">
            <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-1.5 text-xs text-on-surface-variant font-medium">
                <span>Admin</span>
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span class="text-primary font-semibold">Dasbor Pengelola</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="font-['Poppins'] text-2xl lg:text-3xl font-bold text-primary tracking-tight">
                        Selamat Datang, {{ $user->name }}
                    </h1>
                    <p class="text-sm text-on-surface-variant max-w-3xl leading-relaxed mt-1">
                        Kelola katalog proyek inovasi, perbarui dokumentasi serta tim mahasiswa, dan atur status penayangan publik.
                    </p>
                </div>
                <a href="{{ route('apanel.projects.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-vibrant-utama-orange text-white text-xs font-semibold shadow-xs hover:bg-secondary transition-colors duration-150 self-start sm:self-center shrink-0 whitespace-nowrap">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Tambah Proyek Baru</span>
                </a>
            </div>
        </section>

        <!-- Summary KPI Cards -->
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
            <div class="bg-surface border border-outline-variant rounded-2xl p-5 shadow-xs flex flex-col justify-between gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Total Proyek</span>
                    <div class="w-9 h-9 rounded-xl bg-primary-container text-primary flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between gap-3">
                    <div class="text-3xl font-bold text-primary font-['Poppins'] tabular-nums">{{ $projectCount }}</div>
                    <div class="flex items-center gap-1.5 text-[11px] font-semibold">
                        <span class="px-2 py-0.5 rounded-full bg-success-container text-on-success-container tabular-nums">{{ $publishedCount }} Tayang</span>
                        @if($draftCount > 0)
                            <span class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant tabular-nums">{{ $draftCount }} Draft</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-surface border border-outline-variant rounded-2xl p-5 shadow-xs flex flex-col justify-between gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Mahasiswa Pengembang</span>
                    <div class="w-9 h-9 rounded-xl bg-diktisaintek-container text-on-diktisaintek-container flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between gap-3">
                    <div class="text-3xl font-bold text-primary font-['Poppins'] tabular-nums">{{ $contributorCount }}</div>
                    <p class="text-xs text-on-surface-variant">Kontributor terverifikasi NPM</p>
                </div>
            </div>

            <div class="bg-surface border border-outline-variant rounded-2xl p-5 shadow-xs flex flex-col justify-between gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Catatan Lapangan</span>
                    <div class="w-9 h-9 rounded-xl bg-tertiary-container text-on-tertiary-container flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between gap-3">
                    <div class="text-3xl font-bold text-primary font-['Poppins'] tabular-nums">{{ $fieldPostCount }}</div>
                    <p class="text-xs text-on-surface-variant">Dokumentasi desa mitra terbit</p>
                </div>
            </div>
        </section>

        <!-- Main Project Management Workspace -->
        <section class="bg-surface border border-outline-variant rounded-2xl shadow-xs overflow-hidden">
            <!-- Header & Filter Toolbar -->
            <div class="p-5 lg:p-6 border-b border-outline-variant flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <h2 class="font-['Poppins'] font-semibold text-base lg:text-lg text-primary">Daftar Proyek Terdaftar</h2>
                    <span id="visible-project-badge" class="px-2.5 py-0.5 rounded-full bg-primary-container text-on-primary-container font-mono text-xs font-semibold tabular-nums">
                        {{ $projectCount }} Proyek
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <!-- Search Input -->
                    <div class="relative flex-1 sm:w-64">
                        <input type="text" id="dashboard-project-search" placeholder="Cari judul, desa, kategori..." class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-outline-variant bg-surface-variant text-on-surface text-xs placeholder:text-on-surface-variant/60 focus:bg-surface focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                        <svg class="w-4 h-4 text-on-surface-variant absolute left-3 top-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>

                    <!-- Year Filter -->
                    <select id="dashboard-year-filter" class="px-3 py-2 rounded-xl border border-outline-variant bg-surface text-on-surface text-xs font-medium focus:border-primary focus:ring-1 focus:ring-primary shadow-xs cursor-pointer">
                        <option value="all">Semua Tahun</option>
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}">Tahun {{ $year }}</option>
                        @endforeach
                    </select>

                    <!-- Status Filter -->
                    <select id="dashboard-status-filter" class="px-3 py-2 rounded-xl border border-outline-variant bg-surface text-on-surface text-xs font-medium focus:border-primary focus:ring-1 focus:ring-primary shadow-xs cursor-pointer">
                        <option value="all">Semua Status</option>
                        <option value="published">Tayang</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            @if($projects->isEmpty())
                <!-- Empty Database State -->
                <div class="p-12 text-center flex flex-col items-center justify-center gap-3">
                    <div class="w-14 h-14 rounded-2xl bg-surface-container text-outline flex items-center justify-center">
                        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <h3 class="font-['Poppins'] font-semibold text-base text-primary">Belum Ada Proyek Terdaftar</h3>
                    <p class="text-xs text-on-surface-variant max-w-md">Mulai tambahkan karya aplikasi mahasiswa Universitas Widyatama untuk ditampilkan di katalog Berdampak Utama.</p>
                    <a href="{{ route('apanel.projects.create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-vibrant-utama-orange text-white text-xs font-semibold hover:bg-secondary transition-colors shadow-xs">
                        <span>Tambah Proyek Pertama</span>
                    </a>
                </div>
            @else
                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-outline-variant bg-surface-variant/60 text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">
                                <th class="py-3.5 pl-6 pr-4">Proyek & Kategori</th>
                                <th class="py-3.5 px-4">Tahun & Mitra</th>
                                <th class="py-3.5 px-4">Tim & Teknologi</th>
                                <th class="py-3.5 px-4">Status</th>
                                <th class="py-3.5 pl-4 pr-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="projects-table-body" class="divide-y divide-outline-variant text-sm">
                            @foreach ($projects as $project)
                                @php
                                    $searchHaystack = strtolower($project->title . ' ' . $project->slug . ' ' . $project->partner_name . ' ' . $project->category);
                                    $statusKey = $project->is_published ? 'published' : 'draft';
                                @endphp
                                <tr class="project-row-item hover:bg-surface-variant/50 transition-colors"
                                    data-search="{{ $searchHaystack }}"
                                    data-year="{{ $project->year }}"
                                    data-status="{{ $statusKey }}">
                                    <!-- Proyek & Kategori -->
                                    <td class="py-4 pl-6 pr-4 align-middle">
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-20 h-12 rounded-lg overflow-hidden bg-surface-container border border-outline-variant shrink-0 flex items-center justify-center">
                                                @if($project->dashboard_thumbnail)
                                                    <img src="{{ $project->dashboard_thumbnail }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-5 h-5 text-outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                                        <line x1="8" y1="21" x2="16" y2="21"></line>
                                                        <line x1="12" y1="17" x2="12" y2="21"></line>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex flex-col gap-1 min-w-0">
                                                <span class="font-['Poppins'] font-semibold text-sm text-primary truncate max-w-xs" title="{{ $project->title }}">
                                                    {{ $project->title }}
                                                </span>
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="font-mono text-[11px] text-on-surface-variant">/proyek/{{ $project->slug }}</span>
                                                    <span class="text-outline">&bull;</span>
                                                    <span class="text-[11px] text-on-surface-variant truncate max-w-[180px]" title="{{ $project->category }}">{{ $project->category }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Tahun & Mitra -->
                                    <td class="py-4 px-4 align-middle">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-primary-container text-on-primary-container font-mono text-[11px] font-semibold tabular-nums">
                                                    {{ $project->year }}
                                                </span>
                                                <span class="text-xs font-medium text-on-surface truncate max-w-[180px]" title="{{ $project->partner_name }}">
                                                    {{ $project->partner_name }}
                                                </span>
                                            </div>
                                            @if($project->supervisor_name)
                                                <span class="text-[11px] text-on-surface-variant truncate max-w-[220px]">
                                                    Pembimbing: {{ $project->supervisor_name }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Tim & Tech Stack -->
                                    <td class="py-4 px-4 align-middle">
                                        <div class="flex flex-col gap-2">
                                            <div class="flex items-center gap-2">
                                                @if($project->contributors->isNotEmpty())
                                                    <div class="flex items-center -space-x-1.5">
                                                        @foreach($project->contributors->take(3) as $c)
                                                            @if($c->avatar_url)
                                                                <img src="{{ $c->avatar_url }}" alt="{{ $c->name }}" title="{{ $c->name }}" class="w-6 h-6 rounded-full object-cover ring-2 ring-surface">
                                                            @else
                                                                <div class="w-6 h-6 rounded-full bg-primary-container text-on-primary-container text-[10px] font-bold flex items-center justify-center ring-2 ring-surface" title="{{ $c->name }}">
                                                                    {{ strtoupper(substr($c->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <span class="text-xs text-on-surface-variant tabular-nums">
                                                    {{ $project->contributors->count() }} Mahasiswa
                                                </span>
                                            </div>

                                            @if($project->techStackItems->isNotEmpty())
                                                <div class="flex items-center gap-1.5">
                                                    @foreach($project->techStackItems->take(4) as $stack)
                                                        <span title="{{ $stack->name }}" class="inline-flex items-center justify-center w-6 h-6 rounded-md bg-surface-container border border-outline-variant p-1">
                                                            <x-tech-stack-icon :stack="$stack" class="w-4 h-4" />
                                                        </span>
                                                    @endforeach
                                                    @if($project->techStackItems->count() > 4)
                                                        <span class="text-[11px] font-mono text-on-surface-variant">+{{ $project->techStackItems->count() - 4 }}</span>
                                                    @endif
                                                </div>
                                            @elseif(!empty($project->tech_stacks))
                                                <div class="flex flex-wrap items-center gap-1">
                                                    @foreach(array_slice($project->tech_stacks, 0, 3) as $tName)
                                                        <span class="px-1.5 py-0.5 rounded bg-surface-container text-[10px] font-medium text-on-surface-variant">{{ $tName }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Status Toggle -->
                                    <td class="py-4 px-4 align-middle">
                                        <form action="{{ route('apanel.projects.toggle-publish', $project) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                title="{{ $project->is_published ? 'Klik untuk ubah ke Draft' : 'Klik untuk Tayangkan ke Publik' }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition-colors cursor-pointer {{ $project->is_published ? 'bg-success-container text-on-success-container hover:bg-success/20 border border-success/30' : 'bg-surface-container text-on-surface-variant hover:bg-outline-variant border border-outline-variant' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $project->is_published ? 'bg-success' : 'bg-outline' }}"></span>
                                                <span>{{ $project->is_published ? 'Tayang' : 'Draft' }}</span>
                                            </button>
                                        </form>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-4 pl-4 pr-6 align-middle text-right">
                                        <div class="inline-flex items-center justify-end gap-1.5">
                                            @if($project->is_published)
                                                <a href="{{ route('projects.show', $project->slug) }}" target="_blank" title="Buka Halaman Publik" class="inline-flex items-center justify-center p-2 rounded-lg border border-outline-variant bg-surface text-on-surface-variant hover:text-primary hover:border-primary/40 transition-colors">
                                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                        <polyline points="15 3 21 3 21 9"></polyline>
                                                        <line x1="10" y1="14" x2="21" y2="3"></line>
                                                    </svg>
                                                </a>
                                            @endif

                                            <a href="{{ route('apanel.projects.edit', $project) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-primary/30 bg-primary-container/20 text-primary text-xs font-semibold hover:bg-primary-container/40 transition-colors whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                </svg>
                                                <span>Edit</span>
                                            </a>

                                            <button type="button"
                                                data-delete-url="{{ route('apanel.projects.destroy', $project) }}"
                                                data-project-title="{{ $project->title }}"
                                                class="btn-open-delete-modal inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-error/30 bg-error-container/30 text-error text-xs font-semibold hover:bg-error-container transition-colors cursor-pointer whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div id="projects-mobile-list" class="md:hidden divide-y divide-outline-variant">
                    @foreach ($projects as $project)
                        @php
                            $searchHaystack = strtolower($project->title . ' ' . $project->slug . ' ' . $project->partner_name . ' ' . $project->category);
                            $statusKey = $project->is_published ? 'published' : 'draft';
                        @endphp
                        <div class="project-mobile-item p-4 flex flex-col gap-3"
                             data-search="{{ $searchHaystack }}"
                             data-year="{{ $project->year }}"
                             data-status="{{ $statusKey }}">
                            <div class="flex items-start gap-3">
                                <div class="w-20 h-12 rounded-lg overflow-hidden bg-surface-container border border-outline-variant shrink-0 flex items-center justify-center">
                                    @if($project->dashboard_thumbnail)
                                        <img src="{{ $project->dashboard_thumbnail }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                            <line x1="8" y1="21" x2="16" y2="21"></line>
                                            <line x1="12" y1="17" x2="12" y2="21"></line>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="px-2 py-0.5 rounded bg-primary-container text-on-primary-container font-mono text-[10px] font-semibold">{{ $project->year }}</span>
                                        <form action="{{ route('apanel.projects.toggle-publish', $project) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $project->is_published ? 'bg-success-container text-on-success-container' : 'bg-surface-container text-on-surface-variant' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $project->is_published ? 'bg-success' : 'bg-outline' }}"></span>
                                                <span>{{ $project->is_published ? 'Tayang' : 'Draft' }}</span>
                                            </button>
                                        </form>
                                    </div>
                                    <h3 class="font-['Poppins'] font-semibold text-sm text-primary mt-1 truncate">{{ $project->title }}</h3>
                                    <p class="text-xs text-on-surface-variant truncate">{{ $project->partner_name }} &bull; {{ $project->contributors->count() }} Mahasiswa</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 pt-1">
                                @if($project->is_published)
                                    <a href="{{ route('projects.show', $project->slug) }}" target="_blank" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-outline-variant bg-surface text-xs font-semibold text-on-surface-variant">
                                        <span>Lihat</span>
                                    </a>
                                @endif
                                <a href="{{ route('apanel.projects.edit', $project) }}" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-primary/30 bg-primary-container/20 text-xs font-semibold text-primary">
                                    <span>Edit</span>
                                </a>
                                <button type="button"
                                    data-delete-url="{{ route('apanel.projects.destroy', $project) }}"
                                    data-project-title="{{ $project->title }}"
                                    class="btn-open-delete-modal flex-1 inline-flex items-center justify-center gap-1 px-3 py-2 rounded-lg border border-error/30 bg-error-container/30 text-xs font-semibold text-error">
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Empty Search / Filter State -->
                <div id="dashboard-empty-filter" class="hidden p-10 text-center flex flex-col items-center justify-center gap-2">
                    <p class="font-['Poppins'] font-semibold text-sm text-primary">Tidak ada proyek yang cocok dengan filter pencarian</p>
                    <p class="text-xs text-on-surface-variant">Coba ubah kata kunci pencarian, pilihan tahun, atau filter status.</p>
                    <button type="button" id="btn-reset-dashboard-filter" class="mt-2 px-4 py-1.5 rounded-lg border border-primary text-primary text-xs font-semibold hover:bg-primary-container/20 transition-colors cursor-pointer">
                        Reset Filter
                    </button>
                </div>
            @endif
        </section>
    </div>

    <!-- Modal Konfirmasi Hapus Proyek -->
    <div id="delete-project-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-primary-navy-blue/60 backdrop-blur-xs">
        <div class="bg-surface rounded-2xl border border-outline-variant shadow-xl max-w-md w-full p-6 flex flex-col gap-4">
            <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-error-container text-error flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <div class="flex flex-col gap-1">
                    <h3 class="font-['Poppins'] font-semibold text-base text-on-surface">Hapus Proyek Ini?</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Proyek <strong id="delete-modal-project-name" class="text-on-surface font-semibold"></strong> beserta seluruh data kontributor mahasiswa, thumbnail, dan foto galeri akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>

            <form id="delete-project-form" method="POST" action="" class="flex items-center justify-end gap-2.5 pt-2 border-t border-outline-variant">
                @csrf
                @method('DELETE')
                <button type="button" id="btn-cancel-delete-modal" class="px-4 py-2 rounded-xl border border-outline-variant bg-surface text-xs font-semibold text-on-surface-variant hover:bg-surface-variant transition-colors cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-error text-white text-xs font-semibold hover:bg-error/90 transition-colors shadow-xs cursor-pointer">
                    Ya, Hapus Proyek
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        (function () {
            // Live Filtering on Dashboard
            const searchInput = document.getElementById('dashboard-project-search');
            const yearFilter = document.getElementById('dashboard-year-filter');
            const statusFilter = document.getElementById('dashboard-status-filter');
            const desktopRows = document.querySelectorAll('.project-row-item');
            const mobileRows = document.querySelectorAll('.project-mobile-item');
            const emptyBox = document.getElementById('dashboard-empty-filter');
            const resetBtn = document.getElementById('btn-reset-dashboard-filter');
            const visibleBadge = document.getElementById('visible-project-badge');

            function filterProjects() {
                const q = (searchInput ? searchInput.value : '').toLowerCase().trim();
                const year = yearFilter ? yearFilter.value : 'all';
                const status = statusFilter ? statusFilter.value : 'all';

                let desktopVisible = 0;

                const applyToNodes = (nodes, countMode) => {
                    nodes.forEach(node => {
                        const haystack = node.dataset.search || '';
                        const rowYear = node.dataset.year || '';
                        const rowStatus = node.dataset.status || '';

                        const matches = (!q || haystack.includes(q))
                            && (year === 'all' || rowYear === year)
                            && (status === 'all' || rowStatus === status);

                        node.classList.toggle('hidden', !matches);
                        if (countMode && matches) {
                            desktopVisible++;
                        }
                    });
                };

                applyToNodes(desktopRows, true);
                applyToNodes(mobileRows, false);

                if (visibleBadge) {
                    visibleBadge.textContent = desktopVisible + ' Proyek';
                }

                if (emptyBox) {
                    emptyBox.classList.toggle('hidden', desktopVisible > 0);
                }
            }

            if (searchInput) searchInput.addEventListener('input', filterProjects);
            if (yearFilter) yearFilter.addEventListener('change', filterProjects);
            if (statusFilter) statusFilter.addEventListener('change', filterProjects);

            if (resetBtn) {
                resetBtn.addEventListener('click', function () {
                    if (searchInput) searchInput.value = '';
                    if (yearFilter) yearFilter.value = 'all';
                    if (statusFilter) statusFilter.value = 'all';
                    filterProjects();
                });
            }

            // Delete Confirmation Modal
            const deleteModal = document.getElementById('delete-project-modal');
            const deleteForm = document.getElementById('delete-project-form');
            const deleteName = document.getElementById('delete-modal-project-name');
            const cancelDeleteBtn = document.getElementById('btn-cancel-delete-modal');

            document.querySelectorAll('.btn-open-delete-modal').forEach(btn => {
                btn.addEventListener('click', function () {
                    const url = this.dataset.deleteUrl;
                    const title = this.dataset.projectTitle;
                    if (deleteForm && deleteName && deleteModal) {
                        deleteForm.setAttribute('action', url);
                        deleteName.textContent = '"' + title + '"';
                        deleteModal.classList.remove('hidden');
                    }
                });
            });

            if (cancelDeleteBtn && deleteModal) {
                cancelDeleteBtn.addEventListener('click', function () {
                    deleteModal.classList.add('hidden');
                });
            }
        })();
    </script>
    @endpush
</x-apanel-layout>
