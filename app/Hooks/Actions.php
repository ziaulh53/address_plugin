<?php

use Practice\Task\Controller\AddressController;
use Practice\Task\Controller\ShortCodeController;

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


// shortcode hook

add_shortcode('pr_tk_address', function($atts){
    return ShortCodeController::showAllAddressList($atts);
});
