<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

// Create appapi_keys table if not exists
if (!$CI->db->table_exists(db_prefix() . 'appapi_keys')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "appapi_keys` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `key_name` VARCHAR(255) NULL,
        `key_value` VARCHAR(255) NULL,
        `description` TEXT NULL,
        `status` TINYINT(1) NOT NULL DEFAULT '1',
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

// Create appapi_tokens table if not exists
if (!$CI->db->table_exists(db_prefix() . 'appapi_tokens')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "appapi_tokens` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `token_name` VARCHAR(255) NULL,
        `token_value` VARCHAR(255) NULL,
        `description` TEXT NULL,
        `status` TINYINT(1) NOT NULL DEFAULT '1',
        `expires_at` DATETIME NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
