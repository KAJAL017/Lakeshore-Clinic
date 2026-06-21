/**
 * Lakeshore Clinic - Navigation
 * Header scroll behavior, mobile menu, and navigation interactions
 */

(function() {
    'use strict';

    var header = document.getElementById('public-header');
    var spacer = document.getElementById('header-spacer');
    var mobileToggle = document.getElementById('mobile-menu-toggle');
    var mobileMenu = document.getElementById('mobile-menu');
    var mobileOverlay = document.getElementById('mobile-menu-overlay');
    var mobilePanel = document.getElementById('mobile-menu-panel');
    var mobileClose = document.getElementById('mobile-menu-close');

    if (!header) return;

    function handleScroll() {
        if (window.scrollY > 10) {
            header.classList.add('shadow-sm');
        } else {
            header.classList.remove('shadow-sm');
        }
    }

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();

    function openMobileMenu() {
        if (!mobileMenu) return;
        mobileMenu.classList.remove('pointer-events-none');
        mobileMenu.setAttribute('aria-hidden', 'false');
        if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'true');
        if (mobileOverlay) {
            mobileOverlay.classList.remove('opacity-0', 'pointer-events-none');
            mobileOverlay.classList.add('opacity-100');
        }
        if (mobilePanel) {
            mobilePanel.classList.remove('translate-x-full');
            mobilePanel.classList.add('translate-x-0');
        }
        document.body.style.overflow = 'hidden';

        if (mobileToggle) {
            var bars = mobileToggle.querySelectorAll('.mobile-menu-bar');
            if (bars.length >= 3) {
                bars[0].style.transform = 'rotate(45deg) translate(3px, 3px)';
                bars[1].style.opacity = '0';
                bars[2].style.transform = 'rotate(-45deg) translate(3px, -3px)';
            }
        }
    }

    function closeMobileMenu() {
        if (!mobileMenu) return;
        mobileMenu.classList.add('pointer-events-none');
        mobileMenu.setAttribute('aria-hidden', 'true');
        if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'false');
        if (mobileOverlay) {
            mobileOverlay.classList.add('opacity-0', 'pointer-events-none');
            mobileOverlay.classList.remove('opacity-100');
        }
        if (mobilePanel) {
            mobilePanel.classList.add('translate-x-full');
            mobilePanel.classList.remove('translate-x-0');
        }
        document.body.style.overflow = '';

        if (mobileToggle) {
            var bars = mobileToggle.querySelectorAll('.mobile-menu-bar');
            if (bars.length >= 3) {
                bars[0].style.transform = '';
                bars[1].style.opacity = '1';
                bars[2].style.transform = '';
            }
        }
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            var isOpen = mobilePanel && mobilePanel.classList.contains('translate-x-0');
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
    }

    if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);

    if (mobileMenu) {
        mobileMenu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', closeMobileMenu);
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobilePanel && mobilePanel.classList.contains('translate-x-0')) {
            closeMobileMenu();
        }
    });

    var navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(function(link) {
        link.addEventListener('mouseenter', function() {
            var underline = this.querySelector('.nav-underline');
            if (underline && !this.classList.contains('active')) {
                underline.style.width = '100%';
            }
        });
        link.addEventListener('mouseleave', function() {
            var underline = this.querySelector('.nav-underline');
            if (underline && !underline.classList.contains('!w-full')) {
                underline.style.width = '0';
            }
        });
    });
})();
