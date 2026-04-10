<!-- Admin Products Content -->
<div style="display:flex;flex-direction:column;gap:20px;">

    <?php if (isset($_GET['success'])): ?>
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-check-circle" style="color:#16a34a;font-size:14px;flex-shrink:0;"></i>
        <p style="font-size:13.5px;color:#166534;font-weight:500;">Operación completada exitosamente</p>
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
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Productos</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;"><?= $totalProducts ?> producto<?= $totalProducts !== 1 ? 's' : '' ?> en tu catálogo</p>
        </div>
        <div class="page-header-actions">
            <a href="<?= BASE_URL ?>admin/categories" class="btn btn-ghost">
                <i class="fas fa-folder"></i> Categorias
            </a>
            <a href="<?= BASE_URL ?>admin/products/new" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Producto
            </a>
        </div>
    </div>

    <?php if (empty($products)): ?>
    <div class="table-card">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-box-open"></i></div>
            <h3>Aún no tienes productos</h3>
            <p>Comienza a añadir productos para vender en tu tienda online.</p>
            <a href="<?= BASE_URL ?>admin/products/new" class="btn btn-primary">
                <i class="fas fa-plus"></i> Crear Primer Producto
            </a>
        </div>
    </div>

    <?php else: ?>
    <div class="table-card">
        <div class="overflow-x">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="col-hide-sm">Categoria</th>
                        <th class="col-hide-sm">SKU</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th class="col-hide-xs">Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <?php if ($product['image']): ?>
                                    <img src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($product['image'])) ?>"
                                         alt="<?= htmlspecialchars($product['name']) ?>"
                                         style="width:42px;height:42px;border-radius:9px;object-fit:cover;border:1px solid #f1f5f9;flex-shrink:0;">
                                <?php else: ?>
                                    <div style="width:42px;height:42px;border-radius:9px;background:#f8fafc;border:1px solid #f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="fas fa-box" style="color:#cbd5e1;font-size:14px;"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div style="font-size:13.5px;font-weight:600;color:#1e293b;" class="line-clamp-1">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </div>
                                    <div style="font-size:12px;color:#94a3b8;margin-top:2px;" class="line-clamp-1">
                                        <?= htmlspecialchars(Helper::truncate($product['description'] ?? '', 50)) ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="col-hide-sm">
                            <span class="badge badge-indigo" style="font-size:11px;">
                                <?= htmlspecialchars($product['category_name'] ?? 'Sin categoria') ?>
                            </span>
                        </td>
                        <td class="col-hide-sm">
                            <span style="font-family:monospace;font-size:12.5px;color:#64748b;background:#f8fafc;padding:3px 7px;border-radius:5px;">
                                <?= htmlspecialchars($product['sku'] ?? '—') ?>
                            </span>
                        </td>
                        <td>
                            <?php if (isset($product['discount_price']) && floatval($product['discount_price']) > 0): ?>
                            <div>
                                <div style="font-size:14px;font-weight:700;color:#4f46e5;">$<?= number_format($product['discount_price'], 2) ?></div>
                                <div style="font-size:11.5px;color:#94a3b8;text-decoration:line-through;">$<?= number_format($product['price'], 2) ?></div>
                            </div>
                            <?php else: ?>
                            <div style="font-size:14px;font-weight:700;color:#1e293b;">$<?= number_format($product['price'], 2) ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($product['stock'] > 10): ?>
                                <span class="badge badge-green"><i class="fas fa-circle" style="font-size:7px;"></i> <?= $product['stock'] ?> uds.</span>
                            <?php elseif ($product['stock'] > 0): ?>
                                <span class="badge badge-yellow"><i class="fas fa-circle" style="font-size:7px;"></i> <?= $product['stock'] ?> uds.</span>
                            <?php else: ?>
                                <span class="badge badge-red"><i class="fas fa-circle" style="font-size:7px;"></i> Agotado</span>
                            <?php endif; ?>
                        </td>
                        <td class="col-hide-xs">
                            <span class="badge <?= $product['is_active'] ? 'badge-green' : 'badge-slate' ?>">
                                <?= $product['is_active'] ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <a href="<?= BASE_URL ?>admin/products/edit/<?= $product['id'] ?>"
                                   class="btn btn-ghost btn-sm">
                                    <i class="fas fa-pencil-alt"></i> Editar
                                </a>
                                <button onclick="confirmDelete(<?= $product['id'] ?>)"
                                        class="btn btn-danger btn-sm" style="border:none;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
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
            <a href="<?= BASE_URL ?>admin/products?page=<?= $i ?>"
               class="page-item <?= $i == $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>

</div>

<script>
function confirmDelete(productId) {
    if (confirm('¿Seguro que deseas eliminar este producto? Esta acción no se puede deshacer.')) {
        window.location.href = '<?= BASE_URL ?>admin/products/delete/' + productId;
    }
}
</script>
