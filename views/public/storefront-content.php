<!-- Storefront Content -->
<style>
/* ── Hero Banner ── */
.sf-hero {
    position: relative; overflow: hidden;
    background: #0f172a;
    min-height: 420px;
    display: flex; align-items: center;
}
.sf-hero-bg {
    position: absolute; inset: 0;
    background:
    radial-gradient(ellipse 60% 80% at 70% 40%, rgba(42,122,82,0.22) 0%, transparent 60%),
    radial-gradient(ellipse 50% 60% at 20% 80%, rgba(212,151,58,0.16) 0%, transparent 55%),
        radial-gradient(ellipse 40% 50% at 85% 85%, rgba(59,130,246,0.12) 0%, transparent 50%);
}
.sf-hero-grid-overlay {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 48px 48px;
}
.sf-hero-inner {
    position: relative; z-index: 2;
    max-width: 1280px; margin: 0 auto; width: 100%;
    padding: 70px 24px;
    display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center;
}
.sf-hero-kicker {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(42,122,82,0.2);
    border: 1px solid rgba(134,239,172,0.35);
    color: #bbf7d0;
    font-size: 12px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase;
    padding: 5px 12px; border-radius: 9999px;
    margin-bottom: 20px;
}
.sf-hero-headline {
    font-size: clamp(32px, 4vw, 52px);
    font-weight: 900; color: #fff;
    letter-spacing: -1.5px; line-height: 1.08;
    margin-bottom: 18px;
}
.sf-hero-headline span { color: #86efac; }
.sf-hero-sub {
    font-size: 16px; color: rgba(255,255,255,0.52); line-height: 1.6;
    margin-bottom: 32px; max-width: 420px;
}
.sf-hero-ctas { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.sf-hero-cta-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: #2a7a52; color: #fff;
    padding: 13px 24px; border-radius: 12px;
    font-size: 14.5px; font-weight: 700; text-decoration: none;
    box-shadow: 0 8px 24px rgba(42,122,82,0.35);
    transition: transform .2s, box-shadow .2s, background .15s;
}
.sf-hero-cta-primary:hover { background: #1f5c3d; transform: translateY(-2px); box-shadow: 0 12px 32px rgba(42,122,82,0.45); }
.sf-hero-cta-wa {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(37,211,102,0.15); border: 1.5px solid rgba(37,211,102,0.35);
    color: #4ade80;
    padding: 12px 20px; border-radius: 12px;
    font-size: 14px; font-weight: 700; text-decoration: none;
    transition: background .15s, transform .2s;
}
.sf-hero-cta-wa:hover { background: rgba(37,211,102,0.22); transform: translateY(-2px); }

/* Hero right: floating product preview */
.sf-hero-visual {
    display: flex; align-items: center; justify-content: center;
    position: relative;
}
.sf-hero-card-stack {
    position: relative; width: 280px; height: 340px;
}
.sf-hero-card-back {
    position: absolute; top: 16px; right: -12px;
    width: 200px; height: 260px;
    background: rgba(42,122,82,0.16);
    border: 1px solid rgba(42,122,82,0.24);
    border-radius: 20px;
    backdrop-filter: blur(4px);
    transform: rotate(6deg);
}
.sf-hero-card-mid {
    position: absolute; top: 8px; left: -8px;
    width: 200px; height: 260px;
    background: rgba(212,151,58,0.12);
    border: 1px solid rgba(212,151,58,0.2);
    border-radius: 20px;
    backdrop-filter: blur(4px);
    transform: rotate(-3deg);
}
.sf-hero-card-front {
    position: absolute; top: 0; left: 20px;
    width: 220px; height: 280px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 20px;
    backdrop-filter: blur(12px);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 10px;
    overflow: hidden;
}
.sf-hero-slide {
    position: absolute; inset: 0;
    opacity: 0;
    transform: translateX(24px) scale(.98);
    transition: opacity .6s ease, transform .6s ease;
    pointer-events: none;
}
.sf-hero-slide.active {
    opacity: 1;
    transform: translateX(0) scale(1);
}
.sf-hero-slide.prev {
    transform: translateX(-24px) scale(.98);
}
.sf-hero-slide img {
    width: 100%; height: 100%; object-fit: cover; border-radius: 20px; display: block;
}
.sf-hero-slide-info {
    position: absolute; bottom: 14px; left: 14px; right: 14px;
    background: rgba(15,23,42,.85);
    backdrop-filter: blur(8px);
    border-radius: 12px;
    padding: 10px 12px;
}
.sf-hero-slide-name {
    font-size: 12px; font-weight: 700; color: #fff;
    margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sf-hero-slide-price { font-size: 14px; font-weight: 900; color: #86efac; }
.sf-hero-dots {
    position: absolute; left: 50%; bottom: 8px; transform: translateX(-50%);
    display: flex; align-items: center; gap: 6px; z-index: 6;
}
.sf-hero-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: rgba(255,255,255,.35);
    transition: background .2s ease, transform .2s ease;
}
.sf-hero-dot.active { background: #86efac; transform: scale(1.15); }
.sf-hero-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(15,23,42,0.65);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 7;
    transition: background .15s ease, transform .15s ease;
}
.sf-hero-arrow:hover {
    background: rgba(42,122,82,0.9);
    transform: translateY(-50%) scale(1.05);
}
.sf-hero-arrow.prev { left: 8px; }
.sf-hero-arrow.next { right: 8px; }
.sf-hero-stats {
    display: flex; gap: 20px; margin-top: 40px;
}
.sf-hero-stat-item { text-align: center; }
.sf-hero-stat-num { font-size: 22px; font-weight: 900; color: #fff; line-height: 1; }
.sf-hero-stat-label { font-size: 11px; color: rgba(255,255,255,0.4); font-weight: 500; margin-top: 3px; }

/* ── Category strip ── */
.sf-cats {
    background: #fff;
    border-bottom: 1px solid #f1f5f9;
    padding: 0 24px;
    overflow: hidden;
}
.sf-cats-inner {
    max-width: 1280px; margin: 0 auto;
    display: flex; align-items: center; gap: 0;
    overflow-x: auto; scrollbar-width: none;
}
.sf-cats-inner::-webkit-scrollbar { display: none; }
.sf-cat-tab {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 16px 18px;
    font-size: 13.5px; font-weight: 600; color: #64748b;
    text-decoration: none; white-space: nowrap;
    border-bottom: 2.5px solid transparent;
    transition: color .15s, border-color .15s;
    flex-shrink: 0;
}
.sf-cat-tab:hover { color: #1e293b; }
.sf-cat-tab.active { color: #2a7a52; border-bottom-color: #2a7a52; }
.sf-cat-tab i { font-size: 11px; opacity: .7; }

/* ── Toolbar ── */
.sf-toolbar {
    max-width: 1280px; margin: 0 auto;
    padding: 24px 24px 0;
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    flex-wrap: wrap;
}
.sf-toolbar-left { display: flex; flex-direction: column; gap: 2px; }
.sf-toolbar-title { font-size: 20px; font-weight: 800; color: #1e293b; letter-spacing: -.4px; }
.sf-toolbar-subtitle { font-size: 13px; color: #94a3b8; }
.sf-search-box {
    display: flex; align-items: center; gap: 8px;
}
.sf-search-input-wrap { position: relative; }
.sf-search-input-wrap i {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 12px; pointer-events: none;
}
.sf-search-input {
    height: 40px; width: 200px;
    padding: 0 14px 0 34px;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    font-size: 13.5px; font-family: 'Inter', sans-serif; color: #1e293b;
    background: #f8fafc; outline: none;
    transition: border-color .15s, background .15s, width .25s;
}
.sf-search-input:focus { border-color: #2a7a52; background: #fff; width: 240px; }

/* ── Product grid ── */
.sf-grid-wrap { max-width: 1280px; margin: 0 auto; padding: 24px 24px 72px; }
.sf-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 24px;
}

/* ── Product card (portrait, magazine-style) ── */
.sf-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    transition: box-shadow .3s cubic-bezier(.4,0,.2,1), transform .3s;
}
.sf-card:hover {
    box-shadow: 0 20px 48px -8px rgba(15,23,42,.18), 0 4px 12px -4px rgba(15,23,42,.08);
    transform: translateY(-6px);
}
.sf-card-img-wrap {
    aspect-ratio: 3 / 4;
    background: #f1f5f9;
    overflow: hidden;
    position: relative;
}
.sf-card-img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
}
.sf-card:hover .sf-card-img { transform: scale(1.08); }
.sf-card-img-ph {
    width: 100%; height: 100%;
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}
.sf-card-img-ph i { font-size: 48px; color: #dde3ef; }

/* Badge chips */
.sf-card-badges {
    position: absolute; top: 12px; left: 12px;
    display: flex; flex-direction: column; gap: 5px; z-index: 2;
}
.sf-chip { padding: 4px 9px; border-radius: 7px; font-size: 10.5px; font-weight: 800; letter-spacing: .4px; }
.sf-chip-sale { background: #ef4444; color: #fff; }
.sf-chip-new  { background: #0f172a; color: #fff; }

/* Sold-out overlay */
.sf-sold-overlay {
    position: absolute; inset: 0; z-index: 3;
    background: rgba(15,23,42,.5);
    display: flex; align-items: center; justify-content: center;
    backdrop-filter: blur(2px);
}
.sf-sold-tag {
    background: #1e293b; color: #fff;
    font-size: 11px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase;
    padding: 8px 20px; border-radius: 8px;
    border: 1px solid rgba(255,255,255,.12);
}

/* Hover action bar */
.sf-card-action-bar {
    position: absolute; bottom: 0; left: 0; right: 0; z-index: 4;
    padding: 10px;
    background: linear-gradient(to top, rgba(15,23,42,.7) 0%, transparent 100%);
    transform: translateY(100%);
    transition: transform .28s cubic-bezier(.4,0,.2,1);
}
.sf-card:hover .sf-card-action-bar { transform: translateY(0); }
.sf-card-add-btn {
    width: 100%; padding: 11px 0;
    background: #fff; color: #0f172a;
    border: none; border-radius: 10px;
    font-size: 13.5px; font-weight: 800; font-family: 'Inter', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    transition: background .15s, color .15s;
    letter-spacing: -.2px;
}
.sf-card-add-btn:hover { background: #2a7a52; color: #fff; }
.sf-card-add-btn:disabled { background: rgba(255,255,255,.4); color: rgba(255,255,255,.5); cursor: not-allowed; }

/* Card info */
.sf-card-info { padding: 14px 14px 16px; }
.sf-card-cat {
    font-size: 10.5px; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .8px; margin-bottom: 5px;
}
.sf-card-name {
    font-size: 14.5px; font-weight: 700; color: #1e293b;
    line-height: 1.35; margin-bottom: 10px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    text-decoration: none; display: block;
}
.sf-card-name:hover { color: #2a7a52; }
.sf-card-footer { display: flex; align-items: center; justify-content: space-between; }
.sf-card-prices { display: flex; align-items: baseline; gap: 6px; }
.sf-card-price { font-size: 17px; font-weight: 900; color: #1e293b; }
.sf-card-price-sale { color: #ef4444; }
.sf-card-price-original { font-size: 12.5px; color: #94a3b8; text-decoration: line-through; }
.sf-card-stock {
    font-size: 11.5px; font-weight: 700; color: #16a34a;
    display: flex; align-items: center; gap: 4px;
}
.sf-card-stock::before {
    content: ''; width: 6px; height: 6px;
    background: #22c55e; border-radius: 50%; flex-shrink: 0;
}

/* ── Empty ── */
.sf-no-results {
    grid-column: 1 / -1;
    text-align: center; padding: 80px 24px;
}

/* ── Pagination ── */
.sf-pager {
    max-width: 1280px; margin: 0 auto;
    padding: 0 24px 72px;
    display: flex; justify-content: center; gap: 6px; flex-wrap: wrap;
}
.sf-page-a {
    min-width: 40px; height: 40px; padding: 0 6px;
    display: flex; align-items: center; justify-content: center;
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    font-size: 13.5px; font-weight: 600; color: #475569;
    text-decoration: none; transition: all .15s;
}
.sf-page-a:hover { border-color: #2a7a52; color: #2a7a52; background: #ecfdf5; }
.sf-page-a.active { background: #1e293b; border-color: #1e293b; color: #fff; }

/* ── Responsive ── */
@media (max-width: 900px) {
    .sf-hero-inner { grid-template-columns: 1fr; gap: 28px; }
    .sf-hero-visual { display: flex; margin-top: 6px; }
    .sf-hero-card-stack { width: 230px; height: 290px; }
    .sf-hero-card-back,
    .sf-hero-card-mid { width: 165px; height: 215px; }
    .sf-hero-card-front { width: 185px; height: 240px; left: 22px; }
    .sf-hero-slide-name { font-size: 11px; }
    .sf-hero-slide-price { font-size: 13px; }
}
@media (max-width: 640px) {
    .sf-hero { min-height: auto; }
    .sf-hero-inner { padding: 32px 16px 24px; gap: 18px; }
    .sf-hero-kicker { margin-bottom: 12px; font-size: 11px; padding: 5px 10px; }
    .sf-hero-headline { font-size: 34px; line-height: 1.05; margin-bottom: 12px; letter-spacing: -0.7px; }
    .sf-hero-sub { font-size: 14px; margin-bottom: 16px; line-height: 1.45; color: rgba(255,255,255,0.64); }
    .sf-hero-ctas {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }
    .sf-hero-cta-primary,
    .sf-hero-cta-wa {
        width: 100%;
        justify-content: center;
        padding: 11px 12px;
        border-radius: 10px;
        font-size: 13.5px;
    }
    .sf-hero-stats {
        margin-top: 14px;
        gap: 8px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    .sf-hero-stat-item {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 10px;
        padding: 8px 4px;
    }
    .sf-hero-stat-num { font-size: 24px; }
    .sf-hero-stat-label { font-size: 10px; margin-top: 2px; }

    .sf-hero-visual { margin-top: 0; }
    .sf-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
    .sf-grid-wrap, .sf-toolbar { padding-left: 16px; padding-right: 16px; }
    .sf-cats { padding: 0 16px; }
    .sf-hero-card-stack { width: 170px; height: 216px; }
    .sf-hero-card-back,
    .sf-hero-card-mid { width: 122px; height: 164px; }
    .sf-hero-card-back { top: 12px; right: -8px; opacity: .85; }
    .sf-hero-card-mid { top: 6px; left: -6px; opacity: .85; }
    .sf-hero-card-front {
        width: 138px;
        height: 182px;
        left: 16px;
        border-radius: 16px;
    }
    .sf-hero-slide img { border-radius: 16px; }
    .sf-hero-slide-info { left: 8px; right: 8px; bottom: 8px; border-radius: 10px; padding: 8px 9px; }
    .sf-hero-slide-name { font-size: 10.5px; }
    .sf-hero-slide-price { font-size: 12.5px; }
    .sf-hero-arrow { width: 24px; height: 24px; }
    .sf-hero-arrow.prev { left: 6px; }
    .sf-hero-arrow.next { right: 6px; }
    .sf-hero-dots { bottom: 4px; }
}

@media (max-width: 430px) {
    .sf-hero-headline { font-size: 31px; }
    .sf-hero-sub { font-size: 14px; }
}
</style>

<!-- ═══════════════════════════════════════
     HERO BANNER — Promotional, no name repeat
═══════════════════════════════════════ -->
<section class="sf-hero">
    <div class="sf-hero-bg"></div>
    <div class="sf-hero-grid-overlay"></div>
    <div class="sf-hero-inner">
        <!-- Left: Copy -->
        <div>
            <div class="sf-hero-kicker">
                <i class="fas fa-bolt" style="font-size:10px;"></i>
                <?= $totalProducts ?? count($products ?? []) ?> productos disponibles
            </div>
            <h2 class="sf-hero-headline">
                Descubre lo<br>mejor de<br><span>nuestra colección</span>
            </h2>
            <p class="sf-hero-sub">
                <?= htmlspecialchars($storeData['description'] ?? 'Explora nuestra selección de productos de calidad con envío rápido y atención personalizada.') ?>
            </p>
            <div class="sf-hero-ctas">
                <a href="#products" class="sf-hero-cta-primary"
                   onclick="document.getElementById('products').scrollIntoView({behavior:'smooth'});return false;">
                    <i class="fas fa-arrow-down" style="font-size:12px;"></i> Ver productos
                </a>
                <?php if (!empty($storeData['whatsapp_number'])): ?>
                <a href="<?= Helper::getWhatsAppLink($storeData['whatsapp_number']) ?>" target="_blank" class="sf-hero-cta-wa">
                    <i class="fab fa-whatsapp" style="font-size:16px;"></i> WhatsApp
                </a>
                <?php endif; ?>
            </div>
            <div class="sf-hero-stats">
                <div class="sf-hero-stat-item">
                    <div class="sf-hero-stat-num"><?= $totalProducts ?? count($products ?? []) ?></div>
                    <div class="sf-hero-stat-label">Productos</div>
                </div>
                <?php if (!empty($categories)): ?>
                <div class="sf-hero-stat-item">
                    <div class="sf-hero-stat-num"><?= count($categories) ?></div>
                    <div class="sf-hero-stat-label">Categorías</div>
                </div>
                <?php endif; ?>
                <div class="sf-hero-stat-item">
                    <div class="sf-hero-stat-num">24h</div>
                    <div class="sf-hero-stat-label">Respuesta</div>
                </div>
            </div>
        </div>

        <!-- Right: Visual card stack -->
        <div class="sf-hero-visual">
            <div class="sf-hero-card-stack">
                <div class="sf-hero-card-back"></div>
                <div class="sf-hero-card-mid"></div>
                <div class="sf-hero-card-front">
                    <?php
                    $heroProducts = [];
                    foreach (($products ?? []) as $p) {
                        if (!empty($p['image'])) {
                            $heroProducts[] = $p;
                        }
                    }
                    $heroProducts = array_slice($heroProducts, 0, 8);
                    ?>
                    <?php if (!empty($heroProducts)): ?>
                        <div class="sf-hero-carousel" id="sfHeroCarousel" data-interval="3200">
                            <?php foreach ($heroProducts as $index => $featuredProduct): ?>
                                <div class="sf-hero-slide <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                                    <img src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($featuredProduct['image'])) ?>"
                                         alt="<?= htmlspecialchars($featuredProduct['name']) ?>">
                                    <div class="sf-hero-slide-info">
                                        <p class="sf-hero-slide-name"><?= htmlspecialchars($featuredProduct['name']) ?></p>
                                        <p class="sf-hero-slide-price">$<?= number_format(floatval($featuredProduct['discount_price'] ?? $featuredProduct['price']), 2) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if (count($heroProducts) > 1): ?>
                            <button type="button" class="sf-hero-arrow prev" id="sfHeroPrev" aria-label="Producto anterior">
                                <i class="fas fa-chevron-left" style="font-size:11px;"></i>
                            </button>
                            <button type="button" class="sf-hero-arrow next" id="sfHeroNext" aria-label="Producto siguiente">
                                <i class="fas fa-chevron-right" style="font-size:11px;"></i>
                            </button>

                            <div class="sf-hero-dots" id="sfHeroDots">
                                <?php foreach ($heroProducts as $index => $_): ?>
                                    <span class="sf-hero-dot <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>"></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <i class="fas fa-store" style="font-size:48px;color:rgba(165,180,252,0.4);"></i>
                        <p style="font-size:13px;font-weight:700;color:rgba(255,255,255,.5);">Nueva colección</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     CATEGORY TABS
═══════════════════════════════════════ -->
<?php if (!empty($categories)): ?>
<div class="sf-cats">
    <div class="sf-cats-inner">
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>"
           class="sf-cat-tab <?= empty($selectedCategoryId) || intval($selectedCategoryId) === 0 ? 'active' : '' ?>">
            <i class="fas fa-th"></i> Todos
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>?category=<?= intval($cat['id']) ?><?= !empty($searchQuery) ? '&q=' . urlencode($searchQuery) : '' ?>"
           class="sf-cat-tab <?= intval($selectedCategoryId ?? 0) === intval($cat['id']) ? 'active' : '' ?>">
            <?= htmlspecialchars($cat['name']) ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- ═══════════════════════════════════════
     TOOLBAR
═══════════════════════════════════════ -->
<div class="sf-toolbar" id="products">
    <div class="sf-toolbar-left">
        <span class="sf-toolbar-title">
            <?php if (intval($selectedCategoryId ?? 0) > 0):
                foreach ($categories as $c) {
                    if (intval($c['id']) === intval($selectedCategoryId)) { echo htmlspecialchars($c['name']); break; }
                }
            elseif (!empty($searchQuery)): ?>
                Resultados para "<?= htmlspecialchars($searchQuery) ?>"
            <?php else: ?>
                Todos los productos
            <?php endif; ?>
        </span>
        <span class="sf-toolbar-subtitle"><?= count($products ?? []) ?> de <?= $totalProducts ?? count($products ?? []) ?> productos</span>
    </div>
    <form method="GET" class="sf-search-box">
        <?php if (intval($selectedCategoryId ?? 0) > 0): ?>
        <input type="hidden" name="category" value="<?= intval($selectedCategoryId) ?>">
        <?php endif; ?>
        <div class="sf-search-input-wrap">
            <i class="fas fa-search"></i>
            <input type="search" name="q" class="sf-search-input"
                   placeholder="Buscar productos..."
                   value="<?= htmlspecialchars($searchQuery ?? '') ?>">
        </div>
        <?php if (!empty($searchQuery) || intval($selectedCategoryId ?? 0) > 0): ?>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>"
           style="height:40px;padding:0 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;font-weight:600;color:#64748b;display:flex;align-items:center;gap:5px;text-decoration:none;transition:all .15s;white-space:nowrap;"
           onmouseover="this.style.borderColor='#94a3b8';this.style.color='#1e293b'"
           onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#64748b'">
            <i class="fas fa-times" style="font-size:11px;"></i> Limpiar
        </a>
        <?php endif; ?>
    </form>
</div>

<!-- ═══════════════════════════════════════
     PRODUCT GRID
═══════════════════════════════════════ -->
<div class="sf-grid-wrap">
    <?php if (!empty($products)): ?>
    <div class="sf-grid">
        <?php foreach ($products as $i => $product):
            $finalPrice  = (isset($product['discount_price']) && floatval($product['discount_price']) > 0) ? floatval($product['discount_price']) : floatval($product['price']);
            $hasDiscount = isset($product['discount_price']) && floatval($product['discount_price']) > 0;
            $outOfStock  = intval($product['stock']) <= 0;
            $productUrl  = BASE_URL . 'shop/' . htmlspecialchars($storeData['slug']) . '/product/' . htmlspecialchars($product['slug']) . '?id=' . intval($product['id']);
            $isNew       = (time() - strtotime($product['created_at'] ?? 'now')) < 7 * 86400;
        ?>
        <div class="sf-card fade-in-up" style="animation-delay: <?= min($i * 50, 300) ?>ms;">
            <!-- Image -->
            <div class="sf-card-img-wrap">
                <a href="<?= $productUrl ?>" style="display:block;height:100%;">
                    <?php if (!empty($product['image'])): ?>
                        <img class="sf-card-img"
                             src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($product['image'])) ?>"
                             alt="<?= htmlspecialchars($product['name']) ?>"
                             loading="lazy">
                    <?php else: ?>
                        <div class="sf-card-img-ph">
                            <i class="fas fa-image"></i>
                        </div>
                    <?php endif; ?>
                </a>

                <!-- Badges -->
                <div class="sf-card-badges">
                    <?php if ($hasDiscount && !empty($product['discount_percent'])): ?>
                    <span class="sf-chip sf-chip-sale">−<?= $product['discount_percent'] ?>%</span>
                    <?php endif; ?>
                    <?php if ($isNew && !$outOfStock): ?>
                    <span class="sf-chip sf-chip-new">Nuevo</span>
                    <?php endif; ?>
                </div>

                <!-- Sold-out overlay -->
                <?php if ($outOfStock): ?>
                <div class="sf-sold-overlay"><span class="sf-sold-tag">Agotado</span></div>
                <?php endif; ?>

                <!-- Hover add-to-cart bar -->
                <div class="sf-card-action-bar">
                    <button class="sf-card-add-btn"
                            <?= $outOfStock ? 'disabled' : '' ?>
                            onclick="event.stopPropagation();addToCart(<?= intval($product['id']) ?>, <?= intval($storeData['id']) ?>, this)">
                        <?php if (!$outOfStock): ?>
                            <i class="fas fa-shopping-bag" style="font-size:13px;"></i> Añadir al carrito
                        <?php else: ?>
                            <i class="fas fa-ban" style="font-size:12px;"></i> Sin stock
                        <?php endif; ?>
                    </button>
                </div>
            </div>

            <!-- Card info -->
            <div class="sf-card-info">
                <?php if (!empty($product['category_name'])): ?>
                <p class="sf-card-cat"><?= htmlspecialchars($product['category_name']) ?></p>
                <?php endif; ?>
                <a href="<?= $productUrl ?>" class="sf-card-name"><?= htmlspecialchars($product['name']) ?></a>
                <div class="sf-card-footer">
                    <div class="sf-card-prices">
                        <?php if ($hasDiscount): ?>
                            <span class="sf-card-price sf-card-price-sale">$<?= number_format($finalPrice, 2) ?></span>
                            <span class="sf-card-price-original">$<?= number_format($product['price'], 2) ?></span>
                        <?php else: ?>
                            <span class="sf-card-price">$<?= number_format($product['price'], 2) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if (!$outOfStock): ?>
                    <span class="sf-card-stock">En stock</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="sf-grid"><div class="sf-no-results">
        <div style="width:80px;height:80px;background:#f1f5f9;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:32px;color:#d1d5db;">
            <i class="fas fa-<?= !empty($searchQuery) ? 'search' : 'box-open' ?>"></i>
        </div>
        <h3 style="font-size:20px;font-weight:800;color:#1e293b;margin-bottom:8px;">
            <?= !empty($searchQuery) ? 'Sin resultados para "' . htmlspecialchars($searchQuery) . '"' : 'No hay productos aún' ?>
        </h3>
        <p style="font-size:14px;color:#94a3b8;margin-bottom:22px;">
            <?= !empty($searchQuery) ? 'Prueba con un término diferente o explora todas las categorías.' : '¡Vuelve pronto, estamos preparando algo increíble!' ?>
        </p>
        <?php if (!empty($searchQuery)): ?>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>"
           style="display:inline-flex;align-items:center;gap:7px;padding:11px 22px;background:#1e293b;color:#fff;border-radius:10px;font-size:14px;font-weight:700;text-decoration:none;">
            <i class="fas fa-arrow-left" style="font-size:11px;"></i> Ver todos los productos
        </a>
        <?php endif; ?>
    </div></div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<?php if (($totalPages ?? 1) > 1): ?>
<div class="sf-pager">
    <?php if ($page > 1): ?>
    <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>?page=<?= $page-1 ?>&category=<?= intval($selectedCategoryId ?? 0) ?>&q=<?= urlencode($searchQuery ?? '') ?>"
       class="sf-page-a"><i class="fas fa-chevron-left" style="font-size:11px;"></i></a>
    <?php endif; ?>
    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
    <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>?page=<?= $i ?>&category=<?= intval($selectedCategoryId ?? 0) ?>&q=<?= urlencode($searchQuery ?? '') ?>"
       class="sf-page-a <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
    <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>?page=<?= $page+1 ?>&category=<?= intval($selectedCategoryId ?? 0) ?>&q=<?= urlencode($searchQuery ?? '') ?>"
       class="sf-page-a"><i class="fas fa-chevron-right" style="font-size:11px;"></i></a>
    <?php endif; ?>
</div>
<?php endif; ?>

<script>
function addToCart(productId, storeId, btn) {
    const originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="font-size:12px;"></i> Añadiendo...';

    const fd = new FormData();
    fd.append('product_id', productId);
    fd.append('store_id', storeId);
    fd.append('quantity', 1);

    fetch('<?= BASE_URL ?>api/cart/add', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showToast('Producto añadido al carrito ✓', 'success');
                updateCartBadge();
                btn.style.background = '#2a7a52';
                btn.style.color = '#fff';
                btn.innerHTML = '<i class="fas fa-check" style="font-size:12px;"></i> Añadido';
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.style.background = '';
                    btn.style.color = '';
                    btn.disabled = false;
                }, 2200);
            } else {
                btn.innerHTML = originalHtml; btn.disabled = false;
                showToast(data.message || 'Error al añadir', 'error');
            }
        })
        .catch(() => { btn.innerHTML = originalHtml; btn.disabled = false; });
}

function showToast(msg, type) {
    const c = document.getElementById('toastContainer');
    const t = document.createElement('div');
    const isOk = type === 'success';
    t.style.cssText = 'background:#1e293b;color:#f8fafc;padding:13px 18px;border-radius:11px;font-size:13.5px;font-weight:600;box-shadow:0 12px 32px rgba(0,0,0,.22);display:flex;align-items:center;gap:10px;min-width:260px;animation:fadeInUp .3s ease-out;font-family:Inter,sans-serif;border-left:3px solid ' + (isOk ? '#22c55e' : '#ef4444');
    t.innerHTML = `<i class="fas fa-${isOk ? 'check-circle' : 'exclamation-circle'}" style="color:${isOk ? '#22c55e' : '#ef4444'};font-size:16px;flex-shrink:0;"></i>${msg}`;
    c.appendChild(t);
    setTimeout(() => { t.style.cssText += 'opacity:0;transition:opacity .3s;'; setTimeout(() => t.remove(), 300); }, 3200);
}

function updateCartBadge() {
    const b = document.getElementById('cart-count');
    if (b) { b.textContent = parseInt(b.textContent || 0) + 1; }
}

// Auto-submit search on Enter
document.querySelector('.sf-search-input')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') this.form.submit();
});

(function initHeroCarousel() {
    const carousel = document.getElementById('sfHeroCarousel');
    if (!carousel) return;

    const slides = Array.from(carousel.querySelectorAll('.sf-hero-slide'));
    const dots = Array.from(document.querySelectorAll('#sfHeroDots .sf-hero-dot'));
    const prevBtn = document.getElementById('sfHeroPrev');
    const nextBtn = document.getElementById('sfHeroNext');
    if (slides.length <= 1) return;

    const intervalMs = parseInt(carousel.dataset.interval || '2800', 10);
    let current = 0;
    let timer = null;
    let touchStartX = 0;

    function render(nextIndex, direction) {
        const dir = direction || (nextIndex > current ? 'next' : 'prev');
        slides.forEach((slide) => slide.classList.remove('active', 'prev'));

        current = (nextIndex + slides.length) % slides.length;
        if (dir === 'prev') {
            slides[current].classList.add('prev');
            requestAnimationFrame(() => {
                slides[current].classList.remove('prev');
                slides[current].classList.add('active');
            });
        } else {
            slides[current].classList.add('active');
        }

        dots.forEach((dot, i) => dot.classList.toggle('active', i === current));
    }

    function start() {
        stop();
        timer = setInterval(() => render(current + 1, 'next'), intervalMs);
    }

    function stop() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            const index = parseInt(dot.dataset.index || '0', 10);
            render(index, index > current ? 'next' : 'prev');
            start();
        });
    });

    prevBtn?.addEventListener('click', () => {
        render(current - 1, 'prev');
        start();
    });

    nextBtn?.addEventListener('click', () => {
        render(current + 1, 'next');
        start();
    });

    carousel.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0]?.clientX || 0;
    }, { passive: true });

    carousel.addEventListener('touchend', (e) => {
        const touchEndX = e.changedTouches[0]?.clientX || 0;
        const delta = touchEndX - touchStartX;
        if (Math.abs(delta) < 40) return;

        if (delta > 0) {
            render(current - 1, 'prev');
        } else {
            render(current + 1, 'next');
        }
        start();
    }, { passive: true });

    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);

    start();
})();
</script>
