<?php

namespace Practice\Task;

use Practice\Task\Vite;

class Application
{
    public $pl_prefix = 'pr_tk';

    public function __construct($file)
    {
        // Register activation and deactivation hooks
        register_activation_hook($file, array($this, 'plugin_activate'));
        register_deactivation_hook($file, array($this, 'plugin_deactivate'));

        // Add admin menu and enqueue assets
        add_action('admin_menu', [$this, 'create_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);

        $this->load_required_files();
    }

    // Method to execute on plugin activation
    public function plugin_activate()
    {
        $this->create_address_table();
        $this->add_edit_plugins_capability();
    }

    // Method to execute on plugin deactivation
    public function plugin_deactivate()
    {
        $this->remove_edit_plugins_capability();
    }


     // Method to create address table
     public function create_address_table()
     {
         global $wpdb;
         $table_name = $wpdb->prefix . $this->pl_prefix . '_address';
         if (!$wpdb->get_var("SHOW TABLES LIKE '$table_name'")) {
             $charset_collate = $wpdb->get_charset_collate();
             $sql = "CREATE TABLE $table_name (
                 id mediumint(9) NOT NULL AUTO_INCREMENT,
                 name varchar(255) NOT NULL,
                 country text,
                 state text,
                 city text,
                 zipcode text,
                 status varchar(20) NOT NULL DEFAULT 'active',
                 created_at datetime NOT NULL,
                 PRIMARY KEY  (id)
             ) $charset_collate;";
             require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
             dbDelta($sql);
         }
     }

    public function is_address_table_exists()
    {
        global $wpdb;
        $table_name = $this->pl_prefix . 'todos';
        $sql = "SHOW TABLES LIKE '{$table_name}'";
        return $wpdb->get_var($sql) === $table_name;
    }

    // Method to add admin menu
    public function create_admin_menu()
    {
        add_menu_page(
            'Address Management',
            'Address',
            'edit_pages',
            $this->pl_prefix . '_address',
            array($this, 'show_address_page'),
            'dashicons-admin-settings',
            11
        );
        add_submenu_page(
            $this->pl_prefix . '_address',
            'PR TK User Manage',
            'User Manage',
            'manage_options',
            'pr_tk_address#/user-manage',
            array($this, 'show_address_page')
        );
    }

    public function show_address_page()
    {
        echo '<div id="pr_tk_admin"></div>';
    }

    public function enqueue_assets()
    {
        if (isset($_GET['page']) && sanitize_text_field($_GET['page']) === 'pr_tk_address') {
            Vite::enqueueScript('admin_app', 'admin/app.js', [], '1.0', true);
        }
        Vite::enqueueStyle('admin_app', 'scss/admin/admin.scss', [], '1.0', true);
        // ajax script
        wp_localize_script(
            'admin_app',
            $this->pl_prefix.'_get_permission_list',
            [
                'permissions' => wp_get_current_user()->allcaps
            ]
        );

    }

    // Method to add edit_plugins capability to Editor role
    public function add_edit_plugins_capability()
    {
        $editor_role = get_role('administrator');
        if ($editor_role && !$editor_role->has_cap('delete_address')) {
            $editor_role->add_cap('delete_address', true);
            $editor_role->add_cap('edit_address', true);
        }
    }

    // Method to remove edit_plugins capability from Editor role
    public function remove_edit_plugins_capability()
    {
        $editor_role = get_role('editor');
        if ($editor_role && $editor_role->has_cap('edit_plugins')) {
            $editor_role->remove_cap('edit_plugins');
        }
    }

    protected function load_required_files()
    {
        include_once PR_ADDRESS_PLUGIN_DIR . 'app/Hooks/Actions.php';
        include_once PR_ADDRESS_PLUGIN_DIR . 'boot/globals.php';
    }
}
