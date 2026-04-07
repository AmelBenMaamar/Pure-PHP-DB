document.addEventListener('DOMContentLoaded', function () {
    const btn  = document.getElementById('dark-mode-toggle');
    const body = document.body;
    const moonIcon = document.getElementById('moon-icon');
    const sunIcon  = document.getElementById('sun-icon');

    // Restaurer la préférence sauvegardée
    if (localStorage.getItem('darkMode') === 'true') {
        body.classList.add('dark-mode');
        if (moonIcon) moonIcon.style.opacity = '0';
        if (sunIcon)  sunIcon.style.opacity  = '1';
    }

    if (!btn) return;

    btn.addEventListener('click', function () {
        body.classList.toggle('dark-mode');
        const isDark = body.classList.contains('dark-mode');
        localStorage.setItem('darkMode', isDark);

        // Swap icônes lune / soleil
        if (moonIcon) moonIcon.style.opacity = isDark ? '0' : '1';
        if (sunIcon)  sunIcon.style.opacity  = isDark ? '1' : '0';

        // Animation rotation
        btn.classList.add('rotating');
        btn.addEventListener('animationend', () => btn.classList.remove('rotating'), { once: true });
    });
});
