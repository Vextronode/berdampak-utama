/**
 * Auto-populate a slug field from the title input while creating a new record.
 */
export function bindAutoSlug(formEl, titleId, slugId) {
    if (!formEl || formEl.dataset.isEdit === 'true') return;

    const titleInput = document.getElementById(titleId);
    const slugInput = document.getElementById(slugId);
    if (!titleInput || !slugInput) return;

    titleInput.addEventListener('input', () => {
        slugInput.value = titleInput.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    });
}

/**
 * Bind a live character counter badge to a text input or textarea.
 */
export function bindCharCounter(inputId, counterId, maxLength) {
    const inputEl = document.getElementById(inputId);
    const counterEl = document.getElementById(counterId);
    if (!inputEl || !counterEl) return;

    const updateCount = () => {
        counterEl.textContent = `${inputEl.value.length} / ${maxLength}`;
    };

    inputEl.addEventListener('input', updateCount);
    updateCount();
}

/**
 * Bind publish switch toggle and draft/publish submit action buttons.
 */
export function bindPublishControls({
    formEl,
    toggleId,
    knobId,
    hiddenInputId,
    saveDraftBtnId,
    publishBtnId,
}) {
    const toggleBtn = document.getElementById(toggleId);
    const knob = document.getElementById(knobId);
    const hiddenInput = document.getElementById(hiddenInputId);
    if (!formEl || !toggleBtn || !knob || !hiddenInput) return;

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

    document.getElementById(saveDraftBtnId)?.addEventListener('click', () => {
        setPublishState(false);
        if (!formEl.reportValidity()) return;
        formEl.submit();
    });

    document.getElementById(publishBtnId)?.addEventListener('click', () => {
        setPublishState(true);
        if (!formEl.reportValidity()) return;
        formEl.submit();
    });
}

/**
 * Bind a single-image dropzone with preview and clear/remove tracking.
 */
export function bindSingleImageDropzone({
    inputId,
    removeInputId,
    dropzoneId,
    placeholderId,
    previewContainerId,
    previewImgId,
    removeBtnId,
}) {
    const fileInput = document.getElementById(inputId);
    const removeInput = document.getElementById(removeInputId);
    const dropzone = document.getElementById(dropzoneId);
    const placeholder = document.getElementById(placeholderId);
    const previewContainer = document.getElementById(previewContainerId);
    const previewImg = document.getElementById(previewImgId);
    const btnRemove = document.getElementById(removeBtnId);

    if (!fileInput || !dropzone || !previewContainer || !previewImg) return;

    dropzone.addEventListener('click', (event) => {
        if (event.target !== btnRemove && (!btnRemove || !btnRemove.contains(event.target))) {
            fileInput.click();
        }
    });

    fileInput.addEventListener('change', () => {
        if (!fileInput.files || !fileInput.files[0]) return;
        const reader = new FileReader();
        reader.onload = (event) => {
            previewImg.src = event.target.result;
            placeholder?.classList.add('hidden');
            placeholder?.classList.remove('flex');
            previewContainer.classList.remove('hidden');
            if (removeInput) removeInput.value = '0';
        };
        reader.readAsDataURL(fileInput.files[0]);
    });

    btnRemove?.addEventListener('click', (event) => {
        event.stopPropagation();
        fileInput.value = '';
        previewImg.src = '';
        previewContainer.classList.add('hidden');
        placeholder?.classList.remove('hidden');
        placeholder?.classList.add('flex');
        if (removeInput) removeInput.value = '1';
    });
}
