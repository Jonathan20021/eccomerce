<!-- Cart Content -->
<style>
/* ══════════════════════════════════════
   CART — PREMIUM
══════════════════════════════════════ */
.cart-wrap {
    max-width: 1280px; margin: 0 auto;
    padding: 32px 24px 80px;
}

/* Breadcrumb */
.cart-breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; color: #94a3b8; margin-bottom: 10px;
}
.cart-breadcrumb a { color: #64748b; text-decoration: none; font-weight: 500; transition: color .15s; }
.cart-breadcrumb a:hover { color: #2a7a52; }
.cart-breadcrumb i { font-size: 9px; opacity: .6; }

/* Page title */
.cart-title {
    font-size: 28px; font-weight: 900; color: #0f172a;
    letter-spacing: -.6px; margin-bottom: 28px;
}

/* Layout */
.cart-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 28px;
    align-items: start;
}

/* Items card */
.cart-items-card {
    background: #fff;
    border: 1.5px solid #e8f0ec;
    border-radius: 20px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(15,23,42,.05);
}
.cart-items-head {
    padding: 18px 22px; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; justify-content: space-between;
}
.cart-items-head h3 {
    font-size: 15px; font-weight: 800; color: #1e293b;
}
.cart-items-head .clear-link {
    font-size: 12.5px; font-weight: 600; color: #94a3b8;
    text-decoration: none; transition: color .15s;
}
.cart-items-head .clear-link:hover { color: #ef4444; }

/* Cart item row */
.cart-item {
    display: flex; align-items: center; gap: 16px;
    padding: 18px 22px;
    border-bottom: 1px solid #f8fafc;
    transition: background .18s;
}
.cart-item:last-child { border-bottom: none; }
.cart-item:hover { background: #fafff9; }

.cart-item-img {
    width: 76px; height: 76px; border-radius: 13px;
    object-fit: cover; flex-shrink: 0;
    border: 1.5px solid #f1f5f9;
    box-shadow: 0 2px 8px rgba(15,23,42,.06);
}
.cart-item-img-ph {
    width: 76px; height: 76px; border-radius: 13px;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border: 1.5px solid #f1f5f9; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    color: #cbd5e1; font-size: 22px;
}
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-name {
    font-size: 14.5px; font-weight: 700; color: #1e293b;
    margin-bottom: 4px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.cart-item-price {
    font-size: 15px; font-weight: 900; color: #1e293b;
}
.cart-item-price-sale { color: #ef4444; }
.cart-item-price-orig {
    font-size: 12px; color: #94a3b8; text-decoration: line-through; margin-left: 5px; font-weight: 500;
}

/* Quantity stepper */
.qty-stepper {
    display: flex; align-items: center;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    overflow: hidden; flex-shrink: 0;
    background: #f8fafc;
}
.qty-btn {
    width: 34px; height: 36px; background: none; border: none;
    font-size: 16px; color: #475569; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s, color .15s;
}
.qty-btn:hover { background: #ecfdf5; color: #2a7a52; }
.qty-display {
    width: 38px; height: 36px;
    border: none; background: none;
    text-align: center; font-size: 13.5px; font-weight: 800;
    color: #1e293b; font-family: 'Inter', sans-serif; outline: none;
}
.qty-display::-webkit-inner-spin-button,
.qty-display::-webkit-outer-spin-button { -webkit-appearance: none; }

/* Item total */
.cart-item-total {
    font-size: 15.5px; font-weight: 900; color: #1e293b;
    min-width: 80px; text-align: right; flex-shrink: 0;
}

/* Remove button */
.cart-item-remove {
    background: none; border: none; cursor: pointer;
    width: 30px; height: 30px; border-radius: 8px;
    color: #cbd5e1; font-size: 13px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: background .15s, color .15s;
}
.cart-item-remove:hover { background: #fef2f2; color: #ef4444; }

/* Order summary */
.cart-summary-card {
    background: #fff;
    border: 1.5px solid #e8f0ec;
    border-radius: 20px; padding: 26px;
    box-shadow: 0 4px 20px rgba(15,23,42,.05);
    position: sticky; top: 88px;
}
.cart-summary-title {
    font-size: 17px; font-weight: 900; color: #1e293b;
    margin-bottom: 22px; letter-spacing: -.3px;
}
.cart-summary-row {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 12px;
}
.cart-summary-label { font-size: 14px; color: #64748b; }
.cart-summary-value { font-size: 14px; font-weight: 600; color: #1e293b; }
.cart-summary-value.muted { font-size: 13px; color: #94a3b8; font-style: italic; font-weight: 400; }
.cart-summary-divider { height: 1px; background: #f1f5f9; margin: 16px 0; }
.cart-summary-total-label { font-size: 16px; font-weight: 700; color: #1e293b; }
.cart-summary-total-value {
    font-size: 26px; font-weight: 900; color: #0f172a; letter-spacing: -.6px;
}
.cart-checkout-btn {
    display: flex; align-items: center; justify-content: center; gap: 9px;
    width: 100%; padding: 15px;
    border: none; border-radius: 13px;
    background: linear-gradient(135deg, #2a7a52, #1f5c3d);
    color: #fff; font-size: 15px; font-weight: 800;
    font-family: 'Inter', sans-serif; cursor: pointer;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(42,122,82,.38);
    transition: transform .2s, box-shadow .2s;
    margin-bottom: 10px; position: relative; overflow: hidden;
}
.cart-checkout-btn::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.12), transparent);
    opacity: 0; transition: opacity .2s;
}
.cart-checkout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 36px rgba(42,122,82,.5);
}
.cart-checkout-btn:hover::after { opacity: 1; }
.cart-back-btn {
    display: flex; align-items: center; justify-content: center; gap: 7px;
    width: 100%; padding: 12px;
    border: 1.5px solid #e2e8f0; border-radius: 12px;
    background: none; color: #64748b;
    font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif;
    cursor: pointer; text-decoration: none;
    transition: border-color .15s, color .15s, background .15s;
}
.cart-back-btn:hover { border-color: #2a7a52; color: #2a7a52; background: #f0fdf4; }
.cart-secure {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    margin-top: 16px; font-size: 11.5px; color: #94a3b8; font-weight: 600;
}
.cart-secure i { color: #2a7a52; font-size: 12px; }

/* Summary trust */
.cart-summary-trust {
    display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 18px;
}
.cst-item {
    display: flex; flex-direction: column; align-items: center; gap: 5px;
    padding: 10px 6px; border-radius: 10px;
    background: #f8fafc; border: 1px solid #f1f5f9;
    text-align: center;
}
.cst-item i { font-size: 15px; color: #2a7a52; }
.cst-item span { font-size: 10.5px; font-weight: 600; color: #64748b; }

/* Empty cart */
.cart-empty {
    text-align: center; padding: 90px 24px;
    grid-column: 1 / -1;
}
.cart-empty-icon {
    width: 90px; height: 90px;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1.5px solid #bbf7d0;
    border-radius: 24px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px; font-size: 38px; color: #2a7a52;
}

/* Responsive */
@media (max-width: 900px) {
    .cart-layout { grid-template-columns: 1fr; }
    .cart-summary-card { position: static; }
}
@media (max-width: 640px) {
    .cart-wrap { padding: 20px 16px 60px; }
    .cart-item { padding: 14px 16px; gap: 12px; }
    .cart-item-img, .cart-item-img-ph { width: 62px; height: 62px; }
    .cart-item-total { min-width: 60px; font-size: 14px; }
    .cart-title { font-size: 24px; }
}
</style>

<div class="cart-wrap">
    <!-- Breadcrumb -->
    <nav class="cart-breadcrumb">
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>">
            <i class="fas fa-home" style="font-size:11px;"></i> Tienda
        </a>
        <i class="fas fa-chevron-right"></i>
        <span style="color:#1e293b;font-weight:600;">Carrito</span>
    </nav>

    <h1 class="cart-title">
        <i class="fas fa-shopping-bag" style="font-size:22px;color:#2a7a52;margin-right:10px;vertical-align:middle;"></i>
        Carrito de Compras
    </h1>

    <?php if (empty($cartItems)): ?>
    <!-- Empty cart -->
    <div class="cart-empty">
        <div class="cart-empty-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <h2 style="font-size:22px;font-weight:900;color:#1e293b;margin-bottom:10px;letter-spacing:-.4px;">Tu carrito está vacío</h2>
        <p style="font-size:14.5px;color:#64748b;margin-bottom:28px;max-width:360px;margin-left:auto;margin-right:auto;line-height:1.6;">
            Agrega productos y vuelve aquí para continuar con tu pedido.
        </p>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>"
           style="display:inline-flex;align-items:center;gap:9px;background:linear-gradient(135deg,#2a7a52,#1f5c3d);color:#fff;padding:13px 28px;border-radius:13px;font-size:15px;font-weight:700;text-decoration:none;box-shadow:0 8px 24px rgba(42,122,82,.35);">
            <i class="fas fa-arrow-left" style="font-size:12px;"></i> Ver productos
        </a>
    </div>

    <?php else: ?>
    <div class="cart-layout">

        <!-- ── Items ── -->
        <div class="cart-items-card reveal">
            <div class="cart-items-head">
                <h3><?= count($cartItems) ?> artículo<?= count($cartItems) !== 1 ? 's' : '' ?></h3>
                <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>" class="clear-link">
                    <i class="fas fa-arrow-left" style="font-size:10px;margin-right:4px;"></i>
                    Seguir comprando
                </a>
            </div>

            <?php foreach ($cartItems as $item):
                $itemPrice = (isset($item['discount_price']) && floatval($item['discount_price']) > 0)
                    ? floatval($item['discount_price'])
                    : floatval($item['price']);
                $hasDisc = isset($item['discount_price']) && floatval($item['discount_price']) > 0;
            ?>
            <div class="cart-item" id="cart-item-<?= $item['id'] ?>">
                <!-- Image -->
                <?php if (!empty($item['image'])): ?>
                    <img src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($item['image'])) ?>"
                         alt="<?= htmlspecialchars($item['name']) ?>"
                         class="cart-item-img">
                <?php else: ?>
                    <div class="cart-item-img-ph"><i class="fas fa-box"></i></div>
                <?php endif; ?>

                <!-- Info -->
                <div class="cart-item-info">
                    <div class="cart-item-name" title="<?= htmlspecialchars($item['name']) ?>">
                        <?= htmlspecialchars($item['name']) ?>
                    </div>
                    <div>
                        <span class="cart-item-price <?= $hasDisc ? 'cart-item-price-sale' : '' ?>">
                            $<?= number_format($itemPrice, 2) ?>
                        </span>
                        <?php if ($hasDisc): ?>
                        <span class="cart-item-price-orig">$<?= number_format($item['price'], 2) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Qty stepper -->
                <div class="qty-stepper">
                    <button class="qty-btn" onclick="changeQty(<?= $item['id'] ?>, <?= $item['quantity'] - 1 ?>)">−</button>
                    <input type="number" class="qty-display"
                           value="<?= $item['quantity'] ?>" min="1"
                           id="qty-<?= $item['id'] ?>"
                           onchange="updateQuantity(<?= $item['id'] ?>, this.value)">
                    <button class="qty-btn" onclick="changeQty(<?= $item['id'] ?>, <?= $item['quantity'] + 1 ?>)">+</button>
                </div>

                <!-- Line total -->
                <div class="cart-item-total">$<?= number_format($itemPrice * $item['quantity'], 2) ?></div>

                <!-- Remove -->
                <button class="cart-item-remove" onclick="removeFromCart(<?= $item['id'] ?>)" title="Eliminar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- ── Summary ── -->
        <div class="cart-summary-card reveal reveal-delay-2">
            <div class="cart-summary-title">Resumen del Pedido</div>

            <div class="cart-summary-row">
                <span class="cart-summary-label">Subtotal</span>
                <span class="cart-summary-value">$<?= number_format($cartTotal, 2) ?></span>
            </div>
            <div class="cart-summary-row">
                <span class="cart-summary-label">Envío</span>
                <span class="cart-summary-value muted">Al confirmar pedido</span>
            </div>
            <div class="cart-summary-row">
                <span class="cart-summary-label">Impuesto</span>
                <span class="cart-summary-value">$0.00</span>
            </div>

            <div class="cart-summary-divider"></div>

            <div class="cart-summary-row" style="margin-bottom:22px;">
                <span class="cart-summary-total-label">Total</span>
                <span class="cart-summary-total-value">$<?= number_format($cartTotal, 2) ?></span>
            </div>

            <?php $checkoutStoreId = isset($storeData['id']) ? intval($storeData['id']) : (isset($cartItems[0]['store_id']) ? intval($cartItems[0]['store_id']) : 0); ?>
            <a href="<?= BASE_URL ?>checkout?store_id=<?= $checkoutStoreId ?>" class="cart-checkout-btn">
                <i class="fas fa-lock" style="font-size:13px;"></i>
                Proceder al Pago
            </a>
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>" class="cart-back-btn">
                <i class="fas fa-arrow-left" style="font-size:11px;"></i>
                Seguir comprando
            </a>

            <div class="cart-secure">
                <i class="fas fa-shield-alt"></i>
                Compra 100% segura y protegida
            </div>

            <div class="cart-summary-trust">
                <div class="cst-item">
                    <i class="fas fa-truck"></i>
                    <span>Envío rápido</span>
                </div>
                <div class="cst-item">
                    <i class="fas fa-undo"></i>
                    <span>Devoluciones</span>
                </div>
                <div class="cst-item">
                    <i class="fab fa-whatsapp"></i>
                    <span>Soporte 24h</span>
                </div>
                <div class="cst-item">
                    <i class="fas fa-lock"></i>
                    <span>Pago seguro</span>
                </div>
            </div>
        </div>

    </div>
    <?php endif; ?>
</div>

<script>
function changeQty(itemId, newQty) {
    if (newQty <= 0) { removeFromCart(itemId); return; }
    document.getElementById('qty-' + itemId).value = newQty;
    updateQuantity(itemId, newQty);
}

function updateQuantity(itemId, quantity) {
    quantity = parseInt(quantity);
    if (isNaN(quantity) || quantity <= 0) { removeFromCart(itemId); return; }

    const fd = new FormData();
    fd.append('cart_item_id', itemId);
    fd.append('quantity', quantity);

    fetch('<?= BASE_URL ?>api/cart/update', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => { if (data.success) location.reload(); });
}

function removeFromCart(itemId) {
    const row = document.getElementById('cart-item-' + itemId);
    if (row) { row.style.opacity = '0'; row.style.transform = 'translateX(20px)'; row.style.transition = 'all .25s'; }

    const fd = new FormData();
    fd.append('cart_item_id', itemId);

    fetch('<?= BASE_URL ?>api/cart/remove', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => { if (data.success) setTimeout(() => location.reload(), 260); });
}
</script>
