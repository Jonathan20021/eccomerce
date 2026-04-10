<?php

require_once __DIR__ . '/../config/Database.php';

class User {
    private $db;
    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $phone;
    public $role;
    public $store_id;
    public $is_active;
    public $email_verified;
    public $profile_image;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (name, email, password, phone, role, store_id, is_active, email_verified) 
                  VALUES 
                  (:name, :email, :password, :phone, :role, :store_id, :is_active, :email_verified)";

        $stmt = $this->db->prepare($query);

        // Bind values
        $passwordHash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':store_id', $this->store_id);
        $stmt->bindParam(':is_active', $this->is_active);
        $stmt->bindParam(':email_verified', $this->email_verified);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    public function assignStore($userId, $storeId) {
        $query = "UPDATE " . $this->table . " SET store_id = :store_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $storeId);
        $stmt->bindParam(':id', $userId);

        return $stmt->execute();
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findCustomerByEmailAndStore($email, $storeId) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE email = :email AND store_id = :store_id AND role = :role
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $role = ROLE_CUSTOMER;
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function customerEmailExistsInStore($email, $storeId, $excludeId = 0) {
        $query = "SELECT id FROM " . $this->table . "
                  WHERE email = :email AND store_id = :store_id AND role = :role";
        if ($excludeId > 0) {
            $query .= " AND id != :exclude_id";
        }
        $query .= " LIMIT 1";

        $stmt = $this->db->prepare($query);
        $role = ROLE_CUSTOMER;
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role);
        if ($excludeId > 0) {
            $stmt->bindParam(':exclude_id', $excludeId, PDO::PARAM_INT);
        }
        $stmt->execute();

        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCustomerProfile($id, $storeId, $name, $email, $phone) {
        $query = "UPDATE " . $this->table . "
                  SET name = :name,
                      email = :email,
                      phone = :phone,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id AND store_id = :store_id AND role = :role";

        $stmt = $this->db->prepare($query);
        $role = ROLE_CUSTOMER;
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    public function getCustomersByStore($storeId, $limit = 20, $offset = 0, $search = '') {
        $query = "SELECT u.*,
                         COUNT(o.id) AS orders_count,
                         COALESCE(SUM(CASE WHEN o.status != 'cancelled' THEN o.total ELSE 0 END), 0) AS total_spent,
                         MAX(o.created_at) AS last_order_at
                  FROM " . $this->table . " u
                  LEFT JOIN orders o ON o.user_id = u.id AND o.store_id = u.store_id
                  WHERE u.store_id = :store_id AND u.role = :role";

        if ($search !== '') {
            $query .= " AND (u.name LIKE :search OR u.email LIKE :search OR u.phone LIKE :search)";
        }

        $query .= " GROUP BY u.id
                    ORDER BY u.created_at DESC
                    LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);
        $role = ROLE_CUSTOMER;
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);
        $stmt->bindValue(':role', $role);
        if ($search !== '') {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $stmt->bindValue(':offset', intval($offset), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countCustomersByStore($storeId, $search = '') {
        $query = "SELECT COUNT(*) AS total
                  FROM " . $this->table . "
                  WHERE store_id = :store_id AND role = :role";

        if ($search !== '') {
            $query .= " AND (name LIKE :search OR email LIKE :search OR phone LIKE :search)";
        }

        $stmt = $this->db->prepare($query);
        $role = ROLE_CUSTOMER;
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);
        $stmt->bindValue(':role', $role);
        if ($search !== '') {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($row['total'] ?? 0);
    }

    public function findCustomerByIdAndStore($id, $storeId) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE id = :id AND store_id = :store_id AND role = :role
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $role = ROLE_CUSTOMER;
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
        $stmt->bindValue(':store_id', intval($storeId), PDO::PARAM_INT);
        $stmt->bindValue(':role', $role);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name, 
                      email = :email, 
                      phone = :phone, 
                      profile_image = :profile_image,
                      updated_at = CURRENT_TIMESTAMP 
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':profile_image', $this->profile_image);

        return $stmt->execute();
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public function getUserByStoreId($store_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE store_id = :store_id AND role != :role";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id);
        $role = 'superadmin';
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWithStore($limit = 50, $offset = 0, $filters = []) {
        $query = "SELECT u.*, s.name AS store_name, s.slug AS store_slug
                  FROM " . $this->table . " u
                  LEFT JOIN stores s ON s.id = u.store_id
                  WHERE 1=1";

        $params = [];

        if (!empty($filters['role'])) {
            $query .= " AND u.role = :role";
            $params[':role'] = $filters['role'];
        }

        if (!empty($filters['store_id'])) {
            $query .= " AND u.store_id = :store_id";
            $params[':store_id'] = intval($filters['store_id']);
        }

        if (!empty($filters['search'])) {
            $query .= " AND (u.name LIKE :search OR u.email LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        $query .= " ORDER BY u.created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $stmt->bindValue(':offset', intval($offset), PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function emailExistsExceptId($email, $excludeId) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email AND id != :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $excludeId, PDO::PARAM_INT);
        $stmt->execute();

        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateByAdmin($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET name = :name,
                      email = :email,
                      phone = :phone,
                      role = :role,
                      store_id = :store_id,
                      is_active = :is_active,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':phone', $data['phone']);
        $stmt->bindValue(':role', $data['role']);
        if ($data['store_id'] === null) {
            $stmt->bindValue(':store_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':store_id', intval($data['store_id']), PDO::PARAM_INT);
        }
        $stmt->bindValue(':is_active', !empty($data['is_active']) ? 1 : 0, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updatePassword($id, $newPassword) {
        $query = "UPDATE " . $this->table . "
                  SET password = :password,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt->bindValue(':password', $hash);
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function setActiveStatus($id, $isActive) {
        $query = "UPDATE " . $this->table . " SET is_active = :is_active, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
        $stmt->bindValue(':is_active', $isActive ? 1 : 0, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteById($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function countAll($filters = []) {
        $query = "SELECT COUNT(*) AS total FROM " . $this->table . " WHERE 1=1";
        $params = [];

        if (!empty($filters['role'])) {
            $query .= " AND role = :role";
            $params[':role'] = $filters['role'];
        }

        if (!empty($filters['store_id'])) {
            $query .= " AND store_id = :store_id";
            $params[':store_id'] = intval($filters['store_id']);
        }

        if (array_key_exists('is_active', $filters)) {
            $query .= " AND is_active = :is_active";
            $params[':is_active'] = !empty($filters['is_active']) ? 1 : 0;
        }

        if (!empty($filters['search'])) {
            $query .= " AND (name LIKE :search OR email LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            if ($key === ':is_active' || $key === ':store_id') {
                $stmt->bindValue($key, intval($value), PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return intval($row['total'] ?? 0);
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}
