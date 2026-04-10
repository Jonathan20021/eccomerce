<?php

require_once __DIR__ . '/../config/Database.php';

class Setting {
    private $db;
    private $table = 'settings';

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getValue($key, $default = null) {
        $query = "SELECT setting_value FROM " . $this->table . " WHERE setting_key = :key LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return $default;
        }

        return $row['setting_value'];
    }

    public function setValue($key, $value, $type = 'json') {
        $query = "INSERT INTO " . $this->table . " (setting_key, setting_value, type)
                  VALUES (:key, :value, :type)
                  ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), type = VALUES(type), updated_at = CURRENT_TIMESTAMP";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':key', $key);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':type', $type);

        return $stmt->execute();
    }

    public function getStoreTheme($storeId) {
        $storeId = intval($storeId);
        $menuKey = 'store_' . $storeId . '_menu_json';
        $footerKey = 'store_' . $storeId . '_footer_json';

        $menuRaw = $this->getValue($menuKey, '');
        $footerRaw = $this->getValue($footerKey, '');

        $menu = [];
        $footer = [];

        if ($menuRaw) {
            $decoded = json_decode($menuRaw, true);
            if (is_array($decoded)) {
                $menu = $decoded;
            }
        }

        if ($footerRaw) {
            $decoded = json_decode($footerRaw, true);
            if (is_array($decoded)) {
                $footer = $decoded;
            }
        }

        return ['menu' => $menu, 'footer' => $footer];
    }
}
