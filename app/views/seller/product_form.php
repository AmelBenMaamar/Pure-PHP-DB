<?php
/**
 * MARKETFLOW PRO - FORMULAIRE PRODUIT VENDEUR
 * Fichier : app/views/seller/product_form.php
 */

$isEdit  = $mode === 'edit';
$product = $product ?? null;
$old     = $old ?? [];

// Statuts valides selon la contrainte BDD
$statusConfig = [
    'pending'   => ['label' => 'En attente de validation', 'color' => '#92400e', 'bg' => '#fef3c7', 'icon' => '⏳'],
    'approved'  => ['label' => 'Approuvé · Visible',       'color' => '#065f46', 'bg' => '#d1fae5', 'icon' => '✅'],
    'rejected'  => ['label' => 'Refusé par l\'admin',      'color' => '#991b1b', 'bg' => '#fee2e2', 'icon' => '❌'],
    'suspended' => ['label' => 'Suspendu',                  'color' => '#4b5563', 'bg' => '#f3f4f6', 'icon' => '⏸️'],
];
$currentStatus = $isEdit ? ($product['status'] ?? 'pending') : null;
$status        = $statusConfig[$currentStatus] ?? null;
?>

<div style="min-height:100vh;background:linear-gradient(135deg,#f8fafc 0%,#e0e7ff 100%);padding:var(--space-8) 0;">
<div class="container" style="max-width:900px;">

    <!-- HEADER -->
    <div style="
        background:linear-gradient(135deg,#3b82f6 0%,#6366f1 50%,#6B94D6 100%);
        border-radius:24px;padding:var(--space-10);margin-bottom:var(--space-8);
        color:white;box-shadow:0 20px 60px rgba(99,102,241,0.3);
        position:relative;overflow:hidden;
    ">
        <div style="position:absolute;top:-50px;right:-50px;width:200px;height:200px;
            background:rgba(255,255,255,0.1);border-radius:50%;filter:blur(40px);"></div>
        <div style="position:relative;z-index:1;display:flex;align-items:flex-start;
            justify-content:space-between;flex-wrap:wrap;gap:var(--space-4);">
            <div>
                <h1 style="font-size:2.5rem;margin-bottom:var(--space-3);color:white;font-weight:800;">
                    <?= $isEdit ? '✏️ Modifier le produit' : '✨ Nouveau produit' ?>
                </h1>
                <p style="font-size:1.125rem;color:rgba(255,255,255,0.9);margin:0;">
                    <?= $isEdit
                        ? 'Modifiez les informations de votre produit'
                        : 'Créez un produit exceptionnel pour vos clients' ?>
                </p>
            </div>
            <?php if ($isEdit && $status): ?>
            <div style="
                background:<?= $status['bg'] ?>;color:<?= $status['color'] ?>;
                border-radius:12px;padding:var(--space-3) var(--space-5);
                font-weight:700;font-size:0.9rem;
                display:flex;align-items:center;gap:var(--space-2);
                white-space:nowrap;align-self:flex-start;margin-top:4px;
            ">
                <?= $status['icon'] ?> <?= $status['label'] ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- BANNIÈRE REFUS (affiche la raison si rejected) -->
    <?php if ($isEdit && $currentStatus === 'rejected' && !empty($product['rejection_reason'])): ?>
    <div style="
        background:#fee2e2;border:1px solid #fca5a5;border-radius:14px;
        padding:var(--space-5) var(--space-6);margin-bottom:var(--space-6);
        color:#991b1b;
    ">
        <strong>❌ Raison du refus :</strong><br>
        <span style="margin-top:6px;display:block;"><?= e($product['rejection_reason']) ?></span>
        <small style="opacity:0.75;margin-top:4px;display:block;">
            Corrigez les points mentionnés ci-dessus puis sauvegardez — le produit sera resoumis automatiquement.
        </small>
    </div>
    <?php endif; ?>

    <!-- BANNER ERREUR GLOBALE -->
    <?php if (!empty($errors['general'])): ?>
    <div style="
        background:#fee2e2;border:1px solid #fca5a5;border-radius:14px;
        padding:var(--space-4) var(--space-6);margin-bottom:var(--space-6);
        color:#991b1b;display:flex;align-items:center;gap:var(--space-3);
    ">
        <span style="font-size:1.5rem;">⚠️</span>
        <div><strong>Erreur :</strong> <?= e($errors['general']) ?></div>
    </div>
    <?php endif; ?>

    <!-- BANNER BROUILLON (création uniquement) -->
    <?php if (!$isEdit): ?>
    <div id="draftBanner" style="
        display:none;background:#eff6ff;border:1px solid #bfdbfe;
        border-radius:14px;padding:var(--space-3) var(--space-6);
        margin-bottom:var(--space-6);color:#1d4ed8;font-size:0.875rem;
        align-items:center;gap:var(--space-3);justify-content:space-between;
        flex-wrap:wrap;
    ">
        <span>📋 <strong>Brouillon restauré</strong> — vos saisies précédentes ont été récupérées.</span>
        <button type="button" onclick="clearDraft()" style="
            background:none;border:none;color:#1d4ed8;cursor:pointer;
            font-size:0.8rem;text-decoration:underline;padding:0;
        ">Effacer le brouillon</button>
    </div>
    <?php endif; ?>

    <!-- FORMULAIRE -->
    <form
        method="POST"
        action="<?= $isEdit ? "/seller/products/{$product['id']}/update" : '/seller/products/store' ?>"
        enctype="multipart/form-data"
        id="productForm"
        novalidate
    >
        <input type="hidden" name="csrf_token" value="<?= e($csrf_token) ?>">

        <!-- ═══════════════════════════════════════════════
             SECTION 1 — INFORMATIONS PRINCIPALES
        ═══════════════════════════════════════════════ -->
        <div class="pf-section">
            <div class="pf-section-header">
                <div class="pf-icon">📝</div>
                <h2 class="pf-section-title">Informations principales</h2>
            </div>

            <!-- Titre -->
            <div class="pf-field">
                <label class="pf-label" for="title">
                    Titre du produit <span class="pf-required">*</span>
                    <span id="titleCounter" class="pf-counter">0/255</span>
                </label>
                <input
                    type="text" id="title" name="title"
                    class="pf-input <?= isset($errors['title']) ? 'pf-input--error' : '' ?>"
                    placeholder="Ex: Dashboard UI Kit Premium — 150+ Composants"
                    value="<?= $isEdit ? e($product['title']) : e($old['title'] ?? '') ?>"
                    required maxlength="255" data-draft="title"
                >
                <div class="pf-hint">Soyez descriptif et précis (min. 10 caractères)</div>
                <?php if (isset($errors['title'])): ?>
                    <div class="pf-error-msg">⚠ <?= e($errors['title']) ?></div>
                <?php else: ?>
                    <div class="pf-error-msg" id="titleError" style="display:none;"></div>
                <?php endif; ?>
            </div>

            <!-- Catégorie -->
            <div class="pf-field">
                <label class="pf-label" for="category_id">
                    Catégorie <span class="pf-required">*</span>
                </label>
                <select
                    id="category_id" name="category_id"
                    class="pf-input <?= isset($errors['category_id']) ? 'pf-input--error' : '' ?>"
                    required data-draft="category_id"
                >
                    <option value="">Sélectionnez une catégorie</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= e($cat['id']) ?>"
                        <?= ($isEdit && $product['category_id'] == $cat['id'])
                            || (!$isEdit && ($old['category_id'] ?? '') == $cat['id'])
                            ? 'selected' : '' ?>>
                        <?= e($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['category_id'])): ?>
                    <div class="pf-error-msg">⚠ <?= e($errors['category_id']) ?></div>
                <?php else: ?>
                    <div class="pf-error-msg" id="categoryError" style="display:none;"></div>
                <?php endif; ?>
            </div>

            <!-- Accroche courte -->
            <div class="pf-field">
                <label class="pf-label" for="short_description">
                    Accroche courte
                    <span id="shortDescCounter" class="pf-counter">0/160</span>
                </label>
                <input
                    type="text" id="short_description" name="short_description"
                    class="pf-input"
                    placeholder="Ex: Kit UI complet pour créer des dashboards professionnels en quelques minutes"
                    value="<?= $isEdit ? e($product['short_description'] ?? '') : e($old['short_description'] ?? '') ?>"
                    maxlength="160" data-draft="short_description"
                >
                <div class="pf-hint">Affiché dans les cartes produits et les résultats de recherche (max. 160 car.)</div>
            </div>

            <!-- Description longue -->
            <div class="pf-field">
                <label class="pf-label" for="description">
                    Description complète <span class="pf-required">*</span>
                    <span id="descCounter" class="pf-counter">0 car.</span>
                </label>
                <textarea
                    id="description" name="description"
                    class="pf-input <?= isset($errors['description']) ? 'pf-input--error' : '' ?>"
                    placeholder="Décrivez votre produit en détail : fonctionnalités, contenu, utilisation recommandée..."
                    rows="8" required data-draft="description"
                ><?= $isEdit ? e($product['description']) : e($old['description'] ?? '') ?></textarea>
                <div class="pf-hint">Min. 50 caractères — Soyez complet et précis</div>
                <?php if (isset($errors['description'])): ?>
                    <div class="pf-error-msg">⚠ <?= e($errors['description']) ?></div>
                <?php else: ?>
                    <div class="pf-error-msg" id="descError" style="display:none;"></div>
                <?php endif; ?>
            </div>

            <!-- Tags avec chips -->
            <div class="pf-field" style="margin-bottom:0;">
                <label class="pf-label">Tags (mots-clés)</label>
                <input type="hidden" id="tagsHidden" name="tags"
                    value="<?= $isEdit ? e($product['tags_string'] ?? '') : e($old['tags'] ?? '') ?>">
                <div id="tagsContainer" class="pf-tags-container"
                    onclick="document.getElementById('tagInput').focus()">
                    <input type="text" id="tagInput"
                        placeholder="Tapez un tag puis Entrée ou virgule…"
                        style="border:none;outline:none;background:transparent;
                            font-size:0.9rem;color:#1e1208;min-width:200px;flex:1;padding:4px 0;">
                </div>
                <div class="pf-hint">
                    <kbd class="pf-kbd">Entrée</kbd> ou <kbd class="pf-kbd">,</kbd> pour valider ·
                    <kbd class="pf-kbd">Backspace</kbd> pour supprimer le dernier
                </div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════
             SECTION 2 — PRIX ET LICENCE
        ═══════════════════════════════════════════════ -->
        <div class="pf-section">
            <div class="pf-section-header">
                <div class="pf-icon">💰</div>
                <h2 class="pf-section-title">Prix et Licence</h2>
            </div>

            <!-- Cartes licence -->
            <div class="pf-field">
                <label class="pf-label">Type de licence <span class="pf-required">*</span></label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-4);">

                    <label class="pf-license-card" id="licSingle">
                        <input type="radio" name="license_type" value="single" style="display:none;"
                            <?= (!$isEdit && ($old['license_type'] ?? 'single') === 'single')
                                || ($isEdit && ($product['license_type'] ?? 'single') === 'single')
                                ? 'checked' : '' ?>>
                        <div class="pf-license-icon" style="background:linear-gradient(135deg,#3b82f6,#6366f1);">👤</div>
                        <h3 class="pf-license-name">Licence Simple</h3>
                        <p class="pf-license-desc">Usage personnel ou 1 projet client</p>
                        <ul class="pf-license-list">
                            <li>✓ 1 utilisation</li>
                            <li>✓ Usage commercial</li>
                            <li>✗ Revente interdite</li>
                        </ul>
                    </label>

                    <label class="pf-license-card" id="licExtended">
                        <input type="radio" name="license_type" value="extended" style="display:none;"
                            <?= (($isEdit && ($product['license_type'] ?? '') === 'extended')
                                || (!$isEdit && ($old['license_type'] ?? '') === 'extended'))
                                ? 'checked' : '' ?>>
                        <div class="pf-license-icon" style="background:linear-gradient(135deg,#6B94D6,#6BC6D6);">👥</div>
                        <h3 class="pf-license-name">Licence Étendue</h3>
                        <p class="pf-license-desc">Usage illimité pour clients multiples</p>
                        <ul class="pf-license-list">
                            <li>✓ Projets illimités</li>
                            <li>✓ Usage commercial</li>
                            <li>✓ Fichiers sources inclus</li>
                        </ul>
                    </label>

                </div>
            </div>

            <!-- Prix -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--space-6);margin-bottom:var(--space-5);">
                <div class="pf-field" style="margin-bottom:0;">
                    <label class="pf-label" for="price">Prix <span class="pf-required">*</span></label>
                    <div style="position:relative;">
                        <input
                            type="number" id="price" name="price"
                            class="pf-input <?= isset($errors['price']) ? 'pf-input--error' : '' ?>"
                            placeholder="49.99" step="0.01" min="0.01" autocomplete="off"
                            value="<?= $isEdit ? $product['price'] : ($old['price'] ?? '') ?>"
                            required style="padding-right:46px;" data-draft="price"
                        >
                        <span class="pf-currency">€</span>
                    </div>
                    <?php if (isset($errors['price'])): ?>
                        <div class="pf-error-msg">⚠ <?= e($errors['price']) ?></div>
                    <?php else: ?>
                        <div class="pf-error-msg" id="priceError" style="display:none;"></div>
                    <?php endif; ?>
                </div>

                <div class="pf-field" style="margin-bottom:0;">
                    <label class="pf-label" for="original_price">Prix barré (optionnel)</label>
                    <div style="position:relative;">
                        <input
                            type="number" id="original_price" name="original_price"
                            class="pf-input"
                            placeholder="99.99" step="0.01" min="0" autocomplete="off"
                            value="<?= $isEdit ? ($product['original_price'] ?? '') : ($old['original_price'] ?? '') ?>"
                            style="padding-right:46px;" data-draft="original_price"
                        >
                        <span class="pf-currency">€</span>
                    </div>
                    <div class="pf-hint" id="discountInfo">Pour afficher une promotion</div>
                </div>
            </div>

            <!-- Aperçu prix (caché par défaut, JS le montre) -->
            <div id="pricePreview" style="display:none;
                background:linear-gradient(135deg,#eff6ff,#dbeafe);
                border:1px solid #bfdbfe;border-radius:12px;
                padding:var(--space-4) var(--space-5);
                align-items:center;gap:var(--space-4);flex-wrap:wrap;
            ">
                <span style="font-size:0.85rem;color:#64748b;">Aperçu fiche produit :</span>
                <span id="previewPrice" style="font-size:1.5rem;font-weight:800;color:#1e293b;"></span>
                <span id="previewOriginal" style="font-size:1rem;color:#94a3b8;text-decoration:line-through;"></span>
                <span id="previewBadge" style="display:none;
                    background:#ef4444;color:white;border-radius:6px;
                    padding:2px 10px;font-size:0.8rem;font-weight:700;"></span>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════
             SECTION 3 — FICHIERS
        ═══════════════════════════════════════════════ -->
        <div class="pf-section">
            <div class="pf-section-header">
                <div class="pf-icon">📦</div>
                <h2 class="pf-section-title">Fichiers du produit</h2>
            </div>

            <!-- Type de fichier -->
            <div class="pf-field">
                <label class="pf-label" for="file_type">Type de fichier</label>
                <select id="file_type" name="file_type" class="pf-input">
                    <option value="">Sélectionnez…</option>
                    <?php
                    $ftypes = [
                        'zip'=>'ZIP','pdf'=>'PDF','psd'=>'PSD','ai'=>'Adobe Illustrator (AI)',
                        'sketch'=>'Sketch','figma'=>'Figma','xd'=>'Adobe XD',
                        'jpg'=>'JPEG/JPG','png'=>'PNG','svg'=>'SVG','mp4'=>'Vidéo MP4'
                    ];
                    foreach ($ftypes as $val => $label):
                        $sel = ($isEdit && $product['file_type'] == $val)
                            || ($old['file_type'] ?? '') == $val ? 'selected' : '';
                    ?>
                    <option value="<?= $val ?>" <?= $sel ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Image principale -->
            <div class="pf-field">
                <label class="pf-label" for="thumbnail">
                    Image principale <?= !$isEdit ? '<span class="pf-required">*</span>' : '' ?>
                </label>

                <?php if ($isEdit && !empty($product['thumbnail_url'])): ?>
                <div id="currentThumbnail" style="margin-bottom:var(--space-4);">
                    <img
                        src="<?= e(str_replace('/public/', '/', $product['thumbnail_url'])) ?>"
                        alt="Image actuelle"
                        style="max-width:320px;border-radius:12px;box-shadow:0 4px 16px rgba(0,0,0,0.1);"
                    >
                    <p style="font-size:0.8rem;color:#64748b;margin-top:var(--space-2);">
                        Image actuelle — laissez vide pour conserver
                    </p>
                </div>
                <?php endif; ?>

                <div class="pf-dropzone" id="thumbDropZone"
                    ondragover="handleDragOver(event,this)"
                    ondragleave="handleDragLeave(event,this)"
                    ondrop="handleDrop(event,this,'thumbnail','thumbnailPreview',true)"
                    onclick="document.getElementById('thumbnail').click()">
                    <div class="pf-drop-icon">🖼️</div>
                    <p class="pf-drop-title">Glissez une image ici ou cliquez</p>
                    <p class="pf-drop-hint">JPG, PNG, WEBP — Max 5 MB — 1200×800 px recommandé</p>
                    <div class="pf-progress" id="thumbProgress" style="display:none;">
                        <div class="pf-progress-bar" id="thumbProgressBar"></div>
                    </div>
                </div>
                <input type="file" id="thumbnail" name="thumbnail"
                    accept="image/jpeg,image/png,image/webp,image/gif"
                    <?= !$isEdit ? 'required' : '' ?>
                    onchange="handleFileChange(this,'thumbnailPreview',true)"
                    style="display:none;">
                <div id="thumbnailPreview" style="margin-top:var(--space-4);"></div>
                <?php if (isset($errors['thumbnail'])): ?>
                    <div class="pf-error-msg">⚠ <?= e($errors['thumbnail']) ?></div>
                <?php endif; ?>
            </div>

            <!-- Fichier produit -->
            <div class="pf-field">
                <label class="pf-label" for="product_file">
                    Fichier produit <?= !$isEdit ? '<span class="pf-required">*</span>' : '' ?>
                </label>

                <?php if ($isEdit && !empty($product['file_url'])): ?>
                <div id="currentFile" style="
                    padding:var(--space-4);
                    background:linear-gradient(135deg,#d1fae5,#a7f3d0);
                    border-radius:12px;margin-bottom:var(--space-4);
                    color:#065f46;display:flex;align-items:center;gap:var(--space-3);
                ">
                    <div style="width:40px;height:40px;background:white;border-radius:50%;
                        display:flex;align-items:center;justify-content:center;font-size:1.2rem;">✓</div>
                    <div>
                        <strong>Fichier actuel en place</strong><br>
                        <small>
                            Taille : <?php
                                $sizeBytes = (int)$product['file_size'];
                                if ($sizeBytes >= 1048576) {
                                    echo number_format($sizeBytes / 1048576, 2) . ' MB';
                                } elseif ($sizeBytes >= 1024) {
                                    echo number_format($sizeBytes / 1024, 1) . ' KB';
                                } else {
                                    echo $sizeBytes . ' octets';
                                }
                            ?>
                            — Uploadez un nouveau fichier pour le remplacer
                        </small>
                    </div>
                </div>
                <?php endif; ?>

                <div class="pf-dropzone" id="fileDropZone"
                    ondragover="handleDragOver(event,this)"
                    ondragleave="handleDragLeave(event,this)"
                    ondrop="handleDrop(event,this,'product_file','filePreview',false)"
                    onclick="document.getElementById('product_file').click()">
                    <div class="pf-drop-icon">📦</div>
                    <p class="pf-drop-title">Glissez votre fichier ici ou cliquez</p>
                    <p class="pf-drop-hint">ZIP, PDF, PSD, AI, Sketch, Figma, XD — Max 50 MB</p>
                    <div class="pf-progress" id="fileProgress" style="display:none;">
                        <div class="pf-progress-bar" id="fileProgressBar"></div>
                    </div>
                </div>
                <input type="file" id="product_file" name="product_file"
                    accept=".zip,.pdf,.psd,.ai,.sketch,.fig,.xd"
                    <?= !$isEdit ? 'required' : '' ?>
                    onchange="handleFileChange(this,'filePreview',false)"
                    style="display:none;">
                <div id="filePreview" style="margin-top:var(--space-4);"></div>
                <?php if (isset($errors['product_file'])): ?>
                    <div class="pf-error-msg">⚠ <?= e($errors['product_file']) ?></div>
                <?php endif; ?>
            </div>

            <!-- URL démo -->
            <div class="pf-field" style="margin-bottom:0;">
                <label class="pf-label" for="demo_url">URL de démonstration (optionnel)</label>
                <input
                    type="url" id="demo_url" name="demo_url" class="pf-input"
                    placeholder="https://demo.example.com"
                    value="<?= $isEdit ? e($product['demo_url'] ?? '') : e($old['demo_url'] ?? '') ?>"
                    data-draft="demo_url"
                >
                <div class="pf-hint">Lien vers une démo en ligne de votre produit</div>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════
             BARRE STICKY
        ═══════════════════════════════════════════════ -->
        <div id="stickyBar" style="
            position:sticky;bottom:20px;z-index:100;
            background:white;border-radius:16px;
            padding:var(--space-4) var(--space-6);
            box-shadow:0 8px 32px rgba(0,0,0,0.15);
            border:1px solid rgba(99,102,241,0.15);
            display:flex;align-items:center;
            justify-content:flex-end;gap:var(--space-4);flex-wrap:wrap;
        ">
            <div id="unsavedIndicator" style="
                display:none;align-items:center;gap:8px;
                font-size:0.85rem;color:#92400e;margin-right:auto;
            ">
                <span style="width:8px;height:8px;background:#f59e0b;
                    border-radius:50%;display:inline-block;animation:pfPulse 1.5s infinite;"></span>
                Modifications non sauvegardées
            </div>
            <div id="savedIndicator" style="
                display:none;align-items:center;gap:8px;
                font-size:0.85rem;color:#065f46;margin-right:auto;
            ">✓ Brouillon sauvegardé</div>

            <a href="/seller/products" id="cancelBtn" style="
                padding:var(--space-3) var(--space-6);border-radius:10px;
                font-weight:600;background:white;color:#64748b;
                border:2px solid #e2e8f0;text-decoration:none;font-size:0.9rem;
            ">Annuler</a>

            <button type="submit" id="submitBtn" style="
                padding:var(--space-3) var(--space-8);
                background:linear-gradient(135deg,#3b82f6 0%,#6366f1 50%,#6B94D6 100%);
                color:white;border:none;border-radius:10px;
                font-size:0.95rem;font-weight:700;cursor:pointer;
                box-shadow:0 4px 15px rgba(99,102,241,0.4);
                transition:opacity 0.2s;min-width:200px;
            ">
                <?= $isEdit ? '💾 Mettre à jour' : '✨ Créer le produit' ?>
            </button>
        </div>

    </form>
</div>
</div>

<!-- ═══════════════════════════════════════════════════════
     CSS
═══════════════════════════════════════════════════════ -->
<style>
/* Sections */
.pf-section {
    background:white;border-radius:20px;
    padding:var(--space-8);margin-bottom:var(--space-6);
    box-shadow:0 4px 20px rgba(0,0,0,0.06);
    border:1px solid rgba(99,102,241,0.1);
}
.pf-section-header {
    display:flex;align-items:center;gap:var(--space-3);
    margin-bottom:var(--space-6);padding-bottom:var(--space-4);
    border-bottom:2px solid #f1f5f9;
}
.pf-icon {
    width:48px;height:48px;flex-shrink:0;
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    border-radius:12px;display:flex;align-items:center;
    justify-content:center;font-size:1.4rem;
}
.pf-section-title { font-size:1.4rem;margin:0;color:#1e293b;font-weight:700; }

/* Champs */
.pf-field { margin-bottom:var(--space-6); }
.pf-label {
    display:flex;align-items:center;gap:4px;
    font-weight:600;margin-bottom:var(--space-2);
    color:#1e293b;font-size:0.9rem;
}
.pf-required { color:#ef4444; }
.pf-counter { margin-left:auto;font-weight:400;color:#94a3b8;font-size:0.8rem; }
.pf-hint { font-size:0.75rem;color:#64748b;margin-top:6px; }
.pf-kbd {
    background:#f1f5f9;border:1px solid #e2e8f0;
    padding:1px 6px;border-radius:4px;font-size:0.75rem;
}

/* Inputs */
.pf-input {
    width:100%;box-sizing:border-box;
    padding:14px 16px;
    border:2px solid #e2e8f0;border-radius:12px;
    font-size:0.95rem;font-family:inherit;
    transition:border-color .2s,box-shadow .2s;
    background:#faf9f5;color:#1e1208;
}
.pf-input:focus {
    outline:none;border-color:#6366f1;
    box-shadow:0 0 0 4px rgba(99,102,241,0.1);
    background:white;
}
.pf-input--error { border-color:#ef4444 !important; }
.pf-input--success { border-color:#10b981 !important; }
textarea.pf-input { resize:vertical; }

/* Erreurs inline */
.pf-error-msg {
    color:#991b1b;background:#fee2e2;border-radius:8px;
    padding:6px 12px;font-size:0.8rem;margin-top:6px;font-weight:500;
}

/* Devise */
.pf-currency {
    position:absolute;right:14px;top:50%;transform:translateY(-50%);
    color:#64748b;font-weight:700;font-size:1.1rem;pointer-events:none;
}

/* Cartes licence */
.pf-license-card {
    cursor:pointer;border:2px solid #e2e8f0;
    border-radius:14px;padding:var(--space-5);
    transition:all .2s;display:block;background:#faf9f5;
}
.pf-license-card:hover { border-color:#a5b4fc;background:#f5f3ff; }
.pf-license-card.pf-selected { border-color:#6366f1;background:#f5f3ff; }
.pf-license-icon {
    width:40px;height:40px;border-radius:10px;
    display:flex;align-items:center;justify-content:center;
    font-size:1.2rem;margin-bottom:var(--space-3);
}
.pf-license-name { font-size:1rem;margin:0 0 6px;color:#1e293b;font-weight:700; }
.pf-license-desc { font-size:0.85rem;color:#64748b;margin:0;line-height:1.5; }
.pf-license-list {
    font-size:0.78rem;color:#64748b;
    margin:var(--space-3) 0 0;padding-left:var(--space-4);line-height:1.8;
}

/* Tags */
.pf-tags-container {
    min-height:52px;padding:8px 12px;
    border:2px solid #e2e8f0;border-radius:12px;
    background:#faf9f5;display:flex;flex-wrap:wrap;
    gap:8px;align-items:center;cursor:text;
    transition:border-color .2s,box-shadow .2s;
}
.pf-tags-container:focus-within {
    border-color:#6366f1;
    box-shadow:0 0 0 4px rgba(99,102,241,0.1);
    background:white;
}
.pf-chip {
    display:inline-flex;align-items:center;gap:6px;
    background:linear-gradient(135deg,#eff6ff,#dbeafe);
    color:#1d4ed8;border:1px solid #bfdbfe;
    border-radius:20px;padding:4px 10px 4px 12px;
    font-size:0.82rem;font-weight:600;white-space:nowrap;
}
.pf-chip-remove {
    cursor:pointer;font-size:1rem;color:#94a3b8;
    background:none;border:none;padding:0;line-height:1;
}
.pf-chip-remove:hover { color:#ef4444; }

/* Zones drag & drop */
.pf-dropzone {
    border:2px dashed #cbd5e1;border-radius:14px;
    padding:var(--space-8);text-align:center;
    background:linear-gradient(135deg,#f8fafc,#eff6ff);
    transition:all .2s;cursor:pointer;
}
.pf-dropzone:hover, .pf-dropzone.pf-drag-over {
    border-color:#6366f1;
    background:linear-gradient(135deg,#eff6ff,#dbeafe);
}
.pf-dropzone.pf-drop-success {
    border-color:#10b981;
    background:linear-gradient(135deg,#f0fdf4,#dcfce7);
    border-style:solid;
}
.pf-drop-icon { font-size:2.5rem;margin-bottom:var(--space-3); }
.pf-drop-title { font-weight:600;color:#1e293b;margin:0 0 6px; }
.pf-drop-hint { font-size:0.85rem;color:#64748b;margin:0; }

/* Progress bar */
.pf-progress {
    height:6px;background:#e2e8f0;border-radius:99px;
    margin-top:var(--space-4);overflow:hidden;
}
.pf-progress-bar {
    height:100%;width:0%;
    background:linear-gradient(90deg,#3b82f6,#6366f1);
    border-radius:99px;transition:width .3s ease;
}

/* Submit loading */
#submitBtn.pf-loading { opacity:.65;cursor:not-allowed; }

/* Animations */
@keyframes pfPulse {
    0%,100% { opacity:1; }
    50%      { opacity:.3; }
}

/* Override thème maquette2 */
div[style*="min-height: 100vh"][style*="linear-gradient"] { background:#faf9f5 !important; }
div[style*="background: linear-gradient(135deg, #3b82f6"] { background:#e0f7fa !important; box-shadow:none !important; }
h1[style*="color: white"] { color:#5B8ED6 !important; font-family:Georgia,serif !important; font-size:26px !important; font-weight:400 !important; }
p[style*="color: rgba(255, 255, 255, 0.9)"] { color:#6b5c4e !important; }
div[style*="filter: blur"] { display:none !important; }
</style>

<!-- ═══════════════════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════════════════ -->
<script>
const IS_EDIT   = <?= $isEdit ? 'true' : 'false' ?>;
const DRAFT_KEY = 'pf_draft_v1';
let hasUnsaved  = false;
let draftTimer  = null;

// ─── INIT ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    initLicenseCards();
    initTagChips();
    initCounters();
    initPricePreview();
    initUnsaved();
    if (!IS_EDIT) loadDraft();
});

// ─── CARTES LICENCE ──────────────────────────────────────
function initLicenseCards() {
    document.querySelectorAll('.pf-license-card').forEach(card => {
        if (card.querySelector('input[type="radio"]').checked)
            card.classList.add('pf-selected');
        card.addEventListener('click', function() {
            document.querySelectorAll('.pf-license-card').forEach(c => c.classList.remove('pf-selected'));
            this.classList.add('pf-selected');
            this.querySelector('input[type="radio"]').checked = true;
            markUnsaved();
        });
    });
}

// ─── TAG CHIPS ───────────────────────────────────────────
function initTagChips() {
    const hidden    = document.getElementById('tagsHidden');
    const tagInput  = document.getElementById('tagInput');

    // Charger tags existants
    hidden.value.split(',').map(t => t.trim()).filter(Boolean).forEach(addChip);

    tagInput.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const v = tagInput.value.trim().replace(/,$/, '');
            if (v) { addChip(v); tagInput.value = ''; syncTags(); markUnsaved(); }
        }
        if (e.key === 'Backspace' && !tagInput.value) {
            const chips = document.querySelectorAll('#tagsContainer .pf-chip');
            if (chips.length) { chips[chips.length - 1].remove(); syncTags(); markUnsaved(); }
        }
    });
    tagInput.addEventListener('paste', e => {
        e.preventDefault();
        const txt = (e.clipboardData || window.clipboardData).getData('text');
        txt.split(/[,\n]+/).map(t => t.trim()).filter(Boolean).forEach(addChip);
        syncTags(); markUnsaved();
    });
}

function addChip(text) {
    const container = document.getElementById('tagsContainer');
    const tagInput  = document.getElementById('tagInput');
    const key       = text.toLowerCase();
    if ([...container.querySelectorAll('.pf-chip')].some(c => c.dataset.tag === key)) return;
    const chip = document.createElement('span');
    chip.className  = 'pf-chip';
    chip.dataset.tag = key;
    chip.innerHTML  = `${xss(text)}<button type="button" class="pf-chip-remove"
        onclick="this.closest('.pf-chip').remove();syncTags();markUnsaved();">×</button>`;
    container.insertBefore(chip, tagInput);
}
function syncTags() {
    document.getElementById('tagsHidden').value =
        [...document.querySelectorAll('#tagsContainer .pf-chip')]
            .map(c => c.dataset.tag).join(', ');
}

// ─── COMPTEURS ───────────────────────────────────────────
function initCounters() {
    // Titre
    bindCounter('title', 'titleCounter', 255,
        len => len < 10 ? '#ef4444' : len > 240 ? '#f59e0b' : '#94a3b8',
        len => `${len}/255`);
    // Accroche
    bindCounter('short_description', 'shortDescCounter', 160,
        len => len > 140 ? '#f59e0b' : '#94a3b8',
        len => `${len}/160`);
    // Description
    bindCounter('description', 'descCounter', null,
        len => len < 50 ? '#ef4444' : '#10b981',
        len => `${len} car.`);
}
function bindCounter(fieldId, counterId, max, colorFn, labelFn) {
    const el = document.getElementById(fieldId);
    const ct = document.getElementById(counterId);
    if (!el || !ct) return;
    const update = () => {
        const len = el.value.length;
        ct.textContent = labelFn(len);
        ct.style.color = colorFn(len);
    };
    el.addEventListener('input', update);
    update();
}

// ─── APERÇU PRIX ─────────────────────────────────────────
function initPricePreview() {
    const priceEl   = document.getElementById('price');
    const origEl    = document.getElementById('original_price');
    const infoEl    = document.getElementById('discountInfo');
    const previewEl = document.getElementById('pricePreview');
    const ppEl      = document.getElementById('previewPrice');
    const poEl      = document.getElementById('previewOriginal');
    const pbEl      = document.getElementById('previewBadge');

    function update() {
        const price = parseFloat(priceEl.value);
        const orig  = parseFloat(origEl.value);

        if (price > 0) {
            previewEl.style.display = 'flex';
            ppEl.textContent = fmtEuro(price);
        } else {
            previewEl.style.display = 'none';
        }

        if (price > 0 && orig > price) {
            const pct = Math.round((1 - price / orig) * 100);
            infoEl.innerHTML = `Pour afficher une promotion <strong style="color:#ef4444">(-${pct}%)</strong>`;
            poEl.textContent    = fmtEuro(orig);
            pbEl.textContent    = `-${pct}%`;
            pbEl.style.display  = '';
        } else {
            infoEl.textContent  = 'Pour afficher une promotion';
            poEl.textContent    = '';
            pbEl.style.display  = 'none';
        }
    }
    priceEl.addEventListener('input', update);
    origEl.addEventListener('input', update);
    update(); // état initial
}
function fmtEuro(v) {
    return new Intl.NumberFormat('fr-FR',{style:'currency',currency:'EUR'}).format(v);
}

// ─── DRAG & DROP ─────────────────────────────────────────
function handleDragOver(e, zone) {
    e.preventDefault(); zone.classList.add('pf-drag-over');
}
function handleDragLeave(e, zone) {
    if (!zone.contains(e.relatedTarget)) zone.classList.remove('pf-drag-over');
}
function handleDrop(e, zone, inputId, previewId, isImg) {
    e.preventDefault(); zone.classList.remove('pf-drag-over');
    const file = e.dataTransfer.files[0];
    if (!file) return;
    const dt = new DataTransfer();
    dt.items.add(file);
    const input = document.getElementById(inputId);
    input.files = dt.files;
    handleFileChange(input, previewId, isImg);
}

// ─── PREVIEW FICHIER ─────────────────────────────────────
function handleFileChange(input, previewId, isImg) {
    if (!input.files || !input.files[0]) return;
    const file    = input.files[0];
    const dropId  = isImg ? 'thumbDropZone'    : 'fileDropZone';
    const progId  = isImg ? 'thumbProgress'    : 'fileProgress';
    const barId   = isImg ? 'thumbProgressBar' : 'fileProgressBar';
    const currId  = isImg ? 'currentThumbnail' : 'currentFile';

    const curr = document.getElementById(currId);
    if (curr) curr.style.display = 'none';

    const zone    = document.getElementById(dropId);
    const progEl  = document.getElementById(progId);
    const barEl   = document.getElementById(barId);

    // Progress animée
    progEl.style.display = 'block';
    barEl.style.width    = '0%';
    let pct = 0;
    const iv = setInterval(() => {
        pct += Math.random() * 18;
        if (pct >= 90) { pct = 90; clearInterval(iv); }
        barEl.style.width = pct + '%';
    }, 80);

    const finish = (html) => {
        clearInterval(iv);
        barEl.style.width = '100%';
        setTimeout(() => { progEl.style.display = 'none'; }, 500);
        zone.classList.add('pf-drop-success');
        document.getElementById(previewId).innerHTML = html;
    };

    if (isImg) {
        const reader = new FileReader();
        reader.onload = e => finish(`
            <div style="padding:var(--space-4);background:white;
                border-radius:14px;box-shadow:0 4px 16px rgba(0,0,0,0.08);">
                <img src="${e.target.result}"
                    style="max-width:100%;border-radius:10px;" alt="Aperçu">
                <p style="text-align:center;margin-top:var(--space-3);
                    color:#10b981;font-weight:600;font-size:0.9rem;">
                    ✓ ${xss(file.name)} (${(file.size/1048576).toFixed(2)} MB)
                </p>
            </div>`);
        reader.readAsDataURL(file);
    } else {
        const icons = {ZIP:'🗜️',PDF:'📄',PSD:'🎨',AI:'🎨',SKETCH:'💎',FIG:'🎨',XD:'📐'};
        const ext   = file.name.split('.').pop().toUpperCase();
        setTimeout(() => finish(`
            <div style="display:flex;align-items:center;gap:var(--space-4);
                padding:var(--space-4);background:white;border-radius:12px;
                box-shadow:0 2px 10px rgba(0,0,0,0.08);">
                <span style="font-size:2rem;">${icons[ext] || '📦'}</span>
                <div>
                    <strong style="color:#1e293b;">${xss(file.name)}</strong><br>
                    <span style="font-size:0.8rem;color:#64748b;">
                        ${ext} — ${(file.size/1048576).toFixed(2)} MB
                    </span>
                </div>
                <span style="margin-left:auto;color:#10b981;font-weight:700;">✓</span>
            </div>`), 600 + Math.random() * 400);
    }
    markUnsaved();
}

// ─── UNSAVED CHANGES ─────────────────────────────────────
function initUnsaved() {
    document.querySelectorAll('#productForm input, #productForm select, #productForm textarea')
        .forEach(el => { el.addEventListener('input', markUnsaved); el.addEventListener('change', markUnsaved); });

    window.addEventListener('beforeunload', e => {
        if (hasUnsaved) { e.preventDefault(); e.returnValue = ''; }
    });
    document.getElementById('productForm').addEventListener('submit', () => { hasUnsaved = false; });
    document.getElementById('cancelBtn').addEventListener('click', e => {
        if (hasUnsaved && !confirm('Modifications non sauvegardées. Quitter quand même ?'))
            e.preventDefault();
    });
}

function markUnsaved() {
    hasUnsaved = true;
    showEl('unsavedIndicator', 'flex');
    hideEl('savedIndicator');
    if (!IS_EDIT) { clearTimeout(draftTimer); draftTimer = setTimeout(saveDraft, 1500); }
}

// ─── AUTO-SAVE BROUILLON ─────────────────────────────────
function saveDraft() {
    const draft = {};
    document.querySelectorAll('[data-draft]').forEach(el => { draft[el.dataset.draft] = el.value; });
    draft.tags = document.getElementById('tagsHidden').value;
    localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
    hideEl('unsavedIndicator');
    showEl('savedIndicator', 'flex');
    hasUnsaved = false;
    setTimeout(() => hideEl('savedIndicator'), 2500);
}

function loadDraft() {
    try {
        const raw = localStorage.getItem(DRAFT_KEY);
        if (!raw) return;
        const draft   = JSON.parse(raw);
        let restored  = false;
        Object.entries(draft).forEach(([k, v]) => {
            if (k === 'tags') return;
            const el = document.querySelector(`[data-draft="${k}"]`);
            if (el && !el.value && v) { el.value = v; restored = true; }
        });
        if (draft.tags) {
            document.querySelectorAll('#tagsContainer .pf-chip').forEach(c => c.remove());
            draft.tags.split(',').map(t => t.trim()).filter(Boolean).forEach(addChip);
            syncTags();
        }
        if (restored) showEl('draftBanner', 'flex');
    } catch(e) {}
}
function clearDraft() {
    localStorage.removeItem(DRAFT_KEY);
    hideEl('draftBanner');
}

// ─── VALIDATION INLINE ───────────────────────────────────
document.getElementById('productForm').addEventListener('submit', function(e) {
    let valid = true;

    valid = validateField(
        'title', 'titleError',
        v => v.trim().length >= 10,
        'Le titre doit contenir au moins 10 caractères.'
    ) && valid;

    valid = validateField(
        'category_id', 'categoryError',
        v => v !== '',
        'Veuillez sélectionner une catégorie.'
    ) && valid;

    valid = validateField(
        'description', 'descError',
        v => v.trim().length >= 50,
        v => `Description trop courte (${v.trim().length}/50 car. minimum).`
    ) && valid;

    valid = validateField(
        'price', 'priceError',
        v => parseFloat(v) > 0,
        'Le prix doit être supérieur à 0 €.'
    ) && valid;

    if (!valid) {
        e.preventDefault();
        const first = document.querySelector('.pf-input--error');
        if (first) first.scrollIntoView({behavior:'smooth', block:'center'});
        return;
    }

    const btn = document.getElementById('submitBtn');
    btn.classList.add('pf-loading');
    btn.textContent = '⏳ Envoi en cours…';
    hasUnsaved = false;
});

function validateField(fieldId, errId, testFn, msgFn) {
    const el  = document.getElementById(fieldId);
    const err = document.getElementById(errId);
    if (!el || !err) return true;
    const msg = typeof msgFn === 'function' ? msgFn(el.value) : msgFn;
    if (!testFn(el.value)) {
        el.classList.add('pf-input--error');
        el.classList.remove('pf-input--success');
        err.textContent = '⚠ ' + msg;
        err.style.display = 'block';
        return false;
    }
    el.classList.remove('pf-input--error');
    el.classList.add('pf-input--success');
    err.style.display = 'none';
    return true;
}

// ─── UTILITAIRES ─────────────────────────────────────────
function xss(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function showEl(id, d) { const el = document.getElementById(id); if (el) el.style.display = d||'block'; }
function hideEl(id)    { const el = document.getElementById(id); if (el) el.style.display = 'none'; }
</script>
