<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Api x Apps
Description: Apis builder for external app Connection
Author: BIT Solutions OU
Version: 1.0.0
Requires at least: 3.0.0
*/

define('API_X_APPS_MODULE_NAME', 'api_x_apps');

/**
 * Register activation hook
 */
register_activation_hook(API_X_APPS_MODULE_NAME, 'api_x_apps_activation_hook');

function api_x_apps_activation_hook()
{
    $CI = &get_instance();
    
    // [v0] Debug: Log activation hook triggered
    log_activity('[v0] DEBUG: api_x_apps activation hook triggered');
    error_log('[v0] DEBUG: api_x_apps activation hook triggered at ' . date('Y-m-d H:i:s'));
    
    // [v0] Debug: Check if install.php exists
    $install_file = __DIR__ . '/install.php';
    if (file_exists($install_file)) {
        log_activity('[v0] DEBUG: install.php found at ' . $install_file);
        error_log('[v0] DEBUG: install.php found at ' . $install_file);
    } else {
        log_activity('[v0] DEBUG: install.php NOT FOUND at ' . $install_file);
        error_log('[v0] DEBUG: install.php NOT FOUND at ' . $install_file);
    }
    
    require_once($install_file);
    
    // [v0] Debug: Log after require
    log_activity('[v0] DEBUG: install.php loaded successfully');
    error_log('[v0] DEBUG: install.php loaded successfully');
}

/**
 * Register uninstall hook
 */
register_uninstall_hook(API_X_APPS_MODULE_NAME, 'api_x_apps_uninstall_hook');

function api_x_apps_uninstall_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/uninstall.php');
}

/**
 * Register language files
 */
register_language_files(API_X_APPS_MODULE_NAME, [API_X_APPS_MODULE_NAME]);

/**
 * Add module permissions
 */
hooks()->add_action('app_admin_permissions', 'api_x_apps_permissions');

function api_x_apps_permissions($permissions)
{
    $capabilities = [
        'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
        'create' => _l('permission_create'),
        'edit'   => _l('permission_edit'),
        'delete' => _l('permission_delete'),
    ];

    $permissions['api_x_apps_keys'] = [
        'name'         => _l('api_x_apps_keys'),
        'capabilities' => $capabilities,
    ];
    
    $permissions['api_x_apps_tokens'] = [
        'name'         => _l('api_x_apps_tokens'),
        'capabilities' => $capabilities,
    ];

    return $permissions;
}

/**
 * Add admin menu items
 */
hooks()->add_action('admin_init_menu_items', 'api_x_apps_add_menu_items');

function api_x_apps_add_menu_items()
{
    $CI = &get_instance();

    // Main menu: Api Appo
    $CI->app_menu->add_sidebar_menu_item('api_appo_main_menu', [
        'name'     => _l('api_appo_main_menu'),
        'collapse' => true,
        'position' => 10,
        'icon'     => 'fa fa-plug',
    ]);

    // Child menu: Api Tokens
    $CI->app_menu->add_sidebar_child_item('api_appo_main_menu', [
        'slug'     => 'api_tokens',
        'name'     => _l('api_appo_menu_api_tokens'),
        'href'     => admin_url('api_x_apps/tokens'),
        'position' => 5,
        'icon'     => 'fa fa-ticket',
    ]);
    
    // Child menu: Api Keys
    $CI->app_menu->add_sidebar_child_item('api_appo_main_menu', [
        'slug'     => 'api_keys',
        'name'     => _l('api_appo_menu_api_keys'),
        'href'     => admin_url('api_x_apps/keys'),
        'position' => 10,
        'icon'     => 'fa fa-key',
    ]);
}
