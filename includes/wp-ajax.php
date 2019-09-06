<?php
 use Dompdf\Dompdf;

add_action( 'wp_ajax_estimate_insert', 'estimate_insert' );
add_action( 'wp_ajax_nopriv_estimate_insert', 'estimate_insert' );

function estimate_insert() {

	global $wpdb;
		$tablename = $wpdb->prefix . "estimate";

 		// if (isset($_POST['jobmeta_submit'])){
		$userId     = $_POST['userId']; //string value use: %s
		$estimateName    = $_POST['estimateName']; //string value use: %s
		$description    = $_POST['description']; //string value use: %s
		$endUserName    = $_POST['endUserName']; //numeric value use: %s
		$endUserEmail    = $_POST['endUserEmail']; //numeric value use:  %s
		$endUserContact    = $_POST['endUserContact']; //numeric value use: %s
		$endUserContactPerson    = $_POST['endUserContactPerson']; //numeric value use: %s
		$endUserAddress    = $_POST['endUserAddress']; //numeric value use:  %s
		
		// $exists = email_exists( $endUserEmail );

		// if ( $exists ) {
		// 	 echo "Email Exists";
		// } else {
		// 	echo "Email Doesn't Exists";
		// }

		$sql = $wpdb->prepare("INSERT INTO `$tablename` (`user_id`,`estimate_name`,`estimate_description`,`enduser_name`, `enduser_email`, `enduser_contact_person`, `enduser_contact`, `enduser_address`) values (%s, %s, %s, %s, %s, %s, %s, %s)", $userId, $estimateName, $description, $endUserName, $endUserContactPerson,$endUserContact, $endUserEmail, $endUserAddress);

		$wpdb->query($sql);
		// }

		echo $lastid = $wpdb->insert_id;
		// echo 'success';
 
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_estimate_clone', 'estimate_clone' );
add_action( 'wp_ajax_nopriv_estimate_clone', 'estimate_clone' );

function estimate_clone() {

	global $wpdb;
		$tablename = $wpdb->prefix . "estimate";
		$estimateId     = $_POST['id']; //string value use: %s
		// $products = 	getProductsByID($id);
		$estimateData = get_estimate_by_id($estimateId);

	 
 		// if (isset($_POST['jobmeta_submit'])){
		$userId     = $estimateData['user_id']; //string value use: %s
		$estimateName    = $estimateData['estimate_name'].' copy'; //string value use: %s
		$description    = $estimateData['estimate_description']; //string value use: %s
		$endUserName    = $estimateData['enduser_name']; //numeric value use: %s
		$endUserEmail    = $estimateData['enduser_email']; //numeric value use:  %s
		$endUserContact    = $estimateData['enduser_contact_person']; //numeric value use: %s
		$endUserContactPerson    = $estimateData['enduser_contact']; //numeric value use: %s
		$endUserAddress    = $estimateData['enduser_address']; //numeric value use:  %s
		
		// $exists = email_exists( $endUserEmail );

		// if ( $exists ) {
		// 	 echo "Email Exists";
		// } else {
		// 	echo "Email Doesn't Exists";
		// }

		$sql = $wpdb->prepare("INSERT INTO `$tablename` (`user_id`,`estimate_name`,`estimate_description`,`enduser_name`, `enduser_email`, `enduser_contact_person`, `enduser_contact`, `enduser_address`) values (%s, %s, %s, %s, %s, %s, %s, %s)", $userId, $estimateName, $description, $endUserName, $endUserContactPerson,$endUserContact, $endUserEmail, $endUserAddress);

		$wpdb->query($sql); 
	
		$lastid = $wpdb->insert_id; 

	 if($lastid ){ 
		$allProducts = allGetProducts($estimateId); 
		foreach($allProducts as $allProduct){
			$tablename2 = $wpdb->prefix . "estimate_products";
			$product_id = $allProduct ['product_id'];
			$product_name = $allProduct ['product_name'];
			$qty = $allProduct ['qty'];
			$price = $allProduct ['price'];
			$total_price = $allProduct ['total_price'];

			$sql = $wpdb->prepare("INSERT INTO `$tablename2` (`estimate_id`,`product_id`, `product_name`, `qty`, `price`, `total_price`) values (%d, %d, %s, %s, %s, %s)", $lastid, $product_id, $product_name,$qty, $price, $total_price);

		$wpdb->query($sql);
		}
		echo $lastid;
	}
		// }

	
		// echo 'success';
 
	wp_die(); // this is required to terminate immediately and return a proper response
}


function get_estimate_by_id($id){
	global $wpdb;
	$tablename = $wpdb->prefix . "estimate";
	$sql = "Select * from $tablename where `id` = '$id'";
	$values = $wpdb->get_row($sql,ARRAY_A);
	return $values;
}


add_action( 'wp_ajax_estimate_edit', 'estimate_edit' );
add_action( 'wp_ajax_nopriv_estimate_edit', 'estimate_edit' );

function estimate_edit() {

	    global $wpdb;
	   $tablename = $wpdb->prefix . "estimate";

 		// if (isset($_POST['jobmeta_submit'])){
		$estimateId     = $_POST['estimateId']; //string value use: %s
		$estimateName    = $_POST['estimateName']; //string value use: %s
		$description    = $_POST['description']; //string value use: %s
		$endUserName    = $_POST['endUserName']; //numeric value use: %s
		$endUserEmail    = $_POST['endUserEmail']; //numeric value use:  %s
		$endUserContact    = $_POST['endUserContact']; //numeric value use: %s
		$endUserContactPerson    = $_POST['endUserContactPerson']; //numeric value use: %s
		$endUserAddress    = $_POST['endUserAddress']; //numeric value use:  %s 

		// echo $sql = "UPDATE `$tablename`
		// SET `estimate_name` = '$estimateName',
		// 	`enduser_name` = '$endUserName',
		// 	`enduser_email` = '$endUserEmail',
		// 	`enduser_contact` = '$endUserContact',
		// 	`enduser_address` = '$endUserAddress',
		// WHERE  `id` =  $estimateId" ;

		$sql =  $wpdb->prepare( "UPDATE `$tablename`
								   SET `estimate_name` = '$estimateName',
								       `estimate_description` = '$description',
								       `enduser_name` = '$endUserName',
								       `enduser_email` = '$endUserEmail',
								       `enduser_contact_person` = '$endUserContactPerson',
								       `enduser_contact` = '$endUserContact',
								       `enduser_address` = '$endUserAddress'
								   WHERE  `id` = %d", $estimateId );

		$wpdb->query($sql);
		// }

		  echo $estimateId;
		// echo 'success';
 
	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_estimate_product_updateByQty', 'estimate_product_updateByQty' );
add_action( 'wp_ajax_nopriv_estimate_product_updateByQty', 'estimate_product_updateByQty' );

function estimate_product_updateByQty() {

	    global $wpdb;
	   $tablename = $wpdb->prefix . "estimate_products";

 		// if (isset($_POST['jobmeta_submit'])){
		$id     = $_POST['id']; //string value use: %s
		$qty    = $_POST['quantity']; //string value use: %s
		$total_price    = $_POST['totalPrice']; //string value use: %s
    
		$sql =  $wpdb->prepare( "UPDATE `$tablename`
								   SET `qty` = '$qty',
								       `total_price` = '$total_price'
								   WHERE  `id` = %d", $id );

		$wpdb->query($sql);
		// }

		  echo $id;
		// echo 'success';
 
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_estimate_delete', 'estimate_delete' );
add_action( 'wp_ajax_nopriv_estimate_delete', 'estimate_delete' );

function estimate_delete() {

	    global $wpdb;

		$tablename = $wpdb->prefix . "estimate"; 
		$estimateId  = $_POST['estimateId'];  
		$nonce  = $_POST['nonce'];  
		 
		 if(wp_verify_nonce( $nonce, 'estimateDelete')){
			$sql = "DELETE FROM `$tablename` WHERE id = '$estimateId'";
		 }
	   
		$wpdb->query($sql);
  
		echo $estimateId;
  
	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_estimate_product_delete', 'estimate_product_delete' );
add_action( 'wp_ajax_nopriv_estimate_product_delete', 'estimate_product_delete' );

function estimate_product_delete() {

	    global $wpdb;

		$tablename = $wpdb->prefix . "estimate_products"; 
		$id  = $_POST['id'];  
		$productId  = $_POST['productId'];  
		$estimateId  = $_POST['estimateId'];  
		$nonce  = $_POST['nonce'];  
		 
		 if(wp_verify_nonce( $nonce, 'productDelete')){
		  echo	$sql = "DELETE FROM `$tablename` WHERE estimate_id = '$estimateId' and product_id = '$productId'";
		 }
	   
		$wpdb->query($sql);
  
		echo $productId;
  
	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_estimate_product_multiple_delete', 'estimate_product_multiple_delete' );
add_action( 'wp_ajax_nopriv_estimate_product_multiple_delete', 'estimate_product_multiple_delete' );

function estimate_product_multiple_delete() {

			global $wpdb;
		 

		$tablename = $wpdb->prefix . "estimate_products"; 
		$id  = $_POST['id'];  
		$nonce  = $_POST['nonce'];  
		foreach($_POST["id"] as $id){
 						$sql = "DELETE FROM `$tablename` WHERE id = '$id'";
						$wpdb->query($sql);
 		 }
			
			echo 'Success';
  
	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_estimate_product_converToCart', 'estimate_product_converToCart' );
add_action( 'wp_ajax_nopriv_estimate_product_converToCart', 'estimate_product_converToCart' );

function estimate_product_converToCart() {

	  global $woocommerce;  
		$id  = $_POST['id'];  
		foreach($_POST["id"] as $id){
			$products = 	getProductsByID($id);
			print_r($products);
  					//	$sql = "DELETE FROM `$tablename` WHERE id = '$id'";
					//	$wpdb->query($sql);
					$woocommerce->cart->add_to_cart($products[0]['product_id']);
				  
 		 }
			
			echo 'Success';
  
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_estimate_product_Export', 'estimate_product_Export' );
add_action( 'wp_ajax_nopriv_estimate_product_Export', 'estimate_product_Export' );
function estimate_product_Export() {
//	echo $downloadLink = plugin_dir_url( __FILE__ ) . 'assets/file.csv';
	$CSVurl = plugin_dir_path( __FILE__ ). 'assets/estimate.csv'; 
	
	global $woocommerce;  
	$estimateId = $_POST["estimateId"];
	 $estimateData = get_estimate_by_id($estimateId);
	$userId     = $estimateData['user_id']; //string value use: %s 

	$user = get_user_by( 'ID', $userId );
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Style

$heading = array(
	'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '000000'),
			'size'  => 14,
			'name'  => 'Verdana'
	));
	$styleArray = array(
		'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FF0000'),
				'size'  => 9,
				'name'  => 'Verdana'
		));
		$totalSection = array(
			'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => '000000'),
					'size'  => 8,
					'name'  => 'Verdana'
			));

	 $backgroundColor = 	array(
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'd5d5d5')
				));

	$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($heading); 
	


 
// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Price Estimate')
->setCellValue('A2', 'CREATED BY')
->setCellValue('A3', 'Name : '.$user->first_name.' '.$user->last_name)
->setCellValue('A4', 'Company : '.get_user_meta( $user->ID, 'company_name' , true ))
->setCellValue('A5', 'Email : '.$user->user_email)
->setCellValue('A6', 'Cell : '.get_user_meta( $user->ID, 'mobile' , true ));
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A2')->getFont()->setBold( true );
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold( true );
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->applyFromArray(
	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

 // Miscellaneous glyphs, UTF-8
$objPHPExcel->setActiveSheetIndex(0) 
->setCellValue('D2', 'END USER DETAILS')
->setCellValue('D3', 'End User : '.$estimateData['enduser_name'])
->setCellValue('D4', 'Contact Person: '.$estimateData['enduser_contact_person'])
->setCellValue('D5', 'User Contact : '.$estimateData['enduser_contact'])
->setCellValue('D6', 'User Email : '.$estimateData['enduser_email'])
->setCellValue('D7', 'Address : '.$estimateData['enduser_address']);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D2')->getFont()->setBold( true );
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->applyFromArray(
	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);




// $companyName = get_option( 'company_name' );

// $objPHPExcel->setActiveSheetIndex(0)
// ->setCellValue('A7', 'Price Estimate for planning and information purposes only and is not a binding offer from'.$companyName);
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:E7');
// $objPHPExcel->setActiveSheetIndex(0)->getStyle('A7')->getAlignment()->applyFromArray(
// 	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
// );

$timestamp = strtotime($estimateData['cdate']);
		 $date = 	date("d-M-Y", $timestamp);
  $estimate_id = 	 'NS00'.$estimateId; 
	$estimate_name = 	$estimateData['estimate_name'];
	$estimate_description = 	$estimateData['estimate_description'];
	$days = get_option( 'delete_time' );
	$timestamp = strtotime($estimateData['cdate'].$days.'day');
  $validDate = 	date("d-M-Y", $timestamp);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A8',  'ESTIMATE DETAILS')
->setCellValue('A9',  'Date : '.$date)
->setCellValue('A10', 'Estimate ID : '.$estimate_id)
->setCellValue('A11', 'Estimate Name : '.$estimate_name)
->setCellValue('A12', 'Estimate Description : '.$estimate_description)
->setCellValue('A13', 'Valid Till : '.$validDate);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A8')->getFont()->setBold( true );
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->applyFromArray(
	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);


$rowNumber2 = 0;
$rowNumber = 14;
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$rowNumber, 'Product Number')
            ->setCellValue('B'.$rowNumber, 'Product Name')
            ->setCellValue('C'.$rowNumber,'Unit Price')
            ->setCellValue('D'.$rowNumber,'Qty')
						->setCellValue('E'.$rowNumber,'Total Price');

						$objPHPExcel->getActiveSheet()->getStyle('A'.$rowNumber)->applyFromArray($backgroundColor); 
						$objPHPExcel->getActiveSheet()->getStyle('B'.$rowNumber)->applyFromArray($backgroundColor); 
						$objPHPExcel->getActiveSheet()->getStyle('C'.$rowNumber)->applyFromArray($backgroundColor); 
						$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNumber)->applyFromArray($backgroundColor); 
						$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNumber)->applyFromArray($backgroundColor); 
 
						$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(20); 
						$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(25); 
						$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(20); 
						$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(15); 
						$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(20); 
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$rowNumber)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.$rowNumber)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('D'.$rowNumber)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$rowNumber)->getAlignment()->setWrapText(true);
						$objPHPExcel->setActiveSheetIndex(0)->getStyle($rowNumber)->getAlignment()->applyFromArray(
							array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,)
						);
			 foreach($_POST["id"] as $id){
								if($id == 'on'){
									continue;
								}
								$allProduct =  getProductsByID($id);
								$product = wc_get_product( $allProduct[0]['product_id'] ); 
								//print_r($product);
								//die();
							 $totalQty = getTotalQty($allProduct[0]['product_id'], $estimateId);
							 $qty = $totalQty[0]['totalQty'];
							 $productQty =  $qty != ''  ?  $qty  : 1;
							 // $productTotalPrice = $product->get_price() * $productQty; 
							 // $subtotal = $subtotal + $productTotalPrice;
					
							 $with_tax = $product->get_price_including_tax();
							 $without_tax = $product->get_price_excluding_tax();
							 $tax_amount = $with_tax - $without_tax;
							 if($without_tax != 0){
								 $without_taxTotalPrice = $without_tax * $productQty; 
								 $subtotal = $subtotal + $without_taxTotalPrice; 
								 $totalTax = $productQty * $tax_amount;
								 $subtotalTax = $subtotalTax + $totalTax;
							 }else{
								 $productTotalPrice = $product->get_price() * $productQty; 
								 $subtotal = $subtotal + $productTotalPrice; 
								 $totalTax = 0;
							 }

// Add some data
$rowNumber2 = $rowNumber + 1;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$rowNumber2, $product->get_sku())
            ->setCellValue('B'.$rowNumber2, $product->get_name())
            ->setCellValue('C'.$rowNumber2, $without_tax !=0 ? $without_tax : $product->get_price())
            ->setCellValue('D'.$rowNumber2, $productQty)
						->setCellValue('E'.$rowNumber2, $without_tax !=0 ? $without_taxTotalPrice : $productTotalPrice);
		
 	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber2)->getNumberFormat()->setFormatCode('@');
 	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$rowNumber2)->getNumberFormat()->setFormatCode('#');
 	$objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.$rowNumber2)->getNumberFormat()->setFormatCode('#,##0.00');
 	$objPHPExcel->setActiveSheetIndex(0)->getStyle('D'.$rowNumber2)->getNumberFormat()->setFormatCode('#');
 	$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$rowNumber2)->getNumberFormat()->setFormatCode('#,##0.00');

	 $rowNumber++;
						
	 }
	 $grandTotal = $subtotalTax + $subtotal;
	 $rowNumber3 = $rowNumber2 + 1;
	 $objPHPExcel->setActiveSheetIndex(0)
	             ->setCellValue('D'.$rowNumber3, 'SubTotal')
							 ->setCellValue('E'.$rowNumber3, $subtotal);
							 
							 
							 $rowNumber4 =	 $rowNumber2+2;
	 $objPHPExcel->setActiveSheetIndex(0)
	             ->setCellValue('D'.$rowNumber4, 'Estimated Tax')
							 ->setCellValue('E'.$rowNumber4, $subtotalTax);
							 $rowNumber5 =	 $rowNumber2+3;
	 $objPHPExcel->setActiveSheetIndex(0)
	             ->setCellValue('D'.$rowNumber5, 'Grand Total')
							 ->setCellValue('E'.$rowNumber5,  $grandTotal);

		$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNumber3)->applyFromArray($totalSection);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNumber4)->applyFromArray($totalSection);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$rowNumber5)->applyFromArray($totalSection);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNumber3)->applyFromArray($totalSection);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNumber4)->applyFromArray($totalSection);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$rowNumber5)->applyFromArray($totalSection);

		$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$rowNumber3)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$rowNumber4)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$rowNumber5)->getNumberFormat()->setFormatCode('#,##0.00');

  $baseRow = 5;

	$rowNumber5 = $rowNumber2 + 5;
	// $rowNumber6 = $rowNumber2 + 5;
	$ErowNumber5 = $rowNumber5 + 3;
	//   $a = 'A'.$rowNumber5;
	//  $h = 'H'.$rowNumber5;
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$rowNumber5.':E'.$ErowNumber5);
	
  // $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A16:H17');
	// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A18:H18');
	// $objPHPExcel->setActiveSheetIndex(0)->removeColumn('A','B');
  
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber5)->getAlignment()->setWrapText(true);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber5)->getAlignment()->applyFromArray(
    array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

// $companyName = get_option( 'company_name' );

// $objPHPExcel->setActiveSheetIndex(0)
// ->setCellValue('A'.$rowNumber5, 'Price Estimate for planning and information purposes only and is not a binding offer from'.$companyName);
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$rowNumber5.':E'.$rowNumber5);
// $objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber5)->getAlignment()->applyFromArray(
// 	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
// );
$rowNumber6 = $rowNumber5 - 1;

$companyName = get_option( 'company_name' );

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A'.$rowNumber6, 'Price Estimate for planning and information purposes only and is not a binding offer from '.$companyName);
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$rowNumber6.':E'.$rowNumber6);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$rowNumber6)->getAlignment()->applyFromArray(
	array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);
$objPHPExcel->getActiveSheet()->getStyle('A'.$rowNumber6)->applyFromArray($styleArray);

    $estimate_footer = get_option( 'estimate_export_footer' );  
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$rowNumber5,$estimate_footer);


    // $estimate_footer = get_option( 'estimate_export_footer' );  
		// $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowNumber5,$estimate_footer);


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.csv',  $CSVurl));

echo 'success'; 			
   
	wp_die(); // this is required to terminate immediately and return a proper response
}





add_action( 'wp_ajax_estimate_product_Export_as_Pdf', 'estimate_product_Export_as_Pdf' );
add_action( 'wp_ajax_nopriv_estimate_product_Export_as_Pdf', 'estimate_product_Export_as_Pdf' );
function estimate_product_Export_as_Pdf() {
//	echo $downloadLink = plugin_dir_url( __FILE__ ) . 'assets/file.csv';
  $PDFurl = plugin_dir_path( __FILE__ ). 'assets/estimate.pdf';
	// header('Content-type: text/csv');
	// header('Content-disposition: attachment;filename="'. $PDFurl .'"');
		global $woocommerce;  
		$estimateId = $_POST["estimateId"];
 		$estimateData = get_estimate_by_id($estimateId);
		$userId     = $estimateData['user_id']; //string value use: %s 

		$user = get_user_by( 'ID', $userId ); 
 	 
 				ob_start();
 		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<title>Estimate</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		</head>
 <body>
   <div class="estimate" style="font-size: 14px;page-break-inside: auto"> 
  	 <h3 style="text-align:center">Price Estimate</h3>
		 <div style="width:40%; float:left" >
 		<table style="width:100%">
		  <tr>
				<th colspan="2" style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">CREATED BY</th>
  			</tr>
		  <tr>
 				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Name:</th>
 				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $user->first_name.' '.$user->last_name; ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Company:</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo get_user_meta( $user->ID, 'company_name' , true ); ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Email:</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $user->user_email; ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Cell:</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo get_user_meta( $user->ID, 'mobile' , true ); ?></td>
 			</tr>
		</table>
 	</div>
	 <div style="width:60%; float:left" >
		<table style="width:100%">
	   	<tr>
				<th colspan="2" style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">END USER DETAILS</th>
  		 </tr>
 		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">End User</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $estimateData['enduser_name']; ?></td>
 			</tr>
		  <tr>
 				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Contact Person</th>
 				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $estimateData['enduser_contact_person']; ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Contact Number</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $estimateData['enduser_contact']; ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Email</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $estimateData['enduser_email']; ?></td>
 			</tr>
		  <tr>
				<th style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">Address</th>
				<td style="font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $estimateData['enduser_address']; ?></td>
 			</tr>
		</table>
	</div>  
	 <div style="width:100%;clear:both;" >
	 <table style="width:35%"> 
	 <tr>
				<th colspan="2" style="font-size:10px;font-family: Arial, Helvetica, sans-serif;">ESTIMATE DETAILS</th>
  		 </tr>
				<tr>
	 				<th style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">Date</th>
					 <td style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php 
						  $timestamp = strtotime($estimateData['cdate']);
						 echo	date("d-M-Y", $timestamp);

 ?></td>
	 			</tr>
			  <tr>
					<th style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">Estimate ID:</th>
					<td style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo 'NS00'.$estimateId; ?></td>
	 			</tr>
			  <tr>
					<th style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">Estimate Name:</th>
					<td style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $estimateData['estimate_name'] ?></td>
	 			</tr>
			  <tr>
					<th style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">Estimate Description</th>
					<td style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $estimateData['estimate_description'] ?></td>
	 			</tr>
			  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
	 			</tr><tr>
					<th style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">Valid Till</th>
					<td style="padding: 0px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php $days = get_option( 'delete_time' ); $timestamp = strtotime($estimateData['cdate'].$days.'day');
						 echo	date("d-M-Y", $timestamp);   ?></td>
	 			</tr>
			</table>
 </div>
 <div class="products" style="width:100%;margin-top: 10px">
		<table border="1" style="width:100%;border-collapse: collapse"> 
		  <tr>
 				<th style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;width:20%">Product Numer</th>
 				<th style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;width:45%">Description</th>
 				<th style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;text-align: right;width:10%">Unit Price</th>
 				<th style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;;width:10%;text-align: center">Qty</th>
 				<th style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;text-align: right;">Total Price</th>
			 </tr>
			 <?php
			 print_r($_POST["id"]);
			 foreach($_POST["id"] as $id){
				 if($id == 'on'){
						continue;
				 }
				$allProduct =  getProductsByID($id);
				 $product = wc_get_product( $allProduct[0]['product_id'] ); 
				 //print_r($product);
				 //die();
				$totalQty = getTotalQty($allProduct[0]['product_id'], $estimateId);
				$qty = $totalQty[0]['totalQty'];
				$productQty =  $qty != ''  ?  $qty  : 1;
				// $productTotalPrice = $product->get_price() * $productQty; 
				// $subtotal = $subtotal + $productTotalPrice;

				$with_tax = $product->get_price_including_tax();
				$without_tax = $product->get_price_excluding_tax();
				$tax_amount = $with_tax - $without_tax;
				if($without_tax != 0){
					$without_taxTotalPrice = $without_tax * $productQty; 
					$subtotal = $subtotal + $without_taxTotalPrice; 
					$totalTax = $productQty * $tax_amount;
					$subtotalTax = $subtotalTax + $totalTax;
				}else{
					$productTotalPrice = $product->get_price() * $productQty; 
					$subtotal = $subtotal + $productTotalPrice; 
					$totalTax = 0;
				}
			 ?>
		  <tr>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo  $product->get_sku() != '' ? $product->get_sku()  : ''; ?></td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $product->get_name(); ?></td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $without_tax !=0 ? number_format($without_tax,2) : number_format($product->get_price(), 2); ?></td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;text-align: center"><?php echo $productQty; ?></td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;"><?php echo $without_tax !=0 ? number_format($without_taxTotalPrice,2) : number_format($productTotalPrice, 2); ?></td>
			 </tr>
			 <?php } ?>
			 <!-- <tr>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">AIR-PWR-CORD-SA</td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">ASA 5506-X with FirePOWER services, 8GE, AC, DES</td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;">995.00</td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;text-align: center">1</td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;">995.00</td>
 			</tr>
			 <tr>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">RV320-WB-K9-G5</td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">ASA 5506-X with FirePOWER services, 8GE, AC, DES</td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;">995.00</td>
				<td style="padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;text-align: center;">1</td>
				<td style="padding: 5px;text-align: right;font-size:10px;font-family: Arial, Helvetica, sans-serif;">995.00</td>
 			</tr> -->
			 <tr>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" colspan="4">Subtotal</td>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" ><?php echo  number_format($subtotal, 2); ?></td> 
 			</tr>
			 <tr>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" colspan="4">Estimated Tax</td>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" > <?php echo number_format($subtotalTax,2); ?></td> 
 			</tr>
			 <tr>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" colspan="4">Grand Total</td>
				<td style="text-align: right;padding: 5px;font-size:10px;font-family: Arial, Helvetica, sans-serif;" ><?php echo number_format($subtotalTax + $subtotal, 2); ?></td> 
 			</tr>
		  
		</table>
		</div>
		<div class="note" style="text-align: center;width:100%;clear:both;margin-top: 10px">
	    <p style="color:red;margin: 5px">Price Estimate for planning and information purposes only and is not a binding offer from <?php echo get_option( 'company_name' ); ?></p>
		</div>
		<div style="width:100%;margin-top:10px;font-size:10px;font-family: Arial, Helvetica, sans-serif;">
		 <p><?php echo get_option( 'estimate_export_footer' ); ?></p>
		</div>
 </div>
 </body>
 </html>

<?php
 $html = ob_get_clean();
 $html = stripslashes($html);

		if(isset($_POST["id"])){
 			// instantiate and use the dompdf class
			$dompdf = new Dompdf();
			$dompdf->loadHtml($html);

			// (Optional) Setup the paper size and orientation
			$dompdf->set_paper('A4', 'portrait');
			// $dompdf->set_paper("A4", "portrait");

			// Render the HTML as PDF
			$dompdf->render();
			$output = $dompdf->output();
			file_put_contents($PDFurl, $output);
			// Output the generated PDF to Browser
	   //	$dompdf->stream("sample.pdf");
		}

		echo 'success';
 			
   
	wp_die(); // this is required to terminate immediately and return a proper response
}
// add_action('init', 'estimate_product_Export_as_Pdf');

add_action( 'wp_ajax_estimate_product_CSVEmail', 'estimate_product_CSVEmail' );
add_action( 'wp_ajax_nopriv_estimate_product_CSVEmail', 'estimate_product_CSVEmail' );
function estimate_product_CSVEmail() {
	$downloadLink = plugin_dir_url( __FILE__ ) . 'assets/file.csv';
	$CSVurl = plugin_dir_path( __FILE__ ). 'assets/file.csv';
	header('Content-type: text/csv');
	header('Content-disposition: attachment;filename="'. $CSVurl .'"');
	  global $woocommerce;  
		$id  = $_POST['id'];  
		if(isset($_POST["id"]))
{
 $array = [];
		foreach($_POST["id"] as $id){
			$products = 	getProductsByID($id);

	     $array[] = $products[0] ; 
						  
			}   
		$fp = fopen($CSVurl , 'w');
 	 if($fp === FALSE) {
				die('Failed to open temporary file');
		}
 		for ($i=0; $i < count($array); $i++) { 
 				fputcsv($fp, $array[$i]);
		} 
		fclose($fp);
	}
	
	$attachments = array(WP_CONTENT_DIR . $downloadLink);
	$headers = 'From: My Name <myname@mydomain.com>' . "\r\n";
	wp_mail('hossaincse2@gmail.com', 'subject', 'message', $headers, $attachments);
			
			echo 'Success';
  
	wp_die(); // this is required to terminate immediately and return a proper response
}

function getProductsByID($id){
	global $wpdb;
	$tablename = $wpdb->prefix . "estimate_products";
	$sql = "Select * from $tablename where `id` = '$id'";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}


add_action( 'wp_ajax_product_get_by_id', 'product_get_by_id' );
add_action( 'wp_ajax_nopriv_product_get_by_id', 'product_get_by_id' );

function product_get_by_id() {
	global $wpdb;

	$tablename = $wpdb->prefix . "estimate_products";

	$productID  = $_POST['productID'];  
	$estimateId  = $_POST['estimateId'];  
	$product = wc_get_product( $productID );

	$productName = $product->get_name(); 
	$productPrice = $product->get_price();
	$getQty = getTotalQty($productID, $estimateId); 
	$qty = $getQty[0]['totalQty'];
  $productQty = $qty + 1;
	$productTotalPriceByID = $productPrice * $productQty;
	
	// echo $sql = "INSERT INTO `$tablename` (`estimate_id`,`product_id`, `product_name`, `qty`, `price`, `total_price`) values ('$estimateId', '$productID', '$productName','$productQty', '$productPrice', '$productTotalPrice')";
  if(empty(productIdCheckInEstimate($productID,$estimateId))){
		$sql = $wpdb->prepare("INSERT INTO `$tablename` (`estimate_id`,`product_id`, `product_name`, `qty`, `price`, `total_price`) values (%d, %d, %s, %s, %s, %s)", $estimateId, $productID, $productName,$productQty, $productPrice, $productTotalPriceByID);
	}else{ 
	 $sql =  $wpdb->prepare( "UPDATE `$tablename`
		SET `qty` = '$productQty',
				`total_price` = '$productTotalPriceByID'
		WHERE  `estimate_id` = %d AND `product_id` = %d", $estimateId,$productID);
	}

	$wpdb->query($sql);

	ob_start();

	$allProducts = allGetProducts($estimateId);
	$subtotal = 0;
	foreach($allProducts as $productItem){
		$product = wc_get_product( $productItem['product_id'] ); 
		$totalQty = getTotalQty($productItem['product_id'], $estimateId);
		$qty = $totalQty[0]['totalQty'];
		$productQty =  $qty != ''  ?  $qty  : 1;
		// $productTotalPrice = $product->get_price() * $productQty; 
		// $subtotal = $subtotal + $productTotalPrice;

		$with_tax = $product->get_price_including_tax();
		$without_tax = $product->get_price_excluding_tax();
		$tax_amount = $with_tax - $without_tax;
		if($without_tax != 0){
			 $without_taxTotalPrice = $without_tax * $productQty; 
			 $subtotal = $subtotal + $without_taxTotalPrice; 
			 $totalTax = $productQty * $tax_amount;
			 $subtotalTax = $subtotalTax + $totalTax;
		}else{
			 $productTotalPrice = $product->get_price() * $productQty; 
			 $subtotal = $subtotal + $productTotalPrice; 
			 $totalTax = 0;
		}

	?>
	<div class="productListBody">  
             <div class="product" id="remove<?php echo $productItem['id']; ?>"> 
								<div  class="product-removal"> 
									<div class="checkBox">
											 <input value="<?php echo $productItem['id']; ?>"  type="checkbox">
									</div>
										<!-- <a data-id="<?php echo $productItem['id']; ?>" data-estimateId="<?php echo $estimateId; ?>" data-productId="<?php echo $productItem['product_id']; ?>" data-nonce="<?php echo wp_create_nonce( 'productDelete' ); ?>"  class="remove-product">
											 <img style="width:20px" src="<?php echo get_template_directory_uri() . '/img/delete.svg' ?>" alt="">
										</a> -->
									</div>
									<div class="product-code text-left"><?php echo  $product->get_sku() != '' ? $product->get_sku()  : 'Empty'; ?></div>
                  <div class="product-details">
										<div class="product-title"><?php echo $product->get_name(); ?></div>
										<p class="product-description"> It has a lightweight, breathable mesh upper with forefoot cables for a locked-down fit.</p>
									</div>
									<div class="product-price text-right"><?php echo $without_tax !=0 ? number_format($without_tax,2) : number_format($product->get_price(), 2); ?></div>
									<div class="product-quantity text-right">
										<input type="text" data-id="<?php echo $productItem['id']; ?>" value="<?php echo $productQty; ?>" min="1">
                	</div> 
                    <input type="hidden" class="tax-amount" value="<?php echo number_format($tax_amount,2); ?>">
                    <input type="hidden" class="sub-tax-amount" value="<?php echo number_format($totalTax,2); ?>">
 									<div class="product-line-price"><?php echo $without_tax !=0 ? number_format($without_taxTotalPrice,2) : number_format($productTotalPrice, 2); ?></div>
						     </div>
	<?php }		 ?>
	   <div class="totals">
             <div class="totals-item">
               <label>Subtotal</label>
               <div class="totals-value" id="cart-subtotal"> <?php echo  number_format($subtotal, 2); ?></div>
             </div>
             <div class="totals-item">
                  <label>Tax</label>
                  <div class="totals-value" id="cart-tax"> <?php echo number_format($subtotalTax,2); ?></div>
                </div>
             <!-- <div class="totals-item">
               <label>Shipping</label>
               <div class="totals-value" id="cart-shipping">15.00</div>
             </div> -->
             <div class="totals-item totals-item-total">
               <label>Grand Total</label>
               <div class="totals-value" id="cart-total"> <?php echo number_format($subtotalTax + $subtotal, 2); ?></div>
             </div>
           </div>
           </div>  
	<?php
	 $listCard = ob_get_clean();
	 
	 echo $listCard;
 	// echo json_encode($product);

	wp_die(); // this is required to terminate immediately and return a proper response
}


function productIdCheck($id){
	global $wpdb;
	$tablename = $wpdb->prefix . "estimate_products";
	$sql = "Select * from $tablename where `id` = '$id'";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}

function productIdCheckInEstimate($product_id,$estimate_id){
	global $wpdb;
	$tablename = $wpdb->prefix . "estimate_products";
	$sql = "Select * from $tablename where `product_id` = '$product_id' AND estimate_id = '$estimate_id'";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}

function getTotalQty($productId, $estimateId){
	global $wpdb;
	$tablename = $wpdb->prefix . "estimate_products";
	$sql = "SELECT product_id,SUM(qty) as totalQty FROM $tablename Where estimate_id = '$estimateId' and  product_id = $productId GROUP BY product_id;";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}

function allGetProducts($estimateId){
	global $wpdb;
	$tablename = $wpdb->prefix . "estimate_products";
	$sql = "Select * from $tablename Where estimate_id = '$estimateId'  Group By product_id Order by id ASC";
	$values = $wpdb->get_results($sql,ARRAY_A);
	return $values;
}
