<?php
$roleLabels = [
    ROLE_SUPERADMIN => 'SuperAdmin',
    ROLE_STORE_OWNER => 'Propietario',
    ROLE_STORE_STAFF => 'Staff',
    ROLE_CUSTOMER => 'Cliente'
];
$currentPage = max(1, intval($page ?? 1));
$currentRole = $roleFilter ?? '';
$currentSearch = $searchFilter ?? '';
$currentStore = intval($storeFilterId ?? 0);
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
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Usuarios de la Plataforma</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;">Administra todos los usuarios y su relación con cada tienda.</p>
        </div>
        <a href="<?= BASE_URL ?>superadmin/users/create-superadmin" class="btn btn-primary">
            <i class="fas fa-user-shield"></i> Nuevo SuperAdmin
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="<?= BASE_URL ?>superadmin/users" class="form-grid-2" style="gap:12px;align-items:end;">
                <div>
                    <label class="form-label">Buscar usuario</label>
                    <input type="text" name="q" value="<?= htmlspecialchars($currentSearch) ?>" class="form-input" placeholder="Nombre o email">
                </div>
                <div>
                    <label class="form-label">Rol</label>
                    <select name="role" class="form-input">
                        <option value="">Todos</option>
                        <?php foreach ($roleLabels as $roleValue => $roleText): ?>
                            <option value="<?= $roleValue ?>" <?= $currentRole === $roleValue ? 'selected' : '' ?>>
                                <?= $roleText ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Tienda</label>
                    <select name="store_id" class="form-input">
                        <option value="0">Todas</option>
                        <?php foreach ($stores as $s): ?>
                            <option value="<?= intval($s['id']) ?>" <?= intval($currentStore) === intval($s['id']) ? 'selected' : '' ?>>
                                #<?= intval($s['id']) ?> - <?= htmlspecialchars($s['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="display:flex;gap:8px;">
                    <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="<?= BASE_URL ?>superadmin/users" class="btn btn-ghost" style="flex:1;justify-content:center;">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fas fa-users" style="margin-right:7px;color:#d4973a;"></i><?= intval($totalUsers ?? 0) ?> usuarios encontrados</h3>
        </div>
        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="col-hide-sm">ID</th>
                        <th>Usuario</th>
                        <th class="col-hide-sm">Tienda</th>
                        <th class="col-hide-xs">Rol</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $u): ?>
                        <?php
                            $uid = intval($u['id']);
                            $isSelf = intval($_SESSION['user_id'] ?? 0) === $uid;
                            $roleValue = strval($u['role'] ?? '');
                            $isActive = !empty($u['is_active']);
                            $storeValue = intval($u['store_id'] ?? 0);
                        ?>
                        <tr>
                            <td class="col-hide-sm">#<?= $uid ?></td>
                            <td>
                                <div style="display:flex;flex-direction:column;gap:2px;">
                                    <span style="font-weight:700;color:#1e293b;"><?= htmlspecialchars($u['name'] ?? '') ?><?= $isSelf ? ' (Tú)' : '' ?></span>
                                    <span style="font-size:12.5px;color:#64748b;"><?= htmlspecialchars($u['email'] ?? '') ?></span>
                                </div>
                            </td>
                            <td class="col-hide-sm">
                                <?php if (!empty($u['store_id'])): ?>
                                    <a href="<?= BASE_URL ?>superadmin/stores/<?= intval($u['store_id']) ?>" style="font-size:13px;color:#2a7a52;font-weight:600;text-decoration:none;">
                                        #<?= intval($u['store_id']) ?> - <?= htmlspecialchars($u['store_name'] ?? 'Tienda') ?>
                                    </a>
                                <?php else: ?>
                                    <span style="color:#94a3b8;font-size:12.5px;">Sin tienda</span>
                                <?php endif; ?>
                            </td>
                            <td class="col-hide-xs">
                                <span class="badge badge-indigo"><?= htmlspecialchars($roleLabels[$roleValue] ?? $roleValue) ?></span>
                            </td>
                            <td>
                                <span class="badge <?= $isActive ? 'badge-green' : 'badge-red' ?>"><?= $isActive ? 'Sí' : 'No' ?></span>
                            </td>
                            <td>
                                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                    <button type="button" class="btn btn-ghost btn-sm" onclick="toggleEditRow(<?= $uid ?>)">
                                        <i class="fas fa-pen"></i> Editar
                                    </button>
                                    <?php if (!$isSelf): ?>
                                    <a href="<?= BASE_URL ?>superadmin/users/toggle/<?= $uid ?>" class="btn btn-ghost btn-sm">
                                        <i class="fas <?= $isActive ? 'fa-user-slash' : 'fa-user-check' ?>"></i> <?= $isActive ? 'Inactivar' : 'Activar' ?>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteUser(<?= $uid ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <tr id="edit-user-row-<?= $uid ?>" style="display:none;background:#f8fafc;">
                            <td colspan="6" style="padding:14px;">
                                <form action="<?= BASE_URL ?>superadmin/users/update/<?= $uid ?>" method="POST" class="form-grid-2" style="gap:12px;">
                                    <div>
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="name" required class="form-input" value="<?= htmlspecialchars($u['name'] ?? '') ?>">
                                    </div>
                                    <div>
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" required class="form-input" value="<?= htmlspecialchars($u['email'] ?? '') ?>">
                                    </div>
                                    <div>
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" name="phone" class="form-input" value="<?= htmlspecialchars($u['phone'] ?? '') ?>">
                                    </div>
                                    <div>
                                        <label class="form-label">Rol</label>
                                        <select name="role" class="form-input js-role-select" data-user="<?= $uid ?>">
                                            <?php foreach ($roleLabels as $roleOption => $labelOption): ?>
                                            <option value="<?= $roleOption ?>" <?= $roleValue === $roleOption ? 'selected' : '' ?>><?= $labelOption ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="js-store-wrapper" data-user="<?= $uid ?>" style="<?= $roleValue === ROLE_SUPERADMIN ? 'display:none;' : '' ?>">
                                        <label class="form-label">Tienda</label>
                                        <select name="store_id" class="form-input">
                                            <option value="0">Selecciona tienda</option>
                                            <?php foreach ($stores as $s): ?>
                                            <option value="<?= intval($s['id']) ?>" <?= $storeValue === intval($s['id']) ? 'selected' : '' ?>>
                                                #<?= intval($s['id']) ?> - <?= htmlspecialchars($s['name']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label">Nueva contraseña (opcional)</label>
                                        <input type="password" name="new_password" minlength="8" class="form-input" placeholder="Dejar vacío para mantener">
                                    </div>

                                    <div style="grid-column:1 / -1;display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;">
                                        <label style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:#334155;font-weight:600;">
                                            <input type="checkbox" name="is_active" value="1" <?= $isActive ? 'checked' : '' ?>> Cuenta activa
                                        </label>
                                        <div style="display:flex;gap:8px;">
                                            <button type="button" class="btn btn-ghost" onclick="toggleEditRow(<?= $uid ?>)">Cancelar</button>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar cambios</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align:center;padding:34px;color:#94a3b8;">No se encontraron usuarios con los filtros seleccionados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (($totalPages ?? 1) > 1): ?>
    <?php
        $queryParams = $_GET;
    ?>
    <div style="display:flex;justify-content:flex-end;gap:8px;align-items:center;flex-wrap:wrap;">
        <?php for ($p = 1; $p <= intval($totalPages); $p++): ?>
            <?php $queryParams['page'] = $p; ?>
            <a href="<?= BASE_URL ?>superadmin/users?<?= htmlspecialchars(http_build_query($queryParams)) ?>"
               class="btn <?= $p === $currentPage ? 'btn-primary' : 'btn-ghost' ?> btn-sm"
               style="min-width:36px;justify-content:center;">
                <?= $p ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

</div>

<script>
function toggleEditRow(userId) {
    const row = document.getElementById('edit-user-row-' + userId);
    if (!row) return;
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}

function confirmDeleteUser(userId) {
    if (!userId) return;
    if (confirm('Esta acción eliminará el usuario. ¿Deseas continuar?')) {
        window.location.href = '<?= BASE_URL ?>superadmin/users/delete/' + userId;
    }
}

document.querySelectorAll('.js-role-select').forEach(function(select) {
    select.addEventListener('change', function() {
        const userId = select.dataset.user;
        const storeWrap = document.querySelector('.js-store-wrapper[data-user="' + userId + '"]');
        if (!storeWrap) return;
        if (select.value === '<?= ROLE_SUPERADMIN ?>') {
            storeWrap.style.display = 'none';
        } else {
            storeWrap.style.display = '';
        }
    });
});
</script>
