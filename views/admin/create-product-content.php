<!-- Create Product Content -->
<div style="max-width:720px;">

    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:18px;display:flex;align-items:center;gap:10px;">
        <i class="fas fa-exclamation-circle" style="color:#dc2626;font-size:14px;flex-shrink:0;"></i>
        <p style="font-size:13.5px;color:#b91c1c;font-weight:500;"><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
    <?php endif; ?>

    <div style="margin-bottom:24px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
            <a href="<?= BASE_URL ?>admin/products"
               style="color:#94a3b8;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:4px;transition:color .15s;"
               onmouseover="this.style.color='#64748b'" onmouseout="this.style.color='#94a3b8'">
                <i class="fas fa-arrow-left text-xs"></i> Productos
            </a>
            <span style="color:#e2e8f0;">/</span>
            <span style="font-size:13px;color:#64748b;">Nuevo Producto</span>
        </div>
        <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Crear Nuevo Producto</h2>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body" style="display:flex;flex-direction:column;gap:0;">

                <!-- Info básica -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-tag"></i> Información Básica
                    </div>
                    <div style="display:grid;gap:16px;">
                        <div style="display:grid;grid-template-columns:2fr 1fr;gap:14px;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" for="name">Nombre del Producto <span style="color:#ef4444;">*</span></label>
                                <input type="text" id="name" name="name" required
                                       class="form-input" placeholder="Ej: Camiseta Premium Azul">
                            </div>
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label" for="sku">SKU / Código</label>
                                <input type="text" id="sku" name="sku"
                                       class="form-input" placeholder="Ej: CAM-001">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" for="description">Descripción</label>
                            <textarea id="description" name="description" rows="4"
                                      class="form-input"
                                      placeholder="Describe el producto en detalle: características, materiales, tallas disponibles..."></textarea>
                        </div>
                        <div class="form-group" style="margin-bottom:0;max-width:320px;">
                            <label class="form-label" for="category_id">Categoria</label>
                            <select id="category_id" name="category_id" class="form-input">
                                <option value="0">Sin categoría</option>
                                <?php foreach (($categories ?? []) as $cat): ?>
                                <option value="<?= intval($cat['id']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="form-help">Puedes crear más categorías en el módulo Categorias.</p>
                        </div>
                    </div>
                </div>

                <!-- Precios -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-dollar-sign"></i> Precios
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" for="price">Precio de Venta <span style="color:#ef4444;">*</span></label>
                            <div class="input-group">
                                <div class="input-prefix">$</div>
                                <input type="number" id="price" name="price" required step="0.01" min="0"
                                       class="form-input" style="border-radius:0 8px 8px 0;"
                                       placeholder="0.00">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" for="cost">Costo (interno)</label>
                            <div class="input-group">
                                <div class="input-prefix">$</div>
                                <input type="number" id="cost" name="cost" step="0.01" min="0"
                                       class="form-input" style="border-radius:0 8px 8px 0;"
                                       placeholder="0.00">
                            </div>
                            <p class="form-help">No visible para clientes</p>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" for="discount_price">Precio con Descuento</label>
                            <div class="input-group">
                                <div class="input-prefix">$</div>
                                <input type="number" id="discount_price" name="discount_price" step="0.01" min="0"
                                       class="form-input" style="border-radius:0 8px 8px 0;"
                                       placeholder="0.00">
                            </div>
                            <p class="form-help">Dejar en blanco si no hay descuento</p>
                        </div>
                    </div>
                </div>

                <!-- Inventario -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-warehouse"></i> Inventario
                    </div>
                    <div style="max-width:200px;">
                        <label class="form-label" for="stock">Cantidad en Stock <span style="color:#ef4444;">*</span></label>
                        <input type="number" id="stock" name="stock" required min="0"
                               class="form-input" placeholder="0">
                    </div>
                </div>

                <!-- Imagen -->
                <div class="form-section" style="border-bottom:none;margin-bottom:0;padding-bottom:0;">
                    <div class="form-section-title">
                        <i class="fas fa-image"></i> Imagen del Producto
                    </div>
                    <div style="border:2px dashed #e2e8f0;border-radius:12px;padding:32px;text-align:center;cursor:pointer;transition:all .2s;"
                         id="imageDropzone"
                         onclick="document.getElementById('image').click()"
                         onmouseover="this.style.borderColor='#4f46e5';this.style.background='#f5f3ff'"
                         onmouseout="this.style.borderColor='#e2e8f0';this.style.background='transparent'">
                        <div id="imagePreviewWrap" style="display:none;margin-bottom:12px;">
                            <img id="imagePreview" src="" alt="Preview"
                                 style="max-height:160px;border-radius:10px;margin:0 auto;object-fit:cover;">
                        </div>
                        <div id="imageUploadHint">
                            <i class="fas fa-cloud-upload-alt" style="font-size:32px;color:#cbd5e1;margin-bottom:10px;display:block;"></i>
                            <p style="font-size:14px;font-weight:600;color:#64748b;margin-bottom:4px;">Arrastra tu imagen aquí</p>
                            <p style="font-size:12.5px;color:#94a3b8;">o haz clic para seleccionar un archivo</p>
                            <p style="font-size:11.5px;color:#cbd5e1;margin-top:8px;">JPG, PNG, WebP · Máx. 5MB</p>
                        </div>
                        <input type="file" id="image" name="image" accept="image/*"
                               style="display:none;" onchange="previewImage(this)">
                    </div>
                </div>

            </div>
        </div>

        <!-- Actions -->
        <div style="display:flex;gap:10px;margin-top:20px;">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle"></i> Crear Producto
            </button>
            <a href="<?= BASE_URL ?>admin/products" class="btn btn-ghost btn-lg">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreviewWrap').style.display = 'block';
            document.getElementById('imageUploadHint').innerHTML =
                '<p style="font-size:13px;color:#64748b;font-weight:600;margin-top:4px;">' +
                '<i class="fas fa-check-circle" style="color:#10b981;"></i> ' + input.files[0].name + '</p>' +
                '<p style="font-size:11.5px;color:#94a3b8;">Haz clic para cambiar</p>';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
