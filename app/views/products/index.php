<?php
/**
 * MARKETFLOW PRO - PAGE CATALOGUE PRODUITS
 * Fichier : app/views/products/index.php
 */
// Récupérer les IDs des produits en favoris de l'utilisateur
$wishlistIds = [];
if (isset($_SESSION['user_id'])) {
    $wishlistModel = new \App\Models\Wishlist();
    $wishlistIds = $wishlistModel->getUserWishlistIds($_SESSION['user_id']);
}
// Mapping slug → SVG icons
function getCategoryIcon(string $slug): string {
    $icons = [
        'developpement-personnel' => '<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8"/><polygon points="12,6 13.8,11 12,10.2 10.2,11" fill="currentColor" stroke="none"/><polygon points="12,18 13.8,13 12,13.8 10.2,13" fill="currentColor" opacity=".35" stroke="none"/><line x1="12" y1="3" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="21"/><line x1="3" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="21" y2="12"/></svg>',
        'sante-alimentation'      => '<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21 Q4 15 4 9.5 A4.5 4.5 0 0 1 12 7 A4.5 4.5 0 0 1 20 9.5 Q20 15 12 21Z"/><line x1="12" y1="11" x2="12" y2="15"/><line x1="10" y1="13" x2="14" y2="13"/></svg>',
        'jardin-autonomie'        => '<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21 L15 21 L14.2 23 L9.8 23 Z"/><line x1="12" y1="21" x2="12" y2="15"/><path d="M12 18 Q12 12 6 10 Q6 16 12 18"/><path d="M12 16 Q12 10 18 8 Q18 14 12 16"/></svg>',
        'maison-energie'          => '<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="3,11 12,3 21,11"/><path d="M5 11 L5 21 L19 21 L19 11"/><rect x="9" y="15" width="6" height="6" rx="1"/><polyline points="14,9 12,13 15,13 13,17" stroke-width="1.5"/></svg>',
    ];
    return $icons[$slug] ?? '<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/></svg>';
}
// Helper function pour les query params (améliorée pour supporter la suppression)
function updateQueryParam($key, $value = null) {
    $params = $_GET;
    if ($value === null) {
        unset($params[$key]);
    } else {
        $params[$key] = $value;
    }
    $query = http_build_query($params);
    return '/products' . ($query ? '?' . $query : '');
}
?>
<div class="container mt-8 mb-16">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="mb-4">Catalogue de Produits</h1>
        <p class="text-secondary" style="font-size: 1.125rem;">
            Découvrez <?= number_format($pagination['total_items']) ?> produits digitaux premium
        </p>
    </div>
    <div class="catalog-grid">
        <!-- SIDEBAR FILTRES -->
        <aside class="filters-sidebar">
            <div class="card filters-card">
                <!-- Catégories -->
                <div class="filter-section">
                    <h3 class="filter-title">Catégories</h3>
                    <ul class="categories-list">
                        <li class="category-item">
                            <a href="<?= updateQueryParam('category', null) ?>"
                               class="category-link <?= empty($active_filters['category_id']) ? 'active' : '' ?>">
                                <span>Toutes</span>
                                <span class="count"><?= number_format($pagination['total_items']) ?></span>
                            </a>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                        <li class="category-item">
                            <a href="<?= updateQueryParam('category', $cat['id']) ?>"
                               class="category-link <?= ($active_filters['category_id'] ?? null) == $cat['id'] ? 'active' : '' ?>">
                                <span>
                                    <?php if (!empty($cat['icon'])): ?>
                                    <span style="display:inline-flex;align-items:center;vertical-align:middle;margin-right:4px;opacity:0.7;"><?= getCategoryIcon($cat['slug']) ?></span>
                                    <?php endif; ?>
                                    <?= e($cat['name']) ?>
                                </span>
                                <span class="badge badge-primary"><?= e($cat['product_count']) ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- Prix -->
                <div class="filter-section">
                    <h3 class="filter-title">Prix</h3>
                    <div class="price-filter">
                        <div class="price-inputs">
                            <input type="range"
                                   id="priceMin"
                                   class="price-range"
                                   min="<?= $price_range['min_price'] ?? 0 ?>"
                                   max="<?= $price_range['max_price'] ?? 1000 ?>"
                                   value="<?= $active_filters['min_price'] ?? $price_range['min_price'] ?? 0 ?>"
                                   aria-label="Prix minimum">
                            <input type="range"
                                   id="priceMax"
                                   class="price-range"
                                   min="<?= $price_range['min_price'] ?? 0 ?>"
                                   max="<?= $price_range['max_price'] ?? 1000 ?>"
                                   value="<?= $active_filters['max_price'] ?? $price_range['max_price'] ?? 1000 ?>"
                                   aria-label="Prix maximum">
                        </div>
                        <div class="price-labels">
                            <span id="priceMinLabel">
                                <?= formatPrice($active_filters['min_price'] ?? $price_range['min_price'] ?? 0) ?>
                            </span>
                            <span>-</span>
                            <span id="priceMaxLabel">
                                <?= formatPrice($active_filters['max_price'] ?? $price_range['max_price'] ?? 1000) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Tags populaires -->
                <div class="filter-section">
                    <h3 class="filter-title">Tags populaires</h3>
                    <div class="tags-container">
                        <?php foreach (array_slice($popular_tags, 0, 10) as $tag): ?>
                        <a href="<?= updateQueryParam('tag', urlencode($tag['slug'])) ?>"
                           class="badge <?= ($active_filters['tag'] ?? null) == $tag['slug'] ? 'badge-primary' : 'badge-secondary' ?>">
                            <?= e($tag['name']) ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </aside>
        <!-- CONTENU PRINCIPAL -->
        <main class="catalog-main">
            <!-- Barre de tri et recherche -->
            <div class="catalog-toolbar">
                <!-- Bouton toggle filtres (mobile) -->
                <button id="toggleFilters" class="btn btn-secondary btn-sm toggle-filters" aria-label="Ouvrir les filtres">
                    <?php
                    $filterCount = (int)!empty($active_filters['category_id'])
                                 + (int)!empty($active_filters['tag'])
                                 + (int)isset($active_filters['min_price'])
                                 + (int)isset($active_filters['max_price']);
                    ?>
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
                    Filtres<?= $filterCount > 0 ? ' ('.$filterCount.')' : '' ?>
                    <?php if ($filterCount > 0): ?>
                        <span class="toggle-filters-badge" style="display:inline-flex"><?= $filterCount ?></span>
                    <?php endif; ?>
                </button>
                <!-- Résultats -->
                <div class="results-count">
                    <?= number_format($pagination['total_items']) ?>
                    produit<?= $pagination['total_items'] > 1 ? 's' : '' ?>
                    trouvé<?= $pagination['total_items'] > 1 ? 's' : '' ?>
                </div>
                <!-- Tri -->
                <div class="sort-container">
                    <label for="sortSelect" class="sort-label">Trier par :</label>
                    <select
                        id="sortSelect"
                        class="form-select"
                        onchange="window.location.href = this.value">
                        <option value="<?= updateQueryParam('sort', 'newest') ?>" <?= ($active_filters['sort'] ?? 'newest') == 'newest' ? 'selected' : '' ?>>
                            Plus récents
                        </option>
                        <option value="<?= updateQueryParam('sort', 'popular') ?>" <?= ($active_filters['sort'] ?? '') == 'popular' ? 'selected' : '' ?>>
                            Plus populaires
                        </option>
                        <option value="<?= updateQueryParam('sort', 'price_asc') ?>" <?= ($active_filters['sort'] ?? '') == 'price_asc' ? 'selected' : '' ?>>
                            Prix croissant
                        </option>
                        <option value="<?= updateQueryParam('sort', 'price_desc') ?>" <?= ($active_filters['sort'] ?? '') == 'price_desc' ? 'selected' : '' ?>>
                            Prix décroissant
                        </option>
                        <option value="<?= updateQueryParam('sort', 'rating') ?>" <?= ($active_filters['sort'] ?? '') == 'rating' ? 'selected' : '' ?>>
                            Meilleures notes
                        </option>
                    </select>
                </div>
            </div>
            <!-- Grille de produits -->
            <?php if (empty($products)): ?>
                <div class="card text-center empty-state">
                    <div class="empty-icon">🔍</div>
                    <h3 class="empty-title">Aucun produit trouvé</h3>
                    <p class="empty-description">
                        Essayez de modifier vos critères de recherche
                    </p>
                    <a href="<?= updateQueryParam('reset', null) ?>" class="btn btn-primary">Voir tous les produits</a>
                </div>
            <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($products as $product):
                        $isInWishlist = in_array($product['id'], $wishlistIds);
                    ?>
                    <article class="product-card">
                        <!-- Image -->
                        <a href="/products/<?= e($product['slug']) ?>" class="product-link">
                            <div class="product-image-container">
                                <img
                                    src="<?= e($product['thumbnail_url'] ?? '/public/img/placeholder.png') ?>"
                                    alt="<?= e($product['title']) ?>"
                                    class="product-image"
                                    loading="lazy"
                                    width="300"
                                    height="200">
                            </div>
                        </a>
                        <!-- Contenu -->
                        <div class="product-content">
                            <!-- Header -->
                            <div class="product-header">
                                <span class="badge badge-primary">
                                    <?= e($product['category_name']) ?>
                                </span>
                                <?php if ($product['rating_count'] > 0): ?>
                                <div class="product-rating">
                                    <span class="rating-star">★</span>
                                    <span class="rating-score">
                                        <?= number_format($product['rating_average'], 1) ?>
                                    </span>
                                    <span class="rating-count">
                                        (<?= e($product['rating_count']) ?>)
                                    </span>
                                </div>
                                <?php endif; ?>
                            </div>
                            <!-- Titre -->
                            <h3 class="product-title">
                                <a href="/products/<?= e($product['slug']) ?>">
                                    <?= e($product['title']) ?>
                                </a>
                            </h3>
                            <!-- Vendeur -->
                            <p class="product-seller">
                                Par
                                <a href="/seller/<?= urlencode($product['seller_name']) ?>" class="seller-link">
                                    <?= e($product['shop_name'] ?? $product['seller_name']) ?>
                                </a>
                            </p>
                            <!-- Prix et actions -->
                            <div class="product-footer">
                                <div class="price-container">
                                    <span class="product-price">
                                        <?= formatPrice($product['price']) ?>
                                    </span>
                                    <?php if (!empty($product['original_price']) && $product['original_price'] > $product['price']): ?>
                                    <span class="product-price-original">
                                        <?= formatPrice($product['original_price']) ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <!-- Boutons d'action -->
                                <div class="product-actions">
                                    <!-- Bouton Wishlist -->
                                    <button
                                        type="button"
                                        class="btn-wishlist <?= $isInWishlist ? 'in-wishlist' : '' ?>"
                                        data-product-id="<?= e($product['id']) ?>"
                                        title="<?= $isInWishlist ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>"
                                        aria-label="<?= $isInWishlist ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>">
                                        <span class="wishlist-icon">
                                            <?= $isInWishlist ? '❤️' : '🤍' ?>
                                        </span>
                                    </button>
                                    <!-- Bouton Voir -->
                                    <a href="/products/<?= e($product['slug']) ?>" class="btn btn-primary btn-sm">
                                        Voir
                                    </a>
                                </div>
                            </div>
                            <!-- Stats -->
                            <div class="product-stats">
                                <span>👁️ <?= number_format($product['views_count'] ?? 0) ?></span>
                                <span>💰 <?= number_format($product['sales_count'] ?? 0) ?> ventes</span>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
                <!-- Pagination -->
                <?php if ($pagination['total_pages'] > 1): ?>
                <nav class="pagination-container" aria-label="Pagination">
                    <?php if ($pagination['current'] > 1): ?>
                    <a href="<?= updateQueryParam('page', $pagination['current'] - 1) ?>"
                       class="btn btn-secondary btn-sm"
                       rel="prev">
                        ← Précédent
                    </a>
                    <?php endif; ?>
                    <?php
                    $start = max(1, $pagination['current'] - 2);
                    $end = min($pagination['total_pages'], $pagination['current'] + 2);
                    for ($i = $start; $i <= $end; $i++):
                    ?>
                    <a href="<?= updateQueryParam('page', $i) ?>"
                       class="btn btn-sm <?= $i == $pagination['current'] ? 'btn-primary' : 'btn-secondary' ?>"
                       <?= $i == $pagination['current'] ? 'aria-current="page"' : '' ?>>
                        <?= e($i) ?>
                    </a>
                    <?php endfor; ?>
                    <?php if ($pagination['current'] < $pagination['total_pages']): ?>
                    <a href="<?= updateQueryParam('page', $pagination['current'] + 1) ?>"
                       class="btn btn-secondary btn-sm"
                       rel="next">
                        Suivant →
                    </a>
                    <?php endif; ?>
                </nav>
                <?php endif; ?>
            <?php endif; ?>
        </main>
    </div>
</div>

<script>
// Filtres de prix avec debouncing et validation min/max
(function() {
    const priceMin = document.getElementById('priceMin');
    const priceMax = document.getElementById('priceMax');
    const priceMinLabel = document.getElementById('priceMinLabel');
    const priceMaxLabel = document.getElementById('priceMaxLabel');
    if (!priceMin || !priceMax) return;
    let priceTimeout;
    function formatPrice(price) {
        return parseFloat(price).toFixed(2).replace('.', ',') + ' €';
    }
    function applyPriceFilter() {
        const url = new URL(window.location.href);
        url.searchParams.set('min_price', priceMin.value);
        url.searchParams.set('max_price', priceMax.value);
        window.location.href = url.toString();
    }
    function updateLabels() {
        priceMinLabel.textContent = formatPrice(priceMin.value);
        priceMaxLabel.textContent = formatPrice(priceMax.value);
    }
    priceMin.addEventListener('input', function() {
        if (parseFloat(this.value) > parseFloat(priceMax.value)) {
            this.value = priceMax.value;
        }
        updateLabels();
        clearTimeout(priceTimeout);
        priceTimeout = setTimeout(applyPriceFilter, 500);
    });
    priceMax.addEventListener('input', function() {
        if (parseFloat(this.value) < parseFloat(priceMin.value)) {
            this.value = priceMin.value;
        }
        updateLabels();
        clearTimeout(priceTimeout);
        priceTimeout = setTimeout(applyPriceFilter, 500);
    });
})();

// Animation des cards au scroll
(function() {
    if (!('IntersectionObserver' in window)) return;
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });
    document.querySelectorAll('.product-card').forEach(card => {
        observer.observe(card);
    });
})();

           
            if (response.ok) {
                btn.classList.toggle('in-wishlist');
                const icon = btn.querySelector('.wishlist-icon');
                icon.textContent = btn.classList.contains('in-wishlist') ? '❤️' : '🤍';
                btn.title = btn.classList.contains('in-wishlist') ? 'Retirer des favoris' : 'Ajouter aux favoris';
                btn.setAttribute('aria-label', btn.title);
            } else {
                console.error('Erreur lors de la mise à jour de la wishlist');
            }
        } catch (error) {
            console.error('Erreur réseau:', error);
        }
    }
});

// Toggle filtres sur mobile avec overlay
(function() {
    const toggleBtn = document.getElementById('toggleFilters');
    const sidebar = document.querySelector('.filters-sidebar');
    if (!toggleBtn || !sidebar) return;

    // Créer l'overlay
    const overlay = document.createElement('div');
    overlay.className = 'filters-overlay';
    document.body.appendChild(overlay);

    function openFilters() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        toggleBtn.textContent = 'Fermer filtres';
        toggleBtn.setAttribute('aria-label', 'Fermer les filtres');
        document.body.style.overflow = 'hidden'; // Empêcher le scroll
    }

    function closeFilters() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        toggleBtn.textContent = 'Filtres';
        toggleBtn.setAttribute('aria-label', 'Ouvrir les filtres');
        document.body.style.overflow = ''; // Restaurer le scroll
    }

    toggleBtn.addEventListener('click', function() {
        if (sidebar.classList.contains('active')) {
            closeFilters();
        } else {
            openFilters();
        }
    });

    // Fermer les filtres si clic sur l'overlay
    overlay.addEventListener('click', closeFilters);

    // Fermer avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
            closeFilters();
        }
    });
})();
</script>
