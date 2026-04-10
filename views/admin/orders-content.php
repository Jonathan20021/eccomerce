<!-- Admin Orders Content -->
<?php
$statusBadge = [
    'pending'    => ['badge-yellow', 'Pendiente'],
    'confirmed'  => ['badge-blue',   'Confirmada'],
    'processing' => ['badge-purple', 'Procesando'],
    'shipped'    => ['badge-indigo', 'Enviada'],
    'delivered'  => ['badge-green',  'Entregada'],
    'cancelled'  => ['badge-red',    'Cancelada'],
];
$paymentBadge = [
    'pending' => ['badge-yellow', 'Pendiente'],
    'paid'    => ['badge-green',  'Pagada'],
    'failed'  => ['badge-red',    'Fallida'],
];
?>
<div style="display:flex;flex-direction:column;gap:20px;">

    <div class="page-header">
        <div>
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Órdenes</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;">Gestiona las órdenes de tu tienda</p>
        </div>
    </div>

    <?php if (empty($orders)): ?>
    <div class="table-card">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-shopping-bag"></i></div>
            <h3>Aún no tienes órdenes</h3>
            <p>Las órdenes de tus clientes aparecerán aquí cuando realicen una compra.</p>
            <?php if (isset($storeData)): ?>
            <a href="<?= BASE_URL ?>shop/<?= $storeData['slug'] ?>" target="_blank" class="btn btn-primary btn-sm">
                <i class="fas fa-external-link-alt"></i> Ver mi tienda
            </a>
            <?php endif; ?>
        </div>
    </div>

    <?php else: ?>
    <div class="table-card">
        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th class="col-hide-sm">Pago</th>
                        <th class="col-hide-sm">Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order):
                        $sb = $statusBadge[$order['status']] ?? ['badge-slate', ucfirst($order['status'])];
                        $pb = $paymentBadge[$order['payment_status']] ?? ['badge-slate', ucfirst($order['payment_status'])];
                    ?>
                    <tr>
                        <td>
                            <span class="order-num-cell">
                                <?= htmlspecialchars($order['order_number']) ?>
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;flex-direction:column;">
                                <span style="font-size:13.5px;font-weight:600;color:#1e293b;"><?= htmlspecialchars($order['customer_name']) ?></span>
                                <span style="font-size:12px;color:#94a3b8;"><?= htmlspecialchars($order['customer_email']) ?></span>
                            </div>
                        </td>
                        <td>
                            <span style="font-size:14px;font-weight:700;color:#1e293b;">$<?= number_format($order['total'], 2) ?></span>
                        </td>
                        <td><span class="badge <?= $sb[0] ?>"><?= $sb[1] ?></span></td>
                        <td class="col-hide-sm"><span class="badge <?= $pb[0] ?>"><?= $pb[1] ?></span></td>
                        <td class="col-hide-sm"><span style="font-size:13px;color:#64748b;"><?= Helper::formatDate($order['created_at']) ?></span></td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                <a href="<?= BASE_URL ?>admin/orders/<?= $order['id'] ?>" class="btn btn-ghost btn-sm">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="<?= BASE_URL ?>admin/orders/<?= $order['id'] ?>/invoice/online" target="_blank" class="btn btn-ghost btn-sm">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>admin/orders?page=<?= $i ?>"
               class="page-item <?= $i == $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>

</div>
