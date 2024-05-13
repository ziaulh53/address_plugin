<?php

namespace Practice\Task\Controller;

class AddressController
{
    private static $pl_prefix = 'pr_tk_address';
    public static function saveAddress()
    {
        $name = sanitize_text_field($_POST['name']);
        $country = sanitize_text_field($_POST['country']);
        $state = sanitize_text_field($_POST['state']);
        $city = sanitize_text_field($_POST['city']);
        $zipcode = sanitize_text_field($_POST['zipcode']);
        $status = 'active';

        // Insert data into the database
        global $wpdb;
        $table_name = $wpdb->prefix . self::$pl_prefix;

        $data = array(
            'name' => $name,
            'country' => $country,
            'state' => $state,
            'city' => $city,
            'zipcode' => $zipcode,
            'status' => $status,
            'created_at' => current_time('mysql')
        );

        $wpdb->insert($table_name, $data);
        if ($wpdb->insert_id) {
            wp_send_json_success(['success' => true, 'msg' => 'Address saved successfully']);
        } else {
            wp_send_json_error(['message' => 'Failed to save data']);
        }

        wp_send_json_success(['name' => $_POST['name']]);
    }

    public static function getAddress()
    {
        if (isset($_GET['status'])) {
            $status = sanitize_text_field($_GET['status']);
            global $wpdb;
            $table_name = $wpdb->prefix . self::$pl_prefix;

            // Fetch addresses from the database based on status or return all addresses
            if ($status === 'all') {
                $addresses = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
            } else {
                $addresses = $wpdb->get_results(
                    $wpdb->prepare("SELECT * FROM $table_name WHERE status = %s", $status),
                    ARRAY_A
                );
            }
            wp_send_json_success($addresses);
        } else {
            wp_send_json_error(['msg' => 'Status parameter is missing']);
        }
    }

    public static function previewAddress()
    {
        if (isset($_GET['pr_tk_preview']) && $id = intval($_GET['pr_tk_preview'])) {
            $id = intval($id);
            echo \PracticeTask\loadTemplate('preview', [
                'id' => $id
            ]);
            exit;
        }
    }

    public static function deleteAddress()
    {
        if (current_user_can('delete_address')) {
            if (isset($_POST['id'])) {

                // Sanitize the ID
                $id = absint($_POST['id']);

                global $wpdb;
                $table_name = $wpdb->prefix . self::$pl_prefix;

                // Delete the address from the database
                $deleted = $wpdb->delete($table_name, ['id' => $id], ['%d']);

                if ($deleted !== false) {
                    wp_send_json_success(['msg' => 'Address deleted successfully', 'success' => true]);
                } else {
                    wp_send_json_error(['msg' => 'Failed to delete address', 'success' => false]);
                }
            } else {
                wp_send_json_error(['msg' => 'ID is missing']);
            }
        } else {
            wp_send_json_error(['msg' => 'You are not allowed!']);
        }
    }

    public static function updateAddress()
    {
        if (isset($_POST['id'], $_POST['name'], $_POST['country'], $_POST['state'], $_POST['city'], $_POST['zipcode'], $_POST['status'])) {
            $id = absint($_POST['id']);
            $name = sanitize_text_field($_POST['name']);
            $country = sanitize_text_field($_POST['country']);
            $state = sanitize_text_field($_POST['state']);
            $city = sanitize_text_field($_POST['city']);
            $zipcode = sanitize_text_field($_POST['zipcode']);
            $status = sanitize_text_field($_POST['status']);

            global $wpdb;
            $table_name = $wpdb->prefix . self::$pl_prefix;

            // Update the address in the database
            $updated = $wpdb->update(
                $table_name,
                array(
                    'name' => $name,
                    'country' => $country,
                    'state' => $state,
                    'city' => $city,
                    'zipcode' => $zipcode,
                    'status' => $status,
                    // 'updated_at' => current_time('mysql')
                ),
                array('id' => $id),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                ),
                array('%d')
            );

            if ($updated !== false) {
                wp_send_json_success(['msg' => 'Address updated successfully', 'success' => true]);
            } else {
                wp_send_json_error(['msg' => 'Failed to update address', 'success' => false]);
            }
        } else {
            wp_send_json_error(['msg' => 'Missing required parameters']);
        }
    }
}
