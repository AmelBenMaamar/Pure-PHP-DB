<?php
/**
 * VUE CATÉGORIE — DESIGN MAQUETTE2
 * ─────────────────────────────────────────────────────────────────
 * Layout 2 colonnes : sidebar filtres (sticky) + grille produits
 * Design system : fond #faf9f5 · Georgia titres · Manrope corps
 * Accent violet #7c6cf0 · Beige doux pour les bordures #ede8df
 * ─────────────────────────────────────────────────────────────────
 * Données PHP attendues :
 *   $category   → array ['name', 'description', 'slug']
 *   $products   → array de produits
 *   $categories → array de toutes les catégories ['name','slug','product_count']
 *   $pagination → array ['current', 'total_pages'] (optionnel)
 */
?>

<!-- ═══════════════════════════════════════════
     FIL D'ARIANE — navigation contextuelle
     ═══════════════════════════════════════════ -->
<nav class="container breadcrumb-nav" aria-label="Fil d'Ariane">
    <ol class="breadcrumb">
        <li><a href="/" class="breadcrumb-link">Accueil</a></li>
        <li aria-hidden="true" class="breadcrumb-sep">/</li>
        <li><a href="/category" class="breadcrumb-link">Catégories</a></li>
        <li aria-hidden="true" class="breadcrumb-sep">/</li>
        <li class="breadcrumb-current" aria-current="page"><?= e($category[\'name\']) ?></li>
    </ol>
</nav>

<!-- ═══════════════════════════════════════════
     EN-TÊTE CATÉGORIE — icône + titre + compteur
     ═══════════════════════════════════════════ -->
<section class="container category-header">
    <div class="category-header-inner">

        <!-- Cercle avec initiale de la catégorie -->
        <div class="category-icon" aria-hidden="true">
            <?= strtoupper(mb_substr(e($category[\'name\']), 0, 1)) ?>
        </div>

        <div class="category-header-text">
            <h1 class="category-title"><?= e($category[\'name\']) ?></h1>

            <?php if (!empty($category[\'description\'])): ?>
                <p class="category-description"><?= e($category[\'description\']) ?></p>
            <?php endif; ?>

            <p class="category-count">
                <strong><?= count($products) ?></strong>
                produit<?= count($products) > 1 ? \'s\' : \'\' ?> disponible<?= count($products) > 1 ? \'s\' : \'\' ?>
            </p>
        </div>
    </div>
</section>

<!-- Overlay sombre derrière la sidebar sur mobile -->
<div class="filters-overlay" id="filtersOverlay" onclick="toggleFilters()"></div>

<!-- ═══════════════════════════════════════════
     LAYOUT PRINCIPAL — sidebar gauche + contenu
     ═══════════════════════════════════════════ -->
<div class="container catalog-grid">

    <!-- ── SIDEBAR FILTRES ── -->
    <aside class="filters-sidebar" id="filtersSidebar" aria-label="Filtres">

        <!-- En-tête sidebar (bouton ✕ visible sur mobile uniquement) -->
        <div class="sidebar-header">
            <span class="sidebar-title">Filtres</span>
            <button class="sidebar-close" onclick="toggleFilters()" aria-label="Fermer les filtres">✕</button>
        </div>

        <div class="filters-card">

            <!-- Bloc 1 : Navigation catégories -->
            <div class="filter-section" style="padding-top:0;border-top:none;">
                <h3 class="filter-title">Catégories</h3>
                <ul class="categories-list">
                    <li class="category-item">
                        <a href="/category" class="category-link">
                            <span>Toutes les catégories</span>
                        </a>
                    </li>
                    <?php foreach (($categories ?? []) as $cat): ?>
                        <li class="category-item">
                            <a href="/category/<?= e($cat[\'slug\']) ?>"
                               class="category-link <?= ($cat[\'slug\'] === $category[\'slug\']) ? \'active\' : \'\' ?>">
                                <span><?= e($cat[\'name\']) ?></span>
                                <?php if (!empty($cat[\'product_count\'])): ?>
                                    <span class="count"><?= (int)$cat[\'product_count\'] ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Bloc 2 : Slider prix -->
            <div class="filter-section">
                <h3 class="filter-title">Prix maximum</h3>
                <input type="range" id="priceRange" class="price-range"
                       min="0" max="500" step="5" value="500"
                       oninput="updatePriceLabel(this.value)"
                       aria-label="Prix maximum">
                <div class="price-labels">
                    <span>0 €</span>
                    <span id="priceLabel">500 €</span>
                </div>
            </div>

            <!-- Bloc 3 : Tags filtres rapides -->
            <div class="filter-section">
                <h3 class="filter-title">Affiner</h3>
                <div class="tags-container">
                    <button class="badge-secondary filter-tag" data-filter="new"   onclick="toggleTag(this)">Nouveautés</button>
                    <button class="badge-secondary filter-tag" data-filter="promo" onclick="toggleTag(this)">En promo</button>
                    <button class="badge-secondary filter-tag" data-filter="rated" onclick="toggleTag(this)">Bien notés</button>
                </div>
            </div>

            <!-- Bouton appliquer -->
            <div class="filter-section" style="border-top:none;margin-bottom:0;padding-top:8px;">
                <button class="btn btn-primary" style="width:100%;" onclick="applyFilters()">
                    Appliquer les filtres
                </button>
            </div>

        </div><!-- /filters-card -->
    </aside>

    <!-- ── CONTENU PRINCIPAL ── -->
    <div class="catalog-content">

        <!-- Toolbar : compteur + filtres mobile + tri + vue -->
        <div class="catalog-toolbar">

            <span class="results-count">
                <?= count($products) ?> résultat<?= count($products) > 1 ? \'s\' : \'\' ?>
            </span>

            <div class="toolbar-right">
                <!-- Bouton "Filtres" visible uniquement sur mobile -->
                <button class="btn btn-secondary btn-sm toggle-filters"
                        id="toggleFiltersBtn"
                        onclick="toggleFilters()"
                        aria-expanded="false">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="4" y1="6" x2="20" y2="6"/>
                        <line x1="8" y1="12" x2="16" y2="12"/>
                        <line x1="11" y1="18" x2="13" y2="18"/>
                    </svg>
                    Filtres
                </button>

                <span class="sort-label">Trier :</span>

                <!-- Sélecteur de tri — préserve la valeur GET au rechargement -->
                <select id="sortFilter" class="form-select"
                        onchange="applySorting(this.value)"
                        aria-label="Trier les produits">
                    <option value="newest"    <?= (($_GET[\'sort\'] ?? \'\') === \'newest\')    ? \'selected\' : \'\' ?>>Plus récents</option>
                    <option value="price_asc" <?= (($_GET[\'sort\'] ?? \'\') === \'price_asc\') ? \'selected\' : \'\' ?>>Prix croissant</option>
                    <option value="price_desc"<?= (($_GET[\'sort\'] ?? \'\') === \'price_desc\')? \'selected\' : \'\' ?>>Prix décroissant</option>
                    <option value="popular"   <?= (($_GET[\'sort\'] ?? \'\') === \'popular\')   ? \'selected\' : \'\' ?>>Populaires</option>
                    <option value="rating"    <?= (($_GET[\'sort\'] ?? \'\') === \'rating\')    ? \'selected\' : \'\' ?>>Mieux notés</option>
                </select>

                <!-- Bascule grille / liste -->
                <div class="view-toggle" role="group" aria-label="Mode d\'affichage">
                    <button id="btnViewGrid" class="btn-icon view-btn active"
                            onclick="switchView(\'grid\')" title="Vue grille" aria-pressed="true">
                        <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="8" height="8" rx="1"/>
                            <rect x="13" y="3" width="8" height="8" rx="1"/>
                            <rect x="3" y="13" width="8" height="8" rx="1"/>
                            <rect x="13" y="13" width="8" height="8" rx="1"/>
                        </svg>
                    </button>
                    <button id="btnViewList" class="btn-icon view-btn"
                            onclick="switchView(\'list\')" title="Vue liste" aria-pressed="false">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <line x1="3" y1="12" x2="21" y2="12"/>
                            <line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div><!-- /catalog-toolbar -->

        <!-- ══ ÉTAT VIDE ══ -->
        <?php if (empty($products)): ?>
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h3 class="empty-title">Aucun produit pour l\'instant</h3>
                <p class="empty-description">
                    Soyez le premier à publier dans <strong><?= e($category[\'name\']) ?></strong> !
                </p>
                <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
                    <a href="/category" class="btn btn-secondary">Voir toutes les catégories</a>
                    <?php if (isset($_SESSION[\'user_role\']) && $_SESSION[\'user_role\'] === \'seller\'): ?>
                        <a href="/seller/products/create" class="btn btn-primary">Ajouter un produit</a>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>

        <!-- ══ GRILLE PRODUITS ══ -->
        <div class="products-grid" id="productsGrid">

            <?php foreach ($products as $product): ?>
                <?php
                // Badge "Nouveau" : produit créé il y a moins de 7 jours
                $isNew = !empty($product[\'created_at\'])
                    && (time() - strtotime($product[\'created_at\'])) < (7 * 24 * 3600);

                // Badge promo : calcul du % de réduction
                $hasPromo = !empty($product[\'original_price\'])
                    && $product[\'original_price\'] > $product[\'price\'];
                $discountPct = $hasPromo
                    ? round((1 - $product[\'price\'] / $product[\'original_price\']) * 100)
                    : 0;

                // Note arrondie à 0.5 pour les demi-étoiles
                $rating = !empty($product[\'rating_average\'])
                    ? round($product[\'rating_average\'] * 2) / 2
                    : 0;
                ?>

                <article class="product-card">

                    <!-- Image cliquable -->
                    <a href="/products/<?= e($product[\'slug\']) ?>"
                       class="product-image-container"
                       tabindex="-1" aria-hidden="true">

                        <?php if (!empty($product[\'thumbnail_url\'])): ?>
                            <img class="product-image"
                                 src="<?= e($product[\'thumbnail_url\']) ?>"
                                 alt="<?= e($product[\'title\']) ?>"
                                 loading="lazy"
                                 onerror="this.src=\'/public/images/placeholder-product.jpg\'">
                        <?php else: ?>
                            <!-- Placeholder si pas d\'image -->
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f5f1eb;">
                                <svg width="44" height="44" fill="currentColor" viewBox="0 0 24 24" style="opacity:.2;">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <!-- Badge Nouveau prioritaire sur badge Promo -->
                        <?php if ($isNew): ?>
                            <span class="product-badge">Nouveau</span>
                        <?php elseif ($hasPromo): ?>
                            <span class="product-badge" style="background:#fbe8ef;color:#c0305a;">-<?= $discountPct ?>%</span>
                        <?php endif; ?>
                    </a>

                    <!-- Contenu texte -->
                    <div class="product-content">

                        <!-- Ligne haute : tag catégorie + étoiles -->
                        <div class="product-header">
                            <span class="badge-primary"><?= e($category[\'name\']) ?></span>

                            <?php if ($rating > 0): ?>
                                <div class="product-rating" title="<?= number_format($product[\'rating_average\'], 1) ?>/5">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="rating-star">
                                            <?php
                                            if ($i <= $rating)           echo \'★\';
                                            elseif ($i - 0.5 <= $rating) echo \'⯨\';
                                            else                          echo \'☆\';
                                            ?>
                                        </span>
                                    <?php endfor; ?>
                                    <span class="rating-count">(<?= (int)($product[\'rating_count\'] ?? 0) ?>)</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Titre cliquable -->
                        <h3 class="product-title">
                            <a href="/products/<?= e($product[\'slug\']) ?>"><?= e($product[\'title\']) ?></a>
                        </h3>

                        <!-- Description tronquée à 100 caractères -->
                        <?php if (!empty($product[\'description\'])): ?>
                            <p class="product-description">
                                <?= e(mb_substr($product[\'description\'], 0, 100)) ?>…
                            </p>
                        <?php endif; ?>

                        <!-- Nom du vendeur avec lien profil public -->
                        <?php if (!empty($product[\'seller_name\'])): ?>
                            <p class="product-seller">
                                par
                                <?php if (!empty($product[\'seller_slug\'])): ?>
                                    <a href="/seller/<?= e($product[\'seller_slug\']) ?>" class="seller-link">
                                        <?= e($product[\'seller_name\']) ?>
                                    </a>
                                <?php else: ?>
                                    <strong><?= e($product[\'seller_name\']) ?></strong>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Footer card : prix + actions -->
                        <div class="product-footer">

                            <!-- Bloc prix (avec ancien prix barré si promo) -->
                            <div class="price-container">
                                <span class="product-price">
                                    <?= number_format($product[\'price\'], 2, \',\', \' \') ?> €
                                </span>
                                <?php if ($hasPromo): ?>
                                    <span class="product-price-original">
                                        <?= number_format($product[\'original_price\'], 2, \',\', \' \') ?> €
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Boutons : wishlist (si connecté) + voir détails -->
                            <div class="product-actions">
                                <?php if (isLoggedIn()): ?>
                                    <button class="btn-wishlist"
                                            data-product-id="<?= (int)$product[\'id\'] ?>"
                                            title="Ajouter aux favoris"
                                            aria-label="Ajouter <?= e($product[\'title\']) ?> aux favoris">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                                        </svg>
                                    </button>
                                <?php endif; ?>

                                <a href="/products/<?= e($product[\'slug\']) ?>" class="btn btn-primary btn-sm">
                                    Voir
                                </a>
                            </div>
                        </div><!-- /product-footer -->

                    </div><!-- /product-content -->
                </article>

            <?php endforeach; ?>
        </div><!-- /products-grid -->

        <?php endif; ?>

        <!-- ══ PAGINATION avec ellipsis ══ -->
        <?php if (!empty($pagination) && $pagination[\'total_pages\'] > 1): ?>
            <?php
            $cur   = $pagination[\'current\'];
            $total = $pagination[\'total_pages\'];
            $range = 2; // pages affichées de chaque côté de la page courante
            $from  = max(1, $cur - $range);
            $to    = min($total, $cur + $range);
            // Préserve le paramètre sort dans les liens de pagination
            $sortParam = !empty($_GET[\'sort\']) ? \'&sort=\' . e($_GET[\'sort\']) : \'\';
            ?>
            <nav class="pagination-container" aria-label="Pagination" style="margin-top:32px;">

                <?php if ($cur > 1): ?>
                    <a href="?page=<?= $cur - 1 ?><?= $sortParam ?>" class="btn btn-secondary btn-sm">← Précédent</a>
                <?php endif; ?>

                <?php if ($from > 1): ?>
                    <a href="?page=1<?= $sortParam ?>" class="btn btn-secondary btn-sm">1</a>
                    <?php if ($from > 2): ?><span class="pagination-ellipsis">…</span><?php endif; ?>
                <?php endif; ?>

                <?php for ($i = $from; $i <= $to; $i++): ?>
                    <?php if ($i === $cur): ?>
                        <span class="btn btn-primary btn-sm" aria-current="page"><?= $i ?></span>
                    <?php else: ?>
                        <a href="?page=<?= $i ?><?= $sortParam ?>" class="btn btn-secondary btn-sm"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($to < $total): ?>
                    <?php if ($to < $total - 1): ?><span class="pagination-ellipsis">…</span><?php endif; ?>
                    <a href="?page=<?= $total ?><?= $sortParam ?>" class="btn btn-secondary btn-sm"><?= $total ?></a>
                <?php endif; ?>

                <?php if ($cur < $total): ?>
                    <a href="?page=<?= $cur + 1 ?><?= $sortParam ?>" class="btn btn-secondary btn-sm">Suivant →</a>
                <?php endif; ?>

            </nav>
        <?php endif; ?>

    </div><!-- /catalog-content -->
</div><!-- /catalog-grid -->


<!-- ═══════════════════════════════════════════
     STYLES SPÉCIFIQUES À LA PAGE CATÉGORIE
     (complète le <style>
/* ═══════════════════════════════════════════════════
   PAGE CATÉGORIE — CSS COMPLET MAQUETTE2
   ═══════════════════════════════════════════════════ */

/* FIL D'ARIANE */
.breadcrumb-nav { margin-top: 1.5rem; margin-bottom: 0; }
.breadcrumb {
    display: flex; align-items: center; flex-wrap: wrap;
    gap: 0.4rem; list-style: none; padding: 0; margin: 0;
    font-family: "Manrope", sans-serif; font-size: 0.8rem;
}
.breadcrumb-link { color: #8a7060; text-decoration: none; transition: color 0.15s; }
.breadcrumb-link:hover { color: #7c6cf0; }
.breadcrumb-sep { color: #c4b8a8; user-select: none; }
.breadcrumb-current { font-weight: 600; color: #7c6cf0; }

/* EN-TÊTE CATÉGORIE */
.category-header {
    padding: 1.5rem 0 1.25rem;
    border-bottom: 0.5px solid #ede8df;
    margin-bottom: 0;
}
.category-header-inner { display: flex; align-items: flex-start; gap: 1rem; }
.category-icon {
    width: 48px; height: 48px; min-width: 48px;
    border-radius: 12px; background: #ede9fe; color: #534ab7;
    font-family: Georgia, serif; font-size: 1.4rem;
    display: flex; align-items: center; justify-content: center;
}
.category-title {
    font-family: Georgia, serif; font-size: 1.6rem;
    font-weight: 400; color: #1e1208; margin: 0 0 0.35rem;
}
.category-description {
    font-family: "Manrope", sans-serif; font-size: 0.875rem;
    color: #6b5c4e; line-height: 1.65; margin: 0 0 0.35rem; max-width: 560px;
}
.category-count {
    font-family: "Manrope", sans-serif; font-size: 0.775rem; color: #a0907e; margin: 0;
}

/* ─── LAYOUT 2 COLONNES ─── */
.catalog-grid {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 24px;
    padding: 24px 0 56px;
    align-items: start;
}
.catalog-content { min-width: 0; }

/* ─── SIDEBAR ─── */
.filters-sidebar {
    position: sticky;
    top: 68px;
}
.filters-card {
    background: #fff;
    border: 0.5px solid #ede8df;
    border-radius: 14px;
    padding: 18px 16px;
}
.sidebar-header {
    display: flex; justify-content: space-between;
    align-items: center; margin-bottom: 14px;
}
.sidebar-title { font-family: Georgia, serif; font-size: 1rem; color: #1e1208; }
.sidebar-close {
    display: none; background: none; border: none;
    font-size: 1.1rem; color: #8a7060; cursor: pointer;
    padding: 4px 8px; border-radius: 6px; line-height: 1;
}
.sidebar-close:hover { background: #f5f1eb; }

.filter-section {
    padding: 14px 0;
    border-top: 0.5px solid #ede8df;
    margin-bottom: 0;
}
.filter-title {
    font-family: "Manrope", sans-serif; font-size: 0.7rem;
    font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
    color: #a0907e; margin: 0 0 10px;
}

/* Liste catégories sidebar */
.categories-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 2px; }
.category-item { margin: 0; }
.category-link {
    display: flex; justify-content: space-between; align-items: center;
    padding: 7px 10px; border-radius: 8px;
    font-family: "Manrope", sans-serif; font-size: 0.8125rem; color: #6b5c4e;
    text-decoration: none; transition: all 0.15s;
}
.category-link:hover { background: #f5f1eb; color: #1e1208; }
.category-link.active { background: #ede9fe; color: #534ab7; font-weight: 600; }
.category-link .count {
    font-size: 0.7rem; background: #f5f1eb; color: #a0907e;
    padding: 1px 7px; border-radius: 10px;
}
.category-link.active .count { background: #c9c4f5; color: #2a2165; }

/* Slider prix */
.price-range {
    width: 100%; height: 4px; border-radius: 4px;
    background: #ede8df; outline: none; cursor: pointer;
    -webkit-appearance: none; appearance: none;
    padding: 0; border: none; box-shadow: none;
}
.price-range::-webkit-slider-thumb {
    -webkit-appearance: none; width: 16px; height: 16px;
    border-radius: 50%; background: #7c6cf0;
    border: 2px solid #fff; box-shadow: 0 1px 4px rgba(0,0,0,.2); cursor: pointer;
}
.price-range:focus { box-shadow: none; border: none; }
.price-labels {
    display: flex; justify-content: space-between;
    font-family: "Manrope", sans-serif; font-size: 0.75rem; color: #a0907e;
    margin-top: 8px;
}

/* Tags filtres */
.tags-container { display: flex; flex-wrap: wrap; gap: 6px; }
.filter-tag {
    font-family: "Manrope", sans-serif; font-size: 0.75rem;
    padding: 5px 12px; border-radius: 20px; border: none;
    cursor: pointer; transition: all 0.15s;
}

/* ─── TOOLBAR ─── */
.catalog-toolbar {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0 16px; border-bottom: 0.5px solid #ede8df; margin-bottom: 20px;
    flex-wrap: wrap; gap: 8px;
}
.results-count {
    font-family: "Manrope", sans-serif; font-size: 0.8125rem; color: #8a7060;
}
.toolbar-right { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.sort-label {
    font-family: "Manrope", sans-serif; font-size: 0.8rem; color: #a0907e;
}
.form-select {
    font-family: "Manrope", sans-serif; font-size: 0.8rem; color: #1e1208;
    background: #fff; border: 0.5px solid #ddd6c8; border-radius: 8px;
    padding: 6px 10px; cursor: pointer; min-width: auto;
    width: auto;
}
.form-select:focus { box-shadow: none; border-color: #c9c4f5; }

/* Toggle vue grille/liste */
.view-toggle { display: flex; gap: 3px; }
.view-btn {
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    background: transparent; border: 0.5px solid #ddd6c8;
    border-radius: 7px; cursor: pointer; color: #8a7060;
    transition: all 0.15s;
}
.view-btn:hover { background: #f5f1eb; color: #1e1208; }
.view-btn.active { background: #ede9fe; color: #534ab7; border-color: #c9c4f5; }

/* Bouton toggle filtres — masqué sur desktop */
.toggle-filters { display: none; }

/* ─── GRILLE PRODUITS ─── */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 14px;
}

/* ─── PRODUCT CARD — maquette2 ─── */
.product-card {
    background: #fff; border-radius: 14px; border: 0.5px solid #ede8df;
    overflow: hidden; display: flex; flex-direction: column;
    transition: transform 0.2s ease; cursor: pointer;
    box-shadow: none;
}
.product-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.07); }
.product-card::before { display: none; }

.product-image-container {
    position: relative; aspect-ratio: 16/10; overflow: hidden;
    background: #f5f1eb; display: block;
}
.product-image { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease; }
.product-card:hover .product-image { transform: scale(1.05); }
.product-image-container::after { display: none; }

.product-badge {
    position: absolute; top: 10px; left: 10px;
    font-family: "Manrope", sans-serif; font-size: 10px; font-weight: 500;
    padding: 4px 10px; border-radius: 10px;
    background: rgba(255,255,255,.92); color: #534ab7;
}

.product-content { padding: 13px; display: flex; flex-direction: column; gap: 6px; flex: 1; }

.product-header { display: flex; justify-content: space-between; align-items: center; gap: 6px; flex-wrap: wrap; }
.badge-primary {
    display: inline-block;
    font-family: "Manrope", sans-serif; font-size: 9px; font-weight: 700;
    letter-spacing: 0.06em; text-transform: uppercase;
    background: #ede9fe; color: #534ab7;
    padding: 3px 8px; border-radius: 20px;
}
.product-rating { display: flex; align-items: center; gap: 3px; font-size: 11px; }
.rating-star { color: #ba7517; }
.rating-count { font-family: "Manrope", sans-serif; font-size: 10px; color: #a0907e; }

.product-title {
    font-family: Georgia, serif; font-size: 14px; font-weight: 400;
    color: #1e1208; line-height: 1.4; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.product-title a { color: inherit; text-decoration: none; }
.product-title a:hover { color: #7c6cf0; }

.product-description {
    font-family: "Manrope", sans-serif; font-size: 11px; color: #8a7060;
    line-height: 1.6; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}

.product-seller { font-family: "Manrope", sans-serif; font-size: 11px; color: #a0907e; margin: 0; }
.seller-link { color: #7c6cf0; text-decoration: none; }
.seller-link:hover { text-decoration: underline; }

.product-footer {
    display: flex; justify-content: space-between; align-items: center;
    border-top: 0.5px solid #ede8df; padding-top: 10px; margin-top: auto;
    gap: 8px;
}
.price-container { display: flex; flex-direction: column; gap: 1px; }
.product-price {
    font-family: Georgia, serif; font-size: 17px; font-weight: 400;
    color: #1e1208; line-height: 1;
    background: none; -webkit-text-fill-color: #1e1208;
}
.product-price-original {
    font-family: "Manrope", sans-serif; font-size: 11px;
    color: #a0907e; text-decoration: line-through;
}
.product-actions { display: flex; gap: 6px; align-items: center; flex-shrink: 0; }
.btn-wishlist {
    width: 32px; height: 32px; background: #fff;
    border: 0.5px solid #ede8df; border-radius: 8px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: all 0.15s; padding: 0; color: #a0907e;
}
.btn-wishlist:hover { border-color: #c9c4f5; background: #ede9fe; color: #7c6cf0; transform: none; }
.btn.btn-primary.btn-sm {
    font-family: "Manrope", sans-serif; font-size: 11px;
    padding: 5px 12px; border-radius: 8px;
    background: #ede9fe; color: #534ab7;
    border: none; box-shadow: none;
    transition: background 0.15s;
}
.btn.btn-primary.btn-sm:hover { background: #c9c4f5; color: #2a2165; transform: none; box-shadow: none; }
.btn.btn-primary.btn-sm::before { display: none; }

/* ─── ÉTAT VIDE ─── */
.empty-state {
    text-align: center; padding: 64px 20px;
    background: #fff; border-radius: 14px; border: 0.5px solid #ede8df;
}
.empty-icon { font-size: 2.5rem; margin-bottom: 12px; }
.empty-title { font-family: Georgia, serif; font-size: 1.25rem; font-weight: 400; color: #1e1208; margin-bottom: 8px; }
.empty-description { font-family: "Manrope", sans-serif; font-size: 0.875rem; color: #8a7060; margin-bottom: 20px; }

/* ─── PAGINATION ─── */
.pagination-container {
    display: flex; justify-content: center; align-items: center;
    gap: 6px; margin-top: 28px; flex-wrap: wrap;
}
.pagination-container .btn.btn-secondary.btn-sm {
    background: #fff; border: 0.5px solid #ddd6c8; color: #6b5c4e;
    font-family: "Manrope", sans-serif; font-size: 0.8rem;
    padding: 6px 12px; border-radius: 8px; box-shadow: none;
}
.pagination-container .btn.btn-secondary.btn-sm:hover { background: #f5f1eb; transform: none; }
.pagination-container .btn.btn-primary.btn-sm { background: #7c6cf0; color: #fff; font-size: 0.8rem; padding: 6px 12px; border-radius: 8px; box-shadow: none; }
.pagination-ellipsis { font-family: "Manrope", sans-serif; font-size: 13px; color: #a0907e; padding: 0 4px; }

/* ─── OVERLAY MOBILE ─── */
.filters-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.4); z-index: 998;
}
.filters-overlay.active { display: block; }

/* ─── RESPONSIVE ─── */
@media (max-width: 1024px) {
    .catalog-grid { grid-template-columns: 1fr; }
    .filters-sidebar {
        position: fixed; top: 0; left: -280px; width: 280px; height: 100vh;
        overflow-y: auto; z-index: 999; background: #faf9f5;
        padding: 16px; transition: left 0.3s ease;
        box-shadow: none;
    }
    .filters-sidebar.active { left: 0; box-shadow: 4px 0 20px rgba(0,0,0,.15); }
    .sidebar-close { display: block; }
    .toggle-filters { display: inline-flex; }
    .sort-label { display: none; }
}

@media (max-width: 640px) {
    .catalog-toolbar { flex-direction: column; align-items: flex-start; }
    .products-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 420px) {
    .products-grid { grid-template-columns: 1fr; }
}
</style>


<!-- ═══════════════════════════════════════════
     JAVASCRIPT — tri, vue, filtres, sidebar
     ═══════════════════════════════════════════ -->
<script>
/**
 * Applique le tri en rechargeant la page.
 * Préserve TOUS les paramètres GET existants (page, filtres, etc.)
 * sauf "sort" qui est remplacé.
 */
function applySorting(sortValue) {
    const url = new URL(window.location.href);
    url.searchParams.set("sort", sortValue);
    window.location.href = url.toString();
}

/**
 * Bascule entre vue grille et vue liste.
 * Met à jour aria-pressed sur les deux boutons.
 */
function switchView(viewType) {
    const grid    = document.getElementById("productsGrid");
    const btnGrid = document.getElementById("btnViewGrid");
    const btnList = document.getElementById("btnViewList");
    if (!grid) return;

    if (viewType === "grid") {
        grid.className = "products-grid";          // retour grille auto-fill
        btnGrid.classList.add("active");    btnGrid.setAttribute("aria-pressed", "true");
        btnList.classList.remove("active"); btnList.setAttribute("aria-pressed", "false");
    } else {
        grid.style.cssText = "display:flex;flex-direction:column;gap:12px;"; // vue liste
        btnList.classList.add("active");    btnList.setAttribute("aria-pressed", "true");
        btnGrid.classList.remove("active"); btnGrid.setAttribute("aria-pressed", "false");
    }
}

/**
 * Ouvre/ferme la sidebar filtres sur mobile.
 * Active également l'overlay sombre.
 */
function toggleFilters() {
    const sidebar = document.getElementById("filtersSidebar");
    const overlay = document.getElementById("filtersOverlay");
    const btn     = document.getElementById("toggleFiltersBtn");
    const isOpen  = sidebar.classList.toggle("active");

    overlay.classList.toggle("active", isOpen);
    if (btn) btn.setAttribute("aria-expanded", isOpen ? "true" : "false");

    // Empêche le scroll du body quand la sidebar est ouverte
    document.body.style.overflow = isOpen ? "hidden" : "";
}

/**
 * Active/désactive un tag filtre (toggle visuel uniquement pour l'instant).
 * À brancher sur un filtre AJAX ou rechargement selon votre logique métier.
 */
function toggleTag(btn) {
    btn.classList.toggle("badge-primary");
    btn.classList.toggle("badge-secondary");
}

/**
 * Met à jour le label du prix maximum en temps réel.
 */
function updatePriceLabel(value) {
    const label = document.getElementById("priceLabel");
    if (label) label.textContent = value + " €";
}

/**
 * Applique les filtres actifs en les ajoutant à l'URL.
 * Prix max + tags sélectionnés sont transmis en GET.
 */
function applyFilters() {
    const url      = new URL(window.location.href);
    const maxPrice = document.getElementById("priceRange").value;
    const activeTags = [...document.querySelectorAll(".filter-tag.badge-primary")]
        .map(btn => btn.dataset.filter);

    url.searchParams.set("price_max", maxPrice);
    url.searchParams.delete("tag");
    activeTags.forEach(tag => url.searchParams.append("tag", tag));
    url.searchParams.delete("page"); // reset pagination quand on filtre

    window.location.href = url.toString();
}

/**
 * Au chargement : restaure l'état des filtres depuis les params GET.
 */
document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);

    // Restaure la valeur du slider prix
    const maxPrice = params.get("price_max");
    if (maxPrice) {
        const slider = document.getElementById("priceRange");
        if (slider) { slider.value = maxPrice; updatePriceLabel(maxPrice); }
    }

    // Restaure les tags actifs
    params.getAll("tag").forEach(function (tagVal) {
        const btn = document.querySelector(\'.filter-tag[data-filter="\' + tagVal + \'"]\');
        if (btn) {
            btn.classList.remove("badge-secondary");
            btn.classList.add("badge-primary");
        }
    });
});
</script>
