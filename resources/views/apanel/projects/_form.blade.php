@php
    $isEdit = isset($project) && $project->exists;
    $formAction = $isEdit ? route('apanel.projects.update', $project) : route('apanel.projects.store');

    $defaultSelectedIds = [];
    if ($isEdit) {
        $defaultSelectedIds = $project->techStackItems->pluck('id')->toArray();
        if (empty($defaultSelectedIds) && !empty($project->tech_stacks)) {
            $legacyKeys = array_map(fn ($s) => strtolower(trim((string) $s)), $project->tech_stacks);
            $defaultSelectedIds = $techStacks->filter(function ($stack) use ($legacyKeys) {
                return in_array(strtolower($stack->slug), $legacyKeys, true)
                    || in_array(strtolower($stack->name), $legacyKeys, true);
            })->pluck('id')->toArray();
        }
    }
    $selectedTechIds = old('tech_stack_ids', $defaultSelectedIds);

    $contributorsRows = old('contributors');
    if (!is_array($contributorsRows)) {
        if ($isEdit && $project->contributors->isNotEmpty()) {
            $contributorsRows = $project->contributors->map(fn ($c) => [
                'name' => $c->name,
                'npm' => $c->npm,
                'class_year' => $c->class_year,
                'major' => $c->major,
                'role' => $c->role,
                'existing_avatar' => $c->avatar_url,
            ])->toArray();
        } else {
            $contributorsRows = [[]];
        }
    }

    $existingThumb = $isEdit ? $project->dashboard_thumbnail : null;
    $existingSupervisorPhoto = $isEdit ? $project->supervisor_photo_url : null;
    $isPublishedValue = old('is_published', $isEdit ? ($project->is_published ? '1' : '0') : '1');
    $isPublishedBool = filter_var($isPublishedValue, FILTER_VALIDATE_BOOLEAN);

    $featureIcons = \App\Support\FeatureIcons::all();
    $featureRows = old('features');
    if (!is_array($featureRows)) {
        if ($isEdit && !empty($project->features)) {
            $featureRows = $project->features;
        } else {
            $featureRows = [[]];
        }
    }
@endphp

<form id="new-project-form" action="{{ $formAction }}" method="POST" enctype="multipart/form-data" data-is-edit="{{ $isEdit ? 'true' : 'false' }}" class="flex flex-col gap-8 pb-20">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif
    <input type="hidden" name="is_published" id="is_published_input" value="{{ $isPublishedBool ? '1' : '0' }}">

    <!-- CARD 1: INFORMASI UMUM & FILTER PROYEK -->
    <section class="bg-surface border border-outline-variant rounded-2xl p-6 lg:p-8 flex flex-col gap-6 shadow-xs">
        <header class="border-b border-outline-variant pb-4 flex flex-col gap-1">
            <h2 class="font-['Poppins'] font-semibold text-lg text-primary">1. Informasi Umum & Filter Proyek</h2>
            <p class="text-xs text-on-surface-variant">Data identitas utama yang digunakan untuk penayangan kartu dan penyaringan di katalog publik.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="flex flex-col gap-1.5">
                <label for="project-title" class="font-medium text-xs text-on-surface">Judul Proyek <span class="text-error">*</span></label>
                <input id="project-title" name="title" type="text" value="{{ old('title', $project->title ?? '') }}" required placeholder="Contoh: SIGAP - Sistem Informasi Tanggap Darurat" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="project-slug" class="font-medium text-xs text-on-surface">Slug URL Proyek <span class="text-error">*</span></label>
                <div class="relative flex items-center">
                    <span class="absolute left-3.5 text-xs text-on-surface-variant font-mono">/proyek/</span>
                    <input id="project-slug" name="slug" type="text" value="{{ old('slug', $project->slug ?? '') }}" required {{ $isEdit ? '' : 'readonly' }} class="w-full pl-20 pr-3.5 py-2.5 rounded-xl border border-outline-variant {{ $isEdit ? 'bg-surface' : 'bg-surface-container cursor-not-allowed' }} text-on-surface text-sm font-mono focus:border-primary focus:ring-1 focus:ring-primary shadow-xs select-all">
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="project-year" class="font-medium text-xs text-on-surface">Tahun Pengerjaan <span class="text-error">*</span></label>
                <input id="project-year" name="year" type="text" inputmode="numeric" maxlength="4" pattern="[0-9]{4}" value="{{ old('year', $project->year ?? '') }}" required placeholder="Contoh: 2026" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="project-category" class="font-medium text-xs text-on-surface">Kategori Proyek <span class="text-error">*</span></label>
                <input id="project-category" name="category" type="text" value="{{ old('category', $project->category ?? '') }}" required placeholder="Contoh: Layanan Tanggap Darurat & Pengaduan" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="project-partner" class="font-medium text-xs text-on-surface">Nama Mitra / Desa Binaan <span class="text-error">*</span></label>
                <input id="project-partner" name="partner_name" type="text" value="{{ old('partner_name', $project->partner_name ?? '') }}" required placeholder="Contoh: Pemerintah Desa Cibenda, Kab. Bandung Barat" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="project-url" class="font-medium text-xs text-on-surface">URL Aplikasi Web Live (Opsional)</label>
                <input id="project-url" name="live_url" type="url" value="{{ old('live_url', $project->live_url ?? '') }}" placeholder="https://sigap.desa-cibenda.id" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
            </div>
        </div>

        <!-- Publication Toggle -->
        <div class="pt-4 border-t border-outline-variant flex items-center justify-between gap-4">
            <div class="flex flex-col gap-0.5">
                <span class="font-semibold text-xs text-on-surface">Status Publikasi Langsung</span>
                <span class="text-xs text-on-surface-variant">Aktifkan untuk langsung menampilkan proyek di katalog website publik</span>
            </div>
            <button id="publish-toggle" type="button" role="switch" aria-checked="{{ $isPublishedBool ? 'true' : 'false' }}" aria-label="Toggle status publikasi proyek" class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full {{ $isPublishedBool ? 'bg-success' : 'bg-outline' }} transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-primary shadow-xs">
                <span id="publish-toggle-knob" class="pointer-events-none inline-block h-6 w-6 {{ $isPublishedBool ? 'translate-x-5' : 'translate-x-0.5' }} rounded-full bg-surface shadow-xs transform transition-transform duration-150 mt-0.5 ml-0.5"></span>
            </button>
        </div>
    </section>

    <!-- CARD 2: DESKRIPSI PROYEK & DOKUMENTASI LAPANGAN -->
    <section class="bg-surface border border-outline-variant rounded-2xl p-6 lg:p-8 flex flex-col gap-6 shadow-xs">
        <header class="border-b border-outline-variant pb-4 flex flex-col gap-1">
            <h2 class="font-['Poppins'] font-semibold text-lg text-primary">2. Deskripsi Proyek & Dokumentasi Lapangan</h2>
            <p class="text-xs text-on-surface-variant">Narasi latar belakang masalah, solusi inovatif, dan foto kegiatan implementasi mahasiswa di desa.</p>
        </header>

        <!-- Short Description -->
        <div class="flex flex-col gap-1.5">
            <div class="flex items-center justify-between gap-2">
                <label for="short-desc" class="font-medium text-xs text-on-surface">Deskripsi Singkat (maks. 200 karakter) <span class="text-error">*</span></label>
                <span id="short-desc-count" class="text-xs font-mono text-on-surface-variant">0 / 200</span>
            </div>
            <textarea id="short-desc" name="summary" rows="2" maxlength="200" required placeholder="Ringkasan 1-2 kalimat yang tampil pada kartu proyek di halaman katalog utama..." class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs leading-relaxed">{{ old('summary', $project->summary ?? '') }}</textarea>
        </div>

        <!-- Structured Description -->
        <div class="flex flex-col gap-1.5">
            <label for="full-desc" class="font-medium text-xs text-on-surface">Deskripsi Lengkap & Cerita Dampak Nyata</label>
            <div class="border border-outline-variant rounded-xl overflow-hidden shadow-xs">
                <div class="bg-surface-variant border-b border-outline-variant px-3 py-2 flex flex-wrap items-center gap-1 text-xs text-on-surface-variant">
                    <span class="font-medium text-primary px-2">Struktur Narasi yang Dianjurkan: Latar Belakang Masalah, Solusi Sistem, dan Dampak Nyata</span>
                </div>
                <textarea id="full-desc" name="problem_statement" rows="7" placeholder="Tuliskan cerita lengkap mengenai permasalahan yang dihadapi mitra binaan, bagaimana inovasi mahasiswa memberikan solusi, serta dampak terukur bagi masyarakat setempat..." class="w-full p-4 border-0 bg-surface text-on-surface text-sm focus:ring-0 leading-relaxed">{{ old('problem_statement', $project->problem_statement ?? $project->description ?? '') }}</textarea>
            </div>
        </div>

        <!-- Fitur Kunci Sistem (Dynamic Builder + Visual Icon Picker) -->
        <div class="flex flex-col gap-4 pt-4 border-t border-outline-variant">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="font-['Poppins'] font-semibold text-sm text-primary">Fitur Kunci Sistem (Opsional)</h3>
                    <p class="text-xs text-on-surface-variant">Tambahkan daftar keunggulan fitur aplikasi beserta simbolnya untuk halaman detail proyek.</p>
                </div>
                <button type="button" id="btn-add-feature" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-primary/40 bg-surface text-primary text-xs font-semibold hover:bg-primary-container/25 transition-colors shadow-xs self-start sm:self-auto cursor-pointer whitespace-nowrap">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Tambah Fitur Kunci</span>
                </button>
            </div>

            <div id="features-container" data-next-index="{{ count($featureRows) }}" data-feature-icons="{{ json_encode($featureIcons) }}" class="flex flex-col gap-3.5">
                @foreach ($featureRows as $fIdx => $fRow)
                    @php
                        $selectedIcon = (string) ($fRow['icon'] ?? 'check');
                        if (!array_key_exists($selectedIcon, $featureIcons)) {
                            $selectedIcon = 'check';
                        }
                        $iconMeta = $featureIcons[$selectedIcon];
                    @endphp
                    <div class="feature-row bg-surface-variant/40 hover:bg-surface-variant/70 border border-outline-variant hover:border-primary/40 rounded-2xl p-4 sm:p-5 flex flex-col md:flex-row items-start gap-4 relative transition-all duration-150 shadow-xs" data-index="{{ $fIdx }}">
                        <!-- Visual Icon Picker -->
                        <div class="feature-icon-picker-wrap relative shrink-0 w-full md:w-48">
                            <input type="hidden" name="features[{{ $fIdx }}][icon]" value="{{ $selectedIcon }}" class="feature-icon-input">
                            <span class="block font-medium text-xs text-on-surface mb-1">Simbol Fitur</span>
                            <button type="button" class="btn-toggle-icon-picker w-full flex items-center justify-between gap-2.5 p-2 rounded-xl border border-outline-variant bg-surface hover:border-primary transition-colors shadow-xs cursor-pointer text-left">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <span class="feature-icon-preview inline-flex items-center justify-center w-9 h-9 rounded-lg bg-primary-container shrink-0">
                                        <x-feature-icon :icon="$selectedIcon" class="w-5 h-5" />
                                    </span>
                                    <span class="feature-icon-label text-xs font-medium text-on-surface truncate">{{ $iconMeta['label'] }}</span>
                                </div>
                                <svg class="w-4 h-4 text-on-surface-variant shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>

                            <!-- Floating Icon Palette -->
                            <div class="feature-icon-popover hidden absolute left-0 top-full mt-2 w-72 sm:w-80 bg-surface border border-outline-variant rounded-2xl shadow-xl p-3 z-40">
                                <p class="text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider mb-2 px-1">Pilih Simbol Visual</p>
                                <div class="grid grid-cols-3 gap-1.5">
                                    @foreach ($featureIcons as $iconKey => $meta)
                                        <button type="button"
                                            data-icon-key="{{ $iconKey }}"
                                            data-icon-label="{{ $meta['label'] }}"
                                            class="btn-pick-feature-icon flex flex-col items-center gap-1.5 p-2 rounded-xl border {{ $selectedIcon === $iconKey ? 'border-primary bg-primary-container/20' : 'border-transparent hover:border-outline-variant hover:bg-surface-variant' }} transition-all cursor-pointer text-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-container">
                                                <x-feature-icon :icon="$iconKey" class="w-4 h-4" />
                                            </span>
                                            <span class="text-[10px] font-medium text-on-surface leading-tight line-clamp-1">{{ $meta['label'] }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Judul & Deskripsi Fitur -->
                        <div class="flex-1 w-full flex flex-col gap-3">
                            <div class="flex flex-col gap-1">
                                <label class="font-medium text-xs text-on-surface">Judul Fitur</label>
                                <input type="text" name="features[{{ $fIdx }}][title]" value="{{ $fRow['title'] ?? '' }}" placeholder="Contoh: Katalog Komoditas Unggulan Digital" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-medium text-xs text-on-surface">Deskripsi Singkat Fitur</label>
                                <textarea name="features[{{ $fIdx }}][description]" rows="2" placeholder="Contoh: Etalase informasi terstruktur untuk produk olahan makanan dan hasil bumi desa mitra." class="w-full px-3.5 py-2 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs leading-relaxed">{{ $fRow['description'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- Tombol Hapus Baris -->
                        <button type="button" class="btn-remove-feature absolute top-3 right-3 md:relative md:top-auto md:right-auto p-2 text-outline hover:text-error hover:bg-error-container/40 rounded-xl transition-colors shrink-0 self-start mt-5 cursor-pointer" title="Hapus Fitur Ini">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Galeri Dokumentasi Lapangan (4 Slot Foto) -->
        <div class="flex flex-col gap-3 pt-2 border-t border-outline-variant">
            <h3 class="font-['Poppins'] font-semibold text-sm text-primary">Upload Galeri Dokumentasi di Desa Mitra (Maksimal 4 Foto)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @for ($i = 0; $i < 4; $i++)
                    @php
                        $slotItem = $isEdit ? ($project->gallery_images[$i] ?? null) : null;
                        $slotUrl = $slotItem ? ($slotItem['image_url'] ?? $slotItem['url'] ?? null) : null;
                        $slotCaption = $slotItem['caption'] ?? '';
                    @endphp
                    <div class="gallery-slot flex flex-col gap-2 relative">
                        <input type="hidden" name="existing_gallery_urls[{{ $i }}]" value="{{ $slotUrl }}" class="existing-gallery-url-input">
                        <div class="relative aspect-video w-full">
                            <label class="w-full h-full border-2 border-dashed border-outline-variant rounded-xl bg-surface-variant flex flex-col items-center justify-center gap-1.5 text-on-surface-variant hover:border-primary hover:text-primary transition-all duration-150 cursor-pointer overflow-hidden relative group">
                                <input type="file" name="gallery_images[{{ $i }}]" accept="image/*" class="gallery-file-input hidden" data-index="{{ $i }}">
                                <div class="gallery-placeholder {{ $slotUrl ? 'hidden' : 'flex' }} flex-col items-center justify-center p-3 text-center">
                                    <svg class="w-6 h-6 text-outline group-hover:text-primary transition-colors mb-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                    <span class="text-xs font-semibold">Pilih Foto {{ $i + 1 }}</span>
                                    <span class="text-[10px] text-on-surface-variant/70">JPG, PNG (Maks 3MB)</span>
                                </div>
                                <img src="{{ $slotUrl ?? '' }}" class="gallery-preview-img {{ $slotUrl ? '' : 'hidden' }} w-full h-full object-cover" alt="Preview Foto {{ $i + 1 }}">
                            </label>
                            <button type="button" title="Hapus Foto {{ $i + 1 }}" class="btn-remove-gallery {{ $slotUrl ? '' : 'hidden' }} absolute top-2 right-2 bg-error text-white p-1.5 rounded-lg shadow-md hover:bg-error/90 transition-colors cursor-pointer z-10">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <input type="text" name="gallery_captions[{{ $i }}]" value="{{ old('gallery_captions.' . $i, $slotCaption) }}" placeholder="Keterangan / Caption Foto {{ $i + 1 }}" class="w-full px-3 py-1.5 rounded-lg border border-outline-variant bg-surface text-on-surface text-xs placeholder:text-on-surface-variant/50 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- CARD 3: TANGKAPAN LAYAR DASHBOARD UTAMA (16:9) -->
    <section class="bg-surface border border-outline-variant rounded-2xl p-6 lg:p-8 flex flex-col gap-4 shadow-xs">
        <header class="flex flex-col gap-1">
            <h2 class="font-['Poppins'] font-semibold text-lg text-primary">3. Tangkapan Layar Dashboard Utama (Rasio 16:9)</h2>
            <p class="text-xs text-on-surface-variant">Gambar ini akan menjadi cover kartu utama pada halaman depan dan banner halaman detail proyek.</p>
        </header>

        <input type="hidden" name="remove_thumbnail" id="remove_thumbnail_input" value="0">

        <div id="thumbnail-dropzone" class="aspect-video w-full border-2 border-dashed border-outline-variant rounded-2xl bg-surface-variant flex flex-col items-center justify-center text-center p-6 gap-3 cursor-pointer hover:border-primary hover:bg-primary-container/10 transition-all duration-150 relative overflow-hidden group">
            <input type="file" id="dashboard_thumbnail_input" name="dashboard_thumbnail" accept="image/png,image/jpeg,image/webp" class="hidden">
            
            <div id="thumbnail-placeholder" class="{{ $existingThumb ? 'hidden' : 'flex' }} flex-col items-center justify-center gap-2 max-w-md">
                <div class="w-12 h-12 rounded-xl bg-primary-container text-primary flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                </div>
                <span class="font-medium text-sm text-on-surface">Tarik & Lepaskan File Gambar ke Sini atau Klik untuk Memilih</span>
                <span class="text-xs text-on-surface-variant">Format PNG, JPG, atau WebP (Rasio 16:9, Maksimal 3MB)</span>
                <button type="button" class="mt-2 inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-primary text-primary bg-surface text-xs font-semibold hover:bg-primary-container/30 transition-colors shadow-xs">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    <span>Pilih File Gambar</span>
                </button>
            </div>

            <div id="thumbnail-preview-container" class="{{ $existingThumb ? '' : 'hidden' }} absolute inset-0 w-full h-full bg-surface">
                <img id="thumbnail-preview-img" src="{{ $existingThumb ?? '' }}" alt="Preview Thumbnail" class="w-full h-full object-cover">
                <button type="button" id="btn-remove-thumbnail" title="Hapus gambar" class="absolute top-4 right-4 bg-error text-white p-2 rounded-xl shadow-md hover:bg-error/90 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- CARD 4: PILIHAN TECH STACK (DYNAMIC MULTI-SELECT) -->
    <section class="bg-surface border border-outline-variant rounded-2xl p-6 lg:p-8 flex flex-col gap-5 shadow-xs">
        <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-outline-variant pb-4">
            <div>
                <h2 class="font-['Poppins'] font-semibold text-lg text-primary">4. Pilih Teknologi yang Digunakan</h2>
                <p class="text-xs text-on-surface-variant">Pilih stack teknologi utama yang akan ditampilkan pada lencana proyek.</p>
            </div>
            <button type="button" id="btn-open-tech-modal" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-primary text-primary bg-surface text-xs font-semibold hover:bg-primary-container transition-colors shadow-xs self-start sm:self-auto cursor-pointer whitespace-nowrap">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Tambah Stack Baru</span>
            </button>
        </header>

        <!-- Search Filter in Grid -->
        <div class="relative">
            <input type="text" id="tech-filter-search" placeholder="Cari teknologi (misal: React, Laravel, Go, Prisma)..." class="w-full pl-9 pr-3.5 py-2 rounded-xl border border-outline-variant bg-surface-variant text-on-surface text-xs placeholder:text-on-surface-variant/60 focus:bg-surface focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
            <svg class="w-4 h-4 text-on-surface-variant absolute left-3 top-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>

        <!-- Grid Tech Stack Items -->
        <div id="tech-stacks-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 max-h-96 overflow-y-auto pr-1">
            @foreach ($techStacks as $stack)
                @php
                    $isChecked = in_array($stack->id, $selectedTechIds);
                @endphp
                <label class="tech-item-card cursor-pointer border {{ $isChecked ? 'border-primary bg-primary-container/10' : 'border-outline-variant bg-surface' }} rounded-xl p-3 flex flex-col items-center gap-2 text-center hover:border-primary hover:shadow-xs transition-all duration-150 relative select-none" data-name="{{ strtolower($stack->name) }}" data-slug="{{ strtolower($stack->slug) }}">
                    <input type="checkbox" name="tech_stack_ids[]" value="{{ $stack->id }}" {{ $isChecked ? 'checked' : '' }} class="tech-item-checkbox absolute top-2.5 right-2.5 rounded text-primary focus:ring-primary cursor-pointer">
                    <x-tech-stack-icon :stack="$stack" class="w-8 h-8" />
                    <span class="text-xs font-semibold text-on-surface line-clamp-1 mt-0.5">{{ $stack->name }}</span>
                </label>
            @endforeach
        </div>
    </section>

    <!-- CARD 5: TIM PENGEMBANG & ORANG YANG TERLIBAT -->
    <section class="bg-surface border border-outline-variant rounded-2xl p-6 lg:p-8 flex flex-col gap-6 shadow-xs">
        <header class="border-b border-outline-variant pb-4 flex flex-col gap-1">
            <h2 class="font-['Poppins'] font-semibold text-lg text-primary">5. Tim Pengembang & Orang yang Terlibat</h2>
            <p class="text-xs text-on-surface-variant">Cantumkan dosen pembimbing penanggung jawab serta seluruh mahasiswa kontributor pengembang inovasi.</p>
        </header>

        <!-- Dosen Pembimbing Sub-card -->
        <div class="flex flex-col gap-3">
            <h3 class="font-['Poppins'] font-semibold text-sm text-primary">Dosen Pembimbing & Penanggung Jawab</h3>
            <input type="hidden" name="remove_supervisor_photo" id="remove_supervisor_photo_input" value="0">
            <div class="bg-surface-variant/40 border border-outline-variant rounded-2xl p-4 sm:p-5 flex flex-col md:flex-row items-start md:items-center gap-4">
                <div class="relative shrink-0">
                    <label class="w-20 h-20 rounded-full border-2 border-dashed border-outline-variant bg-surface flex flex-col items-center justify-center gap-0.5 text-on-surface-variant hover:border-primary hover:text-primary transition-colors cursor-pointer relative overflow-hidden group shadow-xs">
                        <input type="file" name="supervisor_photo" accept="image/*" class="supervisor-photo-input hidden">
                        <div class="supervisor-photo-placeholder {{ $existingSupervisorPhoto ? 'hidden' : 'flex' }} flex-col items-center">
                            <svg class="w-6 h-6 text-outline group-hover:text-primary transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span class="text-[10px] font-semibold mt-0.5">Foto</span>
                        </div>
                        <img src="{{ $existingSupervisorPhoto ?? '' }}" class="supervisor-photo-preview {{ $existingSupervisorPhoto ? '' : 'hidden' }} w-full h-full object-cover" alt="Preview Dosen">
                    </label>
                    <button type="button" id="btn-remove-supervisor-photo" title="Hapus Foto Dosen" class="{{ $existingSupervisorPhoto ? '' : 'hidden' }} absolute -top-1 -right-1 bg-error text-white p-1 rounded-full shadow-xs hover:bg-error/90 transition-colors cursor-pointer">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 w-full grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label for="supervisor-name" class="font-medium text-xs text-on-surface">Nama Lengkap & Gelar Dosen</label>
                        <input id="supervisor-name" name="supervisor_name" type="text" value="{{ old('supervisor_name', $project->supervisor_name ?? '') }}" placeholder="Contoh: Dr. Hendra Wijaya, M.Kom." class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="supervisor-title" class="font-medium text-xs text-on-surface">Jabatan / Peran Dosen</label>
                        <input id="supervisor-title" name="supervisor_title" type="text" value="{{ old('supervisor_title', $project->supervisor_title ?? '') }}" placeholder="Contoh: Dosen Pembimbing Lapangan" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                    </div>
                </div>
            </div>
        </div>

        <!-- Mahasiswa Kontributor Sub-card -->
        <div class="flex flex-col gap-4 pt-2 border-t border-outline-variant">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h3 class="font-['Poppins'] font-semibold text-sm text-primary">Daftar Mahasiswa yang Terlibat</h3>
                    <p class="text-xs text-on-surface-variant">Tambahkan data mahasiswa kontributor yang terekam pada kartu tim.</p>
                </div>
                <button type="button" id="btn-add-contributor" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-vibrant-utama-orange bg-surface text-on-secondary-container text-xs font-semibold hover:bg-secondary-container transition-colors shadow-xs self-start sm:self-auto cursor-pointer whitespace-nowrap">
                    <svg class="w-4 h-4 text-vibrant-utama-orange" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Tambah Anggota Mahasiswa</span>
                </button>
            </div>

            <!-- Dynamic Container for Contributors -->
            <div id="contributors-container" data-next-index="{{ count($contributorsRows) }}" class="flex flex-col gap-4">
                @foreach ($contributorsRows as $idx => $cRow)
                    @php
                        $existingAvatar = $cRow['existing_avatar'] ?? null;
                    @endphp
                    <div class="contributor-row bg-surface-variant/40 hover:bg-surface-variant/70 border border-outline-variant hover:border-primary/40 rounded-2xl p-4 sm:p-5 flex flex-col md:flex-row items-start gap-4 sm:gap-5 relative transition-all duration-150 shadow-xs" data-index="{{ $idx }}">
                        <input type="hidden" name="contributors[{{ $idx }}][existing_avatar]" value="{{ $existingAvatar }}" class="contributor-existing-avatar">

                        <!-- Foto Profil Avatar -->
                        <div class="flex flex-col items-center gap-1.5 shrink-0 self-center md:self-start">
                            <label class="w-16 h-16 rounded-full border-2 border-dashed border-outline-variant bg-surface flex flex-col items-center justify-center text-on-surface-variant hover:border-primary hover:text-primary transition-colors cursor-pointer relative overflow-hidden group shadow-xs" title="Unggah Foto Mahasiswa">
                                <input type="file" name="contributors[{{ $idx }}][photo]" accept="image/*" class="contributor-photo-input hidden">
                                <svg class="contributor-photo-placeholder {{ $existingAvatar ? 'hidden' : '' }} w-6 h-6 text-outline group-hover:text-primary transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                    <circle cx="12" cy="13" r="4"></circle>
                                </svg>
                                <img src="{{ $existingAvatar ?? '' }}" class="contributor-preview-img {{ $existingAvatar ? '' : 'hidden' }} w-full h-full object-cover" alt="Foto">
                            </label>
                            <span class="text-[10px] font-medium text-on-surface-variant">Foto Profil</span>
                        </div>

                        <!-- Form Grid 2 Baris Lega -->
                        <div class="flex-1 w-full flex flex-col gap-3.5">
                            <!-- Baris 1: Nama Lengkap (Wide), NPM, Angkatan -->
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3.5">
                                <div class="sm:col-span-6 flex flex-col gap-1">
                                    <label class="font-medium text-xs text-on-surface">Nama Lengkap Mahasiswa <span class="text-error">*</span></label>
                                    <input type="text" name="contributors[{{ $idx }}][name]" value="{{ $cRow['name'] ?? '' }}" placeholder="Contoh: Raihan Dastra" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                                </div>
                                <div class="sm:col-span-3 flex flex-col gap-1">
                                    <label class="font-medium text-xs text-on-surface">Nomor NPM <span class="text-error">*</span></label>
                                    <input type="text" name="contributors[{{ $idx }}][npm]" value="{{ $cRow['npm'] ?? '' }}" placeholder="Contoh: 230611001" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm font-mono tabular-nums placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                                </div>
                                <div class="sm:col-span-3 flex flex-col gap-1">
                                    <label class="font-medium text-xs text-on-surface">Angkatan</label>
                                    <input type="text" name="contributors[{{ $idx }}][class_year]" value="{{ $cRow['class_year'] ?? '' }}" placeholder="Contoh: 2023" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                                </div>
                            </div>

                            <!-- Baris 2: Jurusan & Peran -->
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3.5">
                                <div class="sm:col-span-6 flex flex-col gap-1">
                                    <label class="font-medium text-xs text-on-surface">Jurusan / Program Studi <span class="text-error">*</span></label>
                                    <input type="text" name="contributors[{{ $idx }}][major]" value="{{ $cRow['major'] ?? '' }}" placeholder="Contoh: S1 Teknik Informatika" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                                </div>
                                <div class="sm:col-span-6 flex flex-col gap-1">
                                    <label class="font-medium text-xs text-on-surface">Peran / Tanggung Jawab Teknis <span class="text-error">*</span></label>
                                    <input type="text" name="contributors[{{ $idx }}][role]" value="{{ $cRow['role'] ?? '' }}" placeholder="Contoh: Tech Lead & Full Stack Developer" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Hapus Baris -->
                        <button type="button" class="btn-remove-contributor absolute top-3 right-3 md:relative md:top-auto md:right-auto p-2 text-outline hover:text-error hover:bg-error-container/40 rounded-xl transition-colors shrink-0 self-start mt-0.5 cursor-pointer" title="Hapus Anggota Mahasiswa">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sticky Bottom Action Bar -->
    <div class="fixed bottom-0 left-0 right-0 z-30 bg-surface/95 backdrop-blur-md border-t border-outline-variant px-6 lg:px-8 py-4 shadow-lg">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            <a href="{{ route('apanel.dashboard') }}" class="inline-flex items-center gap-1.5 text-on-surface-variant hover:text-primary text-xs font-semibold transition-colors duration-150 whitespace-nowrap">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Batal & Kembali ke Dasbor</span>
            </a>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button type="button" id="btn-save-draft" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-primary text-primary bg-surface text-xs font-semibold hover:bg-primary-container/30 transition-colors duration-150 cursor-pointer shadow-xs whitespace-nowrap">
                    <span>Simpan sebagai Draft</span>
                </button>
                <button type="button" id="btn-publish-now" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-vibrant-utama-orange text-white text-xs font-semibold shadow-xs hover:bg-secondary transition-colors duration-150 cursor-pointer whitespace-nowrap">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>{{ $isEdit ? 'Simpan & Publikasikan' : 'Publikasikan Proyek Sekarang' }}</span>
                </button>
            </div>
        </div>
    </div>
</form>

<!-- Quick Add Tech Stack Modal -->
<div id="tech-stack-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-primary-navy-blue/60 backdrop-blur-xs transition-opacity duration-200">
    <div class="bg-surface rounded-2xl border border-outline-variant shadow-xl max-w-md w-full p-6 flex flex-col gap-4">
        <div class="flex items-center justify-between border-b border-outline-variant pb-3">
            <h3 class="font-['Poppins'] font-semibold text-base text-primary">Tambah Tech Stack Baru</h3>
            <button type="button" id="btn-close-tech-modal" class="text-on-surface-variant hover:text-on-surface p-1 rounded-lg cursor-pointer">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <form id="quick-tech-form" data-tech-store-url="{{ route('apanel.tech-stacks.store') }}" data-csrf-token="{{ csrf_token() }}" class="flex flex-col gap-3.5">
            <div class="flex flex-col gap-1">
                <label for="modal-tech-name" class="font-medium text-xs text-on-surface">Nama Teknologi</label>
                <input type="text" id="modal-tech-name" required placeholder="Contoh: Prisma, Supabase, Go" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs text-on-surface focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
            </div>

            <div class="flex flex-col gap-1">
                <label for="modal-tech-slug" class="font-medium text-xs text-on-surface">Slug (Untuk Auto-Fetch SimpleIcons)</label>
                <input type="text" id="modal-tech-slug" placeholder="Contoh: prisma, supabase, go" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs text-on-surface font-mono focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-medium text-xs text-on-surface">Pilihan Tipe Ikon</label>
                <select id="modal-icon-type" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs text-on-surface focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                    <option value="cdn_url" selected>Auto-fetch dari SimpleIcons CDN</option>
                    <option value="monogram">Fallback Inisial Monogram Badge</option>
                    <option value="custom_upload">Upload File SVG/PNG Custom</option>
                </select>
            </div>

            <div id="modal-custom-file-box" class="hidden flex flex-col gap-1">
                <label for="modal-custom-file" class="font-medium text-xs text-on-surface">File Ikon (SVG atau PNG, Maks 500KB)</label>
                <input type="file" id="modal-custom-file" accept=".svg,.png,.jpg,.webp" class="text-xs text-on-surface-variant file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-primary-container file:text-primary file:font-semibold">
            </div>

            <div class="flex flex-col gap-1">
                <label for="modal-brand-color" class="font-medium text-xs text-on-surface">Warna Brand (Hexadecimal)</label>
                <div class="flex items-center gap-2">
                    <input type="color" id="modal-color-picker" value="#1E1B64" class="w-9 h-9 p-0.5 rounded-lg border border-outline-variant cursor-pointer">
                    <input type="text" id="modal-brand-color" value="#1E1B64" maxlength="7" class="w-full px-3 py-2 rounded-xl border border-outline-variant text-xs text-on-surface font-mono uppercase">
                </div>
            </div>

            <div id="modal-error-box" class="hidden p-2.5 rounded-lg bg-error-container text-on-error-container text-xs"></div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-outline-variant">
                <button type="button" id="btn-cancel-tech-modal" class="px-3.5 py-2 rounded-xl border border-outline-variant text-xs font-semibold text-on-surface-variant hover:bg-surface-variant cursor-pointer">Batal</button>
                <button type="submit" id="btn-submit-quick-tech" class="px-4 py-2 rounded-xl bg-primary text-white text-xs font-semibold hover:bg-primary-royal-indigo transition-colors shadow-xs cursor-pointer">Simpan Stack</button>
            </div>
        </form>
    </div>
</div>
