<div class="tab-pane" id="contact">
	<?php
	global $listingpro_options;
	
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
	
	
	$lp_leadForm = $listingpro_options['lp_lead_form_switch'];
	if($lp_leadForm=="1"){
		$claimed_section = listing_get_metabox('claimed_section');
		$show_leadform_only_claimed = $listingpro_options['lp_lead_form_switch_claim'];
		$showleadform = true;
		if($show_leadform_only_claimed== true){
			if($claimed_section == 'claimed') {
				$showleadform = true;
			}
			else{
				$showleadform = false;
			}
		}
		
		if($showleadform == true) { ?>
				<div class="widget-box business-contact business-contact2">
					<div class="contact-form quickform">										
						<div class="user_text">
							<?php
							$author_avatar_url = get_user_meta(get_the_author_meta( 'ID' ), "listingpro_author_img_url", true); 
							$avatar ='';
							if(!empty($author_avatar_url)) {
								$avatar =  $author_avatar_url;

							} else { 			
								$avatar_url = listingpro_get_avatar_url (get_the_author_meta( 'ID' ), $size = '94' );
								$avatar =  $avatar_url;

							}
						?>
							<div class="author-img">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><img src="<?php echo esc_url($avatar); ?>" alt=""></a>
							</div>
							<div class="author-social">
								<div class="status">
									<span class="online"><a ><?php echo get_the_author_meta('display_name'); ?></a></span>													
								</div>
								<ul class="social-icons post-socials">
									<?php if(!empty($user_facebook)) { ?>
									<li>
										<a href="<?php echo esc_url($user_facebook); ?>">
											<?php echo listingpro_icons('fbGrey'); ?>
										</a>
									</li>
									<?php } if(!empty($user_google)) { ?>
									<li>
										<a href="<?php echo esc_url($user_google); ?>">
											<?php echo listingpro_icons('googleGrey'); ?>
										</a>
									</li>
									<?php } if(!empty($user_instagram)) { ?>
									<li>
										<a href="<?php echo esc_url($user_instagram); ?>">
											<?php echo listingpro_icons('instaGrey'); ?>
										</a>
									</li>
									<?php } if(!empty($user_twitter)) { ?>
									<li>
										<a href="<?php echo esc_url($user_twitter); ?>">
											<?php echo listingpro_icons('tmblrGrey'); ?>
										</a>
									</li>
									<?php } if(!empty($user_linkedin)) { ?>
									<li>
										<a href="<?php echo esc_url($user_linkedin); ?>">
											<?php echo listingpro_icons('clinkedin'); ?>
										</a>
									</li>
									<?php } if(!empty($user_pinterest)) { ?>
									<li>
										<a href="<?php echo esc_url($user_pinterest); ?>">
											<?php echo listingpro_icons('cinterest'); ?>
										</a>
									</li>
									<?php } ?>
								</ul>
							</div>
						</div>
						<div class="clearfix"></div>
						
							<form class="form-horizontal hidding-form-feilds margin-top-20"  method="post" id="contactOwner">
								<?php
								
								$author_id = '';
								$author_email = '';
								$author_email = get_the_author_meta( 'user_email' );
								$author_id = get_the_author_meta( 'ID' );
								$gSiteKey = '';
								$gSiteKey = $listingpro_options['lp_recaptcha_site_key'];
								$enableCaptcha = lp_check_receptcha('lp_recaptcha_lead');
								
								?>
								<div class="form-group">
									<input type="text" class="form-control" name="name7" id="name7" placeholder="<?php esc_html_e('Name:','listingpro'); ?>">
								</div>
								<div class="form-group">
									<input type="email" class="form-control" name="email7" id="email7" placeholder="<?php esc_html_e('Email:','listingpro'); ?>">
								</div>
								<div class="form-group">
									<input type="text" class="form-control" name="phone" id="phone" placeholder="<?php esc_html_e('Phone','listingpro'); ?>">
								</div>
								<div class="form-group">
									<textarea class="form-control" rows="5" name="message7" id="message7" placeholder="<?php esc_html_e('Message:','listingpro'); ?>"></textarea>
								</div>
								<div class="form-group">
								<?php
									if($enableCaptcha==true){
										if ( class_exists( 'cridio_Recaptcha' ) ){ 
											if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) { 
											echo  '<div id="recaptcha-'.get_the_ID().'" class="g-recaptcha" data-sitekey="'.$gSiteKey.'"></div>';
											}
										}
									}

								?>
								
								</div>
								<div class="form-group margin-bottom-0 pos-relative">
									<input type="submit" value="<?php esc_html_e('Send','listingpro'); ?>" class="lp-review-btn btn-second-hover">
									<input type="hidden" value="<?php the_ID(); ?>" name="post_id">
									<input type="hidden" value="<?php echo esc_attr($author_email); ?>" name="author_email">
									<input type="hidden" value="<?php echo esc_attr($author_id); ?>" name="author_id">
									<i class="lp-search-icon fa fa-send"></i>
								</div>
							</form>
					</div>
				</div>
<?php 	} ?>
<?php } ?>
</div>