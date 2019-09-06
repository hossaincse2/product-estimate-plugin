<?php
        use Dompdf\Dompdf;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    product_estimate
 * @subpackage product_estimate/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    product_estimate
 * @subpackage product_estimate/public
 * @author     Your Name <email@example.com>
 */
class product_estimate_Public {

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
	 * @param      string    $product_estimate       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $product_estimate, $version ) {

		$this->product_estimate = $product_estimate;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->product_estimate, plugin_dir_url( __FILE__ ) . 'css/product-estimate-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->product_estimate, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false ); 
		wp_localize_script( $this->product_estimate, 'ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
	}

	public function baseUrl (){
		?>
	 <script type="text/javascript">
		var base_url = '<?php echo home_url(); ?>';
	  </script>
		<?php
	}
	public function pluginUrl (){
		?>
	 <script type="text/javascript">
		var plugin_url = '<?php echo plugin_dir_url('').'/' .$this->product_estimate; ?>';
	  </script>
		<?php
	}

	public function get_device_list(){

	$category =  get_option( 'estimate_category1' );

	$args = array(
        'post_type'      => 'product',
        'posts_per_page' => 10,
        'product_cat'    => $category
    );

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
				global $product;
				if(isset($_GET['estimate-id'])){
					echo '<a data-id="'.get_the_ID().'" data-estimateId = "'.$_GET['estimate-id'].'" class="add_list cart-add-btn list-group-item list-group-item-action bg-light" href="#">'.get_the_title().' <span class="btn-show-hover">Add</span></a>';
				}else{
					echo '<a data-id="'.get_the_ID().'" data-estimateId = "'.$_GET['estimate-id'].'" class="cart-add-btn list-group-item list-group-item-action bg-light" href="#">'.get_the_title().'</a>';
				}
        // echo '<a class="cart-add-btn list-group-item list-group-item-action bg-light" href="'.home_url().'?add-to-cart='.get_the_ID().'">'.get_the_title().' <span class="btn-show-hover">Add</span></a>';
        //echo '<a data-id="'.get_the_ID().'" data-estimateId = "'.$_GET['estimate-id'].'" class="add_list cart-add-btn list-group-item list-group-item-action bg-light" href="#">'.get_the_title().' <span class="btn-show-hover">Add</span></a>';
    endwhile;

    wp_reset_query();
} 


public function get_sensore_list(){

	$category =  get_option( 'estimate_category2' );

	$taxonomy = 'product_cat';
	$orderby = 'name';
	$show_count = 0; // 1 for yes, 0 for no
	$pad_counts = 0; // 1 for yes, 0 for no
	$hierarchical = 1; // 1 for yes, 0 for no
	$title = '';
	$empty = 0;
	
	$cat_id = get_term_by( 'slug',$category, 'product_cat' ); 
	
	$args = array(
	'taxonomy' => $taxonomy,
	'orderby' => $orderby,
	'parent'       => $cat_id->term_id,
	// 'product_cat'    => $category,
	// 'category_name'    => $category,
	'show_count' => $show_count,
	'pad_counts' => $pad_counts,
	'hierarchical' => $hierarchical,
	'title_li' => $title,
	'hide_empty' => $empty
	);?>

     <div class="list-group list-group-flush"> 
        <div id="accordion">
	<?php
	$categories = get_categories( $args );
 	foreach( $categories as $term ){

		// print_r( $term );
	?>

  		<div class="card">
			<div class="card-header"> 
				<a class="card-link" data-toggle="collapse" href="#collapseOne<?php echo $term->term_id; ?>">
				<?php echo $term->name; ?>
				<img class="arrow_icon" src="<?php echo get_template_directory_uri() . '/img/arrow_down.svg' ?>" alt="">
				</a>
			</div>
			<div id="collapseOne<?php echo $term->term_id; ?>" class="collapse" data-parent="#accordion">
				<div class="card-body">
				<?php
				$args = array(
					'post_type'      => 'product',
					'posts_per_page' => 10,
					'product_cat'    => $term->slug
				);
	
				$loop = new WP_Query( $args );
	
				while ( $loop->have_posts() ) : $loop->the_post();
					global $product;

					// print_r($product);
					// echo do_shortcode('[add_to_cart id="94"]');
					// echo '<a class="cart-add-btn list-group-item list-group-item-action bg-light" href="'.home_url().'?add-to-cart='.get_the_ID().'">'.get_the_title().' <span class="btn-show-hover">Add</span></a>';
					if(isset($_GET['estimate-id'])){
						echo '<a data-id="'.get_the_ID().'" data-estimateId = "'.$_GET['estimate-id'].'" class="add_list cart-add-btn list-group-item list-group-item-action bg-light" href="#">'.get_the_title().' <span class="btn-show-hover">Add</span></a>';
					}else{
						echo '<a data-id="'.get_the_ID().'" data-estimateId = "'.$_GET['estimate-id'].'" class="cart-add-btn list-group-item list-group-item-action bg-light" href="#">'.get_the_title().'</a>';
					}

					endwhile;

					wp_reset_query(); 
					?>
				</div>
			</div>
			</div>
			  
	<?php 		
			
	 }
	 ?>
	 </div>
 </div>
	 <?php
	 
} 

public static function get_all_estimate_for_shortCode($limit){
	global $wpdb;
    $current_user = get_current_user_id();
	$tablename = $wpdb->prefix . "estimate";
	$ls_estimate = $wpdb->get_results("SELECT * FROM $tablename WHERE  user_id = '$current_user' LIMIT $limit");
  	 
 	return $ls_estimate;
}
public static function get_all_estimate(){
	global $wpdb;
    $current_user = get_current_user_id();
	$tablename = $wpdb->prefix . "estimate";
	$ls_estimate = $wpdb->get_results("SELECT * FROM $tablename WHERE  user_id = '$current_user'");
  	 
 	return $ls_estimate;
}

public static function get_details_estimate($estimateId){
	global $wpdb;
	$current_user = get_current_user_id();
	$tablename = $wpdb->prefix . "estimate";
	$ls_estimate = $wpdb->get_results("SELECT * FROM $tablename WHERE  user_id = '$current_user' AND id= '$estimateId'");
  	 
 	return $ls_estimate;
}



// public function delete_estimate(){

// 	$nonce =  isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';
// 	 $id =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

// 	if(wp_verify_nonce( $nonce, 'delete_jobs')){
// 	   wp_delete_post($id);
// 	   $link = 'wpre-dashbord?_wpnonce='.wp_create_nonce( 'jobs');
// 	   wp_redirect( get_permalink($link));  
// 	}
// } 


// public static function wpre_job_postmeta_data($job_meta_key = '') {

// 	global $wpdb;
// 	$current_user = get_current_user_id();
// 	$tablename = $wpdb->prefix . "recruitment_jobmeta";
// 	$ls_jobmeta = $wpdb->get_results("SELECT * FROM $tablename WHERE meta_key = '$job_meta_key' And job_id = '$current_user'");

// 	 $jobs_meta=[];
// 	foreach ($ls_jobmeta as $value){
// 		 $jobs_meta[] = $value->meta_value;
// 	}
// //		print_r($jobs_meta);
// //		die();
// 	return $jobs_meta;
// }

// public function wprec_delete_job_post(){

// 	$nonce =  isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';
// 	 $id =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

// 	if(wp_verify_nonce( $nonce, 'delete_jobs')){
// 	   wp_delete_post($id);
// 	   $link = 'wpre-dashbord?_wpnonce='.wp_create_nonce( 'jobs');
// 	   wp_redirect( get_permalink($link));  
// 	}
// } 

public static function allGetProducts($estimateId){
	global $wpdb;
	$tablename = $wpdb->prefix . "estimate_products";
	$sql = "Select * from $tablename Where estimate_id = '$estimateId'  Group By product_id Order by id ASC";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}
public static function getTotalQty($productId, $estimateId){
	global $wpdb;
	$tablename = $wpdb->prefix . "estimate_products";
	$sql = "SELECT product_id,SUM(qty) as totalQty FROM $tablename Where estimate_id = '$estimateId' and  product_id = $productId GROUP BY product_id;";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}

public function estimate_redirect_users_by_role() {

	$current_user   = wp_get_current_user();
	$role_name      = $current_user->roles[0];
	$return_url = esc_url( home_url( '/my-account/' ) );
	if ( 'estimate-admin' === $role_name ) {
		wp_redirect( $return_url );
	} // if

}
 

public function estimate_user_nav_visibility() {

    if ( is_user_logged_in() ) {
        $output="<style> .nav-login { display: none; } </style>";
    } else {
        $output="<style> .nav-account { display: none; } </style>";
    }

    echo $output;
}

function estimate_csv(){ 

	if(isset($_GET['estimate-id'])  && isset($_GET['csv'])){
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");
		
		
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Hello')
					->setCellValue('B2', 'world!')
					->setCellValue('C1', 'Hello')
					->setCellValue('D2', 'world!');
		
		// Miscellaneous glyphs, UTF-8
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A4', 'Miscellaneous glyphs')
					->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (OpenDocument)
		header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
		header('Content-Disposition: attachment;filename="01simple.ods"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
		$objWriter->save('php://output');
		exit;
		
	} 
	
	}
}
