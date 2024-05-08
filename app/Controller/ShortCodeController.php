<?php

namespace Practice\Task\Controller;

class ShortCodeController
{
    private static $pl_prefix = 'pr_tk_address';

    public static function showAllAddressList($atts)
    {
        $atts = shortcode_atts(
            array(
                'status' => '',
            ),
            $atts,
            'pr_tk_address_list'
        );

        // Retrieve the ID from the shortcode attributes
        $status = sanitize_text_field($atts['status']);
        global $wpdb;
        $table_name = $wpdb->prefix . self::$pl_prefix;
        if(empty($status) || $status=='all'){
            $addresses = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        } else {
            $addresses = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM $table_name WHERE status = %s", $status),
                ARRAY_A
            );
        }
        
        return self::loadTemplate(PR_ADDRESS_PLUGIN_DIR.'app/Views/AddressListTemplate',$addresses);
    }

    public static function showSingleAddressShortcode($atts)
    {
        // Parse shortcode attributes
        $atts = shortcode_atts(
            array(
                'id' => '',
            ),
            $atts,
            'pr_tk_address'
        );

        // Retrieve the ID from the shortcode attributes
        $id = sanitize_text_field($atts['id']);
        // Fetch address details from the database based on the ID
        if (!empty($id)) {
            global $wpdb;
            $table_name = $wpdb->prefix . self::$pl_prefix;
            $address = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);
            // Check if address exists
            if (!$address) {
                return 'Data is not found';
            }
            return self::loadTemplate(PR_ADDRESS_PLUGIN_DIR . 'app/Views/AddressItemTemplate', $address);
        } else {
            return 'No ID provided';
        }
    }

    public static function loadTemplate($view_name, $data = [])
    {
        ob_start();

        // Include the view file
        include $view_name . '.php';
        $content = ob_get_clean();
        return $content;
    }
}
