<?php /* MARKETFLOW PRO — CONNEXION */ ?>
<div class="auth-wrap">
<div class="auth-card">
  <div class="auth-head">
    <div class="auth-logo">M</div>
    <h1 class="auth-title">Bon retour</h1>
    <p class="auth-sub">Connectez-vous pour continuer</p>
  </div>
  <?php if (isset($error)): ?>
  <div class="auth-err">
    <svg viewBox="0 0 16 16" fill="none" width="15" height="15"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.4"/><path d="M8 5v3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><circle cx="8" cy="11" r=".6" fill="currentColor"/></svg>
    <?= e($error) ?>
  </div>
  <?php endif; ?>
  <form method="POST" action="/login" id="lf">
    <input type="hidden" name="csrf_token" value="<?= e($csrf_token) ?>">
    <div class="af">
      <label class="al" for="email">Adresse email</label>
      <input type="email" id="email" name="email" class="ai" placeholder="vous@example.com"
        value="<?= isset($email) ? e($email) : '' ?>" required autofocus>
    </div>
    <div class="af">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
        <label class="al" for="password" style="margin:0">Mot de passe</label>
        <a href="/forgot-password" class="auth-fgt">Oublié ?</a>
      </div>
      <div style="position:relative">
        <input type="password" id="password" name="password" class="ai" style="padding-right:40px" placeholder="••••••••" required>
        <button type="button" class="auth-eye" onclick="tp()" title="Afficher/masquer">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </button>
      </div>
    </div>
    <button type="submit" class="auth-btn" id="lsb">Se connecter</button>
  </form>
  <div class="auth-sep"><span>ou</span></div>
  <p class="auth-sw">Pas encore de compte ? <a href="/register">S'inscrire gratuitement →</a></p>
  <p class="auth-legal">En vous connectant, vous acceptez nos <a href="/terms">CGU</a> et notre <a href="/privacy">Politique de confidentialité</a></p>
</div>
</div>
<script>
function tp(){var f=document.getElementById('password');f.type=f.type==='password'?'text':'password';}
document.getElementById('lf').addEventListener('submit',function(){var b=document.getElementById('lsb');b.textContent='Connexion…';b.disabled=true;});
</script>
