<?php

//网站维护模式
if (panda_pz('is_maintenance')) {	
    add_action('wp_loaded', function (){
        global $pagenow;
        if (current_user_can('manage_options')  || $pagenow == 'wp-login.php' || $_SERVER['REQUEST_URI'] == "/user-sign?tab=signin&redirect_to") {
            return;
        }   
        header( $_SERVER["SERVER_PROTOCOL"] . ' 503 Service Temporarily Unavailable', true, 503 );
        header('Content-Type:text/html;charset=utf-8');
        require(WP_CONTENT_DIR . '/themes/panda/assets/others/maintenance/index.php');
        exit;
    });
}