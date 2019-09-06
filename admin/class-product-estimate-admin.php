<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    product_estimate
 * @subpackage product_estimate/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    product_estimate
 * @subpackage product_estimate/admin
 * @author     Your Name <email@example.com>
 */
class product_estimate_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $product_estimate    The ID of this plugin.
	 */
	private $product_estimate;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $product_estimate       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $product_estimate, $version ) {

		$this->product_estimate = $product_estimate;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in product_estimate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The product_estimate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */ 
		wp_enqueue_style('dataTable-style', 'https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->product_estimate, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );
		// Add the color picker css file
		wp_enqueue_style( 'wp-color-picker' );
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in product_estimate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The product_estimate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'dataTable-js','https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->product_estimate, plugin_dir_url( __FILE__ ) . 'js/product-estimate-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->product_estimate, 'ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' )));

		wp_enqueue_script( 'wp-color-picker' );
	}

	/**
 * Register a custom menu page.
 */
public function estimate_register_my_custom_menu_page(){
    add_menu_page( 
        __( 'Product Estimate', 'product_estimate' ),
        'Product Estimate',
        'manage_options',
        'product-estimate',
		 array($this,'product_estimate_menu_page'),
		'dashicons-admin-generic',
        // plugins_url( 'myplugin/images/icon.png' ),
        6
	); 
	
	add_submenu_page('product-estimate', 'Settings', 'Settings',
    'manage_options', 'settings', array($this,'product_estimate_settings_menu_page')); 
}



public function settings_custome_fileld_admin_init() {
	return Estimate_Settings::register_settings_optings();
}

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
        background-image: url(<?php echo plugin_dir_url( __FILE__ ); ?>/images/logo.svg);
		height:65px;
		width:320px;
		background-size: 320px 65px;
		background-repeat: no-repeat;
		padding-bottom: 0px;
		background-color: transparent;
		border-radius: 0;
        }
		#wpfooter p {
			font-size: 13px;
			margin: 0;
			line-height: 20px;
			display: none !important;
		}
    </style>

<?php }
  function demo_footer_filter ($default) {
	  return '';
}
 
function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
}

 
/**
 * Display a custom menu page
 */
public function product_estimate_menu_page(){
 	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/product_estimate.php';
}

public function product_estimate_settings_menu_page(){
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/settings.php';
}



public static function get_all_estimate(){
	global $wpdb;
    // $current_user = get_current_user_id();
	$tablename = $wpdb->prefix . "estimate";
	$ls_estimate = $wpdb->get_results("SELECT * FROM $tablename ORDER BY id");
  	 
 	return $ls_estimate;
}

/**
* Redirect users to custom URL based on their role after login
*
* @param string $redirect
* @param object $user
* @return string
*/
public function wc_custom_user_redirect( $redirect, $user ) {
	// Get the first of all the roles assigned to the user
	$role = $user->roles[0];
	$dashboard = admin_url();
	// $myaccount = get_permalink( wc_get_page_id( 'shop' ) );
	$myaccount = home_url();
	if( $role == 'administrator' ) {
	//Redirect administrators to the dashboard
	$redirect = $dashboard;
	} elseif ( $role == 'shop-manager' ) {
	//Redirect shop managers to the dashboard
	$redirect = $dashboard;
	} elseif ( $role == 'editor' ) {
	//Redirect editors to the dashboard
	$redirect = $dashboard;
	}elseif ( $role == 'author' ||  $role == 'order-manager' ) {
	 //Redirect authors to the dashboard
		$redirect = $dashboard;
	}   elseif ( $role == 'Estimate-admin' || $role == 'subscriber' ) {
	//Redirect customers and subscribers to the "My Account" page
	$redirect = $myaccount;
	} else {
	//Redirect any other role to the previous visited page or, if not available, to the home
	$redirect = wp_get_referer() ? wp_get_referer() : home_url();
	}
	return $redirect;
	}
	// add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 ); 

 
// ---------------------
// 1. Register Order Status
 
// add_filter( 'woocommerce_register_shop_order_post_statuses', 'bbloomer_register_custom_order_status' );
 
function estimate_register_custom_order_status( $order_statuses ){
     
    // Status must start with "wc-"
    $order_statuses['wc-order-received'] = array(                                            
    'label'                     => _x( 'Order Received', 'Order status', 'woocommerce' ),
    'public'                    => false,                                            
    'exclude_from_search'       => false,                                            
    'show_in_admin_all_list'    => true,                                         
    'show_in_admin_status_list' => true,                                         
    'label_count'               => _n_noop( 'Order Received <span class="count">(%s)</span>', 'Order Received <span class="count">(%s)</span>', 'woocommerce' ),                                       
    );      
    $order_statuses['wc-payment-received'] = array(                                            
    'label'                     => _x( 'Payment Received', 'Order status', 'woocommerce' ),
    'public'                    => false,                                            
    'exclude_from_search'       => false,                                            
    'show_in_admin_all_list'    => true,                                         
    'show_in_admin_status_list' => true,                                         
    'label_count'               => _n_noop( 'Payment Received <span class="count">(%s)</span>', 'Payment Received <span class="count">(%s)</span>', 'woocommerce' ),                                       
    );      
    return $order_statuses;
}
 
// ---------------------
// 2. Show Order Status in the Dropdown @ Single Order and "Bulk Actions" @ Orders
 
// add_filter( 'wc_order_statuses', 'bbloomer_show_custom_order_status' );
 
function estimate_show_custom_order_status( $order_statuses ) {    
    $order_statuses['wc-order-received'] = _x( 'Order Received', 'Order status', 'woocommerce' );       
    $order_statuses['wc-payment-received'] = _x( 'Payment Received', 'Order status', 'woocommerce' );       
    return $order_statuses;
}
 
// add_filter( 'bulk_actions-edit-shop_order', 'bbloomer_get_custom_order_status_bulk' );
 
function estimate_get_custom_order_status_bulk( $bulk_actions ) {
    // Note: "mark_" must be there instead of "wc"
	$bulk_actions['mark_order-received'] = 'Change status to Order Received';
	$bulk_actions['mark_payment-received'] = 'Change status to Payment Received';
    return $bulk_actions;
}
 
 
 
// ---------------------
// 3. Set Custom Order Status @ WooCommerce Checkout Process
 
// add_action( 'woocommerce_thankyou', 'bbloomer_thankyou_change_order_status' );
 
function estimate_thankyou_change_order_status( $order_id ){
    if( ! $order_id ) return;
    $order = wc_get_order( $order_id );
 
    // Status without the "wc-" prefix
    $order->update_status( 'order-received' );
    $order->update_status( 'payment-received' );
} 

}

