<?php
	add_action('wp_ajax_listingpro_save_stripe', 'listingpro_save_stripe');
	add_action('wp_ajax_nopriv_listingpro_save_stripe', 'listingpro_save_stripe');
	
	if(!function_exists('listingpro_save_stripe')){
		function listingpro_save_stripe(){
			require_once THEME_PATH . '/include/stripe/stripe-php/init.php';
			global $wpdb, $listingpro_options;
			$secritKey = '';
			$secritKey = $listingpro_options['stripe_secrit_key'];
			$dbprefix = '';
			$dbprefix = $wpdb->prefix;
			
			$current_user = wp_get_current_user();
			$useremail = $current_user->user_email;
			$usereDname = $current_user->display_name;
			
			$paypal_success = $listingpro_options['payment_success'];
			if(!empty($paypal_success)){
				$paypal_success = get_permalink($paypal_success);
			}
			$email = $_POST['email'];
			$planID = $_POST['plan'];
			$listing = $_POST['listing'];
			$token = $_POST['token'];
			$taxrate = '';
			$subsrID = '';
			$taxrate = $_POST['taxrate'];
			$recurring;
			if(isset($_POST['recurring']) && !empty($_POST['recurring'])){
				$recurring = $_POST['recurring'];
			} 

			$listing_title = get_the_title($listing);
			$planprice = get_post_meta($planID, 'plan_price', true);
			$taxPrice = 0;
			if(!empty($taxrate)){
				$taxPrice = ($taxrate/100)*$planprice;
				$taxPrice = $taxPrice*100;
			}
			$plan_time = get_post_meta($planID, 'plan_time', true);
			$planprice = (float)$planprice*100;
			$planprice = $planprice + $taxPrice;
			$planprice = round($planprice, 2);
			$planprice = (int)$planprice;
			$currency = '';
			$charge = array();
			$currency = $listingpro_options['currency_paid_submission'];
			$user_id = get_current_user_id();
			\Stripe\Stripe::setApiKey("$secritKey");
			
			if(!empty($recurring)){
				if(!empty($plan_time)){
					$plan_time = (int) $plan_time;
				}else{
					$response = '';
					$msG = '';
					$msG = esc_html__('Sorry! A plan should have a duration for recurring payment', 'listingpro');
					$response = json_encode(array('status'=>'fail', 'token'=>$token, 'email'=>$email, 'listing'=>$listing, 'redirect'=>$msG));
					
					die($response);
				}
				/* step-1 */
				$customer = \Stripe\Customer::create(array(
				  "email" => "$email",
				  "source" => $token,
				  'description' => "$usereDname"
				));
				
				
				
				/* step-2 */
				$plan = \Stripe\Plan::create(array(
				  "name" => get_the_title($planID).rand(),
				  "id" => "$user_id".rand(),
				  "interval" => "day",
				  "interval_count" => $plan_time,
				  "currency" => "$currency",
				  "amount" => $planprice,
				));
				
				
				/* step-3 */
				$subscirptionObj = \Stripe\Subscription::create(array(
				  "customer" => $customer->id,
				  "items" => array(
					array(
					  "plan" => $plan->id,
					)
				  ),
				));
				
				/* step-4 */
				/* $charge = \Stripe\Charge::create(array(
				  "amount" => $planprice,
				  "currency" => "$currency",
				  "description" => "Listing recurring payment",
				  "customer" => $customer->id
				)); */
				if( !empty($subscirptionObj) ){
					$subsrID = $subscirptionObj->id;
					$charge = array(
									'amount_refunded'=>0,
									'failure_code'=>null,
									'captured'=>true,
					);
				}
				else{
					$response = '';
					$msG = '';
					$msG = esc_html__('Sorry! Error in transaction', 'listingpro');
					$response = json_encode(array('status'=>'fail', 'token'=>$token, 'email'=>$email, 'listing'=>$listing, 'redirect'=>$msG));
					
					die($response);
				}
				
			}
			else{
				$declined = false;
				try {
					$customer = \Stripe\Customer::create(array(
					  "email" => "$email",
					  "source" => $token,
					  'description' => "$usereDname"
					));
					
					$charge = \Stripe\Charge::create(array(
					"amount" => $planprice,
					"currency" => "$currency",
					"description" => "Listing payment",
					"customer" => $customer->id
					));
				}catch (\Stripe\Error\Card $e) {
					$declined = true;
				}
				if($declined) {
					$response = '';
					$msG = '';
					$msG = esc_html__('Sorry! There is some problem in your stripe payment', 'listingpro');
					$response = json_encode(array('status'=>'fail', 'token'=>$token, 'email'=>$email, 'listing'=>$listing, 'redirect'=>$msG));
					
					die($response);
				}
				
			}
			
			if($charge['amount_refunded'] == 0 && $charge['failure_code'] == null && $charge['captured'] == true){
				
				

				$status = 'success';
				$method = 'stripe';
				$currency = '';
				$currency = $listingpro_options['currency_paid_submission'];
				
				$my_post;
				$listing_status = get_post_status( $listing );
				if($listingpro_options['listings_admin_approved']=="no" || $listing_status=="publish" ){
					$my_post = array( 'ID' => $listing, 'post_date'  => date("Y-m-d H:i:s"), 'post_status'   => 'publish' );
				}
				else{
					$my_post = array( 'ID' => $listing, 'post_date'  => date("Y-m-d H:i:s"), 'post_status'   => 'pending' );
				}
				wp_update_post( $my_post );
				
				$ex_plan_id = listing_get_metabox_by_ID('Plan_id', $listing);
				$new_plan_id = listing_get_metabox_by_ID('changed_planid', $listing);
				if(!empty($new_plan_id)){
					if( $ex_plan_id != $new_plan_id ){
						lp_cancel_stripe_subscription($listing, $ex_plan_id);
						listing_set_metabox('Plan_id',$new_plan_id, $listing);
						listing_set_metabox('changed_planid','', $listing);
					}
				}
				
				if(!empty($subsrID)){
					$new_subsc = array('plan_id' => $planID, 'subscr_id' => $subsrID, 'listing_id'=>$listing);
					lp_add_new_susbcription_meta($new_subsc);
				}
				
				$thepost = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$dbprefix."listing_orders WHERE post_id = %d", $listing ) );
			  
				
				$admin_email = '';
				$admin_email = get_option( 'admin_email' );
				
				$listing_id = $listing;
				$listing_title = get_the_title($listing);
				$invoice_no = $thepost->order_id;
				
				$date = date('d-m-Y');
				if(!empty($recurring)){
					$update_data = array('currency' => $currency,
									   'date' => $date,
									   'status' => $status,
									   'description' => 'listing has been purchased',
									   'payment_method' => $method,
									   'summary' => 'recurring',
									   'token' => $token);
				}
				else{
					$update_data = array('currency' => $currency,
									   'date' => $date,
									   'status' => $status,
									   'description' => 'listing has been purchased',
									   'payment_method' => $method,
									   'summary' => $status,
									   'token' => $token);
				}

				$where = array('post_id' => $listing_id);

				$update_format = array('%s', '%s', '%s', '%s', '%s', '%s');

				$wpdb->update($dbprefix.'listing_orders', $update_data, $where, $update_format);
				
				
				$packageResult = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$dbprefix."listing_orders WHERE post_id = %d", $listing ) );
				$planID = $packageResult->plan_id;
				$planUsed = $packageResult->used;
				
				$allowedPosts = '';
				$allowedPosts = get_post_meta($planID, 'plan_text' ,true);
				
				$update_data = array('used' => '1', 'transaction_id' => $token, 'status' => $status);
		  
				$where = array('token' => $token);
				  
				$update_format = array('%s', '%s', '%s');
				  
				$wpdb->update($dbprefix.'listing_orders', $update_data, $where, $update_format);
				
				if(!empty($allowedPosts) && $allowedPosts=="1"){
					$update_status = array('status' => 'expired');
					$wheree = array('plan_id' => $planID);
					$update_formatt = array('%s');
					$wpdb->update($dbprefix.'listing_orders', $update_status, $wheree, $update_formatt);
				}
				
				$current_user = wp_get_current_user();
				$useremail = $current_user->user_email;
				$admin_email = '';
				$admin_email = get_option( 'admin_email' );
				
				$listing_title = get_the_title($listing);
				$invoice_no = $thepost->order_id;
				$payment_method = $method;
				
				$plan_title = $thepost->plan_name;
				$plan_price = $thepost->price.$thepost->currency;
				$listing_url = get_the_permalink($listing);
				
				$mail_subject = $listingpro_options['listingpro_subject_purchase_activated_admin'];
				$website_url = site_url();
				$website_name = get_option('blogname');
				
				$formated_mail_subject = lp_sprintf2("$mail_subject", array(
					'website_url' => "$website_url",
					'website_name' => "$website_name"
				));


				$mail_content = $listingpro_options['listingpro_content_purchase_activated_admin'];
				
				$formated_mail_content = lp_sprintf2("$mail_content", array(
					'website_url' => "$website_url",
					'listing_title' => "$listing_title",
					'plan_title' => "$plan_title",
					'plan_price' => "$plan_price",
					'listing_url' => "$listing_url",
					'invoice_no' => "$invoice_no",
					'website_name' => "$website_name",
					'payment_method' => "$payment_method"
				));
				
				$headers1[] = 'Content-Type: text/html; charset=UTF-8';
				wp_mail( $admin_email, $formated_mail_subject, $formated_mail_content, $headers1);
				
				$mail_subject2 = $listingpro_options['listingpro_subject_purchase_activated'];
				$website_url = site_url();
				
				$formated_mail_subject2 = lp_sprintf2("$mail_subject2", array(
					'website_url' => "$website_url",
					'website_name' => "$website_name"
				));

				$mail_content2 = $listingpro_options['listingpro_content_purchase_activated'];
				
				$formated_mail_content2 = lp_sprintf2("$mail_content2", array(
					'website_url' => "$website_url",
					'listing_title' => "$listing_title",
					'plan_title' => "$plan_title",
					'plan_price' => "$plan_price",
					'listing_url' => "$listing_url",
					'invoice_no' => "$invoice_no",
					'website_name' => "$website_name",
					'payment_method' => "$payment_method"
				));

				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				wp_mail( $useremail, $formated_mail_subject2, $formated_mail_content2, $headers);
				
				
				$response = '';
				$response = json_encode(array('status'=>'success', 'token'=>$token, 'email'=>$email, 'listing'=>$listing, 'redirect'=>$paypal_success));
				
				die($response);
			}
			else{
				$response = '';
				$msG = '';
				$msG = esc_html__('Sorry! Error in transaction', 'listingpro');
				$response = json_encode(array('status'=>'fail', 'token'=>$token, 'email'=>$email, 'listing'=>$listing, 'redirect'=>$msG));
				
				die($response);
			}
		
		}
	}
	
	/*======================================= campaign data saved =======================*/
	
	add_action('wp_ajax_listingpro_save_package_stripe', 'listingpro_save_package_stripe');
	add_action('wp_ajax_nopriv_listingpro_save_package_stripe', 'listingpro_save_package_stripe');
	
	if(!function_exists('listingpro_save_package_stripe')){
		function listingpro_save_package_stripe(){
			require_once THEME_PATH . '/include/stripe/stripe-php/init.php';
			global $wpdb, $listingpro_options;
			$secritKey = '';
			$secritKey = $listingpro_options['stripe_secrit_key'];
			$dbprefix = '';
			$dbprefix = $wpdb->prefix;
			$paypal_success = $listingpro_options['payment_success'];
			$paypal_success = get_permalink($paypal_success);
			$currency = '';
			$currency = $listingpro_options['currency_paid_submission'];
			$response = '';
			$token = '';
			$status = 'success';
			$email = '';
			$listing_id = $_POST['listing'];
			$token = $_POST['token'];
			$email = $_POST['email'];
			$taxPrice = 0;
			
			
			$price_packages = $_POST['packages'];
			$lpTOtalprice = $_POST['lpTOtalprice'];
			$pkgPrice = 0;
			
			if(!empty($price_packages)){
				foreach($price_packages as $package){
					$pkgPrice = $pkgPrice + $listingpro_options["$package"];
				}
			}
			
			if(isset($_POST['taxprice'])){
				if(!empty($_POST['taxprice'])){
					$taxPrice = $_POST['taxprice'];
				}
			}
			$pkgPrice = $pkgPrice+$taxPrice;
			
			$pkgPrice = (float)$pkgPrice*100;
			
			 \Stripe\Stripe::setApiKey("$secritKey");
			$charge = \Stripe\Charge::create(array(
			  "amount" => $pkgPrice,
			  "currency" => "$currency",
			  "description" => "Ads payment received",
			  "source" => $token,
			));
			
			if($charge['amount_refunded'] == 0 && $charge['failure_code'] == null && $charge['captured'] == true){
			
			
				if(session_id() == '') {
					session_start();
				}
					$ads_durations = $listingpro_options['listings_ads_durations'];
					
				  
					$currentdate = date("d-m-Y");
					$exprityDate = date('Y-m-d', strtotime($currentdate. ' + '.$ads_durations.' days'));
					$exprityDate = date('d-m-Y', strtotime( $exprityDate ));
					
					
					$my_post = array(
						'post_title'    => $listing_id,
						'post_status'   => 'publish',
						'post_type' => 'lp-ads',
					);
					$adID = wp_insert_post( $my_post );
					
					listing_set_metabox('ads_listing', $listing_id, $adID);
					
					listing_set_metabox('ad_status', 'Active', $adID);
					listing_set_metabox('ad_date', $currentdate, $adID);
					listing_set_metabox('ad_expiryDate', $exprityDate, $adID);
					
					listing_set_metabox('campaign_id', $adID, $listing_id);
					update_post_meta( $listing_id, 'campaign_status', 'active' );
					
					$priceKeyArray;
					if( !empty($price_packages) ){
						foreach( $price_packages as $val ){
							$priceKeyArray[] = $val;
							update_post_meta( $listing_id, $val, 'active' );
						}
					}
					
					if( !empty($priceKeyArray) ){
						
						listing_set_metabox('ad_type', $priceKeyArray, $adID);
					}
					
					$tID = $token;
					$token = $token;
					$payment_method = 'stripe';
					
					lp_save_campaign_data($adID, $tID, $payment_method, $token, $status, $price_packages, $lpTOtalprice, $listing_id);
					$response = json_encode(array('status'=>'success', 'token'=>$token, 'email'=>$email, 'listing'=>$listing_id, 'redirect'=>$paypal_success, 'pgks'=>$price_packages));
				
					die($response);
			}
			else{	
					$msG = '';
					$msG = esc_html__('Sorry!, error in transaction', 'listingpro');
					$response = json_encode(array('status'=>'fail', 'token'=>$token, 'email'=>$email, 'listing'=>$listing_id, 'redirect'=>$paypal_success, 'pgks'=>$price_packages, 'msg' => $msG));
				
					die($response);
			}
		}
	}
	
?>