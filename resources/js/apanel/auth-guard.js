/**
 * Guard admin pages against stale BFCache history restores and wire the login password toggle.
 */
export function initAuthGuard() {
    window.addEventListener('pageshow', (event) => {
        const navType = window.performance?.navigation?.type;
        if (event.persisted || navType === 2) {
            window.location.reload();
        }
    });

    const passwordInput = document.getElementById('admin-password');
    const toggleBtn = document.getElementById('toggle-password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');

    if (passwordInput && toggleBtn && eyeOpen && eyeClosed) {
        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            eyeOpen.classList.toggle('hidden', isPassword);
            eyeClosed.classList.toggle('hidden', !isPassword);
        });
    }
}
