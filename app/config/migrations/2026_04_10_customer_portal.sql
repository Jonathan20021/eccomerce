-- Migracion incremental: portal de cliente (direcciones)
-- Fecha: 2026-04-10

START TRANSACTION;

CREATE TABLE IF NOT EXISTS customer_addresses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    store_id INT NOT NULL,
    label VARCHAR(50) DEFAULT 'Principal',
    recipient_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address_line TEXT NOT NULL,
    city VARCHAR(100),
    state VARCHAR(100),
    country VARCHAR(100),
    postal_code VARCHAR(20),
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_customer_addresses_user
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_customer_addresses_store
        FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET @idx_user_store_exists := (
    SELECT COUNT(*)
    FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = 'customer_addresses'
      AND index_name = 'idx_customer_address_user_store'
);

SET @sql_user_store := IF(
    @idx_user_store_exists = 0,
    'CREATE INDEX idx_customer_address_user_store ON customer_addresses(user_id, store_id)',
    'SELECT 1'
);
PREPARE stmt_user_store FROM @sql_user_store;
EXECUTE stmt_user_store;
DEALLOCATE PREPARE stmt_user_store;

SET @idx_default_exists := (
    SELECT COUNT(*)
    FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = 'customer_addresses'
      AND index_name = 'idx_customer_address_default'
);

SET @sql_default := IF(
    @idx_default_exists = 0,
    'CREATE INDEX idx_customer_address_default ON customer_addresses(user_id, store_id, is_default)',
    'SELECT 1'
);
PREPARE stmt_default FROM @sql_default;
EXECUTE stmt_default;
DEALLOCATE PREPARE stmt_default;

COMMIT;
