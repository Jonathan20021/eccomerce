<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre de Caja <?= htmlspecialchars($date) ?></title>
    <style>
        body { margin:0; padding:24px; background:#f1f5f9; color:#0f172a; font-family: Arial, sans-serif; }
        .report { max-width: 980px; margin: 0 auto; background:#fff; border-radius:14px; border:1px solid #e2e8f0; overflow:hidden; }
        .head { background:linear-gradient(135deg,#0f172a,#1d4ed8); color:#fff; padding:18px 22px; }
        .head h1 { margin:0; font-size:24px; }
        .head p { margin:5px 0 0; opacity:.9; font-size:13px; }
        .content { padding:18px 22px; }
        .kpis { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:10px; margin-bottom:18px; }
        .kpi { border:1px solid #e2e8f0; border-radius:10px; padding:10px; background:#f8fafc; }
        .kpi .label { font-size:11px; text-transform:uppercase; color:#64748b; font-weight:700; }
        .kpi .value { margin-top:4px; font-size:20px; font-weight:800; color:#0f172a; }
        .grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .box { border:1px solid #e2e8f0; border-radius:10px; padding:12px; }
        .line { display:flex; justify-content:space-between; font-size:13px; padding:4px 0; color:#334155; }
        .line strong { color:#0f172a; }
        .title { margin:0 0 8px; font-size:14px; font-weight:800; color:#0f172a; }
        table { width:100%; border-collapse: collapse; margin-top:14px; }
        th, td { padding:9px 10px; border-bottom:1px solid #e2e8f0; text-align:left; font-size:12.5px; }
        th { background:#f8fafc; color:#334155; font-weight:700; text-transform:uppercase; font-size:11px; }
        .text-right { text-align:right; }
        .actions { display:flex; gap:8px; margin-top:16px; }
        .btn { text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px; border-radius:8px; padding:9px 12px; font-size:12px; font-weight:700; border:1px solid #cbd5e1; color:#0f172a; background:#fff; }
        .btn.primary { background:#0f172a; color:#fff; border-color:#0f172a; }
        @media (max-width: 900px) {
            .kpis { grid-template-columns:repeat(2,minmax(0,1fr)); }
            .grid { grid-template-columns:1fr; }
        }
        @media print {
            body { padding:0; background:#fff; }
            .report { border:none; border-radius:0; max-width:100%; }
            .actions { display:none; }
        }
    </style>
</head>
<body>
<div class="report">
    <div class="head">
        <h1>Cierre de Caja POS</h1>
        <p><?= htmlspecialchars($storeData['name'] ?? 'Tienda') ?> · Fecha <?= htmlspecialchars($date) ?></p>
    </div>
    <div class="content">
        <div class="kpis">
            <div class="kpi"><div class="label">Ventas</div><div class="value"><?= intval($summary['total_sales'] ?? 0) ?></div></div>
            <div class="kpi"><div class="label">Total vendido</div><div class="value">$<?= number_format(floatval($summary['gross_total'] ?? 0), 2) ?></div></div>
            <div class="kpi"><div class="label">Ticket promedio</div><div class="value">$<?= number_format(floatval($summary['average_ticket'] ?? 0), 2) ?></div></div>
            <div class="kpi"><div class="label">Última venta</div><div class="value" style="font-size:14px;"><?= !empty($summary['last_sale_at']) ? Helper::formatDate($summary['last_sale_at'], 'H:i') : '--:--' ?></div></div>
        </div>

        <div class="grid">
            <div class="box">
                <h3 class="title">Resumen por método de pago</h3>
                <div class="line"><span>Efectivo</span><strong>$<?= number_format(floatval($summary['cash_total'] ?? 0), 2) ?></strong></div>
                <div class="line"><span>Tarjeta</span><strong>$<?= number_format(floatval($summary['card_total'] ?? 0), 2) ?></strong></div>
                <div class="line"><span>Transferencia</span><strong>$<?= number_format(floatval($summary['transfer_total'] ?? 0), 2) ?></strong></div>
                <div class="line"><span>Mixto</span><strong>$<?= number_format(floatval($summary['mixed_total'] ?? 0), 2) ?></strong></div>
            </div>
            <div class="box">
                <h3 class="title">Datos de tienda</h3>
                <div class="line"><span>Tienda</span><strong><?= htmlspecialchars($storeData['name'] ?? 'N/A') ?></strong></div>
                <div class="line"><span>Correo</span><strong><?= htmlspecialchars($storeData['email'] ?? '-') ?></strong></div>
                <div class="line"><span>Teléfono</span><strong><?= htmlspecialchars($storeData['phone'] ?? '-') ?></strong></div>
                <div class="line"><span>Generado</span><strong><?= date('Y-m-d H:i') ?></strong></div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Orden</th>
                    <th>Cliente</th>
                    <th>Método</th>
                    <th>Hora</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;color:#64748b;">No hay ventas POS para esta fecha.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($orders as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['order_number']) ?></td>
                        <td><?= htmlspecialchars($row['customer_name']) ?></td>
                        <td><?= strtoupper(htmlspecialchars($row['payment_method'])) ?></td>
                        <td><?= Helper::formatDate($row['created_at'], 'H:i') ?></td>
                        <td class="text-right">$<?= number_format(floatval($row['total']), 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="actions">
            <a href="javascript:window.print()" class="btn primary">Imprimir cierre</a>
            <a href="<?= BASE_URL ?>admin/pos?date=<?= urlencode($date) ?>" class="btn">Volver al POS</a>
        </div>
    </div>
</div>
</body>
</html>
