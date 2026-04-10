<!-- Admin Edit Product Content -->
<div style="max-width:720px;">

    <div style="margin-bottom:24px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
            <a href="<?= BASE_URL ?>admin/products"
               style="color:#94a3b8;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:4px;"
               onmouseover="this.style.color='#64748b'" onmouseout="this.style.color='#94a3b8'">
                <i class="fas fa-arrow-left text-xs"></i> Productos
            </a>
            <span style="color:#e2e8f0;">/</span>
            <span style="font-size:13px;color:#64748b;">Editar</span>
        </div>
        <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Editar Producto</h2>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <!-- Información Básica -->
        <div class="card" style="margin-bottom:16px;">
            <div class="card-header">
                <h3><i class="fas fa-tag" style="color:#4f46e5;margin-right:8px;"></i>Información Básica</h3>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:16px;">

                <div class="form-grid-2">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="name">Nombre del Producto <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="name" name="name" required
                               value="<?= htmlspecialchars($productData['name']) ?>"
                               class="form-input" placeholder="Ej. Camiseta Premium">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="sku">SKU</label>
                        <input type="text" id="sku" name="sku"
                               value="<?= htmlspecialchars($productData['sku'] ?? '') ?>"
                               class="form-input" placeholder="Ej. CAM-001">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label" for="description">Descripción</label>
                    <textarea id="description" name="description" rows="4"
                              class="form-input" style="resize:vertical;"
                              placeholder="Describe el producto..."><?= htmlspecialchars($productData['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group" style="margin-bottom:0;max-width:320px;">
                    <label class="form-label" for="category_id">Categoria</label>
                    <select id="category_id" name="category_id" class="form-input">
                        <option value="0">Sin categoría</option>
                        <?php foreach (($categories ?? []) as $cat): ?>
                        <option value="<?= intval($cat['id']) ?>" <?= intval($productData['category_id'] ?? 0) === intval($cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>
        </div>

        <!-- Precios -->
        <div class="card" style="margin-bottom:16px;">
            <div class="card-header">
                <h3><i class="fas fa-dollar-sign" style="color:#16a34a;margin-right:8px;"></i>Precios</h3>
            </div>
            <div class="card-body">
                <div class="form-grid-3">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="price">Precio <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-weight:600;font-size:14px;">$</span>
                            <input type="number" id="price" name="price" required step="0.01" min="0"
                                   value="<?= $productData['price'] ?>"
                                   class="form-input" style="padding-left:28px;" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="cost">Costo</label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-weight:600;font-size:14px;">$</span>
                            <input type="number" id="cost" name="cost" step="0.01" min="0"
                                   value="<?= $productData['cost'] ?>"
                                   class="form-input" style="padding-left:28px;" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="discount_price">Precio Descuento</label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-weight:600;font-size:14px;">$</span>
                            <input type="number" id="discount_price" name="discount_price" step="0.01" min="0"
                                   value="<?= $productData['discount_price'] ?>"
                                   class="form-input" style="padding-left:28px;" placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventario -->
        <div class="card" style="margin-bottom:16px;">
            <div class="card-header">
                <h3><i class="fas fa-boxes" style="color:#f59e0b;margin-right:8px;"></i>Inventario</h3>
            </div>
            <div class="card-body">
                <div class="form-grid-2" style="align-items:end;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label" for="stock">Stock <span style="color:#ef4444;">*</span></label>
                        <input type="number" id="stock" name="stock" required min="0"
                               value="<?= $productData['stock'] ?>"
                               class="form-input" placeholder="0">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;padding:10px 0;">
                            <input type="checkbox" id="is_active" name="is_active"
                                   <?= $productData['is_active'] ? 'checked' : '' ?>
                                   style="width:16px;height:16px;accent-color:#4f46e5;cursor:pointer;">
                            <span style="font-size:14px;font-weight:600;color:#1e293b;">Producto activo</span>
                        </label>
                        <p style="font-size:12px;color:#94a3b8;margin-top:2px;">Visible en la tienda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imagen -->
        <div class="card" style="margin-bottom:24px;">
            <div class="card-header">
                <h3><i class="fas fa-image" style="color:#7c3aed;margin-right:8px;"></i>Imagen del Producto</h3>
            </div>
            <div class="card-body">
                <?php if ($productData['image']): ?>
                <div style="margin-bottom:16px;">
                    <p style="font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Imagen Actual</p>
                    <div style="display:flex;align-items:center;gap:16px;">
                        <img id="imagePreview" src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($productData['image'])) ?>"
                             alt="Imagen actual"
                             style="width:88px;height:88px;object-fit:cover;border-radius:12px;border:2px solid #e2e8f0;">
                        <div>
                            <p style="font-size:13px;color:#64748b;">Sube una nueva imagen para reemplazar la actual.</p>
                            <p style="font-size:12px;color:#94a3b8;margin-top:2px;">Dejar vacío para mantener la imagen.</p>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div id="imagePreviewWrap" style="display:none;margin-bottom:16px;">
                    <img id="imagePreview" src="" alt="" style="width:88px;height:88px;object-fit:cover;border-radius:12px;border:2px solid #e2e8f0;">
                </div>
                <?php endif; ?>

                <label for="image"
                       style="display:flex;flex-direction:column;align-items:center;gap:10px;padding:28px;border:2px dashed #c7d2fe;border-radius:12px;cursor:pointer;background:#f8fafc;transition:all .15s;"
                       onmouseover="this.style.borderColor='#4f46e5';this.style.background='#eef2ff'"
                       onmouseout="this.style.borderColor='#c7d2fe';this.style.background='#f8fafc'">
                    <i class="fas fa-cloud-upload-alt" style="font-size:28px;color:#a5b4fc;"></i>
                    <div style="text-align:center;">
                        <p style="font-size:14px;font-weight:600;color:#4f46e5;">Haz clic para subir imagen</p>
                        <p style="font-size:12px;color:#94a3b8;margin-top:2px;">PNG, JPG o WebP · Máx. 2MB</p>
                    </div>
                    <input type="file" id="image" name="image" accept="image/*" style="display:none;"
                           onchange="previewImage(this)">
                </label>
            </div>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <a href="<?= BASE_URL ?>admin/products" class="btn btn-ghost btn-lg">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('imagePreview');
        const wrap = document.getElementById('imagePreviewWrap');
        img.src = e.target.result;
        if (wrap) wrap.style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
