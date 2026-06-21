/**
 * Lakeshore Clinic - Hero Section
 * Hero animations and entrance effects
 */

(function() {
    'use strict';

    var panel = document.getElementById('hero-panel');
    if (panel) {
        requestAnimationFrame(function() {
            requestAnimationFrame(function() {
                panel.style.opacity = '1';
                panel.style.transform = 'translateY(0)';
            });
        });
    }

    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.animate-on-scroll').forEach(function(el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(el);
    });

    var style = document.createElement('style');
    style.textContent = '.animate-visible { opacity: 1 !important; transform: translateY(0) !important; }';
    document.head.appendChild(style);
})();
