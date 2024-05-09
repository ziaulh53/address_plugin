<?php

namespace Practice\Task;

use Practice\Task\Vite;

class Application
{
    public $pl_prefix = 'pr_tk';

    public function __construct($file)
    {
        // Register activation hook
        register_activation_hook($file, array($this, 'create_address_table'));

        // Add action
        add_action('admin_menu', [$this, 'create_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
        $this->loadRequiredFiles();
    }

    // Method to execute on plugin activation
    public function create_address_table()
    {
        global $wpdb;
        if (!$this->is_address_table_exists()) {
            $table_name = $wpdb->prefix . $this->pl_prefix;
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

            // Include upgrade.php for dbDelta function
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            // Execute the SQL query
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

    // Method to initialize actions
    public function create_admin_menu()
    {
        add_menu_page(
            'Address management',
            'Address',
            'manage_options',
            $this->pl_prefix . '_address',
            array($this, 'show_address_page'),
            'dashicons-admin-settings',
            11
        );
    }

    public function show_address_page()
    {
        echo '<div id="pr_tk_admin"></div>';
    }

    public function enqueueAssets()
    {
        if (isset($_GET['page']) && sanitize_text_field($_GET['page']) === 'pr_tk_address') {
            Vite::enqueueScript('admin_app', 'admin/app.js', [], '1.0', true);
        }

        Vite::enqueueStyle('admin_app', 'scss/admin/admin.scss', [], '1.0', true);
        // ajax script

    }

    protected function loadRequiredFiles()
    {
        include_once PR_ADDRESS_PLUGIN_DIR .'app/Hooks/Actions.php';
        include_once PR_ADDRESS_PLUGIN_DIR .'boot/globals.php';
        include_once PR_ADDRESS_PLUGIN_DIR .'app/Controller/AddressController.php';
    }

}
