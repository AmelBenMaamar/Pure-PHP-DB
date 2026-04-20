<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MarketFlow Pro - La marketplace pour créateurs digitaux">
    <meta name="keywords" content="marketplace php, plateforme ecommerce, vente produits numériques, templates, ui kits, code source marketplace, stripe multi-vendeurs, marketplace digitale, vendre en ligne">
    <meta name="author" content="A. Devance - MarketFlow Pro">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= APP_URL ?>">
    <meta property="og:title" content="<?= isset($title) ? e($title) . ' - MarketFlow Pro' : 'MarketFlow Pro - Marketplace pour créateurs digitaux' ?>">
    <meta property="og:description" content="Vendez et achetez des templates, designs, codes et ressources premium. Rejoignez des milliers de créateurs qui génèrent des revenus passifs.">
    <meta property="og:image" content="<?= APP_URL ?>/img/og-image.jpg">
    <meta property="og:site_name" content="MarketFlow Pro">
    <meta property="og:locale" content="fr_FR">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= APP_URL ?>">
    <meta name="twitter:title" content="<?= isset($title) ? e($title) . ' - MarketFlow Pro' : 'MarketFlow Pro - Marketplace pour créateurs digitaux' ?>">
    <meta name="twitter:description" content="Vendez et achetez des templates, designs, codes et ressources premium. Rejoignez des milliers de créateurs.">
    <meta name="twitter:image" content="<?= APP_URL ?>/img/twitter-card.jpg">

    <!-- SEO -->
    <link rel="canonical" href="<?= APP_URL . $_SERVER['REQUEST_URI'] ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <title><?= isset($title) ? e($title) . ' - ' : '' ?>MarketFlow Pro</title>

    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= CSS_URL ?>/style.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>/dark-mode.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>/notifications.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>/animations.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>/search.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>/interactions.css">
    <link rel="stylesheet" href="<?= CSS_URL ?>/auth-shared.css">
    <?php if (!empty($extraCss)): foreach ($extraCss as $_eCss): ?>
    <link rel="stylesheet" href="<?= CSS_URL ?>/<?= $_eCss ?>">
    <?php endforeach; endif; ?>

    <!-- JS -->
    <script src="<?= JS_URL ?>/search.js" defer></script>
    <script src="<?= JS_URL ?>/app.js" defer></script>
    <script src="<?= JS_URL ?>/notifications.js" defer></script>
    <script src="<?= JS_URL ?>/wishlist.js" defer></script>
    <script src="<?= JS_URL ?>/animations.js" defer></script>
    <script src="<?= JS_URL ?>/dark-mode.js" defer></script>

<!-- Favicons -->
<link rel="icon" type="image/svg+xml" href="<?= APP_URL ?>/favicon.svg?v=5">
<link rel="icon" type="image/x-icon" href="<?= APP_URL ?>/favicon.ico">
<link rel="icon" type="image/png" sizes="192x192" href="<?= APP_URL ?>/favicon-192.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?= APP_URL ?>/apple-touch-icon.png">

<!-- Google Analytics GA4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1FEB5D7C9F"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-1FEB5D7C9F');
</script>
</head>
<body <?php if (isLoggedIn()): ?>data-user-logged-in="true"<?php endif; ?>>
<!-- SVG gradient partagé pour les icônes nav -->
<svg width="0" height="0" style="position:absolute;overflow:hidden" aria-hidden="true">
  <defs>
    <linearGradient id="iconGrad" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%"   stop-color="#6BD1D6"/>
      <stop offset="25%"  stop-color="#6B94D6"/>
      <stop offset="50%"  stop-color="#6B74D6"/>
      <stop offset="75%"  stop-color="#6BC6D6"/>
      <stop offset="89%"  stop-color="#DAF7DA"/>
      <stop offset="100%" stop-color="#6BD1D6"/>
    </linearGradient>
  </defs>
</svg>

<nav role="navigation" aria-label="Navigation principale">
    <div class="container">
        <div class="nav-inner">

            <!-- Logo -->
            <a href="/" class="nav-logo" aria-label="MarketFlow Pro - Accueil">
                <div class="nav-logo-icon" aria-hidden="true"><svg viewBox="0 0 24 24" width="32" height="32" fill="none"><defs><linearGradient id="mg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#6BD1D6"/><stop offset="25%" stop-color="#6B94D6"/><stop offset="50%" stop-color="#6B74D6"/><stop offset="75%" stop-color="#6BC6D6"/><stop offset="85%" stop-color="#6BC6D6"/><stop offset="89%" stop-color="#DAF7DA" stop-opacity="0.9"/><stop offset="93%" stop-color="#6BC6D6"/><stop offset="100%" stop-color="#6BC6D6"/></linearGradient></defs><path d="M4 18V7l8 5 8-5v11" stroke="url(#mg)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M4 7l8 5 8-5" stroke="url(#mg)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                <div class="nav-logo-inner"><span class="nav-logo-text">MarketFlow</span><span class="nav-logo-sub">Marketplace</span></div>
            </a>

            <!-- HAMBURGER : visible uniquement mobile -->
            <button class="nav-hamburger" id="navHamburger" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="navDrawer">
                <span></span><span></span><span></span>
            </button>

            <!-- Overlay sombre derrière le drawer -->
            <div class="nav-overlay" id="navOverlay" onclick="closeNav()" aria-hidden="true"></div>

            <!-- Drawer mobile + nav desktop -->
            <div class="nav-drawer" id="navDrawer" role="dialog" aria-modal="true" aria-label="Menu principal">
                <div class="nav-drawer-header">
                    <span class="nav-drawer-title">Menu</span>
                    <button class="nav-drawer-close" onclick="closeNav()" aria-label="Fermer le menu">&#x2715;</button>
                </div>
                
                <!-- Liens principaux -->
                <ul class="nav-links" role="menubar">
                    <li role="none"><a href="/" role="menuitem" <?= ($_SERVER['REQUEST_URI'] === '/') ? 'class="active"' : '' ?>>Accueil</a></li>
                    <li role="none"><a href="/products" role="menuitem" <?= str_starts_with($_SERVER['REQUEST_URI'], '/products') ? 'class="active"' : '' ?>>Produits</a></li>
                    <li role="none"><a href="/category" role="menuitem" <?= str_contains($_SERVER['REQUEST_URI'], 'category') ? 'class="active"' : '' ?>>Catégories</a></li>
                </ul>

                <!-- Boutons auth dans le drawer (mobile uniquement) -->
                <div class="nav-drawer-auth">
                    <?php if (!isLoggedIn()): ?>
                        <a href="/login"    class="nav-drawer-btn-login">Connexion</a>
                        <a href="/register" class="nav-drawer-btn-register">S'inscrire →</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- BARRE DE RECHERCHE AUTOCOMPLETE -->
            <div class="nav-search" id="navSearch" role="search">
                <label for="searchInput" class="visually-hidden">Rechercher un produit</label>
                <input type="search" id="searchInput" class="nav-search-input"
                    placeholder="Rechercher…" autocomplete="off"
                    aria-label="Rechercher un produit" aria-expanded="false"
                    aria-controls="searchDropdown" aria-haspopup="listbox">
                <button class="nav-search-btn" id="searchSubmitBtn" aria-label="Lancer la recherche" type="submit">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </button>
                
                <div class="search-dropdown" id="searchDropdown" role="listbox" aria-live="polite"></div>
            </div>

            <!-- Partie droite -->
            <div class="nav-right" role="toolbar" aria-label="Actions utilisateur">

                <!-- Wishlist -->
                <?php
                $wishlistCount = 0;
                if (isLoggedIn()) {
                    $wishlistModel = class_exists("\App\Models\Wishlist") ? new \App\Models\Wishlist() : null;
                    $wishlistCount = $wishlistModel ? $wishlistModel->getCount($_SESSION['user_id']) : 0;
                }
                ?>
                <a href="/wishlist" class="icon-btn icon-btn--wishlist" title="Ma liste de souhaits" aria-label="Liste de souhaits (<?= $wishlistCount ?> article<?= $wishlistCount>1?'s':'' ?>)">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                    <?php if ($wishlistCount > 0): ?>
                        <span class="icon-badge wishlist-count" aria-live="polite" aria-label="<?= $wishlistCount ?> article<?= $wishlistCount>1?'s':'' ?> en favoris"><?= e($wishlistCount) ?></span>
                    <?php endif; ?>
                </a>

                <!-- Panier -->
                <a href="/cart" class="icon-btn icon-btn--cart" title="Mon panier" aria-label="Panier (<?= $cartCount ?? 0 ?> article<?= ($cartCount ?? 0)>1?'s':'' ?>)">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                    <?php $cartCount = $_SESSION['cart_count'] ?? 0; ?>
                    <?php if ($cartCount > 0): ?>
                        <span class="icon-badge" aria-label="Panier" aria-live="polite"><?= e($cartCount) ?></span>
                    <?php endif; ?>
                </a>

                <!-- Toggle Dark Mode -->
                <button id="dark-mode-toggle" class="icon-btn" aria-label="Basculer le mode sombre" aria-pressed="false">
                    <svg id="moon-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                    <svg id="sun-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" style="opacity:0" aria-hidden="true">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                </button>

                <div class="nav-sep" aria-hidden="true"></div>

                <?php if (isLoggedIn()): ?>
                    <?php $currentUser = getCurrentUser(); ?>

                    <!-- Menu utilisateur connecté - amélioré accessibilité -->
                    <div class="nav-dropdown" data-dropdown role="menu" aria-label="Menu compte">
                        <button class="nav-user-btn" aria-haspopup="true" aria-expanded="false" aria-controls="userDropdown">
                            <div class="nav-avatar <?= $currentUser['role'] === 'admin' ? 'nav-avatar--admin' : '' ?>" aria-hidden="true">
                                <span class="nav-avatar-letter"><?= strtoupper(substr($currentUser['username'], 0, 1)) ?></span>
                                <?php if ($currentUser['role'] === 'admin'): ?>
                                    <span class="nav-avatar-crown" aria-label="Administrateur">👑</span>
                                <?php endif; ?>
                            </div>
                            <div class="nav-user-info">
                                <span class="nav-username"><?= e($currentUser['username']) ?></span>
                                <?php if ($currentUser['role'] === 'admin'): ?>
                                    <span class="nav-role-badge">ADMIN</span>
                                <?php endif; ?>
                            </div>
                            <svg class="nav-chevron" viewBox="0 0 24 24" aria-hidden="true">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </button>

                        <div class="dropdown-menu" id="userDropdown" role="menu">
                            <a href="/account" class="dropdown-item" role="menuitem">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                                Mon compte
                            </a>
                            <a href="/orders" class="dropdown-item" role="menuitem">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                Mes commandes
                            </a>
                            <a href="/wishlist" class="dropdown-item" role="menuitem">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                Mes favoris
                            </a>

                            <?php if ($currentUser['role'] === 'seller'): ?>
                                <div class="dropdown-sep" role="separator"></div>
                                <a href="/seller/dashboard" class="dropdown-item" role="menuitem">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 17.5h7M17.5 14v7"/></svg>
                                    Dashboard vendeur
                                </a>
                            <?php endif; ?>

                            <?php if ($currentUser['role'] === 'admin'): ?>
                                <div class="dropdown-sep" role="separator"></div>
                                <a href="/admin" class="dropdown-item dropdown-item--admin" role="menuitem">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                                    Administration
                                </a>
                                <?php $criticalCount = getSecurityAlerts(); ?>
                                <a href="/admin/security" class="dropdown-item <?= $criticalCount > 0 ? 'dropdown-item--alert' : '' ?>" role="menuitem">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    Monitoring Sécurité
                                    <?php if ($criticalCount > 0): ?>
                                        <span class="dropdown-item-badge" aria-label="<?= $criticalCount ?> alerte<?= $criticalCount>1?'s':'' ?>"><?= $criticalCount ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>

                            <div class="dropdown-sep" role="separator"></div>
                            <a href="/logout" class="dropdown-item dropdown-item--danger" role="menuitem">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Déconnexion
                            </a>
                        </div>
                    </div>

                <?php else: ?>
                    <a href="/login" class="btn-login">Connexion</a>
                    <a href="/register" class="btn-register">S'inscrire</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Flash message -->
<?php if ($flash = getFlashMessage()): ?>
    <div data-flash-message="<?= e($flash['message']) ?>"
         data-flash-type="<?= e($flash['type']) ?>"
         style="display:none;" role="alert" aria-live="assertive"></div>
<?php endif; ?>

<!-- Script minimal pour le menu mobile (fallback CSS possible via <details>) -->
<script>
/* ── Menu mobile ── */
function openNav() {
    const drawer = document.getElementById('navDrawer');
    const overlay = document.getElementById('navOverlay');
    const btn = document.getElementById('navHamburger');
    drawer?.classList.add('active');
    overlay?.classList.add('active');
    btn?.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    drawer?.querySelector('.nav-drawer-close')?.focus();
}
function closeNav() {
    const drawer = document.getElementById('navDrawer');
    const overlay = document.getElementById('navOverlay');
    const btn = document.getElementById('navHamburger');
    drawer?.classList.remove('active');
    overlay?.classList.remove('active');
    btn?.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
    btn?.focus();
}
document.getElementById('navHamburger')?.addEventListener('click', function() {
    this.getAttribute('aria-expanded') === 'true' ? closeNav() : openNav();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeNav(); closeDropdown(); } });

/* ── Dropdown utilisateur — clic + clavier ── */
const userBtn = document.querySelector('.nav-user-btn');
const userDropdown = document.getElementById('userDropdown');
function openDropdown() {
    userBtn?.setAttribute('aria-expanded', 'true');
    userDropdown?.classList.add('open');
}
function closeDropdown() {
    userBtn?.setAttribute('aria-expanded', 'false');
    userDropdown?.classList.remove('open');
}
userBtn?.addEventListener('click', e => {
    e.stopPropagation();
    userBtn.getAttribute('aria-expanded') === 'true' ? closeDropdown() : openDropdown();
});
document.addEventListener('click', e => {
    if (!e.target.closest('.nav-dropdown')) closeDropdown();
});

/* ── Scroll-aware shadow ── */
const nav = document.querySelector('nav');
window.addEventListener('scroll', () => {
    nav?.classList.toggle('nav--scrolled', window.scrollY > 8);
}, { passive: true });

/* ── Recherche : soumettre avec Entrée ── */
document.getElementById('searchInput')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && this.value.trim()) {
        window.location.href = '/search?q=' + encodeURIComponent(this.value.trim());
    }
});
document.getElementById('searchSubmitBtn')?.addEventListener('click', () => {
    const q = document.getElementById('searchInput')?.value.trim();
    if (q) window.location.href = '/search?q=' + encodeURIComponent(q);
});
</script>
