/* Progressive enhancement only; navigation and discussions work without JavaScript. */
(() => {
    function init() {
        document.querySelectorAll('.cn-navigation a[href]').forEach(link => {
            const url = new URL(link.href, location.href);
            if (url.origin === location.origin && url.pathname === location.pathname) {
                link.setAttribute('aria-current', 'page');
            }
        });
        document.querySelectorAll('.cn-dashboard').forEach(dashboard => {
            const filters = dashboard.querySelector('.cn-filters');
            if (!filters || filters.dataset.ready) return;
            filters.dataset.ready = 'true';
            filters.hidden = false;
            filters.addEventListener('click', event => {
                const button = event.target.closest('button[data-cn-filter]');
                if (!button) return;
                filters.querySelectorAll('button').forEach(item => item.setAttribute('aria-pressed', String(item === button)));
                dashboard.querySelectorAll('[data-cn-unit]').forEach(group => {
                    group.hidden = button.dataset.cnFilter !== 'all' && button.dataset.cnFilter !== group.dataset.cnUnit;
                });
            });
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
    document.addEventListener('turbo:load', init);
})();
