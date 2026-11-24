import {
    bindAutoSlug,
    bindCharCounter,
    bindPublishControls,
    bindSingleImageDropzone,
} from './form-helpers';

/**
 * Initialize interactive behavior for the admin field-post create/edit form.
 */
export function initFieldPostForm() {
    const formEl = document.getElementById('field-post-form');
    if (!formEl) return;

    bindAutoSlug(formEl, 'post-title', 'post-slug');
    bindCharCounter('post-summary', 'post-summary-count', 300);

    bindPublishControls({
        formEl,
        toggleId: 'post-publish-toggle',
        knobId: 'post-publish-knob',
        hiddenInputId: 'post_is_published_input',
        saveDraftBtnId: 'btn-save-post-draft',
        publishBtnId: 'btn-publish-post',
    });

    bindSingleImageDropzone({
        inputId: 'cover_image_input',
        removeInputId: 'remove_cover_input',
        dropzoneId: 'cover-dropzone',
        placeholderId: 'cover-placeholder',
        previewContainerId: 'cover-preview-container',
        previewImgId: 'cover-preview-img',
        removeBtnId: 'btn-remove-cover',
    });
}
