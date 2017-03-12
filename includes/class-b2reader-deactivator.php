<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://netingit.fr
 * @since      1.0.0
 *
 * @package    B2reader
 * @subpackage B2reader/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    B2reader
 * @subpackage B2reader/includes
 * @author     Eyal Avitan <eyal@netingit.co.il>
 */
 if (!class_exists('s2mm_B2reader_Deactivator')) {
class s2mm_B2reader_Deactivator {

  /**
	 * On deactivation delete the "Saved" page.
	 *
	 * Get the "Saved" page id, check if it exists and delete the page that has that id.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
	}
}
}
