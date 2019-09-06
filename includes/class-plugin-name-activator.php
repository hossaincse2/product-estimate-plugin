<?php

/** 
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    product_estimate
 * @subpackage product_estimate/includes
 * 
 * created 2/14/25019
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    product_estimate
 * @subpackage product_estimate/includes
 * @author     Your Name <email@example.com>
 */
class product_estimate_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

 		self::create_estimate_templete_page();
 		self::create_estimate_list_templete_page();
 		self::create_estimate_edit_templete_page();
 		self::create_signup_templete_page();
		self::add_table();
		self::add_role();
		self::add_cap();
		self::updateOptions();
 	
		}

		private static function create_estimate_templete_page() {
			// Create post object
			$new_page_title = 'Product Estimate';
			$new_page_content = 'Product Estimate';
			$new_page_template = 'estimate.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
			//don't change the code bellow, unless you know what you're doing
			$page_check = get_page_by_title($new_page_title);
	
			$my_post = array(
				'post_title'    => $new_page_title,
				'post_content'  => $new_page_content,
				'page_template'  => 'Estimate',
				'post_status'   => 'publish',
				'post_name' => 'estimate',
				'post_type' => 'page',
				'post_author'   => 1,
			);
	
			// Insert the post into the database
	
			if(!isset($page_check->ID)){
				$new_page_id = wp_insert_post( $my_post );;
				if(!empty($new_page_template)){
					update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
				}
			}
		} 

		private static function create_estimate_list_templete_page() {
			// Create post object
			$new_page_title = 'Product Estimate List';
			$new_page_content = 'Product Estimate List';
			$new_page_template = 'estimate_list.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
			//don't change the code bellow, unless you know what you're doing
			$page_check = get_page_by_title($new_page_title);
	
			$my_post = array(
				'post_title'    => $new_page_title,
				'post_content'  => $new_page_content,
				'page_template'  => 'Estimate List',
				'post_status'   => 'publish',
				'post_name' => 'estimate_list',
				'post_type' => 'page',
				'post_author'   => 1,
			);
	
			// Insert the post into the database
	
			if(!isset($page_check->ID)){
				$new_page_id = wp_insert_post( $my_post );;
				if(!empty($new_page_template)){
					update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
				}
			}
		}
		private static function create_estimate_edit_templete_page() {
			// Create post object
			$new_page_title = 'Product Estimate Edit';
			$new_page_content = 'Product Estimate Edit';
			$new_page_template = 'estimate_edit.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
			//don't change the code bellow, unless you know what you're doing
			$page_check = get_page_by_title($new_page_title);
	
			$my_post = array(
				'post_title'    => $new_page_title,
				'post_content'  => $new_page_content,
				'page_template'  => 'Estimate Edit',
				'post_status'   => 'publish',
				'post_name' => 'estimate_edit',
				'post_type' => 'page',
				'post_author'   => 1,
			);
	
			// Insert the post into the database
	
			if(!isset($page_check->ID)){
				$new_page_id = wp_insert_post( $my_post );;
				if(!empty($new_page_template)){
					update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
				}
			}
		}

		private static function create_signup_templete_page() {
			// Create post object
			$new_page_title = 'Estimate Sign Up';
			$new_page_content = 'Estimate Sign Up';
			$new_page_template = 'signup.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
			//don't change the code bellow, unless you know what you're doing
			$page_check = get_page_by_title($new_page_title);
	
			$my_post = array(
				'post_title'    => $new_page_title,
				'post_content'  => $new_page_content,
				'page_template'  => 'Sign Up',
				'post_status'   => 'publish',
				'post_name' => 'signup',
				'post_type' => 'page',
				'post_author'   => 1,
			);
	
			// Insert the post into the database
	
			if(!isset($page_check->ID)){
				$new_page_id = wp_insert_post( $my_post );;
				if(!empty($new_page_template)){
					update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
				}
			}
		}
	
		private static function add_role() {
			add_role(
				'Estimate-admin',
				__( 'Estimate Admin' ),
				array(
					'read'         => false,  // true allows this capability
					'edit_posts'   => false,
				)
			);
			add_role(
				'product-manager',
				__( 'Product Manager' ),
				array(
					'read'         => true,  // true allows this capability
					'edit_posts'   => true,
				    'delete_products' => true,
					'edit_products' => true,
					'delete_products' => true,
					'edit_product' => true,
					'edit_others_products' => true,
					'edit_private_products' => true,
					'edit_published_products' => true,
					'manage_product_terms' => true,
					'edit_product_terms' => true,
					'view_admin_dashboard' => true,
					'view_woocommerce_reports' => true
				)
			);  
			add_role(
				'order-manager',
				__( 'Order Manager' ),
				array(
					'read'         => true,  // true allows this capability
					'edit_posts'   => true,
					'edit_posts'   => true,
					'read_shop_order' => true,
					'read_shop_orders' => true,
					'edit_shop_orders' => true,
					'edit_publish_shop_orders' => true,
					'edit_private_shop_orders' => true,
					'edit_others_shop_orders' => true,
					'manage_shop_order_terms' => true,
					'edit_shop_order' => true,
					'publish_shop_orders' => true,
					// 'delete_shop_order' => true,
					'view_admin_dashboard' => true,
					'view_woocommerce_reports' => true
				)
			);
			add_role(
				'normal-user',
				__( 'Normal Users' ),
				array(
					'read'         => true,  // true allows this capability
					'edit_posts'   => true, 
				)
			);
		}
		// Add the new capability to all roles having a certain built-in capability
		private static function add_cap() {
			$roles = get_editable_roles();
			foreach ($GLOBALS['wp_roles']->role_objects as $key => $role) {
				if (isset($roles[$key]) && $role->has_cap('estimate-admin')) {
					$role->add_cap('estimate-admin');
				}
				if (isset($roles[$key]) && $role->has_cap('order-manager')) {
					$role->add_cap('order-manager');
				}
			} 
		}


// //add caps to editor role
// $role = get_role("editor");

// //for woocommerce
// $role->add_cap("manage_woocommerce");
// $role->add_cap("view_woocommerce_reports");
// $role->add_cap("edit_product");
// $role->add_cap("read_product");
// $role->add_cap("delete_product");
// $role->add_cap("edit_products");
// $role->add_cap("edit_others_products");
// $role->add_cap("publish_products");
// $role->add_cap("read_private_products");
// $role->add_cap("delete_products");
// $role->add_cap("delete_private_products");
// $role->add_cap("delete_published_products");
// $role->add_cap("delete_others_products");
// $role->add_cap("edit_private_products");
// $role->add_cap("edit_published_products");
// $role->add_cap("manage_product_terms");
// $role->add_cap("edit_product_terms");
// $role->add_cap("delete_product_terms");
// $role->add_cap("assign_product_terms");
// $role->add_cap("edit_shop_order");
// $role->add_cap("read_shop_order");
// $role->add_cap("delete_shop_order");
// $role->add_cap("edit_shop_orders");
// $role->add_cap("edit_others_shop_orders");
// $role->add_cap("publish_shop_orders");
// $role->add_cap("read_private_shop_orders");
// $role->add_cap("delete_shop_orders");
// $role->add_cap("delete_private_shop_orders");
// $role->add_cap("delete_published_shop_orders");
// $role->add_cap("delete_others_shop_orders");
// $role->add_cap("edit_private_shop_orders");
// $role->add_cap("edit_published_shop_orders");
// $role->add_cap("manage_shop_order_terms");
// $role->add_cap("edit_shop_order_terms");
// $role->add_cap("delete_shop_order_terms");
// $role->add_cap("assign_shop_order_terms");
// $role->add_cap("edit_shop_coupon");
// $role->add_cap("read_shop_coupon");
// $role->add_cap("delete_shop_coupon");
// $role->add_cap("edit_shop_coupons");
// $role->add_cap("edit_others_shop_coupons");
// $role->add_cap("publish_shop_coupons");
// $role->add_cap("read_private_shop_coupons");
// $role->add_cap("delete_shop_coupons");
// $role->add_cap("delete_private_shop_coupons");
// $role->add_cap("delete_published_shop_coupons");
// $role->add_cap("delete_others_shop_coupons");
// $role->add_cap("edit_private_shop_coupons");
// $role->add_cap("edit_published_shop_coupons");
// $role->add_cap("manage_shop_coupon_terms");
// $role->add_cap("edit_shop_coupon_terms");
// $role->add_cap("delete_shop_coupon_terms");
// $role->add_cap("assign_shop_coupon_terms");
// $role->add_cap("edit_shop_webhook");
// $role->add_cap("read_shop_webhook");
// $role->add_cap("delete_shop_webhook");
// $role->add_cap("edit_shop_webhooks");
// $role->add_cap("edit_others_shop_webhooks");
// $role->add_cap("publish_shop_webhooks");
// $role->add_cap("read_private_shop_webhooks");
// $role->add_cap("delete_shop_webhooks");
// $role->add_cap("delete_private_shop_webhooks");
// $role->add_cap("delete_published_shop_webhooks");
// $role->add_cap("delete_others_shop_webhooks");
// $role->add_cap("edit_private_shop_webhooks");
// $role->add_cap("edit_published_shop_webhooks");
// $role->add_cap("manage_shop_webhook_terms");
// $role->add_cap("edit_shop_webhook_terms");
// $role->add_cap("delete_shop_webhook_terms");
// $role->add_cap("assign_shop_webhook_terms");

  
		private  static function add_table(){

		 global $wpdb;

		$estimate =  $wpdb->prefix. 'estimate';

		$estimate_products =  $wpdb->prefix. 'estimate_products';

		if($wpdb->get_var("SHOW TABLES LIKE '$estimate'") != $estimate) { 

		$charset_collate = $wpdb->get_charset_collate(); 

			$sql = "CREATE TABLE $estimate (
			id mediumint(9) NOT NULL AUTO_INCREMENT, 
			user_id varchar(200) NOT NULL,
			estimate_name varchar(200) NOT NULL,
			estimate_description text NOT NULL,
			enduser_name varchar(200) NOT NULL,
			enduser_email varchar(200) NOT NULL,
			enduser_contact_person varchar(100) NOT NULL,
			enduser_contact varchar(55) NOT NULL,
			enduser_address text NOT NULL,
			cdate datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY  (id)
			) $charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}

	if($wpdb->get_var("SHOW TABLES LIKE '$estimate_products'") != $estimate_products) { 

		$charset_collate = $wpdb->get_charset_collate(); 

		$sql2 = "CREATE TABLE $estimate_products (
		id mediumint(9) NOT NULL AUTO_INCREMENT, 
		estimate_id mediumint(11) NOT NULL,
		product_id mediumint(11) NOT NULL,
		product_name varchar(200) NOT NULL,
		qty varchar(200) NOT NULL,
		price varchar(55) NOT NULL,
		total_price text NOT NULL,
		cdate datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql2 );

		} 
	 }

	 private  static function updateOptions(){
		update_option( 'primary_color','#dd3333' );
		update_option( 'button_color', '#81d742' );
		update_option( 'seccondary_color','#1941b7' );
		update_option( 'hover_color', '#eaed49' );
		update_option( 'company_name', 'Nybsys' );
		update_option( 'delete_time',  '7' );
		update_option( 'estimate_limit', '10' );
		update_option( 'estimate_export_footer',  'This Price Estimate does not constitute an offer by NybSys to sell products, but is instead an invitation to issue a purchase order to NybSys until the valid date specified in this Price Estimate.Such a purchase order will be subject to Cisco standard procedures, terms and conditions for the acceptance of purchase orders.This order may subject to sales tax, VAT, duty and freight charges even if not noted on this estimate. ' );
		update_option( 'estimate_menu', '1' );
		update_option( 'per_page',  '25' );
		update_option( 'estimate_list','estimate_list' );
		update_option( 'create_estimate', 'estimate' );
		update_option( 'estimate_category1', 'device' );
		update_option( 'estimate_category2', 'sensore' );
	 }
	 
	  
		
 	}

 