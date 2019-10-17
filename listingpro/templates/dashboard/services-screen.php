<?php
if ( isset( $_POST['menu_nonce_field'] ) && wp_verify_nonce( $_POST['menu_nonce_field'], 'menu_nonce' ) ) {
	$res_menu_title 		= $_POST['res_menu_title'];
	$listID 				= $_POST['listID'];
	$menu_img 				= $_POST['frontend_input'];
	$menuArray = array('menu-img'=>$menu_img,'menu-title'=>$res_menu_title);
	if(isset($menu_img) && !empty($menu_img) && isset($listID) && !empty($listID)){
		update_post_meta( $listID, 'menu_listing', $menuArray);
	}
}
if ( isset( $_POST['menu_del_nonce_field'] ) && wp_verify_nonce( $_POST['menu_del_nonce_field'], 'menu_del_nonce' ) ) {
	$menu_remove_id 		= $_POST['menu_remove_id'];
	if(isset($menu_remove_id) && !empty($menu_remove_id)){
		delete_post_meta($menu_remove_id, 'menu_listing');
	}
}
$user_ID = get_current_user_id();	
$args = array(
	'author'   => $user_ID,
	'posts_per_page'   => -1,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_type'        => 'listing',
	'post_status'      => 'publish'
);
$posts_array = get_posts( $args );

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


$argsActive = array(
	'author'   => $user_ID,
	'posts_per_page'   => -1,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_type'        => 'listing',
	'post_status'      => 'publish',
	'meta_query' =>
	array(
		array(
			'key'     => 'menu_listing',
			'compare' => 'EXIST'
		)
	),
);
$Active_array = get_posts( $argsActive ); 
?>
<div class="user-recent-listings-inner tab-pane fade in active" id="resurva_bookings">
	<div class="tab-header">
		<h3><?php echo esc_html__('Restaurant Menu', 'listingpro'); ?></h3>
	</div>
	<div class="row lp-list-page-list">
		<div class="col-md-12 col-sm-6 col-xs-12 lp-list-view">
			<div class="resurva-booking lp-menus-area">
				<div class="lp-list-view-inner-contianer clearfix">
					<form method="post" id="restaurant-menu" action="<?php echo esc_attr($actual_link); ?>">
						<h3><?php esc_html_e('Add Menu to any listing','listingpro'); ?></h3>
						<div class="hidden-items show clearfix">
							<div class="row">
								<div class="col-md-6 col-xs-12">
									<div class="title-field">
										<label for="res_menu_title"><?php esc_html_e('Title (example: "See Full Menu")','listingpro'); ?></label>
										<input type="text" name="res_menu_title" id="res_menu_title" placeholder="<?php esc_html_e('See Full Menu','listingpro'); ?>">
									</div>
									<div class="upload-field">
										<?php echo do_shortcode('[frontend-button]'); ?>
										<div class="file-options">
											<p><?php esc_html_e('(JPEG, PNG, GIF)")','listingpro'); ?></p>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<label for="reservaListing"><?php esc_html_e('Select your list to assign your food / service menu','listingpro'); ?></label>
									<?php if(!empty($posts_array)){ ?>
									<select class="select2" name="listID" id="reservaListing">
										<?php foreach ($posts_array as $list) { ?>
											<option value="<?php echo $list->ID; ?>"><?php echo $list->post_title; ?></option>
										<?php } ?>
									</select>
									<?php }else{
										echo esc_html__('You have no published listing.','listingpro');										
									} ?>
									<div class="send-btn">
										<input type="submit" value="<?php esc_html_e('Submit','listingpro'); ?>" class="lp-review-btn btn-second-hover">
									</div>
								</div>
							</div>
						</div>
						<?php echo wp_nonce_field( 'menu_nonce', 'menu_nonce_field' , true, false ); ?>
					</form>
				</div>
			</div>
			<?php if(!empty($Active_array)){ ?>
				<div class="resurva-booking lp-menus-area">
					<div class="lp-list-view-inner-contianer clearfix">
					<h3 class="margin-top-0 margin-bottom-30"><?php esc_html_e('Menu Option is Currently Active On','listingpro'); ?></h3>
						<ul class="padding-left-0">
							<?php						
							foreach ($Active_array as $list) {
							?>
								<li class="clearfix">
									<h4 class="pull-left margin-right-30"><?php echo $list->post_title; ?></h4>
									<form method="post" id="booking" action="<?php echo $actual_link; ?>">
										<input type="hidden" name="menu_remove_id" value="<?php echo $list->ID; ?>" class="lp-review-btn btn-second-hover">
										<span>
											<i class="fa fa-times"></i>
											<input type="submit" class="margin-top-10 pull-right" value="<?php esc_html_e('Remove','listingpro'); ?>">
										</span>
										<?php echo wp_nonce_field( 'menu_del_nonce', 'menu_del_nonce_field' , true, false ); ?>
									</form>	
								</li>
							<?php } ?>						
						</ul>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>