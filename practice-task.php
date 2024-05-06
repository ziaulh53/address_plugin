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

 require_once __DIR__ .'/vendor/autoload.php';

call_user_func(function ($bootstrap) {
    $bootstrap(__FILE__);
}, require(__DIR__ . '/boot/app.php'));
