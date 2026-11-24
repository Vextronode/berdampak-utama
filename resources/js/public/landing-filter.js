export function initLandingFilter() {
    const section = document.getElementById('portofolio');
    if (!section) return;

    const filterBtns = section.querySelectorAll('.year-filter-btn');
    const cards = section.querySelectorAll('.project-card');
    if (filterBtns.length === 0 || cards.length === 0) return;

    const emptyState = document.getElementById('empty-projects-state');
    const grid = document.getElementById('projects-grid');
    const emptyResetBtn = document.getElementById('empty-reset-btn');
    const defaultYear = section.dataset.defaultYear || 'semua';

    const activeClasses = ['bg-primary', 'text-white', 'border', 'border-primary', 'shadow-xs', 'hover:bg-primary-royal-indigo', 'hover:text-white'];
    const inactiveClasses = ['border', 'border-outline-variant', 'bg-surface', 'text-on-surface-variant', 'hover:border-primary', 'hover:text-primary', 'hover:bg-surface-variant'];

    function applyFilter(year, updateUrl = true) {
        let visibleCount = 0;

        filterBtns.forEach((btn) => {
            const isMatch = btn.getAttribute('data-year-filter') === String(year);
            btn.setAttribute('aria-pressed', isMatch ? 'true' : 'false');
            if (isMatch) {
                inactiveClasses.forEach((cls) => btn.classList.remove(cls));
                activeClasses.forEach((cls) => btn.classList.add(cls));
            } else {
                activeClasses.forEach((cls) => btn.classList.remove(cls));
                inactiveClasses.forEach((cls) => btn.classList.add(cls));
            }
        });

        cards.forEach((card) => {
            const cardYear = card.getAttribute('data-year');
            const show = year === 'semua' || String(cardYear) === String(year);
            card.classList.toggle('hidden', !show);
            if (show) {
                visibleCount++;
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
                : `${window.location.pathname}?year=${encodeURIComponent(year)}`;
            window.history.replaceState(null, '', newUrl);
        }
    }

    filterBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
            applyFilter(this.getAttribute('data-year-filter'), true);
        });
    });

    if (emptyResetBtn) {
        emptyResetBtn.addEventListener('click', () => applyFilter('semua', true));
    }

    const urlParams = new URLSearchParams(window.location.search);
    const initialYear = urlParams.get('year');
    if (initialYear) {
        applyFilter(initialYear, false);
    }
}
