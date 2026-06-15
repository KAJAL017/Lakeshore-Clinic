function getTheme() {
    return localStorage.getItem('theme') || 'light';
}

function setTheme(theme) {
    localStorage.setItem('theme', theme);
    document.documentElement.classList.toggle('dark', theme === 'dark');
}

function toggleTheme() {
    const current = getTheme();
    setTheme(current === 'dark' ? 'light' : 'dark');
}

document.addEventListener('DOMContentLoaded', function () {
    const savedTheme = getTheme();
    document.documentElement.classList.toggle('dark', savedTheme === 'dark');

    document.querySelectorAll('[data-theme-toggle]').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            toggleTheme();
        });
    });
});

window.toggleTheme = toggleTheme;
window.setTheme = setTheme;
window.getTheme = getTheme;
