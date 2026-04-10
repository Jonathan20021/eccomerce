<!-- Admin Reviews Content -->
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
            <h2 style="font-size:22px;font-weight:800;color:#1e293b;letter-spacing:-0.5px;">Comentarios de productos</h2>
            <p style="font-size:13.5px;color:#64748b;margin-top:3px;">Vista completa de feedback por producto, cliente y estado de respuesta.</p>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:10px;">
        <div class="table-card" style="padding:14px;">
            <p style="font-size:12px;color:#64748b;margin-bottom:5px;">Comentarios totales</p>
            <p style="font-size:24px;font-weight:800;color:#0f172a;"><?= intval($reviewStats['total_reviews'] ?? 0) ?></p>
        </div>
        <div class="table-card" style="padding:14px;">
            <p style="font-size:12px;color:#64748b;margin-bottom:5px;">Sin responder</p>
            <p style="font-size:24px;font-weight:800;color:#b45309;"><?= intval($reviewStats['pending_reviews'] ?? 0) ?></p>
        </div>
        <div class="table-card" style="padding:14px;">
            <p style="font-size:12px;color:#64748b;margin-bottom:5px;">Respondidos</p>
            <p style="font-size:24px;font-weight:800;color:#166534;"><?= intval($reviewStats['replied_reviews'] ?? 0) ?></p>
        </div>
        <div class="table-card" style="padding:14px;">
            <p style="font-size:12px;color:#64748b;margin-bottom:5px;">Promedio de valoración</p>
            <p style="font-size:24px;font-weight:800;color:#1d4ed8;"><?= number_format(floatval($reviewStats['avg_rating'] ?? 0), 1) ?> <span style="font-size:13px;font-weight:700;color:#64748b;">/ 5</span></p>
        </div>
    </div>

    <?php if (!empty($topCommentedProducts)): ?>
    <div class="table-card" style="padding:14px;">
        <p style="font-size:14px;font-weight:700;color:#1e293b;margin-bottom:10px;">Productos más comentados</p>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:9px;">
            <?php foreach ($topCommentedProducts as $topProduct): ?>
            <div style="border:1px solid #e2e8f0;border-radius:10px;padding:10px;display:flex;align-items:center;gap:10px;">
                <?php if (!empty($topProduct['product_image'])): ?>
                    <img src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($topProduct['product_image'])) ?>" alt="<?= htmlspecialchars($topProduct['product_name']) ?>" style="width:42px;height:42px;border-radius:9px;object-fit:cover;border:1px solid #e2e8f0;">
                <?php else: ?>
                    <div style="width:42px;height:42px;border-radius:9px;background:#f8fafc;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-box" style="font-size:12px;color:#94a3b8;"></i>
                    </div>
                <?php endif; ?>
                <div style="min-width:0;">
                    <p style="font-size:13px;font-weight:700;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($topProduct['product_name']) ?></p>
                    <p style="font-size:12px;color:#64748b;"><?= intval($topProduct['comments_count']) ?> comentarios • <?= number_format(floatval($topProduct['avg_rating'] ?? 0), 1) ?>/5</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (empty($reviews)): ?>
    <div class="table-card">
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-comments"></i></div>
            <h3>Aún no tienes comentarios</h3>
            <p>Cuando un cliente comente un producto, aparecerá aquí para que puedas responder.</p>
        </div>
    </div>
    <?php else: ?>

    <div style="display:flex;flex-direction:column;gap:14px;">
        <?php foreach ($reviews as $review): ?>
        <?php
            $productPublicUrl = '';
            if (!empty($storeData['slug']) && !empty($review['product_slug'])) {
                $productPublicUrl = BASE_URL . 'shop/' . $storeData['slug'] . '/product/' . $review['product_slug'] . '?id=' . intval($review['product_id'] ?? 0);
            }
            $productEditUrl = BASE_URL . 'admin/products/edit/' . intval($review['product_id'] ?? 0);
            $hasReply = !empty(trim((string)($review['reply_comment'] ?? '')));
        ?>
        <div class="table-card" style="padding:16px;">
            <div style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;">
                <div style="display:flex;gap:11px;align-items:flex-start;min-width:0;">
                    <?php if (!empty($review['product_image'])): ?>
                        <img src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($review['product_image'])) ?>" alt="<?= htmlspecialchars($review['product_name'] ?? 'Producto') ?>" style="width:52px;height:52px;border-radius:10px;object-fit:cover;border:1px solid #e2e8f0;flex-shrink:0;">
                    <?php else: ?>
                        <div style="width:52px;height:52px;border-radius:10px;background:#f8fafc;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-box" style="font-size:14px;color:#94a3b8;"></i>
                        </div>
                    <?php endif; ?>

                    <div style="min-width:0;">
                        <div style="font-size:14px;font-weight:700;color:#1e293b;display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                            <span><?= htmlspecialchars($review['product_name'] ?? 'Producto') ?></span>
                            <span class="badge badge-blue"><?= intval($review['rating'] ?? 5) ?>/5</span>
                            <span class="badge <?= $hasReply ? 'badge-green' : 'badge-yellow' ?>"><?= $hasReply ? 'Respondido' : 'Pendiente' ?></span>
                        </div>
                        <div style="font-size:12.5px;color:#64748b;margin-top:5px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                            <span><i class="fas fa-user"></i> <?= htmlspecialchars($review['customer_name'] ?: ($review['user_name'] ?? 'Cliente')) ?></span>
                            <span>•</span>
                            <span><?= Helper::formatDate($review['created_at']) ?></span>
                            <span>•</span>
                            <span>#<?= intval($review['id']) ?></span>
                        </div>
                        <div style="margin-top:7px;display:flex;gap:7px;flex-wrap:wrap;">
                            <a href="<?= $productEditUrl ?>" class="btn btn-ghost btn-sm"><i class="fas fa-pencil-alt"></i> Editar producto</a>
                            <?php if ($productPublicUrl !== ''): ?>
                            <a href="<?= $productPublicUrl ?>" target="_blank" class="btn btn-ghost btn-sm"><i class="fas fa-external-link-alt"></i> Ver en tienda</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top:12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 13px;font-size:13.5px;color:#334155;line-height:1.55;white-space:pre-wrap;"><?= htmlspecialchars($review['comment'] ?? '') ?></div>

            <?php if ($hasReply): ?>
            <div style="margin-top:12px;background:#ecfdf5;border:1px solid #bbf7d0;border-radius:10px;padding:12px 13px;">
                <p style="font-size:12px;font-weight:700;color:#166534;margin-bottom:6px;">Tu respuesta</p>
                <p style="font-size:13.5px;color:#166534;line-height:1.55;white-space:pre-wrap;"><?= htmlspecialchars($review['reply_comment']) ?></p>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>admin/reviews/reply/<?= intval($review['id']) ?>" style="margin-top:12px;display:flex;flex-direction:column;gap:9px;">
                <textarea name="reply_comment" rows="3" maxlength="1200" required
                          style="width:100%;border:1.5px solid #dbeafe;border-radius:10px;padding:10px 12px;font-size:13px;line-height:1.5;outline:none;resize:vertical;"
                          placeholder="Escribe una respuesta para este comentario..."><?= htmlspecialchars($review['reply_comment'] ?? '') ?></textarea>
                <div style="display:flex;justify-content:flex-end;">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-reply"></i> <?= $hasReply ? 'Actualizar respuesta' : 'Responder' ?>
                    </button>
                </div>
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if (($totalPages ?? 1) > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= BASE_URL ?>admin/reviews?page=<?= $i ?>"
               class="page-item <?= $i == $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

    <?php endif; ?>
</div>
