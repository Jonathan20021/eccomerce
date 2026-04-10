<?php

require_once __DIR__ . '/../config/Database.php';

class CustomerAddress {
    private $db;
    private $table = 'customer_addresses';

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getByCustomer($userId, $storeId) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE user_id = :user_id AND store_id = :store_id
                  ORDER BY is_default DESC, created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id, $userId, $storeId) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE id = :id AND user_id = :user_id AND store_id = :store_id
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($userId, $storeId, $label, $recipientName, $phone, $addressLine, $city, $state, $country, $postalCode, $isDefault = false) {
        if ($isDefault) {
            $this->clearDefault($userId, $storeId);
        }

        $query = "INSERT INTO " . $this->table . "
                  (user_id, store_id, label, recipient_name, phone, address_line, city, state, country, postal_code, is_default)
                  VALUES
                  (:user_id, :store_id, :label, :recipient_name, :phone, :address_line, :city, :state, :country, :postal_code, :is_default)";

        $stmt = $this->db->prepare($query);
        $isDefaultInt = $isDefault ? 1 : 0;
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);
        $stmt->bindParam(':label', $label);
        $stmt->bindParam(':recipient_name', $recipientName);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address_line', $addressLine);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':postal_code', $postalCode);
        $stmt->bindParam(':is_default', $isDefaultInt, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return intval($this->db->lastInsertId());
        }

        return 0;
    }

    public function update($id, $userId, $storeId, $label, $recipientName, $phone, $addressLine, $city, $state, $country, $postalCode, $isDefault = false) {
        if ($isDefault) {
            $this->clearDefault($userId, $storeId);
        }

        $query = "UPDATE " . $this->table . "
                  SET label = :label,
                      recipient_name = :recipient_name,
                      phone = :phone,
                      address_line = :address_line,
                      city = :city,
                      state = :state,
                      country = :country,
                      postal_code = :postal_code,
                      is_default = :is_default,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id AND user_id = :user_id AND store_id = :store_id";

        $stmt = $this->db->prepare($query);
        $isDefaultInt = $isDefault ? 1 : 0;
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);
        $stmt->bindParam(':label', $label);
        $stmt->bindParam(':recipient_name', $recipientName);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address_line', $addressLine);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':postal_code', $postalCode);
        $stmt->bindParam(':is_default', $isDefaultInt, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id, $userId, $storeId) {
        $query = "DELETE FROM " . $this->table . "
                  WHERE id = :id AND user_id = :user_id AND store_id = :store_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getDefaultAddress($userId, $storeId) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE user_id = :user_id AND store_id = :store_id AND is_default = 1
                  ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row;
        }

        $queryFallback = "SELECT * FROM " . $this->table . "
                          WHERE user_id = :user_id AND store_id = :store_id
                          ORDER BY id DESC LIMIT 1";
        $stmtFallback = $this->db->prepare($queryFallback);
        $stmtFallback->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmtFallback->bindParam(':store_id', $storeId, PDO::PARAM_INT);
        $stmtFallback->execute();

        return $stmtFallback->fetch(PDO::FETCH_ASSOC);
    }

    private function clearDefault($userId, $storeId) {
        $query = "UPDATE " . $this->table . "
                  SET is_default = 0, updated_at = CURRENT_TIMESTAMP
                  WHERE user_id = :user_id AND store_id = :store_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $storeId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
