<?php
/**
 * Pure_Notification_Admin use for Admin.
 *
 * This class use for all settings in admin .This class all function are public. it has 4 property
 * use.this all classes name: counstruct,save_settings_optings,
 *
 * @since 1.0.0
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Estimate_Settings {

	protected $delete_time;
	protected $notification_menu;
	protected $shortcode;
	protected $estimate_menu;
	protected $estimate_limit;

	/**
	 * Pure_Notification_Settings constructor.
	 */
	public function __construct() {
	}

	/**
	 * The function save_settings_optings is save all data.
	 *
	 * This function updated all data in wordpress options table when we use this plugin control which we want.
	 *
	 * @since 1.0.0
	 *
	 * @see Function/register_settings_optings/Pure_Notification_Settings relied on
	 * @global object $wpdb Description.
	 *
	 * @param array $settings {
	 *     Optional. An array of arguments.
	 *
	 * @type integer $delete_time set delete time in settings.
	 * @type integer $notification_menu Description.
	 * @type integer $shortcode Description.
	 * @type integer $per_page Description.
	 * }
	 * @return boolean return true or false.
	 */
	public static function register_settings_optings() {
		register_setting( 'get_estimate_settings_group', 'delete_time' );
		register_setting( 'get_estimate_settings_group', 'estimate_menu' );
		register_setting( 'get_estimate_settings_group', 'per_page' );
 	    register_setting( 'get_estimate_settings_group', 'primary_color' );
 	    register_setting( 'get_estimate_settings_group', 'seccondary_color' );
 	    register_setting( 'get_estimate_settings_group', 'button_color' );
 	    register_setting( 'get_estimate_settings_group', 'hover_color' );
 	    register_setting( 'get_estimate_settings_group', 'estimate_limit' );
 	    register_setting( 'get_estimate_settings_group', 'estimate_export_footer' );
 	    register_setting( 'get_estimate_settings_group', 'company_name' );
 	    register_setting( 'get_estimate_settings_group', 'estimate_category1' );
 	    register_setting( 'get_estimate_settings_group', 'estimate_category2' );
		return true;
	}


}

new Estimate_Settings();