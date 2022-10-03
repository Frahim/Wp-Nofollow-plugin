<?php

/**
 * The plugin bootstrap file
 * 
 * 
 
 *
 * @link              https://yeasir.adaptstoday.co.uk/
 * @since             1.0.0
 * @package           Asnf
 *
 * @wordpress-plugin
 * Plugin Name:       Nofollow All External Links
 * Plugin URI:        https://yeasir.adaptstoday.co.uk/
 * Description:       This Plugin will identify each external link and make them nofollow
 * Version:           1.0.0
 * Author:            Md Yeasir Arafat
 * Author URI:        https://yeasir.adaptstoday.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       asnf
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'ASNF_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-asnf-activator.php
 */
function activate_asnf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-asnf-activator.php';
	Asnf_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-asnf-deactivator.php
 */
function deactivate_asnf() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-asnf-deactivator.php';
	Asnf_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_asnf' );
register_deactivation_hook( __FILE__, 'deactivate_asnf' );

/**
 * The plugin option
 * 
 * */
require_once plugin_dir_path( __FILE__ ) . 'option.php';


/** add seting link **/

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'salcode_add_plugin_page_settings_link');
function salcode_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=asnf' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}

/**
 * The core plugin 
 * 
 * */

function asnf_nofollow($content) {
	return preg_replace_callback('/<a[^>]+/', 'asnf_nofollow_callback', $content);
}
function asnf_nofollow_callback($matches) {
	$link = $matches[0];
	$site_link = get_bloginfo('url');
	$custome_value = get_option('asnf_option_name');
	if(!empty($custome_value)){
		$asfn_attrebute =  " ". $custome_value;
	} else{
		$asfn_attrebute = $custome_value;
	}
var_dump($asfn_attrebute);

	if (strpos($link, 'rel') === false) {
		$link = preg_replace("%(href=\S(?!$site_link))%i", 'rel="nofollow'.$asfn_attrebute.'" $1', $link);
	} elseif (preg_match("%href=\S(?!$site_link)%i", $link)) {
		$link = preg_replace('/rel=\S(?!nofollow)\S*/i', 'rel="nofollow"', $link);
	}
	return $link;
}
add_filter('the_content', 'asnf_nofollow');


// Removes noreferrer on the frontend only, you will likely still see noreferrer in the code view of the editor

function noref_formatter($content) {
	$replace = array(" noreferrer" => "" ," noreferrer" => "");
	
	$new_content = strtr($content, $replace);
	return $new_content;
 }
 add_filter('the_content', 'noref_formatter', 999);