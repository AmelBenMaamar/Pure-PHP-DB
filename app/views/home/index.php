<?php
/**
 * ================================================================
 * MARKETFLOW PRO - PAGE D'ACCUEIL v4 (UX amélioré)
 * ================================================================
 * Design : maquette2 (Georgia serif · Manrope · beige · #6B74D6)
 *
 * SECTIONS :
 * 1. Hero        — titre + CTA + trust bar + stats dynamiques
 * 2. Catégories  — 4 cartes asymétriques avec en-tête de section
 * 3. Comment ça marche — 3 étapes CSS pur
 * 4. Produits populaires
 * 5. Features    — pourquoi MarketFlow
 * 6. CTA final   — appel vendeur
 * ================================================================
 */
?>

<!-- ══════════════════════════════════════════
     1. HERO
     ══════════════════════════════════════════ -->
<section class="hero-section">
    <div class="container">
        <div class="hero-inner">

        <div class="hero-content">

            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Marketplace française · 100&nbsp;% digital
            </div>
            <h1 class="hero-title">
                Produits digitaux pour votre
                <em class="hero-accent">autonomie</em>
            </h1>

            <p class="hero-subtitle">
                Découvrez des ressources premium pour le développement personnel,
                l'autonomie et un mode de vie plus conscient.
            </p>
            <div class="hero-cta">
                <a href="/products" class="hero-btn-primary">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                    Explorer les ressources
                </a>
                <a href="/register" class="hero-btn-secondary">Devenir vendeur →</a>
            </div>

            <div class="hero-trust">
                <span class="hero-trust-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Téléchargement instantané
                </span>
                <span class="hero-trust-sep"></span>
                <span class="hero-trust-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    Paiement sécurisé Stripe
                </span>
                <span class="hero-trust-sep"></span>
                <span class="hero-trust-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                    Accès immédiat
                </span>
            </div>

        </div><!-- /.hero-content -->

            <div class="hero-visual" aria-hidden="true">

                <div class="hero-floatcard hero-floatcard--1">
                    <div class="hfc-img hfc-img--1"></div>
                    <div class="hfc-body">
                        <span class="hfc-cat">Développement</span>
                        <span class="hfc-title">Guide autonomie complète</span>
                        <div class="hfc-foot">
                            <span class="hfc-stars">★★★★★</span>
                            <span class="hfc-price">12 €</span>
                        </div>
                    </div>
                </div>

                <div class="hero-floatcard hero-floatcard--2">
                    <div class="hfc-img hfc-img--2"></div>
                    <div class="hfc-body">
                        <span class="hfc-cat">Santé &amp; alimentation</span>
                        <span class="hfc-title">Nutrition &amp; bien-être</span>
                        <div class="hfc-foot">
                            <span class="hfc-stars">★★★★☆</span>
                            <span class="hfc-price">24 €</span>
                        </div>
                    </div>
                </div>

                <div class="hfc-badge">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                         stroke="#0f6e56" stroke-width="2" stroke-linecap="round">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Téléchargement immédiat
                </div>

            </div><!-- /.hero-visual -->

        </div><!-- /.hero-inner -->
    </div>
</section>


<!-- Stats bar -->
<div class="hero-stats">
    <div class="hero-stats-inner">
        <?php if (!empty($totalProducts) && $totalProducts > 0): ?>
        <div class="hero-stat-item">
            <span class="hero-stat-num"><?= $totalProducts ?>+</span>
            <span class="hero-stat-label">ressources<br>disponibles</span>
        </div>
        <?php endif; ?>
        <div class="hero-stat-item">
            <span class="hero-stat-num">4</span>
            <span class="hero-stat-label">thèmes<br>de vie</span>
        </div>
        <div class="hero-stat-item">
            <span class="hero-stat-num">100&nbsp;%</span>
            <span class="hero-stat-label">téléchargement<br>immédiat</span>
        </div>
        <div class="hero-stat-item">
            <span class="hero-stat-num">🔒</span>
            <span class="hero-stat-label">paiement<br>sécurisé</span>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════
     2. CATÉGORIES
     ══════════════════════════════════════════ -->
<section class="categories-section">

    <div class="cat-section-header">
        <span class="cat-section-label">Parcourir par thème</span>
        <a href="/category" class="cat-section-link">Toutes les catégories →</a>
    </div>

    <div class="cat-rows">

        <div class="cat-row-2col">

            <a href="/category/developpement-personnel" class="cat-card cat-card--1"
               aria-label="Voir la catégorie Développement personnel">
                <span class="cat-num" aria-hidden="true">01</span>
                <div class="cat-icon"><div class="cat-icon-frame" style="padding:1.5px;border-radius:10px;background:linear-gradient(135deg,#6BD1D6 0%,#6B94D6 25%,#6B74D6 50%,#6BC6D6 100%);display:inline-flex;flex-shrink:0"><div style="background:#fff;border-radius:8.5px;width:41px;height:41px;display:flex;align-items:center;justify-content:center"><svg width="26" height="26" viewBox="0 0 28 28" fill="none"><defs><linearGradient id="g1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#6BD1D6"/><stop offset="50%" stop-color="#6B74D6"/><stop offset="100%" stop-color="#6BC6D6"/></linearGradient></defs><circle cx="14" cy="14" r="9" stroke="url(#g1)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><polygon points="14,7 16.2,13 14,12 11.8,13" fill="url(#g1)" stroke="none"/><polygon points="14,21 16.2,15 14,16 11.8,15" fill="#6BC6D6" opacity=".35" stroke="none"/><line x1="14" y1="5" x2="14" y2="7" stroke="url(#g1)" stroke-width="1.5" stroke-linecap="round"/><line x1="14" y1="21" x2="14" y2="23" stroke="url(#g1)" stroke-width="1.5" stroke-linecap="round"/><line x1="5" y1="14" x2="7" y2="14" stroke="url(#g1)" stroke-width="1.5" stroke-linecap="round"/><line x1="21" y1="14" x2="23" y2="14" stroke="url(#g1)" stroke-width="1.5" stroke-linecap="round"/></svg></div></div></div>
                <span class="cat-label">01 · Croissance</span>
                <span class="cat-title">Développement personnel</span>
                <?php if (!empty($categoryDescs['developpement-personnel'])): ?>
                    <p style="font-family:'Manrope',sans-serif;font-size:12px;line-height:1.6;opacity:.7;margin:8px 0 0;position:relative;z-index:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        <?= htmlspecialchars($categoryDescs['developpement-personnel'], ENT_QUOTES) ?>
                    </p>
                <?php endif; ?>
                <?php $c1 = $categoryCounts['developpement-personnel'] ?? 0; ?>
                <?php if ($c1 > 0): ?>
                    <span class="cat-btn cat-btn--active">Explorer <?= $c1 ?> ressource<?= $c1 > 1 ? 's' : '' ?> →</span>
                <?php else: ?>
                    <span class="cat-btn cat-btn--empty">Bientôt disponible</span>
                <?php endif; ?>
            </a>

            <a href="/category/sante-alimentation" class="cat-card cat-card--2"
               aria-label="Voir la catégorie Santé &amp; alimentation">
                <span class="cat-num" aria-hidden="true">02</span>
                <div class="cat-icon"><div class="cat-icon-frame" style="padding:1.5px;border-radius:10px;background:linear-gradient(135deg,#6BD1D6 0%,#6B94D6 25%,#6B74D6 50%,#6BC6D6 100%);display:inline-flex;flex-shrink:0"><div style="background:#fff;border-radius:8.5px;width:41px;height:41px;display:flex;align-items:center;justify-content:center"><svg width="26" height="26" viewBox="0 0 28 28" fill="none"><defs><linearGradient id="g2" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#6BD1D6"/><stop offset="50%" stop-color="#6B74D6"/><stop offset="100%" stop-color="#6BC6D6"/></linearGradient></defs><path d="M14 22 Q5 16 5 10.5 A5 5 0 0 1 14 8.5 A5 5 0 0 1 23 10.5 Q23 16 14 22Z" stroke="url(#g2)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="14" y1="13" x2="14" y2="17" stroke="url(#g2)" stroke-width="1.5" stroke-linecap="round"/><line x1="11.5" y1="15" x2="16.5" y2="15" stroke="url(#g2)" stroke-width="1.5" stroke-linecap="round"/></svg></div></div></div>
                <span class="cat-label">02 · Bien-être</span>
                <span class="cat-title">Santé &amp; alimentation</span>
                <?php if (!empty($categoryDescs['sante-alimentation'])): ?>
                    <p style="font-family:'Manrope',sans-serif;font-size:12px;line-height:1.6;opacity:.7;margin:8px 0 0;position:relative;z-index:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        <?= htmlspecialchars($categoryDescs['sante-alimentation'], ENT_QUOTES) ?>
                    </p>
                <?php endif; ?>
                <?php $c2 = $categoryCounts['sante-alimentation'] ?? 0; ?>
                <?php if ($c2 > 0): ?>
                    <span class="cat-btn cat-btn--active">Explorer <?= $c2 ?> ressource<?= $c2 > 1 ? 's' : '' ?> →</span>
                <?php else: ?>
                    <span class="cat-btn cat-btn--empty">Bientôt disponible</span>
                <?php endif; ?>
            </a>

        </div>

        <div class="cat-row-2col-r">

            <a href="/category/jardin-autonomie" class="cat-card cat-card--3"
               aria-label="Voir la catégorie Jardin &amp; autonomie">
                <span class="cat-num" aria-hidden="true">03</span>
                <div class="cat-icon"><div class="cat-icon-frame" style="padding:1.5px;border-radius:10px;background:linear-gradient(135deg,#6BD1D6 0%,#6B94D6 25%,#6B74D6 50%,#6BC6D6 100%);display:inline-flex;flex-shrink:0"><div style="background:#fff;border-radius:8.5px;width:41px;height:41px;display:flex;align-items:center;justify-content:center"><svg width="26" height="26" viewBox="0 0 28 28" fill="none"><defs><linearGradient id="g3" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#6BD1D6"/><stop offset="50%" stop-color="#6B74D6"/><stop offset="100%" stop-color="#6BC6D6"/></linearGradient></defs><path d="M10 22 L18 22 L17 26 L11 26 Z" stroke="url(#g3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><line x1="14" y1="22" x2="14" y2="15" stroke="url(#g3)" stroke-width="1.5" stroke-linecap="round"/><path d="M14 18 Q14 12 8 10 Q8 16 14 18" stroke="url(#g3)" stroke-width="1.5" stroke-linecap="round"/><path d="M14 16 Q14 10 20 8 Q20 14 14 16" stroke="url(#g3)" stroke-width="1.5" stroke-linecap="round"/></svg></div></div></div>
                <span class="cat-label">03 · Jardinage</span>
                <span class="cat-title">Jardin &amp; autonomie</span>
                <?php if (!empty($categoryDescs['jardin-autonomie'])): ?>
                    <p style="font-family:'Manrope',sans-serif;font-size:12px;line-height:1.6;opacity:.7;margin:8px 0 0;position:relative;z-index:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        <?= htmlspecialchars($categoryDescs['jardin-autonomie'], ENT_QUOTES) ?>
                    </p>
                <?php endif; ?>
                <?php $c3 = $categoryCounts['jardin-autonomie'] ?? 0; ?>
                <?php if ($c3 > 0): ?>
                    <span class="cat-btn cat-btn--active">Explorer <?= $c3 ?> ressource<?= $c3 > 1 ? 's' : '' ?> →</span>
                <?php else: ?>
                    <span class="cat-btn cat-btn--empty">Bientôt disponible</span>
                <?php endif; ?>
            </a>

            <a href="/category/maison-energie" class="cat-card cat-card--4"
               aria-label="Voir la catégorie Maison &amp; énergie">
                <span class="cat-num" aria-hidden="true">04</span>
                <div class="cat-icon"><div class="cat-icon-frame" style="padding:1.5px;border-radius:10px;background:linear-gradient(135deg,#6BD1D6 0%,#6B94D6 25%,#6B74D6 50%,#6BC6D6 100%);display:inline-flex;flex-shrink:0"><div style="background:#fff;border-radius:8.5px;width:41px;height:41px;display:flex;align-items:center;justify-content:center"><svg width="26" height="26" viewBox="0 0 28 28" fill="none"><defs><linearGradient id="g4" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#6BD1D6"/><stop offset="50%" stop-color="#6B74D6"/><stop offset="100%" stop-color="#6BC6D6"/></linearGradient></defs><polyline points="4,13 14,4 24,13" stroke="url(#g4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 13 L7 24 L21 24 L21 13" stroke="url(#g4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><rect x="11" y="18" width="6" height="6" rx="1" stroke="url(#g4)" stroke-width="1.5"/><polyline points="16,10 14,14 17,14 15,18" stroke="url(#g4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div></div></div>
                <span class="cat-label">04 · Habitat</span>
                <span class="cat-title">Maison &amp; énergie</span>
                <?php if (!empty($categoryDescs['maison-energie'])): ?>
                    <p style="font-family:'Manrope',sans-serif;font-size:12px;line-height:1.6;opacity:.7;margin:8px 0 0;position:relative;z-index:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        <?= htmlspecialchars($categoryDescs['maison-energie'], ENT_QUOTES) ?>
                    </p>
                <?php endif; ?>
                <?php $c4 = $categoryCounts['maison-energie'] ?? 0; ?>
                <?php if ($c4 > 0): ?>
                    <span class="cat-btn cat-btn--active">Explorer <?= $c4 ?> ressource<?= $c4 > 1 ? 's' : '' ?> →</span>
                <?php else: ?>
                    <span class="cat-btn cat-btn--empty">Bientôt disponible</span>
                <?php endif; ?>
            </a>

        </div>

    </div>

</section>


<!-- ══════════════════════════════════════════
     3. COMMENT ÇA MARCHE
     ══════════════════════════════════════════ -->
<section class="how-section">
    <div class="container">
        <h2 class="how-title">En 3 étapes simples</h2>
        <div class="how-grid">

            <div class="how-step">
                <div class="how-num"><span class="how-num-text">01</span></div>
                <h3 class="how-step-title">Choisissez</h3>
                <p class="how-step-desc">
                    Parcourez notre catalogue de ressources digitales soigneusement
                    sélectionnées par thème.
                </p>
            </div>

            <div class="how-connector" aria-hidden="true"></div>

            <div class="how-step">
                <div class="how-num"><span class="how-num-text">02</span></div>
                <h3 class="how-step-title">Payez en sécurité</h3>
                <p class="how-step-desc">
                    Votre paiement est traité par Stripe. Vos données sont
                    protégées à chaque étape.
                </p>
            </div>

            <div class="how-connector" aria-hidden="true"></div>

            <div class="how-step">
                <div class="how-num"><span class="how-num-text">03</span></div>
                <h3 class="how-step-title">Téléchargez</h3>
                <p class="how-step-desc">
                    Accès immédiat à votre ressource dès la confirmation.
                    Votre lien est disponible dans votre espace compte.
                </p>
            </div>

        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════
     4. PRODUITS POPULAIRES
     ══════════════════════════════════════════ -->
<section class="products-section">
    <div class="container">
        <div class="section-header">
            <div>
                <h2 class="sec-title-new">Produits populaires</h2>
                <p class="sec-subtitle-new">Les ressources les mieux notées du moment</p>
            </div>
            <a href="/products" class="sec-link-new">Voir tout →</a>
        </div>

        <div class="products-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="prod-card-new" data-product-id="<?= e($product['id']) ?>">
                        <div class="prod-img-new">
                            <?php if (isLoggedIn()): ?>
                                <button class="wishlist-btn <?= isInWishlist($product['id']) ? 'active' : '' ?>"
                                        data-product-id="<?= e($product['id']) ?>"
                                        title="<?= isInWishlist($product['id']) ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>"
                                        aria-label="Ajouter aux favoris">
                                    <span class="heart-icon">❤️</span>
                                </button>
                            <?php endif; ?>
                            <img src="<?= str_replace('/public/', '/', e($product['thumbnail_url'] ?? $product['thumbnail'] ?? '/img/placeholder.png')) ?>"
                                 alt="<?= e($product['title']) ?>"
                                 class="product-image"
                                 loading="lazy">
                            <span class="prod-badge-new"><?= e($product['category_name'] ?? 'Digital') ?></span>
                        </div>
                        <div class="prod-body-new">
                            <?php if (isset($product['rating_average']) && $product['rating_average'] > 0): ?>
                            <div class="prod-rating">
                                <span class="prod-stars">
                                    <?php
                                        $rating = round($product['rating_average'] ?? 0);
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo $i <= $rating ? '★' : '☆';
                                        }
                                    ?>
                                </span>
                                <span class="prod-rating-count">(<?= $product['rating_count'] ?? 0 ?>)</span>
                            </div>
                            <?php endif; ?>
                            <h3 class="prod-title-new">
                                <a href="/products/<?= e($product['slug']) ?>">
                                    <?= e(truncate($product['title'], 60)) ?>
                                </a>
                            </h3>
                            <?php if (isset($product['shop_name']) || isset($product['seller_name'])): ?>
                            <div class="prod-seller-new">
                                <?= e($product['shop_name'] ?? $product['seller_name'] ?? 'Créateur') ?>
                            </div>
                            <?php endif; ?>
                            <div class="prod-foot-new">
                                <span class="prod-price-new"><?= formatPrice($product['price']) ?></span>
                                <a href="/products/<?= e($product['slug']) ?>" class="prod-btn-new">Voir</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">
                    <div class="no-products-icon">📦</div>
                    Aucun produit disponible pour le moment.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════
     5. FEATURES — Pourquoi MarketFlow ?
     ══════════════════════════════════════════ -->
<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2 class="sec-title-new">Pourquoi MarketFlow ?</h2>
        </div>
        <div class="feat-grid-new">

            <div class="feat-card-new">
                <div class="feat-ic-new" style="background:#e0f7fa;">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"
                              stroke="#5B8ED6" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="feat-title-new">Vente instantanée</h3>
                <p class="feat-desc-new">
                    Téléchargement automatique après paiement. Vos clients reçoivent
                    leurs fichiers en quelques secondes, sans intervention manuelle.
                </p>
            </div>

            <div class="feat-card-new">
                <div class="feat-ic-new" style="background:#d8f0e8;">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="9" stroke="#0f6e56" stroke-width="1.5"/>
                        <path d="M8.5 14.5c.5 1.5 2 2.5 3.5 2.5s3-1 3-2.5-1.5-2-3-2.5-3-1-3-2.5S10.5 7 12 7s3 1 3.5 2.5"
                              stroke="#0f6e56" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="feat-title-new">Commission réduite</h3>
                <p class="feat-desc-new">
                    Gardez la majorité de vos revenus. Paiements automatiques
                    et sécurisés via Stripe, virés directement sur votre compte.
                </p>
            </div>

            <div class="feat-card-new">
                <div class="feat-ic-new" style="background:#fde8ee;">
                    <svg viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="7" height="7" rx="1" stroke="#993556" stroke-width="1.5"/>
                        <rect x="14" y="3" width="7" height="7" rx="1" stroke="#993556" stroke-width="1.5"/>
                        <rect x="3" y="14" width="7" height="7" rx="1" stroke="#993556" stroke-width="1.5"/>
                        <path d="M14 17.5h7M17.5 14v7" stroke="#993556" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="feat-title-new">Dashboard complet</h3>
                <p class="feat-desc-new">
                    Suivez vos ventes en temps réel, analysez vos performances
                    et gérez vos produits depuis un espace vendeur dédié.
                </p>
            </div>

        </div>
    </div>
</section>


<!-- ══════════════════════════════════════════
     6. CTA FINAL
     ══════════════════════════════════════════ -->
<section class="cta-section">
    <div class="container">
        <div class="cta-inner-new">
            <div class="cta-badge-new">Pour les créateurs</div>
            <h2 class="cta-title-new">Prêt à vendre vos créations&nbsp;?</h2>
            <p class="cta-desc-new">
                Rejoignez MarketFlow, publiez votre première ressource en quelques minutes
                et commencez à générer des revenus passifs dès aujourd'hui.
            </p>
            <div class="cta-actions-new">
                <a href="/register" class="cta-btn-new">Créer mon compte vendeur →</a>
                <a href="/products" class="cta-link-new">Explorer d'abord</a>
            </div>
        </div>
    </div>
</section>
