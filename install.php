<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!class_exists('CI_Migration')) {
    return;
}

class Migration_Create_api_x_apps_tables extends CI_Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . db_prefix() . "appapi_keys` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `new_column_1` VARCHAR(255) NULL,
            `new_column_2` VARCHAR(255) NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        $this->db->query("CREATE TABLE IF NOT EXISTS `" . db_prefix() . "appapi_tokens` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `new_column_1` VARCHAR(255) NULL,
            `new_column_2` VARCHAR(255) NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    }

    public function down()
    {
        // Down migration is not used in Perfex activation, but good practice to have.
        $this->dbforge->drop_table('appapi_keys', true);
        $this->dbforge->drop_table('appapi_tokens', true);
    }
}
