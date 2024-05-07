<?php
if (!defined('ABSPATH')) {
    die('nothing!!');
}

/*
 * Plugin Name: Practice Task
 * Description: Prctice
 * Version: 1.0.0
 * Author: Ziaul
 * Author URI: https://exampledomain.com
 * Plugin URI: https://exampledomain.com/test/
 * License: GPLv2 or later
 * Text Domain: practas
 * Domain Path: /resources/languages
 */

 define('PR_ADDRESS_PLUGIN_DIR', plugin_dir_path(__FILE__));
 define('PR_ADDRESS_PLUGIN_URL', plugin_dir_url(__FILE__));

 require_once __DIR__ .'/vendor/autoload.php';

call_user_func(function ($bootstrap) {
    $bootstrap(__FILE__);
}, require(__DIR__ . '/boot/app.php'));
