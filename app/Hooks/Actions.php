<?php

use Practice\Task\Controller\AddressController;
use Practice\Task\Controller\ShortCodeController;
use Practice\Task\Controller\UserPerController;

// save address
add_action('wp_ajax_pr_tk_save_address',  function(){
    AddressController::saveAddress();
});

// get address
add_action('wp_ajax_pr_tk_get_address', function(){
    AddressController::getAddress();
});


//delete address 
add_action('wp_ajax_pr_tk_delete_address',function(){
    AddressController::deleteAddress();
});

// update address
add_action('wp_ajax_pr_tk_update_address',function(){
    AddressController::updateAddress();
});

add_action('init',function(){
    AddressController::previewAddress();
});


//user management controller
add_action('wp_ajax_pr_tk_get_role',function(){
    UserPerController::getRoles();
});

add_action('wp_ajax_update_capability', function (){
    UserPerController::updateCapabilty();
});

// shortcode hook

add_shortcode('pr_tk_address', function($atts){
    return ShortCodeController::showAllAddressList($atts);
});
