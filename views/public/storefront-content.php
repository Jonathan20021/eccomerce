<!-- Storefront Content -->
<style>
/* ══════════════════════════════════════
   STOREFRONT PREMIUM STYLES
══════════════════════════════════════ */

/* ── Hero ── */
.sf-hero {
    position: relative; overflow: hidden;
    background: #0c1f12;
    min-height: 460px;
    display: flex; align-items: center;
}
/* Layered gradient bg */
.sf-hero-bg {
    position: absolute; inset: 0;
    background:
        linear-gradient(135deg, #0c1f12 0%, #1a4a2e 50%, #2a7a52 85%, #1f5c3d 100%);
}
/* Radial glow spots */
.sf-hero-glow {
    position: absolute; inset: 0; pointer-events: none;
    background:
        radial-gradient(ellipse 55% 70% at 72% 35%, rgba(212,151,58,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 40% 55% at 20% 75%, rgba(42,122,82,0.22) 0%, transparent 50%),
        radial-gradient(ellipse 35% 40% at 88% 85%, rgba(59,130,246,0.1) 0%, transparent 50%);
}
/* Animated dot mesh */
.sf-hero-mesh {
    position: absolute; inset: 0; pointer-events: none;
    background-image: radial-gradient(circle, rgba(255,255,255,.055) 1px, transparent 1px);
    background-size: 36px 36px;
    animation: hero-mesh-drift 18s linear infinite;
}
@keyframes hero-mesh-drift {
    from { background-position: 0 0; }
    to   { background-position: 36px 36px; }
}
/* Floating orb particles */
.sf-hero-orb {
    position: absolute; border-radius: 50%; pointer-events: none; filter: blur(40px);
}
.sf-hero-orb-1 {
    width: 280px; height: 280px; top: -80px; right: 15%;
    background: rgba(42,122,82,.18);
    animation: orb-float 8s ease-in-out infinite;
}
.sf-hero-orb-2 {
    width: 200px; height: 200px; bottom: -60px; left: 10%;
    background: rgba(212,151,58,.14);
    animation: orb-float 11s ease-in-out infinite reverse;
}
.sf-hero-orb-3 {
    width: 150px; height: 150px; top: 30%; left: 40%;
    background: rgba(134,239,172,.08);
    animation: orb-float 14s ease-in-out infinite 3s;
}
@keyframes orb-float {
    0%,100% { transform: translateY(0) scale(1); }
    50%      { transform: translateY(-28px) scale(1.06); }
}

.sf-hero-inner {
    position: relative; z-index: 2;
    max-width: 1280px; margin: 0 auto; width: 100%;
    padding: 76px 24px;
    display: grid; grid-template-columns: 1fr 1fr; gap: 52px; align-items: center;
}

/* Staggered hero entrance */
.sf-hero-copy > * {
    animation: hero-enter .7s cubic-bezier(.22,1,.36,1) both;
}
.sf-hero-kicker { animation-delay: .05s !important; }
.sf-hero-headline { animation-delay: .18s !important; }
.sf-hero-sub { animation-delay: .30s !important; }
.sf-hero-ctas { animation-delay: .42s !important; }
.sf-hero-stats { animation-delay: .54s !important; }
@keyframes hero-enter {
    from { opacity: 0; transform: translateY(22px); }
    to   { opacity: 1; transform: translateY(0); }
}

.sf-hero-kicker {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(42,122,82,0.22);
    border: 1px solid rgba(134,239,172,0.38);
    color: #bbf7d0;
    font-size: 12px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase;
    padding: 5px 14px; border-radius: 9999px;
    margin-bottom: 20px; backdrop-filter: blur(6px);
}
.sf-hero-headline {
    font-size: clamp(32px, 4vw, 54px);
    font-weight: 900; color: #fff;
    letter-spacing: -1.5px; line-height: 1.08;
    margin-bottom: 18px;
}
.sf-hero-headline span {
    background: linear-gradient(135deg, #86efac, #4ade80);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
.sf-hero-sub {
    font-size: 15.5px; color: rgba(255,255,255,0.55); line-height: 1.65;
    margin-bottom: 34px; max-width: 440px;
}
.sf-hero-ctas { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.sf-hero-cta-primary {
    display: inline-flex; align-items: center; gap: 9px;
    background: linear-gradient(135deg, #2a7a52, #1f5c3d);
    color: #fff;
    padding: 13px 26px; border-radius: 13px;
    font-size: 14.5px; font-weight: 700; text-decoration: none;
    box-shadow: 0 8px 24px rgba(42,122,82,.42);
    transition: transform .22s, box-shadow .22s, background .2s;
    position: relative; overflow: hidden;
}
.sf-hero-cta-primary::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.12), transparent);
    opacity: 0; transition: opacity .2s;
}
.sf-hero-cta-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 14px 36px rgba(42,122,82,.52);
}
.sf-hero-cta-primary:hover::after { opacity: 1; }
.sf-hero-cta-wa {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(37,211,102,0.14); border: 1.5px solid rgba(37,211,102,0.38);
    color: #4ade80;
    padding: 12px 20px; border-radius: 12px;
    font-size: 14px; font-weight: 700; text-decoration: none;
    transition: background .18s, transform .22s, box-shadow .22s;
    backdrop-filter: blur(6px);
}
.sf-hero-cta-wa:hover {
    background: rgba(37,211,102,0.22);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37,211,102,.25);
}

/* Hero stats */
.sf-hero-stats {
    display: flex; gap: 16px; margin-top: 42px; flex-wrap: wrap;
}
.sf-hero-stat-item {
    text-align: center;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 12px; padding: 12px 20px;
    backdrop-filter: blur(6px);
    min-width: 72px;
    transition: background .2s, border-color .2s;
}
.sf-hero-stat-item:hover {
    background: rgba(255,255,255,.1);
    border-color: rgba(134,239,172,.25);
}
.sf-hero-stat-num { font-size: 22px; font-weight: 900; color: #fff; line-height: 1; }
.sf-hero-stat-label { font-size: 11px; color: rgba(255,255,255,.45); font-weight: 500; margin-top: 4px; }

/* Hero right: floating card stack */
.sf-hero-visual {
    display: flex; align-items: center; justify-content: center;
    position: relative;
    animation: hero-visual-enter .8s cubic-bezier(.22,1,.36,1) .2s both;
}
@keyframes hero-visual-enter {
    from { opacity: 0; transform: translateX(32px) scale(.97); }
    to   { opacity: 1; transform: translateX(0) scale(1); }
}
.sf-hero-card-stack {
    position: relative; width: 288px; height: 356px;
}
.sf-hero-card-back {
    position: absolute; top: 18px; right: -14px;
    width: 208px; height: 270px;
    background: rgba(42,122,82,.14);
    border: 1px solid rgba(42,122,82,.22);
    border-radius: 22px; backdrop-filter: blur(4px);
    transform: rotate(7deg);
}
.sf-hero-card-mid {
    position: absolute; top: 9px; left: -10px;
    width: 208px; height: 270px;
    background: rgba(212,151,58,.1);
    border: 1px solid rgba(212,151,58,.18);
    border-radius: 22px; backdrop-filter: blur(4px);
    transform: rotate(-4deg);
}
.sf-hero-card-front {
    position: absolute; top: 0; left: 22px;
    width: 224px; height: 292px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.13);
    border-radius: 22px; backdrop-filter: blur(14px);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(0,0,0,.28);
}
.sf-hero-slide {
    position: absolute; inset: 0;
    opacity: 0;
    transform: translateX(26px) scale(.97);
    transition: opacity .65s ease, transform .65s ease;
    pointer-events: none;
}
.sf-hero-slide.active { opacity: 1; transform: translateX(0) scale(1); }
.sf-hero-slide.prev   { transform: translateX(-26px) scale(.97); }
.sf-hero-slide img { width: 100%; height: 100%; object-fit: cover; border-radius: 22px; display: block; }
.sf-hero-slide-info {
    position: absolute; bottom: 14px; left: 12px; right: 12px;
    background: rgba(12,31,18,.88);
    backdrop-filter: blur(10px);
    border-radius: 13px; padding: 10px 13px;
    border: 1px solid rgba(255,255,255,.07);
}
.sf-hero-slide-name {
    font-size: 12px; font-weight: 700; color: #fff;
    margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sf-hero-slide-price {
    font-size: 14px; font-weight: 900;
    background: linear-gradient(90deg, #86efac, #4ade80);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
.sf-hero-dots {
    position: absolute; left: 50%; bottom: 10px; transform: translateX(-50%);
    display: flex; align-items: center; gap: 6px; z-index: 6;
}
.sf-hero-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: rgba(255,255,255,.32);
    transition: background .22s, transform .22s, width .22s;
    cursor: pointer;
}
.sf-hero-dot.active {
    background: #86efac; width: 18px; border-radius: 3px;
}
.sf-hero-arrow {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 32px; height: 32px; border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.22);
    background: rgba(12,31,18,0.7);
    color: #fff; display: flex; align-items: center; justify-content: center;
    cursor: pointer; z-index: 7;
    transition: background .15s, transform .15s;
}
.sf-hero-arrow:hover { background: rgba(42,122,82,.9); transform: translateY(-50%) scale(1.08); }
.sf-hero-arrow.prev { left: 10px; }
.sf-hero-arrow.next { right: 10px; }

/* ── Category tabs ── */
.sf-cats {
    background: #fff;
    border-bottom: 1px solid #f1f5f9;
    padding: 0 24px;
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
    transition: color .18s, border-color .18s;
    flex-shrink: 0; position: relative;
}
.sf-cat-tab:hover { color: #1e293b; }
.sf-cat-tab.active { color: #2a7a52; border-bottom-color: #2a7a52; }
.sf-cat-tab i { font-size: 11px; opacity: .65; }
.sf-cat-count {
    background: #f1f5f9; color: #64748b;
    font-size: 10.5px; font-weight: 700;
    padding: 1px 6px; border-radius: 9999px;
    transition: background .18s, color .18s;
}
.sf-cat-tab.active .sf-cat-count { background: #dcfce7; color: #2a7a52; }

/* ── Toolbar ── */
.sf-toolbar {
    max-width: 1280px; margin: 0 auto;
    padding: 28px 24px 0;
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    flex-wrap: wrap;
}
.sf-toolbar-left { display: flex; flex-direction: column; gap: 3px; }
.sf-toolbar-title {
    font-size: 21px; font-weight: 900; color: #1e293b; letter-spacing: -.5px;
}
.sf-toolbar-subtitle { font-size: 13px; color: #94a3b8; }
.sf-search-box { display: flex; align-items: center; gap: 8px; }
.sf-search-input-wrap { position: relative; }
.sf-search-input-wrap i {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 12px; pointer-events: none;
    transition: color .2s;
}
.sf-search-input-wrap:focus-within i { color: #2a7a52; }
.sf-search-input {
    height: 42px; width: 210px;
    padding: 0 14px 0 36px;
    border: 1.5px solid #e2e8f0; border-radius: 11px;
    font-size: 13.5px; font-family: 'Inter', sans-serif; color: #1e293b;
    background: #f8fafc; outline: none;
    transition: border-color .2s, background .2s, width .28s, box-shadow .2s;
}
.sf-search-input:focus {
    border-color: #2a7a52; background: #fff;
    width: 250px; box-shadow: 0 0 0 3px rgba(42,122,82,.1);
}

/* ── Product grid ── */
.sf-grid-wrap { max-width: 1280px; margin: 0 auto; padding: 26px 24px 80px; }
.sf-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 24px;
}

/* ── Product card ── */
.sf-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    transition: box-shadow .32s cubic-bezier(.4,0,.2,1), transform .32s;
    border: 1.5px solid transparent;
}
.sf-card:hover {
    box-shadow: 0 24px 52px -8px rgba(15,23,42,.16), 0 4px 12px -4px rgba(15,23,42,.07);
    transform: translateY(-7px);
    border-color: #e8f5ee;
}
.sf-card-img-wrap {
    aspect-ratio: 3 / 4;
    background: #f1f5f9;
    overflow: hidden;
    position: relative;
}
.sf-card-img {
    width: 100%; height: 100%;
    object-fit: cover; display: block;
    transition: transform .55s cubic-bezier(.4,0,.2,1);
}
.sf-card:hover .sf-card-img { transform: scale(1.09); }
.sf-card-img-ph {
    width: 100%; height: 100%;
    display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}
.sf-card-img-ph i { font-size: 44px; color: #dde3ef; }

/* Wishlist button */
.sf-card-wish {
    position: absolute; top: 10px; right: 10px; z-index: 5;
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,.9); backdrop-filter: blur(6px);
    border: none; cursor: pointer; color: #cbd5e1;
    display: flex; align-items: center; justify-content: center; font-size: 14px;
    transform: scale(0); opacity: 0;
    transition: transform .22s, opacity .22s, color .15s, background .15s;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}
.sf-card:hover .sf-card-wish { transform: scale(1); opacity: 1; }
.sf-card-wish:hover { color: #ef4444; background: rgba(255,255,255,1); }

/* Badge chips */
.sf-card-badges {
    position: absolute; top: 12px; left: 12px;
    display: flex; flex-direction: column; gap: 5px; z-index: 2;
}
.sf-chip {
    padding: 4px 10px; border-radius: 7px;
    font-size: 10.5px; font-weight: 800; letter-spacing: .4px;
    line-height: 1.4;
}
.sf-chip-sale { background: #ef4444; color: #fff; }
.sf-chip-new  { background: #0f172a; color: #fff; }

/* Sold-out overlay */
.sf-sold-overlay {
    position: absolute; inset: 0; z-index: 3;
    background: rgba(15,23,42,.52);
    display: flex; align-items: center; justify-content: center;
    backdrop-filter: blur(2px);
}
.sf-sold-tag {
    background: #1e293b; color: #fff;
    font-size: 11px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase;
    padding: 8px 20px; border-radius: 9px;
    border: 1px solid rgba(255,255,255,.12);
}

/* Hover action bar */
.sf-card-action-bar {
    position: absolute; bottom: 0; left: 0; right: 0; z-index: 4;
    padding: 12px;
    background: linear-gradient(to top, rgba(12,31,18,.82) 0%, transparent 100%);
    transform: translateY(102%);
    transition: transform .3s cubic-bezier(.4,0,.2,1);
}
.sf-card:hover .sf-card-action-bar { transform: translateY(0); }
.sf-card-add-btn {
    width: 100%; padding: 12px 0;
    background: #fff; color: #0f172a;
    border: none; border-radius: 11px;
    font-size: 13.5px; font-weight: 800; font-family: 'Inter', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    transition: background .18s, color .18s, box-shadow .18s;
    letter-spacing: -.2px;
    box-shadow: 0 2px 8px rgba(0,0,0,.12);
}
.sf-card-add-btn:hover { background: #2a7a52; color: #fff; box-shadow: 0 4px 14px rgba(42,122,82,.4); }
.sf-card-add-btn:disabled { background: rgba(255,255,255,.4); color: rgba(255,255,255,.5); cursor: not-allowed; box-shadow: none; }

/* Card info */
.sf-card-info { padding: 15px 15px 17px; }
.sf-card-cat {
    font-size: 10.5px; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .9px; margin-bottom: 6px;
}
.sf-card-name {
    font-size: 14.5px; font-weight: 700; color: #1e293b;
    line-height: 1.35; margin-bottom: 12px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    text-decoration: none;
}
.sf-card-name:hover { color: #2a7a52; }
.sf-card-footer { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
.sf-card-prices { display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap; }
.sf-card-price { font-size: 18px; font-weight: 900; color: #1e293b; }
.sf-card-price-sale { color: #ef4444; }
.sf-card-price-original { font-size: 12.5px; color: #94a3b8; text-decoration: line-through; }
.sf-card-stock {
    font-size: 11px; font-weight: 700; color: #16a34a;
    display: inline-flex; align-items: center; gap: 4px;
    background: #f0fdf4; padding: 3px 8px; border-radius: 9999px;
    border: 1px solid #bbf7d0; flex-shrink: 0;
}
.sf-card-stock::before {
    content: ''; width: 5px; height: 5px;
    background: #22c55e; border-radius: 50%; flex-shrink: 0;
    animation: stock-pulse 2s ease infinite;
}
@keyframes stock-pulse {
    0%,100% { opacity: 1; }
    50%      { opacity: .4; }
}

/* ── Empty state ── */
.sf-no-results {
    grid-column: 1 / -1;
    text-align: center; padding: 90px 24px;
}

/* ── Pagination ── */
.sf-pager {
    max-width: 1280px; margin: 0 auto;
    padding: 0 24px 80px;
    display: flex; justify-content: center; gap: 6px; flex-wrap: wrap;
}
.sf-page-a {
    min-width: 42px; height: 42px; padding: 0 8px;
    display: flex; align-items: center; justify-content: center;
    border: 1.5px solid #e2e8f0; border-radius: 11px;
    font-size: 13.5px; font-weight: 600; color: #475569;
    text-decoration: none; transition: all .18s;
}
.sf-page-a:hover { border-color: #2a7a52; color: #2a7a52; background: #ecfdf5; }
.sf-page-a.active { background: #1e293b; border-color: #1e293b; color: #fff; }

/* ── Responsive ── */
@media (max-width: 900px) {
    .sf-hero-inner { grid-template-columns: 1fr; gap: 30px; }
    .sf-hero-visual { margin-top: 4px; }
    .sf-hero-card-stack { width: 238px; height: 298px; }
    .sf-hero-card-back, .sf-hero-card-mid { width: 170px; height: 220px; }
    .sf-hero-card-front { width: 190px; height: 248px; left: 24px; }
}
@media (max-width: 640px) {
    .sf-hero { min-height: auto; }
    .sf-hero-inner { padding: 36px 16px 28px; gap: 20px; }
    .sf-hero-kicker { margin-bottom: 12px; font-size: 11px; padding: 5px 10px; }
    .sf-hero-headline { font-size: 34px; line-height: 1.06; margin-bottom: 12px; letter-spacing: -.7px; }
    .sf-hero-sub { font-size: 14px; margin-bottom: 20px; color: rgba(255,255,255,.6); }
    .sf-hero-ctas { width: 100%; display: grid; grid-template-columns: 1fr; gap: 10px; }
    .sf-hero-cta-primary, .sf-hero-cta-wa { width: 100%; justify-content: center; padding: 11px 12px; font-size: 14px; }
    .sf-hero-stats { margin-top: 16px; gap: 8px; display: grid; grid-template-columns: repeat(3, 1fr); }
    .sf-hero-stat-item { padding: 9px 6px; border-radius: 10px; }
    .sf-hero-stat-num { font-size: 20px; }
    .sf-hero-stat-label { font-size: 10px; }
    .sf-hero-visual { margin-top: 0; }
    .sf-hero-card-stack { width: 175px; height: 220px; }
    .sf-hero-card-back, .sf-hero-card-mid { width: 126px; height: 168px; }
    .sf-hero-card-back { top: 12px; right: -8px; }
    .sf-hero-card-mid { top: 6px; left: -6px; }
    .sf-hero-card-front { width: 142px; height: 186px; left: 16px; border-radius: 17px; }
    .sf-hero-slide img { border-radius: 17px; }
    .sf-hero-slide-info { left: 8px; right: 8px; bottom: 8px; border-radius: 10px; padding: 8px 9px; }
    .sf-hero-slide-name { font-size: 10px; }
    .sf-hero-slide-price { font-size: 12px; }
    .sf-hero-arrow { width: 26px; height: 26px; }
    .sf-hero-arrow.prev { left: 6px; }
    .sf-hero-arrow.next { right: 6px; }
    .sf-hero-dots { bottom: 5px; }
    .sf-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
    .sf-grid-wrap, .sf-toolbar { padding-left: 16px; padding-right: 16px; }
    .sf-cats { padding: 0 16px; }
}
@media (max-width: 430px) {
    .sf-hero-headline { font-size: 31px; }
}
</style>

<!-- ═══════════════════════════════════════
     HERO BANNER
═══════════════════════════════════════ -->
<section class="sf-hero">
    <div class="sf-hero-bg"></div>
    <div class="sf-hero-glow"></div>
    <div class="sf-hero-mesh"></div>
    <div class="sf-hero-orb sf-hero-orb-1"></div>
    <div class="sf-hero-orb sf-hero-orb-2"></div>
    <div class="sf-hero-orb sf-hero-orb-3"></div>

    <div class="sf-hero-inner">
        <!-- Left: Copy -->
        <div class="sf-hero-copy">
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

        <!-- Right: Visual card stack with product carousel -->
        <div class="sf-hero-visual">
            <div class="sf-hero-card-stack">
                <div class="sf-hero-card-back"></div>
                <div class="sf-hero-card-mid"></div>
                <div class="sf-hero-card-front">
                    <?php
                    $heroProducts = [];
                    foreach (($products ?? []) as $p) {
                        if (!empty($p['image'])) $heroProducts[] = $p;
                    }
                    $heroProducts = array_slice($heroProducts, 0, 8);
                    ?>
                    <?php if (!empty($heroProducts)): ?>
                        <div class="sf-hero-carousel" id="sfHeroCarousel" data-interval="3200">
                            <?php foreach ($heroProducts as $index => $fp): ?>
                                <div class="sf-hero-slide <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                                    <img src="<?= htmlspecialchars(Helper::resolvePublicFileUrl($fp['image'])) ?>"
                                         alt="<?= htmlspecialchars($fp['name']) ?>" loading="lazy">
                                    <div class="sf-hero-slide-info">
                                        <p class="sf-hero-slide-name"><?= htmlspecialchars($fp['name']) ?></p>
                                        <p class="sf-hero-slide-price">$<?= number_format(floatval($fp['discount_price'] ?? $fp['price']), 2) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (count($heroProducts) > 1): ?>
                            <button type="button" class="sf-hero-arrow prev" id="sfHeroPrev" aria-label="Anterior">
                                <i class="fas fa-chevron-left" style="font-size:10px;"></i>
                            </button>
                            <button type="button" class="sf-hero-arrow next" id="sfHeroNext" aria-label="Siguiente">
                                <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                            </button>
                            <div class="sf-hero-dots" id="sfHeroDots">
                                <?php foreach ($heroProducts as $index => $_): ?>
                                    <span class="sf-hero-dot <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>"></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <i class="fas fa-store" style="font-size:52px;color:rgba(134,239,172,.3);"></i>
                        <p style="font-size:13px;font-weight:700;color:rgba(255,255,255,.4);margin-top:10px;">Nueva colección</p>
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
            <span class="sf-cat-count"><?= $totalProducts ?? count($products ?? []) ?></span>
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>?category=<?= intval($cat['id']) ?><?= !empty($searchQuery) ? '&q=' . urlencode($searchQuery) : '' ?>"
           class="sf-cat-tab <?= intval($selectedCategoryId ?? 0) === intval($cat['id']) ? 'active' : '' ?>">
            <?= htmlspecialchars($cat['name']) ?>
            <?php if (!empty($cat['product_count'])): ?>
            <span class="sf-cat-count"><?= intval($cat['product_count']) ?></span>
            <?php endif; ?>
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
                Resultados para &ldquo;<?= htmlspecialchars($searchQuery) ?>&rdquo;
            <?php else: ?>
                Todos los productos
            <?php endif; ?>
        </span>
        <span class="sf-toolbar-subtitle">
            <?= count($products ?? []) ?> de <?= $totalProducts ?? count($products ?? []) ?> productos
        </span>
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
           style="height:42px;padding:0 16px;border:1.5px solid #e2e8f0;border-radius:11px;font-size:13px;font-weight:600;color:#64748b;display:flex;align-items:center;gap:5px;text-decoration:none;transition:all .15s;white-space:nowrap;"
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
        <div class="sf-card reveal reveal-delay-<?= ($i % 4) + 1 ?>">
            <!-- Image wrapper -->
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

                <!-- Wishlist hint -->
                <button class="sf-card-wish" aria-label="Lista de deseos" onclick="event.preventDefault();">
                    <i class="far fa-heart"></i>
                </button>

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
                    <span class="sf-card-stock">Stock</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="sf-grid"><div class="sf-no-results">
        <div style="width:88px;height:88px;background:linear-gradient(135deg,#f0fdf4,#dcfce7);border-radius:24px;display:flex;align-items:center;justify-content:center;margin:0 auto 22px;font-size:36px;color:#86efac;border:1.5px solid #bbf7d0;">
            <i class="fas fa-<?= !empty($searchQuery) ? 'search' : 'box-open' ?>"></i>
        </div>
        <h3 style="font-size:22px;font-weight:900;color:#1e293b;margin-bottom:10px;letter-spacing:-.4px;">
            <?= !empty($searchQuery) ? 'Sin resultados para &ldquo;' . htmlspecialchars($searchQuery) . '&rdquo;' : 'No hay productos aún' ?>
        </h3>
        <p style="font-size:14.5px;color:#94a3b8;margin-bottom:24px;max-width:360px;margin-left:auto;margin-right:auto;line-height:1.6;">
            <?= !empty($searchQuery) ? 'Prueba con un término diferente o explora todas las categorías.' : '¡Vuelve pronto, estamos preparando algo increíble!' ?>
        </p>
        <?php if (!empty($searchQuery)): ?>
        <a href="<?= BASE_URL ?>shop/<?= htmlspecialchars($storeData['slug']) ?>"
           style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:linear-gradient(135deg,#1e293b,#0f172a);color:#fff;border-radius:12px;font-size:14px;font-weight:700;text-decoration:none;box-shadow:0 6px 20px rgba(15,23,42,.25);">
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
    if (!c) return;
    const t = document.createElement('div');
    const isOk = type === 'success';
    t.style.cssText = 'background:#1e293b;color:#f8fafc;padding:14px 18px;border-radius:12px;font-size:13.5px;font-weight:600;box-shadow:0 12px 36px rgba(0,0,0,.25);display:flex;align-items:center;gap:10px;min-width:270px;animation:fadeInUp .3s ease-out;font-family:Inter,sans-serif;border-left:3px solid ' + (isOk ? '#22c55e' : '#ef4444');
    t.innerHTML = `<i class="fas fa-${isOk ? 'check-circle' : 'exclamation-circle'}" style="color:${isOk ? '#22c55e' : '#ef4444'};font-size:16px;flex-shrink:0;"></i>${msg}`;
    c.appendChild(t);
    setTimeout(() => { t.style.cssText += 'opacity:0;transition:opacity .3s;'; setTimeout(() => t.remove(), 300); }, 3000);
}

function updateCartBadge() {
    const b = document.getElementById('cart-count');
    if (b) b.textContent = parseInt(b.textContent || 0) + 1;
}

document.querySelector('.sf-search-input')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') this.form.submit();
});

/* ── Hero Carousel ── */
(function initHeroCarousel() {
    const carousel = document.getElementById('sfHeroCarousel');
    if (!carousel) return;
    const slides = Array.from(carousel.querySelectorAll('.sf-hero-slide'));
    const dots   = Array.from(document.querySelectorAll('#sfHeroDots .sf-hero-dot'));
    const prevBtn = document.getElementById('sfHeroPrev');
    const nextBtn = document.getElementById('sfHeroNext');
    if (slides.length <= 1) return;

    const intervalMs = parseInt(carousel.dataset.interval || '3200', 10);
    let current = 0, timer = null, touchStartX = 0;

    function render(nextIndex, dir) {
        const direction = dir || (nextIndex > current ? 'next' : 'prev');
        slides.forEach(s => s.classList.remove('active', 'prev'));
        current = (nextIndex + slides.length) % slides.length;
        if (direction === 'prev') {
            slides[current].classList.add('prev');
            requestAnimationFrame(() => {
                slides[current].classList.remove('prev');
                slides[current].classList.add('active');
            });
        } else {
            slides[current].classList.add('active');
        }
        dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }
    function start() { stop(); timer = setInterval(() => render(current + 1, 'next'), intervalMs); }
    function stop()  { if (timer) { clearInterval(timer); timer = null; } }

    dots.forEach(d => d.addEventListener('click', () => {
        render(parseInt(d.dataset.index || '0'), parseInt(d.dataset.index) > current ? 'next' : 'prev');
        start();
    }));
    prevBtn?.addEventListener('click', () => { render(current - 1, 'prev'); start(); });
    nextBtn?.addEventListener('click', () => { render(current + 1, 'next'); start(); });
    carousel.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0]?.clientX || 0; }, { passive: true });
    carousel.addEventListener('touchend', e => {
        const delta = (e.changedTouches[0]?.clientX || 0) - touchStartX;
        if (Math.abs(delta) < 40) return;
        delta > 0 ? render(current - 1, 'prev') : render(current + 1, 'next');
        start();
    }, { passive: true });
    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);
    start();
})();
</script>
