/**
 * ================================================================
 * MARKETFLOW PRO — INTERACTIONS v1.0
 * Scroll reveal · Ripple · Nav scroll · Wishlist heart
 * ================================================================
 */

document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initRipple();
    initNavScroll();
    initWishlistFeedback();
    console.log('✅ Interactions v1.0 initialisées');
});

/* ────────────────────────────────────────────────────────────────
   1. SCROLL REVEAL
   Ajoute .js-reveal sur les éléments clés, puis observe
   ──────────────────────────────────────────────────────────────── */
function initScrollReveal() {
    // Sélecteurs et leur délai de cascade (index dans la grille)
    const groups = [
        { sel: '.cat-card',      cascade: true },
        { sel: '.prod-card-new', cascade: true },
        { sel: '.feat-card-new', cascade: true },
        { sel: '.cta-inner-new', cascade: false },
        { sel: '.sec-title-new', cascade: false },
        { sel: '.hero-trust',    cascade: false },
        { sel: '.hero-cta',      cascade: false },
    ];

    groups.forEach(({ sel, cascade }) => {
        document.querySelectorAll(sel).forEach((el, i) => {
            // Évite de re-marquer un élément déjà traité
            if (el.classList.contains('js-reveal')) return;
            el.classList.add('js-reveal');
            if (cascade && i < 4) {
                el.classList.add(`js-reveal-d${i + 1}`);
            }
        });
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.08,
        rootMargin: '0px 0px -36px 0px'
    });

    document.querySelectorAll('.js-reveal').forEach(el => observer.observe(el));
    console.log('   ✅ Scroll reveal actif');
}

/* ────────────────────────────────────────────────────────────────
   2. RIPPLE EFFECT
   Boutons colorés → ripple blanc ; boutons légers → ripple lavande
   ──────────────────────────────────────────────────────────────── */
function initRipple() {
    const dark  = ['.cta-btn-new', '.btn-register', '.hero-btn-primary'];
    const light = ['.prod-btn-new', '.cat-btn.cat-btn--active', '.hero-btn-secondary'];

    dark.forEach(sel => {
        document.querySelectorAll(sel).forEach(btn => {
            btn.classList.add('ripple-host');
            btn.addEventListener('click', createRipple);
        });
    });

    light.forEach(sel => {
        document.querySelectorAll(sel).forEach(btn => {
            btn.classList.add('ripple-host', 'ripple-light');
            btn.addEventListener('click', createRipple);
        });
    });

    console.log('   ✅ Ripple actif');
}

function createRipple(e) {
    const btn  = e.currentTarget;
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x    = e.clientX - rect.left  - size / 2;
    const y    = e.clientY - rect.top   - size / 2;

    const wave = document.createElement('span');
    wave.classList.add('ripple-wave');
    wave.style.cssText = `width:${size}px;height:${size}px;left:${x}px;top:${y}px;`;
    btn.appendChild(wave);
    wave.addEventListener('animationend', () => wave.remove(), { once: true });
}

/* ────────────────────────────────────────────────────────────────
   3. NAV — OMBRE AU SCROLL
   ──────────────────────────────────────────────────────────────── */
function initNavScroll() {
    const nav = document.querySelector('nav');
    if (!nav) return;

    const toggle = () => nav.classList.toggle('nav-scrolled', window.scrollY > 10);
    window.addEventListener('scroll', toggle, { passive: true });
    toggle(); // état initial
    console.log('   ✅ Nav scroll actif');
}

/* ────────────────────────────────────────────────────────────────
   4. WISHLIST HEART FEEDBACK
   Animation pop au clic (indépendante de la logique AJAX existante)
   ──────────────────────────────────────────────────────────────── */
function initWishlistFeedback() {
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            this.classList.remove('just-clicked');
            // Force reflow pour relancer l'animation
            void this.offsetWidth;
            this.classList.add('just-clicked');
            this.addEventListener('animationend', () => {
                this.classList.remove('just-clicked');
            }, { once: true });
        });
    });
    console.log('   ✅ Wishlist feedback actif');
}

/* ────────────────────────────────────────────────────────────────
   5. BACK TO TOP
   Crée le bouton, le rend visible après 300px de scroll
   ──────────────────────────────────────────────────────────────── */
(function initBackToTop() {
    const btn = document.createElement('button');
    btn.className = 'back-to-top';
    btn.setAttribute('aria-label', 'Retour en haut');
    btn.innerHTML = `<svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg>`;
    document.body.appendChild(btn);

    window.addEventListener('scroll', () => {
        btn.classList.toggle('visible', window.scrollY > 300);
    }, { passive: true });

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    console.log('   ✅ Back to top actif');
})();
