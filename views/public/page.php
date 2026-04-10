<?php
$subtitle = $pageData['subtitle'] ?? '';
$updatedAt = $pageData['updated_at'] ?? '';
$sections = is_array($pageData['sections'] ?? null) ? $pageData['sections'] : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> — Kyros Commerce</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="font-family:'Inter',sans-serif;background:#f8fafc;color:#0f172a;">

<nav style="position:sticky;top:0;z-index:20;background:rgba(255,255,255,0.96);backdrop-filter:blur(10px);border-bottom:1px solid #e2e8f0;">
    <div style="max-width:1100px;margin:0 auto;padding:0 20px;height:62px;display:flex;align-items:center;justify-content:space-between;">
        <a href="<?= BASE_URL ?>" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
            <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#4f46e5,#7c3aed);display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:900;">K</div>
            <span style="font-size:16px;font-weight:800;color:#0f172a;">Kyros Commerce</span>
        </a>
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="<?= BASE_URL ?>auth/login" style="font-size:13px;font-weight:600;color:#334155;text-decoration:none;padding:7px 11px;border:1px solid #e2e8f0;border-radius:8px;">Iniciar sesion</a>
            <a href="<?= BASE_URL ?>auth/register" style="font-size:13px;font-weight:700;color:#fff;text-decoration:none;padding:8px 12px;border-radius:8px;background:linear-gradient(135deg,#4f46e5,#7c3aed);">Empezar</a>
        </div>
    </div>
</nav>

<main style="max-width:900px;margin:0 auto;padding:36px 20px 52px;">
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px 22px;margin-bottom:16px;">
        <h1 style="font-size:30px;font-weight:900;letter-spacing:-.8px;color:#0f172a;margin-bottom:8px;"><?= htmlspecialchars($page_title) ?></h1>
        <?php if ($subtitle !== ''): ?>
        <p style="font-size:15px;color:#64748b;line-height:1.7;margin-bottom:8px;"><?= htmlspecialchars($subtitle) ?></p>
        <?php endif; ?>
        <?php if ($updatedAt !== ''): ?>
        <p style="font-size:12px;color:#94a3b8;">Ultima actualizacion: <?= htmlspecialchars($updatedAt) ?></p>
        <?php endif; ?>
    </div>

    <div style="display:flex;flex-direction:column;gap:12px;">
        <?php foreach ($sections as $section): ?>
        <section style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:18px 18px;">
            <h2 style="font-size:18px;font-weight:800;color:#0f172a;margin-bottom:8px;"><?= htmlspecialchars($section['title'] ?? '') ?></h2>
            <p style="font-size:14px;color:#475569;line-height:1.8;"><?= htmlspecialchars($section['content'] ?? '') ?></p>
        </section>
        <?php endforeach; ?>
    </div>
</main>

<footer style="background:#0f172a;color:#94a3b8;padding:24px 20px;text-align:center;font-size:12px;">
    <a href="<?= BASE_URL ?>terms" style="color:#cbd5e1;text-decoration:none;margin:0 6px;">Terminos</a>
    <a href="<?= BASE_URL ?>privacy" style="color:#cbd5e1;text-decoration:none;margin:0 6px;">Privacidad</a>
    <a href="<?= BASE_URL ?>cookies" style="color:#cbd5e1;text-decoration:none;margin:0 6px;">Cookies</a>
    <div style="margin-top:8px;">&copy; <?= date('Y') ?> Kyros Commerce</div>
</footer>

</body>
</html>
