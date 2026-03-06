/**
 * HouseAidPro — Main Application JS (app.js)
 */
(function () {
    'use strict';

    /* ── Theme Toggle ───────────────────────────────── */
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;

    function setTheme(theme) {
        html.setAttribute('data-theme', theme);
        localStorage.setItem('hap-theme', theme);
    }

    // Restore saved theme or system preference
    const saved = localStorage.getItem('hap-theme');
    if (saved) {
        setTheme(saved);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        setTheme('dark');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            setTheme(next);
        });
    }

    /* ── Mobile Menu ────────────────────────────────── */
    const hamburger = document.getElementById('hamburger');
    const nav = document.getElementById('main-nav');

    if (hamburger && nav) {
        hamburger.addEventListener('click', () => {
            nav.classList.toggle('open');
            const isOpen = nav.classList.contains('open');
            hamburger.setAttribute('aria-expanded', isOpen);
        });
        // Close on link click
        nav.querySelectorAll('.nav__link').forEach(link => {
            link.addEventListener('click', () => nav.classList.remove('open'));
        });
    }

    /* ── PWA Registration ───────────────────────────── */
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/maintenance/sw.js').catch(() => {});
        });
    }

    /* ── Accordion ──────────────────────────────────── */
    document.querySelectorAll('.accordion__trigger').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const item = trigger.closest('.accordion__item');
            const wasOpen = item.classList.contains('open');
            // Close all siblings
            item.closest('.accordion').querySelectorAll('.accordion__item').forEach(i => i.classList.remove('open'));
            if (!wasOpen) item.classList.add('open');
        });
    });

    /* ── Animate on scroll ──────────────────────────── */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-fadeInUp, .animate-fadeIn, .animate-scaleIn').forEach(el => {
        el.style.animationPlayState = 'paused';
        observer.observe(el);
    });

})();
