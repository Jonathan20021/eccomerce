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

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}
