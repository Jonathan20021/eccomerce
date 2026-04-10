<div style="max-width:980px;margin:28px auto 70px;padding:0 16px;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:14px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#0f172a;">Detalle de orden</h1>
            <p style="font-size:13px;color:#64748b;"><?= htmlspecialchars($orderData['order_number'] ?? '') ?></p>
        </div>
        <a href="<?= BASE_URL ?>customer/panel" style="font-size:13px;color:#2a7a52;font-weight:700;text-decoration:none;">Volver al panel</a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:14px;align-items:start;">
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
            <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9;">
                <h2 style="font-size:15px;font-weight:800;color:#0f172a;">Productos</h2>
            </div>

            <?php if (empty($orderItems)): ?>
            <div style="padding:18px 16px;font-size:13px;color:#64748b;">No hay items para esta orden.</div>
            <?php else: ?>
            <div style="display:flex;flex-direction:column;">
                <?php foreach ($orderItems as $item): ?>
                <div style="padding:12px 16px;border-top:1px solid #f8fafc;display:flex;align-items:center;gap:10px;justify-content:space-between;">
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#0f172a;"><?= htmlspecialchars($item['name'] ?? 'Producto') ?></div>
                        <div style="font-size:12px;color:#64748b;">Cantidad: <?= intval($item['quantity'] ?? 0) ?></div>
                    </div>
                    <div style="font-size:13px;font-weight:700;color:#0f172a;">$<?= number_format(floatval($item['subtotal'] ?? 0), 2) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:14px;">
            <h2 style="font-size:15px;font-weight:800;color:#0f172a;margin-bottom:10px;">Resumen</h2>
            <div style="display:flex;justify-content:space-between;gap:8px;margin-bottom:8px;font-size:13px;">
                <span style="color:#64748b;">Estado</span>
                <strong style="color:#334155;"><?= htmlspecialchars(ucfirst($orderData['status'] ?? 'pending')) ?></strong>
            </div>
            <div style="display:flex;justify-content:space-between;gap:8px;margin-bottom:8px;font-size:13px;">
                <span style="color:#64748b;">Pago</span>
                <strong style="color:#334155;"><?= htmlspecialchars(ucfirst($orderData['payment_status'] ?? 'pending')) ?></strong>
            </div>
            <div style="display:flex;justify-content:space-between;gap:8px;margin-bottom:8px;font-size:13px;">
                <span style="color:#64748b;">Total</span>
                <strong style="color:#0f172a;">$<?= number_format(floatval($orderData['total'] ?? 0), 2) ?></strong>
            </div>
            <div style="display:flex;justify-content:space-between;gap:8px;margin-bottom:12px;font-size:13px;">
                <span style="color:#64748b;">Fecha</span>
                <strong style="color:#334155;"><?= htmlspecialchars(date('Y-m-d H:i', strtotime($orderData['created_at'] ?? 'now'))) ?></strong>
            </div>
            <div style="padding:10px;border:1px solid #e2e8f0;border-radius:9px;background:#f8fafc;font-size:12px;color:#475569;line-height:1.5;">
                <strong>Dirección de envío:</strong><br>
                <?= nl2br(htmlspecialchars($orderData['shipping_address'] ?? '')) ?>
            </div>
        </div>
    </div>
</div>
