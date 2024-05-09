<?php

namespace PracticeTask {

    function loadTemplate($view_name, $data = [])
    {
        
        extract($data);
        // var_dump($data);
        // exit;
        ob_start();
        include PR_ADDRESS_PLUGIN_DIR .'app/Views/'. $view_name . '.php';
        $content = ob_get_clean();
        return $content;
    }
}
