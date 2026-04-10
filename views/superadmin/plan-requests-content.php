<?php
$planNames = [1 => 'Starter', 2 => 'Professional', 3 => 'Enterprise'];
$currentStatus = strval($status ?? '');
$currentPage = max(1, intval($page ?? 1));
?>

<style>
.plan-request-filter {
    display:flex;
    align-items:center;
    gap:8px;
    flex-wrap:wrap;
}

.plan-request-actions {
    display:flex;
    flex-direction:column;
    gap:6px;
    min-width:210px;
}

.plan-request-actions form {
    display:flex;
    gap:6px;
}

@media (max-width: 768px) {
    .plan-request-filter {
        width:100%;
    }

    .plan-request-filter .form-input,
    .plan-request-filter .btn {
        width:100%;
    }

    .plan-request-actions {
        min-width:180px;
    }

    .plan-request-actions form {
        flex-direction:column;
    }

    .plan-request-actions form .btn {
        width:100%;
        justify-content:center;
    }
}
</style>

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

    <div class="page-header" style="display:flex;justify-content:space-between;align-items:flex-end;gap:12px;flex-wrap:wrap;">
        <div>
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Solicitudes de Cambio de Plan</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;">Revisa y decide cambios de plan solicitados por las tiendas.</p>
        </div>

        <form method="GET" action="<?= BASE_URL ?>superadmin/plan-requests" class="plan-request-filter">
            <select name="status" class="form-input" style="height:38px;min-width:160px;">
                <option value="" <?= $currentStatus === '' ? 'selected' : '' ?>>Todos</option>
                <option value="pending" <?= $currentStatus === 'pending' ? 'selected' : '' ?>>Pendientes</option>
                <option value="approved" <?= $currentStatus === 'approved' ? 'selected' : '' ?>>Aprobadas</option>
                <option value="rejected" <?= $currentStatus === 'rejected' ? 'selected' : '' ?>>Rechazadas</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filtrar</button>
            <a href="<?= BASE_URL ?>superadmin/plan-requests" class="btn btn-ghost btn-sm">Limpiar</a>
        </form>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fas fa-exchange-alt" style="color:#64748b;margin-right:7px;"></i><?= intval($totalRequests ?? 0) ?> solicitudes</h3>
        </div>

        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="col-hide-sm">ID</th>
                        <th>Tienda</th>
                        <th class="col-hide-sm">Solicita</th>
                        <th>Plan</th>
                        <th class="col-hide-sm">Motivo</th>
                        <th>Estado</th>
                        <th class="col-hide-sm">Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($requests)): ?>
                        <?php foreach ($requests as $requestItem): ?>
                        <?php
                            $requestId = intval($requestItem['id']);
                            $statusValue = strval($requestItem['status'] ?? 'pending');
                            $statusBadge = 'badge-yellow';
                            $statusText = 'Pendiente';
                            if ($statusValue === 'approved') {
                                $statusBadge = 'badge-green';
                                $statusText = 'Aprobada';
                            } elseif ($statusValue === 'rejected') {
                                $statusBadge = 'badge-red';
                                $statusText = 'Rechazada';
                            }
                        ?>
                        <tr>
                            <td class="col-hide-sm">#<?= $requestId ?></td>
                            <td>
                                <div style="display:flex;flex-direction:column;gap:2px;">
                                    <a href="<?= BASE_URL ?>superadmin/stores/<?= intval($requestItem['store_id']) ?>" style="font-size:13.5px;font-weight:700;color:#2a7a52;text-decoration:none;">
                                        #<?= intval($requestItem['store_id']) ?> - <?= htmlspecialchars($requestItem['store_name'] ?? 'Tienda') ?>
                                    </a>
                                </div>
                            </td>
                            <td class="col-hide-sm">
                                <span style="font-size:13px;color:#334155;"><?= htmlspecialchars($requestItem['requester_name'] ?? 'Usuario') ?></span>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                    <span class="badge badge-slate"><?= htmlspecialchars($planNames[intval($requestItem['current_plan_id'] ?? 1)] ?? 'Plan') ?></span>
                                    <i class="fas fa-arrow-right" style="font-size:10px;color:#94a3b8;"></i>
                                    <span class="badge badge-blue"><?= htmlspecialchars($planNames[intval($requestItem['requested_plan_id'] ?? 1)] ?? 'Plan') ?></span>
                                </div>
                            </td>
                            <td class="col-hide-sm" style="max-width:280px;">
                                <span style="font-size:12.5px;color:#64748b;"><?= htmlspecialchars($requestItem['reason'] ?: 'Sin motivo') ?></span>
                            </td>
                            <td>
                                <span class="badge <?= $statusBadge ?>"><?= $statusText ?></span>
                            </td>
                            <td class="col-hide-sm">
                                <span style="font-size:12.5px;color:#64748b;"><?= Helper::formatDate($requestItem['created_at']) ?></span>
                            </td>
                            <td>
                                <?php if ($statusValue === 'pending'): ?>
                                <div class="plan-request-actions">
                                    <form method="POST" action="<?= BASE_URL ?>superadmin/plan-requests/approve/<?= $requestId ?>">
                                        <input type="text" name="decision_note" class="form-input" placeholder="Nota (opcional)" style="height:32px;font-size:12px;">
                                        <button type="submit" class="btn btn-sm" style="background:#16a34a;color:#fff;border-color:#16a34a;">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="<?= BASE_URL ?>superadmin/plan-requests/reject/<?= $requestId ?>">
                                        <input type="text" name="decision_note" class="form-input" placeholder="Motivo rechazo" style="height:32px;font-size:12px;">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                                <?php else: ?>
                                <span style="font-size:12px;color:#64748b;display:block;max-width:220px;">
                                    <?= htmlspecialchars($requestItem['decision_note'] ?: 'Sin nota de revisión') ?>
                                </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align:center;padding:34px;color:#94a3b8;">No hay solicitudes para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (($totalPages ?? 1) > 1): ?>
    <?php $queryParams = $_GET; ?>
    <div style="display:flex;justify-content:flex-end;gap:8px;align-items:center;flex-wrap:wrap;">
        <?php for ($p = 1; $p <= intval($totalPages); $p++): ?>
            <?php $queryParams['page'] = $p; ?>
            <a href="<?= BASE_URL ?>superadmin/plan-requests?<?= htmlspecialchars(http_build_query($queryParams)) ?>"
               class="btn <?= $p === $currentPage ? 'btn-primary' : 'btn-ghost' ?> btn-sm"
               style="min-width:36px;justify-content:center;">
                <?= $p ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

</div>
