<!-- Admin Categories Content -->
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

    <div class="page-header">
        <div>
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Categorias</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;">Organiza tu catalogo para mejorar la navegacion de clientes.</p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1.1fr 1.9fr;gap:16px;" class="max-md:grid-cols-1">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-folder-plus" style="color:#4f46e5;margin-right:7px;"></i>Nueva Categoria</h3>
            </div>
            <div class="card-body">
                <form method="POST" style="display:flex;flex-direction:column;gap:12px;">
                    <input type="hidden" name="edit_id" id="edit_id" value="0">

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="name">Nombre <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="name" name="name" class="form-input" required placeholder="Ej: Camisetas">
                    </div>

                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="description">Descripcion</label>
                        <textarea id="description" name="description" rows="3" class="form-input" placeholder="Descripcion corta opcional"></textarea>
                    </div>

                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                        <input type="checkbox" name="is_active" id="is_active" checked
                               style="width:16px;height:16px;accent-color:#4f46e5;cursor:pointer;">
                        <span style="font-size:14px;font-weight:600;color:#1e293b;">Activa</span>
                    </label>

                    <div style="display:flex;gap:8px;">
                        <button type="submit" class="btn btn-primary btn-sm" id="categorySubmitBtn">
                            <i class="fas fa-plus"></i> Crear
                        </button>
                        <button type="button" class="btn btn-ghost btn-sm" onclick="resetCategoryForm()">
                            <i class="fas fa-undo"></i> Limpiar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <h3><i class="fas fa-folder-open" style="color:#64748b;margin-right:7px;"></i>Listado de Categorias</h3>
            </div>

            <?php if (empty($categories)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-folder"></i></div>
                <h3>No tienes categorias</h3>
                <p>Crea categorias para clasificar tus productos y facilitar la busqueda.</p>
            </div>
            <?php else: ?>
            <div class="overflow-x">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Productos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td>
                                <div style="font-size:13.5px;font-weight:700;color:#1e293b;"><?= htmlspecialchars($cat['name']) ?></div>
                                <div style="font-size:12px;color:#94a3b8;margin-top:2px;" class="line-clamp-1"><?= htmlspecialchars($cat['description'] ?? '') ?></div>
                            </td>
                            <td>
                                <span class="badge <?= intval($cat['is_active']) === 1 ? 'badge-green' : 'badge-slate' ?>">
                                    <?= intval($cat['is_active']) === 1 ? 'Activa' : 'Inactiva' ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-indigo"><?= intval($cat['products_count'] ?? 0) ?></span>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:6px;">
                                    <button class="btn btn-ghost btn-sm"
                                            type="button"
                                            onclick='editCategory(<?= json_encode(['id' => intval($cat['id']), 'name' => $cat['name'], 'description' => $cat['description'], 'is_active' => intval($cat['is_active'])]) ?>)'>
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <a class="btn btn-danger btn-sm" style="border:none;"
                                       href="<?= BASE_URL ?>admin/categories?delete=<?= intval($cat['id']) ?>"
                                       onclick="return confirm('¿Eliminar categoria? Los productos quedaran sin categoria.')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function editCategory(data) {
    document.getElementById('edit_id').value = data.id || 0;
    document.getElementById('name').value = data.name || '';
    document.getElementById('description').value = data.description || '';
    document.getElementById('is_active').checked = Number(data.is_active || 0) === 1;

    const submitBtn = document.getElementById('categorySubmitBtn');
    submitBtn.innerHTML = '<i class="fas fa-save"></i> Guardar';
}

function resetCategoryForm() {
    document.getElementById('edit_id').value = 0;
    document.getElementById('name').value = '';
    document.getElementById('description').value = '';
    document.getElementById('is_active').checked = true;

    const submitBtn = document.getElementById('categorySubmitBtn');
    submitBtn.innerHTML = '<i class="fas fa-plus"></i> Crear';
}
</script>
