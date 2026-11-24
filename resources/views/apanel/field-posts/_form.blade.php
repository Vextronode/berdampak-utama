@php
    $isEdit = isset($post) && $post->exists;
    $formAction = $isEdit ? route('apanel.field-posts.update', $post) : route('apanel.field-posts.store');
    $existingCover = $isEdit ? $post->cover_image : null;
    $isPublishedValue = old('is_published', $isEdit ? ($post->is_published ? '1' : '0') : '1');
    $isPublishedBool = filter_var($isPublishedValue, FILTER_VALIDATE_BOOLEAN);
    $defaultDate = old('activity_date', $isEdit && $post->activity_date ? $post->activity_date->format('Y-m-d') : now()->format('Y-m-d'));
@endphp

<form id="field-post-form" action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-8 pb-20">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif
    <input type="hidden" name="is_published" id="post_is_published_input" value="{{ $isPublishedBool ? '1' : '0' }}">

    <!-- CARD 1: INFORMASI ARTIKEL -->
    <section class="bg-surface border border-outline-variant rounded-2xl p-6 lg:p-8 flex flex-col gap-6 shadow-xs">
        <header class="border-b border-outline-variant pb-4 flex flex-col gap-1">
            <h2 class="font-['Poppins'] font-semibold text-lg text-primary">1. Informasi Utama Catatan Kegiatan</h2>
            <p class="text-xs text-on-surface-variant">Judul artikel, tanggal pelaksanaan di lapangan, dan keterkaitan dengan proyek program Berdampak Utama.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="flex flex-col gap-1.5">
                <label for="post-title" class="font-medium text-xs text-on-surface">Judul Catatan / Liputan <span class="text-error">*</span></label>
                <input id="post-title" name="title" type="text" value="{{ old('title', $post->title ?? '') }}" required placeholder="Contoh: Sosialisasi Aplikasi SIGAP di Balai Desa Cibenda" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="post-slug" class="font-medium text-xs text-on-surface">Slug URL Artikel <span class="text-error">*</span></label>
                <div class="relative flex items-center">
                    <span class="absolute left-3.5 text-xs text-on-surface-variant font-mono">/catatan/</span>
                    <input id="post-slug" name="slug" type="text" value="{{ old('slug', $post->slug ?? '') }}" required {{ $isEdit ? '' : 'readonly' }} class="w-full pl-24 pr-3.5 py-2.5 rounded-xl border border-outline-variant {{ $isEdit ? 'bg-surface' : 'bg-surface-container cursor-not-allowed' }} text-on-surface text-sm font-mono focus:border-primary focus:ring-1 focus:ring-primary shadow-xs select-all">
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="post-date" class="font-medium text-xs text-on-surface">Tanggal Pelaksanaan <span class="text-error">*</span></label>
                <input id="post-date" name="activity_date" type="date" value="{{ $defaultDate }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="post-project" class="font-medium text-xs text-on-surface">Tautkan ke Proyek Terkait (Opsional)</label>
                <select id="post-project" name="project_id" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                    <option value="">Tidak Ditautkan (Kegiatan Program Umum)</option>
                    @foreach($projects as $proj)
                        <option value="{{ $proj->id }}" {{ (string) old('project_id', $post->project_id ?? '') === (string) $proj->id ? 'selected' : '' }}>
                            {{ $proj->title }} ({{ $proj->year }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="pt-4 border-t border-outline-variant flex items-center justify-between gap-4">
            <div class="flex flex-col gap-0.5">
                <span class="font-semibold text-xs text-on-surface">Status Publikasi</span>
                <span class="text-xs text-on-surface-variant">Aktifkan untuk langsung menampilkan catatan di halaman utama dan arsip publik</span>
            </div>
            <button id="post-publish-toggle" type="button" role="switch" aria-checked="{{ $isPublishedBool ? 'true' : 'false' }}" class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full {{ $isPublishedBool ? 'bg-success' : 'bg-outline' }} transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-primary shadow-xs">
                <span id="post-publish-knob" class="pointer-events-none inline-block h-6 w-6 {{ $isPublishedBool ? 'translate-x-5' : 'translate-x-0.5' }} rounded-full bg-surface shadow-xs transform transition-transform duration-150 mt-0.5 ml-0.5"></span>
            </button>
        </div>
    </section>

    <!-- CARD 2: FOTO SAMPUL (16:9) -->
    <section class="bg-surface border border-outline-variant rounded-2xl p-6 lg:p-8 flex flex-col gap-4 shadow-xs">
        <header class="flex flex-col gap-1">
            <h2 class="font-['Poppins'] font-semibold text-lg text-primary">2. Foto Sampul Dokumentasi (Rasio 16:9)</h2>
            <p class="text-xs text-on-surface-variant">Foto kegiatan mahasiswa atau dosen di lokasi desa mitra yang tampil pada kartu catatan lapangan.</p>
        </header>

        <input type="hidden" name="remove_cover_image" id="remove_cover_input" value="0">

        <div id="cover-dropzone" class="aspect-video w-full border-2 border-dashed border-outline-variant rounded-2xl bg-surface-variant flex flex-col items-center justify-center text-center p-6 gap-3 cursor-pointer hover:border-primary hover:bg-primary-container/10 transition-all duration-150 relative overflow-hidden group">
            <input type="file" id="cover_image_input" name="cover_image" accept="image/png,image/jpeg,image/webp" class="hidden">

            <div id="cover-placeholder" class="{{ $existingCover ? 'hidden' : 'flex' }} flex-col items-center justify-center gap-2 max-w-md">
                <div class="w-12 h-12 rounded-xl bg-primary-container text-primary flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                </div>
                <span class="font-medium text-sm text-on-surface">Klik untuk Memilih Foto Sampul Kegiatan</span>
                <span class="text-xs text-on-surface-variant">Format PNG, JPG, atau WebP (Rasio 16:9, Maksimal 3MB)</span>
            </div>

            <div id="cover-preview-container" class="{{ $existingCover ? '' : 'hidden' }} absolute inset-0 w-full h-full bg-surface">
                <img id="cover-preview-img" src="{{ $existingCover ?? '' }}" alt="Preview Cover" class="w-full h-full object-cover">
                <button type="button" id="btn-remove-cover" title="Hapus gambar" class="absolute top-4 right-4 bg-error text-white p-2 rounded-xl shadow-md hover:bg-error/90 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- CARD 3: RINGKASAN & ISI ARTIKEL -->
    <section class="bg-surface border border-outline-variant rounded-2xl p-6 lg:p-8 flex flex-col gap-6 shadow-xs">
        <header class="border-b border-outline-variant pb-4 flex flex-col gap-1">
            <h2 class="font-['Poppins'] font-semibold text-lg text-primary">3. Ringkasan & Isi Cerita Lengkap</h2>
            <p class="text-xs text-on-surface-variant">Tulis ringkasan singkat untuk kartu katalog dan narasi artikel penuh mengenai jalannya kegiatan lapangan.</p>
        </header>

        <div class="flex flex-col gap-1.5">
            <div class="flex items-center justify-between gap-2">
                <label for="post-summary" class="font-medium text-xs text-on-surface">Ringkasan Singkat (maks. 300 karakter)</label>
                <span id="post-summary-count" class="text-xs font-mono text-on-surface-variant">0 / 300</span>
            </div>
            <textarea id="post-summary" name="summary" rows="2" maxlength="300" placeholder="Ringkasan 1-2 kalimat yang tampil pada kartu catatan lapangan di beranda..." class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs leading-relaxed">{{ old('summary', $post->summary ?? '') }}</textarea>
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="post-content" class="font-medium text-xs text-on-surface">Isi Artikel Lengkap <span class="text-error">*</span></label>
            <textarea id="post-content" name="content" rows="10" required placeholder="Tuliskan cerita lengkap jalannya kegiatan di lapangan, peserta yang terlibat, hasil diskusi atau pelatihan, dan dokumentasi dampaknya..." class="w-full p-4 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs leading-relaxed">{{ old('content', $post->content ?? '') }}</textarea>
        </div>
    </section>

    <!-- Sticky Bottom Action Bar -->
    <div class="fixed bottom-0 left-0 right-0 z-30 bg-surface/95 backdrop-blur-md border-t border-outline-variant px-6 lg:px-8 py-4 shadow-lg">
        <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            <a href="{{ route('apanel.field-posts.index') }}" class="inline-flex items-center gap-1.5 text-on-surface-variant hover:text-primary text-xs font-semibold transition-colors duration-150 whitespace-nowrap">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Batal & Kembali</span>
            </a>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button type="button" id="btn-save-post-draft" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-primary text-primary bg-surface text-xs font-semibold hover:bg-primary-container/30 transition-colors cursor-pointer shadow-xs whitespace-nowrap">
                    <span>Simpan sebagai Draft</span>
                </button>
                <button type="button" id="btn-publish-post" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-vibrant-utama-orange text-white text-xs font-semibold shadow-xs hover:bg-secondary transition-colors cursor-pointer whitespace-nowrap">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>{{ $isEdit ? 'Simpan & Publikasikan' : 'Terbitkan Catatan Sekarang' }}</span>
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    (function () {
        const isEditMode = @json($isEdit);
        const titleInput = document.getElementById('post-title');
        const slugInput = document.getElementById('post-slug');

        if (!isEditMode && titleInput && slugInput) {
            titleInput.addEventListener('input', function () {
                slugInput.value = titleInput.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            });
        }

        const summaryInput = document.getElementById('post-summary');
        const summaryCount = document.getElementById('post-summary-count');
        if (summaryInput && summaryCount) {
            const updateCount = () => summaryCount.textContent = summaryInput.value.length + ' / 300';
            summaryInput.addEventListener('input', updateCount);
            updateCount();
        }

        const toggleBtn = document.getElementById('post-publish-toggle');
        const knob = document.getElementById('post-publish-knob');
        const hiddenInput = document.getElementById('post_is_published_input');
        const mainForm = document.getElementById('field-post-form');

        if (toggleBtn && knob && hiddenInput) {
            const setPublishState = (active) => {
                toggleBtn.setAttribute('aria-checked', active ? 'true' : 'false');
                toggleBtn.classList.toggle('bg-success', active);
                toggleBtn.classList.toggle('bg-outline', !active);
                knob.classList.toggle('translate-x-5', active);
                knob.classList.toggle('translate-x-0.5', !active);
                hiddenInput.value = active ? '1' : '0';
            };

            toggleBtn.addEventListener('click', () => {
                setPublishState(toggleBtn.getAttribute('aria-checked') !== 'true');
            });

            document.getElementById('btn-save-post-draft')?.addEventListener('click', () => {
                setPublishState(false);
                if (!mainForm.reportValidity()) return;
                mainForm.submit();
            });

            document.getElementById('btn-publish-post')?.addEventListener('click', () => {
                setPublishState(true);
                if (!mainForm.reportValidity()) return;
                mainForm.submit();
            });
        }

        const coverInput = document.getElementById('cover_image_input');
        const removeInput = document.getElementById('remove_cover_input');
        const dropzone = document.getElementById('cover-dropzone');
        const placeholder = document.getElementById('cover-placeholder');
        const previewBox = document.getElementById('cover-preview-container');
        const previewImg = document.getElementById('cover-preview-img');
        const btnRemove = document.getElementById('btn-remove-cover');

        if (coverInput && dropzone) {
            dropzone.addEventListener('click', (e) => {
                if (e.target !== btnRemove && !btnRemove.contains(e.target)) {
                    coverInput.click();
                }
            });

            coverInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImg.src = e.target.result;
                        placeholder.classList.add('hidden');
                        placeholder.classList.remove('flex');
                        previewBox.classList.remove('hidden');
                        if (removeInput) removeInput.value = '0';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            btnRemove?.addEventListener('click', (e) => {
                e.stopPropagation();
                coverInput.value = '';
                previewImg.src = '';
                previewBox.classList.add('hidden');
                placeholder.classList.remove('hidden');
                placeholder.classList.add('flex');
                if (removeInput) removeInput.value = '1';
            });
        }
    })();
</script>
@endpush
