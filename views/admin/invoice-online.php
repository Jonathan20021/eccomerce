<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura <?= htmlspecialchars($orderData['order_number']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f1f5f9; margin: 0; padding: 24px; color: #0f172a; }
        .invoice-wrap { max-width: 900px; margin: 0 auto; background: #fff; border-radius: 14px; padding: 24px; border: 1px solid #e2e8f0; }
        .row { display: flex; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .title { font-size: 28px; margin: 0; font-weight: 800; }
        .muted { color: #64748b; font-size: 13px; }
        .chip { display: inline-block; background: #e0e7ff; color: #4338ca; padding: 6px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border-bottom: 1px solid #e2e8f0; padding: 10px; text-align: left; font-size: 13px; }
        th { color: #334155; background: #f8fafc; }
        .text-right { text-align: right; }
        .summary { margin-left: auto; margin-top: 14px; width: 300px; }
        .summary-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 14px; }
        .summary-total { font-size: 18px; font-weight: 800; border-top: 1px solid #cbd5e1; margin-top: 8px; padding-top: 10px; }
        .actions { display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap; }
        .btn { text-decoration: none; background: #0f172a; color: #fff; border-radius: 8px; padding: 10px 14px; font-size: 13px; font-weight: 700; }
        .btn.secondary { background: #475569; }
        @media print {
            body { background: #fff; padding: 0; }
            .invoice-wrap { border: none; box-shadow: none; border-radius: 0; max-width: 100%; padding: 0; }
            .actions { display: none; }
        }
    </style>
</head>
<body>
<div class="invoice-wrap">
    <div class="row" style="align-items:flex-start;">
        <div>
            <h1 class="title">Factura de Venta</h1>
            <p class="muted" style="margin-top:6px;"><?= htmlspecialchars($storeData['name'] ?? 'Tienda') ?></p>
            <?php if (!empty($storeData['email'])): ?><p class="muted" style="margin:2px 0;"><?= htmlspecialchars($storeData['email']) ?></p><?php endif; ?>
            <?php if (!empty($storeData['phone'])): ?><p class="muted" style="margin:2px 0;"><?= htmlspecialchars($storeData['phone']) ?></p><?php endif; ?>
        </div>
        <div style="text-align:right;">
            <span class="chip">#<?= htmlspecialchars($orderData['order_number']) ?></span>
            <p class="muted" style="margin:8px 0 0;">Fecha: <?= Helper::formatDate($orderData['created_at'], 'Y-m-d H:i') ?></p>
            <p class="muted" style="margin:2px 0 0;">Pago: <?= strtoupper(htmlspecialchars($orderData['payment_method'])) ?></p>
        </div>
    </div>

    <div class="row" style="margin-top:18px;">
        <div>
            <strong>Facturar a:</strong>
            <p class="muted" style="margin:6px 0 0;"><?= htmlspecialchars($orderData['customer_name']) ?></p>
            <?php if (!empty($orderData['customer_email'])): ?><p class="muted" style="margin:2px 0;"><?= htmlspecialchars($orderData['customer_email']) ?></p><?php endif; ?>
            <?php if (!empty($orderData['customer_phone'])): ?><p class="muted" style="margin:2px 0;"><?= htmlspecialchars($orderData['customer_phone']) ?></p><?php endif; ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td class="text-right"><?= intval($item['quantity']) ?></td>
                <td class="text-right">$<?= number_format($item['price'], 2) ?></td>
                <td class="text-right">$<?= number_format($item['subtotal'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row"><span>Subtotal</span><strong>$<?= number_format($orderData['subtotal'], 2) ?></strong></div>
        <div class="summary-row"><span>Impuesto</span><strong>$<?= number_format($orderData['tax'], 2) ?></strong></div>
        <div class="summary-row"><span>Envío</span><strong>$<?= number_format($orderData['shipping_cost'], 2) ?></strong></div>
        <div class="summary-row"><span>Descuento</span><strong>$<?= number_format($orderData['discount'], 2) ?></strong></div>
        <div class="summary-row summary-total"><span>Total</span><strong>$<?= number_format($orderData['total'], 2) ?></strong></div>
    </div>

    <div class="actions">
        <a class="btn" href="<?= BASE_URL ?>admin/orders/<?= intval($orderData['id']) ?>/invoice/pdf">Descargar PDF</a>
        <a class="btn secondary"
           href="<?= BASE_URL ?>admin/orders/<?= intval($orderData['id']) ?>/invoice/thermal"
           onclick="window.open(this.href, 'thermalPrintWindow', 'width=420,height=860,menubar=no,toolbar=no,location=no,status=no,resizable=yes,scrollbars=yes'); return false;">
            Ticket térmico
        </a>
        <a class="btn secondary" href="<?= BASE_URL ?>admin/orders/<?= intval($orderData['id']) ?>">Volver a orden</a>
        <a class="btn secondary" href="javascript:window.print()">Imprimir</a>
    </div>
</div>
</body>
</html>
