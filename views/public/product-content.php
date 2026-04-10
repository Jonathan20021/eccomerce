<!-- Product Detail Content -->
<style>
/* ══════════════════════════════════════
   PRODUCT DETAIL — PREMIUM
══════════════════════════════════════ */
.pd-wrap {
    max-width: 1280px; margin: 0 auto;
    padding: 32px 24px 80px;
}

/* Breadcrumb */
.pd-breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; color: #94a3b8; margin-bottom: 32px;
    flex-wrap: wrap;
}
.pd-breadcrumb a {
    color: #64748b; text-decoration: none; font-weight: 500;
    transition: color .15s;
}
.pd-breadcrumb a:hover { color: #2a7a52; }
.pd-breadcrumb i { font-size: 9px; opacity: .6; }

/* Main grid */
.pd-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 52px;
    align-items: start;
}

/* Image panel */
.pd-img-panel {}
.pd-img-main-wrap {
    border-radius: 22px; overflow: hidden;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border: 1.5px solid #e8f0ec;
    position: relative;
    cursor: zoom-in;
    box-shadow: 0 8px 32px rgba(15,23,42,.08);
}
.pd-img-main {
    width: 100%; aspect-ratio: 4 / 5;
    object-fit: cover; display: block;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
}
.pd-img-main-wrap:hover .pd-img-main { transform: scale(1.04); }
.pd-img-placeholder {
    width: 100%; aspect-ratio: 4 / 5;
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px;
    color: #cbd5e1;
}
.pd-img-placeholder i { font-size: 64px; opacity: .5; }

/* Sale ribbon */
.pd-ribbon {
    position: absolute; top: 18px; left: 18px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff; font-size: 11px; font-weight: 800;
    padding: 5px 12px; border-radius: 8px;
    letter-spacing: .4px;
    box-shadow: 0 4px 12px rgba(239,68,68,.4);
}

/* Info panel */
.pd-info-panel {}

/* Category + store name */
.pd-meta-top {
    display: flex; align-items: center; gap: 8px; margin-bottom: 12px;
}
.pd-category-tag {
    display: inline-flex; align-items: center; gap: 4px;
    background: #ecfdf5; color: #2a7a52;
    border: 1px solid #bbf7d0;
    font-size: 11px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase;
    padding: 4px 10px; border-radius: 9999px;
}

/* Product name */
.pd-name {
    font-size: clamp(24px, 3vw, 34px);
    font-weight: 900; color: #0f172a;
    letter-spacing: -.7px; line-height: 1.18;
    margin-bottom: 14px;
}

/* Price block */
.pd-price-block {
    display: flex; align-items: center; gap: 14px;
    margin-bottom: 18px; flex-wrap: wrap;
}
.pd-price {
    font-size: 34px; font-weight: 900; color: #0f172a;
    letter-spacing: -1px; line-height: 1;
}
.pd-price-sale { color: #ef4444; }
.pd-price-original {
    font-size: 18px; color: #94a3b8; text-decoration: line-through;
    font-weight: 600;
}
.pd-discount-badge {
    background: #fef2f2; color: #ef4444;
    border: 1px solid #fecaca;
    font-size: 12px; font-weight: 800;
    padding: 4px 10px; border-radius: 8px;
}

/* Stock indicator */
.pd-stock {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 6px 14px; border-radius: 9999px;
    font-size: 12.5px; font-weight: 700;
    margin-bottom: 22px;
}
.pd-stock-in {
    background: #f0fdf4; color: #166534;
    border: 1px solid #bbf7d0;
}
.pd-stock-in .stock-dot {
    width: 7px; height: 7px; background: #22c55e; border-radius: 50%;
    animation: pd-stock-pulse 2s ease infinite;
}
.pd-stock-out { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
@keyframes pd-stock-pulse {
    0%,100% { opacity: 1; box-shadow: 0 0 0 0 rgba(34,197,94,.5); }
    50%      { opacity: .7; box-shadow: 0 0 0 4px rgba(34,197,94,0); }
}

/* Divider */
.pd-divider {
    height: 1px; background: #f1f5f9; margin: 22px 0;
}

/* Description */
.pd-description {
    font-size: 14.5px; color: #475569; line-height: 1.8;
    margin-bottom: 26px; white-space: pre-wrap;
}

/* Quantity + Add to cart */
.pd-actions {
    display: flex; gap: 12px; align-items: stretch; margin-bottom: 16px;
}
.pd-qty-wrap {
    display: flex; align-items: center;
    border: 1.5px solid #e2e8f0; border-radius: 12px; overflow: hidden;
    background: #f8fafc;
}
.pd-qty-btn {
    width: 44px; height: 52px; background: none; border: none;
    font-size: 18px; color: #475569; cursor: pointer; font-family: 'Inter', sans-serif;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s, color .15s;
}
.pd-qty-btn:hover { background: #ecfdf5; color: #2a7a52; }
.pd-qty-input {
    width: 52px; height: 52px; border: none; background: none;
    text-align: center; font-size: 16px; font-weight: 800;
    color: #1e293b; font-family: 'Inter', sans-serif; outline: none;
}
.pd-qty-input::-webkit-inner-spin-button,
.pd-qty-input::-webkit-outer-spin-button { -webkit-appearance: none; }

.pd-add-btn {
    flex: 1; padding: 0 24px; border: none; border-radius: 13px;
    background: linear-gradient(135deg, #2a7a52, #1f5c3d);
    color: #fff; font-size: 15px; font-weight: 800;
    font-family: 'Inter', sans-serif; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 9px;
    box-shadow: 0 8px 24px rgba(42,122,82,.36);
    transition: transform .22s, box-shadow .22s, background .18s;
    position: relative; overflow: hidden; min-height: 52px;
}
.pd-add-btn::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.12), transparent);
    opacity: 0; transition: opacity .2s;
}
.pd-add-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 14px 36px rgba(42,122,82,.48);
}
.pd-add-btn:hover:not(:disabled)::after { opacity: 1; }
.pd-add-btn:disabled {
    background: #e2e8f0; color: #94a3b8;
    box-shadow: none; cursor: not-allowed;
}

.pd-wa-btn {
    padding: 0 20px; height: 52px; border: none; border-radius: 13px;
    background: #25D366; color: #fff;
    font-size: 22px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 6px 18px rgba(37,211,102,.35);
    transition: transform .2s, box-shadow .2s;
    text-decoration: none;
}
.pd-wa-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(37,211,102,.5); }

/* Trust features */
.pd-trust-grid {
    display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;
    margin-top: 22px;
}
.pd-trust-item {
    display: flex; align-items: center; gap: 10px;
    background: #f8fafc; border: 1px solid #f1f5f9;
    padding: 11px 14px; border-radius: 12px;
}
.pd-trust-icon {
    width: 32px; height: 32px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; flex-shrink: 0;
}
.pd-trust-icon.green { background: linear-gradient(135deg, #2a7a52, #1f5c3d); color: #fff; }
.pd-trust-icon.amber { background: linear-gradient(135deg, #d4973a, #b07d2e); color: #fff; }
.pd-trust-icon.blue  { background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; }
.pd-trust-icon.slate { background: linear-gradient(135deg, #475569, #334155); color: #fff; }
.pd-trust-text { font-size: 12px; font-weight: 700; color: #1e293b; line-height: 1.3; }
.pd-trust-sub { font-size: 11px; color: #94a3b8; font-weight: 500; }

/* Share row */
.pd-share {
    display: flex; align-items: center; gap: 10px;
    margin-top: 20px; padding-top: 20px;
    border-top: 1px solid #f1f5f9;
    font-size: 12.5px; color: #94a3b8; font-weight: 600;
}
.pd-share-btn {
    width: 34px; height: 34px; border-radius: 8px;
    background: #f1f5f9; color: #475569;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer;
    border: none; transition: background .15s, color .15s;
}
.pd-share-btn:hover { background: #2a7a52; color: #fff; }

/* Responsive */
@media (max-width: 768px) {
    .pd-grid { grid-template-columns: 1fr; gap: 28px; }
    .pd-wrap { padding: 24px 16px 60px; }
    .pd-name { font-size: 26px; }
    .pd-price { font-size: 28px; }
    .pd-trust-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .pd-actions { flex-wrap: wrap; }
    .pd-add-btn { min-width: 100%; }
    .pd-trust-grid { grid-template-columns: 1fr; }
}

.pd-alert {
    border-radius: 12px;
    padding: 12px 14px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
}

.pd-alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
}

.pd-alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
}

.pd-reviews {
    margin-top: 34px;
    padding-top: 28px;
    border-top: 1px solid #e2e8f0;
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

.pd-reviews-title {
    font-size: 23px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 2px;
}

.pd-review-form {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 16px;
    display: grid;
    gap: 10px;
}

.pd-review-input,
.pd-review-textarea,
.pd-review-select {
    width: 100%;
    border: 1.5px solid #dbe2ea;
    border-radius: 10px;
    background: #fff;
    padding: 11px 12px;
    font-size: 13.5px;
    color: #1e293b;
    outline: none;
}

.pd-review-textarea {
    resize: vertical;
    min-height: 100px;
}

.pd-review-item {
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    background: #fff;
    padding: 14px;
}

.pd-review-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

.pd-review-reply {
    margin-top: 10px;
    background: #ecfdf5;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 10px 11px;
}
</style>

<div class="pd-wrap">
    <?php if (isset($_GET['success'])): ?>
    <div class="pd-alert pd-alert-success">
        <i class="fas fa-check-circle"></i>
        <span><?= htmlspecialchars($_GET['success']) ?></span>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div class="pd-alert pd-alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span><?= htmlspecialchars($_GET['error']) ?></span>
    </div>
    <?php endif; ?>

    <!-- Breadcrumb -->
    <nav class="pd-breadcrumb" aria-label="Breadcrumb">
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>">
            <i class="fas fa-home" style="font-size:11px;"></i> Tienda
        </a>
        <i class="fas fa-chevron-right"></i>
        <?php if (!empty($productData['category_name'])): ?>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>?category=<?= intval($productData['category_id'] ?? 0) ?>">
            <?= htmlspecialchars($productData['category_name']) ?>
        </a>
        <i class="fas fa-chevron-right"></i>
        <?php endif; ?>
        <span style="color:#1e293b;font-weight:600;"><?= htmlspecialchars($productData['name']) ?></span>
    </nav>

    <!-- Main grid -->
    <div class="pd-grid">

        <!-- Image panel -->
        <div class="pd-img-panel reveal">
            <div class="pd-img-main-wrap">
                <?php
                $hasDiscount = isset($productData['discount_price']) && floatval($productData['discount_price']) > 0;
                $outOfStock  = intval($productData['stock'] ?? 0) <= 0;
                $finalPrice  = $hasDiscount ? floatval($productData['discount_price']) : floatval($productData['price']);
                ?>
                <?php if ($hasDiscount && !empty($productData['discount_percent'])): ?>
                <div class="pd-ribbon">−<?= $productData['discount_percent'] ?>%</div>
                <?php endif; ?>
                <?php if (!empty($productData['image'])): ?>
                    <img class="pd-img-main"
                         src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($productData['image'])) ?>"
                         alt="<?= htmlspecialchars($productData['name']) ?>">
                <?php else: ?>
                    <div class="pd-img-placeholder">
                        <i class="fas fa-box"></i>
                        <span style="font-size:14px;font-weight:600;">Sin imagen</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Info panel -->
        <div class="pd-info-panel reveal reveal-delay-2">
            <!-- Category tag -->
            <?php if (!empty($productData['category_name'])): ?>
            <div class="pd-meta-top">
                <span class="pd-category-tag">
                    <i class="fas fa-tag" style="font-size:9px;"></i>
                    <?= htmlspecialchars($productData['category_name']) ?>
                </span>
            </div>
            <?php endif; ?>

            <!-- Name -->
            <h1 class="pd-name"><?= htmlspecialchars($productData['name']) ?></h1>

            <!-- Prices -->
            <div class="pd-price-block">
                <?php if ($hasDiscount): ?>
                    <span class="pd-price pd-price-sale">$<?= number_format($finalPrice, 2) ?></span>
                    <span class="pd-price-original">$<?= number_format($productData['price'], 2) ?></span>
                    <?php if (!empty($productData['discount_percent'])): ?>
                    <span class="pd-discount-badge">−<?= $productData['discount_percent'] ?>% OFF</span>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="pd-price">$<?= number_format($productData['price'], 2) ?></span>
                <?php endif; ?>
            </div>

            <!-- Stock -->
            <?php if (!$outOfStock): ?>
            <div class="pd-stock pd-stock-in">
                <span class="stock-dot"></span>
                En stock (<?= intval($productData['stock']) ?> disponibles)
            </div>
            <?php else: ?>
            <div class="pd-stock pd-stock-out">
                <i class="fas fa-ban" style="font-size:12px;"></i> Agotado
            </div>
            <?php endif; ?>

            <div class="pd-divider"></div>

            <!-- Description -->
            <?php if (!empty($productData['description'])): ?>
            <p class="pd-description"><?= htmlspecialchars($productData['description']) ?></p>
            <?php endif; ?>

            <!-- Add to cart actions -->
            <div class="pd-actions">
                <!-- Quantity -->
                <div class="pd-qty-wrap">
                    <button type="button" class="pd-qty-btn" onclick="adjustQty(-1)">−</button>
                    <input type="number" id="product-qty" class="pd-qty-input"
                           min="1" max="<?= intval($productData['stock'] ?? 99) ?>" value="1">
                    <button type="button" class="pd-qty-btn" onclick="adjustQty(1)">+</button>
                </div>

                <!-- Add to cart -->
                <button class="pd-add-btn" id="pdAddBtn"
                        onclick="addToCartFromDetail(<?= intval($productData['id']) ?>, <?= intval($storeData['id']) ?>)"
                        <?= $outOfStock ? 'disabled' : '' ?>>
                    <?php if (!$outOfStock): ?>
                        <i class="fas fa-shopping-bag" style="font-size:16px;"></i>
                        Agregar al carrito
                    <?php else: ?>
                        <i class="fas fa-ban" style="font-size:15px;"></i>
                        Producto agotado
                    <?php endif; ?>
                </button>

                <?php if (!empty($storeData['whatsapp_number'])): ?>
                <a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number'], 'Hola, me interesa el producto: ' . urlencode($productData['name'] ?? '')) ?>"
                   target="_blank" rel="noopener" class="pd-wa-btn" title="Preguntar por WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <?php endif; ?>
            </div>

            <!-- View cart shortcut -->
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>/cart"
               style="display:flex;align-items:center;justify-content:center;gap:7px;padding:12px;border:1.5px solid #e2e8f0;border-radius:12px;color:#475569;font-size:14px;font-weight:600;text-decoration:none;transition:all .18s;margin-top:0;"
               onmouseover="this.style.borderColor='#2a7a52';this.style.color='#2a7a52';this.style.background='#f0fdf4'"
               onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#475569';this.style.background='transparent'">
                <i class="fas fa-shopping-bag" style="font-size:13px;"></i> Ver mi carrito
            </a>

            <!-- Trust badges -->
            <div class="pd-trust-grid">
                <div class="pd-trust-item">
                    <div class="pd-trust-icon green"><i class="fas fa-truck"></i></div>
                    <div>
                        <div class="pd-trust-text">Envío rápido</div>
                        <div class="pd-trust-sub">Entrega segura</div>
                    </div>
                </div>
                <div class="pd-trust-item">
                    <div class="pd-trust-icon amber"><i class="fas fa-shield-alt"></i></div>
                    <div>
                        <div class="pd-trust-text">Pago seguro</div>
                        <div class="pd-trust-sub">100% protegido</div>
                    </div>
                </div>
                <div class="pd-trust-item">
                    <div class="pd-trust-icon blue"><i class="fas fa-undo"></i></div>
                    <div>
                        <div class="pd-trust-text">Devoluciones</div>
                        <div class="pd-trust-sub">Sin complicaciones</div>
                    </div>
                </div>
                <div class="pd-trust-item">
                    <div class="pd-trust-icon slate"><i class="fab fa-whatsapp"></i></div>
                    <div>
                        <div class="pd-trust-text">Soporte 24h</div>
                        <div class="pd-trust-sub">Por WhatsApp</div>
                    </div>
                </div>
            </div>

            <!-- Share -->
            <div class="pd-share">
                <span>Compartir:</span>
                <button class="pd-share-btn" title="Copiar enlace" onclick="copyProductLink()">
                    <i class="fas fa-link"></i>
                </button>
                <button class="pd-share-btn" title="Compartir en WhatsApp"
                        onclick="window.open('https://wa.me/?text=' + encodeURIComponent('<?= htmlspecialchars($productData['name']) ?> — ' + window.location.href), '_blank')">
                    <i class="fab fa-whatsapp"></i>
                </button>
            </div>
        </div>
    </div>

    <section class="pd-reviews">
        <div>
            <h2 class="pd-reviews-title">Comentarios</h2>
            <p style="font-size:13.5px;color:#64748b;">Comparte tu experiencia con este producto.</p>
        </div>

        <form method="POST" class="pd-review-form">
            <div style="display:grid;grid-template-columns:1fr 140px;gap:10px;">
                <input type="text" name="customer_name" maxlength="120" class="pd-review-input" placeholder="Tu nombre">
                <select name="rating" class="pd-review-select">
                    <option value="5">5 estrellas</option>
                    <option value="4">4 estrellas</option>
                    <option value="3">3 estrellas</option>
                    <option value="2">2 estrellas</option>
                    <option value="1">1 estrella</option>
                </select>
            </div>
            <textarea name="comment" class="pd-review-textarea" maxlength="1200" required placeholder="Escribe tu comentario..."></textarea>
            <div style="display:flex;justify-content:flex-end;">
                <button type="submit" class="pd-add-btn" style="max-width:220px;">
                    <i class="fas fa-paper-plane"></i> Publicar comentario
                </button>
            </div>
        </form>

        <div style="display:grid;gap:12px;">
            <?php if (!empty($productReviews)): ?>
                <?php foreach ($productReviews as $review): ?>
                <article class="pd-review-item">
                    <div class="pd-review-meta">
                        <strong style="font-size:14px;color:#0f172a;"><?= htmlspecialchars($review['customer_name'] ?: ($review['user_name'] ?? 'Cliente')) ?></strong>
                        <span style="font-size:12px;color:#64748b;"><?= Helper::formatDate($review['created_at']) ?></span>
                    </div>
                    <div style="font-size:12.5px;color:#f59e0b;font-weight:700;margin-bottom:6px;">
                        <?= str_repeat('★', max(1, min(5, intval($review['rating'] ?? 5)))) ?>
                    </div>
                    <p style="font-size:13.5px;color:#334155;line-height:1.55;white-space:pre-wrap;"><?= htmlspecialchars($review['comment'] ?? '') ?></p>

                    <?php if (!empty($review['reply_comment'])): ?>
                    <div class="pd-review-reply">
                        <p style="font-size:11.5px;font-weight:700;color:#166534;margin-bottom:5px;">Respuesta de la tienda</p>
                        <p style="font-size:13px;color:#166534;line-height:1.5;white-space:pre-wrap;"><?= htmlspecialchars($review['reply_comment']) ?></p>
                    </div>
                    <?php endif; ?>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="pd-review-item" style="text-align:center;color:#64748b;font-size:13.5px;">
                    Aún no hay comentarios. Sé el primero en opinar.
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
function adjustQty(delta) {
    const input = document.getElementById('product-qty');
    const max = parseInt(input.max || '99');
    const newVal = Math.max(1, Math.min(max, parseInt(input.value || '1') + delta));
    input.value = newVal;
}

function addToCartFromDetail(productId, storeId) {
    const btn = document.getElementById('pdAddBtn');
    const qty = Math.max(1, parseInt(document.getElementById('product-qty').value || '1'));
    const originalHtml = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="font-size:15px;"></i> Añadiendo...';

    const fd = new FormData();
    fd.append('product_id', productId);
    fd.append('store_id', storeId);
    fd.append('quantity', qty);

    fetch('<?= BASE_URL ?>api/cart/add', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                btn.innerHTML = '<i class="fas fa-check" style="font-size:15px;"></i> ¡Añadido!';
                btn.style.background = 'linear-gradient(135deg,#16a34a,#15803d)';
                const badge = document.getElementById('cart-count');
                if (badge) badge.textContent = parseInt(badge.textContent || 0) + qty;
                setTimeout(() => {
                    window.location.href = '<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>/cart';
                }, 900);
            } else {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                alert(data.message || 'Error al añadir al carrito');
            }
        })
        .catch(() => { btn.innerHTML = originalHtml; btn.disabled = false; });
}

function copyProductLink() {
    navigator.clipboard?.writeText(window.location.href)
        .then(() => {
            const btn = event.currentTarget;
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.style.background = '#2a7a52';
            btn.style.color = '#fff';
            setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; btn.style.color = ''; }, 1800);
        });
}

/* Input validation: no decimals, enforce min/max */
document.getElementById('product-qty')?.addEventListener('change', function() {
    const max = parseInt(this.max || '99');
    let val = parseInt(this.value || '1');
    if (isNaN(val) || val < 1) val = 1;
    if (val > max) val = max;
    this.value = val;
});
</script>
