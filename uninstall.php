<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();
$db_prefix = db_prefix();

$CI->db->query("DROP TABLE IF EXISTS `{$db_prefix}appapi_keys`");
$CI->db->query("DROP TABLE IF EXISTS `{$db_prefix}appapi_tokens`");
