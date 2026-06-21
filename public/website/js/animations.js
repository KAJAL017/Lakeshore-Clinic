/**
 * Lakeshore Clinic - Animations
 * Scroll-triggered animations and smooth transitions
 */

(function() {
    'use strict';

    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('lc-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('[data-animate]').forEach(function(el) {
        el.classList.add('lc-animate');
        observer.observe(el);
    });

    var style = document.createElement('style');
    style.textContent = [
        '.lc-animate { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }',
        '.lc-animate.lc-visible { opacity: 1; transform: translateY(0); }',
        '.lc-animate[data-animate="fade-left"] { transform: translateX(-20px); }',
        '.lc-animate[data-animate="fade-left"].lc-visible { transform: translateX(0); }',
        '.lc-animate[data-animate="fade-right"] { transform: translateX(20px); }',
        '.lc-animate[data-animate="fade-right"].lc-visible { transform: translateX(0); }',
        '.lc-animate[data-animate="scale"] { transform: scale(0.95); }',
        '.lc-animate[data-animate="scale"].lc-visible { transform: scale(1); }',
        '.lc-stagger-1 { transition-delay: 0.1s; }',
        '.lc-stagger-2 { transition-delay: 0.2s; }',
        '.lc-stagger-3 { transition-delay: 0.3s; }',
        '.lc-stagger-4 { transition-delay: 0.4s; }'
    ].join('\n');
    document.head.appendChild(style);
})();
