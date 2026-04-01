<?php
/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Api Appo
Description: API management module for external app connections - Manage API Tokens and API Keys
Author: BIT Solutions OU
Version: 1.0.0
Requires at least: 2.3.*
*/

define('API_X_APPS_MODULE_NAME', 'api_x_apps');

/**
 * Register activation hook - runs when module is activated
 */
register_activation_hook(API_X_APPS_MODULE_NAME, 'api_x_apps_activation_hook');

function api_x_apps_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Register deactivation hook - runs when module is deactivated
 */
register_deactivation_hook(API_X_APPS_MODULE_NAME, 'api_x_apps_deactivation_hook');

function api_x_apps_deactivation_hook()
{
    // Perform any cleanup tasks when module is deactivated
}

/**
 * Register uninstall hook - runs when module is uninstalled
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
 * Using 'admin_init' hook as per official Perfex CRM documentation
 */
hooks()->add_action('admin_init', 'api_x_apps_init_menu_items');

function api_x_apps_init_menu_items()
{
    $CI = &get_instance();

    // Main menu: Api Appo (parent collapsible menu)
    $CI->app_menu->add_sidebar_menu_item('api-appo', [
        'name'     => _l('api_appo_main_menu'),
        'collapse' => true,
        'position' => 32,
        'icon'     => 'fa fa-plug',
    ]);

    // Child menu: Api Tokens
    $CI->app_menu->add_sidebar_children_item('api-appo', [
        'slug'     => 'api-tokens',
        'name'     => _l('api_appo_menu_api_tokens'),
        'href'     => admin_url('api_x_apps/tokens'),
        'position' => 1,
        'icon'     => 'fa fa-ticket',
    ]);
    
    // Child menu: Api Keys
    $CI->app_menu->add_sidebar_children_item('api-appo', [
        'slug'     => 'api-keys',
        'name'     => _l('api_appo_menu_api_keys'),
        'href'     => admin_url('api_x_apps/keys'),
        'position' => 2,
        'icon'     => 'fa fa-key',
    ]);
}
