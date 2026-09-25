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
            dashboard.classList.add('cn-enhanced');
            const updateDiscussions = () => {
                const selected = filters.querySelector('[aria-pressed="true"]')?.dataset.cnFilter || 'all';
                let topicCount = 0;
                let rowCount = 0;
                dashboard.querySelectorAll('[data-cn-unit]').forEach(group => {
                    group.hidden = selected !== 'all' && selected !== group.dataset.cnUnit;
                    if (!group.hidden) {
                        topicCount += group.querySelectorAll('.cn-topic').length;
                        rowCount += group.querySelectorAll('.cn-topic:not(.cn-topic-pinned)').length;
                    }
                });
                const empty = dashboard.querySelector('.cn-dashboard-empty');
                if (empty) empty.hidden = topicCount > 0;
                const heading = dashboard.querySelector('.cn-unified-heading');
                if (heading) heading.hidden = rowCount === 0;
            };
            filters.addEventListener('click', event => {
                const button = event.target.closest('button[data-cn-filter]');
                if (!button) return;
                filters.querySelectorAll('button').forEach(item => item.setAttribute('aria-pressed', String(item === button)));
                updateDiscussions();
            });
            // Native live components can replace their topic rows after initial render.
            new MutationObserver(updateDiscussions).observe(dashboard, {childList: true, subtree: true});
            updateDiscussions();
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
    document.addEventListener('turbo:load', init);
})();
