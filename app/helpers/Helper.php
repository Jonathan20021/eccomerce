<?php

class Helper {
    public static function generateSlug($text) {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = preg_replace('/-+/', '-', $text);
        return trim($text, '-');
    }

    public static function formatPrice($price, $currency = 'USD') {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'MXN' => '$',
            'COP' => '$',
            'ARS' => '$',
            'DOP' => 'RD$'
        ];

        $symbol = $symbols[$currency] ?? '$';
        return $symbol . number_format($price, 2, '.', ',');
    }

    public static function formatDate($date, $format = 'Y-m-d') {
        return date($format, strtotime($date));
    }

    public static function formatBytes($bytes, $precision = 2) {
        $bytes = max(0, floatval($bytes));
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = 0;

        if ($bytes > 0) {
            $pow = min(intval(floor(log($bytes, 1024))), count($units) - 1);
        }

        $value = $bytes / pow(1024, $pow);
        return number_format($value, $precision) . ' ' . $units[$pow];
    }

    public static function truncate($text, $length = 100) {
        if (strlen($text) > $length) {
            return substr($text, 0, $length) . '...';
        }
        return $text;
    }

    public static function getWhatsAppLink($phone, $message = '') {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (!$phone) return '#';
        return "https://wa.me/" . $phone . ($message ? "?text=" . urlencode($message) : "");
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validatePhone($phone) {
        return preg_match('/^[0-9+\-\s()]{10,}$/', $phone);
    }

    public static function generateToken($length = 32) {
        return bin2hex(random_bytes($length / 2));
    }

    public static function sanitizeInput($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }

    public static function sanitizeUrl($url, $allowRelative = true) {
        $url = trim((string)$url);
        if ($url === '') {
            return '';
        }

        // Block dangerous protocols before any other check.
        if (preg_match('/^(javascript|data|vbscript):/i', $url)) {
            return '';
        }

        if ($allowRelative && preg_match('/^(\/|#|\?)/', $url)) {
            return $url;
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        }

        $scheme = strtolower((string)parse_url($url, PHP_URL_SCHEME));
        if (!in_array($scheme, ['http', 'https'], true)) {
            return '';
        }

        return $url;
    }

    public static function uploadFile($file, $directory = 'uploads') {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB

        $uploadError = intval($file['error'] ?? UPLOAD_ERR_NO_FILE);
        if ($uploadError !== UPLOAD_ERR_OK) {
            $messages = [
                UPLOAD_ERR_INI_SIZE => 'La imagen supera el límite de upload_max_filesize del servidor',
                UPLOAD_ERR_FORM_SIZE => 'La imagen supera el tamaño máximo permitido por el formulario',
                UPLOAD_ERR_PARTIAL => 'La imagen se subió parcialmente, intenta nuevamente',
                UPLOAD_ERR_NO_FILE => 'No se recibió ninguna imagen',
                UPLOAD_ERR_NO_TMP_DIR => 'No existe carpeta temporal para subir archivos',
                UPLOAD_ERR_CANT_WRITE => 'No se pudo escribir la imagen en disco',
                UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida de la imagen'
            ];

            return ['success' => false, 'message' => $messages[$uploadError] ?? 'Error al subir la imagen'];
        }

        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            return ['success' => false, 'message' => 'No se detectó un archivo válido en la petición'];
        }

        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            return ['success' => false, 'message' => 'Formato no permitido. Usa JPG, PNG, GIF o WebP'];
        }

        if ($file['size'] > $maxFileSize) {
            return ['success' => false, 'message' => 'La imagen excede 5MB'];
        }

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $fileName = time() . '_' . uniqid() . '.' . $fileExtension;
        $filePath = $directory . '/' . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $publicPath = str_replace('\\', '/', $filePath);
            $appPathNorm = str_replace('\\', '/', APP_PATH);

            if (strpos($publicPath, $appPathNorm . '/public/') === 0) {
                $relative = substr($publicPath, strlen($appPathNorm . '/public/'));
                $publicPath = 'public/' . ltrim($relative, '/');
            }

            return ['success' => true, 'file' => ltrim($publicPath, '/')];
        }

        return ['success' => false, 'message' => 'No se pudo mover la imagen al directorio de destino'];
    }

    public static function resolvePublicFileUrl($path) {
        $raw = trim((string)$path);
        if ($raw === '') {
            return '';
        }

        $normalized = str_replace('\\', '/', $raw);

        if (preg_match('/^https?:\/\//i', $normalized)) {
            return $normalized;
        }

        if (strpos($normalized, BASE_URL) === 0) {
            return $normalized;
        }

        $publicMarker = '/public/';
        $markerPos = strpos($normalized, $publicMarker);
        if ($markerPos !== false) {
            $relative = substr($normalized, $markerPos + strlen($publicMarker));
            return BASE_URL . 'public/' . ltrim($relative, '/');
        }

        if (strpos($normalized, 'public/') === 0) {
            return BASE_URL . ltrim($normalized, '/');
        }

        if (strpos($normalized, 'uploads/') === 0 || strpos($normalized, '/uploads/') === 0) {
            return BASE_URL . 'public/' . ltrim($normalized, '/');
        }

        return BASE_URL . ltrim($normalized, '/');
    }

    public static function calculateDiscount($originalPrice, $discountedPrice) {
        if ($originalPrice == 0) return 0;
        return round((($originalPrice - $discountedPrice) / $originalPrice) * 100);
    }

    public static function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    public static function json($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    public static function getLicensePlan($planId) {
        $plans = [
            1 => PLAN_STARTER,
            2 => PLAN_PROFESSIONAL,
            3 => PLAN_ENTERPRISE
        ];

        return $plans[$planId] ?? $plans[1];
    }

    public static function getDaysUntilExpiry($expiryDate) {
        $today = new DateTime();
        $expiry = new DateTime($expiryDate);
        $interval = $today->diff($expiry);
        return $interval->days;
    }

    public static function isTrialExpired($trialEndsAt) {
        return strtotime($trialEndsAt) < time();
    }

    public static function getClientIp() {
        $keys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                $value = $_SERVER[$key];
                if ($key === 'HTTP_X_FORWARDED_FOR') {
                    $parts = explode(',', $value);
                    return trim($parts[0]);
                }
                return trim($value);
            }
        }

        return '0.0.0.0';
    }

    public static function enforceRateLimit($scope, $maxRequests = 60, $windowSeconds = 60) {
        if (!isset($_SESSION['rate_limits'])) {
            $_SESSION['rate_limits'] = [];
        }

        $bucketKey = $scope . '|' . self::getClientIp();
        $now = time();

        if (!isset($_SESSION['rate_limits'][$bucketKey])) {
            $_SESSION['rate_limits'][$bucketKey] = [];
        }

        $_SESSION['rate_limits'][$bucketKey] = array_values(array_filter(
            $_SESSION['rate_limits'][$bucketKey],
            function ($ts) use ($now, $windowSeconds) {
                return ($now - $ts) < $windowSeconds;
            }
        ));

        if (count($_SESSION['rate_limits'][$bucketKey]) >= $maxRequests) {
            return false;
        }

        $_SESSION['rate_limits'][$bucketKey][] = $now;
        return true;
    }
}
