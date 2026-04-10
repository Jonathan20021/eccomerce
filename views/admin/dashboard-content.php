<!-- Admin Dashboard Content -->
<div style="display:flex;flex-direction:column;gap:24px;">

    <!-- Stat Cards -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:16px;">

        <div class="stat-card">
            <div class="stat-icon indigo"><i class="fas fa-box-open"></i></div>
            <div>
                <div class="stat-label">Productos</div>
                <div class="stat-value"><?= number_format($totalProducts) ?></div>
                <div class="stat-meta">en tu catálogo</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-shopping-bag"></i></div>
            <div>
                <div class="stat-label">Órdenes</div>
                <div class="stat-value"><?= number_format($totalOrders) ?></div>
                <div class="stat-meta">órdenes totales</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-dollar-sign"></i></div>
            <div>
                <div class="stat-label">Ingresos</div>
                <div class="stat-value"><?= Helper::formatPrice($totalRevenue, $storeData['currency']) ?></div>
                <div class="stat-meta">ingresos totales</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-certificate"></i></div>
            <div>
                <div class="stat-label">Licencia</div>
                <div class="stat-value" style="font-size:18px;margin-top:4px;">
                    <span class="badge badge-green" style="font-size:12px;">
                        <i class="fas fa-check-circle"></i> Activa
                    </span>
                    <span class="badge badge-blue" style="font-size:12px;margin-left:6px;">
                        <?= htmlspecialchars($currentPlanName ?? 'Starter') ?>
                    </span>
                </div>
                <div class="stat-meta">estado y nivel de plan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-hdd"></i></div>
            <div style="width:100%;">
                <div class="stat-label">Almacenamiento</div>
                <div style="font-size:18px;font-weight:800;color:#1e293b;line-height:1.2;">
                    <?= number_format($storageAvailableGb, 2) ?> GB
                </div>
                <div class="stat-meta">
                    disponibles de <?= number_format($storageLimitGb, 2) ?> GB
                </div>
                <?php if (($storageUsageLevel ?? 'ok') === 'warning'): ?>
                <div style="margin-top:6px;font-size:11px;font-weight:700;color:#b45309;background:#fffbeb;border:1px solid #fde68a;border-radius:6px;padding:4px 8px;display:inline-flex;align-items:center;gap:5px;">
                    <i class="fas fa-exclamation-triangle"></i> Uso alto (&gt;=80%)
                </div>
                <?php elseif (($storageUsageLevel ?? 'ok') === 'critical'): ?>
                <div style="margin-top:6px;font-size:11px;font-weight:700;color:#b91c1c;background:#fef2f2;border:1px solid #fecaca;border-radius:6px;padding:4px 8px;display:inline-flex;align-items:center;gap:5px;">
                    <i class="fas fa-ban"></i> Casi sin espacio (&gt;=95%)
                </div>
                <?php endif; ?>
                <div style="margin-top:8px;background:#e2e8f0;border-radius:999px;height:7px;overflow:hidden;">
                    <div style="height:100%;width:<?= max(0, min(100, $storageUsagePercent)) ?>%;background:
                        <?= (($storageUsageLevel ?? 'ok') === 'critical')
                            ? 'linear-gradient(90deg,#ef4444,#dc2626)'
                            : ((($storageUsageLevel ?? 'ok') === 'warning')
                                ? 'linear-gradient(90deg,#f59e0b,#d97706)'
                                : 'linear-gradient(90deg,#3b82f6,#2563eb)') ?>;"></div>
                </div>
                <div style="font-size:11px;<?= (($storageUsageLevel ?? 'ok') === 'critical') ? 'color:#b91c1c;font-weight:700;' : ((($storageUsageLevel ?? 'ok') === 'warning') ? 'color:#92400e;font-weight:700;' : 'color:#64748b;') ?>margin-top:6px;">
                    Usado: <?= Helper::formatBytes($storageUsedBytes, 2) ?> (<?= number_format($storageUsagePercent, 1) ?>%)
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Actions + Store Info -->
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;" class="max-md:grid-cols-1">

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-bolt" style="color:#f59e0b;margin-right:7px;"></i>Acciones Rápidas</h3>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="<?= BASE_URL ?>admin/products/new" class="action-chip"
                       style="background:#eef2ff;color:#4f46e5;">
                        <i class="fas fa-plus-circle"></i> Nuevo Producto
                    </a>
                    <a href="<?= BASE_URL ?>admin/orders" class="action-chip"
                       style="background:#f0fdf4;color:#16a34a;">
                        <i class="fas fa-list-check"></i> Ver Órdenes
                    </a>
                    <a href="<?= BASE_URL ?>admin/settings" class="action-chip"
                       style="background:#f8fafc;color:#475569;">
                        <i class="fas fa-sliders-h"></i> Configuración
                    </a>
                    <a href="<?= BASE_URL ?>admin/categories" class="action-chip"
                       style="background:#eff6ff;color:#1d4ed8;">
                        <i class="fas fa-folder"></i> Categorias
                    </a>
                    <?php if (!empty($enabledModules['inventory'])): ?>
                    <a href="<?= BASE_URL ?>admin/inventory" class="action-chip"
                       style="background:#ecfeff;color:#0e7490;">
                        <i class="fas fa-warehouse"></i> Inventario
                    </a>
                    <?php endif; ?>
                    <?php if (!empty($enabledModules['finance'])): ?>
                    <a href="<?= BASE_URL ?>admin/finance" class="action-chip"
                       style="background:#ecfdf5;color:#047857;">
                        <i class="fas fa-chart-pie"></i> Finanzas
                    </a>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>shop/<?= $storeData['slug'] ?>" target="_blank" class="action-chip"
                       style="background:#faf5ff;color:#7c3aed;">
                        <i class="fas fa-external-link-alt"></i> Ver Tienda
                    </a>
                </div>
            </div>
        </div>

        <!-- Store Info Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-store" style="color:#4f46e5;margin-right:7px;"></i>Tu Tienda</h3>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:12px;">
                <div>
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#94a3b8;margin-bottom:2px;">Nombre</div>
                    <div style="font-size:14px;font-weight:600;color:#1e293b;"><?= htmlspecialchars($storeData['name']) ?></div>
                </div>
                <div>
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#94a3b8;margin-bottom:2px;">URL Pública</div>
                    <a href="<?= BASE_URL ?>shop/<?= $storeData['slug'] ?>" target="_blank"
                       style="font-size:12.5px;color:#4f46e5;font-weight:500;word-break:break-all;text-decoration:none;">
                        /shop/<?= htmlspecialchars($storeData['slug']) ?>
                    </a>
                </div>
                <div>
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#94a3b8;margin-bottom:2px;">Moneda</div>
                    <div style="font-size:14px;font-weight:600;color:#1e293b;"><?= htmlspecialchars($storeData['currency']) ?></div>
                </div>
                <div>
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#94a3b8;margin-bottom:6px;">Módulos Habilitados</div>
                    <?php if (!empty($enabledModuleLabels)): ?>
                        <div style="display:flex;flex-wrap:wrap;gap:6px;">
                            <?php foreach ($enabledModuleLabels as $moduleLabel): ?>
                            <span class="badge badge-blue" style="font-size:11px;"><?= htmlspecialchars($moduleLabel) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <span style="font-size:13px;color:#94a3b8;">Sin módulos adicionales</span>
                    <?php endif; ?>
                </div>
                <?php if ($storeData['whatsapp_number']): ?>
                <div>
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#94a3b8;margin-bottom:2px;">WhatsApp</div>
                    <a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number']) ?>" target="_blank"
                       style="font-size:13px;color:#16a34a;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:5px;">
                        <i class="fab fa-whatsapp"></i> +<?= htmlspecialchars($storeData['whatsapp_number']) ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- Recent Orders -->
    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fas fa-clock" style="color:#64748b;margin-right:7px;"></i>Órdenes Recientes</h3>
            <a href="<?= BASE_URL ?>admin/orders"
               style="font-size:13px;color:#4f46e5;font-weight:600;text-decoration:none;">
                Ver todas <i class="fas fa-arrow-right text-xs ml-1"></i>
            </a>
        </div>

        <?php if (empty($recentOrders)): ?>
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-shopping-bag"></i></div>
            <h3>Sin órdenes aún</h3>
            <p>Cuando tus clientes realicen compras, aparecerán aquí.</p>
            <a href="<?= BASE_URL ?>shop/<?= $storeData['slug'] ?>" target="_blank" class="btn btn-primary btn-sm">
                <i class="fas fa-external-link-alt"></i> Ver mi tienda
            </a>
        </div>
        <?php else: ?>
        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $statusBadge = [
                        'pending'    => ['badge-yellow','Pendiente'],
                        'confirmed'  => ['badge-blue',  'Confirmada'],
                        'processing' => ['badge-purple', 'Procesando'],
                        'shipped'    => ['badge-indigo', 'Enviada'],
                        'delivered'  => ['badge-green',  'Entregada'],
                        'cancelled'  => ['badge-red',    'Cancelada'],
                    ];
                    foreach ($recentOrders as $order):
                        $sb = $statusBadge[$order['status']] ?? ['badge-slate', ucfirst($order['status'])];
                    ?>
                    <tr>
                        <td>
                            <span style="font-size:13px;font-weight:700;color:#4f46e5;"><?= htmlspecialchars($order['order_number']) ?></span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:9px;">
                                <div style="width:28px;height:28px;border-radius:50%;background:#eef2ff;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#4f46e5;flex-shrink:0;">
                                    <?= strtoupper(substr($order['customer_name'], 0, 1)) ?>
                                </div>
                                <span style="font-size:13.5px;font-weight:500;"><?= htmlspecialchars($order['customer_name']) ?></span>
                            </div>
                        </td>
                        <td><span style="font-size:14px;font-weight:700;"><?= Helper::formatPrice($order['total'], $storeData['currency']) ?></span></td>
                        <td><span class="badge <?= $sb[0] ?>"><?= $sb[1] ?></span></td>
                        <td><span style="color:#64748b;font-size:13px;"><?= Helper::formatDate($order['created_at']) ?></span></td>
                        <td>
                            <a href="<?= BASE_URL ?>admin/orders/<?= $order['id'] ?>"
                               class="btn btn-ghost btn-sm">
                                <i class="fas fa-eye"></i> Ver
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
