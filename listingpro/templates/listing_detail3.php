<?php
/* The loop starts here. */
global $listingpro_options;
$currentUserId = get_current_user_id();
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post(); 
		setPostViews(get_the_ID());
		$claimed_section = listing_get_metabox('claimed_section');
		$tagline_text = listing_get_metabox('tagline_text');
		
		$plan_id = listing_get_metabox_by_ID('Plan_id',get_the_ID());
		if(!empty($plan_id)){
			$plan_id = $plan_id;
		}else{
			$plan_id = 'none';
		}
		
		$contact_show = get_post_meta( $plan_id, 'contact_show', true );
		$map_show = get_post_meta( $plan_id, 'map_show', true );
		$video_show = get_post_meta( $plan_id, 'video_show', true );
		$gallery_show = get_post_meta( $plan_id, 'gallery_show', true );
		$tagline_show = get_post_meta( $plan_id, 'listingproc_tagline', true );
		$location_show = get_post_meta( $plan_id, 'listingproc_location', true );
		$website_show = get_post_meta( $plan_id, 'listingproc_website', true );
		$social_show = get_post_meta( $plan_id, 'listingproc_social', true );
		$faqs_show = get_post_meta( $plan_id, 'listingproc_faq', true );
		$price_show = get_post_meta( $plan_id, 'listingproc_price', true );
		$tags_show = get_post_meta( $plan_id, 'listingproc_tag_key', true );
		$hours_show = get_post_meta( $plan_id, 'listingproc_bhours', true );
		
		if($plan_id=="none"){
			$contact_show = 'true';
			$map_show = 'true';
			$video_show = 'true';
			$gallery_show = 'true';
			$tagline_show = 'true';
			$location_show = 'true';
			$website_show = 'true';
			$social_show = 'true';
			$faqs_show = 'true';
			$price_show = 'true';
			$tags_show = 'true';
			$hours_show = 'true';
		}
		
		$showReport = true;
		if( isset($listingpro_options['lp_detail_page_report_button']) ){
			if( $listingpro_options['lp_detail_page_report_button']=='off' ){
				$showReport = false;
			}
		}

		$claim = '';
		if($claimed_section == 'claimed') {
			$claim = '<span class="claimed"><i class="fa fa-check"></i> '. esc_html__('Claimed', 'listingpro').'</span>';

		}elseif($claimed_section == 'not_claimed') {
			$claim = '';

		}
		global $post;
		
		$resurva_url = get_post_meta($post->ID, 'resurva_url', true);
		$menuOption = false;
		$menuTitle = '';
		$menuImg = '';
		$menuMeta = get_post_meta($post->ID, 'menu_listing', true);
		if(!empty($menuMeta)){
			$menuTitle = $menuMeta['menu-title'];
			$menuImg = $menuMeta['menu-img'];
			$menuOption = true;
		}
		
		$timekit = false;
		$timekit_booking = get_post_meta($post->ID, 'timekit_bookings', true);
		
		if(!empty($timekit_booking)){
			$timekit = true;
		}
		
		
		
		/* get user meta */
		$user_id=$post->post_author;
		$user_facebook = '';
		$user_linkedin = '';
		$user_clinkedin = '';
		$user_facebook = '';
		$user_instagram = '';
		$user_twitter = '';
		$user_pinterest = '';
		$user_cpinterest = '';

		$user_facebook = get_the_author_meta('facebook', $user_id);
		$user_google = get_the_author_meta('google', $user_id);
		$user_linkedin = get_the_author_meta('linkedin', $user_id);
		$user_instagram = get_the_author_meta('instagram', $user_id);
		$user_twitter = get_the_author_meta('twitter', $user_id);
		$user_pinterest = get_the_author_meta('pinterest', $user_id);
		/* get user meta */
		?>
		<!--==================================Section Open=================================-->
		<section class="aliceblue listing-second-view lp-detail-page-template-3">
			<!--=======Galerry=====-->
			<?php 
			$lp_detail_slider_styles = $listingpro_options['lp_detail_slider_styles'];
			$IDs = get_post_meta( $post->ID, 'gallery_image_ids', true );
			if($lp_detail_slider_styles == 'style1'){				
				if (!empty($IDs)) {
					if($gallery_show=="true"){
						$imgIDs = explode(',',$IDs);
						$numImages = count($imgIDs);
						if($numImages >= 1 ){ ?>
							<div class="pos-relative">
								<div class="spinner">
								  <div class="double-bounce1"></div>
								  <div class="double-bounce2"></div>
								</div>
								<div class="single-page-slider-container style1">
									<div class="row">
										<div class="">
											<div class="listing-slide img_<?php echo esc_attr($numImages); ?>" data-images-num="<?php echo esc_attr($numImages); ?>">
												<?php
													//$imgSize = 'listingpro-gal';
													require_once (THEME_PATH . "/include/aq_resizer.php");
													$imgSize = 'listingpro-detail_gallery';

													foreach($imgIDs as $imgID){
														
														if($numImages == 3){
															$img_url = wp_get_attachment_image_src( $imgID, 'full');
															$imgurl = aq_resize( $img_url[0], '550', '420', true, true, true);
															$imgSrc = $imgurl;
														}elseif($numImages == 2){
															$img_url = wp_get_attachment_image_src( $imgID, 'full');
															$imgurl = aq_resize( $img_url[0], '800', '400', true, true, true);
															$imgSrc = $imgurl;
														}elseif($numImages == 1){
															$img_url = wp_get_attachment_image_src( $imgID, 'full');
															$imgurl = aq_resize( $img_url[0], '1170', '400', true, true, true);
															$imgSrc = $imgurl;
														}elseif($numImages == 4){
															$img_url = wp_get_attachment_image_src( $imgID, 'full');
															$imgurl = aq_resize( $img_url[0], '400', '400', true, true, true);
															$imgSrc = $imgurl;
														}else {
															/* $imgurl = wp_get_attachment_image_src( $imgID, $imgSize);
															$imgSrc = $imgurl[0]; */
															$img_url = wp_get_attachment_image_src( $imgID, 'full');
															$imgurl = aq_resize( $img_url[0], '350', '450', true, true, true);
															$imgSrc = $imgurl;
														}
														$imgFull = wp_get_attachment_image_src( $imgID, 'full');
														if(!empty($imgurl[0])){
															echo '
															<div class="slide">
																<a href="'. $imgFull[0] .'" rel="prettyPhoto[gallery1]">
																	<img src="'. $imgSrc .'" alt="'.get_the_title().'" />
																</a>
															</div>';
														}
													}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						} else{
							$imgurl = wp_get_attachment_image_src( $imgIDs[0], 'listingpro-listing-gallery');
							$imgFull = wp_get_attachment_image_src( $imgID, 'full');
							if(!empty($imgurl[0])){
								echo '
								<div class="slide_ban text-center">
									<a href="'. $imgFull[0] .'" rel="prettyPhoto[gallery1]">
										<img src="'. $imgurl[0] .'" alt="'.get_the_title().'" />
									</a>
								</div>';
							}
						}
					}
				}
			} else if($lp_detail_slider_styles == 'style2') {
				if (!empty($IDs)) {
					if($gallery_show=="true"){
						$imgIDs = explode(',',$IDs);
						$numImages = count($imgIDs);
						if($numImages >= 1 ){ ?>
							<div class="pos-relative">
								<div class="spinner">
								  <div class="double-bounce1"></div>
								  <div class="double-bounce2"></div>
								</div>
								<div class="single-page-slider-container style2">
									<div class="row">
										<div class="">
											<div class="listing-slide img_<?php echo esc_attr($numImages); ?>" data-images-num="<?php echo esc_attr($numImages); ?>">
												<?php
													$slider_height = $listingpro_options['slider_height'];
													//$imgSize = 'listingpro-gal';
													require_once (THEME_PATH . "/include/aq_resizer.php");
													$imgSize = 'listingpro-detail_gallery';
													foreach($imgIDs as $imgID){
														$img_url = wp_get_attachment_image_src( $imgID, 'full');
														$imgSrc = $img_url;
														$imgFull = wp_get_attachment_image_src( $imgID, 'full');
														$gstyle= 'style="height:'.$slider_height.'px;object-fit: cover"';
														if(!empty($img_url[0])){
															echo '
															<div class="slide">
																<a href="'. $imgFull[0] .'" rel="prettyPhoto[gallery1]">
																	<img '.$gstyle.' src="'. $img_url[0] .'" alt="'.get_the_title().'" />
																</a>
															</div>';
														}
													}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php
						}
						else{
							$imgurl = wp_get_attachment_image_src( $imgIDs[0], 'listingpro-listing-gallery');
							$imgFull = wp_get_attachment_image_src( $imgID, 'full');
							if(!empty($imgurl[0])){
								echo '
								<div class="slide_ban text-center">
									<a href="'. $imgFull[0] .'" rel="prettyPhoto[gallery1]">
										<img src="'. $imgurl[0] .'" alt="'.get_the_title().'" />
									</a>
								</div>';
							}
						}
					}
				}					
			}
			?>
			<div class="post-meta-info">
				<div class="container">
					<div class="row">
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="post-meta-left-box">
								<?php if (function_exists('listingpro_breadcrumbs')) listingpro_breadcrumbs(); ?>
								<h1><?php the_title(); ?> <?php echo $claim; ?></h1>
								<?php if(!empty($tagline_text)) {
											if($tagline_show=="true"){?>
											<p><?php echo $tagline_text; ?></p>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="post-meta-right-box text-right clearfix margin-top-20">
								<ul class="post-stat">
									<?php
                                        $favrt  =   listingpro_is_favourite_new(get_the_ID());
                                     ?>
									<li id="fav-container">
										<a class="email-address <?php if($favrt == 'yes'){echo 'remove-fav';}else{echo 'add-to-fav';} ?>" data-post-type="detail" href="" data-post-id="<?php echo get_the_ID(); ?>" data-success-text="<?php echo esc_html__('Saved', 'listingpro') ?>">
											<i class="fa <?php echo listingpro_is_favourite(get_the_ID(),$onlyicon=true); ?>"></i>
											<span class="email-icon">
												<?php echo listingpro_is_favourite(get_the_ID(),$onlyicon=false); ?>
											</span>
											 										
										</a>
									</li>
									<li class="reviews sbutton">
										<?php listingpro_sharing(); ?>
									</li>
								</ul>
								<div class="padding-top-30">
								<span class="rating-section">
									<?php
										$NumberRating = listingpro_ratings_numbers($post->ID);
										if($NumberRating != 0){
											echo lp_cal_listing_rate(get_the_ID());											
									?>
											<span>
												<small><?php echo $NumberRating; ?></small>
												<br> 
												<?php echo esc_html__('Ratings', 'listingpro'); ?>
											</span>
									<?php		
										}else{
											echo lp_cal_listing_rate(get_the_ID());
										}
									?>
								</span>
									<?php if(!empty($resurva_url)){ ?>
											<a href="" class="secondary-btn make-reservation">
												<i class="fa fa-calendar-check-o"></i>
												<?php echo esc_html__('Book Now', 'listingpro'); ?>
											</a>
											<div class="ifram-reservation">
												<div class="inner-reservations">
													<a href="#" class="close-btn"><i class="fa fa-times"></i></a>
													<iframe src="<?php echo esc_url($resurva_url); ?>" name="resurva-frame" frameborder="0"></iframe>
												</div>
											</div>
									<?php }else{
												if (class_exists('ListingReviews')) {
													$allowedReviews = $listingpro_options['lp_review_switch'];
													if(!empty($allowedReviews) && $allowedReviews=="1"){
														if(get_post_status($post->ID)=="publish"){
														
											?>
													<a href="#" class="secondary-btn" id="clicktoreview2">
														<i class="fa fa-star"></i>
														<?php echo esc_html__('Submit Review', 'listingpro'); ?>
													</a>
											<?php
													}
													}
												}
											}
									?>
									
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content-white-area">
				
				<div class="container single-inner-container single_listing" >
					<?php if( isset($listingpro_options['lp-gads-editor']) ){
							$listingGAdsense = $listingpro_options['lp-gads-editor'];
							if( !empty($listingGAdsense) ){ ?>
								
								<div class="row padding-bottom-30">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<?php echo $listingGAdsense; ?>
									</div>
								</div>
								
							<?php }
						} ?>
					<div class="row">
						<div class="col-md-8 col-sm-8 col-xs-12">
							
							
							<div class="single-tabber2 margin-bottom-30" id="reply-title2">
								
								<ul class="row list-style-none clearfix" data-tabs="tabs">
									<?php
										$pagecontentOption = $listingpro_options['lp-detail-page-layout2-content']['general'];
										if ($pagecontentOption):
											foreach ($pagecontentOption as $key=>$value) {
										
												switch($key) {
											
													case 'lp_content_section': ?>
														<li class="">
															<a href="#adinfo" data-toggle="tab">
																<?php echo esc_html__( 'Details', 'listingpro' );?>
															</a>
														</li>
													<?php
													break;
													
													case 'lp_video_section': ?>
														<li class="">
															<a href="#video" data-toggle="tab">
																<?php echo esc_html__( 'Video', 'listingpro' );?>
															</a>
														</li>
													<?php
													break;
													
													case 'lp_faqs_section': ?>
														<li class="">
															<a href="#faqs" data-toggle="tab">
																<?php echo esc_html__( 'FAQs', 'listingpro' );?>
															</a>
														</li>
													<?php
													break;
													
													case 'lp_reviews_section': ?>
														<li class="lpreviews">
															<a href="#reviews" data-toggle="tab">
																<?php echo esc_html__( 'Reviews ', 'listingpro' );?>
															</a>
														</li>
													<?php
													break;
													
													case 'lp_contacts_section': ?>
														<li class="">
															<a href="#contact" data-toggle="tab">
																<?php echo esc_html__( 'Contact Info', 'listingpro' );?>
															</a>
														</li>
													<?php
													break;
													
													
												}
												
											}
										endif;
									?>
								</ul>
								
							</div>	
							<div class="detail-page2-tab-content">
								<div class="tab-content">
									<?php
										$pagecontentOption = $listingpro_options['lp-detail-page-layout2-content']['general'];
										if ($pagecontentOption):
											foreach ($pagecontentOption as $key=>$value) {
										
												switch($key) {
											
													case 'lp_content_section': ?>
														<!--adinfo-->
														<?php get_template_part('templates/single-list/listing-details-style2/content/adinfo'); ?>
													<?php
													break;
													
													case 'lp_video_section': ?>
														<!--video-->
														<?php get_template_part('templates/single-list/listing-details-style2/content/video'); ?>
													<?php
													break;
													
													case 'lp_faqs_section': ?>
														<!--faq-->
														<?php get_template_part('templates/single-list/listing-details-style2/content/faqs'); ?>
													<?php
													break;
													
													case 'lp_reviews_section': ?>
														<!--reviews-->
														<?php get_template_part('templates/single-list/listing-details-style2/content/reviews'); ?>
													<?php
													break;
													
													case 'lp_contacts_section': ?>
														<!--contacts-->
														<?php get_template_part('templates/single-list/listing-details-style2/content/contacts'); ?>
													<?php
													break;
													
												}
												
											}
										endif;
									?>
									
								</div>
								
							</div>
							<div class="clearfix"></div>
							
						</div>
						
						<div class="col-md-4 col-sm-4 col-xs-12">
							<?php
								$pagesidebrOption = $listingpro_options['lp-detail-page-layout2-rsidebar']['sidebar'];
								if ($pagesidebrOption):
									foreach ($pagesidebrOption as $key=>$value) {
										
										switch($key) {
											
											case 'lp_timing_section': get_template_part( 'templates/single-list/listing-details-style2/sidebar/timings' );
											break;
											
											case 'lp_mapsocial_section': get_template_part( 'templates/single-list/listing-details-style2/sidebar/map-contacts' );
											break;
											
											case 'lp_quicks_section': get_template_part( 'templates/single-list/listing-details-style2/sidebar/quicks' );
											break;
											
											case 'lp_additional_section': get_template_part( 'templates/single-list/listing-details-style2/sidebar/additional' );
											break;
											
											case 'lp_sidebarelemnts_section': get_template_part( 'templates/single-list/listing-details-style2/sidebar/def-sidebar' );
											break;
											
											
										}
									}
								endif;	
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--==================================Section Close=================================-->
		<?php 
		global $post;
		echo listingpro_post_confirmation($post);
	} // end while
}