<?php
/**
  * add menu to admin
  * Create option page add_options_page
  */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
  * @wp-hook admin_menu
  * add menu to admin
  * Create option page add_options_page
  */
function polr_plugin_menu() {
    add_options_page( esc_html(__('Polr settings', 'wp-polr')), esc_html(__('Polr', 'wp-polr')), 'manage_options', 'polr', 'polr_plugin_options' ); // page title, title to display in admin menu, User permission to access to this page, Abbreviation for the menu, Function to execute when the page is loaded
}
add_action('admin_menu', 'polr_plugin_menu' );

 ?>
