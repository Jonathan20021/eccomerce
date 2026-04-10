<?php
$statusLabel = [
    'pending' => 'Pendiente',
    'confirmed' => 'Confirmada',
    'processing' => 'Procesando',
    'shipped' => 'Enviada',
    'delivered' => 'Entregada',
    'cancelled' => 'Cancelada'
];
$maxDaily = 1;
foreach ($dailyRevenue as $value) {
    if ($value > $maxDaily) {
        $maxDaily = $value;
    }
}
?>
<div style="display:flex;flex-direction:column;gap:20px;">

    <div class="stat-cards-grid-auto">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-money-bill-trend-up"></i></div>
            <div>
                <div class="stat-label">Ingresos Totales</div>
                <div class="stat-value"><?= Helper::formatPrice($totalRevenue, $storeData['currency'] ?? 'USD') ?></div>
                <div class="stat-meta">sin órdenes canceladas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon indigo"><i class="fas fa-calendar-days"></i></div>
            <div>
                <div class="stat-label">Ingresos del Mes</div>
                <div class="stat-value"><?= Helper::formatPrice($monthlyRevenue, $storeData['currency'] ?? 'USD') ?></div>
                <div class="stat-meta">mes actual</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-ticket"></i></div>
            <div>
                <div class="stat-label">Ticket Promedio</div>
                <div class="stat-value"><?= Helper::formatPrice($averageTicket, $storeData['currency'] ?? 'USD') ?></div>
                <div class="stat-meta">promedio por orden</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="stat-label">Pendiente por Cobrar</div>
                <div class="stat-value"><?= Helper::formatPrice($pendingRevenue, $storeData['currency'] ?? 'USD') ?></div>
                <div class="stat-meta">órdenes pendientes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-ban"></i></div>
            <div>
                <div class="stat-label">Cancelado</div>
                <div class="stat-value"><?= Helper::formatPrice($cancelledRevenue, $storeData['currency'] ?? 'USD') ?></div>
                <div class="stat-meta">monto en cancelaciones</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-calendar-day"></i></div>
            <div>
                <div class="stat-label">Hoy</div>
                <div class="stat-value"><?= Helper::formatPrice($todayRevenue, $storeData['currency'] ?? 'USD') ?></div>
                <div class="stat-meta">ventas de hoy</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-chart-column" style="color:#0f766e;margin-right:7px;"></i>Ingresos últimos 7 días</h3>
        </div>
        <div class="card-body finance-bar-chart" style="display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:10px;align-items:end;min-height:180px;">
            <?php foreach ($dailyRevenue as $day => $amount):
                $height = intval(($amount / $maxDaily) * 120);
            ?>
            <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                <div style="height:120px;display:flex;align-items:flex-end;">
                    <div title="<?= htmlspecialchars($day) ?>: <?= Helper::formatPrice($amount, $storeData['currency'] ?? 'USD') ?>"
                         style="width:24px;height:<?= max(4, $height) ?>px;background:linear-gradient(180deg,#14b8a6,#0f766e);border-radius:6px 6px 2px 2px;"></div>
                </div>
                <div style="font-size:11px;color:#64748b;"><?= date('d/m', strtotime($day)) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="admin-grid-form-table" style="grid-template-columns:1fr 2fr;">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-layer-group" style="color:#334155;margin-right:7px;"></i>Órdenes por Estado</h3>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                <?php if (empty($statusCounts)): ?>
                <p style="font-size:13px;color:#64748b;">Aún no hay órdenes.</p>
                <?php else: ?>
                <?php foreach ($statusCounts as $status => $count): ?>
                <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px dashed #e2e8f0;padding-bottom:7px;">
                    <span style="font-size:13px;color:#334155;"><?= htmlspecialchars($statusLabel[$status] ?? ucfirst($status)) ?></span>
                    <span class="badge badge-blue"><?= intval($count) ?></span>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <h3><i class="fas fa-receipt" style="color:#475569;margin-right:7px;"></i>Movimientos recientes</h3>
            </div>
            <?php if (empty($recentFinanceOrders)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <h3>Sin movimientos todavía</h3>
                <p>Cuando entren órdenes, las verás aquí.</p>
            </div>
            <?php else: ?>
            <div class="overflow-x">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Orden</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentFinanceOrders as $row): ?>
                        <tr>
                            <td><strong style="font-size:12.5px;color:#4f46e5;"><?= htmlspecialchars($row['order_number']) ?></strong></td>
                            <td><?= htmlspecialchars($row['customer_name']) ?></td>
                            <td><span class="badge badge-slate"><?= htmlspecialchars($statusLabel[$row['status']] ?? ucfirst($row['status'])) ?></span></td>
                            <td><strong><?= Helper::formatPrice($row['total'], $storeData['currency'] ?? 'USD') ?></strong></td>
                            <td><?= Helper::formatDate($row['created_at']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
