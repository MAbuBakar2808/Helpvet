	<?php
			$output = null;
			
			$favrt  =   listingpro_is_favourite_new(get_the_ID());
			
			global $listingpro_options;
			$lp_review_switch = $listingpro_options['lp_review_switch'];

			if(!isset($postGridCount)){
				$postGridCount = '0';
			}
			global $postGridCount;			
			$postGridCount++;
			
			$listing_style = '';
				$listing_style = $listingpro_options['listing_style'];
				if(isset($_GET['list-style']) && !empty($_GET['list-style'])){
					$listing_style = esc_html($_GET['list-style']);
				}
				if(is_front_page()){
					$listing_style = 'col-md-4 col-sm-6';
					$postGridnumber = 3;
				}else{
					if($listing_style == '1'){
						$listing_style = 'col-md-4 col-sm-6';
						$postGridnumber = 3;
					}elseif($listing_style == '3' && !is_page()){
						$listing_style = 'col-md-6 col-sm-12';
						$postGridnumber = 2;
					}else{
						$listing_style = 'col-md-4 col-sm-6';
						$postGridnumber =3;
					}
				}
				if(is_page_template('template-favourites.php')){
					$listing_style = 'col-md-4 col-sm-6';
					$postGridnumber =3;
				}
				$latitude = listing_get_metabox('latitude');
				$longitude = listing_get_metabox('longitude');
				$gAddress = listing_get_metabox('gAddress');
				if(!empty($latitude)){
					$latitude = str_replace(",",".",$latitude);
				}
				if(!empty($longitude)){
					$longitude = str_replace(",",".",$longitude);
				}
				$isfavouriteicon = listingpro_is_favourite_grids(get_the_ID(),$onlyicon=true);
				$isfavouritetext = listingpro_is_favourite_grids(get_the_ID(),$onlyicon=false);

				$adStatus = get_post_meta( get_the_ID(), 'campaign_status', true );
				$CHeckAd = '';
				$adClass = '';
				if($adStatus == 'active'){
					$CHeckAd = '<span class="listing-pro">'.esc_html__('Ad','listingpro').'</span>';
					$adClass = 'promoted';
				}
				$claimed_section = listing_get_metabox('claimed_section');

				$claim = '';
				$claimStatus = '';
				
				$deafaultFeatImg = lp_default_featured_image_listing();
				
				if($claimed_section == 'claimed') {
					if(is_singular( 'listing' ) ){
						$claimStatus = esc_html__('Claimed', 'listingpro');
					}
					$claim = '<span class="verified simptip-position-top simptip-movable" data-tooltip="'. esc_html__('Claimed', 'listingpro').'"><i class="fa fa-check"></i> '.$claimStatus.'</span>';

				}elseif($claimed_section == 'not_claimed') {
					$claim = '';

				}
				$listing_layout = $listingpro_options['listing_views'];
				if( isset( $GLOBALS['listing_layout_element'] ) && !empty( $GLOBALS['listing_layout_element'] ) && $GLOBALS['listing_layout_element'] != '' ){
					$listing_layout = $GLOBALS['listing_layout_element'];
				}
				if( $listing_layout == 'grid_view' ) {
					?>							
					<div class="<?php echo esc_attr($listing_style); ?> <?php echo esc_attr($adClass); ?> lp-grid-box-contianer grid_view2 card1 lp-grid-box-contianer1" data-title="<?php echo get_the_title(); ?>" data-postid="<?php echo get_the_ID(); ?>"   data-lattitue="<?php echo esc_attr($latitude); ?>" data-longitute="<?php echo esc_attr($longitude); ?>" data-posturl="<?php echo get_the_permalink(); ?>">
						<?php if(is_page_template('template-favourites.php')){ ?>
							<div class="remove-fav md-close" data-post-id="<?php echo get_the_ID(); ?>">
								<i class="fa fa-close"></i>
							</div>
						<?php } ?>
						<div class="lp-grid-box">
							<div class="lp-grid-box-thumb-container" >
								<div class="lp-grid-box-thumb">
									<div class="show-img">
										<?php
											if ( has_post_thumbnail()) {
												$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'listingpro-blog-grid' );
													if(!empty($image[0])){
														echo "<a href='".get_the_permalink()."' >
																<img src='" . $image[0] . "' />
															</a>";
													}else {
														echo '
														<a href="'.get_the_permalink().'" >
															<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro').'" alt="">
														</a>';
													}	
											}elseif(!empty($deafaultFeatImg)){
												echo "<a href='".get_the_permalink()."' >
													<img src='" . $deafaultFeatImg . "' />
												</a>";
											}else {
												echo '
												<a href="'.get_the_permalink().'" >
													<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro').'" alt="">
												</a>';
											}
										?>
									</div>
									<div class="hide-img listingpro-list-thumb">
										<?php
											if ( has_post_thumbnail()) {
												$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'listingpro-blog-grid' );
													if(!empty($image[0])){
														echo "<a href='".get_the_permalink()."' >
																<img src='" . $image[0] . "' />
															</a>";
													}else {
														echo '
														<a href="'.get_the_permalink().'" >
															<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro').'" alt="">
														</a>';
													}	
											}elseif(!empty($deafaultFeatImg)){
												echo "<a href='".get_the_permalink()."' >
													<img src='" . $deafaultFeatImg . "' />
												</a>";
											}else {
												echo '
												<a href="'.get_the_permalink().'" >
													<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro').'" alt="">
												</a>';
											}
										?>
									</div>
							   	</div>
								<div class="lp-grid-box-quick">
									<ul class="lp-post-quick-links">
										<li>
											<a href="#" data-post-type="grids" data-post-id="<?php echo esc_attr(get_the_ID()); ?>" data-success-text="<?php echo esc_html__('Saved', 'listingpro') ?>" class="status-btn <?php if($favrt == 'yes'){echo 'remove-fav';}else{echo 'add-to-fav';} ?> lp-add-to-fav">
												<i class="fa <?php echo esc_attr($isfavouriteicon); ?>"></i> <span><?php echo $isfavouritetext; ?></span>
											</a>
										</li>
										<li>
											<a class="icon-quick-eye md-trigger qickpopup" data-modal="modal-126"><i class="fa fa-eye"></i> <?php echo esc_html__('Preview', 'listingpro'); ?></a>
										</li>
									</ul>
								</div>
							</div>
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
											<?php
											if($lp_review_switch==1){ ?>
											<li>
												<?php
													$NumberRating = listingpro_ratings_numbers($post->ID);
													if($NumberRating != 0){
														if($NumberRating <= 1){
															$review = esc_html__('Rating', 'listingpro');
														}else{
															$review = esc_html__('Ratings', 'listingpro');
														}
														echo lp_cal_listing_rate(get_the_ID());											
												?>
														<span>
															<?php echo $NumberRating; ?>
															<?php echo $review; ?>
														</span>
												<?php		
													}else{
														echo lp_cal_listing_rate(get_the_ID());
													}
												?>
											</li>
											<?php } ?>
											<li class="middle">
												<?php echo listingpro_price_dynesty_text($post->ID); ?>
											</li>
											<li>
												<?php
													$cats = get_the_terms( get_the_ID(), 'listing-category' );
													if(!empty($cats)){
														$catCount = 1;
														foreach ( $cats as $cat ) {
															if($catCount==1){
																$category_image = listing_get_tax_meta($cat->term_id,'category','image');
																if(!empty($category_image)){
																	echo '<span class="cat-icon"><img class="icon icons8-Food" src="'.$category_image.'" alt="cat-icon"></span>';
																}
																$term_link = get_term_link( $cat );
																echo '
																<a href="'.$term_link.'">
																	'.$cat->name.'
																</a>';
																$catCount++;
															}
															
														}
													}
												?>
											</li>
										</ul>
										<?php echo listingpro_last_review_by_list_ID(get_the_ID()); ?>
									</div>
									<div class="lp-grid-box-right pull-right">
									</div>
								</div>
								<?php
								$openStatus = listingpro_check_time(get_the_ID());
								$cats = get_the_terms( get_the_ID(), 'location' );
								if(!empty($openStatus) || !empty($cats)){
								?>
									<div class="lp-grid-box-bottom">
										<div class="pull-left">
											<div class="show">
												<?php
													$countlocs = 1;
													$cats = get_the_terms( get_the_ID(), 'location' );
													if(!empty($cats)){
														echo '<span class="cat-icon">'.listingpro_icons('mapMarkerGrey').'</span>';
														foreach ( $cats as $cat ) {
															if($countlocs==1){
																$term_link = get_term_link( $cat );
																echo '
																<a href="'.$term_link.'">
																	'.$cat->name.'
																</a>';
															}
															$countlocs ++;
														}
													}
													
												?>
											</div>
											<?php if(!empty($gAddress)) { ?>
												<div class="hide">
													<span class="cat-icon">
														<?php echo listingpro_icons('mapMarkerGrey'); ?>
													</span>
													<span class="text gaddress"><?php echo substr($gAddress, 0, 30); ?>...</span>
												</div>
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
								
								<?php } ?>
							</div>
						</div>
					</div>
					<?php
				}elseif( $listing_layout == 'grid_view2' ) {
					?>
				<div class="<?php echo esc_attr($listing_style); ?> <?php echo esc_attr($adClass); ?> lp-grid-box-contianer grid_view2 card1 lp-grid-box-contianer1 listing-grid-view2-outer" data-title="<?php echo get_the_title(); ?>" data-postid="<?php echo get_the_ID(); ?>"   data-lattitue="<?php echo esc_attr($latitude); ?>" data-longitute="<?php echo esc_attr($longitude); ?>" data-posturl="<?php echo get_the_permalink(); ?>">
						<?php if(is_page_template('template-favourites.php')){ ?>
							<div class="remove-fav md-close" data-post-id="<?php echo get_the_ID(); ?>">
								<i class="fa fa-close"></i>
							</div>
						<?php } ?>
						<div class="lp-grid-box">
							<div class="lp-grid-box-thumb-container" >
								<div class="lp-grid-box-thumb">
									<div class="show-img">
										<?php
											if ( has_post_thumbnail()) {
												$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'listingpro-blog-grid2' );
													if(!empty($image[0])){
														echo "<a href='".get_the_permalink()."' >
																<img src='" . $image[0] . "' />
															</a>";
													}else {
														echo '
														<a href="'.get_the_permalink().'" >
															<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=400', 'listingpro').'" alt="">
														</a>';
													}	
											}elseif(!empty($deafaultFeatImg)){
												echo "<a href='".get_the_permalink()."' >
													<img src='" . $deafaultFeatImg . "' />
												</a>";
											}else {
												echo '
												<a href="'.get_the_permalink().'" >
													<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=400', 'listingpro').'" alt="">
												</a>';
											}
										?>
									</div>
									<div class="hide-img listingpro-list-thumb">
										<?php
											if ( has_post_thumbnail()) {
												$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'listingpro-blog-grid' );
													if(!empty($image[0])){
														echo "<a href='".get_the_permalink()."' >
																<img src='" . $image[0] . "' />
															</a>";
													}else {
														echo '
														<a href="'.get_the_permalink().'" >
															<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro').'" alt="">
														</a>';
													}	
											}elseif(!empty($deafaultFeatImg)){
												echo "<a href='".get_the_permalink()."' >
													<img src='" . $deafaultFeatImg . "' />
												</a>";
											}else {
												echo '
												<a href="'.get_the_permalink().'" >
													<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro').'" alt="">
												</a>';
											}
										?>
									</div>
							   	</div>
								<div class="lp-grid-box-quick">
									<ul class="lp-post-quick-links clearfix">
										<li class="pull-left">
											<a href="#" data-post-type="grids" data-post-id="<?php echo esc_attr(get_the_ID()); ?>" data-success-text="<?php echo esc_html__('Saved', 'listingpro') ?>" class="status-btn <?php if($favrt == 'yes'){echo 'remove-fav';}else{echo 'add-to-fav';} ?> lp-add-to-fav">
												<i class="fa <?php echo esc_attr($isfavouriteicon); ?>"></i> <span><?php echo $isfavouritetext; ?></span>
											</a>
										</li>
										
									</ul>
								</div>
							</div>
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
											<?php
											if($lp_review_switch==1){ ?>
											<li>
												<?php
													$NumberRating = listingpro_ratings_numbers($post->ID);
													if($NumberRating != 0){
														if($NumberRating <= 1){
															$review = esc_html__('Rating', 'listingpro');
														}else{
															$review = esc_html__('Ratings', 'listingpro');
														}
														echo lp_cal_listing_rate(get_the_ID());											
												?>
														<span>
															<?php echo $NumberRating; ?>
															<?php echo $review; ?>
														</span>
												<?php		
													}else{
														echo lp_cal_listing_rate(get_the_ID());
													}
												?>
											</li>
											<?php } ?>
											
											<li>
												<?php
													$cats = get_the_terms( get_the_ID(), 'listing-category' );
													if(!empty($cats)){
														$catCount = 1;
														foreach ( $cats as $cat ) {
															if($catCount==1){
																$category_image = listing_get_tax_meta($cat->term_id,'category','image');
																if(!empty($category_image)){
																	echo '<span class="cat-icon"><img class="icon icons8-Food" src="'.$category_image.'" alt="cat-icon"></span>';
																}
																$term_link = get_term_link( $cat );
																echo '
																<a href="'.$term_link.'">
																	'.$cat->name.'
																</a>';
																$catCount++;
															}
															
														}
													}
												?>
											</li>
										</ul>
										<div class="clearfix"></div>
										<p class="description-container"><?php echo substr(strip_tags(get_the_content()),0,100) ?></p>
									</div>
									<div class="lp-grid-box-right pull-right">
									</div>
								</div>
								<?php
								$openStatus = listingpro_check_time(get_the_ID());
								$cats = get_the_terms( get_the_ID(), 'location' );
								if(!empty($openStatus) || !empty($cats)){
								?>
									<div class="lp-grid-box-bottom">
										<div class="pull-left">
											<div class="show">
												<?php
													$countlocs = 1;
													$cats = get_the_terms( get_the_ID(), 'location' );
													if(!empty($cats)){
														echo '<span class="cat-icon">'.listingpro_icons('mapMarkerGrey').'</span>';
														foreach ( $cats as $cat ) {
															if($countlocs==1){
																$term_link = get_term_link( $cat );
																echo '
																<a href="'.$term_link.'">
																	'.$cat->name.'
																</a>';
															}
															$countlocs ++;
														}
													}
													
												?>
											</div>
											<?php if(!empty($gAddress)) { ?>
												<div class="hide">
													<span class="cat-icon">
														<?php echo listingpro_icons('mapMarkerGrey'); ?>
													</span>
													<span class="text gaddress"><?php echo substr($gAddress, 0, 30); ?>...</span>
												</div>
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
								
								<?php } ?>
							</div>
						</div>
				</div>	
					
				<?php
				}elseif( $listing_layout == 'list_view' ) {
					?>
					<div class="col-md-12 lp-grid-box-contianer list_view card1 lp-grid-box-contianer1 <?php echo esc_attr($adClass); ?>" data-title="<?php echo get_the_title(); ?>" data-postid="<?php echo get_the_ID(); ?>"   data-lattitue="<?php echo esc_attr($latitude); ?>" data-longitute="<?php echo esc_attr($longitude); ?>" data-posturl="<?php echo get_the_permalink(); ?>">
						<?php if(is_page_template('template-favourites.php')){ ?>
							<div class="remove-fav md-close" data-post-id="<?php echo get_the_ID(); ?>">
								<i class="fa fa-close"></i>
							</div>
						<?php } ?>
						<div class="lp-grid-box lp-border lp-border-radius-8">
							<div class="lp-grid-box-thumb-container" >
								<div class="lp-grid-box-thumb">
									<div class="show">
										<?php 
											if ( has_post_thumbnail()) {
												$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'listingpro-blog-grid' );
													if(!empty($image[0])){
														echo "<a href='".get_the_permalink()."' >
																<img src='" . $image[0] . "' />
															</a>";
													}else {
														echo '
														<a href="'.get_the_permalink().'" >
															<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro').'" alt="">
														</a>';
													}	
											}elseif(!empty($deafaultFeatImg)){
												echo "<a href='".get_the_permalink()."' >
													<img src='" . $deafaultFeatImg . "' />
												</a>";
											}else {
												echo '
												<a href="'.get_the_permalink().'" >
													<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro').'" alt="">
												</a>';
											}
										?>
									</div>
									<div class="hide">
										<?php
											if ( has_post_thumbnail()) {
												$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'listingpro-blog-grid' );
													if(!empty($image[0])){
														echo "<a href='".get_the_permalink()."' >
																<img src='" . $image[0] . "' />
															</a>";
													}else {
														echo '
														<a href="'.get_the_permalink().'" >
															<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro').'" alt="">
														</a>';
													}	
											}elseif(!empty($deafaultFeatImg)){
												echo "<a href='".get_the_permalink()."' >
													<img src='" . $deafaultFeatImg . "' />
												</a>";
											}else {
												echo '
												<a href="'.get_the_permalink().'" >
													<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=240', 'listingpro').'" alt="">
												</a>';
											}
										?>
									</div>
							   	</div><!-- ../grid-box-thumb -->
								<div class="lp-grid-box-quick">
									<ul class="lp-post-quick-links">
										<li>
											<a href="#" data-post-type="grids" data-post-id="<?php echo esc_attr(get_the_ID()); ?>" data-success-text="<?php echo esc_html__('Saved', 'listingpro') ?>" class="status-btn <?php if($favrt == 'yes'){echo 'remove-fav';}else{echo 'add-to-fav';} ?> lp-add-to-fav">
												<i class="fa <?php echo esc_attr($isfavouriteicon); ?>"></i> <span><?php echo $isfavouritetext; ?></span>
											</a>
										</li>
										<li>
											<a class="icon-quick-eye md-trigger qickpopup" data-modal="modal-1<?php echo esc_attr(get_the_ID()); ?>"><i class="fa fa-eye"></i> <?php echo esc_html__('Preview', 'listingpro'); ?></a>
										</li>
									</ul>
								</div><!-- ../grid-box-quick-->
							</div>
							<div class="lp-grid-box-description ">
								<div class="lp-grid-box-left pull-left">
									<h4 class="lp-h4">
										<a href="<?php echo esc_url(get_the_permalink()); ?>">
											<?php echo $CHeckAd; ?>
											<!--<span class="listing-pro">Ad</span>-->
											<?php echo get_the_title(); ?>
											<?php echo $claim; ?>
										</a>
									</h4>
									<ul>
									<?php
									if($lp_review_switch==1){ ?>
										<li>
											<?php
												$NumberRating = listingpro_ratings_numbers($post->ID);
												if($NumberRating != 0){
													if($NumberRating <= 1){
														$review = esc_html__('Rating', 'listingpro');
													}else{
														$review = esc_html__('Ratings', 'listingpro');
													}
													echo lp_cal_listing_rate(get_the_ID());											
											?>
													<span>
														<?php echo $NumberRating; ?>
														<?php echo $review; ?>
													</span>
											<?php		
												}else{
													echo lp_cal_listing_rate(get_the_ID());
												}
											?>
										</li>
										<?php
											}
										?>
										<li class="middle">
											<?php echo listingpro_price_dynesty_text($post->ID); ?>
										</li>
										<li>
											<?php
												$cats = get_the_terms( get_the_ID(), 'listing-category' );
												if(!empty($cats)){
													$catCount = 1;
													foreach ( $cats as $cat ) {
														if($catCount==1 && $cat->parent==0){
															$category_image = listing_get_tax_meta($cat->term_id,'category','image');
															if(!empty($category_image)){
																echo '<span class="cat-icon"><img class="icon icons8-Food" src="'.$category_image.'" alt="cat-icon"></span>';
															}
															$term_link = get_term_link( $cat );
															echo '
															<a href="'.$term_link.'">
																'.$cat->name.'
															</a>';
															$catCount++;
														}
													}
												}
											?>
										</li>
									</ul>
									<?php echo listingpro_last_review_by_list_ID(get_the_ID()); ?>
								</div>
								<div class="lp-grid-box-right pull-right">
								</div>
							</div>
							<?php
								$openStatus = listingpro_check_time(get_the_ID());
								$cats = get_the_terms( get_the_ID(), 'location' );
								if(!empty($openStatus) || !empty($cats)){
							?>
									<div class="lp-grid-box-bottom">
										<div class="pull-left">
											<div class="show">
												<?php
													$countlocs = 1;
													$cats = get_the_terms( get_the_ID(), 'location' );
													if(!empty($cats)){
														echo '<span class="cat-icon">'.listingpro_icons('mapMarkerGrey').'</span>';
														foreach ( $cats as $cat ) {
															if($countlocs == 1){
																$term_link = get_term_link( $cat );
																echo '
																<a href="'.$term_link.'">
																	'.$cat->name.'
																</a>';
															}
															$countlocs ++;
														}
													}
													
												?>
											</div>
											<?php if(!empty($gAddress)) { ?>
												<div class="hide">
													<span class="cat-icon">
														<img class="icon icons8-Food" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAABv0lEQVRoge1ZUbGDMBA8CUhAAhKQUAlIqILsOkBCJSABCUhAAhJ4Hw1vGB4tB82R9A07c7+Z3dxmuQSRCxcuBAPJwjlHAC2ADsDgqwfQOOdIsojN8w9Ilp7wqKyOZBWbt5AsdhJfExKnI37Xhw/ITzWQLL+V/G+dJoJkHpr8rBP2dsIzYUKTn6o3JU/yZkh+xNNKlZkAfJY42hpMyPvI1JJoSZYkC5K571y7owt5cAH+C6shUJPM1tYAUGvWcM4xuAAAjXLnV8nP1tF0orUQ0Ctaf9taRxkE4c+BUkCuEJDFErD58QooYLQQsBmhSguVCgGdhQBNgmwePijDILgAbYy+i0CSd80aAOrgAnaOEd00XZLMvG00Oz8CRuOE9vCFKJMvsYgIgMcJAhoT8iIiJKsTdr+yFGBto8HMPhNga6OHKXkR0y6cc6UUMetC+Ox/BYMu2Ht/CSgvJ8nt/gTfhT4A+X7rEmQpQjNZvi3NBGsK7JhxkrDOEt5KR17q4llniSNWim6dJbAvleJbZw1QPpkkY50lFNGaju9fwT+/r5E//0fGUawd6uQO7Rbmd2iS99h8DsG/QqSZOBcu/BP8AL+XHO7G8elbAAAAAElFTkSuQmCC" alt="cat-icon">
													</span>
													<span class="text gaddress"><?php echo $gAddress; ?></span>
												</div>
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
									
								<?php } ?>
						</div>
					</div>
					<?php
					}
					?>
					<?php //get_template_part('templates/preview'); ?>
								 
				<?php 
					if($postGridCount%$postGridnumber == 0){
						echo '<div class="clearfix"></div>';
					}
				?>


							
							