<?php
/*
Plugin Name: Polr Wordpress Plugin
Plugin URI: https://wordpress.org/plugins/wp-polr
Description: Polr is a quick, modern, and open-source link shortener. This plugin allows you to use Polr service in Wordpress.
Version: 1.0.1
Author: Egoitz Gonzalez
Author URI: http://www.egoitzgonzalez.com
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.html
Text Domain: wp-polr
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// === INCLUDES === //

include( plugin_dir_path( __FILE__ ) . 'admin/polr-metabox.php');
include( plugin_dir_path( __FILE__ ) . 'admin/admin-all-posts-page.php');
include( plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php');
include( plugin_dir_path( __FILE__ ) . 'admin/plugins-page.php');
include( plugin_dir_path( __FILE__ ) . 'admin/settings-page.php');

// === //



// Set up to internationalize the plugin
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'polr_plugin_add_settings_link' ); // admin/plugins-page.php


/**
  * @wp-hook plugins_loaded
	* Set to internationalize the plugin
	*/

function polr_plugin_load_textdomain() {

	$text_domain	= 'wp-polr';
	$path_languages = basename(dirname(__FILE__)).'/languages/'; // basename(dirname(__FILE__)) relative url. This function extracts the name of the plugin directory. In this case, Polr.

 	load_plugin_textdomain($text_domain, false, $path_languages );
}
add_action('plugins_loaded', 'polr_plugin_load_textdomain'); // init hook is valid too



/**
  * @wp-hook add_meta_boxes
	* Load external files
	* JQuery
	* polr.js
	*/

function polr_init() {
    // registers plugin's js file. Jquery is a requirement for this script, so we specify it
		// polr-js is the name to reference polar.js file as identifile. Jquery is a requirement for polr.js file

    wp_register_script( 'polr-js', plugins_url( '/polr.js', __FILE__ ), array('jquery') );

    //load scripts
    wp_enqueue_script('jquery'); // Load jquery for polr.js
    wp_enqueue_script('polr-js'); // Load polr.js file. This file is registered as polr-js

    global $post;
    $post_id = $post->ID;
		$ajax_path = esc_url(admin_url('admin-ajax.php'));
    wp_localize_script('polr-js', 'MyAjax', array(
      'post_id' => $post_id,
      'action'=> 'polr_get_url', // polr_get_url is the action, but without the wp_ajax prefix. This acction launches polr_get_url_process function
			'ajax_path'=> $ajax_path
    ));
}
add_action( 'add_meta_boxes', 'polr_init' ); // wp hook is valid too



/**
  * @wp-hook wp_ajax_polr_get_url
	* Function to process the Ajax
	* Get post url, service api key, host url and create shortened url
	*/

function polr_get_url_process() {
    if(isset($_POST['postID']))
    {
    $post_id = intval( $_POST['postID'] );
    $post_url = esc_url(get_permalink($post_id));
    $api_key = esc_attr(get_option('polr_settings_api_key'));
		$host_url = esc_url(get_option('polr_settings_host'));
		$shortenedurl = file_get_contents($host_url.'/api/v2/action/shorten?key='.$api_key.'&url='.$post_url.'&is_secret=false');
    update_post_meta($post_id, 'polr_shortened_url', esc_url_raw($shortenedurl)); // post id, field name, data to insert. This functions save the data
    echo esc_url($shortenedurl);

    }

    exit();
}
add_action('wp_ajax_polr_get_url', 'polr_get_url_process'); // Defined polr_get_url action. This is called in polr.js file . wp_ajax is a standard prefix in Wordpress


?>
