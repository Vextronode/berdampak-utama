<div id="navbar-top" class="absolute top-0 inset-x-0 z-30 pointer-events-auto bg-gradient-to-b from-black/80 via-black/35 to-transparent animate-hero-nav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 sm:h-24 flex items-center justify-between">
        <nav class="hidden md:flex items-center justify-end gap-6 lg:gap-8 flex-1 basis-0 pr-6 lg:pr-8" aria-label="Navigasi Atas Kiri">
            <a href="#beranda" data-scroll-to="beranda" class="font-headline text-xs lg:text-sm font-semibold tracking-wider text-white hover:text-vibrant-utama-orange transition-colors cursor-pointer">
                Beranda
            </a>
            <a href="#tentang" data-scroll-to="tentang" class="font-headline text-xs lg:text-sm font-semibold tracking-wider text-white/90 hover:text-white transition-colors cursor-pointer">
                Tentang
            </a>
        </nav>

        <div class="flex items-center justify-start md:justify-center shrink-0">
            <a href="#beranda" data-scroll-to="beranda" class="group flex items-center gap-2 sm:gap-3.5 p-1 focus:outline-none focus:ring-2 focus:ring-white/60 rounded-xl cursor-pointer" aria-label="Universitas Widyatama x Diktisaintek Berdampak">
                <img src="{{ asset('images/widyatama-emblem-white.png') }}" 
                     alt="Emblem Universitas Widyatama" 
                     class="h-8 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105 drop-shadow-md">
                <span class="h-5 sm:h-6 w-px bg-white/30" aria-hidden="true"></span>
                <img src="{{ asset('images/diktisaintek-transparent.png') }}" 
                     alt="Logo Diktisaintek Berdampak" 
                     class="h-6 sm:h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105 drop-shadow-md">
            </a>
        </div>

        <nav class="hidden md:flex items-center justify-start gap-6 lg:gap-8 flex-1 basis-0 pl-6 lg:pl-8" aria-label="Navigasi Atas Kanan">
            <a href="#portofolio" data-scroll-to="portofolio" class="font-headline text-xs lg:text-sm font-semibold tracking-wider text-white/90 hover:text-white transition-colors cursor-pointer">
                Portofolio Proyek
            </a>
            <a href="#catatan-lapangan" data-scroll-to="catatan-lapangan" class="font-headline text-xs lg:text-sm font-semibold tracking-wider text-white/90 hover:text-white transition-colors cursor-pointer">
                Catatan Lapangan
            </a>
            <a href="https://www.widyatama.ac.id/" target="_blank" rel="noopener noreferrer" class="font-headline text-xs lg:text-sm font-semibold tracking-wider text-white/90 hover:text-white transition-colors flex items-center gap-1.5">
                <span>Widyatama.ac.id</span>
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
            <a href="#portofolio" data-scroll-to="portofolio" class="p-2 text-white/90 hover:text-white transition-colors rounded-full hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white cursor-pointer" aria-label="Cari dan Filter Proyek">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </a>
        </nav>

        <div class="flex md:hidden shrink-0">
            <button type="button" 
                    id="mobile-drawer-open-top"
                    class="p-2 sm:p-2.5 rounded-lg text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white cursor-pointer transition-colors"
                    aria-expanded="false" 
                    aria-label="Buka menu navigasi mobile">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>
</div>

<header id="navbar-sticky" 
        class="fixed top-0 inset-x-0 z-40 transform -translate-y-full opacity-0 pointer-events-none transition-all duration-300 ease-out bg-surface/96 backdrop-blur-md border-b border-outline-variant shadow-xs"
        aria-hidden="true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-3 sm:gap-4">
        <a href="#beranda" data-scroll-to="beranda" class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1 focus:outline-none focus:ring-2 focus:ring-primary rounded-md p-1 cursor-pointer">
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                <img src="{{ asset('images/logo-widyatama-transparent.png') }}" alt="Logo Universitas Widyatama" class="h-7 sm:h-10 w-auto object-contain">
                <img src="{{ asset('images/diktisaintek-transparent.png') }}" alt="Logo Diktisaintek Berdampak" class="h-6 sm:h-8 w-auto object-contain">
            </div>
            <div class="flex flex-col min-w-0">
                <span class="font-headline font-semibold text-xs sm:text-base text-primary leading-tight truncate">Kampus Berdampak</span>
                <span class="font-body text-[10px] sm:text-xs text-on-surface-variant truncate hidden sm:block">berdampak.widyatama.ac.id</span>
            </div>
        </a>

        <nav class="hidden md:flex items-center gap-6 lg:gap-8 shrink-0" aria-label="Navigasi Utama Sticky">
            <a href="#beranda" data-scroll-to="beranda" class="sticky-nav-link font-body text-sm font-semibold text-primary hover:text-vibrant-utama-orange transition-colors cursor-pointer">Beranda</a>
            <a href="#tentang" data-scroll-to="tentang" class="sticky-nav-link font-body text-sm font-medium text-on-surface-variant hover:text-primary transition-colors cursor-pointer">Tentang</a>
            <a href="#portofolio" data-scroll-to="portofolio" class="sticky-nav-link font-body text-sm font-medium text-on-surface-variant hover:text-primary transition-colors cursor-pointer">Portofolio Proyek</a>
            <a href="#catatan-lapangan" data-scroll-to="catatan-lapangan" class="sticky-nav-link font-body text-sm font-medium text-on-surface-variant hover:text-primary transition-colors cursor-pointer">Catatan Lapangan & Blog</a>
        </nav>

        <div class="flex md:hidden shrink-0">
            <button type="button" 
                    id="mobile-drawer-open-sticky"
                    class="p-2 sm:p-2.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-variant focus:outline-none focus:ring-2 focus:ring-primary cursor-pointer transition-colors"
                    aria-expanded="false" 
                    aria-label="Buka menu navigasi mobile">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </div>
</header>

<div id="mobile-drawer-backdrop" 
     class="fixed inset-0 z-50 bg-black/65 backdrop-blur-sm is-closed md:hidden"
     aria-hidden="true"></div>

<aside id="mobile-drawer-panel" 
     class="fixed top-0 right-0 bottom-0 z-50 w-[86vw] max-w-sm bg-neutral-950/98 border-l border-white/10 text-white shadow-2xl flex flex-col justify-between p-6 sm:p-8 is-closed overflow-y-auto md:hidden"
     role="dialog"
     aria-modal="true"
     aria-label="Menu Navigasi Mobile">
    
    <div class="flex items-center justify-between pb-6 border-b border-white/10">
        <a href="#beranda" data-scroll-to="beranda" class="flex items-center gap-2.5 cursor-pointer">
            <img src="{{ asset('images/widyatama-emblem-white.png') }}" alt="Logo Widyatama" class="h-9 w-auto object-contain">
            <span class="h-5 w-px bg-white/20"></span>
            <img src="{{ asset('images/diktisaintek-transparent.png') }}" alt="Logo Diktisaintek" class="h-7 w-auto object-contain">
        </a>

        <button type="button" 
                id="mobile-drawer-close"
                class="p-2 rounded-full text-white/80 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white transition-all duration-200 active:scale-95 cursor-pointer"
                aria-label="Tutup menu navigasi">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex flex-col py-6 space-y-1 flex-1 justify-center" aria-label="Menu Mobile Drawer">
        <a href="#beranda" data-scroll-to="beranda" class="drawer-nav-link group flex items-center justify-between py-3.5 px-3 rounded-lg text-lg font-headline font-semibold text-white/95 hover:text-vibrant-utama-orange hover:bg-white/5 transition-all cursor-pointer">
            <span>Beranda</span>
            <svg class="w-4 h-4 text-white/40 group-hover:text-vibrant-utama-orange group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </a>
        <a href="#tentang" data-scroll-to="tentang" class="drawer-nav-link group flex items-center justify-between py-3.5 px-3 rounded-lg text-lg font-headline font-semibold text-white/95 hover:text-vibrant-utama-orange hover:bg-white/5 transition-all cursor-pointer">
            <span>Tentang Program</span>
            <svg class="w-4 h-4 text-white/40 group-hover:text-vibrant-utama-orange group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </a>
        <a href="#portofolio" data-scroll-to="portofolio" class="drawer-nav-link group flex items-center justify-between py-3.5 px-3 rounded-lg text-lg font-headline font-semibold text-white/95 hover:text-vibrant-utama-orange hover:bg-white/5 transition-all cursor-pointer">
            <span>Portofolio Project</span>
            <svg class="w-4 h-4 text-white/40 group-hover:text-vibrant-utama-orange group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </a>
        <a href="#catatan-lapangan" data-scroll-to="catatan-lapangan" class="drawer-nav-link group flex items-center justify-between py-3.5 px-3 rounded-lg text-lg font-headline font-semibold text-white/95 hover:text-vibrant-utama-orange hover:bg-white/5 transition-all cursor-pointer">
            <span>Dokumentasi Program</span>
            <svg class="w-4 h-4 text-white/40 group-hover:text-vibrant-utama-orange group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </a>
        <a href="https://www.widyatama.ac.id/" target="_blank" rel="noopener noreferrer" class="drawer-nav-link group flex items-center justify-between py-3.5 px-3 rounded-lg text-base font-body font-medium text-white/75 hover:text-white hover:bg-white/5 transition-all">
            <span>Website Widyatama.ac.id</span>
            <svg class="w-4 h-4 text-white/40 group-hover:text-white transition-all" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
            </svg>
        </a>
    </nav>

    <div class="pt-6 border-t border-white/10 flex flex-col gap-1 text-xs text-white/60">
        <span class="text-white/80 font-medium">Universitas Widyatama Bandung</span>
        <span>Platform Berdampak Utama (2026)</span>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stickyNavbar = document.getElementById('navbar-sticky');
        const backdrop = document.getElementById('mobile-drawer-backdrop');
        const panel = document.getElementById('mobile-drawer-panel');
        const btnOpenTop = document.getElementById('mobile-drawer-open-top');
        const btnOpenSticky = document.getElementById('mobile-drawer-open-sticky');
        const btnClose = document.getElementById('mobile-drawer-close');

        const sectionIds = ['beranda', 'tentang', 'portofolio', 'catatan-lapangan'];
        const stickyNavLinks = stickyNavbar ? stickyNavbar.querySelectorAll('nav a[data-scroll-to]') : [];
        const topNavLinks = document.querySelectorAll('#navbar-top nav a[data-scroll-to]');
        const drawerNavLinks = document.querySelectorAll('#mobile-drawer-panel .drawer-nav-link[data-scroll-to]');

        function updateActiveNav(activeId) {
            if (!activeId) return;

            stickyNavLinks.forEach(link => {
                const target = link.getAttribute('data-scroll-to');
                const isMatch = target === activeId;
                if (isMatch) {
                    link.classList.remove('font-medium', 'text-on-surface-variant');
                    link.classList.add('font-semibold', 'text-primary');
                } else {
                    link.classList.remove('font-semibold', 'text-primary');
                    link.classList.add('font-medium', 'text-on-surface-variant');
                }
            });

            topNavLinks.forEach(link => {
                const target = link.getAttribute('data-scroll-to');
                const isMatch = target === activeId;
                if (isMatch) {
                    link.classList.remove('text-white/90');
                    link.classList.add('text-white');
                } else {
                    link.classList.remove('text-white');
                    link.classList.add('text-white/90');
                }
            });

            drawerNavLinks.forEach(link => {
                const target = link.getAttribute('data-scroll-to');
                const isMatch = target === activeId;
                if (isMatch) {
                    link.classList.add('text-vibrant-utama-orange', 'bg-white/10');
                    link.classList.remove('text-white/95');
                } else {
                    link.classList.remove('text-vibrant-utama-orange', 'bg-white/10');
                    link.classList.add('text-white/95');
                }
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

        function getThreshold() {
            return 200;
        }

        let isStickyVisible = false;
        let ticking = false;

        function syncStickyNavbar() {
            const threshold = getThreshold();
            const shouldShow = window.scrollY >= threshold;

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
            syncStickyNavbar();
            const activeId = calculateActiveSection();
            updateActiveNav(activeId);
            ticking = false;
        }

        window.addEventListener('scroll', function () {
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
            backdrop.addEventListener('click', function (e) {
                if (e.target === backdrop) {
                    closeDrawer();
                }
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && panel && panel.classList.contains('is-open')) {
                closeDrawer();
            }
        });

        function scrollToSection(targetId) {
            if (!targetId) return;
            const targetEl = document.getElementById(targetId);
            if (targetEl) {
                targetEl.scrollIntoView({ behavior: 'smooth' });
                cleanHashFromUrl();
            }
        }

        function cleanHashFromUrl() {
            if (window.location.hash) {
                const clean = window.location.pathname + window.location.search;
                history.replaceState(null, '', clean);
            }
        }

        document.addEventListener('click', function (e) {
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
                setTimeout(function () {
                    scrollToSection(initialHash);
                }, 100);
            }
        }

        window.addEventListener('hashchange', cleanHashFromUrl);
    });
</script>