document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const sidebarCollapseBtn = document.getElementById('sidebar-collapse');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('-translate-x-full');
            if (mobileOverlay) {
                mobileOverlay.classList.toggle('hidden');
            }
        });
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function () {
            sidebar.classList.remove('-translate-x-full');
            if (mobileOverlay) {
                mobileOverlay.classList.remove('hidden');
            }
        });
    }

    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', function () {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
        });
    }

    if (sidebarCollapseBtn) {
        sidebarCollapseBtn.addEventListener('click', function () {
            sidebar.classList.toggle('sidebar-collapsed');
            document.body.classList.toggle('sidebar-collapsed');
        });
    }

    const menuItems = document.querySelectorAll('.sidebar-menu-item');
    menuItems.forEach(function (item) {
        const link = item.querySelector('.sidebar-menu-link');
        const submenu = item.querySelector('.sidebar-submenu');

        if (link && submenu) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                item.classList.toggle('active');
                submenu.classList.toggle('hidden');
                const icon = link.querySelector('.sidebar-arrow');
                if (icon) {
                    icon.classList.toggle('rotate-90');
                }
            });
        }
    });
});
