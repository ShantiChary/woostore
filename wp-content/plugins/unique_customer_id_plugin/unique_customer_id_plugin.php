<?php
/*
  Plugin Name: Unique Customer ID
  Description: Woostore Unique Customer ID Function
  Version: 1.0
  Author: Shanti Chary
  License: GPL 2.1
 */

    // register shortcode
    add_shortcode('user_details', 'woostore_add_account_number'); 

    function woostore_add_account_number($user_id)
    {
        $accountnumber = rand(pow(10, 4-1), pow(10, 4)-1).$user_id;
        update_user_meta($user_id, 'account_number', $accountnumber);

        $user = wp_get_current_user();
        $display_name = $user->display_name;

        $user_details = $accountnumber . ' ' . $display_name;

        return $user_details;
    }

?>