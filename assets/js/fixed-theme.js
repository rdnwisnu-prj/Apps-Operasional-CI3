!(function () {
    'use strict';

    var fixedConfig = {
        theme: 'light',
        layout: 'default',
        sidebar: 'gradientsidebar4',
        topbar: 'white',
        color: 'teal'
    };

    try {
        sessionStorage.removeItem('__THEME_CONFIG__');
    } catch (error) {}

    var html = document.documentElement;
    html.setAttribute('data-bs-theme', fixedConfig.theme);
    html.setAttribute('data-layout', fixedConfig.layout);
    html.setAttribute('data-sidebar', fixedConfig.sidebar);
    html.setAttribute('data-topbar', fixedConfig.topbar);
    html.setAttribute('data-color', fixedConfig.color);
    html.removeAttribute('data-sidenav-user');

    window.defaultConfig = {
        theme: fixedConfig.theme,
        nav: 'vertical',
        color: { color: fixedConfig.color },
        layout: { mode: 'fluid' },
        topbar: { color: fixedConfig.topbar },
        menu: { color: fixedConfig.sidebar },
        sidenav: { size: fixedConfig.layout, user: false }
    };
    window.config = JSON.parse(JSON.stringify(window.defaultConfig));
})();
