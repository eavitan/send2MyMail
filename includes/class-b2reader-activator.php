<?php

/**
 * Fired during plugin activation
 *
 * @link       http://netingit.fr
 * @since      1.0.0
 *
 * @package    B2reader
 * @subpackage B2reader/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    B2reader
 * @subpackage B2reader/includes
 * @author     Eyal Avitan <eyal@netingit.co.il>
 */
 if (!class_exists('s2mm_B2reader_Activator')) {
class s2mm_B2reader_Activator {
  /**
	 * On activation create a page and remember it.
	 *
	 * Create a page named "Saved", add a shortcode that will show the saved items
	 * and remember page id in our database.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	}

}
}
