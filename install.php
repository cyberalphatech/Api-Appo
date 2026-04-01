<?php
defined('BASEPATH') or exit('No direct script access allowed');

// [v0] Debug: install.php has been loaded
log_activity('[v0] DEBUG: install.php execution started');
error_log('[v0] DEBUG: install.php execution started at ' . date('Y-m-d H:i:s'));

$CI = &get_instance();

// [v0] Debug: Check if db is available
if (isset($CI->db)) {
    log_activity('[v0] DEBUG: Database connection available');
    error_log('[v0] DEBUG: Database connection available');
} else {
    log_activity('[v0] DEBUG: Database connection NOT available');
    error_log('[v0] DEBUG: Database connection NOT available');
}

// [v0] Debug: Attempt to create tables
try {
    log_activity('[v0] DEBUG: Attempting to create appapi_keys table');
    error_log('[v0] DEBUG: Attempting to create appapi_keys table');
    
    $CI->db->query("CREATE TABLE IF NOT EXISTS `" . db_prefix() . "appapi_keys` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `key_name` VARCHAR(255) NULL,
        `key_value` VARCHAR(255) NULL,
        `description` TEXT NULL,
        `status` TINYINT(1) DEFAULT 1,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    
    log_activity('[v0] DEBUG: appapi_keys table created or already exists');
    error_log('[v0] DEBUG: appapi_keys table created or already exists');

    log_activity('[v0] DEBUG: Attempting to create appapi_tokens table');
    error_log('[v0] DEBUG: Attempting to create appapi_tokens table');
    
    $CI->db->query("CREATE TABLE IF NOT EXISTS `" . db_prefix() . "appapi_tokens` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `token_name` VARCHAR(255) NULL,
        `token_value` VARCHAR(255) NULL,
        `description` TEXT NULL,
        `status` TINYINT(1) DEFAULT 1,
        `expires_at` DATETIME NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    
    log_activity('[v0] DEBUG: appapi_tokens table created or already exists');
    error_log('[v0] DEBUG: appapi_tokens table created or already exists');
    
    log_activity('[v0] DEBUG: install.php completed successfully');
    error_log('[v0] DEBUG: install.php completed successfully');
    
} catch (Exception $e) {
    log_activity('[v0] DEBUG: ERROR during table creation: ' . $e->getMessage());
    error_log('[v0] DEBUG: ERROR during table creation: ' . $e->getMessage());
}
