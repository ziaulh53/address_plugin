<?php

class Controller
{

    public static function getAddressAjaxHandler()
    {
        $data = array('message' => 'Hello from WordPress!');

        // Return JSON response
        // wp_send_json_success($data);
    }
}
