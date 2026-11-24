export function initProjectDetail() {
    const mainTeam = document.getElementById('team-showcase-main');
    const sidebarDock = document.getElementById('team-sidebar-dock');
    if (!mainTeam || !sidebarDock) return;

    let isDockVisible = false;
    let dockTimeout = null;

    function showDock() {
        if (isDockVisible) return;
        isDockVisible = true;
        clearTimeout(dockTimeout);

        sidebarDock.classList.remove('hidden');
        sidebarDock.setAttribute('aria-hidden', 'false');

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                sidebarDock.classList.remove('max-h-0', 'opacity-0', '-translate-y-2', 'pointer-events-none');
                sidebarDock.classList.add('max-h-[800px]', 'opacity-100', 'translate-y-0', 'pointer-events-auto');
            });
        });
    }

    function hideDock() {
        if (!isDockVisible) return;
        isDockVisible = false;
        clearTimeout(dockTimeout);

        sidebarDock.classList.remove('max-h-[800px]', 'opacity-100', 'translate-y-0', 'pointer-events-auto');
        sidebarDock.classList.add('max-h-0', 'opacity-0', '-translate-y-2', 'pointer-events-none');
        sidebarDock.setAttribute('aria-hidden', 'true');

        dockTimeout = setTimeout(() => {
            if (!isDockVisible) {
                sidebarDock.classList.add('hidden');
            }
        }, 320);
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting && entry.boundingClientRect.top < 0) {
                showDock();
            } else {
                hideDock();
            }
        });
    }, {
        root: null,
        threshold: 0,
        rootMargin: '-80px 0px 0px 0px',
    });

    observer.observe(mainTeam);
}
