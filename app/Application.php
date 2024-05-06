<?php

namespace Practice\Task;

class Application
{
    private $table_prefix = 'pr_tk_address';

    public function __construct($file)
    {
        // Register activation hook
        register_activation_hook($file, array($this, 'create_address_table'));

        // Add action
        add_action('admin_menu', array($this, 'create_admin_menu'));
    }

    // Method to execute on plugin activation
    public function create_address_table()
    {
        global $wpdb;

        if (!$this->is_address_table_exists()) {
            $table_name = $wpdb->prefix . $this->table_prefix;
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
        $table_name = $this->table_prefix . 'todos';
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
            $this->table_prefix.'address',
            array($this,'show_address_page'),
            'dashicons-admin-settings',
            11
        );
    }

    public function show_address_page (){
    ?>
	 <div>
		<h1>Test</h1>
		<button>Submit</button>
		<input id="name" name="name" />
	 </div>
    <?php
    }
}
