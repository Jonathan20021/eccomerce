<?php

$migrationFile = __DIR__ . '/2026_04_10_customer_portal.sql';

if (!file_exists($migrationFile)) {
    fwrite(STDERR, "Migration file not found: {$migrationFile}\n");
    exit(1);
}

$sql = file_get_contents($migrationFile);
if ($sql === false) {
    fwrite(STDERR, "Unable to read migration file.\n");
    exit(1);
}

try {
    $pdo = new PDO(
        'mysql:host=129.121.81.172;dbname=neetjbte_eccomerce;charset=utf8mb4',
        'neetjbte_eccomerce',
        'Hacker#2002',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $pdo->exec($sql);
    echo "Migration OK\n";
    exit(0);
} catch (Throwable $e) {
    fwrite(STDERR, "Migration failed: " . $e->getMessage() . "\n");
    exit(1);
}
