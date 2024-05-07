<?php


// save address
add_action('wp_ajax_pr_tk_save_address', 'saveAddress');

function saveAddress()
{
    $name = sanitize_text_field($_POST['name']);
    $country = sanitize_text_field($_POST['country']);
    $state = sanitize_text_field($_POST['state']);
    $city = sanitize_text_field($_POST['city']);
    $zipcode = sanitize_text_field($_POST['zipcode']);
    $status = 'active'; // Assuming 'status' is always 'active'

    // Insert data into the database
    global $wpdb;
    $table_name = $wpdb->prefix . 'pr_tk_address';

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


// get address

add_action('wp_ajax_pr_tk_get_address', 'getAddress');

function getAddress()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'pr_tk_address';

    // Fetch all addresses from the database
    $addresses = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    if ($addresses) {
        wp_send_json_success($addresses);
    } else {
        wp_send_json_error(['message' => 'No addresses found']);
    }
}


//delete address 
add_action('wp_ajax_pr_tk_delete_address', 'deleteAddress');
function deleteAddress()
{
    if (isset($_POST['id'])) {
        // Sanitize the ID
        $id = absint($_POST['id']);

        global $wpdb;
        $table_name = $wpdb->prefix . 'pr_tk_address';

        // Delete the address from the database
        $deleted = $wpdb->delete($table_name, ['id' => $id], ['%d']);

        if ($deleted !== false) {
            wp_send_json_success(['msg' => 'Address deleted successfully', 'success'=>true]);
        } else {
            wp_send_json_error(['msg' => 'Failed to delete address', 'success'=>false]);
        }
    } else {
        wp_send_json_error(['message' => 'ID is missing']);
    }
}
