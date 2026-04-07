<?php
/**
 * MARKETFLOW PRO - PAGE CATÉGORIES (v2 — maquette2)
 * Fichier : app/views/products/categories.php
 */

/* ── Icônes SVG par slug ── */
$svgIcons = [
    'developpement-personnel' => '<svg width="28" height="28" viewBox="0 0 32 32" fill="none"><line x1="16" y1="26" x2="16" y2="8" stroke="#534AB7" stroke-width="1.5" stroke-linecap="round"/><polyline points="11,13 16,8 21,13" fill="none" stroke="#534AB7" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round"/><path d="M9 22 Q16 19 23 22" stroke="#AFA9EC" stroke-width="1.5" stroke-linecap="round" fill="none"/></svg>',
    'sante-alimentation'      => '<svg width="28" height="28" viewBox="0 0 32 32" fill="none"><path d="M16 5 C11 5 8 9 8 14 C8 20 12 27 16 27 C20 27 24 20 24 14 C24 9 21 5 16 5Z" fill="#C0DD97" stroke="#3B6D11" stroke-width="1.5"/><path d="M13 17 L16 20 L21 13" stroke="#3B6D11" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'jardin-autonomie'        => '<svg width="28" height="28" viewBox="0 0 32 32" fill="none"><path d="M16 6C14 9 13 12 13 15a3 3 0 006 0C19 12 18 9 16 6z" stroke="#854F0B" stroke-width="1.5" stroke-linejoin="round"/><path d="M10 12C8 14 7 17 7 20a3 3 0 006 0C13 17 12 14 10 12z" stroke="#854F0B" stroke-width="1.5" stroke-linejoin="round"/><path d="M22 12C20 14 19 17 19 20a3 3 0 006 0C25 17 24 14 22 12z" stroke="#854F0B" stroke-width="1.5" stroke-linejoin="round"/></svg>',
    'maison-energie'          => '<svg width="28" height="28" viewBox="0 0 32 32" fill="none"><path d="M4 28h24M8 28V18L16 10L24 18V28" stroke="#185FA5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><rect x="13" y="20" width="6" height="8" rx="1" stroke="#185FA5" stroke-width="1.5"/></svg>',
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

<style>
/* ================================================================
   CATEGORIES PAGE — styles complémentaires (maquette2)
   ================================================================ */

/* Hero */
.cat-hero {
    background: #faf9f5;
    padding: 40px 0 32px;
    border-bottom: 0.5px solid #ede8df;
    margin-bottom: 0;
}
.cat-hero-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 40px;
}
.cat-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Manrope', sans-serif;
    font-size: 12px;
    color: #6b5e52;
    margin-bottom: 20px;
    letter-spacing: 0.01em;
}
.cat-breadcrumb a {
    color: #6b5e52;
    text-decoration: none;
    border-bottom: 1px solid transparent;
    transition: color 0.15s, border-color 0.15s;
}
.cat-breadcrumb a:hover {
    color: #534ab7;
    border-bottom-color: #c9c4f5;
}
.cat-breadcrumb-sep {
    color: #c9c4f5;
    font-size: 10px;
    user-select: none;
}
.cat-breadcrumb-current {
    color: #1e1208;
    font-weight: 500;
}

.cat-hero-title {
    font-family: Georgia, serif;
    font-size: clamp(26px, 4vw, 36px);
    font-weight: 400;
    color: #1e1208;
    line-height: 1.2;
    margin: 0 0 6px;
}
.cat-hero-sub {
    font-family: 'Manrope', sans-serif;
    font-size: 13px;
    color: #8a7060;
    margin: 0 0 24px;
    line-height: 1.7;
}

/* .cat-search-bar supprimé — recherche centralisée dans la nav */

/* Compteurs */
.cat-stats {
    display: flex;
    gap: 28px;
    flex-wrap: wrap;
}
.cat-stat {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.cat-stat-val {
    font-family: Georgia, serif;
    font-size: 22px;
    font-weight: 400;
    color: #1e1208;
    line-height: 1;
}
.cat-stat-lbl {
    font-family: 'Manrope', sans-serif;
    font-size: 10px;
    color: #a0907e;
    text-transform: uppercase;
    letter-spacing: 0.07em;
}
.cat-stat-sep {
    width: 0.5px;
    background: #ede8df;
    align-self: stretch;
    min-height: 24px;
}

/* Grille principale */
.cat-page-grid {
    max-width: 1240px;
    margin: 0 auto;
    padding: 32px 40px 56px;
}

/* En-tête section */
.cat-section-head {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 8px;
}
.cat-section-head h2 {
    font-family: Georgia, serif;
    font-size: 18px;
    font-weight: 400;
    color: #1e1208;
    margin: 0;
}
.cat-section-count {
    font-family: 'Manrope', sans-serif;
    font-size: 11px;
    color: #a0907e;
}

/* Layout asymétrique des rangées */
.cat-rows { display: flex; flex-direction: column; gap: 12px; }

.cat-row-2col   { display: grid; grid-template-columns: 1.5fr 1fr;   gap: 12px; }
.cat-row-2col-r { display: grid; grid-template-columns: 1fr 1.5fr;   gap: 12px; }
.cat-row-3col   { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
.cat-row-1col   { display: grid; grid-template-columns: 1fr;         gap: 12px; }

/* CTA vendeur */
.cat-cta {
    background: #ebe8fb;
    border: 0.5px solid #c9c4f5;
    border-radius: 16px;
    padding: 36px 40px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    margin-top: 32px;
    flex-wrap: wrap;
}
.cat-cta-text h3 {
    font-family: Georgia, serif;
    font-size: 22px;
    font-weight: 400;
    color: #2a2165;
    margin: 0 0 6px;
}
.cat-cta-text p {
    font-family: 'Manrope', sans-serif;
    font-size: 13px;
    color: #534ab7;
    margin: 0;
    line-height: 1.6;
    max-width: 380px;
}
.cat-cta-btn {
    font-family: 'Manrope', sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: #fff;
    background: #7c6cf0;
    border: none;
    border-radius: 20px;
    padding: 10px 24px;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.15s;
    flex-shrink: 0;
}
.cat-cta-btn:hover { background: #6558d4; color: #fff; }

/* État vide */
.cat-empty {
    text-align: center;
    padding: 64px 20px;
    font-family: 'Manrope', sans-serif;
    font-size: 14px;
    color: #a0907e;
}
.cat-empty-icon { font-size: 2.5rem; margin-bottom: 12px; display: block; }

/* ── Responsive ── */
@media (max-width: 900px) {
    .cat-hero-inner { padding: 0 20px; }
    .cat-page-grid  { padding: 24px 20px 40px; }
    .cat-row-2col,
    .cat-row-2col-r,
    .cat-row-3col   { grid-template-columns: 1fr 1fr; }
    .cat-cta        { flex-direction: column; padding: 28px 24px; }
    .cat-cta-btn    { width: 100%; text-align: center; }
}
@media (max-width: 600px) {
    .cat-hero { padding: 28px 0 22px; }
    .cat-search-bar { flex-direction: column; }
    .cat-search-bar input  { width: 100%; }
    .cat-search-bar button { width: 100%; }
    .cat-stats { gap: 16px; }
    .cat-stat-sep { display: none; }
    .cat-row-2col,
    .cat-row-2col-r,
    .cat-row-3col   { grid-template-columns: 1fr; }
    .cat-card .cat-title { font-size: 20px; }
}
</style>

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
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="/register?role=seller" class="cat-cta-btn">Devenir vendeur →</a>
        <?php elseif (($_SESSION['user_role'] ?? '') === 'seller'): ?>
            <a href="/seller/products/create" class="cat-cta-btn">Ajouter une ressource →</a>
        <?php elseif (($_SESSION['user_role'] ?? '') === 'admin'): ?>
            <a href="/admin" class="cat-cta-btn">Administration →</a>
        <?php endif; ?>
    </div>

</div>
