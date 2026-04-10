<?php
$statusBadge = [
    'pending'    => ['badge-yellow', 'Pendiente'],
    'confirmed'  => ['badge-blue',   'Confirmada'],
    'processing' => ['badge-purple', 'Procesando'],
    'shipped'    => ['badge-indigo', 'Enviada'],
    'delivered'  => ['badge-green',  'Entregada'],
    'cancelled'  => ['badge-red',    'Cancelada'],
];
?>
<div style="display:flex;flex-direction:column;gap:20px;">

    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <a href="<?= BASE_URL ?>admin/customers"
                   style="color:#94a3b8;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:4px;"
                   onmouseover="this.style.color='#64748b'" onmouseout="this.style.color='#94a3b8'">
                    <i class="fas fa-arrow-left text-xs"></i> Clientes
                </a>
            </div>
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Detalle del Cliente</h2>
            <p style="font-size:13px;color:#64748b;margin-top:4px;"><?= htmlspecialchars($customerData['name'] ?? '') ?> · <?= htmlspecialchars($customerData['email'] ?? '') ?></p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:12px;">
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:14px;">
            <p style="font-size:12px;color:#94a3b8;margin-bottom:6px;">Pedidos totales</p>
            <p style="font-size:24px;font-weight:800;color:#1e293b;"><?= intval($totalOrders ?? 0) ?></p>
        </div>
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:14px;">
            <p style="font-size:12px;color:#94a3b8;margin-bottom:6px;">Pendientes</p>
            <p style="font-size:24px;font-weight:800;color:#d97706;"><?= intval($pendingOrders ?? 0) ?></p>
        </div>
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:14px;">
            <p style="font-size:12px;color:#94a3b8;margin-bottom:6px;">Total gastado</p>
            <p style="font-size:24px;font-weight:800;color:#0f766e;">$<?= number_format(floatval($totalSpent ?? 0), 2) ?></p>
        </div>
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:14px;">
            <p style="font-size:12px;color:#94a3b8;margin-bottom:6px;">Último pedido</p>
            <p style="font-size:13.5px;font-weight:700;color:#1e293b;"><?= !empty($lastOrderAt) ? Helper::formatDate($lastOrderAt) : 'Sin pedidos' ?></p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:start;">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-user" style="color:#4f46e5;margin-right:8px;"></i>Datos del cliente</h3>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                <p style="font-size:13px;color:#64748b;"><strong style="color:#1e293b;">Nombre:</strong> <?= htmlspecialchars($customerData['name'] ?? '') ?></p>
                <p style="font-size:13px;color:#64748b;"><strong style="color:#1e293b;">Email:</strong> <?= htmlspecialchars($customerData['email'] ?? '') ?></p>
                <p style="font-size:13px;color:#64748b;"><strong style="color:#1e293b;">Teléfono:</strong> <?= htmlspecialchars(($customerData['phone'] ?? '') ?: '-') ?></p>
                <p style="font-size:13px;color:#64748b;"><strong style="color:#1e293b;">Registro:</strong> <?= !empty($customerData['created_at']) ? Helper::formatDate($customerData['created_at']) : '-' ?></p>
                <p style="font-size:13px;color:#64748b;"><strong style="color:#1e293b;">Estado:</strong>
                    <span class="badge <?= !empty($customerData['is_active']) ? 'badge-green' : 'badge-red' ?>">
                        <?= !empty($customerData['is_active']) ? 'Activo' : 'Inactivo' ?>
                    </span>
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-map-marker-alt" style="color:#16a34a;margin-right:8px;"></i>Direcciones</h3>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                <?php if (empty($addresses)): ?>
                    <p style="font-size:13px;color:#64748b;">Este cliente no tiene direcciones registradas.</p>
                <?php else: ?>
                    <?php foreach ($addresses as $addr): ?>
                    <div style="border:1px solid #e2e8f0;border-radius:8px;padding:10px;">
                        <p style="font-size:12px;font-weight:700;color:#1e293b;margin-bottom:4px;">
                            <?= htmlspecialchars($addr['label'] ?: 'Dirección') ?>
                            <?php if (!empty($addr['is_default'])): ?>
                                <span class="badge badge-green" style="margin-left:6px;">Predeterminada</span>
                            <?php endif; ?>
                        </p>
                        <p style="font-size:12px;color:#64748b;"><?= htmlspecialchars($addr['recipient_name'] ?? '') ?></p>
                        <p style="font-size:12px;color:#475569;"><?= htmlspecialchars($addr['address_line'] ?? '') ?></p>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fas fa-shopping-bag" style="color:#334155;margin-right:8px;"></i>Monitoreo de pedidos del cliente</h3>
        </div>

        <?php if (empty($orders)): ?>
            <div class="empty-state" style="padding-top:24px;padding-bottom:24px;">
                <div class="empty-icon"><i class="fas fa-receipt"></i></div>
                <h3>Sin pedidos registrados</h3>
                <p>Cuando este cliente compre, sus pedidos aparecerán aquí.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Número</th>
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
                            $pb = ($order['payment_status'] ?? 'pending') === 'paid' ? ['badge-green', 'Pagada'] : (($order['payment_status'] ?? 'pending') === 'failed' ? ['badge-red', 'Fallida'] : ['badge-yellow', 'Pendiente']);
                        ?>
                        <tr>
                            <td><span class="order-num-cell"><?= htmlspecialchars($order['order_number']) ?></span></td>
                            <td><span style="font-size:13.5px;font-weight:700;color:#1e293b;">$<?= number_format(floatval($order['total'] ?? 0), 2) ?></span></td>
                            <td><span class="badge <?= $sb[0] ?>"><?= $sb[1] ?></span></td>
                            <td class="col-hide-sm"><span class="badge <?= $pb[0] ?>"><?= $pb[1] ?></span></td>
                            <td class="col-hide-sm"><span style="font-size:13px;color:#64748b;"><?= Helper::formatDate($order['created_at']) ?></span></td>
                            <td>
                                <a href="<?= BASE_URL ?>admin/orders/<?= intval($order['id']) ?>" class="btn btn-ghost btn-sm">
                                    <i class="fas fa-eye"></i> Ver orden
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
