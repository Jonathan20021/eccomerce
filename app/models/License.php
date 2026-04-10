<?php

require_once __DIR__ . '/../config/Database.php';

class License {
    private $db;
    private $table = 'licenses';

    public $id;
    public $code;
    public $store_id;
    public $plan_id;
    public $status;
    public $trial_days;
    public $trial_ends_at;
    public $starts_at;
    public $expires_at;
    public $is_trial;
    public $features;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function create() {
        $this->code = $this->generateCode();
        $this->code = strtoupper($this->code);
        $this->trial_ends_at = null;
        $this->expires_at = null;
        
        if ($this->is_trial) {
            $this->trial_ends_at = date('Y-m-d H:i:s', strtotime('+' . $this->trial_days . ' days'));
        } else {
            $this->expires_at = date('Y-m-d H:i:s', strtotime('+1 year'));
        }

        $query = "INSERT INTO " . $this->table . " 
                  (code, store_id, plan_id, status, trial_days, trial_ends_at, expires_at, is_trial, features) 
                  VALUES 
                  (:code, :store_id, :plan_id, :status, :trial_days, :trial_ends_at, :expires_at, :is_trial, :features)";

        $stmt = $this->db->prepare($query);

        $features = json_encode($this->features);
        $status = 'active';
        
        $stmt->bindParam(':code', $this->code);
        $stmt->bindParam(':store_id', $this->store_id);
        $stmt->bindParam(':plan_id', $this->plan_id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':trial_days', $this->trial_days);
        $stmt->bindParam(':trial_ends_at', $this->trial_ends_at);
        $stmt->bindParam(':expires_at', $this->expires_at);
        $stmt->bindParam(':is_trial', $this->is_trial);
        $stmt->bindParam(':features', $features);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function findByCode($code) {
        $query = "SELECT * FROM " . $this->table . " WHERE code = :code LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByStoreId($store_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE store_id = :store_id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findActiveByStoreId($store_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE store_id = :store_id AND status = 'active'
                  AND (trial_ends_at IS NULL OR trial_ends_at > NOW())
                  AND (expires_at IS NULL OR expires_at > NOW())
                  ORDER BY created_at DESC
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isValidLicense($license_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE id = :id AND status = 'active' 
                  AND (trial_ends_at IS NULL OR trial_ends_at > NOW())
                  AND (expires_at IS NULL OR expires_at > NOW())";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $license_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function activateLicense($code, $store_id) {
        $license = $this->findByCode($code);
        
        if (!$license) {
            return ['success' => false, 'message' => 'Código de licencia no válido'];
        }

        if ($license['store_id'] !== null) {
            return ['success' => false, 'message' => 'Esta licencia ya está siendo utilizada'];
        }

        if ($license['status'] !== 'active') {
            return ['success' => false, 'message' => 'La licencia no está activa'];
        }

        if (!empty($license['trial_ends_at']) && strtotime($license['trial_ends_at']) <= time()) {
            return ['success' => false, 'message' => 'La licencia de prueba ya expiró'];
        }

        if (!empty($license['expires_at']) && strtotime($license['expires_at']) <= time()) {
            return ['success' => false, 'message' => 'La licencia ya expiró'];
        }

        $this->db->beginTransaction();

        $query = "UPDATE " . $this->table . " SET store_id = :store_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id);
        $stmt->bindParam(':id', $license['id']);

        if (!$stmt->execute()) {
            $this->db->rollBack();
            return ['success' => false, 'message' => 'Error al activar la licencia'];
        }

        $storeQuery = "UPDATE stores SET license_id = :license_id WHERE id = :store_id";
        $storeStmt = $this->db->prepare($storeQuery);
        $storeStmt->bindParam(':license_id', $license['id']);
        $storeStmt->bindParam(':store_id', $store_id);

        if (!$storeStmt->execute()) {
            $this->db->rollBack();
            return ['success' => false, 'message' => 'Error al vincular la licencia a la tienda'];
        }

        $this->db->commit();
        return ['success' => true, 'message' => 'Licencia activada exitosamente'];
    }

    public function generateCode() {
        return 'KYROS-' . strtoupper(bin2hex(random_bytes(6))) . '-' . time();
    }

    public function getAllLicenses($limit = 20, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteById($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function updateFeaturesById($id, $features) {
        $query = "UPDATE " . $this->table . " SET features = :features WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $payload = json_encode($features);
        $stmt->bindParam(':features', $payload);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
