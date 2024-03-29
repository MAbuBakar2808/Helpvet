<?php
session_start();
/**
 * Form posting handler
 */
require_once( dirname(dirname( dirname( dirname( dirname( dirname( __FILE__ )))))) . '/wp-load.php' );

/**
* Add transaction info to database 
*/
global $wpdb, $listingpro_options;

$dbprefix = $wpdb->prefix; 

	
	 
	 //for ads payment
	 
	 if( !empty($_POST['listing_id']) && isset($_POST['listing_id']) && !empty($_POST['method']) && isset($_POST['method']  ) && is_array($_POST['package_level']) ){
		 
		 $func_type = $_POST['func'];
		 $lp_random_ads = $listingpro_options['lp_random_ads'];
		 $lp_detail_page_ads = $listingpro_options['lp_detail_page_ads'];
		 $lp_top_in_search_page_ads = $listingpro_options['lp_top_in_search_page_ads'];
		 $currencyprice = $listingpro_options['currency_paid_submission'];
		 $currency = $listingpro_options['currency_paid_submission'];
		 
		 $listing_id = $_POST['listing_id'];
		 $method = $_POST['method'];
		 $price_package = $_POST['package_level'];
		 $lp_total_price = $_POST['lp_total_price'];
		 $price_packages = array();
		 
		 
		 $pricetotal = 0;
		
		 /* paypal */
		 if( $method=="paypal" ){
			 if( is_array($price_package) && !empty($listing_id) && !empty($method) ){
				 $enableTax = false;
				$Taxrate='';
				$Taxtype='';
				if($listingpro_options['lp_tax_swtich']=="1"){
					$enableTax = true;
					$Taxrate = $listingpro_options['lp_tax_amount'];
					$Taxtype = $listingpro_options['lp_tax_label'];
				}
				
				if($enableTax=="1" && !empty($Taxrate)){
					$pricetotal = $lp_total_price;
				}
				else{
				 foreach($price_package as $key=>$val):
					$pricetotal = (int)$val + (int)$pricetotal;
					$price_packages[]=$key;
					//$pricetotal = (float)$listingpro_options[$val] + (float)$pricetotal;
				 endforeach;
				}
			 }
			 else{
				 $backurl = site_url();
				 wp_redirect($backurl);
				 exit();
			 }
		 }
		 
		 /* wire */
		else if( $method=="wire" ){
			if( is_array($price_package) && !empty($listing_id) && !empty($method) ){
				$enableTax = false;
				$Taxrate='';
				$Taxtype='';
				if($listingpro_options['lp_tax_swtich']=="1"){
					$enableTax = true;
					$Taxrate = $listingpro_options['lp_tax_amount'];
					$Taxtype = $listingpro_options['lp_tax_label'];
				}
				
				if($enableTax=="1" && !empty($Taxrate)){
					$pricetotal = $lp_total_price;
				}
				else{
					foreach($price_package as $val):
						$pricetotal = (int)$val + (int)$pricetotal;
						//$pricetotal = (float)$listingpro_options[$val] + (float)$pricetotal;
					endforeach;
				}
				lp_create_campaigns_table();
				$user_ID = '';
				$user_ID = get_current_user_id();
				$status = 'pending';

				$start = 11111111;
				$end = 999999999;
				$ord_num = random_int($start, $end);

				$insert_data = array(
					'user_id' => $user_ID,
					'post_id' => $listing_id,
					'payment_method' => $method,
					'price' => $pricetotal,
					'currency' => $currency,
					'status' => $status,
					'transaction_id' => $ord_num
				);
				$table = 'listing_campaigns';
				lp_insert_data_in_db($table, $insert_data);
				update_post_meta( $listing_id, 'campaign_status', 'in progress' );
					
				$_SESSION['post_id'] = $listing_id;
				$_SESSION['price_package'] = $price_package;
				listing_set_metabox('listings_ads_purchase_packages', $price_package, $listing_id);
				$checkout = $listingpro_options['payment-checkout'];
				$checkout_url = get_permalink( $checkout );
				$perma = '';
				$methodQuery = 'checkout=wire';
				global $wp_rewrite;
				if ($wp_rewrite->permalink_structure == ''){
					$perma = "&";
				}else{
					$perma = "?";
				}
				

				$redirect = '';
				$redirect = $checkout_url.$perma.$methodQuery;
				wp_redirect($redirect);

				exit();
			}
			else{
				 $backurl = site_url();
				 wp_redirect($backurl);
				 exit();
			}
		}
		 
	}
		 
		 
	 


/**
* End function
*/



//if( !empty( $method ) && $method=="paypal" ){
	
	require get_template_directory().'/include/paypal/paypalapi2.php';
	/* for listing */
	if ( isset($_GET['func']) && $_GET['func'] == 'confirm' && isset($_GET['token']) && isset($_GET['PayerID']) ) {
	  
	  
	  
	  $var = new wp_PayPalAPI();
	  $var->ConfirmExpressCheckout();
	  
	  if ( isset( $_SESSION['RETURN_URL'] ) ) {
		$url = $_SESSION['RETURN_URL'];
		unset($_SESSION['RETURN_URL']);
		header('Location: '.$url);
		exit;
	  }
	  
	  if ( is_numeric(get_option('paypal_success_page')) && get_option('paypal_success_page') > 0 )
		header('Location: '.get_permalink(get_option('paypal_success_page')));
	  else
		header('Location: '.home_url());
	  exit;
	}
	
	

	if ( ! count($_POST) )
	  trigger_error('Payment error code: #00001', E_USER_ERROR);

	$allowed_func = array('start ads');
	if ( count($_POST) && (! isset($_POST['func']) || ! in_array($_POST['func'], $allowed_func)) ){
		
		trigger_error('Payment error code: #00002', E_USER_ERROR);
	}
	  
	  
	if( $_POST['func'] && (empty($price) || ! is_numeric($price) || !isset($price) || $price_package < 0) ){
			if( empty($pricetotal) || $pricetotal<0 ){
				trigger_error('Payment error code: #00003', E_USER_ERROR);
			}
			
		}
		

	  
	switch ( $_POST['func'] ) {
	  
	 case 'start ads':
		$var = new wp_PayPalAPI();
		$var->StartExpressCheckout();
		break;
	}