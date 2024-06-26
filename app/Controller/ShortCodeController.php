<?php

namespace Practice\Task\Controller;

use function PracticeTask\loadTemplate;

class ShortCodeController
{
    private static $pl_prefix = 'pr_tk_address';

    public static function showAllAddressList($atts)
    {
        $atts = shortcode_atts(
            array(
                'status' => '',
                'id' => ''
            ),
            $atts,
            'pr_tk_address'
        );

        // Retrieve the ID from the shortcode attributes
        $status = sanitize_text_field($atts['status']);
        $id = sanitize_text_field($atts['id']);
        global $wpdb;
        $table_name = $wpdb->prefix . self::$pl_prefix;

        if ($id) {
            $addresses = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id), ARRAY_A);
            return loadTemplate('AddressItemTemplate', $addresses);
        } else if (!empty($status) && $status != 'all') {
            $addresses = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM $table_name WHERE status = %s", $status),
                ARRAY_A
            );
        } else {
            $addresses = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        }

        return loadTemplate('AddressListTemplate', $addresses);
    }
}
