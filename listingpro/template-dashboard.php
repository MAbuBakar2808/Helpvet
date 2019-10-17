<?php
/**
 * Template name: Dashboard
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */
 ?>
 <?php
global $listingpro_options, $post;
$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
if( $listing_mobile_view == 'app_view' && wp_is_mobile() ){
	get_template_part('mobile/template-dashboard-app-view');
}
else
{
	
	$userID = '';
	if(is_user_logged_in()){
		
		$current_user = wp_get_current_user();
		$userID = $current_user->ID;		
	}else{
		wp_redirect( home_url() ); exit;
	}
	
	/* by zaheer on 21 march */
	$published_listings = ''; 
	$pending_listings=''; 
	$expired_listings = ''; 
	$all_listings='';
	$count_listings = wp_count_posts( 'listing', 'readable' );
	$published_listings = count_user_posts_by_status('listing', 'publish',$userID, false);
	$pending_listings = count_user_posts_by_status('listing', 'pending',$userID, false);
	$expired_listings = count_user_posts_by_status('listing', 'expired',$userID, false);
	$all_listings = $published_listings + $pending_listings + $expired_listings;
	/* end by zaheer on 21 march */
	
	$simpleDashboard=false;
	if( empty($published_listings) && empty($pending_listings) && empty($expired_listings) ){
		$simpleDashboard = true;
	}
	
	$updateTab = false;
	global $user_id, $listingpro_options;
	
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	$userSubscriptions = false;	
	$userSubs = get_user_meta($user_id, 'listingpro_user_sbscr', true);
	if(!empty($userSubs)){
		if( is_array($userSubs) && count($userSubs)>0){
			$userSubscriptions=true;
		}
	}
	$rmessage = '';
	$rType = '';
	if(isset($_POST['removeid']) && !empty($_POST['removeid'])){
		$rID = $_POST['removeid'];
		$rpost = get_post( $rID ); 
		$rpost_author = $rpost->post_author;
		if($user_id == $rpost_author){
			wp_delete_post($rID);
			$rmessage = esc_html__('Post has deleted succesfully', "listingpro");
			$rType = 'success';
		}else{
			$rmessage = esc_html__('You have no permission to delete this post', "listingpro");
			$rType = 'warning';
		}
		
	}
	
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID; 
	// User Name
	$user_fname = get_the_author_meta('first_name', $user_id);
	$user_lname = get_the_author_meta('last_name', $user_id);
	// User contact meta
	$user_address = get_the_author_meta('address', $user_id);
	$user_phone = get_the_author_meta('phone', $user_id);
	$user_email = get_the_author_meta('user_email', $user_id);
	// User Social links
	$user_facebook = get_the_author_meta('facebook', $user_id);
	$user_google = get_the_author_meta('google', $user_id);
	$user_linkedin = get_the_author_meta('linkedin', $user_id);
	$user_instagram = get_the_author_meta('instagram', $user_id);
	$user_twitter = get_the_author_meta('twitter', $user_id);
	$user_pinterest = get_the_author_meta('pinterest', $user_id);
	// User BIO
	$user_desc = get_the_author_meta('description', $user_id);
	$user_ID = $user_id;
	if ($user_ID) {

		if(isset($_POST['profileupdate'])) {

			$message = esc_html__("Your profile was updated successfully.", "listingpro");
			$mType = 'success';

			$first = esc_html($_POST['first_name']);
			$last = esc_html($_POST['last_name']);
			$email = esc_html($_POST['email']);
			$user_phone = esc_html($_POST['phone']);
			$user_address = esc_html($_POST['address']);
			$description = esc_html($_POST['desc']);

			$facebook = esc_html($_POST['facebook']);
			$google = esc_html($_POST['google']);
			$linkedin = esc_html($_POST['linkedin']);
			$instagram = esc_html($_POST['instagram']);
			$twitter = esc_html($_POST['twitter']);
			$pinterest = esc_html($_POST['pinterest']);

			$password = esc_html($_POST['pwd']);
			$confirm_password = esc_html($_POST['confirm']);

			update_user_meta( $user_ID, 'first_name', $first );
			update_user_meta( $user_ID, 'last_name', $last );
			update_user_meta( $user_ID, 'phone', $user_phone );
			update_user_meta( $user_ID, 'address', $user_address );
			update_user_meta( $user_ID, 'description', $description );

			update_user_meta( $user_ID, 'facebook', $facebook );
			update_user_meta( $user_ID, 'google', $google );
			update_user_meta( $user_ID, 'linkedin', $linkedin );
			update_user_meta( $user_ID, 'instagram', $instagram );
			update_user_meta( $user_ID, 'twitter', $twitter );
			update_user_meta( $user_ID, 'pinterest', $pinterest );
			
			$your_image_url = $_POST['your_author_image_url'];
			$author_avatar_url = get_user_meta($user_ID, "listingpro_author_img_url", true); 
			if($your_image_url != ''){
				update_user_meta( $user_ID, 'listingpro_author_img_url', $your_image_url );
			}else{
				update_user_meta( $user_ID, 'listingpro_author_img_url', $author_avatar_url );
			}

			if(isset($email) && is_email($email)) {
				wp_update_user( array ('ID' => $user_ID, 'user_email' => $email) ) ;
			}else { 
				$message = esc_html__("Please enter a valid email id.", "listingpro");
				$mType = 'error';
			}

			if($password) {
				if (strlen($password) < 5 || strlen($password) > 15) {
					$message = esc_html__("Password must be 5 to 15 characters in length", "listingpro");
					$mType = 'error';
				}
				//elseif( $password == $confirm_password ) {
				elseif(isset($password) && $password != $confirm_password) {
					$message = "Password Mismatch";
					$mType = 'error';
				} elseif ( isset($password) && !empty($password) ) {
					$update = wp_set_password( $password, $user_ID );
					$message = esc_html__("Your profile was updated successfully.", "listingpro");
					$mType = 'success';
				}
			}
			$updateTab = true;
		}
	}
	
	$contactSupport = $listingpro_options['contact_support'];
	$resurva_bookings_enable = $listingpro_options['resurva_bookings_enable'];
	$timekit_bookings_enable = $listingpro_options['timekit_bookings_enable'];
	$menu_bookings_enable = $listingpro_options['menu_bookings_enable'];
		
		
			/* by zaheer on 28 march */
			$published_campaings = lp_count_user_campaigns($userID);
			/* end by zaheer on 28 march */
 ?>
<?php get_header();?>

<!--==================================Section Open=================================-->
<?php
	if (class_exists('ListingproPlugin')) {
		$current_user = wp_get_current_user();
		$u_display_name = $current_user->display_name;
		if(empty($u_display_name)){
			$u_display_name = $current_user->nickname;
		}
?>
	<section class="aliceblue">
		<div class="admin-top-section">
			<div class="user-details">
				<div class="row pos-relative">
					<div class="col-md-3">
						<div class="user-portfolio">
							<div class="user-info">
								<div class="user-thumb">
									<img class="avatar-circle" src="<?php echo listingpro_author_image(); ?>" alt="userimg" />
								</div>
								<div class="user-text">
									<h5 class="user-name margin-top-0">
										<span><?php esc_html_e('Howdy!','listingpro'); ?></span>
										<?php echo $u_display_name; ?>
									</h5>
									<!-- <p><?php echo esc_html($user_address); ?></p>
									<p><?php echo esc_html($user_phone); ?></p> -->
								</div>
							</div>
						</div>
					</div>
					<div class="lp-right-panel-upper">
						<div class="user-description-box clearfix">
						<?php if($simpleDashboard==false){ ?>
							<ul>
								<li class="lp-all-listing">
									<span class="count-text all-listing"><?php echo esc_html__('All Listing', 'listingpro'); ?></span>
									<div class="lp-dashboard-circle">
										<div class="lp-circle-content">
											<span class="count"><?php echo $all_listings; ?>
												<p><?php echo esc_html__('Items', 'listingpro'); ?></p>
											</span>
										</div>
									</div>
								</li>
								<li class="lp-pending">
									<span class="count-text pending-listing"><?php echo esc_html__('Pending', 'listingpro'); ?></span>
									<div class="lp-dashboard-circle">
										<div class="lp-circle-content">
											<span class="count"><?php echo $pending_listings; ?>
												<p><?php echo esc_html__('Items', 'listingpro'); ?></p>
											</span>
										</div>	
									</div>	
								</li>
								<li class="lp-publish-listing">
									<span class="count-text published-listing"><?php echo esc_html__('Published', 'listingpro'); ?></span>								
									<div class="lp-dashboard-circle">
										<div class="lp-circle-content">
											<span class="count"><?php echo $published_listings; ?>
												<p><?php echo esc_html__('Items', 'listingpro'); ?></p>
											</span>
										</div>
									</div>
								</li>
								<li class="lp-expired-listing">
									<span class="count-text expired-listing"><?php echo esc_html__('Expired', 'listingpro'); ?></span>
									<div class="lp-dashboard-circle">
										<div class="lp-circle-content">
											<span class="count"><?php echo $expired_listings; ?>
												<p><?php echo esc_html__('Items', 'listingpro'); ?></p>
											</span>
										</div>
									</div>
								</li>
								
								<li class="lp-active-listing">
									<span class="count-text active-campaigns"><?php echo esc_html__('Active Campaigns', 'listingpro'); ?></span>
									<div class="lp-dashboard-circle">
										<div class="lp-circle-content">
											<span class="count"><?php echo $published_campaings; ?>
												<p><?php echo esc_html__('Items', 'listingpro'); ?></p>
											</span>
										</div>
									</div>
								</li>
							</ul>
						<?php } ?>	
						</div>		
						<?php if(!empty($contactSupport)) { ?>
							<div class="lp-contact-support">
								<a href="<?php echo esc_url($contactSupport); ?>" class="secondary-btn">
									<i class="fa fa-support"></i>
									<?php esc_html_e('Contact Support','listingpro'); ?>
								</a>
							</div>
						<?php } ?>			
					</div>					
				</div>
			</div>
		</div>

		<?php
			$dashPage = '';
			$opendClass = '';
			$openedClasss = '';
			$activeListing = '';
			$activePending = '';
			$activeExpired = '';
			if(isset($_GET['dashboard'])){
				$dashPage = esc_html($_GET['dashboard']);
			}
			
			if(!empty($dashPage) && ($dashPage=="listing" || $dashPage=="pending" || $dashPage=="expired")){
				$opendClass = 'opened';

				if($dashPage=="listing"){
					$activeListing = 'class="active"';
				}
				else if($dashPage=="pending"){
					$activePending = 'class="active"';
				}
				else if($dashPage=="expired"){
					$activeExpired = 'class="active"';
				}
			}
			
			$lft_panel = '';
			$openedClass = '';
			$camp_Listing = '';
			$activeCampListing = '';
			$invcListing = '';
			$activeinvoiceListing = '';
			if(isset($_GET['dashboard'])){
				$lft_panel = esc_html($_GET['dashboard']);
			}
			if(!empty($lft_panel) && ($lft_panel=="campaigns" || $lft_panel=="active-campaigns")){
				$openedClass = 'opened';
				
				if($lft_panel=="campaigns"){
					$camp_Listing = 'class="active"';
				}
				else if($lft_panel=="active-campaigns"){
					$activeCampListing = 'class="active"';
				}
			}
			
			if(!empty($lft_panel) && ($lft_panel=="list-invoices" || $lft_panel=="ads-invoices")){
				$openedClasss = 'opened';
				
				if($lft_panel=="list-invoices"){
					$activeinvoiceListing = 'class="active"';
				}
				else if($lft_panel=="ads-invoices"){
					$invcListing = 'class="active"';
				}
			}
			
			$review_panel = '';
			$reviewOpenedClass = '';
			$review_Listing = '';
			$activeReviewListing = '';
			if(isset($_GET['dashboard'])){
				$review_panel = esc_html($_GET['dashboard']);
			}
			if(!empty($review_panel) && ($review_panel=="reviews" || $review_panel=="reviews-submited")){
				$reviewOpenedClass = 'opened';
				
				if($review_panel=="reviews"){
					$review_Listing = 'class="active"';
				}
				else if($review_panel=="reviews-submited"){
					$activeReviewListing = 'class="active"';
				}
			}
			
			$tymkit_panel = '';
			$tymkitOpenedClass = '';
			$tymkit_Listing = '';
			$activeTymkitListing = '';
			if(isset($_GET['dashboard'])){
				$tymkit_panel = esc_html($_GET['dashboard']);
			}
			if(!empty($tymkit_panel) && ($tymkit_panel=="bookings" || $tymkit_panel=="timekit-bookings")){
				$tymkitOpenedClass = 'opened';
				
				if($tymkit_panel=="bookings"){
					$tymkit_Listing = 'class="active"';
				}
				else if($tymkit_panel=="timekit-bookings"){
					$activeTymkitListing = 'class="active"';
				}
			}
			
			
			$activeDashboardMenu = '';
			$activeprofileMenu = '';
			$activesavedMenu = '';
			$activeinvoicesMenu = '';
			$activepackagesMenu = '';
			$activecampaignsMenu = '';
			$activereviewsMenu = '';
			$activeBookingsMenu = '';
			$activeMenuItem = '';
			$activeSubscriptionMenu = '';
			if(!empty($dashPage)){
				if($dashPage=="main-screen"){
					$activeDashboardMenu = 'class="active-dash-menu"';
				}
				else if($dashPage=="update-profile"){
					$activeprofileMenu = 'class="active-dash-menu"';
				}
				else if($dashPage=="saved"){
					$activesavedMenu = 'class="active-dash-menu"';
				}
				else if($dashPage=="invoices"){
					$activeinvoicesMenu = 'class="active-dash-menu"';
				}
				else if($dashPage=="packages"){
					$activepackagesMenu = 'class="active-dash-menu"';
				}
				else if($dashPage=="campaigns"){
					$activecampaignsMenu = 'class="active-dash-menu"';
				}
				else if($dashPage=="services-screen"){
					$activeMenuItem = 'class="active-dash-menu"';
				}
				else if($dashPage=="subscription"){
					$activeSubscriptionMenu = 'class="active-dash-menu"';
				}
			}
			
			
			$currentURL = '';
			$perma = '';
			$dashQuery = 'dashboard=';
			$currentURL = get_permalink();
			global $wp_rewrite;
			if ($wp_rewrite->permalink_structure == ''){
				$perma = "&";
			}else{
				$perma = "?";
			}
			
			$dashboard_usr_show = true;
			$my_listings_show = true;
			$saved_listing_show = true;
			$invoices_dashboard_show = true;
			$dashboard_packages_show = true;
			$ad_compaigns_show = true;
			$review_dashoard_show = true;
			$booking_dashoard_show = true;
			$menu_dashoard_show = true;
			$my_profile_show = true;
			$log_out_show = true;
			
			$dashboard_usr = $listingpro_options['dashboard_usr'];
			if($dashboard_usr == 0) {
				$dashboard_usr_show = false;
			}
			$my_listings = $listingpro_options['my_listings'];
			if($my_listings == 0) {
				$my_listings_show = false;
			}
			$saved_listing = $listingpro_options['saved_listing'];
			if($saved_listing == 0) {
				$saved_listing_show = false;
			}
			$invoices_dashboard = $listingpro_options['invoices_dashboard'];
			if($invoices_dashboard == 0) {
				$invoices_dashboard_show = false;
			}
			$dashboard_packages = $listingpro_options['dashboard_packages'];
			if($dashboard_packages == 0) {
				$dashboard_packages_show = false;
			}
			$ad_compaigns = $listingpro_options['ad_compaigns'];
			if($ad_compaigns == 0) {
				$ad_compaigns_show = false;
			}
			$review_dashoard = $listingpro_options['review_dashoard'];
			if($review_dashoard == 0) {
				$review_dashoard_show = false;
			}
			$booking_dashoard = $listingpro_options['booking_dashoard'];
			if($booking_dashoard == 0) {
				$booking_dashoard_show = false;
			}
			$menu_dashoard = $listingpro_options['menu_dashoard'];
			if($menu_dashoard == 0) {
				$menu_dashoard_show = false;
			}
			$my_profile = $listingpro_options['my_profile'];
			if($my_profile == 0) {
				$my_profile_show = false;
			}
			$log_outt = $listingpro_options['log_outt'];
			
			if($log_outt == 0) {
				$log_out_show = false;
			}
			
		?>

		<div class="dashboard-content">
			<div class="row">
				<div class="col-md-12 col-xs-12 tbl-cell">
					<div class="pull-left left-panel tbl-cell">
						<div class="dashboard-tabs lp-main-tabs text-center">
							<!-- Left Panel Navigation Starts -->
							<ul>
								<?php if($simpleDashboard==false){ ?>
								
								<?php if($dashboard_usr_show == true){ ?>
								<li>
									<a <?php echo $activeDashboardMenu; ?> href="<?php echo $currentURL.$perma.$dashQuery.'main-screen'; ?>"><i class="fa fa-dashboard"></i><?php esc_html_e(' Dashboard','listingpro'); ?></a>
								</li>
								<?php } ?>
								
								<?php } ?>
								<?php if($simpleDashboard==true){ ?>
								
								<?php if($my_profile_show == true){ ?>
								<li>
									<a <?php echo $activeprofileMenu; ?> href="<?php echo $currentURL.$perma.$dashQuery.'update-profile'; ?>"><i class="fa fa-user-circle"></i><?php esc_html_e(' My Profile','listingpro'); ?></a>
								</li>
								<?php } ?>
								
								<?php if($saved_listing_show == true){ ?>		
									<li><a <?php echo $activesavedMenu; ?> href="<?php echo $currentURL.$perma.$dashQuery.'saved'; ?>"><i class="fa fa-heart" aria-hidden="true"></i><?php esc_html_e('Saved','listingpro'); ?> </a></li>
								<?php } ?>
								
								<?php } ?>
								<?php if($simpleDashboard==false){ ?>
								
								<?php if($my_listings_show == true){ ?>								
									<li class="dropdown <?php echo esc_attr($opendClass) ?>">
										<a href="#"><i class="fa fa-th-list"></i><?php esc_html_e('My Listing ','listingpro'); ?> <i class="fa fa-angle-down"></i></a>
										<ul class="<?php echo esc_attr($opendClass) ?>">
											<li <?php echo $activeListing; ?> class="lp-publish-lst"><a href="<?php echo $currentURL.$perma.$dashQuery.'listing'; ?>"><i class="fa fa-angle-right"></i><?php esc_html_e(' Published','listingpro'); ?><span><?php echo $published_listings; ?></span></a></li>
											<li <?php echo $activePending; ?> class="lp-pending-lst"><a href="<?php echo $currentURL.$perma.$dashQuery.'pending'; ?>"><i class="fa fa-angle-right"></i><?php esc_html_e('  Pending','listingpro'); ?><span><?php echo $pending_listings; ?></span></a></li>
											<li <?php echo $activeExpired; ?> class="lp-expired-lst"><a href="<?php echo $currentURL.$perma.$dashQuery.'expired'; ?>"><i class="fa fa-angle-right"></i><?php esc_html_e('   Expired','listingpro'); ?><span><?php echo $expired_listings; ?></span></a></li>
										</ul>
									</li>
								<?php } ?>
								<?php if($saved_listing_show == true){ ?>		
									<li><a <?php echo $activesavedMenu; ?> href="<?php echo $currentURL.$perma.$dashQuery.'saved'; ?>"><i class="fa fa-heart" aria-hidden="true"></i><?php esc_html_e('Saved','listingpro'); ?> </a></li>
								<?php } ?>
								<?php if($invoices_dashboard_show == true){ ?>
									<li class="dropdown <?php echo esc_attr($openedClasss) ?>">
										<a href="#"><i class="fa fa-file-text-o"></i><?php esc_html_e(' Invoices ','listingpro'); ?><i class="fa fa-angle-down"></i></a>
										<ul class="<?php echo esc_attr($openedClasss) ?>">
											<li <?php echo $activeinvoiceListing; ?> class="lp-publish-lst"><a href="<?php echo $currentURL.$perma.$dashQuery.'list-invoices'; ?>"><i class="fa fa-angle-right"></i><?php esc_html_e(' For Listings','listingpro'); ?> </a></li>
											<li <?php echo $invcListing; ?> class="lp-publish-lst"><a href="<?php echo $currentURL.$perma.$dashQuery.'ads-invoices'; ?>"><i class="fa fa-angle-right"></i><?php esc_html_e(' For Ads','listingpro'); ?></a></li>
										</ul>
									</li>
								<?php } ?>
								<?php if($dashboard_packages_show == true){ ?>
									<li><a <?php echo $activepackagesMenu; ?> href="<?php echo $currentURL.$perma.$dashQuery.'packages'; ?>"><i class="fa fa-briefcase" aria-hidden="true"></i><?php esc_html_e('Packages','listingpro'); ?> </a></li>
								<?php } ?>
								<?php if($userSubscriptions==true){ ?>
									<li>
										<a <?php echo $activeSubscriptionMenu; ?> href="<?php echo $currentURL.$perma.$dashQuery.'subscription'; ?>"><i class="fa fa-flag"></i><?php esc_html_e(' My Subscriptions','listingpro'); ?></a>
									</li>
								<?php
									}
								?>
									<?php
										if (class_exists('ListingAds')) {
									?>
									<?php if($ad_compaigns_show == true){ ?>
											<li class="dropdown <?php echo esc_attr($openedClass); ?>">
												<a href="#"><i class="fa fa-bullhorn"></i><?php esc_html_e('Ad Campaigns ','listingpro'); ?> <i class="fa fa-angle-down"></i></a>
												<ul class="<?php echo esc_attr($openedClass); ?>">
													<li <?php echo $activeCampListing; ?> class="lp-publish-lst"><a href="<?php echo $currentURL.$perma.$dashQuery.'active-campaigns'; ?>"><i class="fa fa-angle-right"></i><?php esc_html_e(' Active Campaigns ','listingpro'); ?><span><?php echo $published_campaings; ?></span></a></li>
													<li <?php echo $camp_Listing; ?> class="lp-publish-lst"><a href="<?php echo $currentURL.$perma.$dashQuery.'campaigns'; ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e('Start New Campaign','listingpro'); ?></a></li>
												</ul>
											</li>
									<?php } ?>
								<?php
									}
								}
								?>
								
								<?php
									if (class_exists('ListingReviews')) {
								?>
								<?php if($review_dashoard_show == true){ ?>
										<li class="dropdown <?php echo esc_attr($reviewOpenedClass); ?>">
											<a href="#"><i class="fa fa-star"></i><?php esc_html_e(' Reviews ','listingpro'); ?><i class="fa fa-angle-down"></i></a>
											<ul class="<?php echo esc_attr($reviewOpenedClass); ?>">
											<?php if($simpleDashboard==false){ ?>
													<li <?php echo $review_Listing; ?>><a href="<?php echo $currentURL.$perma.$dashQuery.'reviews'; ?>"><i class="fa fa-angle-right"></i><?php esc_html_e(' Reviews Received','listingpro'); ?></a></li>
											<?php } ?>
												<li <?php echo $activeReviewListing; ?>><a href="<?php echo $currentURL.$perma.$dashQuery.'reviews-submited'; ?>"><i class="fa fa-angle-right"></i><?php esc_html_e('Reviews Submited ','listingpro'); ?> </a></li>
											</ul>
										</li>
								<?php } ?>
								<?php
									}
								?>
								
								<?php if( $timekit_bookings_enable == 1 || $resurva_bookings_enable == 1 ) { ?>
								<?php if($simpleDashboard==false){ ?>
								
								<?php if($booking_dashoard_show == true){ ?>
									<li class="dropdown <?php echo esc_attr($tymkitOpenedClass); ?>">
										<a href="#"><i class="fa fa-calendar"></i><?php esc_html_e('Bookings ','listingpro'); ?> <i class="fa fa-angle-down"></i></a>
										<ul class="<?php echo esc_attr($tymkitOpenedClass); ?>">
											<?php if( $resurva_bookings_enable == 1 ) { ?>
												<li <?php echo $tymkit_Listing; ?>><a href="<?php echo $currentURL.$perma.$dashQuery.'bookings'; ?>"><i class="fa fa-angle-right"></i><?php esc_html_e(' Resurva','listingpro'); ?></a></li>
											<?php } ?>
											<?php if( $timekit_bookings_enable == 1 ) { ?>
												<li <?php echo $activeTymkitListing; ?>><a href="<?php echo $currentURL.$perma.$dashQuery.'timekit-bookings'; ?>"><i class="fa fa-angle-right"></i><?php esc_html_e(' Timekit','listingpro'); ?></a></li>
											<?php } ?>
										</ul>
									</li>
								<?php } ?>
								<?php } }
								if( $menu_bookings_enable == 1 ) { ?>
								<?php if($simpleDashboard==false){ ?>
								<?php if($menu_dashoard_show == true){ 
									$food_menu_icon = $listingpro_options['food_menu_icon']['url'];
									if(empty($food_menu_icon)){
								?>
							
									<li><a <?php echo $activeMenuItem; ?> href="<?php echo $currentURL.$perma.$dashQuery.'services-screen'; ?>"><i class="fa fa-cutlery"></i><?php esc_html_e('Food / Service Menu','listingpro'); ?> </a></li>
								<?php }elseif(!empty($food_menu_icon)){ ?>
								
									<li class="lp-food-menu-icon"><a <?php echo $activeMenuItem; ?> href="<?php echo $currentURL.$perma.$dashQuery.'services-screen'; ?>"><img src = "<?php echo esc_attr($food_menu_icon); ?>" /><?php esc_html_e('Food / Service Menu','listingpro'); ?> </a></li>
								
								<?php }?>
								
								<?php } ?>
								<?php } } ?>
								<?php if($simpleDashboard==false){ ?>
								<?php if($my_profile_show == true){ ?>
								<li>
									<a <?php echo $activeprofileMenu; ?> href="<?php echo $currentURL.$perma.$dashQuery.'update-profile'; ?>"><i class="fa fa-user-circle"></i><?php esc_html_e(' My Profile','listingpro'); ?></a>
								</li>
								
								
								<?php } ?>
								<?php } ?>
								<?php if($log_out_show == true){ ?>
								<li><a href="<?php echo wp_logout_url(); ?>"><i class="fa fa-unlock-alt"></i><?php esc_html_e(' Logout','listingpro'); ?></a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<div class="right-panel">
						<?php if($simpleDashboard==false){ ?>
						<?php
							if(isset($_GET['dashboard']) && !empty($_GET['dashboard'])){
								get_template_part('templates/dashboard/'.$_GET['dashboard'].'');
							}else {
								get_template_part('templates/dashboard/main-screen');
							}
						?>
						<?php } ?>
						
						<?php

						if($simpleDashboard==true){ 
							if(isset($_GET['dashboard']) && !empty($_GET['dashboard'])){
								get_template_part('templates/dashboard/'.$_GET['dashboard'].'');
							}else{
								get_template_part('templates/dashboard/update-profile');
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php } else{ ?>
	<div class="col-md-12">
		<p><?php esc_html_e('Sorry! You have no permisssion to access this page. Please contact web admin.','listingpro'); ?></p>
	</div>
	<?php } ?>
	<!--==================================Section Close=================================-->
	<div class="md-overlay"></div>
<?php } ?>
<?php get_footer();?>