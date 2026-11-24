import { initAuthGuard } from './apanel/auth-guard';
import { initCatalogControls } from './apanel/catalog-filters';
import { initFieldPostForm } from './apanel/field-post-form';
import { initProjectForm } from './apanel/project-form';

document.addEventListener('DOMContentLoaded', () => {
    initAuthGuard();
    initCatalogControls();
    initFieldPostForm();
    initProjectForm();
});
