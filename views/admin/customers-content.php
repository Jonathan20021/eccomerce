<?php
$searchQuery = trim((string)($_GET['q'] ?? ''));
?>
<div style="display:flex;flex-direction:column;gap:20px;">

    <?php if (isset($_GET['success'])): ?>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-check-circle" style="color:#16a34a;font-size:14px;flex-shrink:0;"></i>
        <div style="display:flex;flex-direction:column;gap:4px;">
            <p style="font-size:13.5px;color:#166534;font-weight:500;"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php if (isset($_GET['generated_password']) && trim((string)$_GET['generated_password']) !== ''): ?>
            <p style="font-size:12.5px;color:#166534;">
                Contraseña temporal: <code style="background:#ecfdf5;border:1px solid #bbf7d0;border-radius:6px;padding:2px 7px;font-size:12px;color:#14532d;"><?= htmlspecialchars($_GET['generated_password']) ?></code>
            </p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-exclamation-circle" style="color:#dc2626;font-size:14px;flex-shrink:0;"></i>
        <p style="font-size:13.5px;color:#b91c1c;font-weight:500;"><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
    <?php endif; ?>

    <div class="page-header">
        <div>
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Clientes Registrados</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;">Visualiza tus clientes por tienda y monitorea su actividad de compra.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-plus" style="color:#2a7a52;margin-right:8px;"></i>Crear cliente manualmente</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= BASE_URL ?>admin/customers" class="form-grid-2" style="gap:12px;align-items:end;">
                <div>
                    <label class="form-label">Nombre <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" required class="form-input" placeholder="Nombre del cliente">
                </div>
                <div>
                    <label class="form-label">Email <span style="color:#ef4444;">*</span></label>
                    <input type="email" name="email" required class="form-input" placeholder="cliente@correo.com">
                </div>
                <div>
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-input" placeholder="809-000-0000">
                </div>
                <div>
                    <label class="form-label">Contraseña inicial <span style="color:#ef4444;">*</span></label>
                    <input type="password" id="customer_password" name="password" minlength="6" class="form-input" placeholder="Mínimo 6 caracteres">
                </div>
                <div style="grid-column:1/-1;display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
                        <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#475569;cursor:pointer;">
                            <input type="checkbox" id="auto_password" name="auto_password" value="1" checked style="width:16px;height:16px;accent-color:#2563eb;cursor:pointer;">
                            Generar contraseña temporal automáticamente
                        </label>
                        <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#475569;cursor:pointer;">
                        <input type="checkbox" name="is_active" checked style="width:16px;height:16px;accent-color:#2a7a52;cursor:pointer;">
                        Crear cliente como activo
                    </label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Crear cliente
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;">
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:14px;">
            <p style="font-size:12px;color:#94a3b8;margin-bottom:6px;">Total clientes</p>
            <p style="font-size:24px;font-weight:800;color:#1e293b;"><?= intval($totalCustomers ?? 0) ?></p>
        </div>
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:14px;">
            <p style="font-size:12px;color:#94a3b8;margin-bottom:6px;">Clientes activos</p>
            <p style="font-size:24px;font-weight:800;color:#0f766e;"><?= intval($activeCustomers ?? 0) ?></p>
        </div>
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:14px;">
            <p style="font-size:12px;color:#94a3b8;margin-bottom:6px;">Con al menos 1 pedido</p>
            <p style="font-size:24px;font-weight:800;color:#2563eb;"><?= intval($customersWithOrders ?? 0) ?></p>
        </div>
    </div>

    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:12px;">
        <form method="GET" action="<?= BASE_URL ?>admin/customers" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
            <input type="search" name="q" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Buscar por nombre, email o teléfono"
                   style="flex:1;min-width:220px;height:38px;border:1px solid #e2e8f0;border-radius:8px;padding:0 12px;font-size:13px;color:#1e293b;">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>
            <?php if ($searchQuery !== ''): ?>
            <a href="<?= BASE_URL ?>admin/customers" class="btn btn-ghost btn-sm"><i class="fas fa-times"></i> Limpiar</a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (empty($customers)): ?>
    <div class="table-card">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-users"></i></div>
            <h3>No hay clientes aún</h3>
            <p>Los clientes que se registren o compren en tu tienda aparecerán aquí.</p>
        </div>
    </div>
    <?php else: ?>
    <div class="table-card">
        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th class="col-hide-sm">Teléfono</th>
                        <th>Pedidos</th>
                        <th class="col-hide-sm">Total gastado</th>
                        <th class="col-hide-sm">Último pedido</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td>
                            <div style="display:flex;flex-direction:column;">
                                <span style="font-size:13.5px;font-weight:600;color:#1e293b;"><?= htmlspecialchars($customer['name'] ?? 'Cliente') ?></span>
                                <span style="font-size:12px;color:#94a3b8;"><?= htmlspecialchars($customer['email'] ?? '') ?></span>
                            </div>
                        </td>
                        <td class="col-hide-sm"><span style="font-size:13px;color:#475569;"><?= htmlspecialchars($customer['phone'] ?: '-') ?></span></td>
                        <td><span style="font-size:14px;font-weight:700;color:#1e293b;"><?= intval($customer['orders_count'] ?? 0) ?></span></td>
                        <td class="col-hide-sm"><span style="font-size:13.5px;font-weight:700;color:#0f766e;">$<?= number_format(floatval($customer['total_spent'] ?? 0), 2) ?></span></td>
                        <td class="col-hide-sm"><span style="font-size:13px;color:#64748b;"><?= !empty($customer['last_order_at']) ? Helper::formatDate($customer['last_order_at']) : 'Sin pedidos' ?></span></td>
                        <td>
                            <span class="badge <?= !empty($customer['is_active']) ? 'badge-green' : 'badge-red' ?>">
                                <?= !empty($customer['is_active']) ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>admin/customers/<?= intval($customer['id']) ?>" class="btn btn-ghost btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (($totalPages ?? 1) > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>admin/customers?page=<?= $i ?><?= $searchQuery !== '' ? '&q=' . urlencode($searchQuery) : '' ?>"
               class="page-item <?= $i == intval($page ?? 1) ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

    <?php endif; ?>
</div>

<script>
(function() {
    var auto = document.getElementById('auto_password');
    var input = document.getElementById('customer_password');
    if (!auto || !input) return;

    function syncPasswordField() {
        if (auto.checked) {
            input.value = '';
            input.required = false;
            input.disabled = true;
            input.placeholder = 'Se generará automáticamente';
            input.style.background = '#f8fafc';
            input.style.cursor = 'not-allowed';
        } else {
            input.required = true;
            input.disabled = false;
            input.placeholder = 'Mínimo 6 caracteres';
            input.style.background = '#fff';
            input.style.cursor = 'text';
        }
    }

    auto.addEventListener('change', syncPasswordField);
    syncPasswordField();
})();
</script>
