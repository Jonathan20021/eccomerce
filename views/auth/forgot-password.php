<?php
$page_title = 'Recuperar Acceso — Kyros Commerce';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/style.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/mobile-pro.css">
</head>
<body style="font-family:'Inter',sans-serif;background:#f8fafc;color:#0f172a;">

<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;">
    <div style="width:100%;max-width:460px;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px;">
        <a href="<?= BASE_URL ?>auth/login" style="display:inline-flex;align-items:center;gap:6px;text-decoration:none;color:#2a7a52;font-size:13px;font-weight:600;margin-bottom:14px;">
            <i class="fas fa-arrow-left"></i> Volver a login
        </a>

        <h1 style="font-size:24px;font-weight:900;letter-spacing:-0.6px;color:#0f172a;margin-bottom:8px;">Recuperar acceso</h1>
        <p style="font-size:14px;color:#64748b;line-height:1.6;margin-bottom:18px;">Ingresa tu correo y te enviaremos instrucciones para recuperar tu cuenta.</p>

        <?php if (isset($_GET['error'])): ?>
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:11px 13px;margin-bottom:14px;color:#b91c1c;font-size:13px;font-weight:600;">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:11px 13px;margin-bottom:14px;color:#166534;font-size:13px;font-weight:600;">
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
        <?php endif; ?>

        <form method="POST" style="display:flex;flex-direction:column;gap:12px;">
            <label for="email" style="font-size:13px;font-weight:700;color:#334155;">Correo electronico</label>
            <input type="email" id="email" name="email" required placeholder="tu@email.com"
                   style="width:100%;height:42px;border:1px solid #e2e8f0;border-radius:9px;padding:0 12px;font-size:14px;outline:none;">

                <button type="submit"
                    style="height:43px;border:none;border-radius:9px;background:linear-gradient(135deg,#2a7a52,#1f5c3d);color:#fff;font-size:14px;font-weight:700;cursor:pointer;">
                Enviar instrucciones
            </button>
        </form>
    </div>
</div>

</body>
</html>
