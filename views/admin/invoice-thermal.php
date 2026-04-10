<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket <?= htmlspecialchars($orderData['order_number']) ?></title>
    <style>
        @page { size: 80mm auto; margin: 0; }
        html, body { width: 80mm; margin: 0 auto; padding: 0; }
        body { background: #e2e8f0; font-family: 'Courier New', monospace; }
        .ticket-wrap { padding: 12px 0 18px; }
        .ticket {
            width: 78mm;
            margin: 0 auto;
            background: #fff;
            color: #0f172a;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .12);
        }
        .center { text-align: center; }
        .muted { font-size: 10px; color: #475569; }
        .brand { font-size: 15px; font-weight: 700; letter-spacing: .4px; color: #020617; }
        .doc-title { margin-top: 3px; font-size: 11px; letter-spacing: 1.2px; color: #334155; text-transform: uppercase; }
        .line { border-top: 1px dashed #475569; margin: 8px 0; }
        .meta-row { display: flex; justify-content: space-between; gap: 8px; font-size: 10px; margin-bottom: 2px; }
        .meta-row .label { color: #64748b; }
        .meta-row .value { color: #0f172a; font-weight: 700; text-align: right; }
        table { width: 100%; border-collapse: collapse; }
        th { font-size: 10px; text-transform: uppercase; color: #64748b; text-align: left; padding-bottom: 3px; }
        td { font-size: 10px; padding: 2px 0; vertical-align: top; color: #0f172a; }
        .item-name { font-weight: 700; padding-top: 3px; }
        .qty { width: 13%; text-align: center; }
        .price, .subtotal { width: 25%; text-align: right; }
        .summary td { padding: 2px 0; }
        .summary .label { color: #475569; }
        .summary .value { text-align: right; font-weight: 700; }
        .total-row .label, .total-row .value { font-size: 13px; color: #020617; font-weight: 800; }
        .footer-note { margin-top: 8px; text-align: center; font-size: 10px; color: #334155; line-height: 1.35; }
        .actions { max-width: 78mm; margin: 8px auto 0; display:flex; gap:6px; }
        .btn { flex:1; text-decoration:none; text-align:center; background:#0f172a; color:#fff; border-radius:6px; padding:8px 4px; font:700 11px Arial,sans-serif; }
        @media print {
            html, body { width: 76mm !important; margin: 0 !important; padding: 0 !important; }
            body { background: #fff; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .ticket-wrap { padding: 0; }
            .ticket { margin: 0; border: none; border-radius: 0; box-shadow: none; width: 76mm; }
            .actions { display: none; }
        }
    </style>
</head>
<body>
<?php
$money = function ($amount) use ($currencySymbol) {
    return $currencySymbol . number_format(floatval($amount), 2);
};
?>
<div class="ticket-wrap">
    <div class="ticket">
        <div class="center">
            <div class="brand"><?= htmlspecialchars($companyInfo['name'] ?? 'Tienda') ?></div>
            <div class="doc-title">Comprobante de venta</div>
            <div class="muted" style="margin-top:4px;"><?= htmlspecialchars($companyInfo['address'] ?? '') ?></div>
            <div class="muted"><?= htmlspecialchars($companyInfo['phone'] ?? '') ?><?= !empty($companyInfo['phone']) && !empty($companyInfo['email']) ? ' · ' : '' ?><?= htmlspecialchars($companyInfo['email'] ?? '') ?></div>
        </div>

        <div class="line"></div>
        <div class="meta-row"><span class="label">Ticket:</span><span class="value"><?= htmlspecialchars($orderData['order_number']) ?></span></div>
        <div class="meta-row"><span class="label">Fecha:</span><span class="value"><?= Helper::formatDate($orderData['created_at'], 'Y-m-d H:i') ?></span></div>
        <div class="meta-row"><span class="label">Cliente:</span><span class="value"><?= htmlspecialchars($orderData['customer_name'] ?: 'Cliente general') ?></span></div>
        <div class="meta-row"><span class="label">Pago:</span><span class="value"><?= strtoupper(htmlspecialchars($orderData['payment_method'])) ?></span></div>

        <div class="line"></div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th class="qty">Cant</th>
                    <th class="price">P/U</th>
                    <th class="subtotal">Imp.</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td colspan="4" class="item-name"><?= htmlspecialchars($item['name']) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="qty"><?= intval($item['quantity']) ?></td>
                    <td class="price"><?= $money($item['price']) ?></td>
                    <td class="subtotal"><?= $money($item['subtotal']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="line"></div>
        <table class="summary">
            <tr><td class="label">Subtotal</td><td class="value"><?= $money($orderData['subtotal']) ?></td></tr>
            <tr><td class="label">Impuesto</td><td class="value"><?= $money($orderData['tax']) ?></td></tr>
            <tr><td class="label">Descuento</td><td class="value"><?= $money($orderData['discount']) ?></td></tr>
            <tr class="total-row"><td class="label">TOTAL</td><td class="value"><?= $money($orderData['total']) ?></td></tr>
        </table>

        <div class="line"></div>
        <div class="footer-note">
            <?= htmlspecialchars($companyInfo['footer_text'] ?? 'Gracias por su compra.') ?><br>
            Conserve este comprobante para cualquier cambio o reclamación.
        </div>
    </div>
</div>

<div class="actions">
    <a class="btn" href="javascript:window.print()">Imprimir</a>
    <a class="btn" href="<?= BASE_URL ?>admin/orders/<?= intval($orderData['id']) ?>/invoice/online">Factura web</a>
</div>

<script>
window.addEventListener('load', function () {
    if (!window.location.search.includes('preview=1')) {
        setTimeout(function () {
            window.print();
        }, 120);
    }
});
</script>
</body>
</html>
