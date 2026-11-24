import { initNavbar } from './public/navbar';
import { initLandingFilter } from './public/landing-filter';
import { initProjectDetail } from './public/project-detail';

document.addEventListener('DOMContentLoaded', () => {
    initNavbar();
    initLandingFilter();
    initProjectDetail();
});
