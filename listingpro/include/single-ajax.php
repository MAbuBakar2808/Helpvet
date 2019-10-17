<?php
/**
 * Claim List
 *
 */

/* ============== ListingPro single ajax Init ============ */
	
	if(!function_exists('Listingpro_single_ajax_init')){
		function Listingpro_single_ajax_init(){
			
			
			wp_register_script('ajax-single-ajax', get_template_directory_uri() . '/assets/js/single-ajax.js', array('jquery') ); 
			 
			wp_enqueue_script('ajax-single-ajax');
			

			wp_localize_script( 'ajax-single-ajax', 'single_ajax_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			));
			
		}
		if(!is_admin()){
			if(!is_singular('listing')){
				add_action('init', 'Listingpro_single_ajax_init');
			}
		}
	}
	
	
	
	
	/* ============== ListingPro Claim Ajax Process ============ */
	
	add_action('wp_ajax_listingpro_claim_list', 'listingpro_claim_list');
	add_action('wp_ajax_nopriv_listingpro_claim_list', 'listingpro_claim_list');
	if(!function_exists('listingpro_claim_list')){
		function listingpro_claim_list(){
			
			global $listingpro_options;
			$post_title = '';
			$post_url = '';
			$email1 = '';
			$message = '';
			$author_nicename = '';
			$author_url = '';
			$emailexist = false;
			
			$current_user = wp_get_current_user();
			$userID = $current_user->ID;
			$userData = get_user_by( 'id', $userID );
			$email1 = $userData->user_email;
		
			if( isset( $_POST[ 'formData' ] ) ) {
				parse_str( $_POST[ 'formData' ], $formData );
				
				$posttitle = '';
				$name1 = sanitize_text_field($formData['fullname']);
				$post_title = sanitize_text_field($formData['post_title']);
				$post_URL = sanitize_text_field($formData['post_url']);
				$posttitle = esc_html__('Claim for', 'listingpro').' ';
				$posttitle .= $post_title;
				
				$author_email = sanitize_text_field($formData['author_email']);
				$message = sanitize_text_field($formData['message']);
				$claimerphone = sanitize_text_field($formData['phone']);
				
				$post_id = sanitize_text_field($formData['post_id']);
				$post_author = get_post_field( 'post_author', $post_id );
				$user = get_user_by( 'id', $post_author );
				$usersname = $user->user_login;
				$authorEmail = $user->user_email;
				
				$claimerdetails = '';
				$claimerdetails .= $name1.' : ';
				$claimerdetails .= $email1.' : ';
				$claimerdetails .= $message;
				
				$status = 'pending';
				
				$claim_post = array(
				  'post_title'    => wp_strip_all_tags( $posttitle ),
				  'post_type'   => 'lp-claims',
				  'post_status'   => 'publish',
				);
				 
				$id = wp_insert_post( $claim_post );
				$current_user = get_post_field( 'post_author', $id );
				$current_usermeta = wp_get_current_user();
				$claimer_email = $current_usermeta->user_email;
				
				listing_set_metabox('details', $claimerdetails, $id);
				listing_set_metabox('claimer', $current_user, $id);
				listing_set_metabox('owner', $usersname, $id);
				listing_set_metabox('claim_status', $status, $id);
				listing_set_metabox('claimed_listing', $post_id, $id);
				listing_set_metabox('claimer_phone', $claimerphone, $id);
				
				$admin_email = '';
				$admin_email = get_option( 'admin_email' );
				$website_url = site_url();
				$website_name = get_option('blogname');
				$listing_title = $post_title;
				$listing_url = $post_URL;
				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				/* ====for claimer=== */
				$c_mail_subject = $listingpro_options['listingpro_subject_listing_claimer'];
				$c_mail_body = $listingpro_options['listingpro_content_listing_claimer'];
				
				$c_mail_subject_a = lp_sprintf2("$c_mail_subject", array(
					'website_url' => "$website_url",
					'listing_title' => "$listing_title",
					'listing_url' => "$listing_url",
					'website_name' => "$website_name"
				));
				
				$c_mail_body_a = lp_sprintf2("$c_mail_body", array(
					'website_url' => "$website_url",
					'listing_title' => "$listing_title",
					'listing_url' => "$listing_url",
					'website_name' => "$website_name"
				));
				
				wp_mail( $claimer_email, $c_mail_subject_a, $c_mail_body_a, $headers);
				
				/* ====for Admin=== */
				$a_mail_subject = $listingpro_options['listingpro_subject_listing_claim_admin'];
				$a_mail_body = $listingpro_options['listingpro_content_listing_claim_admin'];
				
				$a_mail_subject_a = lp_sprintf2("$a_mail_subject", array(
					'website_url' => "$website_url",
					'listing_title' => "$listing_title",
					'listing_url' => "$listing_url",
					'website_name' => "$website_name"
				));
				
				$a_mail_body_a = lp_sprintf2("$a_mail_body", array(
					'website_url' => "$website_url",
					'listing_title' => "$listing_title",
					'listing_url' => "$listing_url",
					'website_name' => "$website_name"
				));
				
				wp_mail( $admin_email, $a_mail_subject_a, $a_mail_body_a, $headers);
				/* ====for Author=== */
				$athr_mail_subject = $listingpro_options['listingpro_subject_listing_author'];
				$athr_mail_body = $listingpro_options['listingpro_content_listing_author'];
				
				$athr_mail_subject_a = lp_sprintf2("$athr_mail_subject", array(
					'website_url' => "$website_url",
					'listing_title' => "$listing_title",
					'listing_url' => "$listing_url",
					'website_name' => "$website_name"
				));
				
				$athr_mail_body_a = lp_sprintf2("$athr_mail_body", array(
					'website_url' => "$website_url",
					'listing_title' => "$listing_title",
					'listing_url' => "$listing_url",
					'website_name' => "$website_name"
				));
				
				wp_mail( $authorEmail, $athr_mail_subject_a, $athr_mail_body_a, $headers);
				/* ====end for Author mail=== */
				
				$result = $id;
				
				echo json_encode(array('state'=>'<span class="alert alert-success">'.esc_html__('Claim has been submitted.','listingpro').'</span>','result'=>$result));
				exit();
			}
			

		}
	}

	/* ============== ListingPro Contact author Process ============ */
	
	
	add_action('wp_ajax_listingpro_contactowner', 'listingpro_contactowner');
	add_action('wp_ajax_nopriv_listingpro_contactowner', 'listingpro_contactowner');
	if(!function_exists('listingpro_contactowner')){
		function listingpro_contactowner(){
			global $listingpro_options;
			$post_id = '';
			$post_title = '';
			$post_url = '';
			$name = '';
			$email = '';
			$phone = '';
			$message = '';
			$authoremail = '';
			$authorID = '';
			$result = '';
			$error = array();
		
			if( isset( $_POST[ 'formData' ] ) ) {
				parse_str( $_POST[ 'formData' ], $formData );
				
				
				$post_id = sanitize_text_field($formData['post_id']);
				$post_title = get_the_title($post_id);
				$post_url = get_the_permalink($post_id);
				$name1 = sanitize_text_field($formData['name7']);
				$email = sanitize_text_field($formData['email7']);
				$phone = sanitize_text_field($formData['phone']);
				$message = sanitize_text_field($formData['message7']);
				$authorID = sanitize_text_field($formData['author_id']);
				$enableCaptcha = false;
				$processLead = true;
				$gCaptcha;
				
				if(isset($formData['g-recaptcha-response'])){
					if(!empty($formData['g-recaptcha-response'])){
						$enableCaptcha = true;
					}
					else{
						$processLead = false;
					}
				}
				else{
					$enableCaptcha = false;
					$processLead = true;
				}
				
				
				$keyResponse = '';
				
				if($enableCaptcha == true){
					if ( class_exists( 'cridio_Recaptcha' ) ){ 
										$keyResponse = cridio_Recaptcha_Logic::is_recaptcha_valid($formData['g-recaptcha-response']);
										if($keyResponse == false){
											$processLead = false;
										}
										else{
											$processLead = true;
										}
					}
				}
				
				if($processLead == true){
					$authoremail = sanitize_text_field($formData['author_email']);
					$toauthor = $authoremail;
					$subject =  $listingpro_options['listingpro_subject_lead_form'];
					$body =  $listingpro_options['listingpro_content_lead_form'];
					
					$formated_mail_content = lp_sprintf2("$body", array(
						'listing_title' => "$post_title",
						'sender_name' => "$name1",
						'sender_email' => "$email",
						'sender_phone' => "$phone",
						'sender_message' => "$message"
					));
					
					
					$headers = "From: " . strip_tags($email) . "\r\n";
					$headers .= "Reply-To: ". strip_tags($email) . "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					$headers .= "Content-Type: text/html; charset=UTF-8";
					
					if(empty($email) || empty($message) || empty($name1)){
						$result = 'fail';
						if(empty($email)){
							$error['email'] = $email;
						}
						if(empty($message)){
							$error['message'] = $message;
						}
						if(empty($name1)){
							$error['name7'] = $name1;
						}
						echo json_encode(array('state'=>'<span class="alert alert-danger">'.esc_html__('Something is missing! Please fill out all fields highlighted in red.','listingpro').'</span>','result'=>$result, 'errors'=>$error));
					}
					else{
						$result = wp_mail( $toauthor, $subject, $formated_mail_content,$headers); 
						if($result==true){
							$leadsCount = '';
							$leadsCount = get_user_meta( $authorID, 'leads_count', true );
							if( isset($leadsCount) ){
								$leadsCount = (int)$leadsCount + 1;
								update_user_meta($authorID, 'leads_count', $leadsCount);
							}
							else{
								$leadsCount = 0;
								update_user_meta($authorID, 'leads_count', $leadsCount);
							}
							
							/* saving activity in wp_options */
							
							$listing_id = $post_id;
							$listingData = get_post($listing_id);
							$authID = $listingData->post_author;
							//$currentdate = date("d-m-Y h:i:a");
							$currentdate =  current_time('mysql');
							$activityData = array();
							$activityData = array( array(
								'type'	=>	'lead',
								'actor'	=>	$name1,
								'reviewer'	=>	'',
								'listing'	=>	$listing_id,
								'rating'	=>	'',
								'time'	=>	$currentdate
							));
							
							$updatedActivitiesData = array();
							
							$lp_recent_activities = get_option( 'lp_recent_activities' );
							if( $lp_recent_activities!=false ){
								
								$existingActivitiesData = get_option( 'lp_recent_activities' );
								if (array_key_exists($authID, $existingActivitiesData)) {
									$currenctActivityData = $existingActivitiesData[$authID];
									if(count($currenctActivityData)>=20){
										$currenctActivityData = array_slice($currenctActivityData,1,20);
										$updatedActivityData = array_merge($currenctActivityData,$activityData);
									}
									else{
										$updatedActivityData = array_merge($currenctActivityData,$activityData);
									}
									$existingActivitiesData[$authID] = $updatedActivityData;
								}
								else{
									$existingActivitiesData[$authID] = $activityData;
								}
								$updatedActivitiesData = $existingActivitiesData;
							}
							else{
								$updatedActivitiesData[$authID] = $activityData;
							}
							update_option( 'lp_recent_activities', $updatedActivitiesData );
							
							
							
							
							
							
							echo json_encode(array('state'=>'<span class="alert alert-success">'.esc_html__('Email has been sent.','listingpro').'</span>','result'=>$result, 'errors'=>$error));
							
						}
						else{
							echo json_encode(array('state'=>'<span class="alert alert-danger">'.esc_html__('Something went wrong.','listingpro').'</span>','result'=>$result, 'errors'=>$error));
							
							

						}
						
						
					}
				}
				else{
					$result = 'fail';
					$error['email'] = $email;
					$error['message'] = $message;
					$error['name7'] = $name1;
					echo json_encode(array('state'=>'<span class="alert alert-danger">'.esc_html__('Please check captcha','listingpro').'</span>','result'=>$result, 'errors'=>$error));
				}
			}
			exit();
		}
	}
	
	/* =========================================change price plan============== */
	add_action('wp_ajax_listingpro_change_plan', 'listingpro_change_plan');
	add_action('wp_ajax_nopriv_listingpro_change_plan', 'listingpro_change_plan');
	if(!function_exists('listingpro_change_plan')){
		function listingpro_change_plan(){
			
			global $listingpro_options;
			$plan_id = $_POST['ch_plan_id'];
			$listing_id = $_POST['ch_listing_id'];
			$listing_status = get_post_status( $listing_id );
			$checkout = $listingpro_options['payment-checkout'];
			$checkout_url = get_permalink( $checkout );
			$status = '';
			$ex_plan_price = '';
			$new_plan_price = '';
			$action = '';
			$subsc_status = '';
			$alertmsg = '';
			$ex_plan = listing_get_metabox_by_ID('Plan_id', $listing_id);
			if(!empty($ex_plan)){
				$ex_plan_price = get_post_meta($ex_plan, 'plan_price', true);
			}
			if(!empty($plan_id)){
				$new_plan_price = get_post_meta($plan_id, 'plan_price', true);
			}
			
			listing_set_metabox('changed_planid', $plan_id, $listing_id);
			
			if($listing_status=="publish"){
				if($new_plan_price <= $ex_plan_price){
					
				$action = '		
								<form method="post"  action="'.$checkout_url.'">
								<input type="hidden" name="planid" value="'.$plan_id.'">
								<input type="hidden" name="listingid" value="'.$listing_id.'">
								<a href="" class="lp_change_plan_action" data-planid="'.$plan_id.'" data-listingid="'.$listing_id.'">'.esc_html__('Proceed', 'listingpro').'</a>
								<form>
								'
							;
				}
				else{
					$action = '
							<form method="post"  action="'.$checkout_url.'">
							<input type="hidden" name="planid" value="'.$plan_id.'">
							<input type="hidden" name="listingid" value="'.$listing_id.'">
							<input type="submit" value="'.esc_html__('Pay & Proceed', 'listingpro').'"/>
							</form>
							';
				}
				/* check if subscribed already */
				$alreadySubscribed = false;
				$uid = get_current_user_id();
				$userSubscriptions = get_user_meta($uid, 'listingpro_user_sbscr', true);
				if(!empty($userSubscriptions)){
					foreach($userSubscriptions as $key=>$subscription){
						$subscr_plan_id = $subscription['plan_id'];
						$subscr_listing_id = $subscription['listing_id'];
						if( ($subscr_plan_id == $ex_plan) &&($subscr_listing_id == $listing_id) ){
							$alreadySubscribed = true;
							break;
						}
					}
				}
				
				if($alreadySubscribed==true){
					$subsc_status = 'yes';
					$alertmsg = esc_html__('Alert! your existing plan attached with this listing has an active subscription, changing plan will cancel your subscription, make sure to change before proceed', 'listingpro');
				}
				/* end check if subscribed already */
				
			}
			else{
				
				$payment_status = lp_get_payment_status_by_ID($listing_id);
				if( ($payment_status=="success") && ($new_plan_price >= $ex_plan_price) ){
					$action = '
								<form method="post" action="'.$checkout_url.'">
								<input type="hidden" name="planid" value="'.$plan_id.'">
								<input type="hidden" name="listingid" value="'.$listing_id.'">
								<input type="submit" value="'.esc_html__('Pay & Proceed', 'listingpro').'"/>
								</form>
								'
							;
				}
				
				elseif(!empty($new_plan_price)){
					$action = '
							<form method="post"  action="'.$checkout_url.'">
							<input type="hidden" name="planid" value="'.$plan_id.'">
							<input type="hidden" name="listingid" value="'.$listing_id.'">
							<input type="submit" value="'.esc_html__('Pay & Proceed', 'listingpro').'"/>
							</form>
							
						';
				}
				else{
					$action = '
								<form method="post" action="'.$checkout_url.'">
								<input type="hidden" name="planid" value="'.$plan_id.'">
								<input type="hidden" name="listingid" value="'.$listing_id.'">
								<a href="" class="lp_change_plan_action" data-planid="'.$plan_id.'" data-listingid="'.$listing_id.'">'.esc_html__('Proceed', 'listingpro').'</a>
								</form>
								'
							;
				}
				
			}
			
			$data = array('planid'=>$plan_id, 'listing'=>$listing_id, 'status'=>$status, 'error'=>'', 'subscribed'=>$subsc_status, 'action'=>$action, 'actionurl'=>$checkout_url, 'listing_status'=>$listing_status, 'alertmsg'=>$alertmsg);
			die(json_encode($data));
			
		}
	}
	
	/* =========================================change plan proceeding============== */
	add_action('wp_ajax_listingpro_change_plan_proceeding', 'listingpro_change_plan_proceeding');
	add_action('wp_ajax_nopriv_listingpro_change_plan_proceeding', 'listingpro_change_plan_proceeding');
	if(!function_exists('listingpro_change_plan_proceeding')){
		function listingpro_change_plan_proceeding(){
			global $listingpro_options;
			$res = array();
			$plan_id = $_POST['plan_iddd'];
			$listing_id = $_POST['listing_iddd'];
			if(!empty($plan_id) && !empty($listing_id)){
				/* if expired.. publish it */
				$listing_status = get_post_status( $listing_id );
				if($listing_status=="expired"){
					$my_listing_post = array();
					$my_listing_post['ID'] = $listing_id;
					$my_listing_post['post_date'] = date("Y-m-d H:i:s");
					$my_listing_post['post_status'] = 'publish';
					wp_update_post( $my_listing_post );
				}
				/* end if expired.. publish it */
				/* check if subscribed already */
				$ex_plan = listing_get_metabox_by_ID('Plan_id', $listing_id);
				if(!empty($ex_plan)){
					lp_cancel_stripe_subscription($listing_id, $ex_plan);
					listing_set_metabox('Plan_id',$plan_id, $listing_id);
					listing_set_metabox('changed_planid','', $listing_id);
				}
				/* end check if subscribed already */
				listing_set_metabox('Plan_id', $plan_id, $listing_id);
				$msg = '<span class="alert alert-success">'.esc_html__('Plan has been changed', 'listingpro').'</span>';
				$res = array('status'=>'success', 'message'=>$msg);
			}
			
			die(json_encode($res));
		}
	}
	/* =========================================cancel subscription proceeding============== */
	add_action('wp_ajax_listingpro_cancel_subscription_proceeding', 'listingpro_cancel_subscription_proceeding');
	add_action('wp_ajax_nopriv_listingpro_cancel_subscription_proceeding', 'listingpro_cancel_subscription_proceeding');
	if(!function_exists('listingpro_cancel_subscription_proceeding')){
		function listingpro_cancel_subscription_proceeding(){
			$response = array();
			global $listingpro_options;
			require_once THEME_PATH . '/include/stripe/stripe-php/init.php';
			$secritKey = '';
			$secritKey = $listingpro_options['stripe_secrit_key'];
			\Stripe\Stripe::setApiKey("$secritKey");
			if(isset($_POST['subscript_id'])){
				$subscrip_id = $_POST['subscript_id'];
				$subscription = \Stripe\Subscription::retrieve($subscrip_id);
				$subscription->cancel();
				
				$uid = get_current_user_id();
				$userSubscriptions = get_user_meta($uid, 'listingpro_user_sbscr', true);
				if(!empty($userSubscriptions)){
					foreach($userSubscriptions as $key=>$subscription){
						$subscr_id = $subscription['subscr_id'];
						$subscr_listing_id = $subscription['listing_id'];
						
						$my_listing_post = array();
						$my_listing_post['ID'] = $subscr_listing_id;
						$my_listing_post['post_status'] = 'expired';
						wp_update_post( $my_listing_post );
						
						if($subscr_id == $subscrip_id){
							unset($userSubscriptions[$key]);
							$headers[] = 'Content-Type: text/html; charset=UTF-8';
							/* user email */
							$author_obj = get_user_by('id', $uid);
							$user_email = $author_obj->user_email;
							$usubject = $listingpro_options['listingpro_subject_cancel_subscription'];
							$ucontent = $listingpro_options['listingpro_content_cancel_subscription'];
							wp_mail( $user_email, $usubject, $ucontent, $headers );
							/* admin email */
							$adminemail = get_option('admin_email');
							$asubject = $listingpro_options['listingpro_subject_cancel_subscription_admin'];
							$acontent = $listingpro_options['listingpro_content_cancel_subscription_admin'];
							wp_mail( $adminemail, $asubject, $acontent, $headers );
						}
					}
				}
				/* removing user meta */
				if(!empty($userSubscriptions)){
					update_user_meta($uid, 'listingpro_user_sbscr', $userSubscriptions);
				}
				else{
					delete_user_meta($uid, 'listingpro_user_sbscr');
				}
				/* end removing user meta */
				$response = array('status'=>'success', 'msg'=> esc_html__('you have unsubscribed successfully', 'listingpro'));
			}
			else{
				$response = array('status'=>'fail', 'msg'=> esc_html__('something went wrong', 'listingpro'));
			}
			die(json_encode($response));
		}
	}
	
	/* ===========================Report Listing OR Review============== */
	add_action('wp_ajax_listingpro_report_this_post', 'listingpro_report_this_post');
	add_action('wp_ajax_nopriv_listingpro_report_this_post', 'listingpro_report_this_post');
	if(!function_exists('listingpro_report_this_post')){
		function listingpro_report_this_post(){
			$response = array();
			$resp='';
			global $listingpro_options;
			$postType = $_POST['posttype'];
			$postid = $_POST['postid'];
			$reporterID = $_POST['reportedby'];
			if(isset($postType) && isset($postid)){
				if($postType=="listing"){
					/* for listing post type */
					$Reportedby = array();
					$postReportedby = listing_get_metabox_by_ID('listing_reported_by', $postid);
					if(!empty($postReportedby)){
						if( strpos($postReportedby, ',') !== false ){
							/* found */
							$Reportedby = explode(",",$postReportedby);
						}else{
							$Reportedby[] = $postReportedby;
							
						}
						
						$resSearch = in_array($reporterID,$Reportedby);
						if(!empty($resSearch)){
							$resp = '<span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>'.esc_html__('Already reported by you !', 'listingpro');
							$response = array('status'=>'fail', 'msg'=>$resp);
							die(json_encode($response));
						}
						else{
							/* update metaboxes */
							$postReportedcount = listing_get_metabox_by_ID('listing_reported', $postid);
							if(!empty($postReportedcount)){
								$postReportedcount = $postReportedcount + 1;
							}
							else{
								$postReportedcount = 1;
							}
							listing_set_metabox('listing_reported', $postReportedcount, $postid);
							$Reportedby[] = $reporterID;
							$newpostReportedby = implode(",",$Reportedby);
							listing_set_metabox('listing_reported_by', $newpostReportedby, $postid);
							
							$resp = '<span><i class="fa fa-check" aria-hidden="true"></i></span>'.esc_html__('Reported Successfully', 'listingpro');
							$response = array('status'=>'success', 'msg'=>$resp);
							
							/* store data in options  */
							if ( get_option( 'lp_reported_listings' ) !== false ) {
								$reportedLisingsArray = array();
								$reportedLisings = get_option( 'lp_reported_listings' );
								if( strpos($reportedLisings, ',') !== false ){
									$reportedLisingsArray = explode(",",$reportedLisings);
								}else{
									$reportedLisingsArray[] = $reportedLisings;
									
								}
								$reportedLisingsArray[] = $postid;
								$reportedLisings = implode(",",$reportedLisingsArray);
								update_option( 'lp_reported_listings', $reportedLisings );
								
							}
							else{
								$deprecated = null;
								$autoload = 'no';
								$reportedLisings = $postid;
								add_option( 'lp_reported_listings', $reportedLisings, $deprecated, $autoload );
							}
							
							/* end store data in options  */
							
							die(json_encode($response));
						}
					}
					$Reportedby[] = $reporterID;
					$postReportedby = implode(",",$Reportedby);
					listing_set_metabox('listing_reported_by', $postReportedby, $postid);
					listing_set_metabox('listing_reported', '1', $postid);
					
					$resp = esc_html__('Reported Successfully', 'listingpro');
					$response = array('status'=>'success', 'msg'=>$resp);
					
					/* store data in options  */
					if ( get_option( 'lp_reported_listings' ) !== false ) {
						$reportedLisingsArray = array();
						$reportedLisings = get_option( 'lp_reported_listings' );
						if( strpos($reportedLisings, ',') !== false ){
							$reportedLisingsArray = explode(",",$reportedLisings);
						}else{
							$reportedLisingsArray[] = $reportedLisings;
							
						}
						$reportedLisingsArray[] = $postid;
						$reportedLisings = implode(",",$reportedLisingsArray);
						update_option( 'lp_reported_listings', $reportedLisings );
						
					}
					else{
						$deprecated = null;
						$autoload = 'no';
						$reportedLisings = $postid;
						add_option( 'lp_reported_listings', $reportedLisings, $deprecated, $autoload );
					}
					
					/* end store data in options  */
					
					die(json_encode($response));
					
				}
				
				if($postType=="reviews"){
					/* for listing reviews */
					
					$Reportedby;
					$postReportedby = listing_get_metabox_by_ID('review_reported_by', $postid);
					if(!empty($postReportedby)){
						if( strpos($postReportedby, ',') !== false ){
							/* found */
							$Reportedby = explode(",",$postReportedby);
						}else{
							$Reportedby[] = $postReportedby;
						}
						
						$resSearch = in_array($reporterID,$Reportedby);
						if(!empty($resSearch)){
							$resp = esc_html__('Already reported by you', 'listingpro');
							$response = array('status'=>'fail', 'msg'=>$resp);
							die(json_encode($response));
						}
						else{
							/* update metaboxes */
							$postReportedcount = listing_get_metabox_by_ID('review_reported', $postid);
							if(!empty($postReportedcount)){
								$postReportedcount = $postReportedcount + 1;
							}
							else{
								$postReportedcount = 1;
							}
							listing_set_metabox('review_reported', $postReportedcount, $postid);
							
							$Reportedby[] = $reporterID;
							$newpostReportedby = implode(",",$Reportedby);
							listing_set_metabox('review_reported_by', $newpostReportedby, $postid);
							
							$resp = esc_html__('Reported Successfully', 'listingpro');
							$response = array('status'=>'success', 'msg'=>$resp);
							
							/* store data in options  */
							if ( get_option( 'lp_reported_reviews' ) !== false ) {
								$reportedLisingsArray = array();
								$reportedLisings = get_option( 'lp_reported_reviews' );
								if( strpos($reportedLisings, ',') !== false ){
									$reportedLisingsArray = explode(",",$reportedLisings);
								}else{
									$reportedLisingsArray[] = $reportedLisings;
									
								}
								$reportedLisingsArray[] = $postid;
								$reportedLisings = implode(",",$reportedLisingsArray);
								update_option( 'lp_reported_reviews', $reportedLisings );
								
							}
							else{
								$deprecated = null;
								$autoload = 'no';
								$reportedLisings = $postid;
								add_option( 'lp_reported_reviews', $reportedLisings, $deprecated, $autoload );
							}
							
							/* end store data in options  */
							die(json_encode($response));
						}
					}
					$Reportedby[] = $reporterID;
					$postReportedby = implode(",",$Reportedby);
					listing_set_metabox('review_reported_by', $postReportedby, $postid);
					listing_set_metabox('review_reported', '1', $postid);
					
					$resp = esc_html__('Reported Successfully', 'listingpro');
					$response = array('status'=>'success', 'msg'=>$resp);
					
					/* store data in options  */
					if ( get_option( 'lp_reported_reviews' ) !== false ) {
						$reportedLisingsArray = array();
						$reportedLisings = get_option( 'lp_reported_reviews' );
						if( strpos($reportedLisings, ',') !== false ){
							$reportedLisingsArray = explode(",",$reportedLisings);
						}else{
							$reportedLisingsArray[] = $reportedLisings;
							
						}
						$reportedLisingsArray[] = $postid;
						$reportedLisings = implode(",",$reportedLisingsArray);
						update_option( 'lp_reported_reviews', $reportedLisings );
						
					}
					else{
						$deprecated = null;
						$autoload = 'no';
						$reportedLisings = $postid;
						add_option( 'lp_reported_reviews', $reportedLisings, $deprecated, $autoload );
					}
					
					/* end store data in options  */
					
					die(json_encode($response));
					
				}
				
			}
			else{
				$resp = esc_html__('Something Wrong', 'listingpro');
				$response = array('status'=>'fail', 'msg'=>$resp);
			}
			die(json_encode($response));
		}
	}
	
	/* ================= for preview popu================= */
	
	if(!function_exists('quick_preivew_cb')){
		function quick_preivew_cb() {
			if ( isset($_REQUEST) ) {
				global $listingpro_options;
				$deafaultFeatImg = lp_default_featured_image_listing();
				$LPpostID    =   $_REQUEST['LPpostID'];
				$data_return    =   array();

				$post_content = get_post($LPpostID);
				$post_content = $post_content->post_content;
				$post_content = wp_filter_nohtml_kses($post_content);
				$post_content   =   substr($post_content, 0, 230);

				if ( has_post_thumbnail( $LPpostID )) {
					require_once (THEME_PATH . "/include/aq_resizer.php");
					$img_url = wp_get_attachment_image_src(get_post_thumbnail_id( $LPpostID ), 'full');
					if(!empty($img_url[0])){
						$imgurl = aq_resize( $img_url[0], '650', '300', true, true, true);
						$imgSrc = $imgurl;
					}else{
						$imgSrc =   'https://placeholdit.imgix.net/~text?txtsize=33&w=650&h=300';
					}

				}elseif(!empty($deafaultFeatImg)){
									
					$imgSrc = $deafaultFeatImg;
					
				}
				else {
					$imgSrc =   'https://placeholdit.imgix.net/~text?txtsize=33&w=650&h=300';
				}
				$permalink  =   get_the_permalink( $LPpostID );
				$ptitle     =   substr($LPpostID, 0, 40);
				$phone = listing_get_metabox_by_ID('phone', $LPpostID);
				$gAddress = listing_get_metabox_by_ID('gAddress', $LPpostID);
				$adress_markup  =   '';
				if( !empty( $gAddress ) )
				{
					$adress_markup  =   '<span class="cat-icon">
				   <img class="icon icons8-Food" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAABv0lEQVRoge1ZUbGDMBA8CUhAAhKQUAlIqILsOkBCJSABCUhAAhJ4Hw1vGB4tB82R9A07c7+Z3dxmuQSRCxcuBAPJwjlHAC2ADsDgqwfQOOdIsojN8w9Ilp7wqKyOZBWbt5AsdhJfExKnI37Xhw/ITzWQLL+V/G+dJoJkHpr8rBP2dsIzYUKTn6o3JU/yZkh+xNNKlZkAfJY42hpMyPvI1JJoSZYkC5K571y7owt5cAH+C6shUJPM1tYAUGvWcM4xuAAAjXLnV8nP1tF0orUQ0Ctaf9taRxkE4c+BUkCuEJDFErD58QooYLQQsBmhSguVCgGdhQBNgmwePijDILgAbYy+i0CSd80aAOrgAnaOEd00XZLMvG00Oz8CRuOE9vCFKJMvsYgIgMcJAhoT8iIiJKsTdr+yFGBto8HMPhNga6OHKXkR0y6cc6UUMetC+Ox/BYMu2Ht/CSgvJ8nt/gTfhT4A+X7rEmQpQjNZvi3NBGsK7JhxkrDOEt5KR17q4llniSNWim6dJbAvleJbZw1QPpkkY50lFNGaju9fwT+/r5E//0fGUawd6uQO7Rbmd2iS99h8DsG/QqSZOBcu/BP8AL+XHO7G8elbAAAAAElFTkSuQmCC" alt="cat-icon">
				  </span>
				  <span class="text gaddress">'.$gAddress.'</span>';
				}

				$rating = get_post_meta( $LPpostID, 'listing_rate', true );
				$rate = $rating;

				$adStatus = get_post_meta( $LPpostID, 'campaign_status', true );
				$CHeckAd = '';
				if($adStatus == 'active'){
					$CHeckAd = '<span class="listing-pro">'.esc_html__('Ad','listingpro').'</span>';
				}
				$claimed_section = listing_get_metabox_by_ID('claimed_section', $LPpostID);

				$claim = '';
				if($claimed_section == 'claimed') {
					$claim = '<span class="verified simptip-position-top simptip-movable" data-tooltip="'. esc_html__('Claimed', 'listingpro').'"><i class="fa fa-check"></i> '. esc_html__('Claimed', 'listingpro').'</span>';

				}elseif($claimed_section == 'not_claimed') {
					$claim = '';
				}
				$pricey =   listingpro_price_dynesty_text( $LPpostID );
				$cats_markup    =   '';
				$cats = get_the_terms( $LPpostID, 'listing-category' );
				if(!empty($cats)){
					foreach ( $cats as $cat ) {
						$category_image = listing_get_tax_meta($cat->term_id,'category','image');
						if(!empty($category_image)){
							$cats_markup    .=   '<span class="cat-icon"><img class="icon icons8-Food" src="'.$category_image.'" alt="cat-icon"></span>';
						}
						$term_link = get_term_link( $cat );
						$cats_markup    .=  '<a href="'.$term_link.'">
					   '.$cat->name.'
					  </a>';
					}
				}
				$openStatus = listingpro_check_time( $LPpostID );

				$data_return['noreview'] = esc_html__('0 Reviews', 'listingpro');
				$data_return['ad'] = esc_html__('Ad', 'listingpro');
				$data_return['phone'] = $phone;
				$data_return['gAddress'] = $gAddress;
				$data_return['post_content'] = $post_content;
				$data_return['post_thumb'] = $imgSrc;
				$data_return['permalink'] = $permalink;
				$data_return['ptitle'] = $ptitle;
				$data_return['adStatus'] = $adStatus;
				$data_return['rate'] = $rate;
				$data_return['pricey'] = $pricey;
				$data_return['cats_markup'] = $cats_markup;
				$data_return['adress_markup'] = $adress_markup;
				$data_return['openStatus'] = $openStatus;
				
				die(json_encode( $data_return ));
			}
			$data_return    =   array();
			die(json_encode( $data_return ));
		}
	}

add_action( 'wp_ajax_quick_preivew_cb', 'quick_preivew_cb' );
add_action( 'wp_ajax_nopriv_quick_preivew_cb', 'quick_preivew_cb' );
	