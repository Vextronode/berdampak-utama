<x-apanel-layout title="Kelola Catatan Lapangan">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8 lg:py-10">
        <!-- Header & Primary Action -->
        <section class="flex flex-col gap-2 mb-8">
            <nav aria-label="Breadcrumb" class="flex flex-wrap items-center gap-1.5 text-xs text-on-surface-variant font-medium">
                <a href="{{ route('apanel.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span class="text-primary font-semibold">Catatan Lapangan</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="font-['Poppins'] text-2xl lg:text-3xl font-bold text-primary tracking-tight">
                        Catatan Lapangan & Dokumentasi Tim
                    </h1>
                    <p class="text-sm text-on-surface-variant max-w-3xl leading-relaxed mt-1">
                        Kelola artikel jurnal kegiatan lapangan, pelatihan operator desa, dan liputan implementasi mahasiswa untuk ditayangkan ke halaman publik.
                    </p>
                </div>
                <a href="{{ route('apanel.field-posts.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-vibrant-utama-orange text-white text-xs font-semibold shadow-xs hover:bg-secondary transition-colors duration-150 self-start sm:self-center shrink-0 whitespace-nowrap">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Tulis Catatan Baru</span>
                </a>
            </div>
        </section>

        <!-- Summary KPI Strip -->
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
            <div class="bg-surface border border-outline-variant rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Total Artikel</span>
                    <div class="text-3xl font-bold text-primary font-['Poppins'] tabular-nums mt-1">{{ $postCount }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-primary-container text-primary flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
            </div>

            <div class="bg-surface border border-outline-variant rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Artikel Tayang</span>
                    <div class="text-3xl font-bold text-success font-['Poppins'] tabular-nums mt-1">{{ $publishedCount }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-success-container text-on-success-container flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
            </div>

            <div class="bg-surface border border-outline-variant rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Draft Tersimpan</span>
                    <div class="text-3xl font-bold text-on-surface-variant font-['Poppins'] tabular-nums mt-1">{{ $draftCount }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-surface-container text-on-surface-variant flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </div>
            </div>
        </section>

        <!-- Field Posts Catalog Table -->
        <section class="bg-surface border border-outline-variant rounded-2xl shadow-xs overflow-hidden">
            <div class="p-5 lg:p-6 border-b border-outline-variant flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <h2 class="font-['Poppins'] font-semibold text-base lg:text-lg text-primary">Daftar Catatan Kegiatan</h2>
                    <span id="visible-post-badge" class="px-2.5 py-0.5 rounded-full bg-primary-container text-on-primary-container font-mono text-xs font-semibold tabular-nums">
                        {{ $postCount }} Catatan
                    </span>
                </div>

                @if($posts->isNotEmpty())
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <div class="relative flex-1 sm:w-64">
                            <input type="text" id="post-search-input" placeholder="Cari judul atau isi ringkasan..." class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-outline-variant bg-surface-variant text-on-surface text-xs placeholder:text-on-surface-variant/60 focus:bg-surface focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                            <svg class="w-4 h-4 text-on-surface-variant absolute left-3 top-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>

                        <select id="post-project-filter" class="px-3 py-2 rounded-xl border border-outline-variant bg-surface text-on-surface text-xs font-medium focus:border-primary focus:ring-1 focus:ring-primary shadow-xs cursor-pointer">
                            <option value="all">Semua Program</option>
                            @foreach($projects as $proj)
                                <option value="{{ $proj->id }}">{{ $proj->title }}</option>
                            @endforeach
                        </select>

                        <select id="post-status-filter" class="px-3 py-2 rounded-xl border border-outline-variant bg-surface text-on-surface text-xs font-medium focus:border-primary focus:ring-1 focus:ring-primary shadow-xs cursor-pointer">
                            <option value="all">Semua Status</option>
                            <option value="published">Tayang</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                @endif
            </div>

            @if($posts->isEmpty())
                <x-empty-state
                    icon="document"
                    title="Belum Ada Catatan Lapangan"
                    description="Mulai dokumentasikan aktivitas lapangan dan pelatihan di desa mitra untuk ditampilkan di halaman publik."
                    class="border-0 rounded-none shadow-none"
                >
                    <a href="{{ route('apanel.field-posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-vibrant-utama-orange text-white text-xs font-semibold hover:bg-secondary transition-colors shadow-xs">
                        <span>Tulis Catatan Pertama</span>
                    </a>
                </x-empty-state>
            @else
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-outline-variant bg-surface-variant/60 text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">
                                <th class="py-3.5 pl-6 pr-4">Artikel Dokumentasi</th>
                                <th class="py-3.5 px-4">Tanggal & Program Terkait</th>
                                <th class="py-3.5 px-4">Status</th>
                                <th class="py-3.5 pl-4 pr-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant text-sm">
                            @foreach($posts as $post)
                                @php
                                    $haystack = strtolower($post->title . ' ' . $post->slug . ' ' . ($post->summary ?? '') . ' ' . ($post->project?->title ?? ''));
                                    $statusKey = $post->is_published ? 'published' : 'draft';
                                @endphp
                                <tr class="post-row-item hover:bg-surface-variant/50 transition-colors"
                                    data-search="{{ $haystack }}"
                                    data-project="{{ $post->project_id ?? 'none' }}"
                                    data-status="{{ $statusKey }}">
                                    <td class="py-4 pl-6 pr-4 align-middle">
                                        <div class="flex items-center gap-3.5">
                                            <div class="w-20 h-12 rounded-lg overflow-hidden bg-surface-container border border-outline-variant shrink-0 flex items-center justify-center">
                                                @if($post->cover_image)
                                                    <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-5 h-5 text-outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                        <polyline points="21 15 16 10 5 21"></polyline>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex flex-col gap-1 min-w-0">
                                                <span class="font-['Poppins'] font-semibold text-sm text-primary truncate max-w-md" title="{{ $post->title }}">
                                                    {{ $post->title }}
                                                </span>
                                                <span class="font-mono text-[11px] text-on-surface-variant truncate max-w-md">/catatan/{{ $post->slug }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-4 px-4 align-middle">
                                        <div class="flex flex-col gap-1.5">
                                            <span class="text-xs font-medium text-on-surface tabular-nums">{{ $post->activity_date->translatedFormat('d F Y') }}</span>
                                            @if($post->project)
                                                <span class="self-start px-2 py-0.5 rounded-md bg-primary-container text-on-primary-container text-[11px] font-semibold truncate max-w-[200px]">
                                                    {{ $post->project->title }}
                                                </span>
                                            @else
                                                <span class="text-[11px] text-on-surface-variant">Kegiatan Umum Program</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="py-4 px-4 align-middle">
                                        <form action="{{ route('apanel.field-posts.toggle-publish', $post) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                title="{{ $post->is_published ? 'Klik untuk ubah ke Draft' : 'Klik untuk Tayangkan' }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition-colors cursor-pointer {{ $post->is_published ? 'bg-success-container text-on-success-container hover:bg-success/20 border border-success/30' : 'bg-surface-container text-on-surface-variant hover:bg-outline-variant border border-outline-variant' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $post->is_published ? 'bg-success' : 'bg-outline' }}"></span>
                                                <span>{{ $post->is_published ? 'Tayang' : 'Draft' }}</span>
                                            </button>
                                        </form>
                                    </td>

                                    <td class="py-4 pl-4 pr-6 align-middle text-right">
                                        <div class="inline-flex items-center justify-end gap-1.5">
                                            @if($post->is_published)
                                                <a href="{{ route('field-posts.show', $post->slug) }}" target="_blank" title="Baca Artikel Publik" class="inline-flex items-center justify-center p-2 rounded-lg border border-outline-variant bg-surface text-on-surface-variant hover:text-primary hover:border-primary/40 transition-colors">
                                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                        <polyline points="15 3 21 3 21 9"></polyline>
                                                        <line x1="10" y1="14" x2="21" y2="3"></line>
                                                    </svg>
                                                </a>
                                            @endif
                                            <a href="{{ route('apanel.field-posts.edit', $post) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-primary/30 bg-primary-container/20 text-primary text-xs font-semibold hover:bg-primary-container/40 transition-colors whitespace-nowrap">
                                                <span>Edit</span>
                                            </a>
                                            <button type="button"
                                                data-delete-url="{{ route('apanel.field-posts.destroy', $post) }}"
                                                data-post-title="{{ $post->title }}"
                                                class="btn-open-delete-post inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-error/30 bg-error-container/30 text-error text-xs font-semibold hover:bg-error-container transition-colors cursor-pointer whitespace-nowrap">
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card List -->
                <div class="md:hidden divide-y divide-outline-variant">
                    @foreach($posts as $post)
                        @php
                            $haystack = strtolower($post->title . ' ' . $post->slug . ' ' . ($post->summary ?? '') . ' ' . ($post->project?->title ?? ''));
                            $statusKey = $post->is_published ? 'published' : 'draft';
                        @endphp
                        <div class="post-mobile-item p-4 flex flex-col gap-3"
                             data-search="{{ $haystack }}"
                             data-project="{{ $post->project_id ?? 'none' }}"
                             data-status="{{ $statusKey }}">
                            <div class="flex items-start gap-3">
                                <div class="w-20 h-12 rounded-lg overflow-hidden bg-surface-container border border-outline-variant shrink-0">
                                    @if($post->cover_image)
                                        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-[11px] font-medium text-on-surface-variant">{{ $post->activity_date->translatedFormat('d F Y') }}</span>
                                    <h3 class="font-['Poppins'] font-semibold text-sm text-primary truncate">{{ $post->title }}</h3>
                                    @if($post->project)
                                        <span class="text-[11px] font-medium text-secondary">{{ $post->project->title }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($post->is_published)
                                    <a href="{{ route('field-posts.show', $post->slug) }}" target="_blank" class="flex-1 text-center py-2 rounded-lg border border-outline-variant text-xs font-semibold text-on-surface-variant">Lihat</a>
                                @endif
                                <a href="{{ route('apanel.field-posts.edit', $post) }}" class="flex-1 text-center py-2 rounded-lg border border-primary/30 bg-primary-container/20 text-xs font-semibold text-primary">Edit</a>
                                <button type="button"
                                    data-delete-url="{{ route('apanel.field-posts.destroy', $post) }}"
                                    data-post-title="{{ $post->title }}"
                                    class="btn-open-delete-post flex-1 text-center py-2 rounded-lg border border-error/30 bg-error-container/30 text-xs font-semibold text-error">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="post-empty-filter" class="hidden p-10 text-center flex flex-col items-center gap-2">
                    <p class="font-['Poppins'] font-semibold text-sm text-primary">Tidak ada catatan yang cocok</p>
                    <button type="button" id="btn-reset-post-filter" class="px-4 py-1.5 rounded-lg border border-primary text-primary text-xs font-semibold cursor-pointer">Reset Filter</button>
                </div>
            @endif
        </section>
    </div>

    <!-- Modal Konfirmasi Hapus Catatan -->
    <div id="delete-post-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-primary-navy-blue/60 backdrop-blur-xs">
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
                    <h3 class="font-['Poppins'] font-semibold text-base text-on-surface">Hapus Catatan Lapangan?</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Artikel <strong id="delete-modal-post-name" class="text-on-surface font-semibold"></strong> beserta foto sampulnya akan dihapus permanen.
                    </p>
                </div>
            </div>

            <form id="delete-post-form" method="POST" action="" class="flex items-center justify-end gap-2.5 pt-2 border-t border-outline-variant">
                @csrf
                @method('DELETE')
                <button type="button" id="btn-cancel-delete-post" class="px-4 py-2 rounded-xl border border-outline-variant bg-surface text-xs font-semibold text-on-surface-variant hover:bg-surface-variant cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-error text-white text-xs font-semibold hover:bg-error/90 shadow-xs cursor-pointer">
                    Ya, Hapus Catatan
                </button>
            </form>
        </div>
    </div>

</x-apanel-layout>
