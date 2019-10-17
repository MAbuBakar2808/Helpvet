<?php

/* ====================== for campaign wire===================== */

if(!function_exists('get_campaign_wire_invoice')){
	function get_campaign_wire_invoice($postid){
		
		global $listingpro_options;
		$output = null;
		$logo = '';
		$company = '';
		$address = '';
		$phone = '';
		$additional = '';
		$thanku_text = '';
		
		$taxIsOn = $listingpro_options['lp_tax_swtich'];
		$tax = '';
		
		$logo = $listingpro_options['invoice_logo']['url'];
		$company = $listingpro_options['invoice_company_name'];
		$address = $listingpro_options['invoice_address'];
		$phone = $listingpro_options['invoice_phone'];
		$additional = $listingpro_options['invoice_additional_info'];
		$thanku_text = $listingpro_options['invoice_thankyou'];
		$userrow = '';
		$userID = '';
		$userID = get_current_user_id();
		$table = 'listing_campaigns';
		$data = '*';
		$condition = "post_id = $postid";
		$userrow = lp_get_data_from_db($table, $data, $condition);
		
		$plan_name = '';
		$plan_price = '';
		$org_plan_price = '';
		$currency = listingpro_currency_sign();
		$invoice = '';
		$payment_method = '';
		if( is_array( $userrow ) && count( $userrow ) > 0 ){
			
				$plan_price = $userrow[0]->price;
				$org_plan_price = $plan_price;
				$plan_name = get_the_title($postid);
				//$currency = $userrow[0]->currency;
				$invoice = $userrow[0]->transaction_id;
				$payment_method = $userrow[0]->payment_method;
			
		}
		
		
		if(!empty($taxIsOn)){
			$tax = $listingpro_options['lp_tax_amount'];
			$tax = (float) $tax;
			if(!empty($tax)){
				$tax = (float)($tax/100)*$plan_price;
			}
		}
		
		$plan_price = $plan_price + $tax;
		$plan_price = (float)$plan_price;
		$plan_price = round($plan_price, 2);
		
		$user_info = get_userdata($userID);
		$fname = '';
		$lname = '';
		$usermail = '';
		$usermail = $user_info->user_email;
		$fname = $user_info->first_name;
		$lname = $user_info->last_name;
		
$output = '
		<div class="checkout-invoice-area">
			<div class="top-heading-area">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-12">
						<img src="'.esc_attr($logo).'" alt="Listingpro" style="width:122px" width="122" class="CToWUd">
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<p>'.esc_html__('Receipt','listingpro').'</p>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12"></div>
				</div>
			</div>
			<div class="invoice-area">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<h4>'.esc_html__('Billed to :','listingpro').'</h4>
						<ul>
							<li>'.$fname.' '.$lname.'</li>
							<li>'.$usermail.'</li>
						</ul>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p>
							<strong>'.esc_html__('Invoice :','listingpro').'</strong>
							#'.$invoice.'<br>
							<strong>'.esc_html__('Process With: Direct / Wire method','listingpro').'</strong>
						</p>
					</div>
				</div>
				<div class="row heading-area">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p><strong>'.esc_html__('Description','listingpro').'</strong></p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<p><strong>'.esc_html__('Plan','listingpro').'</strong></p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<p><strong>'.esc_html__('Price','listingpro').'</strong></p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12"></div>
				</div>
				<div class="row invoices-company-details">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<a href="#" target="_blank">'.$company.'</a> <br>
						<p>'.$address.' '.'<span class="aBn" data-term="goog_1120388248" tabindex="0"><span class="aQJ">'.current_time('mysql').'</span></span></b></p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<p>'.$plan_name.'</p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<p>'.$org_plan_price.'</p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
					</div>
				</div>
				<div class="row invoice-price-details">
					<div class="col-md-6 col-sm-6 col-xs-12">
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<ul class="clearfix">
							<li>'.esc_html__('Subtotal :','listingpro').'</li>
							<li>'.$plan_price.'</li>
						</ul>
						<ul class="clearfix">
							<li>'.esc_html__('Tax :','listingpro').'</li>
							<li>'.$tax.'</li>
						</ul>
						<ul class="clearfix">
							<li>'.esc_html__('Amount Paid :','listingpro').'</li>
							<li>0.00</li>
						</ul>
						<ul class="clearfix">
							<li>'.esc_html__('Balance due :','listingpro').'</li>
							<li>'.$plan_price. $currency.'</li>
							
						</ul>
					</div>
				</div>
				<div class="thankyou-text text-center">
					<p>'.$thanku_text.'</p>
				</div>
			</div>
			<div class="checkout-bottom-area">
				'.$additional.'
			</div>
		</div>';
		
		
	$website_name = get_option('blogname');
	$admin_email = get_option( 'admin_email' );
				
	$listing_title = get_the_title($postid);
	$listing_url = get_the_permalink($postid);
	
	
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	//to admin
			
			
			$mail_subject = $listingpro_options['listingpro_subject_wire_invoice_admin'];
			$website_url = site_url();
			$website_name = get_option('blogname');
			
			$formated_mail_subject = lp_sprintf2("$mail_subject", array(
				'website_url' => "$website_url",
				'website_name' => "$website_name"
			));


			$mail_content = $listingpro_options['listingpro_content_wire_invoice_admin'];
			
			$formated_mail_content = lp_sprintf2("$mail_content", array(
				'website_url' => "$website_url",
				'listing_title' => "$listing_title",
				'plan_title' => "$plan_title",
				'plan_price' => "$plan_name",
				'listing_url' => "$listing_url",
				'invoice_no' => "$invoice",
				'website_name' => "$website_name",
				'payment_method' => "$payment_method"
			));
			
			$emailresponse = wp_mail( $admin_email, $formated_mail_subject, $formated_mail_content, $headers);
	
	
	
	// to user
			$to = $usermail;
			$subject = '';
			$body = '';
			$subjec = $listingpro_options['listingpro_subject_wire_invoice'];
			$bod = $listingpro_options['listingpro_content_wire_invoice'];
	
			$website_url = site_url();
			
			$subject = lp_sprintf2("$subjec", array(
				'website_url' => "$website_url",
				'website_name' => "$website_name"
			));
			
			$body = lp_sprintf2("$bod", array(
				'website_url' => "$website_url",
				'listing_title' => "$listing_title",
				'plan_title' => "$plan_title",
				'plan_price' => "$plan_name",
				'listing_url' => "$listing_url",
				'invoice_no' => "$invoice",
				'website_name' => "$website_name",
				'payment_method' => "$payment_method"
			));

			$emailresponse = wp_mail( $to, $subject, $body, $headers);

	
		return $output;
		
		
	}
}

/* ====================== for listing wire ======================*/

if ( !function_exists('generate_wire_invoice') ){
	
	function generate_wire_invoice( $postid ){
		
		global $listingpro_options;
		$logo = '';
		$company = '';
		$address = '';
		$phone = '';
		$additional = '';
		$thanku_text = '';
		$post_id = '';
		
		
		$logo = $listingpro_options['invoice_logo']['url'];
		$company = $listingpro_options['invoice_company_name'];
		$address = $listingpro_options['invoice_address'];
		$phone = $listingpro_options['invoice_phone'];
		$additional = $listingpro_options['invoice_additional_info'];
		$thanku_text = $listingpro_options['invoice_thankyou'];
		$taxIsOn = $listingpro_options['lp_tax_swtich'];
		$tax = '';
		
		$payment_method = '';
		
		
		global $wpdb;
		$prefix = $wpdb->prefix;
		$userID = '';
		$userID = $wpdb->get_results( 
						$wpdb->prepare("SELECT user_id  FROM ".$prefix."listing_orders WHERE post_id=%d", $postid) 
					 );
		if(!empty($userID)){
			if( is_array( $userID ) ){
				$userID = $userID[0]->user_id;
			}
			else{
				$userID = $userID->user_id;
			}
		}
		
		$userrow = '';
		$userrow = $wpdb->get_results( 
						$wpdb->prepare("SELECT *  FROM ".$prefix."listing_orders WHERE post_id=%d", $postid) 
					 );
		
		$plan_name = '';
		$plan_price = '';
		$orig_plan_price = '';
		$currency = listingpro_currency_sign();
		$invoice = '';
		$cPlanID = listing_get_metabox_by_ID('changed_planid', $postid);
		if(!empty($userrow)){
			if( is_array( $userrow ) && count( $userrow ) > 0 ){
					if(!empty($cPlanID)){
						$plan_price = get_post_meta($cPlanID, 'plan_price', true);
						$orig_plan_price = $plan_price;
						$plan_name = get_the_title($cPlanID);
					}else{
						$plan_id = $userrow[0]->plan_id;
						$plan_price = get_post_meta($plan_id, 'plan_price', true);
						$orig_plan_price = $plan_price;
						$plan_name = $userrow[0]->plan_name;
					}
					$invoice = $userrow[0]->order_id;
					$payment_method = $userrow[0]->payment_method;
					$post_id = $userrow[0]->post_id;
					
			}
		}
		$plan_price = (float)$plan_price;
		if(!empty($taxIsOn)){
			$tax = $listingpro_options['lp_tax_amount'];
			$tax = (float) $tax;
			if(!empty($tax)){
				$tax = (float)($tax/100)*$plan_price;
				$tax = round($tax, 2);
			}
		}
		
		$plan_price = (float)$plan_price + (float)$tax;
		$plan_price = (float)$plan_price;
		$plan_price = round($plan_price, 2);
		$user_info = get_userdata($userID);
		$fname = '';
		$lname = '';
		$usermail = '';
		if(!empty($user_info)){
			$usermail = $user_info->user_email;
			$fname = $user_info->first_name;
			$lname = $user_info->last_name;
		}
		
		
		
		$output = null;
		
		$output = '
		
		<div class="checkout-invoice-area">
			<div class="top-heading-area">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-12">
						<img src="'.esc_attr($logo).'" alt="" style="width:122px" width="122" class="CToWUd">
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12">
						<p>'.esc_html__('Receipt','listingpro').'</p>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-12"></div>
				</div>
			</div>
			<div class="invoice-area">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<h4>'.esc_html__('Billed to :','listingpro').'</h4>
						<ul>
							<li>'.$fname.' '.$lname.'</li>
							<li>'.$usermail.'</li>
						</ul>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p>
							<strong>'.esc_html__('Invoice :','listingpro').'</strong>
							#'.$invoice.'<br>
							<strong>'.esc_html__('Process With: Direct / Wire method','listingpro').'</strong>
						</p>
					</div>
				</div>
				<div class="row heading-area">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<p><strong>'.esc_html__('Description','listingpro').'</strong></p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<p><strong>'.esc_html__('Plan','listingpro').'</strong></p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<p><strong>'.esc_html__('Price','listingpro').'</strong></p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12"></div>
				</div>
				<div class="row invoices-company-details">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<a href="#" target="_blank">'.$company.'</a> <br>
						<p>'.$address.' '.'<span class="aBn" data-term="goog_1120388248" tabindex="0"><span class="aQJ"> '.current_time('mysql').'</span></span></b></p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<p>'.$plan_name.'</p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<p>'.$orig_plan_price.'</p>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
					</div>
				</div>
				<div class="row invoice-price-details">
					<div class="col-md-6 col-sm-6 col-xs-12">
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<ul class="clearfix">
							<li>'.esc_html__('Subtotal :','listingpro').'</li>
							<li>'.$plan_price.'</li>
						</ul>
						<ul class="clearfix">
							<li>'.esc_html__('Tax :','listingpro').'</li>
							<li>'.$tax.'</li>
						</ul>
						<ul class="clearfix">
							<li>'.esc_html__('Amount Paid :','listingpro').'</li>
							<li>0.00</li>
						</ul>
						<ul class="clearfix">
							<li>'.esc_html__('Balance due :','listingpro').'</li>
							<li>'.$plan_price. $currency.'</li>
						</ul>
					</div>
				</div>
				<div class="thankyou-text text-center">
					<p>'.$thanku_text.'</p>
				</div>
			</div>
			<div class="checkout-bottom-area">
				'.$additional.'
			</div>
		</div>';
	
	$website_url = site_url();
	$website_name = get_option('blogname');
	$admin_email = get_option( 'admin_email' );
	$plan_title = $plan_name;
	$invoice_no = $invoice;
	
				
	$listing_title = get_the_title($post_id);
	$listing_url = get_the_permalink($post_id);
	
	
	$headers[] = 'Content-Type: text/html; charset=UTF-8';
	//to admin
			
			
			$mail_subject = $listingpro_options['listingpro_subject_wire_invoice_admin'];
			$website_url = site_url();
			$website_name = get_option('blogname');
			
			$formated_mail_subject = lp_sprintf2("$mail_subject", array(
				'website_url' => "$website_url",
				'website_name' => "$website_name"
			));

			$mail_content = $listingpro_options['listingpro_content_wire_invoice_admin'];
			
			$formated_mail_content = lp_sprintf2("$mail_content", array(
				'website_url' => "$website_url",
				'listing_title' => "$listing_title",
				'plan_title' => "$plan_title",
				'plan_price' => "$plan_name",
				'listing_url' => "$listing_url",
				'invoice_no' => "$invoice_no",
				'website_name' => "$website_name",
				'payment_method' => "$payment_method"
			));
			
			$emailresponse = wp_mail( $admin_email, $formated_mail_subject, $formated_mail_content, $headers);
	
	
	
	// to user
			$to = $usermail;
			$subject = '';
			$body = '';
			$subjec = $listingpro_options['listingpro_subject_wire_invoice'];
			$bod = $listingpro_options['listingpro_content_wire_invoice'];

			$website_url = site_url();
			
			$subject = lp_sprintf2("$subjec", array(
				'website_url' => "$website_url",
				'website_name' => "$website_name"
			));

			$body = lp_sprintf2("$bod", array(
				'website_url' => "$website_url",
				'listing_title' => "$listing_title",
				'plan_title' => "$plan_title",
				'plan_price' => "$plan_name",
				'listing_url' => "$listing_url",
				'invoice_no' => "$invoice_no",
				'website_name' => "$website_name",
				'payment_method' => "$payment_method"
			));

			$emailresponse = wp_mail( $to, $subject, $body, $headers);
	
	return $output;
	
	
	}
	
}


?>