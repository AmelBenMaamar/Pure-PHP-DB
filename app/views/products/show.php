<?php
/** MARKETFLOW PRO - PAGE DÉTAIL PRODUIT */
?>
<div class="container mt-8 mb-16">
<!-- Breadcrumb -->
<nav style="margin-bottom: var(--space-6); font-size: 0.875rem; color: var(--text-tertiary);">
  <a href="/" style="color: inherit;">Accueil</a> <span style="margin:0 var(--space-2)">/</span>
  <a href="/products" style="color: inherit;">Produits</a> <span style="margin:0 var(--space-2)">/</span>
  <?php if (!empty($product['category_slug'])): ?>
    <a href="/category/<?= e($product['category_slug']) ?>" style="color: inherit;"><?= e($product['category_name']) ?></a> <span style="margin:0 var(--space-2)">/</span>
  <?php endif; ?>
  <span style="color: var(--text-primary);"><?= e($product['title']) ?></span>
</nav>

<div style="display: grid; grid-template-columns: 1fr 400px; gap: var(--space-12); margin-bottom: var(--space-12);">
  <!-- Colonne gauche -->
  <div>
    <div class="card" style="padding: var(--space-8); margin-bottom: var(--space-8);">
      <div style="margin-bottom: var(--space-6);">
        <img id="mainImage" src="<?= e($product['thumbnail_url'] ?? $product['thumbnail'] ?? '/public/img/placeholder.png') ?>" alt="<?= e($product['title']) ?>" style="width:100%; border-radius:var(--radius-lg);">
      </div>
      <?php if (!empty($product['images'])): ?>
        <div style="display:grid; grid-template-columns: repeat(auto-fill,minmax(100px,1fr)); gap:var(--space-3);">
          <div class="thumbnail-item active" onclick="changeMainImage('<?= e($product['thumbnail'] ?? $product['thumbnail_url']) ?>', this)">
            <img src="<?= e($product['thumbnail'] ?? $product['thumbnail_url']) ?>" alt="Miniature" style="width:100%; border-radius:8px;">
          </div>
          <?php foreach ($product['images'] as $img): ?>
            <div class="thumbnail-item" onclick="changeMainImage('<?= e($img['image_url']) ?>', this)">
              <img src="<?= e($img['image_url']) ?>" alt="Miniature" style="width:100%; border-radius:8px;">
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="card" style="padding:0; overflow:hidden;">
      <div style="display:flex; border-bottom:1px solid var(--border-color);">
        <button class="tab-btn active" data-tab="description" style="flex:1; padding:var(--space-4); border:none; background:none; cursor:pointer;">Description</button>
        <button class="tab-btn" data-tab="reviews" style="flex:1; padding:var(--space-4); border:none; background:none; cursor:pointer; color:var(--text-secondary);">Avis (<?= count($reviews) ?>)</button>
      </div>
      <div class="tab-content active" data-tab-content="description" style="padding:var(--space-8);">
        <div style="line-height:1.8; color:var(--text-secondary);"><?= nl2br(e($product['description'])) ?></div>
        <?php if (!empty($product['tags'])): ?>
          <div style="margin-top:var(--space-8); padding-top:var(--space-6); border-top:1px solid var(--border-color);">
            <div style="display:flex; flex-wrap:wrap; gap:var(--space-2);">
              <?php foreach ($product['tags'] as $tag): ?>
                <a href="/products?tag=<?= e($tag['slug']) ?>" class="badge badge-primary"><?= e($tag['name']) ?></a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="tab-content" data-tab-content="reviews" style="padding:var(--space-8); display:none;">
        <?php if (empty($reviews)): ?>
          <div class="text-center" style="padding:var(--space-12); color:var(--text-tertiary);">💬 Aucun avis pour le moment.</div>
        <?php else: ?>
          <div style="display:flex; flex-direction:column; gap:var(--space-6);">
            <?php foreach ($reviews as $rev): ?>
              <div class="card" style="padding:var(--space-6);">
                <div style="display:flex; justify-content:space-between; margin-bottom:var(--space-3);">
                  <div style="display:flex; gap:var(--space-3); align-items:center;">
                    <div style="width:40px; height:40px; border-radius:50%; background:var(--gradient-primary); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:600;"><?= strtoupper(substr($rev['username'],0,1)) ?></div>
                    <div><div style="font-weight:600;"><?= e($rev['username']) ?></div><div style="font-size:0.75rem; color:var(--text-tertiary);"><?= date('d/m/Y',strtotime($rev['created_at'])) ?></div></div>
                  </div>
                  <div style="color:var(--warning);"><?php for($i=1;$i<=5;$i++) echo $i<=$rev['rating']?'★':'☆'; ?></div>
                </div>
                <p style="color:var(--text-secondary); line-height:1.6;"><?= nl2br(e($rev['comment'])) ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Colonne droite -->
  <aside style="position:sticky; top:100px; height:fit-content;">
    <div class="card" style="padding:var(--space-8);">
      <div style="font-size:2.5rem; font-weight:700; color:var(--primary-600); margin-bottom:var(--space-6);"><?= formatPrice($product['price']) ?></div>
      
      <?php if (isset($_SESSION['user_id'])): ?>
        <?php 
        // SAFE FALLBACK: Utilise $wishlistIds passé par le contrôleur, sinon tableau vide
        $isInWishlist = isset($wishlistIds) ? in_array($product['id'], $wishlistIds) : false; 
        ?>
        <button type="button" class="btn-wishlist <?= $isInWishlist ? 'in-wishlist' : '' ?>" data-product-id="<?= e($product['id']) ?>" style="width:100%; padding:0.75rem; margin-bottom:0.75rem; border-radius:8px; font-size:1.125rem; cursor:pointer;">
          <?= $isInWishlist ? '❤️ Dans mes favoris' : '🤍 Ajouter aux favoris' ?>
        </button>
      <?php else: ?>
        <a href="/login" style="display:block; width:100%; padding:0.75rem; margin-bottom:0.75rem; border:1px solid var(--border-color); border-radius:8px; text-align:center; text-decoration:none; color:inherit;">🤍 Connectez-vous pour ajouter aux favoris</a>
      <?php endif; ?>

      <form method="POST" action="/cart/add">
        <input type="hidden" name="csrf_token" value="<?= e($csrf_token ?? generateCsrfToken()) ?>">
        <input type="hidden" name="product_id" value="<?= e($product['id']) ?>">
        <button type="submit" class="btn btn-primary" style="width:100%; font-size:1.125rem; padding:var(--space-4); border-radius:8px;">🛒 Ajouter au panier</button>
      </form>

      <div style="margin-top:var(--space-6); border-top:1px solid var(--border-color); padding-top:var(--space-6); font-size:0.875rem;">
        <div style="display:flex; justify-content:space-between; margin-bottom:var(--space-2);"><span style="color:var(--text-tertiary);">Type</span><strong><?= strtoupper($product['file_type']??'N/A') ?></strong></div>
        <div style="display:flex; justify-content:space-between;"><span style="color:var(--text-tertiary);">Téléchargements</span><strong><?= number_format($product['downloads']??0) ?></strong></div>
      </div>
    </div>
  </aside>
</div>

<script>
function changeMainImage(src, el){ document.getElementById('mainImage').src = src; document.querySelectorAll('.thumbnail-item').forEach(t=>t.classList.remove('active')); el.classList.add('active'); }
document.querySelectorAll('.tab-btn').forEach(btn => btn.addEventListener('click', function(){
  document.querySelectorAll('.tab-btn').forEach(b=>{b.classList.remove('active'); b.style.borderBottom='none'; b.style.color='var(--text-secondary)';});
  document.querySelectorAll('.tab-content').forEach(c=>c.style.display='none');
  this.classList.add('active'); this.style.borderBottom='2px solid var(--primary-600)'; this.style.color='var(--primary-600)';
  document.querySelector(`[data-tab-content="${this.dataset.tab}"]`).style.display='block';
}));
document.querySelectorAll('.btn-wishlist').forEach(btn => btn.addEventListener('click', async function(){
  const pid = this.dataset.productId;
  const isIn = this.classList.contains('in-wishlist');
  try {
    const res = await fetch(isIn ? '/wishlist/remove' : '/wishlist/add', { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({product_id:pid}) });
    const data = await res.json();
    if(data.success){
      this.classList.toggle('in-wishlist');
      this.innerHTML = isIn ? '🤍 Ajouter aux favoris' : '❤️ Dans mes favoris';
      if(window.showNotification) showNotification(data.message, 'success');
    }
  } catch(e){ console.error(e); }
}));
</script>
