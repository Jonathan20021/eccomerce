<?php
$planNames = ['Starter', 'Professional', 'Enterprise'];
$planLabel = $planNames[intval($storeData['plan_id'] ?? 1) - 1] ?? ('Plan ' . intval($storeData['plan_id'] ?? 1));
$isActive = !empty($storeData['is_active']);
$storePublicUrl = BASE_URL . 'shop/' . ($storeData['slug'] ?? '');
?>

<div style="display:flex;flex-direction:column;gap:20px;">

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

    <div class="page-header" style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;flex-wrap:wrap;">
        <div>
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;margin-bottom:4px;">Detalle de Tienda</h2>
            <p style="font-size:13.5px;color:#64748b;">Revisa informacion general, propietario y usuarios asociados.</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end;">
            <a href="<?= BASE_URL ?>superadmin/licenses?store_id=<?= intval($storeData['id'] ?? 0) ?>" class="btn btn-ghost">
                <i class="fas fa-certificate"></i> Ver licencia
            </a>
            <a href="<?= BASE_URL ?>superadmin/stores/toggle/<?= intval($storeData['id'] ?? 0) ?>" class="btn btn-ghost">
                <i class="fas fa-power-off"></i> <?= $isActive ? 'Inactivar' : 'Activar' ?>
            </a>
            <a href="<?= BASE_URL ?>superadmin/stores" class="btn btn-ghost">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="<?= htmlspecialchars($storePublicUrl) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                <i class="fas fa-external-link-alt"></i> Ver tienda
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDeleteStore(<?= intval($storeData['id'] ?? 0) ?>)">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;" class="max-lg:grid-cols-1">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-store" style="margin-right:7px;color:#4f46e5;"></i>Informacion General</h3>
            </div>
            <div class="card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;" class="max-md:grid-cols-1">
                <div>
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Nombre</div>
                    <div style="font-size:14px;color:#1e293b;font-weight:700;margin-top:3px;"><?= htmlspecialchars($storeData['name'] ?? '') ?></div>
                </div>
                <div>
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Slug</div>
                    <div style="font-size:14px;color:#1e293b;font-weight:700;margin-top:3px;"><?= htmlspecialchars($storeData['slug'] ?? '') ?></div>
                </div>
                <div>
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Plan</div>
                    <div style="font-size:14px;color:#1e293b;font-weight:700;margin-top:3px;"><?= htmlspecialchars($planLabel) ?></div>
                </div>
                <div>
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Estado</div>
                    <div style="margin-top:4px;">
                        <span class="badge <?= $isActive ? 'badge-green' : 'badge-red' ?>"><?= $isActive ? 'Activa' : 'Inactiva' ?></span>
                    </div>
                </div>
                <div>
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Email</div>
                    <div style="font-size:14px;color:#1e293b;margin-top:3px;"><?= htmlspecialchars($storeData['email'] ?? '-') ?></div>
                </div>
                <div>
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Telefono</div>
                    <div style="font-size:14px;color:#1e293b;margin-top:3px;"><?= htmlspecialchars($storeData['phone'] ?? '-') ?></div>
                </div>
                <div style="grid-column:1 / -1;">
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Descripcion</div>
                    <div style="font-size:14px;color:#334155;margin-top:4px;line-height:1.7;"><?= htmlspecialchars($storeData['description'] ?? 'Sin descripcion') ?></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-link" style="margin-right:7px;color:#0ea5e9;"></i>Resumen tecnico</h3>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                <div>
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Store ID</div>
                    <div style="font-size:15px;color:#1e293b;font-weight:700;margin-top:3px;">#<?= intval($storeData['id'] ?? 0) ?></div>
                </div>
                <div>
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Owner ID</div>
                    <div style="font-size:15px;color:#1e293b;font-weight:700;margin-top:3px;">#<?= intval($storeData['owner_id'] ?? 0) ?></div>
                </div>
                <div>
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">License ID</div>
                    <div style="font-size:15px;color:#1e293b;font-weight:700;margin-top:3px;"><?= !empty($storeData['license_id']) ? ('#' . intval($storeData['license_id'])) : 'Sin licencia' ?></div>
                </div>
                <div>
                    <div style="font-size:12px;color:#94a3b8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Creada</div>
                    <div style="font-size:13px;color:#334155;margin-top:3px;"><?= !empty($storeData['created_at']) ? htmlspecialchars(Helper::formatDate($storeData['created_at'])) : '-' ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fas fa-users" style="margin-right:7px;color:#7c3aed;"></i>Usuarios asociados</h3>
        </div>
        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Activo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($storeUsers)): ?>
                        <?php foreach ($storeUsers as $u): ?>
                        <tr>
                            <td>#<?= intval($u['id']) ?></td>
                            <td><?= htmlspecialchars($u['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($u['email'] ?? '') ?></td>
                            <td><span class="badge badge-indigo"><?= htmlspecialchars($u['role'] ?? '') ?></span></td>
                            <td>
                                <span class="badge <?= !empty($u['is_active']) ? 'badge-green' : 'badge-red' ?>">
                                    <?= !empty($u['is_active']) ? 'Si' : 'No' ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center;padding:34px;color:#94a3b8;">No hay usuarios asociados a esta tienda.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
function confirmDeleteStore(storeId) {
    if (!storeId) return;
    if (confirm('Esta accion eliminara la tienda y su informacion relacionada. ¿Deseas continuar?')) {
        window.location.href = '<?= BASE_URL ?>superadmin/stores/delete/' + storeId;
    }
}
</script>
