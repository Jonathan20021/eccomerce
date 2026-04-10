<!-- Product Detail Content -->
<div class="store-page-wrap">

    <div style="margin-bottom:20px;">
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>"
           style="display:inline-flex;align-items:center;gap:6px;color:#64748b;font-size:13px;font-weight:500;text-decoration:none;">
            <i class="fas fa-arrow-left text-xs"></i> Volver a la tienda
        </a>
    </div>

    <div class="store-product-grid">
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;">
            <?php if (!empty($productData['image'])): ?>
              <img src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($productData['image'])) ?>"
                 alt="<?= htmlspecialchars($productData['name']) ?>"
                 style="width:100%;height:460px;object-fit:cover;display:block;">
            <?php else: ?>
            <div style="height:460px;display:flex;align-items:center;justify-content:center;background:#f8fafc;">
                <i class="fas fa-box" style="font-size:70px;color:#cbd5e1;"></i>
            </div>
            <?php endif; ?>
        </div>

        <div>
            <h1 style="font-size:30px;font-weight:900;color:#1e293b;line-height:1.2;letter-spacing:-0.8px;margin-bottom:10px;">
                <?= htmlspecialchars($productData['name']) ?>
            </h1>

            <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
                <?php if (isset($productData['discount_price']) && floatval($productData['discount_price']) > 0): ?>
                <span style="font-size:30px;font-weight:900;color:#4f46e5;">$<?= number_format($productData['discount_price'], 2) ?></span>
                <span style="font-size:18px;color:#94a3b8;text-decoration:line-through;">$<?= number_format($productData['price'], 2) ?></span>
                <?php else: ?>
                <span style="font-size:30px;font-weight:900;color:#4f46e5;">$<?= number_format($productData['price'], 2) ?></span>
                <?php endif; ?>
            </div>

            <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
                <?php if (intval($productData['stock']) > 0): ?>
                <span style="display:inline-flex;align-items:center;gap:6px;background:#ecfdf5;color:#166534;border:1px solid #bbf7d0;padding:5px 10px;border-radius:999px;font-size:12px;font-weight:700;">
                    <span style="width:6px;height:6px;background:#16a34a;border-radius:50%;display:inline-block;"></span>
                    En stock (<?= intval($productData['stock']) ?>)
                </span>
                <?php else: ?>
                <span style="display:inline-flex;align-items:center;gap:6px;background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;padding:5px 10px;border-radius:999px;font-size:12px;font-weight:700;">
                    Agotado
                </span>
                <?php endif; ?>
            </div>

            <p style="font-size:14.5px;color:#475569;line-height:1.75;margin-bottom:24px;white-space:pre-wrap;">
                <?= htmlspecialchars($productData['description'] ?? 'Sin descripción disponible.') ?>
            </p>

            <div style="display:flex;gap:10px;align-items:center;">
                <input id="product-qty" type="number" min="1" value="1"
                       style="width:80px;padding:12px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:14px;font-weight:700;color:#1e293b;">

                <button onclick="addToCartFromDetail(<?= intval($productData['id']) ?>, <?= intval($storeData['id']) ?>)"
                        <?= intval($productData['stock']) <= 0 ? 'disabled' : '' ?>
                        style="flex:1;padding:12px 18px;border:none;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;font-size:14px;font-weight:700;cursor:pointer;">
                    <i class="fas fa-shopping-cart" style="margin-right:6px;"></i>
                    <?= intval($productData['stock']) > 0 ? 'Agregar al carrito' : 'Producto agotado' ?>
                </button>

                <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>/cart"
                   style="padding:12px 14px;border:1.5px solid #e2e8f0;border-radius:10px;color:#475569;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;">
                    <i class="fas fa-shopping-bag"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function addToCartFromDetail(productId, storeId) {
    const qtyInput = document.getElementById('product-qty');
    const quantity = Math.max(1, parseInt(qtyInput.value || '1', 10));

    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('store_id', storeId);
    formData.append('quantity', quantity);

    fetch('<?= BASE_URL ?>api/cart/add', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                window.location.href = '<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>/cart';
            }
        });
}
</script>
