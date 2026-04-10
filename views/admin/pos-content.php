<style>
.pos-shell { display:flex; flex-direction:column; gap:18px; }
.pos-hero { border-radius:16px; background:linear-gradient(135deg,#0f172a 0%,#1d4ed8 55%,#0ea5e9 100%); padding:18px 20px; color:#fff; border:1px solid rgba(255,255,255,.2); }
.pos-hero-top { display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:flex-start; }
.pos-kpis { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:10px; margin-top:14px; }
.pos-kpi { background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.22); border-radius:12px; padding:10px 12px; }
.pos-kpi .label { font-size:11px; opacity:.9; text-transform:uppercase; letter-spacing:.4px; }
.pos-kpi .value { font-size:18px; font-weight:800; margin-top:4px; }
.pos-main { display:grid; grid-template-columns:2fr 1fr; gap:16px; align-items:start; }
.pos-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; box-shadow:0 4px 14px rgba(15,23,42,.04); }
.pos-card-head { padding:14px 16px; border-bottom:1px solid #eef2f7; display:flex; align-items:center; justify-content:space-between; gap:10px; }
.pos-card-body { padding:14px 16px; }
.pos-tools { display:grid; grid-template-columns:1fr 1fr auto; gap:10px; margin-bottom:14px; }
.pos-search-dropdown { position:absolute; left:0; right:0; top:100%; margin-top:6px; background:#fff; border:1px solid #e2e8f0; border-radius:10px; max-height:340px; overflow:auto; z-index:20; box-shadow:0 10px 22px rgba(2,6,23,.12); }
.pos-search-item { display:flex; gap:12px; padding:10px; cursor:pointer; border-bottom:1px solid #f1f5f9; align-items:center; transition:all .15s; }
.pos-search-item:last-child { border-bottom:none; }
.pos-search-item:hover { background:#f0f9ff; transform:translateX(3px); }
.pos-search-img { width:52px; height:52px; border-radius:8px; object-fit:cover; border:1px solid #e2e8f0; background:#f8fafc; flex-shrink:0; }
.pos-search-info { flex:1; min-width:0; }
.pos-search-name { font-weight:700; font-size:13px; color:#0f172a; margin-bottom:3px; }
.pos-search-meta { font-size:11px; color:#64748b; }
.pos-search-price { font-weight:800; font-size:14px; color:#2563eb; flex-shrink:0; }
.pos-lines-head, .pos-line-row { display:grid; grid-template-columns:auto 1.2fr .4fr .5fr .5fr auto; gap:10px; align-items:center; }
.pos-lines-head { font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700; margin-bottom:8px; }
.pos-line-row { padding:8px; border:1px solid #e2e8f0; border-radius:10px; margin-bottom:8px; background:#fff; transition:all .15s; }
.pos-line-row:hover { box-shadow:0 2px 8px rgba(15,23,42,.08); }
.pos-line-thumb { width:44px; height:44px; border-radius:8px; object-fit:cover; border:1px solid #e2e8f0; background:#f8fafc; }
.pos-line-product-wrap { display:flex; flex-direction:column; gap:2px; }
.pos-mini { font-size:11px; color:#64748b; margin-top:2px; }
.pos-right-stack { display:flex; flex-direction:column; gap:14px; }
.pos-summary-box { border:1px solid #e2e8f0; border-radius:12px; padding:12px; background:#f8fafc; }
.pos-summary-line { display:flex; justify-content:space-between; font-size:13px; color:#334155; padding:4px 0; }
.pos-summary-total { border-top:1px solid #cbd5e1; margin-top:6px; padding-top:8px; font-weight:800; font-size:18px; color:#0f172a; }
.pos-recent { max-height:280px; overflow:auto; }
@media (max-width: 1100px) {
    .pos-main { grid-template-columns:1fr; }
    .pos-kpis { grid-template-columns:repeat(2,minmax(0,1fr)); }
    .pos-tools { grid-template-columns:1fr; }
    .pos-lines-head, .pos-line-row { grid-template-columns:1fr; }
}
</style>

<?php
$dailySalesCount = intval($posDailySummary['total_sales'] ?? 0);
$dailyTotal = floatval($posDailySummary['gross_total'] ?? 0);
$dailyAvg = floatval($posDailySummary['average_ticket'] ?? 0);
$dailyCash = floatval($posDailySummary['cash_total'] ?? 0);
?>

<div class="pos-shell">
    <section class="pos-hero">
        <div class="pos-hero-top">
            <div>
                <h2 style="font-size:24px;font-weight:800;letter-spacing:-.4px;margin:0;">POS Profesional</h2>
                <p style="margin:6px 0 0;font-size:13px;opacity:.9;">Caja rápida con inventario en tiempo real, escaneo SKU y cierre diario.</p>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <a href="<?= BASE_URL ?>admin/pos/close?date=<?= urlencode($selectedDate) ?>" target="_blank" class="btn btn-ghost btn-sm" style="background:rgba(255,255,255,.17);color:#fff;border:1px solid rgba(255,255,255,.25);">
                    <i class="fas fa-cash-register"></i> Cierre de caja
                </a>
                <a href="<?= BASE_URL ?>admin/inventory" class="btn btn-ghost btn-sm" style="background:rgba(255,255,255,.17);color:#fff;border:1px solid rgba(255,255,255,.25);">
                    <i class="fas fa-warehouse"></i> Inventario
                </a>
            </div>
        </div>
        <div class="pos-kpis">
            <div class="pos-kpi"><div class="label">Ventas (día)</div><div class="value"><?= $dailySalesCount ?></div></div>
            <div class="pos-kpi"><div class="label">Total (día)</div><div class="value">$<?= number_format($dailyTotal, 2) ?></div></div>
            <div class="pos-kpi"><div class="label">Ticket promedio</div><div class="value">$<?= number_format($dailyAvg, 2) ?></div></div>
            <div class="pos-kpi"><div class="label">Efectivo</div><div class="value">$<?= number_format($dailyCash, 2) ?></div></div>
        </div>
    </section>

    <?php if (empty($availableProducts)): ?>
    <div class="table-card">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-box-open"></i></div>
            <h3>No hay productos con stock</h3>
            <p>Agrega o actualiza inventario para poder vender desde el POS.</p>
            <a href="<?= BASE_URL ?>admin/inventory" class="btn btn-primary btn-sm">
                <i class="fas fa-warehouse"></i> Ir a inventario
            </a>
        </div>
    </div>
    <?php else: ?>
    <form method="POST" action="<?= BASE_URL ?>admin/pos/sale" id="posSaleForm" class="pos-main">
        <section class="pos-card">
            <div class="pos-card-head">
                <h3 style="font-size:16px;font-weight:800;color:#0f172a;"><i class="fas fa-shopping-cart" style="color:#2563eb;margin-right:7px;"></i>Venta actual</h3>
                <button type="button" id="addLineBtn" class="btn btn-ghost btn-sm"><i class="fas fa-plus"></i> Línea manual</button>
            </div>
            <div class="pos-card-body">
                <div class="pos-tools">
                    <div style="position:relative;">
                        <label class="form-label" for="posSearchInput">Buscar producto</label>
                        <input type="text" id="posSearchInput" class="form-input" placeholder="Nombre o SKU...">
                        <div id="posSearchDropdown" class="pos-search-dropdown" style="display:none;"></div>
                    </div>
                    <div>
                        <label class="form-label" for="skuScannerInput">Escáner SKU / código</label>
                        <input type="text" id="skuScannerInput" class="form-input" placeholder="Escanea y presiona Enter">
                    </div>
                    <div style="display:flex;align-items:end;">
                        <button type="button" id="scanAddBtn" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;"><i class="fas fa-barcode"></i> Agregar</button>
                    </div>
                </div>

                <div class="pos-lines-head">
                    <div></div>
                    <div>Producto</div>
                    <div>Cant.</div>
                    <div>Precio</div>
                    <div>Subtotal</div>
                    <div></div>
                </div>
                <div id="posLines"></div>
            </div>
        </section>

        <aside class="pos-right-stack">
            <div class="pos-card">
                <div class="pos-card-head"><h3 style="font-size:15px;font-weight:800;"><i class="fas fa-user" style="color:#0891b2;margin-right:7px;"></i>Cliente</h3></div>
                <div class="pos-card-body" style="display:flex;flex-direction:column;gap:10px;">
                    <div class="form-group">
                        <label class="form-label" for="customer_id">Seleccionar cliente</label>
                        <select id="customer_id" name="customer_id" class="form-input">
                            <option value="">Cliente de mostrador</option>
                            <?php foreach ($customers as $customer): ?>
                            <option value="<?= intval($customer['id']) ?>"
                                    data-name="<?= htmlspecialchars($customer['name']) ?>"
                                    data-email="<?= htmlspecialchars($customer['email']) ?>"
                                    data-phone="<?= htmlspecialchars($customer['phone'] ?? '') ?>">
                                <?= htmlspecialchars($customer['name']) ?> (<?= htmlspecialchars($customer['email']) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group"><label class="form-label">Nombre</label><input class="form-input" type="text" id="customer_name" name="customer_name" value="Cliente Mostrador" required></div>
                    <div class="form-group"><label class="form-label">Email</label><input class="form-input" type="email" id="customer_email" name="customer_email"></div>
                    <div class="form-group"><label class="form-label">Teléfono</label><input class="form-input" type="text" id="customer_phone" name="customer_phone"></div>
                </div>
            </div>

            <div class="pos-card">
                <div class="pos-card-head"><h3 style="font-size:15px;font-weight:800;"><i class="fas fa-credit-card" style="color:#16a34a;margin-right:7px;"></i>Cobro</h3></div>
                <div class="pos-card-body" style="display:flex;flex-direction:column;gap:10px;">
                    <div class="form-group">
                        <label class="form-label" for="payment_method">Método de pago</label>
                        <select id="payment_method" name="payment_method" class="form-input">
                            <option value="cash">Efectivo</option>
                            <option value="card">Tarjeta</option>
                            <option value="transfer">Transferencia</option>
                            <option value="mixed">Mixto</option>
                        </select>
                    </div>
                    <div class="form-group"><label class="form-label" for="tax">Impuesto</label><input class="form-input summary-input" type="number" step="0.01" min="0" id="tax" name="tax" value="0"></div>
                    <div class="form-group"><label class="form-label" for="discount">Descuento</label><input class="form-input summary-input" type="number" step="0.01" min="0" id="discount" name="discount" value="0"></div>
                    <div class="form-group"><label class="form-label" for="notes">Notas</label><textarea class="form-input" id="notes" name="notes" rows="2" placeholder="Ej. venta express"></textarea></div>

                    <div class="pos-summary-box">
                        <div class="pos-summary-line"><span>Subtotal</span><strong id="subtotalView">$0.00</strong></div>
                        <div class="pos-summary-line"><span>Impuesto</span><strong id="taxView">$0.00</strong></div>
                        <div class="pos-summary-line"><span>Descuento</span><strong id="discountView">$0.00</strong></div>
                        <div class="pos-summary-line pos-summary-total"><span>Total</span><strong id="totalView">$0.00</strong></div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                        <i class="fas fa-check"></i> Confirmar venta
                    </button>
                </div>
            </div>

            <div class="pos-card">
                <div class="pos-card-head" style="padding-bottom:10px;">
                    <h3 style="font-size:15px;font-weight:800;"><i class="fas fa-clock" style="color:#4f46e5;margin-right:7px;"></i>Ventas del día</h3>
                    <span class="badge badge-slate"><?= htmlspecialchars($selectedDate) ?></span>
                </div>
                <div class="pos-card-body pos-recent">
                    <?php if (empty($posDailyOrders)): ?>
                    <p class="pos-mini" style="margin:0;">No hay ventas POS registradas en esta fecha.</p>
                    <?php else: ?>
                        <?php foreach ($posDailyOrders as $row): ?>
                        <a href="<?= BASE_URL ?>admin/orders/<?= intval($row['id']) ?>" style="display:flex;justify-content:space-between;gap:8px;padding:8px;border:1px solid #e2e8f0;border-radius:10px;margin-bottom:8px;text-decoration:none;">
                            <div>
                                <div style="font-size:12px;font-weight:700;color:#0f172a;"><?= htmlspecialchars($row['order_number']) ?></div>
                                <div class="pos-mini"><?= htmlspecialchars($row['customer_name']) ?> · <?= strtoupper(htmlspecialchars($row['payment_method'])) ?></div>
                            </div>
                            <strong style="font-size:13px;color:#0f172a;">$<?= number_format($row['total'], 2) ?></strong>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </form>
    <?php endif; ?>
</div>

<?php if (!empty($availableProducts)): ?>
<script>
(function () {
    var products = <?= json_encode(array_map(function ($item) {
        $image = '';
        if (!empty($item['images'])) {
            $images = is_string($item['images']) ? json_decode($item['images'], true) : $item['images'];
            if (is_array($images) && !empty($images[0])) {
                $image = $images[0];
            }
        }
        return [
            'id' => intval($item['id']),
            'name' => strval($item['name'] ?? ''),
            'sku' => strval($item['sku'] ?? ''),
            'price' => floatval($item['discount_price'] ?? 0) > 0 ? floatval($item['discount_price']) : floatval($item['price'] ?? 0),
            'stock' => intval($item['stock'] ?? 0),
            'image' => $image
        ];
    }, $availableProducts), JSON_UNESCAPED_UNICODE) ?>;

    var productsById = {};
    var productsBySku = {};
    products.forEach(function (p) {
        productsById[p.id] = p;
        if (p.sku) {
            productsBySku[p.sku.toLowerCase()] = p;
        }
    });

    var baseUrl = <?= json_encode(BASE_URL) ?>;
    var linesWrap = document.getElementById('posLines');
    var addLineBtn = document.getElementById('addLineBtn');
    var subtotalView = document.getElementById('subtotalView');
    var taxView = document.getElementById('taxView');
    var discountView = document.getElementById('discountView');
    var totalView = document.getElementById('totalView');
    var taxInput = document.getElementById('tax');
    var discountInput = document.getElementById('discount');
    var customerSelect = document.getElementById('customer_id');
    var searchInput = document.getElementById('posSearchInput');
    var searchDropdown = document.getElementById('posSearchDropdown');
    var scannerInput = document.getElementById('skuScannerInput');
    var scanAddBtn = document.getElementById('scanAddBtn');

    function money(value) {
        return '$' + Number(value || 0).toFixed(2);
    }

    function escapeHtml(value) {
        return String(value || '').replace(/[&<>"]/g, function (char) {
            return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'})[char] || char;
        });
    }

    function buildOptions(selectedId) {
        return products.map(function (product) {
            var selected = Number(selectedId) === Number(product.id) ? ' selected' : '';
            return '<option value="' + product.id + '" data-price="' + product.price + '" data-stock="' + product.stock + '" data-image="' + escapeHtml(product.image || '') + '"' + selected + '>' +
                escapeHtml(product.name) + ' · SKU ' + escapeHtml(product.sku || '-') + ' · stock ' + product.stock + '</option>';
        }).join('');
    }

    function createLine(productId, quantity) {
        var line = document.createElement('div');
        line.className = 'pos-line-row';
        var product = productsById[productId] || products[0];
        var imgSrc = product && product.image ? baseUrl + product.image : '';
        
        line.innerHTML = '' +
            '<img class="pos-line-thumb" src="' + (imgSrc || 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="44" height="44"%3E%3Crect fill="%23f1f5f9" width="44" height="44"/%3E%3Ctext x="50%25" y="50%25" dominant-baseline="middle" text-anchor="middle" fill="%2394a3b8" font-size="18"%3E?%3C/text%3E%3C/svg%3E') + '" alt="">' +
            '<div class="pos-line-product-wrap">' +
                '<select name="product_id[]" class="form-input pos-product" required>' + buildOptions(productId) + '</select>' +
                '<div class="pos-mini pos-line-meta">-</div>' +
            '</div>' +
            '<input class="form-input pos-qty" type="number" min="1" step="1" name="quantity[]" value="' + (quantity || 1) + '" required>' +
            '<div class="pos-unit" style="font-weight:700;color:#0f172a;">$0.00</div>' +
            '<div class="pos-subtotal" style="font-weight:800;color:#0f172a;">$0.00</div>' +
            '<button type="button" class="btn btn-ghost btn-sm pos-remove"><i class="fas fa-trash"></i></button>';

        linesWrap.appendChild(line);

        var selectEl = line.querySelector('.pos-product');
        var thumbEl = line.querySelector('.pos-line-thumb');
        
        selectEl.addEventListener('change', function() {
            var selected = selectEl.options[selectEl.selectedIndex];
            var newImg = selected ? selected.getAttribute('data-image') : '';
            thumbEl.src = newImg ? baseUrl + newImg : 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="44" height="44"%3E%3Crect fill="%23f1f5f9" width="44" height="44"/%3E%3Ctext x="50%25" y="50%25" dominant-baseline="middle" text-anchor="middle" fill="%2394a3b8" font-size="18"%3E?%3C/text%3E%3C/svg%3E';
            recalc();
        });
        line.querySelector('.pos-qty').addEventListener('input', recalc);
        line.querySelector('.pos-remove').addEventListener('click', function () {
            if (document.querySelectorAll('.pos-line-row').length <= 1) {
                return;
            }
            line.remove();
            recalc();
        });

        recalc();
    }

    function addOrIncreaseProduct(product) {
        var lines = document.querySelectorAll('.pos-line-row');
        for (var i = 0; i < lines.length; i++) {
            var line = lines[i];
            var select = line.querySelector('.pos-product');
            if (Number(select.value) === Number(product.id)) {
                var qtyInput = line.querySelector('.pos-qty');
                qtyInput.value = Number(qtyInput.value || 1) + 1;
                recalc();
                return;
            }
        }
        createLine(product.id, 1);
    }

    function recalc() {
        var subtotal = 0;
        var lines = document.querySelectorAll('.pos-line-row');

        lines.forEach(function (line) {
            var select = line.querySelector('.pos-product');
            var qtyInput = line.querySelector('.pos-qty');
            var unitView = line.querySelector('.pos-unit');
            var subView = line.querySelector('.pos-subtotal');
            var metaView = line.querySelector('.pos-line-meta');
            var selected = select.options[select.selectedIndex];

            var price = Number(selected ? selected.getAttribute('data-price') : 0);
            var stock = Number(selected ? selected.getAttribute('data-stock') : 0);
            var qty = Math.max(1, Number(qtyInput.value || 1));

            if (qty > stock) {
                qty = stock > 0 ? stock : 1;
                qtyInput.value = qty;
            }

            var lineSubtotal = price * qty;
            subtotal += lineSubtotal;
            unitView.textContent = money(price);
            subView.textContent = money(lineSubtotal);

            var product = productsById[Number(select.value)];
            metaView.textContent = product ? ('SKU: ' + (product.sku || '-') + ' · Stock disponible: ' + stock) : '-';
        });

        var tax = Math.max(0, Number(taxInput.value || 0));
        var discount = Math.max(0, Number(discountInput.value || 0));
        var total = Math.max(0, subtotal + tax - discount);

        subtotalView.textContent = money(subtotal);
        taxView.textContent = money(tax);
        discountView.textContent = money(discount);
        totalView.textContent = money(total);
    }

    function renderSearchResults(items) {
        if (!items || !items.length) {
            searchDropdown.style.display = 'none';
            searchDropdown.innerHTML = '';
            return;
        }

        searchDropdown.innerHTML = items.map(function (item) {
            var imgSrc = item.image ? baseUrl + item.image : 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="52" height="52"%3E%3Crect fill="%23f1f5f9" width="52" height="52"/%3E%3Ctext x="50%25" y="50%25" dominant-baseline="middle" text-anchor="middle" fill="%2394a3b8" font-size="20"%3E?%3C/text%3E%3C/svg%3E';
            return '<div class="pos-search-item" data-id="' + item.id + '">' +
                '<img class="pos-search-img" src="' + imgSrc + '" alt="">' +
                '<div class="pos-search-info">' +
                    '<div class="pos-search-name">' + escapeHtml(item.name) + '</div>' +
                    '<div class="pos-search-meta">SKU: ' + escapeHtml(item.sku || '-') + ' · Stock: ' + item.stock + '</div>' +
                '</div>' +
                '<div class="pos-search-price">' + money(item.price) + '</div>' +
                '</div>';
        }).join('');
        searchDropdown.style.display = 'block';
    }

    var searchTimer = null;
    function remoteSearch(query) {
        if (searchTimer) {
            clearTimeout(searchTimer);
        }
        searchTimer = setTimeout(function () {
            if (!query || query.length < 2) {
                renderSearchResults([]);
                return;
            }

            fetch(baseUrl + 'admin/pos/search?q=' + encodeURIComponent(query), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function (res) { return res.json(); })
                .then(function (payload) {
                    renderSearchResults(payload && payload.products ? payload.products : []);
                })
                .catch(function () {
                    renderSearchResults([]);
                });
        }, 180);
    }

    searchInput.addEventListener('input', function () {
        remoteSearch(searchInput.value.trim());
    });

    searchDropdown.addEventListener('click', function (event) {
        var item = event.target.closest('.pos-search-item');
        if (!item) {
            return;
        }
        var productId = Number(item.getAttribute('data-id'));
        var product = productsById[productId];
        if (!product) {
            return;
        }
        addOrIncreaseProduct(product);
        searchInput.value = '';
        renderSearchResults([]);
    });

    document.addEventListener('click', function (event) {
        if (!searchDropdown.contains(event.target) && event.target !== searchInput) {
            renderSearchResults([]);
        }
    });

    function processScannerInput() {
        var raw = (scannerInput.value || '').trim().toLowerCase();
        if (!raw) {
            return;
        }

        var product = productsBySku[raw] || null;
        if (product) {
            addOrIncreaseProduct(product);
            scannerInput.value = '';
            return;
        }

        fetch(baseUrl + 'admin/pos/search?q=' + encodeURIComponent(raw), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (res) { return res.json(); })
            .then(function (payload) {
                var matches = payload && payload.products ? payload.products : [];
                if (matches.length > 0) {
                    var match = matches[0];
                    addOrIncreaseProduct({
                        id: Number(match.id),
                        name: match.name,
                        sku: match.sku,
                        stock: Number(match.stock),
                        price: Number(match.price)
                    });
                    scannerInput.value = '';
                }
            })
            .catch(function () {});
    }

    scannerInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            processScannerInput();
        }
    });
    scanAddBtn.addEventListener('click', processScannerInput);

    addLineBtn.addEventListener('click', function () { createLine(null, 1); });
    taxInput.addEventListener('input', recalc);
    discountInput.addEventListener('input', recalc);

    customerSelect.addEventListener('change', function () {
        var selected = customerSelect.options[customerSelect.selectedIndex];
        if (!selected || !selected.value) {
            return;
        }
        document.getElementById('customer_name').value = selected.getAttribute('data-name') || 'Cliente Mostrador';
        document.getElementById('customer_email').value = selected.getAttribute('data-email') || '';
        document.getElementById('customer_phone').value = selected.getAttribute('data-phone') || '';
    });

    createLine(null, 1);
})();
</script>
<?php endif; ?>
