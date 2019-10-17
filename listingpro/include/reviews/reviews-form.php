<?php
if(!function_exists('listingpro_get_reviews_form')){
	function listingpro_get_reviews_form($postid){
		if (class_exists('ListingReviews')) {
			
			global $listingpro_options;
			$lp_Reviews_OPT = $listingpro_options['lp_review_submit_options'];
			$gSiteKey = '';
			$gSiteKey = $listingpro_options['lp_recaptcha_site_key'];
			$enableCaptcha = lp_check_receptcha('lp_recaptcha_reviews');
			
			if( is_user_logged_in() ){
				
				?>
				
					<div class="review-form" id="review-section">
						<h3 id="reply-title" class="comment-reply-title"><i class="fa fa-star-o"></i> <?php esc_html_e('Rate us and Write a Review','listingpro'); ?> <i class="fa fa-caret-down"></i></h3>
						<form id = "rewies_form" name = "rewies_form" action = "" method = "post" enctype="multipart/form-data">
							<div class = "col-md-6 padding-left-0">
								<div class="form-group margin-bottom-40">
									<p class="padding-bottom-15"><?php esc_html_e('Your Rating for this listing','listingpro'); ?></p>
									<div class="sfdfdf list-style-none form-review-stars">
										<input type="hidden" id="review-rating" name="rating" class="rating-tooltip" data-filled="fa fa-star fa-2x" data-empty="fa fa-star-o fa-2x" />
										<div class="review-emoticons">
											<div class="review angry"><?php echo listingpro_icons('angry'); ?></div>
											<div class="review cry"><?php echo listingpro_icons('crying'); ?></div>
											<div class="review sleeping"><?php echo listingpro_icons('sleeping'); ?></div>
											<div class="review smily"><?php echo listingpro_icons('smily'); ?></div>
											<div class="review cool"><?php echo listingpro_icons('cool'); ?></div>
										</div>
									</div>
								</div>
							</div>
							
							<div class = "col-md-6 pull-right padding-right-0">
								<div class="form-group submit-images">
									<label for = "post_gallery submit-images"><?php esc_html_e('Select Images','listingpro'); ?></label>
									<a href="#" class="browse-imgs"><?php esc_html_e('Browse','listingpro'); ?></a>
									<input type = "file" id = "filer_input2" name = "post_gallery[]" multiple="multiple"/>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group">
								<label for = "post_title"><?php esc_html_e('Title','listingpro'); ?></label>
								<input placeholder="<?php esc_html_e('Example: It was an awesome experience to be there','listingpro'); ?>" type = "text" id = "post_title" class="form-control" name = "post_title" />
							</div>
							<div class="form-group">
								<label for = "post_description"><?php esc_html_e('Review','listingpro'); ?></label>
								<textarea placeholder="<?php esc_html_e('Tip: A great review covers food, service, and ambiance. Got recommendations for your favorite dishes and drinks, or something everyone should try here? Include that too!','listingpro'); ?>" id = "post_description" class="form-control" rows="8" name = "post_description" ></textarea>
								<p><?php esc_html_e('Your review is recommended to be at least 140 characters long :)','listingpro'); ?></p>
							</div>
							<div class="form-group">
								<?php
									if($enableCaptcha==true){
										if ( class_exists( 'cridio_Recaptcha' ) ){ 
											if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) { 
											echo  '<div style="transform:scale(0.88);-webkit-transform:scale(0.88);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-'.get_the_ID().'" class="g-recaptcha" data-sitekey="'.$gSiteKey.'"></div>';
											}
										}
									}
								?>
							</div>
							<p class="form-submit post-reletive">
								<input name="submit_review" type="submit" id="submit" class="lp-review-btn btn-second-hover" value="<?php esc_html_e('Submit Review','listingpro'); ?>"> 
								<input type="hidden" name="comment_post_ID" value="<?php echo $postid; ?>" id="comment_post_ID">
								<input type="hidden" name="errormessage" value="<?php esc_html_e('Please fill Email, Title, Description and Rating', 'listingpro'); ?>">
								<span class="review_status"></span>
								<img class="loadinerSearch" width="100px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
							</p>
						</form>
					</div>
				<?php
			}
			else  { ?>
				<div class="review-form">
					<h3 id="reply-title" class="comment-reply-title"><i class="fa fa-star-o"></i><?php esc_html_e(' Rate us and Write a Review ','listingpro'); ?><i class="fa fa-caret-down"></i></h3>
					<?php
						if($lp_Reviews_OPT=="instant_sign_in"){
					?>
						<form id = "rewies_form" name = "rewies_form" action = "" method = "post" enctype="multipart/form-data">
					<?php
						}
						else{
					?>
						<form id = "rewies_formm" name = "rewies_form" action = "#" method = "post" enctype="multipart/form-data">
						
					<?php } ?>
					
						<div class = "col-md-6 padding-left-0">
							<div class="form-group margin-bottom-40">
								<p class="padding-bottom-15"><?php esc_html_e('Your Rating for this listing','listingpro'); ?></p>
								<div class="list-style-none form-review-stars">
									<input type="hidden" name="rating" class="rating-tooltip" data-filled="fa fa-star fa-2x" data-empty="fa fa-star-o fa-2x" />
									<div class="review-emoticons">
										<div class="review angry"><?php echo listingpro_icons('angry'); ?></div>
										<div class="review cry"><?php echo listingpro_icons('crying'); ?></div>
										<div class="review sleeping"><?php echo listingpro_icons('sleeping'); ?></div>
										<div class="review smily"><?php echo listingpro_icons('smily'); ?></div>
										<div class="review cool"><?php echo listingpro_icons('cool'); ?></div>
									</div>
								</div>
							</div>
						</div>
						<div class = "col-md-6 pull-right padding-right-0">
							<div class="form-group submit-images">
								<label for = "post_gallery submit-images"><?php esc_html_e('Select Images','listingpro'); ?></label>
								<a href="#" class="browse-imgs"><?php esc_html_e('Browse','listingpro'); ?></a>
								<input type = "file" id = "filer_input2" name = "post_gallery[]" multiple="multiple"/>
							</div>
						</div>
						<div class="clearfix"></div>
						<?php
							if($lp_Reviews_OPT=="instant_sign_in"){
						?>
							<div class="form-group">
								<label for = "u_mail"><?php esc_html_e('Email','listingpro'); ?></label>
								<input type = "email" placeholder="<?php esc_html_e('you@website.com','listingpro'); ?>" id = "u_mail" class="form-control" name = "u_mail" />
							</div>
							<?php } ?>
						<div class="form-group">
							<label for = "post_title"><?php esc_html_e('Title','listingpro'); ?></label>
							<input type = "text" placeholder="<?php esc_html_e('Example: It was an awesome experience to be there','listingpro'); ?>" id = "post_title" class="form-control" name = "post_title" />
						</div>
						<div class="form-group">
							<label for = "post_description"><?php esc_html_e('Review','listingpro'); ?></label>
							<textarea placeholder="<?php esc_html_e('Tip: A great review covers food, service, and ambiance. Got recommendations for your favorite dishes and drinks, or something everyone should try here? Include that too!','listingpro'); ?>" id = "post_description" class="form-control" rows="8" name = "post_description" ></textarea>
							<p><?php esc_html_e('Your review is recommended to be at least 140 characters long','listingpro'); ?></p>
						</div>
						<div class="form-group">
								<?php
									if($lp_Reviews_OPT=="instant_sign_in"){
										if($enableCaptcha==true){
											if ( class_exists( 'cridio_Recaptcha' ) ){ 
												if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) { 
												echo  '<div style="transform:scale(0.88);-webkit-transform:scale(0.88);transform-origin:0 0;-webkit-transform-origin:0 0;" id="recaptcha-'.get_the_ID().'" class="g-recaptcha" data-sitekey="'.$gSiteKey.'"></div>';
												}
											}
										}
									}
								?>
						</div>
						<p class="form-submit">
							<?php
								if($lp_Reviews_OPT=="sign_in"){
							?>
								<input name="submit_review" type="submit" id="submit" class="lp-review-btn btn-second-hover md-trigger" data-modal="modal-3" value="<?php echo esc_html__('Submit Review ', 'listingpro');?>">
							<?php
								}elseif($lp_Reviews_OPT=="instant_sign_in"){
							?>
								<input name="submit_review" type="submit" id="submit" class="lp-review-btn btn-second-hover" value="<?php echo esc_html__('Signup & Submit Review ', 'listingpro');?>">
							<?php } ?>
							 
							
							<input type="hidden" name="comment_post_ID" value="<?php echo $postid; ?>" id="comment_post_ID">
							<span class="review_status"></span>
								<img class="loadinerSearch" width="100px" src="<?php echo get_template_directory_uri().'/assets/images/ajax-load.gif' ?>">
						</p>
					</form>
				</div>
				<?php
			}
		}
	}
}
?>