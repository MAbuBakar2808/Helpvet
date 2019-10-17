<?php
if(session_id() == '') {
    session_start();
}
/* ================================save data via paypal====================================== */
if(!function_exists('lp_save_campaign_data')){
	function lp_save_campaign_data($adID, $transactionID, $method, $token, $status, $price_packages, $lpTOtalprice = '', $listing_id=''){
		global $wpdb,$listingpro_options;
		$dbprefix = $wpdb->prefix;
		$user_ID = '';
		$user_ID = get_current_user_id();
		$currency_code = '';
		$currency_code = $listingpro_options['currency_paid_submission'];
		$priceKeyArray = 0;
		$packagesDetails ='';
		$enableTax = false;
		$Taxrate='';
		if($listingpro_options['lp_tax_swtich']=="1"){
			$enableTax = true;
			$Taxrate = $listingpro_options['lp_tax_amount'];
		}
		
		//$price_packages = $_SESSION['price_package'];
				if(empty($lpTOtalprice)){
					if( !empty($price_packages) && is_array($price_packages) ){
						foreach( $price_packages as $val ){
							if($val=="lp_random_ads"){
								$packagesDetails .= esc_html__(' Random Ads ', 'listingpro');
							}
							if($val=="lp_detail_page_ads"){
								$packagesDetails .= esc_html__(' Detail Page Ads ', 'listingpro');
							}
							if($val=="lp_top_in_search_page_ads"){
								$packagesDetails .= esc_html__(' Top in Search Page Ads ', 'listingpro');
							}
							$taxPrice = 0;
							if($enableTax=="1" && !empty($Taxrate)){
								$taxPrice = ($Taxrate / 100)*$listingpro_options[$val];
								$priceKeyArray = $listingpro_options[$val]+$priceKeyArray+$taxPrice;
							}
							else{
								$priceKeyArray = $listingpro_options[$val]+$priceKeyArray;
							}
							
						}
					}
					else if(!empty($price_packages) && !is_array($price_packages)){
						
						$taxPrice = 0;
						if($enableTax=="1" && !empty($Taxrate)){
							$taxPrice = ($Taxrate / $priceKeyArray)*100;
							$priceKeyArray = $priceKeyArray+$taxPrice;
						}
						else{
							$priceKeyArray = $price_packages;
						}
					}
				}
				else{
					//$priceKeyArray = $lpTOtalprice;
					if( !empty($price_packages) && is_array($price_packages) ){
						foreach( $price_packages as $val ){
							if($val=="lp_random_ads"){
								$packagesDetails .= esc_html__(' Random Ads ', 'listingpro');
							}
							if($val=="lp_detail_page_ads"){
								$packagesDetails .= esc_html__(' Detail Page Ads ', 'listingpro');
							}
							if($val=="lp_top_in_search_page_ads"){
								$packagesDetails .= esc_html__(' Top in Search Page Ads ', 'listingpro');
							}
							//$priceKeyArray = $listingpro_options[$val]+$priceKeyArray;
							$priceKeyArray = $lpTOtalprice;
						}
					}
				}

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$sql="
		   CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."listing_campaigns`
		 (
			  main_id bigint(20) NOT NULL auto_increment,
			  user_id varchar(255) default NULL,
			  post_id varchar(255) default NULL,
			  payment_method varchar(255) default NULL,
			  token varchar(255) default NULL,
			  price varchar(255) default NULL,
			  currency varchar(255) default NULL,
			  status varchar(255) default NULL,
			  transaction_id varchar(255) default NULL,
			  PRIMARY KEY  (`main_id`)
		 );";
		dbDelta($sql);
		
		$insert_sql ="
				INSERT INTO `".$wpdb->prefix."listing_campaigns` VALUES ('','$user_ID','$adID','$method','$token','$priceKeyArray','$currency_code','$status','$transactionID')";

        dbDelta($insert_sql);
		
		$current_user = wp_get_current_user();
		$user_email = $current_user->user_email;
		$admin_email = get_option('admin_email');
		$listing_title = get_the_title($listing_id);
		$listing_url = get_the_permalink($listing_id);
		$campaign_packages = $packagesDetails;
		
		$author_name = $current_user->user_login;
        /* for admin */
		$subject = $listingpro_options['listingpro_subject_campaign_activate'];
		$mail_content = $listingpro_options['listingpro_content_campaign_activate'];
		
		$formated_mail_content = lp_sprintf2("$mail_content", array(
			'campaign_packages' => "$campaign_packages",
			'listing_title' => "$listing_title",
			'listing_url' => "$listing_url",
			'author_name' => "$author_name"
		));
		
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		wp_mail( $admin_email, $subject, $formated_mail_content, $headers);
		
		 /* for author */
		 
		$subject = $listingpro_options['listingpro_subject_campaign_activate_author'];
		$mail_content = $listingpro_options['listingpro_content_campaign_activate_author'];
		
		$formated_mail_content = lp_sprintf2("$mail_content", array(
			'campaign_packages' => "$campaign_packages",
			'listing_title' => "$listing_title",
			'listing_url' => "$listing_url",
		));
		
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		wp_mail( $user_email, $subject, $formated_mail_content, $headers);
		
	}
}

/* ===========================================listingpro insert data in db============================================== */

if(!function_exists('lp_insert_data_in_db')){
	function lp_insert_data_in_db($table, $dataArray){
		global $wpdb,$listingpro_options;
		$dbprefix = $wpdb->prefix;
		$table =$dbprefix.$table;
		$result = $wpdb->insert( $table, $dataArray, $format = null );
		
		if(!empty($result) && $result > 0){
			return true;
		}
		else{
			return false;
		}
		
	}
}

/* ===========================================listingpro delete data in db============================================== */

if(!function_exists('lp_delete_data_in_db')){
	function lp_delete_data_in_db($table, $where){
		global $wpdb,$listingpro_options;
		$dbprefix = $wpdb->prefix;
		$table =$dbprefix.$table;
		$result = $wpdb->delete( $table, $where, $where_format = null );
		
		if(!empty($result) && $result > 0){
			return true;
		}
		else{
			return false;
		}
		
	}
}

/* ============================================listingpro update data in db========================================= */

if(!function_exists('lp_update_data_in_db')){
	function lp_update_data_in_db($table, $data, $where){
		global $wpdb,$listingpro_options;
		$dbprefix = $wpdb->prefix;
		$table =$dbprefix.$table;
		
		$result = $wpdb->update( $table, $data, $where, $format = null, $where_format = null );
		if(!empty($result) && $result > 0){
			return true;
		}
		else{
			return false;
		}
	}
}

/* ============================================listingpro get data from db table ================================= */

if(!function_exists('lp_get_data_from_db')){
	function lp_get_data_from_db($table, $data, $condition){
		global $wpdb,$listingpro_options;
		
		$dbprefix = $wpdb->prefix;
		
		$table =$dbprefix.$table;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
			$query = "";
			$query = "SELECT $data from $table WHERE $condition ORDER BY main_id DESC";
			$result = $wpdb->get_results( $query);		
			return $result;
		}
return;
		
	}
}

/* =============================================listingpro create campains table ================================*/

if(!function_exists('lp_create_campaigns_table')){
	function lp_create_campaigns_table(){
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		global $wpdb,$listingpro_options;
		$dbprefix = $wpdb->prefix;
		$sql="
		   CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."listing_campaigns`
		 (
			  main_id bigint(20) NOT NULL auto_increment,
			  user_id varchar(255) default NULL,
			  post_id varchar(255) default NULL,
			  payment_method varchar(255) default NULL,
			  token varchar(255) default NULL,
			  price varchar(255) default NULL,
			  currency varchar(255) default NULL,
			  status varchar(255) default NULL,
			  transaction_id varchar(255) default NULL,
			  PRIMARY KEY  (`main_id`)
		 );";
		dbDelta($sql);
	}
}

/* ==============================================listingpro create listings orders table =============================== */

if(!function_exists('lp_create_listings_orders_table')){
	function lp_create_listings_orders_table(){
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		global $wpdb,$listingpro_options;
		$dbprefix = $wpdb->prefix;
		$wpdb->query("CREATE TABLE IF NOT EXISTS `".$dbprefix."listing_orders` (
		  `main_id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		  `user_id` TEXT NOT NULL ,
		  `post_id` TEXT NOT NULL ,
		  `plan_id` TEXT NOT NULL ,
		  `plan_name` TEXT NOT NULL ,
		  `plan_type` TEXT NOT NULL ,
		  `payment_method` TEXT NOT NULL ,
		  `token` TEXT NOT NULL ,
		  `price` FLOAT UNSIGNED NOT NULL ,
		  `currency` TEXT NOT NULL ,
		  `days` TEXT NOT NULL ,
		  `date` TEXT NOT NULL ,
		  `status` TEXT NOT NULL ,
		  `used` TEXT NOT NULL ,
		  `transaction_id` TEXT NOT NULL ,
		  `firstname` TEXT NOT NULL ,
		  `lastname` TEXT NOT NULL ,
		  `email` TEXT NOT NULL ,
		  `description` TEXT NOT NULL ,
		  `summary` TEXT NOT NULL ,
		  `order_id` TEXT NOT NULL 
		  ) ENGINE = MYISAM; ");
	}
}

?>