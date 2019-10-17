<?php
	$phone = listing_get_metabox('phone');
	$gAddress = listing_get_metabox('gAddress');

	$rating = get_post_meta( get_the_ID(), 'listing_rate', true );
	$rate = $rating;
	$adStatus = get_post_meta( get_the_ID(), 'campaign_status', true );
	$CHeckAd = '';
	if($adStatus == 'active'){
		$CHeckAd = '<span class="listing-pro">'.esc_html__('Ad','listingpro').'</span>';
	}
	$claimed_section = listing_get_metabox('claimed_section');

	$claim = '';
	if($claimed_section == 'claimed') {
		$claim = '<span class="verified simptip-position-top simptip-movable" data-tooltip="'. esc_html__('Claimed', 'listingpro').'"><i class="fa fa-check"></i> '. esc_html__('Claimed', 'listingpro').'</span>';

	}elseif($claimed_section == 'not_claimed') {
		$claim = '';

	}

	?>
	<div class="md-modal md-effect-3" id="modal-1<?php echo get_the_ID(); ?>">
		<div class="container">
			<div class="md-content ">
				<div class="row popup-inner-left-padding ">
					<div class="col-md-6 lp-insert-data">
						<div class="lp-grid-box-thumb">
							<?php
							if ( has_post_thumbnail()) {
								require_once (THEME_PATH . "/include/aq_resizer.php");
								$img_url = wp_get_attachment_image_src(get_post_thumbnail_id( get_the_ID()), 'full');
									if(!empty($img_url[0])){
										$imgurl = aq_resize( $img_url[0], '650', '300', true, true, true);
										$imgSrc = $imgurl;
										echo '
										<div class="slide">
											<img src="'. $imgSrc .'" alt="post1" />
										</div>';
									}else{
										echo '
										<a href="'.get_the_permalink().'" >
											<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=650&h=300', 'listingpro').'" alt="">
										</a>';
									}
										
							}else {
								echo '
								<a href="'.get_the_permalink().'" >
									<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=650&h=300', 'listingpro').'" alt="">
								</a>';
							}
							?>
						</div><!-- ../grid-box-thumb -->
						<div class="lp-grid-desc-container lp-border clearfix">
							<div class="lp-grid-box-description ">
								<div class="lp-grid-box-left pull-left">
									<h4 class="lp-h4">
										<a href="<?php echo get_the_permalink(); ?>">
											<?php echo $CHeckAd; ?>
											<?php echo substr(get_the_title(), 0, 40); ?>
											<?php echo $claim; ?>
										</a>
									</h4>
									<ul>
										<li>
											<?php if(!empty($rate)) { ?>
												<span class="rate"><?php echo $rate; ?><sup>/5</sup></span>
											<?php } ?>
											<?php echo listingpro_ratings_numbers(get_the_ID()).' '.esc_html__('Reviews', 'listingpro'); ?>
										</li>
										<li class="middle">
											<?php echo listingpro_price_dynesty_text($post->ID); ?>
										</li>
										<li>
											<?php
												$cats = get_the_terms( get_the_ID(), 'listing-category' );
												if(!empty($cats)){
													foreach ( $cats as $cat ) {
														$category_image = listing_get_tax_meta($cat->term_id,'category','image');
														if(!empty($category_image)){
															echo '<span class="cat-icon"><img class="icon icons8-Food" src="'.$category_image.'" alt="cat-icon"></span>';
														}
														$term_link = get_term_link( $cat );
														echo '
														<a href="'.$term_link.'">
															'.$cat->name.'
														</a>';
													}
												}
											?>
										</li>
										<?php if(!empty($phone)) { ?>
											<li>
												<a href="tel:<?php echo esc_attr($phone); ?>">
													<?php echo esc_html($phone); ?>
												</a>
											</li>
										<?php } ?>
									</ul>
									<div class="lp-grid-desc">
										<?php
											$quickcontent = get_the_content();
											$quickcontent = wp_filter_nohtml_kses($quickcontent);
										?>
										<p><?php echo esc_html(substr($quickcontent, 0, 230)); ?></p>
									</div>
								</div>
								<div class="lp-grid-box-right pull-right">
								</div>
							</div>
							<div class="lp-grid-box-bottom">
								<div class="pull-left">
									<?php if(!empty($gAddress)) { ?>
										<span class="cat-icon">
											<img class="icon icons8-Food" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAABv0lEQVRoge1ZUbGDMBA8CUhAAhKQUAlIqILsOkBCJSABCUhAAhJ4Hw1vGB4tB82R9A07c7+Z3dxmuQSRCxcuBAPJwjlHAC2ADsDgqwfQOOdIsojN8w9Ilp7wqKyOZBWbt5AsdhJfExKnI37Xhw/ITzWQLL+V/G+dJoJkHpr8rBP2dsIzYUKTn6o3JU/yZkh+xNNKlZkAfJY42hpMyPvI1JJoSZYkC5K571y7owt5cAH+C6shUJPM1tYAUGvWcM4xuAAAjXLnV8nP1tF0orUQ0Ctaf9taRxkE4c+BUkCuEJDFErD58QooYLQQsBmhSguVCgGdhQBNgmwePijDILgAbYy+i0CSd80aAOrgAnaOEd00XZLMvG00Oz8CRuOE9vCFKJMvsYgIgMcJAhoT8iIiJKsTdr+yFGBto8HMPhNga6OHKXkR0y6cc6UUMetC+Ox/BYMu2Ht/CSgvJ8nt/gTfhT4A+X7rEmQpQjNZvi3NBGsK7JhxkrDOEt5KR17q4llniSNWim6dJbAvleJbZw1QPpkkY50lFNGaju9fwT+/r5E//0fGUawd6uQO7Rbmd2iS99h8DsG/QqSZOBcu/BP8AL+XHO7G8elbAAAAAElFTkSuQmCC" alt="cat-icon">
										</span>
										<span class="text gaddress"><?php echo $gAddress; ?></span>
									<?php } ?>
								</div>
								<?php
									$openStatus = listingpro_check_time(get_the_ID());
									if(!empty($openStatus)){
										echo '
										<div class="pull-right">
											<a href="#" class="status-btn">';
												echo $openStatus;
												echo ' 
											</a>
										</div>';
									}
								?>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div id="quickmap<?php echo get_the_ID(); ?>" class="quickmap"></div>
						<a class="md-close widget-map-click"><i class="fa fa-close"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>