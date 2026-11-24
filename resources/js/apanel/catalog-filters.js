/**
 * Initialize live table/card filtering and delete confirmation modal for an admin catalog view.
 */
function setupCatalogView(config) {
    const searchInput = document.getElementById(config.searchId);
    const secondaryFilter = document.getElementById(config.secondaryFilterId);
    const statusFilter = document.getElementById(config.statusFilterId);
    const desktopRows = document.querySelectorAll(config.desktopSelector);
    const mobileRows = document.querySelectorAll(config.mobileSelector);
    const emptyBox = document.getElementById(config.emptyBoxId);
    const resetBtn = document.getElementById(config.resetBtnId);
    const visibleBadge = document.getElementById(config.visibleBadgeId);

    if (searchInput || secondaryFilter || statusFilter) {
        const applyFilter = () => {
            const q = (searchInput ? searchInput.value : '').toLowerCase().trim();
            const secondaryVal = secondaryFilter ? secondaryFilter.value : 'all';
            const statusVal = statusFilter ? statusFilter.value : 'all';
            let visibleCount = 0;

            const updateNodes = (nodes, countMode) => {
                nodes.forEach((node) => {
                    const haystack = node.dataset.search || '';
                    const rowSecondary = node.dataset[config.secondaryDatasetKey] || '';
                    const rowStatus = node.dataset.status || '';

                    const matches = (!q || haystack.includes(q))
                        && (secondaryVal === 'all' || rowSecondary === secondaryVal)
                        && (statusVal === 'all' || rowStatus === statusVal);

                    node.classList.toggle('hidden', !matches);
                    if (countMode && matches) {
                        visibleCount++;
                    }
                });
            };

            updateNodes(desktopRows, true);
            updateNodes(mobileRows, false);

            if (visibleBadge) {
                visibleBadge.textContent = `${visibleCount} ${config.badgeSuffix}`;
            }
            if (emptyBox) {
                emptyBox.classList.toggle('hidden', visibleCount > 0);
            }
        };

        searchInput?.addEventListener('input', applyFilter);
        secondaryFilter?.addEventListener('change', applyFilter);
        statusFilter?.addEventListener('change', applyFilter);

        resetBtn?.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            if (secondaryFilter) secondaryFilter.value = 'all';
            if (statusFilter) statusFilter.value = 'all';
            applyFilter();
        });
    }

    const deleteModal = document.getElementById(config.modalId);
    const deleteForm = document.getElementById(config.modalFormId);
    const deleteName = document.getElementById(config.modalNameId);
    const cancelBtn = document.getElementById(config.cancelBtnId);

    document.querySelectorAll(config.openModalSelector).forEach((btn) => {
        btn.addEventListener('click', () => {
            if (!deleteModal || !deleteForm || !deleteName) return;
            deleteForm.setAttribute('action', btn.dataset.deleteUrl || '');
            deleteName.textContent = `"${btn.dataset[config.titleDatasetKey] || ''}"`;
            deleteModal.classList.remove('hidden');
        });
    });

    cancelBtn?.addEventListener('click', () => {
        deleteModal?.classList.add('hidden');
    });
}

/**
 * Bind catalog filters and delete modals on Admin dashboard and field-post index pages.
 */
export function initCatalogControls() {
    setupCatalogView({
        searchId: 'dashboard-project-search',
        secondaryFilterId: 'dashboard-year-filter',
        secondaryDatasetKey: 'year',
        statusFilterId: 'dashboard-status-filter',
        desktopSelector: '.project-row-item',
        mobileSelector: '.project-mobile-item',
        emptyBoxId: 'dashboard-empty-filter',
        resetBtnId: 'btn-reset-dashboard-filter',
        visibleBadgeId: 'visible-project-badge',
        badgeSuffix: 'Proyek',
        modalId: 'delete-project-modal',
        modalFormId: 'delete-project-form',
        modalNameId: 'delete-modal-project-name',
        cancelBtnId: 'btn-cancel-delete-modal',
        openModalSelector: '.btn-open-delete-modal',
        titleDatasetKey: 'projectTitle',
    });

    setupCatalogView({
        searchId: 'post-search-input',
        secondaryFilterId: 'post-project-filter',
        secondaryDatasetKey: 'project',
        statusFilterId: 'post-status-filter',
        desktopSelector: '.post-row-item',
        mobileSelector: '.post-mobile-item',
        emptyBoxId: 'post-empty-filter',
        resetBtnId: 'btn-reset-post-filter',
        visibleBadgeId: 'visible-post-badge',
        badgeSuffix: 'Catatan',
        modalId: 'delete-post-modal',
        modalFormId: 'delete-post-form',
        modalNameId: 'delete-modal-post-name',
        cancelBtnId: 'btn-cancel-delete-post',
        openModalSelector: '.btn-open-delete-post',
        titleDatasetKey: 'postTitle',
    });
}
