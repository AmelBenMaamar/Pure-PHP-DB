<?php
/**
 * MARKETFLOW PRO - PAGE CATÉGORIES (v2 — maquette2)
 * Fichier : app/views/products/categories.php
 */

/* ── Icônes SVG par slug ── */
$svgIcons = [
    'developpement-personnel' => '<div class="cat-icon-frame" style="padding:1.5px;border-radius:10px;background:linear-gradient(135deg,#6BD1D6 0%,#6B94D6 25%,#6B74D6 50%,#6BC6D6 75%,#6BC6D6 100%);display:inline-flex;flex-shrink:0"><div style="background:#fff;border-radius:8.5px;width:41px;height:41px;display:flex;align-items:center;justify-content:center"><svg width="26" height="26" viewBox="0 0 28 28" fill="none"><defs><linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#6BD1D6"/><stop offset="50%" stop-color="#6B74D6"/><stop offset="100%" stop-color="#6BC6D6"/></linearGradient></defs><circle cx="14" cy="14" r="9" stroke="url(#g1)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><polygon points="14,7 16.2,13 14,12 11.8,13" fill="url(#g1)" stroke="none"/><polygon points="14,21 16.2,15 14,16 11.8,15" fill="#6BC6D6" opacity=".35" stroke="none"/><line x1="14" y1="5" x2="14" y2="7" stroke="url(#g1)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="14" y1="21" x2="14" y2="23" stroke="url(#g1)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="5" y1="14" x2="7" y2="14" stroke="url(#g1)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="21" y1="14" x2="23" y2="14" stroke="url(#g1)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div></div>',
    'sante-alimentation'      => '<div class="cat-icon-frame" style="padding:1.5px;border-radius:10px;background:linear-gradient(135deg,#6BD1D6 0%,#6B94D6 25%,#6B74D6 50%,#6BC6D6 75%,#6BC6D6 100%);display:inline-flex;flex-shrink:0"><div style="background:#fff;border-radius:8.5px;width:41px;height:41px;display:flex;align-items:center;justify-content:center"><svg width="26" height="26" viewBox="0 0 28 28" fill="none"><defs><linearGradient id="g2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#6BD1D6"/><stop offset="50%" stop-color="#6B74D6"/><stop offset="100%" stop-color="#6BC6D6"/></linearGradient></defs><path d="M14 22 Q5 16 5 10.5 A5 5 0 0 1 14 8.5 A5 5 0 0 1 23 10.5 Q23 16 14 22Z" stroke="url(#g2)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="14" y1="13" x2="14" y2="17" stroke="url(#g2)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="11.5" y1="15" x2="16.5" y2="15" stroke="url(#g2)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div></div>',
    'jardin-autonomie'        => '<div class="cat-icon-frame" style="padding:1.5px;border-radius:10px;background:linear-gradient(135deg,#6BD1D6 0%,#6B94D6 25%,#6B74D6 50%,#6BC6D6 75%,#6BC6D6 100%);display:inline-flex;flex-shrink:0"><div style="background:#fff;border-radius:8.5px;width:41px;height:41px;display:flex;align-items:center;justify-content:center"><svg width="26" height="26" viewBox="0 0 28 28" fill="none"><defs><linearGradient id="g3" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#6BD1D6"/><stop offset="50%" stop-color="#6B74D6"/><stop offset="100%" stop-color="#6BC6D6"/></linearGradient></defs><path d="M10 22 L18 22 L17 26 L11 26 Z" stroke="url(#g3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="14" y1="22" x2="14" y2="15" stroke="url(#g3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 18 Q14 12 8 10 Q8 16 14 18" stroke="url(#g3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 16 Q14 10 20 8 Q20 14 14 16" stroke="url(#g3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div></div>',
    'maison-energie'          => '<div class="cat-icon-frame" style="padding:1.5px;border-radius:10px;background:linear-gradient(135deg,#6BD1D6 0%,#6B94D6 25%,#6B74D6 50%,#6BC6D6 75%,#6BC6D6 100%);display:inline-flex;flex-shrink:0"><div style="background:#fff;border-radius:8.5px;width:41px;height:41px;display:flex;align-items:center;justify-content:center"><svg width="26" height="26" viewBox="0 0 28 28" fill="none"><defs><linearGradient id="g4" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#6BD1D6"/><stop offset="50%" stop-color="#6B74D6"/><stop offset="100%" stop-color="#6BC6D6"/></linearGradient></defs><polyline points="4,13 14,4 24,13" stroke="url(#g4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 13 L7 24 L21 24 L21 13" stroke="url(#g4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><rect x="11" y="18" width="6" height="6" rx="1" stroke="url(#g4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><polyline points="16,10 14,14 17,14 15,18" stroke="url(#g4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3"/></svg></div></div>',
];
$svgIconFallback = '<svg width="28" height="28" viewBox="0 0 32 32" fill="none"><rect x="6" y="6" width="20" height="20" rx="4" fill="none" stroke="#534AB7" stroke-width="1.5"/><line x1="11" y1="16" x2="21" y2="16" stroke="#534AB7" stroke-width="1.5" stroke-linecap="round"/><line x1="16" y1="11" x2="16" y2="21" stroke="#534AB7" stroke-width="1.5" stroke-linecap="round"/></svg>';

/* ── Correspondance slug → numéro de thème couleur ── */
$slugToTheme = [
    'developpement-personnel' => 1,
    'sante-alimentation'      => 2,
    'jardin-autonomie'        => 4,
    'maison-energie'          => 6,
];
$fallbackThemes = [1, 2, 3, 4, 5, 6, 7, 8];

/* ── Totaux pour le hero ── */
$totalProducts = array_sum(array_column($categories, 'product_count'));
?>


<!-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ -->
<section class="cat-hero">
    <div class="cat-hero-inner">

        <!-- Fil d'Ariane -->
        <nav class="cat-breadcrumb" aria-label="Fil d'Ariane">
            <a href="/">Accueil</a>
            <span class="cat-breadcrumb-sep">›</span>
            <span class="cat-breadcrumb-current">Catégories</span>
        </nav>

        <h1 class="cat-hero-title">Explorez nos univers</h1>
        <p class="cat-hero-sub">Autonomie, bien-être, jardin… trouvez les ressources qui vous correspondent.</p>

        <!-- Statistiques -->
        <div class="cat-stats">
            <div class="cat-stat">
                <span class="cat-stat-val"><?= count($categories) ?></span>
                <span class="cat-stat-lbl">Catégories</span>
            </div>
            <?php if ($totalProducts > 0): ?>
            <div class="cat-stat-sep"></div>
            <div class="cat-stat">
                <span class="cat-stat-val"><?= number_format($totalProducts, 0, ',', ' ') ?></span>
                <span class="cat-stat-lbl">Ressources disponibles</span>
            </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- ══════════════════════════════════════
     GRILLE DES CATÉGORIES
══════════════════════════════════════ -->
<div class="cat-page-grid">

    <?php if (empty($categories)): ?>
        <div class="cat-empty">
            <span class="cat-empty-icon">🗂️</span>
            Aucune catégorie disponible pour le moment.
        </div>
    <?php else: ?>

    <!-- En-tête section -->
    <div class="cat-section-head">
        <h2>Toutes les catégories</h2>
        <span class="cat-section-count"><?= count($categories) ?> univers</span>
    </div>

    <!-- Layout adaptatif selon le nombre de catégories -->
    <div class="cat-rows">
    <?php
    $total = count($categories);
    $index = 0;
    $rowNum = 0;

    /*
     * Stratégie de layout :
     * Rangée 0 : 2 colonnes larges (1.5fr / 1fr)
     * Rangée 1 : 2 colonnes inversées (1fr / 1.5fr)
     * Rangée 2 : 3 colonnes égales
     * Rangée 3 : 2 colonnes larges (1.5fr / 1fr)
     * … puis on repart
     */
    $rowLayouts = [
        'cat-row-2col',    // rangée 0 : 2 cartes
        'cat-row-2col-r',  // rangée 1 : 2 cartes
        'cat-row-3col',    // rangée 2 : 3 cartes
        'cat-row-2col',    // rangée 3 : 2 cartes
    ];
    $rowSizes = [2, 2, 3, 2];

    while ($index < $total):
        $rIdx   = $rowNum % count($rowLayouts);
        $size   = $rowSizes[$rIdx];
        $layout = $rowLayouts[$rIdx];

        // Dernière rangée : si 1 seul restant → pleine largeur
        $remaining = $total - $index;
        if ($remaining === 1) { $layout = 'cat-row-1col'; $size = 1; }
        if ($remaining < $size) { $size = $remaining; }
    ?>
    <div class="<?= $layout ?>">
    <?php for ($i = 0; $i < $size && $index < $total; $i++, $index++):
        $cat     = $categories[$index];
        $slug    = $cat['slug'] ?? '';
        $name    = $cat['name'] ?? 'Catégorie';
        $count   = (int)($cat['product_count'] ?? 0);
        $desc    = $cat['description'] ?? '';
        $theme   = $slugToTheme[$slug] ?? $fallbackThemes[$index % count($fallbackThemes)];
        $icon    = $svgIcons[$slug]    ?? $svgIconFallback;
        $num     = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
        $countLabel = $count > 0
            ? 'Explorer ' . number_format($count, 0, ',', ' ') . ' ressource' . ($count > 1 ? 's' : '') . ' →'
            : null;
    ?>
        <a href="/category/<?= htmlspecialchars($slug, ENT_QUOTES) ?>"
           class="cat-card cat-card--<?= $theme ?>"
           aria-label="Voir la catégorie <?= htmlspecialchars($name, ENT_QUOTES) ?>">

            <!-- Numéro en filigrane -->
            <span class="cat-num" aria-hidden="true"><?= $num ?></span>

            <!-- Icône -->
            <div class="cat-icon"><?= $icon ?></div>

            <!-- Label + titre -->
            <span class="cat-label"><?= $num ?> · <?= htmlspecialchars($name, ENT_QUOTES) ?></span>
            <span class="cat-title"><?= htmlspecialchars($name, ENT_QUOTES) ?></span>

            <?php if ($desc): ?>
                <p style="font-family:'Manrope',sans-serif;font-size:12px;line-height:1.6;opacity:.7;margin:8px 0 0;position:relative;z-index:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                    <?= htmlspecialchars($desc, ENT_QUOTES) ?>
                </p>
            <?php endif; ?>

            <!-- Bouton avec compteur -->
            <?php if ($countLabel): ?>
                <span class="cat-btn cat-btn--active"><?= $countLabel ?></span>
            <?php else: ?>
                <span class="cat-btn cat-btn--empty">Bientôt disponible</span>
            <?php endif; ?>

        </a>
    <?php endfor; ?>
    </div>
    <?php $rowNum++; endwhile; ?>
    </div>

    <?php endif; ?>

    <!-- ── CTA Vendeur ── -->
    <div class="cat-cta">
        <div class="cat-cta-text">
            <h3>Vous créez du contenu ?</h3>
            <p>Rejoignez nos vendeurs et partagez vos ressources avec notre communauté d'apprenants.</p>
        </div>
        <?php if (!isLoggedIn()): ?>
            <a href="/register?role=seller" class="cat-cta-btn">Devenir vendeur →</a>
        <?php elseif ((getCurrentUser()['role'] ?? '') === 'seller'): ?>
            <a href="/seller/products/create" class="cat-cta-btn">Ajouter une ressource →</a>
        <?php elseif ((getCurrentUser()['role'] ?? '') === 'admin'): ?>
            <a href="/admin" class="cat-cta-btn">Administration →</a>
        <?php endif; ?>
    </div>

</div>
