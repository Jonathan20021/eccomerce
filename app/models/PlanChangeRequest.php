<?php

require_once __DIR__ . '/../config/Database.php';

class PlanChangeRequest {
    private $db;
    private $table = 'plan_change_requests';

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->ensureTable();
    }

    private function ensureTable() {
        $query = "CREATE TABLE IF NOT EXISTS plan_change_requests (
                    id INT PRIMARY KEY AUTO_INCREMENT,
                    store_id INT NOT NULL,
                    requested_by_user_id INT NOT NULL,
                    current_plan_id INT NOT NULL,
                    requested_plan_id INT NOT NULL,
                    reason TEXT,
                    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
                    reviewed_by_user_id INT NULL,
                    reviewed_at TIMESTAMP NULL,
                    decision_note TEXT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    INDEX idx_plan_change_store (store_id),
                    INDEX idx_plan_change_status (status),
                    INDEX idx_plan_change_created_at (created_at),
                    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE CASCADE,
                    FOREIGN KEY (requested_by_user_id) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY (reviewed_by_user_id) REFERENCES users(id) ON DELETE SET NULL
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        $this->db->exec($query);
    }

    public function createRequest($payload) {
        $query = "INSERT INTO " . $this->table . "
                  (store_id, requested_by_user_id, current_plan_id, requested_plan_id, reason, status)
                  VALUES
                  (:store_id, :requested_by_user_id, :current_plan_id, :requested_plan_id, :reason, 'pending')";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':store_id', intval($payload['store_id']), PDO::PARAM_INT);
        $stmt->bindValue(':requested_by_user_id', intval($payload['requested_by_user_id']), PDO::PARAM_INT);
        $stmt->bindValue(':current_plan_id', intval($payload['current_plan_id']), PDO::PARAM_INT);
        $stmt->bindValue(':requested_plan_id', intval($payload['requested_plan_id']), PDO::PARAM_INT);
        $stmt->bindValue(':reason', strval($payload['reason'] ?? ''));

        if ($stmt->execute()) {
            return intval($this->db->lastInsertId());
        }

        return false;
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLatestPendingByStore($storeId) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE store_id = :store_id AND status = 'pending'
                  ORDER BY created_at DESC
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByStore($storeId, $limit = 20, $offset = 0) {
        $query = "SELECT r.*, reviewer.name AS reviewed_by_name
                  FROM " . $this->table . " r
                  LEFT JOIN users reviewer ON reviewer.id = r.reviewed_by_user_id
                  WHERE r.store_id = :store_id
                  ORDER BY r.created_at DESC
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);
        $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $stmt->bindValue(':offset', intval($offset), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWithStore($limit = 30, $offset = 0, $status = '') {
        $query = "SELECT r.*, s.name AS store_name, requester.name AS requester_name, reviewer.name AS reviewed_by_name
                  FROM " . $this->table . " r
                  INNER JOIN stores s ON s.id = r.store_id
                  INNER JOIN users requester ON requester.id = r.requested_by_user_id
                  LEFT JOIN users reviewer ON reviewer.id = r.reviewed_by_user_id
                  WHERE 1=1";

        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query .= " AND r.status = :status";
        }

        $query .= " ORDER BY
                    CASE WHEN r.status = 'pending' THEN 0 ELSE 1 END,
                    r.created_at DESC
                    LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $stmt->bindValue(':status', $status);
        }
        $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $stmt->bindValue(':offset', intval($offset), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll($status = '') {
        $query = "SELECT COUNT(*) AS total FROM " . $this->table . " WHERE 1=1";
        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query .= " AND status = :status";
        }

        $stmt = $this->db->prepare($query);
        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $stmt->bindValue(':status', $status);
        }
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($row['total'] ?? 0);
    }

    public function markApproved($id, $reviewedByUserId, $decisionNote = '') {
        $query = "UPDATE " . $this->table . "
                  SET status = 'approved',
                      reviewed_by_user_id = :reviewed_by_user_id,
                      reviewed_at = CURRENT_TIMESTAMP,
                      decision_note = :decision_note,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id AND status = 'pending'";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':reviewed_by_user_id', intval($reviewedByUserId), PDO::PARAM_INT);
        $stmt->bindValue(':decision_note', strval($decisionNote));
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);

        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    public function markRejected($id, $reviewedByUserId, $decisionNote = '') {
        $query = "UPDATE " . $this->table . "
                  SET status = 'rejected',
                      reviewed_by_user_id = :reviewed_by_user_id,
                      reviewed_at = CURRENT_TIMESTAMP,
                      decision_note = :decision_note,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id AND status = 'pending'";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':reviewed_by_user_id', intval($reviewedByUserId), PDO::PARAM_INT);
        $stmt->bindValue(':decision_note', strval($decisionNote));
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);

        return $stmt->execute() && $stmt->rowCount() > 0;
    }
}
