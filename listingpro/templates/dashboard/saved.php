<div class="user-recent-listings-inner tab-pane fade in active lp-saved-listing-tab" id="pending">
	<div class="tab-header">
		<h3><?php echo esc_html__('Saved Listings', 'listingpro'); ?></h3>
	</div>
	<div class="row lp-list-page-list">
		<?php
		global $paged, $wp_query, $listingpro_options;
		$fav = getSaved();
		if(!empty($fav)) {
			$args=array(
				'post_type' => 'listing',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'post__in' => $fav,	
				'paged' => $paged,
			);
			
			$deafaultFeatImg = lp_default_featured_image_listing();
			$wp_query = null;
			$wp_query = new WP_Query($args);
			if( $wp_query->have_posts() ) {
				while ($wp_query->have_posts()) : $wp_query->the_post();  
					$listingcurrency = listing_get_metabox('listingcurrency');
					$listingprice = listing_get_metabox('listingprice');
					$listingptext = listing_get_metabox('listingptext');
					$Plan_id = listing_get_metabox('Plan_id');
					$plan_time  = get_post_meta($Plan_id, 'plan_time', true);
					$listinviews = getPostViews(get_the_ID());
					global $wp_rewrite;
					$edit_post_page_id = $listingpro_options['edit-listing'];
					$postID = $post->ID;
					if ($wp_rewrite->permalink_structure == ''){
						//we are using ?page_id
						$edit_post = $edit_post_page_id."&lp_post=".$postID;
					}else{
						//we are using permalinks
						$edit_post = $edit_post_page_id."?lp_post=".$postID;
					}
					?>		
<div class="col-md-12 col-sm-6 col-xs-12 lp-list-view lp-grid-box-contianer">
						<div class="lp-list-view-inner-contianer clearfix">
							<div class="col-md-1 col-sm-1 col-xs-12">
								<div class="lp-list-view-thumb">
									<div class="lp-list-view-thumb-inner">
										<?php	
											if ( has_post_thumbnail()) {
												$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'thumbnail' );
												if(!empty($image[0])){
													echo "<a href='".get_the_permalink()."' >
															<img src='" . $image[0] . "' />
														</a>";
												}else {
													echo "<a href='".get_the_permalink()."' >
															<img src='".esc_url('https://placeholdit.imgix.net/~text?txtsize=22&txt=150%C3%97150&w=150&h=150')."' />
														</a>";
												}
											}elseif(!empty($deafaultFeatImg)){
											
												echo "<a href='".get_the_permalink()."' >
														<img src='".$deafaultFeatImg."' />
													</a>";
												
											}else {
												echo "<a href='".get_the_permalink()."' >
														<img src='".esc_url('https://placeholdit.imgix.net/~text?txtsize=22&txt=150%C3%97150&w=150&h=150')."' />
													</a>";
											}
										?>	
									</div>
								</div>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="lp-list-view-content lp-list-cnt">
									<div class="lp-list-view-content-upper lp-list-view-content-bottom">
										<a href="<?php echo get_the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
										<ul class="lp-grid-box-price list-style-none list-pt-display">
											<?php
												$cats = get_the_terms( get_the_ID(), 'listing-category' );
												if($cats){
													foreach ( $cats as $cat ) {
														$category_image = listing_get_tax_meta($cat->term_id,'category','image');
														if(!empty($category_image)){
															?>
															<li class="category-cion">
																<a href="<?php echo get_term_link($cat); ?>">
																	<img class="icon icons8-Food" src="<?php echo esc_attr($category_image); ?>" alt="cat-icon">
																</a>
															</li>
															<?php
														} ?>
														<li class="">
															<a href="<?php echo get_term_link($cat); ?>">
																<?php echo $cat->name; ?>
															</a>
														</li>
														<?php
													}
												}
											?>
											<li>
												<span><?php echo esc_html($listingcurrency.$listingprice); ?></span>
											</li>
											<li>
												<span class="lp-list-sp-icon">
													<i class="fa fa-calendar"></i>
												</span>
												<span class="lp-list-sp-text">
													<?php the_time( get_option( 'date_format' ) ); ?>
												</span>
											</li>
											<li>
												<span class="lp-list-sp-icon">
													<i class="fa fa-eye"></i>
												</span>
												<span class="lp-list-sp-text">
													<?php echo $listinviews; ?>
												</span>
											</li>
											<li>
												<span class="lp-list-sp-icon">
													<i class="fa fa-check"></i>
												</span>
												<span class="lp-list-sp-text">
												<?php 
													if(get_post_status() == 'publish'){
														echo esc_html__('Published','listingpro');
													}elseif(get_post_status() == 'pending'){
														echo 'Pending';
													}
												?>
												</span>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
								
							</div>
						</div>
						<div class="remove-fav md-close" data-post-id="<?php echo get_the_ID(); ?>">
							<i class="fa fa-times"></i>
							<span><?php echo esc_html__('Remove', 'listingpro'); ?></span>
						</div>
					</div>
					
					<?php			
				endwhile;
				echo listingpro_pagination();
			}else{
				?>
				<div class="text-center no-result-found col-md-12 col-sm-6 col-xs-12 margin-bottom-30">
					<h1><?php esc_html_e('Ooops!','listingpro'); ?></h1>
					<p><?php esc_html_e('Sorry ! You have no published Listing yet!','listingpro'); ?></p>
				</div>
				<?php
			}
		}
		else{	?>
				<div class="text-center no-result-found col-md-12 col-sm-6 col-xs-12 margin-bottom-30">
					<h1><?php esc_html_e('Ooops!','listingpro'); ?></h1>
					<p><?php esc_html_e('Sorry ! You have no saved Listing yet!','listingpro'); ?></p>
				</div>
				<?php
		}
		?>
	</div>
</div>
												