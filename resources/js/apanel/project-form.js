import {
    bindAutoSlug,
    bindCharCounter,
    bindPublishControls,
    bindSingleImageDropzone,
} from './form-helpers';

/**
 * Escape server-provided text before it is placed inside an HTML template string.
 */
function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

/**
 * Bind image previews and clear actions for the project gallery grid and supervisor photo.
 */
function initProjectMediaUploads() {
    document.querySelectorAll('.gallery-slot').forEach((slot) => {
        const input = slot.querySelector('.gallery-file-input');
        const preview = slot.querySelector('.gallery-preview-img');
        const placeholderBox = slot.querySelector('.gallery-placeholder');
        const removeBtn = slot.querySelector('.btn-remove-gallery');
        const existingInput = slot.querySelector('.existing-gallery-url-input');

        input?.addEventListener('change', () => {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = (event) => {
                preview.src = event.target.result;
                preview.classList.remove('hidden');
                placeholderBox?.classList.add('hidden');
                placeholderBox?.classList.remove('flex');
                removeBtn?.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        });

        removeBtn?.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            if (input) input.value = '';
            if (existingInput) existingInput.value = '';
            if (preview) {
                preview.src = '';
                preview.classList.add('hidden');
            }
            placeholderBox?.classList.remove('hidden');
            placeholderBox?.classList.add('flex');
            removeBtn.classList.add('hidden');
        });
    });

    const supervisorInput = document.querySelector('.supervisor-photo-input');
    const btnRemoveSupervisor = document.getElementById('btn-remove-supervisor-photo');
    const removeSupervisorInput = document.getElementById('remove_supervisor_photo_input');
    if (!supervisorInput) return;

    const label = supervisorInput.closest('label');
    const preview = label?.querySelector('.supervisor-photo-preview');
    const placeholderBox = label?.querySelector('.supervisor-photo-placeholder');

    supervisorInput.addEventListener('change', () => {
        if (!supervisorInput.files || !supervisorInput.files[0]) return;
        const reader = new FileReader();
        reader.onload = (event) => {
            if (preview) {
                preview.src = event.target.result;
                preview.classList.remove('hidden');
            }
            placeholderBox?.classList.add('hidden');
            placeholderBox?.classList.remove('flex');
            btnRemoveSupervisor?.classList.remove('hidden');
            if (removeSupervisorInput) removeSupervisorInput.value = '0';
        };
        reader.readAsDataURL(supervisorInput.files[0]);
    });

    btnRemoveSupervisor?.addEventListener('click', () => {
        supervisorInput.value = '';
        if (preview) {
            preview.src = '';
            preview.classList.add('hidden');
        }
        placeholderBox?.classList.remove('hidden');
        placeholderBox?.classList.add('flex');
        btnRemoveSupervisor.classList.add('hidden');
        if (removeSupervisorInput) removeSupervisorInput.value = '1';
    });
}

/**
 * Bind dynamic student contributor row creation, photo preview, and removal.
 */
function initContributorRows() {
    const container = document.getElementById('contributors-container');
    const addBtn = document.getElementById('btn-add-contributor');
    if (!container) return;

    let nextIndex = Number(container.dataset.nextIndex || 0);

    const bindRowEvents = (row) => {
        const photoInput = row.querySelector('.contributor-photo-input');
        const photoPreview = row.querySelector('.contributor-preview-img');
        const photoPlaceholder = row.querySelector('.contributor-photo-placeholder');

        if (photoInput && photoPreview) {
            photoInput.addEventListener('change', () => {
                if (!photoInput.files || !photoInput.files[0]) return;
                const reader = new FileReader();
                reader.onload = (event) => {
                    photoPreview.src = event.target.result;
                    photoPreview.classList.remove('hidden');
                    photoPlaceholder?.classList.add('hidden');
                };
                reader.readAsDataURL(photoInput.files[0]);
            });
        }

        row.querySelector('.btn-remove-contributor')?.addEventListener('click', () => {
            row.remove();
        });
    };

    document.querySelectorAll('.contributor-row').forEach(bindRowEvents);

    addBtn?.addEventListener('click', () => {
        const index = nextIndex++;
        const rowHtml = `
            <div class="contributor-row bg-surface-variant/40 hover:bg-surface-variant/70 border border-outline-variant hover:border-primary/40 rounded-2xl p-4 sm:p-5 flex flex-col md:flex-row items-start gap-4 sm:gap-5 relative transition-all duration-150 shadow-xs" data-index="${index}">
                <input type="hidden" name="contributors[${index}][existing_avatar]" value="" class="contributor-existing-avatar">
                <div class="flex flex-col items-center gap-1.5 shrink-0 self-center md:self-start">
                    <label class="w-16 h-16 rounded-full border-2 border-dashed border-outline-variant bg-surface flex flex-col items-center justify-center text-on-surface-variant hover:border-primary hover:text-primary transition-colors cursor-pointer relative overflow-hidden group shadow-xs" title="Unggah Foto Mahasiswa">
                        <input type="file" name="contributors[${index}][photo]" accept="image/*" class="contributor-photo-input hidden">
                        <svg class="contributor-photo-placeholder w-6 h-6 text-outline group-hover:text-primary transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                            <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                        <img class="contributor-preview-img hidden w-full h-full object-cover" alt="Foto">
                    </label>
                    <span class="text-[10px] font-medium text-on-surface-variant">Foto Profil</span>
                </div>

                <div class="flex-1 w-full flex flex-col gap-3.5">
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3.5">
                        <div class="sm:col-span-6 flex flex-col gap-1">
                            <label class="font-medium text-xs text-on-surface">Nama Lengkap Mahasiswa <span class="text-error">*</span></label>
                            <input type="text" name="contributors[${index}][name]" placeholder="Contoh: Raihan Dastra" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                        </div>
                        <div class="sm:col-span-3 flex flex-col gap-1">
                            <label class="font-medium text-xs text-on-surface">Nomor NPM <span class="text-error">*</span></label>
                            <input type="text" name="contributors[${index}][npm]" placeholder="Contoh: 230611001" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm font-mono tabular-nums placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                        </div>
                        <div class="sm:col-span-3 flex flex-col gap-1">
                            <label class="font-medium text-xs text-on-surface">Angkatan</label>
                            <input type="text" name="contributors[${index}][class_year]" placeholder="Contoh: 2023" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3.5">
                        <div class="sm:col-span-6 flex flex-col gap-1">
                            <label class="font-medium text-xs text-on-surface">Jurusan / Program Studi <span class="text-error">*</span></label>
                            <input type="text" name="contributors[${index}][major]" placeholder="Contoh: S1 Teknik Informatika" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                        </div>
                        <div class="sm:col-span-6 flex flex-col gap-1">
                            <label class="font-medium text-xs text-on-surface">Peran / Tanggung Jawab Teknis <span class="text-error">*</span></label>
                            <input type="text" name="contributors[${index}][role]" placeholder="Contoh: Full Stack Developer" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-remove-contributor absolute top-3 right-3 md:relative md:top-auto md:right-auto p-2 text-outline hover:text-error hover:bg-error-container/40 rounded-xl transition-colors shrink-0 self-start mt-0.5 cursor-pointer" title="Hapus Anggota Mahasiswa">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                </button>
            </div>
        `;
        const temp = document.createElement('div');
        temp.innerHTML = rowHtml.trim();
        const newRow = temp.firstChild;
        container.appendChild(newRow);
        bindRowEvents(newRow);
    });
}

/**
 * Bind tech stack filter input and quick-add tech stack modal AJAX creation.
 */
function initTechStackControls() {
    const techFilterSearch = document.getElementById('tech-filter-search');
    const techCards = document.querySelectorAll('.tech-item-card');

    techFilterSearch?.addEventListener('input', () => {
        const query = techFilterSearch.value.toLowerCase().trim();
        techCards.forEach((card) => {
            const name = card.dataset.name || '';
            const slug = card.dataset.slug || '';
            card.style.display = (name.includes(query) || slug.includes(query)) ? '' : 'none';
        });
    });

    const techModal = document.getElementById('tech-stack-modal');
    const btnOpenModal = document.getElementById('btn-open-tech-modal');
    const btnCloseModal = document.getElementById('btn-close-tech-modal');
    const btnCancelModal = document.getElementById('btn-cancel-tech-modal');
    const quickTechForm = document.getElementById('quick-tech-form');
    const modalTechName = document.getElementById('modal-tech-name');
    const modalTechSlug = document.getElementById('modal-tech-slug');
    const modalIconType = document.getElementById('modal-icon-type');
    const modalCustomFileBox = document.getElementById('modal-custom-file-box');
    const modalColorPicker = document.getElementById('modal-color-picker');
    const modalBrandColor = document.getElementById('modal-brand-color');
    const modalErrorBox = document.getElementById('modal-error-box');
    const techGrid = document.getElementById('tech-stacks-grid');

    if (!techModal || !btnOpenModal || !quickTechForm) return;

    const storeUrl = quickTechForm.dataset.techStoreUrl;
    const csrfToken = quickTechForm.dataset.csrfToken;

    const closeModal = () => {
        techModal.classList.add('hidden');
        quickTechForm.reset();
        modalCustomFileBox?.classList.add('hidden');
    };

    btnOpenModal.addEventListener('click', () => {
        modalErrorBox?.classList.add('hidden');
        techModal.classList.remove('hidden');
        modalTechName?.focus();
    });

    btnCloseModal?.addEventListener('click', closeModal);
    btnCancelModal?.addEventListener('click', closeModal);

    modalTechName?.addEventListener('input', () => {
        if (modalTechSlug) {
            modalTechSlug.value = modalTechName.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9]/g, '');
        }
    });

    modalIconType?.addEventListener('change', () => {
        modalCustomFileBox?.classList.toggle('hidden', modalIconType.value !== 'custom_upload');
    });

    modalColorPicker?.addEventListener('input', () => {
        if (modalBrandColor) {
            modalBrandColor.value = modalColorPicker.value.toUpperCase();
        }
    });

    modalBrandColor?.addEventListener('input', () => {
        if (modalColorPicker && /^#[0-9A-Fa-f]{6}$/.test(modalBrandColor.value)) {
            modalColorPicker.value = modalBrandColor.value;
        }
    });

    quickTechForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        modalErrorBox?.classList.add('hidden');

        const formData = new FormData();
        formData.append('name', modalTechName?.value.trim() || '');
        formData.append('slug', modalTechSlug?.value.trim() || '');
        formData.append('icon_type', modalIconType?.value || '');
        formData.append('brand_color', modalBrandColor?.value.trim() || '');

        const fileInput = document.getElementById('modal-custom-file');
        if (fileInput?.files?.[0]) {
            formData.append('custom_icon', fileInput.files[0]);
        }

        try {
            const response = await fetch(storeUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const result = await response.json();
            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Gagal menyimpan tech stack.');
            }

            const stack = result.tech_stack;
            const cardLabel = document.createElement('label');
            cardLabel.className = 'tech-item-card cursor-pointer border border-primary bg-primary-container/10 rounded-xl p-3 flex flex-col items-center gap-2 text-center hover:border-primary hover:shadow-xs transition-all duration-150 relative select-none';
            cardLabel.dataset.name = stack.name.toLowerCase();
            cardLabel.dataset.slug = stack.slug.toLowerCase();

            const name = escapeHtml(stack.name);
            const iconUrl = escapeHtml(stack.icon_value);
            const brandColor = escapeHtml(stack.brand_color);
            const monogram = escapeHtml(stack.monogram);

            let iconMarkup = '';
            // icon_value svg_raw sudah disanitasi di server (enshrined/svg-sanitize)
            if (stack.icon_type === 'svg_raw' && stack.icon_value) {
                iconMarkup = `<div class="w-8 h-8 flex items-center justify-center shrink-0 [&>svg]:w-full [&>svg]:h-full" aria-hidden="true">${stack.icon_value}</div>`;
            } else if (stack.icon_type === 'cdn_url' && stack.icon_value) {
                iconMarkup = `<img src="${iconUrl}" alt="${name}" class="w-8 h-8 object-contain shrink-0" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                              <div class="w-8 h-8 hidden items-center justify-center rounded text-white text-xs font-bold shrink-0 tracking-wider" style="background-color: ${brandColor};">${monogram}</div>`;
            } else if (stack.icon_type === 'custom_upload' && stack.icon_value) {
                iconMarkup = `<img src="${iconUrl}" alt="${name}" class="w-8 h-8 object-contain shrink-0">`;
            } else {
                iconMarkup = `<div class="w-8 h-8 flex items-center justify-center rounded text-white text-xs font-bold shrink-0 shadow-xs tracking-wider" style="background-color: ${brandColor};">${monogram}</div>`;
            }

            cardLabel.innerHTML = `
                <input type="checkbox" name="tech_stack_ids[]" value="${escapeHtml(stack.id)}" checked class="tech-item-checkbox absolute top-2.5 right-2.5 rounded text-primary focus:ring-primary cursor-pointer">
                ${iconMarkup}
                <span class="text-xs font-semibold text-on-surface line-clamp-1 mt-0.5">${name}</span>
            `;

            techGrid?.prepend(cardLabel);
            closeModal();
        } catch (err) {
            if (modalErrorBox) {
                modalErrorBox.textContent = err.message;
                modalErrorBox.classList.remove('hidden');
            }
        }
    });
}

/**
 * Bind dynamic key feature rows and the visual SVG icon picker popover.
 */
function initFeatureRows() {
    const featuresContainer = document.getElementById('features-container');
    const btnAddFeature = document.getElementById('btn-add-feature');
    if (!featuresContainer) return;

    let featureIcons = {};
    try {
        featureIcons = JSON.parse(featuresContainer.dataset.featureIcons || '{}');
    } catch {
        featureIcons = {};
    }

    let nextFeatureIndex = Number(featuresContainer.dataset.nextIndex || 0);

    const buildFeatureSvg = (iconKey, sizeClass) => {
        const meta = featureIcons[iconKey] || featureIcons.check;
        if (!meta) return '';
        return `<svg class="${sizeClass} ${meta.color}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">${meta.paths}</svg>`;
    };

    const closeAllIconPopovers = (exceptPopover = null) => {
        document.querySelectorAll('.feature-icon-popover').forEach((pop) => {
            if (pop !== exceptPopover) {
                pop.classList.add('hidden');
            }
        });
    };

    document.addEventListener('click', (event) => {
        if (!event.target.closest('.feature-icon-picker-wrap')) {
            closeAllIconPopovers();
        }
    });

    const bindFeatureRowEvents = (row) => {
        const toggleBtn = row.querySelector('.btn-toggle-icon-picker');
        const popover = row.querySelector('.feature-icon-popover');
        const iconInput = row.querySelector('.feature-icon-input');
        const iconPreview = row.querySelector('.feature-icon-preview');
        const iconLabel = row.querySelector('.feature-icon-label');
        const removeBtn = row.querySelector('.btn-remove-feature');

        if (toggleBtn && popover) {
            toggleBtn.addEventListener('click', (event) => {
                event.stopPropagation();
                const wasHidden = popover.classList.contains('hidden');
                closeAllIconPopovers(popover);
                popover.classList.toggle('hidden', !wasHidden);
            });
        }

        row.querySelectorAll('.btn-pick-feature-icon').forEach((pickBtn) => {
            pickBtn.addEventListener('click', () => {
                const key = pickBtn.dataset.iconKey;
                const label = pickBtn.dataset.iconLabel;

                if (iconInput) iconInput.value = key;
                if (iconPreview) iconPreview.innerHTML = buildFeatureSvg(key, 'w-5 h-5');
                if (iconLabel) iconLabel.textContent = label;

                row.querySelectorAll('.btn-pick-feature-icon').forEach((btn) => {
                    const isSelected = btn.dataset.iconKey === key;
                    btn.classList.toggle('border-primary', isSelected);
                    btn.classList.toggle('bg-primary-container/20', isSelected);
                    btn.classList.toggle('border-transparent', !isSelected);
                });

                popover?.classList.add('hidden');
            });
        });

        removeBtn?.addEventListener('click', () => {
            row.remove();
        });
    };

    document.querySelectorAll('.feature-row').forEach(bindFeatureRowEvents);

    btnAddFeature?.addEventListener('click', () => {
        const index = nextFeatureIndex++;
        const defaultKey = 'check';
        const defaultMeta = featureIcons[defaultKey] || { label: 'Check' };

        const paletteHtml = Object.entries(featureIcons).map(([key, meta]) => `
            <button type="button"
                data-icon-key="${key}"
                data-icon-label="${meta.label}"
                class="btn-pick-feature-icon flex flex-col items-center gap-1.5 p-2 rounded-xl border ${key === defaultKey ? 'border-primary bg-primary-container/20' : 'border-transparent hover:border-outline-variant hover:bg-surface-variant'} transition-all cursor-pointer text-center">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-container">
                    ${buildFeatureSvg(key, 'w-4 h-4')}
                </span>
                <span class="text-[10px] font-medium text-on-surface leading-tight line-clamp-1">${meta.label}</span>
            </button>
        `).join('');

        const rowHtml = `
            <div class="feature-row bg-surface-variant/40 hover:bg-surface-variant/70 border border-outline-variant hover:border-primary/40 rounded-2xl p-4 sm:p-5 flex flex-col md:flex-row items-start gap-4 relative transition-all duration-150 shadow-xs" data-index="${index}">
                <div class="feature-icon-picker-wrap relative shrink-0 w-full md:w-48">
                    <input type="hidden" name="features[${index}][icon]" value="${defaultKey}" class="feature-icon-input">
                    <span class="block font-medium text-xs text-on-surface mb-1">Simbol Fitur</span>
                    <button type="button" class="btn-toggle-icon-picker w-full flex items-center justify-between gap-2.5 p-2 rounded-xl border border-outline-variant bg-surface hover:border-primary transition-colors shadow-xs cursor-pointer text-left">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="feature-icon-preview inline-flex items-center justify-center w-9 h-9 rounded-lg bg-primary-container shrink-0">
                                ${buildFeatureSvg(defaultKey, 'w-5 h-5')}
                            </span>
                            <span class="feature-icon-label text-xs font-medium text-on-surface truncate">${defaultMeta.label}</span>
                        </div>
                        <svg class="w-4 h-4 text-on-surface-variant shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>

                    <div class="feature-icon-popover hidden absolute left-0 top-full mt-2 w-72 sm:w-80 bg-surface border border-outline-variant rounded-2xl shadow-xl p-3 z-40">
                        <p class="text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider mb-2 px-1">Pilih Simbol Visual</p>
                        <div class="grid grid-cols-3 gap-1.5">
                            ${paletteHtml}
                        </div>
                    </div>
                </div>

                <div class="flex-1 w-full flex flex-col gap-3">
                    <div class="flex flex-col gap-1">
                        <label class="font-medium text-xs text-on-surface">Judul Fitur</label>
                        <input type="text" name="features[${index}][title]" placeholder="Contoh: Katalog Komoditas Unggulan Digital" class="w-full px-3.5 py-2.5 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs">
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="font-medium text-xs text-on-surface">Deskripsi Singkat Fitur</label>
                        <textarea name="features[${index}][description]" rows="2" placeholder="Contoh: Etalase informasi terstruktur untuk produk olahan makanan dan hasil bumi desa mitra." class="w-full px-3.5 py-2 rounded-xl border border-outline-variant bg-surface text-on-surface text-sm placeholder:text-on-surface-variant/60 focus:border-primary focus:ring-1 focus:ring-primary shadow-xs leading-relaxed"></textarea>
                    </div>
                </div>

                <button type="button" class="btn-remove-feature absolute top-3 right-3 md:relative md:top-auto md:right-auto p-2 text-outline hover:text-error hover:bg-error-container/40 rounded-xl transition-colors shrink-0 self-start mt-5 cursor-pointer" title="Hapus Fitur Ini">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                </button>
            </div>
        `;

        const temp = document.createElement('div');
        temp.innerHTML = rowHtml.trim();
        const newRow = temp.firstChild;
        featuresContainer.appendChild(newRow);
        bindFeatureRowEvents(newRow);
    });
}

/**
 * Initialize interactive behavior for the admin project create/edit form.
 */
export function initProjectForm() {
    const formEl = document.getElementById('new-project-form');
    if (!formEl) return;

    bindAutoSlug(formEl, 'project-title', 'project-slug');
    bindCharCounter('short-desc', 'short-desc-count', 200);

    bindPublishControls({
        formEl,
        toggleId: 'publish-toggle',
        knobId: 'publish-toggle-knob',
        hiddenInputId: 'is_published_input',
        saveDraftBtnId: 'btn-save-draft',
        publishBtnId: 'btn-publish-now',
    });

    bindSingleImageDropzone({
        inputId: 'dashboard_thumbnail_input',
        removeInputId: 'remove_thumbnail_input',
        dropzoneId: 'thumbnail-dropzone',
        placeholderId: 'thumbnail-placeholder',
        previewContainerId: 'thumbnail-preview-container',
        previewImgId: 'thumbnail-preview-img',
        removeBtnId: 'btn-remove-thumbnail',
    });

    initProjectMediaUploads();
    initContributorRows();
    initTechStackControls();
    initFeatureRows();
}
