<!-- Cart Content -->
<div class="store-page-wrap">

    <div style="margin-bottom:28px;">
        <a href="javascript:history.back()"
           style="display:inline-flex;align-items:center;gap:5px;color:#64748b;font-size:13px;font-weight:500;text-decoration:none;margin-bottom:12px;transition:color .15s;"
           onmouseover="this.style.color='#1e293b'" onmouseout="this.style.color='#64748b'">
            <i class="fas fa-arrow-left text-xs"></i> Seguir comprando
        </a>
        <h1 style="font-size:26px;font-weight:800;color:#1e293b;letter-spacing:-0.6px;">Carrito de Compras</h1>
    </div>

    <?php if (empty($cartItems)): ?>
    <div style="text-align:center;padding:80px 24px;">
        <div style="width:80px;height:80px;background:#eef2ff;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:32px;color:#4f46e5;">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <h2 style="font-size:20px;font-weight:700;color:#1e293b;margin-bottom:8px;">Tu carrito está vacío</h2>
        <p style="font-size:14px;color:#64748b;margin-bottom:24px;">Agrega productos para continuar con tu compra.</p>
        <a href="javascript:history.back()"
           style="display:inline-flex;align-items:center;gap:8px;background:#4f46e5;color:#fff;padding:12px 24px;border-radius:9px;font-size:14px;font-weight:700;text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Ver Productos
        </a>
    </div>

    <?php else: ?>
    <div class="store-grid-main">

        <!-- Cart Items -->
        <div>
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;">
                <div style="padding:16px 20px;border-bottom:1px solid #f1f5f9;">
                    <h3 style="font-size:14px;font-weight:700;color:#1e293b;"><?= count($cartItems) ?> artículo<?= count($cartItems) !== 1 ? 's' : '' ?></h3>
                </div>
                <div style="padding:4px 0;">
                    <?php foreach ($cartItems as $item): ?>
                    <?php $itemPrice = (isset($item['discount_price']) && floatval($item['discount_price']) > 0) ? floatval($item['discount_price']) : floatval($item['price']); ?>
                    <div style="display:flex;align-items:center;gap:14px;padding:16px 20px;border-bottom:1px solid #f8fafc;" id="cart-item-<?= $item['id'] ?>">
                        <!-- Image -->
                        <?php if (isset($item['image']) && $item['image']): ?>
                            <img src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($item['image'])) ?>"
                             alt="<?= htmlspecialchars($item['name']) ?>"
                             style="width:72px;height:72px;border-radius:10px;object-fit:cover;border:1px solid #f1f5f9;flex-shrink:0;">
                        <?php else: ?>
                        <div style="width:72px;height:72px;border-radius:10px;background:#f8fafc;border:1px solid #f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-box" style="color:#cbd5e1;font-size:20px;"></i>
                        </div>
                        <?php endif; ?>

                        <!-- Name + Price -->
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:14px;font-weight:600;color:#1e293b;margin-bottom:4px;" class="line-clamp-2">
                                <?= htmlspecialchars($item['name']) ?>
                            </p>
                            <p style="font-size:15px;font-weight:800;color:#4f46e5;">
                                $<?= number_format($itemPrice, 2) ?>
                            </p>
                        </div>

                        <!-- Quantity -->
                        <div style="display:flex;align-items:center;gap:0;border:1.5px solid #e2e8f0;border-radius:8px;overflow:hidden;flex-shrink:0;">
                            <button onclick="changeQty(<?= $item['id'] ?>, <?= $item['quantity'] - 1 ?>)"
                                    style="width:32px;height:34px;background:#f8fafc;border:none;cursor:pointer;font-size:16px;color:#475569;transition:background .15s;"
                                    onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">−</button>
                            <input type="number" value="<?= $item['quantity'] ?>" min="1"
                                   id="qty-<?= $item['id'] ?>"
                                   style="width:42px;height:34px;border:none;border-left:1px solid #e2e8f0;border-right:1px solid #e2e8f0;text-align:center;font-size:13.5px;font-weight:700;color:#1e293b;"
                                   onchange="updateQuantity(<?= $item['id'] ?>, this.value)">
                            <button onclick="changeQty(<?= $item['id'] ?>, <?= $item['quantity'] + 1 ?>)"
                                    style="width:32px;height:34px;background:#f8fafc;border:none;cursor:pointer;font-size:16px;color:#475569;transition:background .15s;"
                                    onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">+</button>
                        </div>

                        <!-- Item total -->
                        <div style="font-size:15px;font-weight:800;color:#1e293b;min-width:72px;text-align:right;flex-shrink:0;">
                            $<?= number_format($itemPrice * $item['quantity'], 2) ?>
                        </div>

                        <!-- Remove -->
                        <button onclick="removeFromCart(<?= $item['id'] ?>)"
                                style="background:none;border:none;color:#cbd5e1;cursor:pointer;padding:4px;transition:color .15s;"
                                onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#cbd5e1'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="store-summary-col">
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px;position:sticky;top:80px;">
                <h3 style="font-size:16px;font-weight:800;color:#1e293b;margin-bottom:20px;">Resumen del Pedido</h3>

                <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:18px;padding-bottom:18px;border-bottom:1px solid #f1f5f9;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:14px;color:#64748b;">Subtotal</span>
                        <span style="font-size:14px;font-weight:600;color:#1e293b;">$<?= number_format($cartTotal, 2) ?></span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:14px;color:#64748b;">Envío</span>
                        <span style="font-size:13px;color:#94a3b8;font-style:italic;">Calculado al checkout</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:14px;color:#64748b;">Impuesto</span>
                        <span style="font-size:14px;font-weight:600;color:#1e293b;">$0.00</span>
                    </div>
                </div>

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:22px;">
                    <span style="font-size:16px;font-weight:700;color:#1e293b;">Total</span>
                    <span style="font-size:22px;font-weight:900;color:#4f46e5;letter-spacing:-0.5px;">$<?= number_format($cartTotal, 2) ?></span>
                </div>

                     <?php $checkoutStoreId = isset($storeData['id']) ? intval($storeData['id']) : (isset($cartItems[0]['store_id']) ? intval($cartItems[0]['store_id']) : 0); ?>
                     <a href="<?= BASE_URL ?>checkout?store_id=<?= $checkoutStoreId ?>"
                   style="display:block;text-align:center;padding:14px;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;font-size:15px;font-weight:700;text-decoration:none;box-shadow:0 4px 16px rgba(79,70,229,0.3);margin-bottom:10px;transition:all .2s;"
                   onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 22px rgba(79,70,229,0.4)'"
                   onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 16px rgba(79,70,229,0.3)'">
                    <i class="fas fa-lock mr-2" style="font-size:12px;"></i> Proceder al Pago
                </a>

                <a href="javascript:history.back()"
                   style="display:block;text-align:center;padding:11px;border-radius:9px;border:1.5px solid #e2e8f0;color:#64748b;font-size:14px;font-weight:600;text-decoration:none;transition:all .15s;"
                   onmouseover="this.style.background='#f8fafc';this.style.borderColor='#cbd5e1'"
                   onmouseout="this.style.background='transparent';this.style.borderColor='#e2e8f0'">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Seguir Comprando
                </a>

                <div style="display:flex;align-items:center;justify-content:center;gap:6px;margin-top:16px;">
                    <i class="fas fa-shield-alt" style="font-size:11px;color:#94a3b8;"></i>
                    <span style="font-size:11.5px;color:#94a3b8;">Compra 100% segura</span>
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
    const fd = new FormData();
    fd.append('cart_item_id', itemId);

    fetch('<?= BASE_URL ?>api/cart/remove', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => { if (data.success) location.reload(); });
}
</script>
