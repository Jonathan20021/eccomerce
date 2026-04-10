<!-- SuperAdmin Licenses Content -->
<?php
$planNames  = ['Starter', 'Professional', 'Enterprise'];
$statusMap  = ['active'=>['badge-green','Activa'], 'expired'=>['badge-red','Expirada'], 'suspended'=>['badge-yellow','Suspendida'], 'cancelled'=>['badge-slate','Cancelada']];
?>

<style>
@media (max-width: 768px) {
    .licenses-store-banner {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .license-row-actions {
        flex-direction: column;
        align-items: stretch !important;
        min-width: 116px;
    }

    .license-row-actions form,
    .license-row-actions .btn {
        width: 100%;
    }

    .license-row-actions form {
        display: flex;
        gap: 6px;
    }

    .license-row-actions form input {
        flex: 1;
        min-width: 0;
    }
}
</style>

<div style="display:flex;flex-direction:column;gap:20px;">

    <?php if (!empty($_GET['store_id'])): ?>
    <div class="licenses-store-banner" style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:10px;">
        <p style="font-size:13.5px;color:#1d4ed8;font-weight:600;">Mostrando licencias de la tienda #<?= intval($_GET['store_id']) ?></p>
        <a href="<?= BASE_URL ?>superadmin/licenses" style="font-size:13px;font-weight:700;color:#1d4ed8;text-decoration:none;">Ver todas</a>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-check-circle" style="color:#16a34a;font-size:14px;flex-shrink:0;"></i>
        <p style="font-size:13.5px;color:#166534;font-weight:500;"><?= htmlspecialchars($_GET['success']) ?></p>
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
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Licencias</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;">Gestiona las licencias y módulos activos por plan</p>
        </div>
        <a href="<?= BASE_URL ?>superadmin/licenses/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Licencia
        </a>
    </div>

    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 14px;">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
            <i class="fas fa-table" style="color:#334155;font-size:13px;"></i>
            <strong style="font-size:13.5px;color:#1e293b;">Matriz de Módulos por Plan</strong>
        </div>
        <div class="overflow-x">
            <table style="width:100%;border-collapse:collapse;font-size:12.5px;">
                <thead>
                    <tr style="background:#ecfdf5;color:#166534;">
                        <th style="text-align:left;padding:8px;border:1px solid #c7d2fe;">Plan</th>
                        <th style="text-align:left;padding:8px;border:1px solid #c7d2fe;">Portal de Clientes</th>
                        <th style="text-align:left;padding:8px;border:1px solid #c7d2fe;">Inventario</th>
                        <th style="text-align:left;padding:8px;border:1px solid #c7d2fe;">Finanzas</th>
                        <th style="text-align:left;padding:8px;border:1px solid #c7d2fe;">Notas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding:8px;border:1px solid #e2e8f0;font-weight:700;color:#0f172a;">Starter</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#0f766e;">Incluido (perfil, direcciones, pedidos)</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#0f766e;">Incluido</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#b91c1c;">No incluido</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#475569;">Plan base para operaciones de stock y atención a clientes</td>
                    </tr>
                    <tr>
                        <td style="padding:8px;border:1px solid #e2e8f0;font-weight:700;color:#0f172a;">Professional</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#0f766e;">Incluido + checkout autocompletado</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#0f766e;">Incluido</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#0f766e;">Incluido</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#475569;">Análisis financiero y control operativo</td>
                    </tr>
                    <tr>
                        <td style="padding:8px;border:1px solid #e2e8f0;font-weight:700;color:#0f172a;">Enterprise</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#0f766e;">Incluido + experiencia personalizada</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#0f766e;">Incluido</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#0f766e;">Incluido</td>
                        <td style="padding:8px;border:1px solid #e2e8f0;color:#475569;">Módulos completos y escalables</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p style="margin-top:8px;font-size:12px;color:#64748b;">El portal de clientes está activo por defecto en todos los planes. Puedes sobrescribir inventario/finanzas por licencia desde la columna <strong>Módulos</strong>.</p>
    </div>

    <div class="table-card">
        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th class="col-hide-sm">Plan</th>
                        <th class="col-hide-sm">Espacio</th>
                        <th class="col-hide-sm">Módulos</th>
                        <th class="col-hide-sm">Tienda</th>
                        <th class="col-hide-xs">Tipo</th>
                        <th>Estado</th>
                        <th class="col-hide-sm">Creada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($licenses)):
                        foreach ($licenses as $license):
                            $sb = $statusMap[$license['status']] ?? ['badge-slate', ucfirst($license['status'])];
                    ?>
                    <tr>
                        <td>
                            <code style="font-size:12px;background:#f8fafc;color:#2a7a52;padding:3px 8px;border-radius:5px;border:1px solid #e2e8f0;font-family:monospace;">
                                <?= htmlspecialchars($license['code']) ?>
                            </code>
                        </td>
                        <td class="col-hide-sm">
                            <span style="font-size:13.5px;font-weight:600;color:#1e293b;">
                                <?= $planNames[($license['plan_id'] - 1)] ?? 'Plan ' . $license['plan_id'] ?>
                            </span>
                        </td>
                        <td class="col-hide-sm">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <span class="badge badge-blue" style="font-size:11px;"><?= number_format(floatval($license['storage_gb'] ?? 0), 1) ?> GB</span>
                            </div>
                        </td>
                        <td class="col-hide-sm">
                            <form method="POST" action="<?= BASE_URL ?>superadmin/licenses/modules/<?= intval($license['id']) ?>" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                <label style="display:flex;align-items:center;gap:4px;font-size:12px;color:#334155;">
                                    <input type="checkbox" name="module_inventory" <?= !empty($license['module_inventory']) ? 'checked' : '' ?> style="accent-color:#0ea5e9;">
                                    Inventario
                                </label>
                                <label style="display:flex;align-items:center;gap:4px;font-size:12px;color:#334155;">
                                    <input type="checkbox" name="module_finance" <?= !empty($license['module_finance']) ? 'checked' : '' ?> style="accent-color:#10b981;">
                                    Finanzas
                                </label>
                                <button type="submit" class="btn btn-sm btn-ghost" style="height:28px;padding:0 7px;">
                                    <i class="fas fa-save"></i>
                                </button>
                            </form>
                        </td>
                        <td class="col-hide-sm">
                            <?php if ($license['store_id']): ?>
                                <a href="<?= BASE_URL ?>superadmin/stores/<?= $license['store_id'] ?>"
                                   style="color:#2a7a52;font-size:13.5px;font-weight:600;text-decoration:none;">
                                    <i class="fas fa-store text-xs mr-1"></i> Tienda #<?= $license['store_id'] ?>
                                </a>
                            <?php else: ?>
                                <span style="color:#94a3b8;font-size:13px;font-style:italic;">Sin asignar</span>
                            <?php endif; ?>
                        </td>
                        <td class="col-hide-xs">
                            <span class="badge <?= $license['is_trial'] ? 'badge-yellow' : 'badge-blue' ?>">
                                <?= $license['is_trial'] ? 'Prueba' : 'Pago' ?>
                            </span>
                        </td>
                        <td><span class="badge <?= $sb[0] ?>"><?= $sb[1] ?></span></td>
                        <td class="col-hide-sm"><span style="font-size:13px;color:#64748b;"><?= Helper::formatDate($license['created_at']) ?></span></td>
                        <td>
                            <div class="license-row-actions" style="display:flex;align-items:center;gap:6px;">
                                <form method="POST" action="<?= BASE_URL ?>superadmin/licenses/storage/<?= intval($license['id']) ?>" style="display:flex;align-items:center;gap:4px;">
                                    <input type="number" name="storage_gb" min="1" step="0.5" value="<?= number_format(floatval($license['storage_gb'] ?? 0), 1, '.', '') ?>"
                                           style="width:78px;height:30px;border:1px solid #e2e8f0;border-radius:6px;padding:0 8px;font-size:12px;color:#1e293b;">
                                    <button type="submit" class="btn btn-sm btn-ghost" style="height:30px;padding:0 8px;">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>

                                <button class="btn btn-danger btn-sm"
                                        onclick="if(confirm('¿Eliminar esta licencia?')) deleteRecord(<?= $license['id'] ?>)"
                                        style="border:none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-certificate"></i></div>
                                <h3>No hay licencias aún</h3>
                                <p>Crea licencias para asignarlas a las tiendas.</p>
                                <a href="<?= BASE_URL ?>superadmin/licenses/create" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Crear Licencia
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function deleteRecord(id) {
    window.location.href = '<?= BASE_URL ?>superadmin/licenses/delete/' + id;
}
</script>
