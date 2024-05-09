<?php

namespace Practice\Task\Controller;

class UserPerController
{
    private static $pl_prefix = 'pr_tk_address';

    public static function getRoles()
    {
        $roles = wp_roles()->roles;
        $roles = array_values($roles);
        wp_send_json_success($roles);
    }
}
