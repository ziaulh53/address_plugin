<?php

namespace Practice\Task\Controller;

class UserPerController
{
    private static $pl_prefix = 'pr_tk_address';

    public static function getRoles()
    {
        $roles = wp_roles()->roles;
        $roles = array_values($roles);
        array_shift($roles);
        wp_send_json_success($roles);
    }

    public static function updateCapabilty()
    {
        $roleName = $_POST['role'];
        $capability = sanitize_text_field($_POST['capability']);
        $capabilityValue = filter_var($_POST['capabilityValue'], FILTER_VALIDATE_BOOLEAN); // Convert string to boolean

        $role = get_role($roleName);

        if ($role) {
            if ($capabilityValue) {
                $role->add_cap($capability);
            } else {
                $role->remove_cap($capability);
            }

            wp_send_json_success(['msg' => 'Success']);
        } else {
            wp_send_json_error(['msg' => 'Role not found']);
        }
    }
}
