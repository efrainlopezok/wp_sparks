<?php
/***************************************
*	Custom Widgets
***************************************/
add_action( 'vc_before_init', 'sparks_vc_before_init_actions' );
function sparks_vc_before_init_actions() {
    // Require new custom Widget
    require_once( get_stylesheet_directory().'/inc/widgets/image-with-text.php' );
    
}