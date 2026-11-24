export function initNavbar() {
    const stickyNavbar = document.getElementById('navbar-sticky');
    const backdrop = document.getElementById('mobile-drawer-backdrop');
    const panel = document.getElementById('mobile-drawer-panel');
    const btnOpenTop = document.getElementById('mobile-drawer-open-top');
    const btnOpenSticky = document.getElementById('mobile-drawer-open-sticky');
    const btnClose = document.getElementById('mobile-drawer-close');

    if (!stickyNavbar) return;

    const sectionIds = ['beranda', 'tentang', 'portofolio', 'catatan-lapangan'];
    const stickyNavLinks = stickyNavbar.querySelectorAll('nav a[data-scroll-to]');
    const topNavLinks = document.querySelectorAll('#navbar-top nav a[data-scroll-to]');
    const drawerNavLinks = document.querySelectorAll('#mobile-drawer-panel .drawer-nav-link[data-scroll-to]');

    function updateActiveNav(activeId) {
        if (!activeId) return;

        stickyNavLinks.forEach((link) => {
            const isMatch = link.getAttribute('data-scroll-to') === activeId;
            link.classList.toggle('font-semibold', isMatch);
            link.classList.toggle('text-primary', isMatch);
            link.classList.toggle('font-medium', !isMatch);
            link.classList.toggle('text-on-surface-variant', !isMatch);
        });

        topNavLinks.forEach((link) => {
            const isMatch = link.getAttribute('data-scroll-to') === activeId;
            link.classList.toggle('text-white', isMatch);
            link.classList.toggle('text-white/90', !isMatch);
        });

        drawerNavLinks.forEach((link) => {
            const isMatch = link.getAttribute('data-scroll-to') === activeId;
            link.classList.toggle('text-vibrant-utama-orange', isMatch);
            link.classList.toggle('bg-white/10', isMatch);
            link.classList.toggle('text-white/95', !isMatch);
        });
    }

    function calculateActiveSection() {
        if ((window.innerHeight + window.scrollY) >= (document.documentElement.scrollHeight - 60)) {
            return sectionIds[sectionIds.length - 1];
        }

        if (window.scrollY < 120) {
            return sectionIds[0];
        }

        const offset = 180;
        let current = sectionIds[0];

        for (let i = 0; i < sectionIds.length; i++) {
            const el = document.getElementById(sectionIds[i]);
            if (el) {
                const top = el.getBoundingClientRect().top + window.scrollY;
                if (window.scrollY + offset >= top) {
                    current = sectionIds[i];
                }
            }
        }
        return current;
    }

    const isLandingPage = stickyNavbar.dataset.isLanding === 'true';
    let isStickyVisible = !isLandingPage;
    let ticking = false;

    function syncStickyNavbar() {
        if (!isLandingPage) return;
        const shouldShow = window.scrollY >= 200;

        if (shouldShow !== isStickyVisible) {
            isStickyVisible = shouldShow;
            if (isStickyVisible) {
                stickyNavbar.classList.remove('-translate-y-full', 'opacity-0', 'pointer-events-none');
                stickyNavbar.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
                stickyNavbar.setAttribute('aria-hidden', 'false');
            } else {
                stickyNavbar.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
                stickyNavbar.classList.add('-translate-y-full', 'opacity-0', 'pointer-events-none');
                stickyNavbar.setAttribute('aria-hidden', 'true');
            }
        }
    }

    function syncScroll() {
        if (isLandingPage) {
            syncStickyNavbar();
            updateActiveNav(calculateActiveSection());
        }
        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(syncScroll);
            ticking = true;
        }
    }, { passive: true });

    window.addEventListener('resize', syncScroll, { passive: true });
    syncScroll();

    function openDrawer() {
        if (!backdrop || !panel) return;
        backdrop.classList.remove('is-closed');
        backdrop.classList.add('is-open');
        panel.classList.remove('is-closed');
        panel.classList.add('is-open');
        document.body.classList.add('overflow-hidden');
        if (btnOpenTop) btnOpenTop.setAttribute('aria-expanded', 'true');
        if (btnOpenSticky) btnOpenSticky.setAttribute('aria-expanded', 'true');
    }

    function closeDrawer() {
        if (!backdrop || !panel) return;
        panel.classList.remove('is-open');
        panel.classList.add('is-closed');
        backdrop.classList.remove('is-open');
        backdrop.classList.add('is-closed');
        document.body.classList.remove('overflow-hidden');
        if (btnOpenTop) btnOpenTop.setAttribute('aria-expanded', 'false');
        if (btnOpenSticky) btnOpenSticky.setAttribute('aria-expanded', 'false');
    }

    if (btnOpenTop) btnOpenTop.addEventListener('click', openDrawer);
    if (btnOpenSticky) btnOpenSticky.addEventListener('click', openDrawer);
    if (btnClose) btnClose.addEventListener('click', closeDrawer);

    if (backdrop) {
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) {
                closeDrawer();
            }
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && panel && panel.classList.contains('is-open')) {
            closeDrawer();
        }
    });

    function cleanHashFromUrl() {
        if (window.location.hash) {
            const clean = window.location.pathname + window.location.search;
            history.replaceState(null, '', clean);
        }
    }

    function scrollToSection(targetId) {
        if (!targetId) return;
        const targetEl = document.getElementById(targetId);
        if (targetEl) {
            targetEl.scrollIntoView({ behavior: 'smooth' });
            cleanHashFromUrl();
        }
    }

    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[data-scroll-to], a[href^="#"]');
        if (!link) return;

        let targetId = link.getAttribute('data-scroll-to');
        if (!targetId) {
            const href = link.getAttribute('href');
            if (href && href.startsWith('#') && href.length > 1) {
                targetId = href.substring(1);
            }
        }

        if (targetId) {
            e.preventDefault();
            closeDrawer();
            updateActiveNav(targetId);
            scrollToSection(targetId);
        }
    });

    if (window.location.hash) {
        const initialHash = window.location.hash.substring(1);
        cleanHashFromUrl();
        if (initialHash) {
            setTimeout(() => scrollToSection(initialHash), 100);
        }
    }

    window.addEventListener('hashchange', cleanHashFromUrl);
}
