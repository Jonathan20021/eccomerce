<?php

require_once __DIR__ . '/../config/Database.php';

class Store {
    private $db;
    private $table = 'stores';

    public $id;
    public $owner_id;
    public $name;
    public $slug;
    public $description;
    public $logo;
    public $banner;
    public $domain;
    public $phone;
    public $whatsapp_number;
    public $email;
    public $address;
    public $city;
    public $state;
    public $country;
    public $postal_code;
    public $currency;
    public $license_id;
    public $plan_id;
    public $is_active;
    public $verified;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (owner_id, name, slug, description, phone, email, plan_id, is_active) 
                  VALUES 
                  (:owner_id, :name, :slug, :description, :phone, :email, :plan_id, :is_active)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':owner_id', $this->owner_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':plan_id', $this->plan_id);
        $stmt->bindParam(':is_active', $this->is_active);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBySlug($slug) {
        $query = "SELECT * FROM " . $this->table . " WHERE slug = :slug LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByOwnerId($owner_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE owner_id = :owner_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':owner_id', $owner_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name, 
                      description = :description, 
                      logo = :logo, 
                      banner = :banner,
                      phone = :phone,
                      whatsapp_number = :whatsapp_number,
                      email = :email,
                      address = :address,
                      city = :city,
                      state = :state,
                      country = :country,
                      postal_code = :postal_code,
                      currency = :currency,
                      updated_at = CURRENT_TIMESTAMP 
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':logo', $this->logo);
        $stmt->bindParam(':banner', $this->banner);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':whatsapp_number', $this->whatsapp_number);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':state', $this->state);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':postal_code', $this->postal_code);
        $stmt->bindParam(':currency', $this->currency);

        return $stmt->execute();
    }

    public function getAll($limit = 10, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assignLicense($store_id, $license_id) {
        $query = "UPDATE " . $this->table . " SET license_id = :license_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':license_id', $license_id);
        $stmt->bindParam(':id', $store_id);

        return $stmt->execute();
    }

    public function deleteById($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function setActiveStatus($id, $isActive) {
        $query = "UPDATE " . $this->table . " SET is_active = :is_active, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $activeValue = $isActive ? 1 : 0;
        $stmt->bindParam(':is_active', $activeValue, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function setOwner($store_id, $owner_id) {
        $query = "UPDATE " . $this->table . " SET owner_id = :owner_id, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':owner_id', $owner_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $store_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
