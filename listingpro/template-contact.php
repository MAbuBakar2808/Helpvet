<?php
/**
 * Template name: Contact Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */

get_header(); 
	global $listingpro_options;
	$contact_page_map_switch = $listingpro_options['contact_page_map_switch'];
	$cpFailedMessage = $listingpro_options['cp-failed-message'];
	$cpsuccessMessage = $listingpro_options['cp-success-message'];
	$gSiteKey = '';
	$gSiteKey = $listingpro_options['lp_recaptcha_site_key'];
	$enableCaptchaform = lp_check_receptcha('lp_recaptcha_contact');

	$errorMSG = '';
	$successMSG = '';
	if(isset($_POST['contactMSG'])){
		
		$uname = sanitize_text_field($_POST['uname']);
		$uemail = sanitize_email($_POST['uemail']);
		$usubject = sanitize_text_field($_POST['usubject']);
		$umessage = sanitize_text_field($_POST['umessage']);
		
		$enableCaptcha = false;
		$processContact = true;
		if(isset($_POST['g-recaptcha-response'])){
			if(!empty($_POST['g-recaptcha-response'])){
				$enableCaptcha = true;
			}
			else{
				$processContact = false;
			}
		}
		else{
			$enableCaptcha = false;
			$processContact = true;
		}
		
		$keyResponse = '';
		
		if($enableCaptcha == true){
			if ( class_exists( 'cridio_Recaptcha' ) ){ 
								$keyResponse = cridio_Recaptcha_Logic::is_recaptcha_valid($_POST['g-recaptcha-response']);
								if($keyResponse == false){
									$processContact = false;
								}
								else{
									$processContact = true;
								}
			}
		}
		
		if($processContact==true){
			
			if(empty($uname) || empty($uemail) || empty($umessage) ){
				//$errorMSG = esc_html__('Required : ', 'listingpro');
				if(empty($uname) || empty($uemail) || empty($umessage)){
					$errorMSG .= $cpFailedMessage;
				}			
			}
			else{
				$successMSG = $cpsuccessMessage;
				
				$admin_email = '';
				$admin_email = get_option( 'admin_email' );
				if(empty($usubject)){
					$usubject = esc_html__('Contact Us Email', 'listingpro');
				}
				$formated_mail_content = '<h3>'.esc_html__("Details : ", "listingpro").'</h3>';
				$formated_mail_content .= '<p>'.esc_html__("Name : ", "listingpro").$uname.'</p>';
				$formated_mail_content .= '<p>'.esc_html__("Email : ", "listingpro").$uemail.'</p>';
				$formated_mail_content .= '<p>'.esc_html__("Message : ", "listingpro").$umessage.'</p>';
				
				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				//$headers[] = 'From: '.$uname.' <'.$uemail.'>';
				wp_mail( $admin_email, $usubject, $formated_mail_content, $headers);
				
			}
			
		}
		else{
			$errorMSG .= esc_html__('Please check captcha.', 'listingpro');
		}
		
		
	}



	$addressTitle = $listingpro_options['Address'];
	$cp_address = $listingpro_options['cp-address'];
	$cp_number = $listingpro_options['cp-number'];
	$cp_email = $listingpro_options['cp-email'];
	$cp_social_links = $listingpro_options['cp-social-links'];
	$formTitle = $listingpro_options['form-title'];
	$cpSuccessMessage = $listingpro_options['cp-success-message'];
	
	$cpLat = $listingpro_options['cp-lat'];
	$cpLan = $listingpro_options['cp-lan'];
	$showContactinfo = true;
	$cpShowcontactinfo = $listingpro_options['cp-show-contact-details'];
	if($cpShowcontactinfo=="1"){
		$showContactinfo = true;
	}
	else{
		$showContactinfo = false;
	}
	$lp_map_pin = $listingpro_options['lp_map_pin']['url'];
	$contact_wrap_center = '';
	$contact_wrap_align_center = '';
	if($contact_page_map_switch == false){
		
		$contact_wrap_center    = 'contact_center';
		$contact_wrap_align_center    = 'text-center';
	}
	
?>
		<!--==================================Section Open=================================-->
	<section class="clearfix">
		<?php
			if($contact_page_map_switch==true){
			?>
		<div class="contact-left">
			<div class="cp-lat" data-lat="<?php echo esc_attr($cpLat); ?>"></div>
			<div class="cp-lan" data-lan="<?php echo esc_attr($cpLan); ?>"></div>
			<div id="cpmap" class="contactmap" data-pinicon = "<?php echo esc_attr($lp_map_pin); ?>">
			</div>
		</div>
			<?php } ?>
		<div  class="<?php echo $contact_wrap_align_center; ?>">
			<div  class=" padding-top-60 padding-bottom-70 contact-right <?php echo $contact_wrap_center; ?>">
				<?php
					if($showContactinfo==true){
				?>
					<h3 class=" lp-border-bottom padding-bottom-20 margin-bottom-20"><?php echo esc_attr($addressTitle); ?></h3>
					<div class="address-box mr-bottom-30">
					<?php if(!empty($cp_address)){ ?>
						<p>
							<i class="fa fa-map-marker"></i>
							<span><?php echo esc_attr($cp_address); ?></span>
						</p>
					<?php } if(!empty($cp_number)){?>
						<p>
							<i class="fa fa-phone"></i>
							<span><?php echo esc_attr($cp_number); ?></span>
						</p>
					<?php } if(!empty($cp_email)){?>
						<p>
							<i class="fa fa-envelope"></i>
							<span><?php echo esc_attr($cp_email); ?></span>
						</p>
					<?php } ?>
						<?php
						if($cp_social_links == 1){
							$fb = $listingpro_options['fb'];
							$tw = $listingpro_options['tw'];
							$gog = $listingpro_options['gog'];
							$insta = $listingpro_options['insta'];
							$tumb = $listingpro_options['tumb'];

						?>
							<ul class="social-icons post-socials contact-social">
							<?php if(!empty($fb)){ ?>
								<li>
									<a href="<?php echo esc_attr($fb); ?>"><!-- Facebook icon by Icons8 -->
										<?php echo listingpro_icons('fb'); ?>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($gog)){ ?>
								<li>
									<a href="<?php echo esc_attr($gog); ?>"><!-- Google Plus icon by Icons8 -->
										<?php echo listingpro_icons('gp'); ?>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($tw)){ ?>
								<li>
									<a href="<?php echo esc_attr($tw); ?>"><!-- LinkedIn icon by Icons8 -->
										<?php echo listingpro_icons('tw'); ?>
									</a>
								</li>
							<?php } ?>
							<?php if(!empty($insta)){ ?>
								<li>
									<a href="<?php echo esc_attr($insta); ?>"><!-- Instagram icon by Icons8 -->
										<?php echo listingpro_icons('insta'); ?>
									</a>
								</li>
							<?php } ?>
							
							</ul><!-- ../social-icons-->
						<?php } ?>
					</div>
				<?php }?>
				<h3 class="margin-top-60 margin-bottom-30 lp-border-bottom padding-bottom-20"><?php echo esc_attr($formTitle); ?></h3>
					
				<form class="form-horizontal pos-relative" id="contactMSG" name="contactMSG" method="post" novalidate="novalidate" action="">
					<div class="form-group">
					  <div class="col-sm-6">
						<input class="form-control nameform" id="name" name="uname" placeholder="<?php esc_html_e('Name:','listingpro'); ?>" type="text" value="" required="">
					  </div>
					  <div class="col-sm-6">          
						<input class="form-control" id="email" name="uemail" placeholder="<?php esc_html_e('Email:','listingpro'); ?>" type="email" required="">
					  </div>
					</div>
					<div class="form-group">
					  <div class="col-sm-12">          
						<input class="form-control" id="subject" name="usubject" placeholder="<?php esc_html_e('Subject:','listingpro'); ?>" type="text">
					  </div>
					</div>
					<div class="form-group">
					  <div class="col-sm-12">          
					<textarea class="form-control" rows="5" id="message" name="umessage" placeholder="<?php esc_html_e('Message:','listingpro'); ?>"></textarea>
					  </div>
					</div>
					<div class="form-group mr-bottom-20">
						<div class="col-sm-12">
							<?php
								if($enableCaptchaform==true){
									if ( class_exists( 'cridio_Recaptcha' ) ){ 
										if ( cridio_Recaptcha_Logic::is_recaptcha_enabled() ) { 
										echo  '<div id="recaptcha-'.get_the_ID().'" class="g-recaptcha" data-sitekey="'.$gSiteKey.'"></div>';
										}
									}
								}
							?>
						</div>
					</div>
					<div class="form-group">        
					  <div class="col-sm-12">							
						<input type="submit" id="contactMSG" name="contactMSG" value="<?php esc_html_e('Send Message','listingpro'); ?>" class="lp-review-btn btn-second-hover">

					  </div>
					</div>
				
				<?php if(!empty($successMSG)){ ?>
				<div id="success" style="display:block">
					<span class="green textcenter">
						<p><?php echo esc_html($successMSG); ?></p>
					</span>
				</div>
				<?php } ?>
				<?php if(!empty($errorMSG)){ ?>
				<div id="error"style="display:block">
					<span>
						<p><?php echo esc_html($errorMSG); ?></p>
					</span>
				</div>
				<?php } ?>
				
				</form>
			</div>
		</div>
	</section>
	<!--==================================Section Close=================================-->
	
			
<?php 
get_footer();
?>