<!-- SuperAdmin Dashboard Content -->
<div style="display:flex;flex-direction:column;gap:24px;">

    <!-- Stat Cards -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:16px;">
        <div class="stat-card">
            <div class="stat-icon indigo"><i class="fas fa-store"></i></div>
            <div>
                <div class="stat-label">Total Tiendas</div>
                <div class="stat-value" id="store-count"><?= count($stores ?? []) ?></div>
                <div class="stat-meta">tiendas registradas</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-certificate"></i></div>
            <div>
                <div class="stat-label">Licencias</div>
                <div class="stat-value" id="license-count"><?= count($licenses ?? []) ?></div>
                <div class="stat-meta">licencias totales</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-dollar-sign"></i></div>
            <div>
                <div class="stat-label">Ingresos Plataforma</div>
                <div class="stat-value">$0</div>
                <div class="stat-meta">este mes</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-label">Usuarios</div>
                <div class="stat-value">0</div>
                <div class="stat-meta">usuarios activos</div>
            </div>
        </div>
    </div>

    <!-- Admin Actions -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-bolt" style="color:#f59e0b;margin-right:7px;"></i>Acciones de Administración</h3>
        </div>
        <div class="card-body">
            <div class="quick-actions">
                <a href="<?= BASE_URL ?>superadmin/licenses/create" class="action-chip" style="background:#eef2ff;color:#4f46e5;">
                    <i class="fas fa-plus-circle"></i> Crear Licencia
                </a>
                <a href="<?= BASE_URL ?>superadmin/licenses" class="action-chip" style="background:#f0fdf4;color:#16a34a;">
                    <i class="fas fa-certificate"></i> Gestionar Licencias
                </a>
                <a href="<?= BASE_URL ?>superadmin/stores" class="action-chip" style="background:#faf5ff;color:#7c3aed;">
                    <i class="fas fa-store"></i> Ver Tiendas
                </a>
                <a href="<?= BASE_URL ?>superadmin/settings" class="action-chip" style="background:#f8fafc;color:#475569;">
                    <i class="fas fa-cog"></i> Configuración
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Stores -->
    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fas fa-store" style="color:#64748b;margin-right:7px;"></i>Tiendas Recientes</h3>
            <a href="<?= BASE_URL ?>superadmin/stores" style="font-size:13px;color:#4f46e5;font-weight:600;text-decoration:none;">
                Ver todas <i class="fas fa-arrow-right text-xs ml-1"></i>
            </a>
        </div>
        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tienda</th>
                        <th>Propietario</th>
                        <th>Plan</th>
                        <th>Estado</th>
                        <th>Creada</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($stores)):
                        $count = 0;
                        $planNames = ['Starter', 'Professional', 'Enterprise'];
                        foreach ($stores as $store):
                            if ($count++ >= 5) break;
                    ?>
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:34px;height:34px;border-radius:9px;background:#eef2ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-store" style="color:#4f46e5;font-size:13px;"></i>
                                </div>
                                <span style="font-size:13.5px;font-weight:600;color:#1e293b;"><?= htmlspecialchars($store['name']) ?></span>
                            </div>
                        </td>
                        <td><span style="font-size:13px;color:#64748b;">ID #<?= $store['owner_id'] ?></span></td>
                        <td>
                            <span class="badge badge-indigo">
                                <?= $planNames[($store['plan_id'] - 1)] ?? 'Plan ' . $store['plan_id'] ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge <?= $store['is_active'] ? 'badge-green' : 'badge-red' ?>">
                                <?= $store['is_active'] ? 'Activa' : 'Inactiva' ?>
                            </span>
                        </td>
                        <td><span style="font-size:13px;color:#64748b;"><?= Helper::formatDate($store['created_at']) ?></span></td>
                        <td>
                            <a href="<?= BASE_URL ?>superadmin/stores/<?= $store['id'] ?>" class="btn btn-ghost btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;font-size:14px;">
                            No hay tiendas registradas aún
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Licenses -->
    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fas fa-certificate" style="color:#64748b;margin-right:7px;"></i>Licencias Recientes</h3>
            <a href="<?= BASE_URL ?>superadmin/licenses" style="font-size:13px;color:#4f46e5;font-weight:600;text-decoration:none;">
                Ver todas <i class="fas fa-arrow-right text-xs ml-1"></i>
            </a>
        </div>
        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Plan</th>
                        <th>Tienda</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Creada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($licenses)):
                        $count = 0;
                        $planNames = ['Starter', 'Professional', 'Enterprise'];
                        foreach ($licenses as $license):
                            if ($count++ >= 5) break;
                        $statusMap = ['active'=>['badge-green','Activa'], 'expired'=>['badge-red','Expirada'], 'suspended'=>['badge-yellow','Suspendida'], 'cancelled'=>['badge-slate','Cancelada']];
                        $sb = $statusMap[$license['status']] ?? ['badge-slate', ucfirst($license['status'])];
                    ?>
                    <tr>
                        <td>
                            <code style="font-size:12px;background:#f8fafc;color:#4f46e5;padding:3px 8px;border-radius:5px;border:1px solid #e2e8f0;">
                                <?= htmlspecialchars($license['code']) ?>
                            </code>
                        </td>
                        <td><span style="font-size:13.5px;color:#1e293b;"><?= $planNames[($license['plan_id'] - 1)] ?? 'Plan ' . $license['plan_id'] ?></span></td>
                        <td>
                            <?php if ($license['store_id']): ?>
                                <a href="<?= BASE_URL ?>superadmin/stores/<?= $license['store_id'] ?>" style="color:#4f46e5;font-size:13px;font-weight:600;text-decoration:none;">
                                    Tienda #<?= $license['store_id'] ?>
                                </a>
                            <?php else: ?>
                                <span style="color:#94a3b8;font-size:13px;">Sin asignar</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?= $license['is_trial'] ? 'badge-yellow' : 'badge-blue' ?>">
                                <?= $license['is_trial'] ? 'Prueba' : 'Pago' ?>
                            </span>
                        </td>
                        <td><span class="badge <?= $sb[0] ?>"><?= $sb[1] ?></span></td>
                        <td><span style="font-size:13px;color:#64748b;"><?= Helper::formatDate($license['created_at']) ?></span></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:#94a3b8;font-size:14px;">
                            No hay licencias registradas aún
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
