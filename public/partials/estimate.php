<?php
 /* Template Name: Product Estimate Page */ 
 if ( !is_user_logged_in() ) {
    header('Location: ' . wp_login_url());
} 
 wp_head();

 get_header();
 global $current_user;
   get_currentuserinfo();
  //  print_r($current_user);
  $userId =  $current_user->ID;
  $estimateId =  $_GET['estimate-id'];
  $details =  product_estimate_Public::get_details_estimate($estimateId); 
  // $csvExport = new CSVExport(); 

  ?>
 
<div class="container" style="margin-top:100px">
  <div class="row">
  <div class="col-md-3">
    <div class="aside">
         <div class="devicelist">
              <!-- Sidebar -->
        <div class="bg-light" id="sidebar-wrapper">
        <div class="sidebar-heading">Device List </div>
        <div class="list-group list-group-flush">
            <?php do_action ( 'device_list' ); ?> 
        </div>
        
        </div>
        </div>

        <div  style="margin:25px 0px" class="bg-light" id="sidebar-wrapper">
        <div class="sidebar-heading">Sensor List </div>
        <?php do_action ( 'sensore_list' ); ?> 
     
        <!-- /#sidebar-wrapper -->
            <?php //echo do_shortcode(' [recent_products per_page="4" columns="1" orderby=”date” order="ASC"]'); ?>
        </div>
        <!-- <h5>Sensore List</h5>
        <div class="devicelist">
            <?php //echo do_shortcode(' [recent_products per_page="4" columns="1" orderby=”date” order="ASC"]'); ?>
        </div> -->
    </div>
  </div>
  <div class="col-md-9 estimate_section"> 
    
    <!-- <div class="cart-pakage">
        <?php //echo do_shortcode('[woocommerce_cart] '); ?>
    </div> -->
    
       
   
    <div class="card">
    <div class="estimateDetails" style="<?php echo isset($estimateId) ?  'display:block' : 'display:none'   ?>">
    <div class="card-header">
         <span><img style="width: 16px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/details.svg'; ?>" alt=""> Details Estimate</span> 
         <ul class="list-inline listMenu">
            <li class="list-inline-item"><a class="social-icon text-xs-center"  href="<?php echo home_url(); ?>/estimate">Create Estimate</a></li>
           </ul>
        </div>
        <div class="card-body"> 
            <div class="row">
              <div class="col-md-6">
                <b>Estimate ID:</b> <span>#NS00<?php echo isset($details[0]->id) ?  $details[0]->id : ''  ?></span> <br>
                <b>Estimate Name:</b> <span><?php echo  isset($details[0]->estimate_name) ?  $details[0]->estimate_name : '' ?></span> <br> 
                <b>Estimate Description:</b> <span><?php echo  isset($details[0]->estimate_description) ?  $details[0]->estimate_description : '' ?></span> <br> 
              </div>
              <div class="col-md-6">
                <a class="float-right" href="estimate_edit?estimate-id=<?php echo  isset($details[0]->id) ?  $details[0]->id : '' ?>"><img style="width: 16px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/edit.svg'; ?>" alt=""> Edit</a>
                <b>End user Name:</b> <span><?php echo  isset($details[0]->enduser_name) ?  $details[0]->enduser_name : '' ?></span> <br>
                <b>End user Email:</b> <span><?php echo  isset($details[0]->enduser_email) ?  $details[0]->enduser_email : '' ?></span> <br>
                <b>End user Contact Person:</b> <span><?php echo  isset($details[0]->enduser_contact_person) ?  $details[0]->enduser_contact_person : '' ?></span> <br>
                <b>End user Contact Number:</b> <span><?php echo  isset($details[0]->enduser_contact) ?  $details[0]->enduser_contact : '' ?></span> <br>
                <b>End user Address:</b> <span><?php echo  isset($details[0]->enduser_address) ?  $details[0]->enduser_address : '' ?></span> <br>
              </div>
         </div>
        </div>
        </div>
        <div class="estimateForm" style="<?php echo isset($estimateId) ?  'display:none' : 'display:block'   ?>">
        <div class="card-header">
         <span><img style="width: 16px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/add.svg'; ?>" alt=""> Create Estimate</span> 
         <ul class="list-inline listMenu">
            <li class="list-inline-item"><a class="social-icon text-xs-center"  href="<?php echo home_url(); ?>/estimate_list"> Estimate List</a></li>
           </ul>
        </div>
        <div class="card-body"> 
        <form  class="pb-4" action="" s>
          <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Estimate Name</label>
                  <input type="hidden" class="form-control" name="userId" id="userId" value="<?php echo  $userId; ?>">
                  <input type="text" class="form-control" name="estimateName" id="estimateName">
                 </div>
                 <div class="form-group">
                    <label for="pwd">Estimate Description</label>
                    <textarea name="description" id="description" cols="30" rows="7"></textarea>
                  </div>  
               </div>
               <div class="col-md-6">
               <div class="form-group">
                  <label for="pwd">End User</label>
                  <input type="text" class="form-control" name="endUserName" id="endUserName">
                 </div> 
                 <div class="form-group">
                    <label for="pwd">End User Contact Person</label>
                    <input type="text" class="form-control" name="endUserContactPerson" id="endUserContactPerson">
                  </div> 
                 <div class="form-group">
                    <label for="pwd">End User Contact Number</label>
                    <input type="text" class="form-control" name="endUserContact" id="endUserContact">
                  </div> 
                 
                <div class="form-group">
                  <label for="email">End User Email</label>
                  <input type="email" class="form-control" name="endUserEmail" id="endUserEmail">
                 </div> 
                 <div class="form-group">
                    <label for="pwd">End User Address</label>
                    <textarea name="endUserAddress" id="endUserAddress" cols="30" rows="2"></textarea>
                  </div> 
               </div>
          </div> 
          <div class="col-md-12  text-right p0">
             <button type="submit" id="estimateInsert" class="btn btn-primary">Create</button>
          </div>
        </form>
        </div>
        </div>
     </div>
    <div class="estimate-cart">
    <div class="card">
        <div class="card-header">
          <span class="titleList"><img style="width: 16px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/list.svg'; ?>" alt=""> List  Products</span>  
          <ul class="list-inline listMenu">
            <li class="list-inline-item"><a id="btn_delete" class="social-icon text-xs-center"  href="#"> <img style="width: 16px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/delete.svg'; ?>" alt=""> Delete</a></li>
            <li class="list-inline-item dropdown"><a   class="social-icon text-xs-center  dropdown-toggle" data-toggle="dropdown" href="#""><img style="width: 18px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/export.svg'; ?>" alt=""> Export</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" data-id = "<?php echo isset($_GET['estimate-id']) ? $_GET['estimate-id'] : '';  ?>" id="btn_export_pdf"  href="#">Export as pdf</a>
                <a class="dropdown-item" data-id = "<?php echo isset($_GET['estimate-id']) ? $_GET['estimate-id'] : '';  ?>" id="btn_export"  href="#">Export as csv</a>
             </div>
          </li>
            <li class="list-inline-item"><a id="estimate_clone" data-id = "<?php echo isset($_GET['estimate-id']) ? $_GET['estimate-id'] : '';  ?>" class="social-icon text-xs-center" target="_blank" href="#"><img style="width: 15px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/clone.svg'; ?>" alt=""> Clone</a></li>
            <li class="list-inline-item"><a  id="btn_email" class="social-icon text-xs-center" target="_blank" href="#"><img style="width: 15px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/email.svg'; ?>" alt=""> Email</a></li>
            <li class="list-inline-item"><a id="btn_convert" class="social-icon text-xs-center"   href="#"><img style="width: 20px;" src="<?php  echo plugin_dir_url( dirname( __FILE__ ) ) . '/img/convert.svg'; ?>" alt=""> Convert To Cart</a></li>
          </ul>
        </div>
        <div class="card-body">
           
              <div class="shopping-cart">
              <?php
              $estimateId = isset($_GET['estimate-id']) ? $_GET['estimate-id'] : '';
              $allProducts = product_estimate_Public::allGetProducts($estimateId);  
            // if( !empty($allProducts)){
           ?>
              <div class="column-labels">
                <label class="product-removal"><input id="checkAll" type="checkbox"></label>
                <label class="product-code">Product Code</label>
                <label class="product-details text-left">Product Description</label>
                <label class="product-price text-right">Unit Price</label>
                <label class="product-quantity text-right">Quantity</label>
                <label class="product-line-price text-right">Total</label>
              </div> 
              <?php //} ?>  
 <div class="productListBody">  
    <?php 
     if( !empty($allProducts)){ 
      $subtotal = 0;
      $totalTax = 0;
      foreach($allProducts as $productItem){
        $product = wc_get_product( $productItem['product_id'] );
        $totalQty = product_estimate_Public::getTotalQty($productItem['product_id'],$estimateId) ;
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
       
             <div id="remove<?php echo $productItem['id']; ?>" class="product"> 
								<div class="product-removal"> 
									<div class="checkBox">
                        <input name="products_id[]" id="checkboxes-0" value="<?php echo $productItem['id']; ?>" type="checkbox" data-id="<?php echo $productItem['id']; ?>" data-estimateId="<?php echo $estimateId; ?>" data-productId="<?php echo $productItem['product_id']; ?>" data-nonce="<?php echo wp_create_nonce( 'productDelete' ); ?>" >
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
                  <label>Estimated Tax</label>
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
                  <!-- <button class="btn btn-primary float-right">Export</button> -->
                  <?php }else{
              //  echo 'No Products';
        } ?>
              </div> 
        </div>
      
     </div>
    </div>



    <div class="bundle-pakage">
         <?php echo do_shortcode(' [products limit="4" columns="4" category="bundle-product" cat_operator="AND"]
'); ?>
    </div>
  </div>
  </div>
</div>
<?php
get_footer();