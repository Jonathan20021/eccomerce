<?php

require_once __DIR__ . '/../config/Database.php';

class Category {
    private $db;
    private $table = 'categories';

    public $id;
    public $store_id;
    public $name;
    public $slug;
    public $description;
    public $is_active;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (store_id, name, slug, description, is_active)
                  VALUES
                  (:store_id, :name, :slug, :description, :is_active)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':is_active', $this->is_active, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET name = :name,
                      slug = :slug,
                      description = :description,
                      is_active = :is_active,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id AND store_id = :store_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':is_active', $this->is_active, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByStore($store_id, $onlyActive = false) {
        $query = "SELECT c.*,
                         (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) AS products_count
                  FROM " . $this->table . " c
                  WHERE c.store_id = :store_id";

        if ($onlyActive) {
            $query .= " AND c.is_active = 1";
        }

        $query .= " ORDER BY c.name ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':store_id', $store_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteById($id, $store_id) {
        // Unassign products before deletion
        $unassign = $this->db->prepare("UPDATE products SET category_id = NULL WHERE category_id = :category_id AND store_id = :store_id");
        $unassign->bindParam(':category_id', $id, PDO::PARAM_INT);
        $unassign->bindParam(':store_id', $store_id, PDO::PARAM_INT);
        $unassign->execute();

        $query = "DELETE FROM " . $this->table . " WHERE id = :id AND store_id = :store_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':store_id', $store_id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
