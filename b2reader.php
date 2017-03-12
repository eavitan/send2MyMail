<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://netingit.fr
 * @since             1.0.0
 * @package           Send 2 ma mail
 *
 * @wordpress-plugin
 * Plugin Name:       Send 2 ma mail
 * Plugin URI:        http://netingit.fr
 * Description:       improve you content readability by offering your audience to send the page content to their mail.
 * Version:           1.0.0
 * Author:            Eyal Avitan
 * Author URI:        http://netingit.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Send 2 ma mail
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if(!function_exists('s2mm_activate_b2reader')){
	function s2mm_activate_b2reader() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-b2reader-activator.php';
		s2mm_B2reader_Activator::activate();
	}
}

if(!function_exists('s2mm_deactivate_b2reader')){
	function s2mm_deactivate_b2reader() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-b2reader-deactivator.php';
		s2mm_B2reader_Deactivator::deactivate();
	}
}

register_activation_hook( __FILE__, 'activate_b2reader' );
register_deactivation_hook( __FILE__, 'deactivate_b2reader' );

require plugin_dir_path( __FILE__ ) . 'includes/class-b2reader.php';

/**
 * @since    1.0.0
 */
 if(!function_exists('s2mm_run_send_2_ma_mail')){
	function s2mm_run_send_2_ma_mail() {
		if (class_exists('s2mm_B2reader')) {
			$plugin = new s2mm_B2reader();
			$plugin->run();
		}
	}
}
s2mm_run_send_2_ma_mail();
