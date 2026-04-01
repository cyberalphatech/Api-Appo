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
    require_once(__DIR__ . '/install.php');
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

    $CI->app_menu->add_sidebar_menu_item('api_x_apps_main_menu', [
        'name'     => _l('api_x_apps_main_menu'),
        'collapse' => true,
        'position' => 10,
        'icon'     => 'fa fa-cogs',
    ]);

    $CI->app_menu->add_sidebar_child_item('api_x_apps_main_menu', [
        'slug'     => 'Tokens',
        'name'     => _l('api_x_apps_menu_api_tokens'),
        'href'     => admin_url('tokens'),
        'position' => 5,
        'icon'     => 'fa fa-question-circle',
    ]);
    
    $CI->app_menu->add_sidebar_child_item('api_x_apps_main_menu', [
        'slug'     => 'my_menu_item',
        'name'     => _l('api_x_apps_menu_my_menu_item'),
        'href'     => admin_url('my_menu_item'),
        'position' => 10,
        'icon'     => 'fa fa-question-circle',
    ]);
    
    $CI->app_menu->add_sidebar_child_item('api_x_apps_main_menu', [
        'slug'     => 'my_menu_item2',
        'name'     => _l('api_x_apps_menu_my_menu_item2'),
        'href'     => admin_url('my_menu_item2'),
        'position' => 15,
        'icon'     => 'fa fa-question-circle',
    ]);
}

// As per instructions, create CRUD for each table, even if not in menu.
// To make the Keys table accessible, you can uncomment the following lines:
/*
hooks()->add_action('admin_init_menu_items', function(){
    $CI = &get_instance();
    $CI->app_menu->add_sidebar_child_item('api_x_apps_main_menu', [
        'slug'     => 'keys',
        'name'     => 'API Keys (Example)',
        'href'     => admin_url('keys'),
        'position' => 20,
        'icon'     => 'fa fa-key',
    ]);
});
*/
