document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (e) {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(function (dropdown) {
            if (!dropdown.parentElement.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });

    document.querySelectorAll('[data-dropdown-toggle]').forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            const targetId = this.getAttribute('data-dropdown-toggle');
            const menu = document.getElementById(targetId);
            if (menu) {
                menu.classList.toggle('hidden');
            }
        });
    });
});
