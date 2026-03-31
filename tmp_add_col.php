<?php
require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/core/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    $db->exec("ALTER TABLE categories ADD COLUMN image VARCHAR(255) NULL AFTER description");
    echo "Column added successfully.\n";
} catch (PDOException $e) {
    if ($e->getCode() == '42S21') {
        echo "Column already exists.\n";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
