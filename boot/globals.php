<?php

namespace PracticeTask {

    function loadTemplate($view_name, $data = [])
    {
        
        extract($data);
        ob_start();
        include PR_ADDRESS_PLUGIN_DIR .'app/Views/'. $view_name . '.php';
        $content = ob_get_clean();
        return $content;
    }
}
