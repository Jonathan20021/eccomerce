<div style="max-width:1100px;margin:28px auto 70px;padding:0 16px;">
    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;padding:12px 14px;border-radius:10px;margin-bottom:14px;font-size:13px;">
        <?= htmlspecialchars($_GET['error']) ?>
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:12px 14px;border-radius:10px;margin-bottom:14px;font-size:13px;">
        <?= htmlspecialchars($_GET['success']) ?>
    </div>
    <?php endif; ?>

    <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:14px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#0f172a;">Hola, <?= htmlspecialchars($customer['name'] ?? 'Cliente') ?></h1>
            <p style="font-size:13px;color:#64748b;">Desde aquí gestionas tu cuenta en <?= htmlspecialchars($storeData['name'] ?? 'la tienda') ?>.</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="<?= BASE_URL ?>customer/profile" style="padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;font-weight:700;color:#334155;text-decoration:none;">Mi perfil</a>
            <a href="<?= BASE_URL ?>customer/addresses" style="padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:9px;font-size:13px;font-weight:700;color:#334155;text-decoration:none;">Mis direcciones</a>
            <a href="<?= BASE_URL ?>customer/logout" style="padding:9px 12px;border:1.5px solid #fee2e2;border-radius:9px;font-size:13px;font-weight:700;color:#dc2626;text-decoration:none;">Cerrar sesión</a>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-bottom:16px;">
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:14px;">
            <div style="font-size:12px;color:#64748b;margin-bottom:6px;">Pedidos realizados</div>
            <div style="font-size:26px;font-weight:900;color:#0f172a;"><?= intval($totalOrders ?? 0) ?></div>
        </div>
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:14px;">
            <div style="font-size:12px;color:#64748b;margin-bottom:6px;">Email</div>
            <div style="font-size:14px;font-weight:700;color:#0f172a;"><?= htmlspecialchars($customer['email'] ?? '') ?></div>
        </div>
    </div>

    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">
        <div style="padding:14px 16px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">
            <h2 style="font-size:15px;font-weight:800;color:#0f172a;">Mis pedidos</h2>
            <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>" style="font-size:12px;color:#2a7a52;font-weight:700;text-decoration:none;">Seguir comprando</a>
        </div>

        <?php if (empty($orders)): ?>
        <div style="padding:24px 16px;text-align:center;color:#64748b;font-size:13px;">
            Aún no tienes pedidos. Cuando completes tu primera compra aparecerá aquí.
        </div>
        <?php else: ?>
        <div style="overflow:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:760px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="text-align:left;padding:10px 12px;font-size:12px;color:#475569;">Orden</th>
                        <th style="text-align:left;padding:10px 12px;font-size:12px;color:#475569;">Estado</th>
                        <th style="text-align:left;padding:10px 12px;font-size:12px;color:#475569;">Total</th>
                        <th style="text-align:left;padding:10px 12px;font-size:12px;color:#475569;">Fecha</th>
                        <th style="text-align:left;padding:10px 12px;font-size:12px;color:#475569;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr style="border-top:1px solid #f1f5f9;">
                        <td style="padding:10px 12px;font-size:13px;font-weight:700;color:#0f172a;"><?= htmlspecialchars($order['order_number']) ?></td>
                        <td style="padding:10px 12px;font-size:13px;color:#334155;"><?= htmlspecialchars(ucfirst($order['status'])) ?></td>
                        <td style="padding:10px 12px;font-size:13px;color:#334155;">$<?= number_format(floatval($order['total'] ?? 0), 2) ?></td>
                        <td style="padding:10px 12px;font-size:13px;color:#64748b;"><?= htmlspecialchars(date('Y-m-d H:i', strtotime($order['created_at'] ?? 'now'))) ?></td>
                        <td style="padding:10px 12px;">
                            <a href="<?= BASE_URL ?>customer/orders/<?= intval($order['id']) ?>" style="font-size:12px;font-weight:700;color:#2a7a52;text-decoration:none;">Ver detalle</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
