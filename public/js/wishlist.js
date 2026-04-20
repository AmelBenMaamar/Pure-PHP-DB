/**
 * MARKETFLOW PRO - WISHLIST UNIFIÉE (v2.0)
 * - Délégation d'événements sur document
 * - Compatible boutons grille (index.php) & fiche (show.php)
 * - Pas de duplication, pas de inline JS
 */
(function() {
  'use strict';

  // État local pour éviter les requêtes en double si le réseau est lent
  const pendingRequests = new Set();

  // Injection CSS légère (uniquement si non présente)
  if (!document.getElementById('wishlist-core-styles')) {
    const style = document.createElement('style');
    style.id = 'wishlist-core-styles';
    style.textContent = `
      .btn-wishlist { transition: transform 0.15s, background 0.15s, border-color 0.15s; }
      .btn-wishlist:hover { transform: scale(1.05); }
      .btn-wishlist.in-wishlist { background: #fbeaf0; border-color: #d4537e; }
      .btn-wishlist[disabled] { opacity: 0.5; pointer-events: none; }
      @keyframes wishlist-pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.15)} }
      .wishlist-animate { animation: wishlist-pulse 0.4s ease; }
    `;
    document.head.appendChild(style);
  }

  // Écouteur unique sur le document (délégation)
  document.addEventListener('click', async function(e) {
    const btn = e.target.closest('.btn-wishlist');
    if (!btn) return;

    e.preventDefault();
    e.stopPropagation();

    const productId = btn.dataset.productId;
    if (!productId || pendingRequests.has(productId)) return;

    // Vérification connexion
    const isLoggedIn = document.body.dataset.userLoggedIn === 'true' ||
                       !!document.querySelector('[data-dropdown]');
    if (!isLoggedIn) {
      if (window.showNotification) window.showNotification('Connectez-vous pour ajouter aux favoris ❤️', 'info');
      setTimeout(() => window.location.href = `/login?redirect=${encodeURIComponent(window.location.pathname)}`, 1200);
      return;
    }

    const isInWishlist = btn.classList.contains('in-wishlist');
    const url = isInWishlist ? '/wishlist/remove' : '/wishlist/add';
    pendingRequests.add(productId);
    btn.disabled = true;

    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
        body: `product_id=${encodeURIComponent(productId)}`
      });
      const data = await res.json();

      if (data.success) {
        btn.classList.toggle('in-wishlist');
        btn.classList.add('wishlist-animate');
        setTimeout(() => btn.classList.remove('wishlist-animate'), 400);

        const icon = btn.querySelector('.wishlist-icon') || btn;
        icon.textContent = btn.classList.contains('in-wishlist') ? '❤️' : '🤍';
        btn.title = btn.classList.contains('in-wishlist') ? 'Retirer des favoris' : 'Ajouter aux favoris';
        btn.setAttribute('aria-label', btn.title);

        // Mise à jour badge header si présent
        if (data.count !== undefined) {
          const badge = document.querySelector('.wishlist-count');
          if (badge) {
            badge.textContent = data.count;
            badge.style.display = data.count > 0 ? 'inline-flex' : 'none';
            if (window.showNotification) window.showNotification(data.message, 'success');
          }
        }
      } else {
        throw new Error(data.message || 'Erreur serveur');
      }
    } catch (err) {
      console.warn('[Wishlist]', err);
      if (window.showNotification) window.showNotification('Impossible de mettre à jour les favoris', 'error');
    } finally {
      pendingRequests.delete(productId);
      btn.disabled = false;
    }
  });

  console.log('✅ Wishlist.js (v2.0) - Délégation active');
})();
