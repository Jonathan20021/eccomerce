<div style="display:flex;flex-direction:column;gap:20px;">

    <?php if (isset($_GET['success'])): ?>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-check-circle" style="color:#16a34a;"></i>
        <span style="font-size:13.5px;color:#166534;font-weight:600;"><?= htmlspecialchars($_GET['success']) ?></span>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-exclamation-circle" style="color:#dc2626;"></i>
        <span style="font-size:13.5px;color:#b91c1c;font-weight:600;"><?= htmlspecialchars($_GET['error']) ?></span>
    </div>
    <?php endif; ?>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-boxes"></i></div>
            <div>
                <div class="stat-label">Productos</div>
                <div class="stat-value"><?= number_format(count($inventoryRows)) ?></div>
                <div class="stat-meta">en el inventario</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-triangle-exclamation"></i></div>
            <div>
                <div class="stat-label">Stock Bajo</div>
                <div class="stat-value"><?= number_format($lowStockCount) ?></div>
                <div class="stat-meta">productos con <= 5 unidades</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon indigo"><i class="fas fa-cubes-stacked"></i></div>
            <div>
                <div class="stat-label">Unidades Totales</div>
                <div class="stat-value"><?= number_format($totalStockUnits) ?></div>
                <div class="stat-meta">stock acumulado</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-sack-dollar"></i></div>
            <div>
                <div class="stat-label">Valor Estimado</div>
                <div class="stat-value"><?= Helper::formatPrice($inventoryValue, $storeData['currency'] ?? 'USD') ?></div>
                <div class="stat-meta">stock x costo</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="padding:14px;">
            <form method="GET" action="<?= BASE_URL ?>admin/inventory" class="admin-filter-form">
                <div>
                    <label class="form-label" for="q">Buscar producto o SKU</label>
                    <input type="text" id="q" name="q" class="form-input" placeholder="Ej: camiseta o SKU-001" value="<?= htmlspecialchars($search) ?>">
                </div>
                <div>
                    <label class="form-label" for="low">Filtro</label>
                    <select id="low" name="low" class="form-input">
                        <option value="0" <?= !$onlyLowStock ? 'selected' : '' ?>>Todo el inventario</option>
                        <option value="1" <?= $onlyLowStock ? 'selected' : '' ?>>Solo stock bajo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="height:42px;">
                    <i class="fas fa-filter"></i> Aplicar
                </button>
            </form>
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <h3><i class="fas fa-warehouse" style="color:#0369a1;margin-right:7px;"></i>Control de Inventario</h3>
        </div>
        <?php if (empty($inventoryRows)): ?>
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-box-open"></i></div>
            <h3>No hay productos para mostrar</h3>
            <p>Ajusta los filtros o crea productos para gestionar inventario.</p>
            <a href="<?= BASE_URL ?>admin/products/new" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Crear Producto
            </a>
        </div>
        <?php else: ?>
        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th>Precio</th>
                        <th>Costo</th>
                        <th>Valor Stock</th>
                        <th>Stock</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventoryRows as $row): ?>
                    <tr>
                        <td>
                            <div style="display:flex;flex-direction:column;gap:2px;">
                                <span style="font-size:13.5px;font-weight:700;color:#1e293b;"><?= htmlspecialchars($row['name']) ?></span>
                                <?php if (!empty($row['is_low_stock'])): ?>
                                <span class="badge badge-yellow" style="width:max-content;">Stock bajo</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td><span style="font-size:12px;color:#64748b;"><?= htmlspecialchars($row['sku'] ?? 'N/A') ?></span></td>
                        <td><?= Helper::formatPrice(floatval($row['price'] ?? 0), $storeData['currency'] ?? 'USD') ?></td>
                        <td><?= Helper::formatPrice(floatval($row['cost'] ?? 0), $storeData['currency'] ?? 'USD') ?></td>
                        <td><strong><?= Helper::formatPrice(floatval($row['estimated_value'] ?? 0), $storeData['currency'] ?? 'USD') ?></strong></td>
                        <td>
                            <form method="POST" action="<?= BASE_URL ?>admin/inventory/stock/<?= intval($row['id']) ?>" style="display:flex;align-items:center;gap:6px;">
                                <input type="number" min="0" name="stock" value="<?= intval($row['stock'] ?? 0) ?>" style="width:88px;height:32px;border:1px solid #e2e8f0;border-radius:7px;padding:0 8px;">
                                <button type="submit" class="btn btn-sm btn-ghost" style="height:32px;padding:0 9px;">
                                    <i class="fas fa-save"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>admin/products/edit/<?= intval($row['id']) ?>" class="btn btn-ghost btn-sm">
                                <i class="fas fa-pen"></i> Editar
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
