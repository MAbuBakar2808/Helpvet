<?php
	global $listingpro_options;
	$post_id='';
	$post_title='';
	$post_url='';
	$post_author_id='';
	$post_author_meta='';
	$author_nicename='';
	$author_url='';

	$post_id = $post->ID;
	$post_title = $post->post_title;
	$post_url = get_permalink($post_id);

	$post_author_id= $post->post_author;
	$post_author_meta = get_user_by( 'id', $post_author_id );
	//print_r($post_author_meta);
	if(!empty($post_author_meta)){
		$author_nicename = $post_author_meta->user_nicename;
		$author_user_email = $post_author_meta->user_email;
	}
	
	$author_url = get_author_posts_url( $post_author_id);
	
	$claimIMG = $listingpro_options['lp_listing_claim_image']['url'];

?>


<div class="md-modal md-effect-3 single-page-popup" id="modal-2">
	<div class="md-content claimform-box">
		<!-- <h3><?php //echo esc_html('Claim This Business', 'listingpro'); ?> ( <?php echo get_the_title(); ?> )</h3> -->
		<div class="">
			<form class="form-horizontal"  method="post" id="claimform">
				<div class="col-md-5 col-xs-12 padding-0">
					<div class="claim-text">
						<h1>
							<?php echo esc_html__('Claim To', 'listingpro'); ?>
							<span><?php echo esc_html__('Unlock', 'listingpro'); ?></span>
							<small><?php echo esc_html__('Your Business', 'listingpro'); ?></small>
							<span class="big"><?php echo esc_html__('Listing', 'listingpro'); ?></span>
						</h1>
						<?php 
							if(!empty($claimIMG)){ ?>
								<img src="<?php echo $claimIMG; ?>" alt="">
						<?php }
						?>
						
					</div>
				</div>
				<div class="col-md-7 col-xs-12 padding-0">
					<div class="claim-details">
						<h3><?php echo esc_html__('Start Managing your listing like a pro', 'listingpro'); ?></h3>
						<h2>
							<?php echo esc_html__('All from ', 'listingpro'); ?>
							<span><?php echo esc_html__('One', 'listingpro'); ?></span> 
							<?php echo esc_html__('dashboard', 'listingpro'); ?>
						</h2>
						<ul>
							<li>
								<i class="fa fa-check-square-o"></i> 
								<?php echo esc_html__('Edit business listing, add photos, video etc.', 'listingpro'); ?>
							</li>
							<li>
								<i class="fa fa-check-square-o"></i> 
								<?php echo esc_html__('Promote your listing with ads to drive sales.', 'listingpro'); ?>
							</li>
							<li>
								<i class="fa fa-check-square-o"></i> 
								<?php echo esc_html__('Start recieving messages from lead.', 'listingpro'); ?>
							</li>
						</ul>
						<div class="form-group">
							<input type="hidden" class="form-control" name="post_title" value="<?php echo esc_attr($post_title); ?>">
							<input type="hidden" class="form-control" name="post_url" value="<?php echo esc_attr($post_url); ?>">
							<input type="hidden" class="form-control" name="author_nicename" value="<?php echo esc_attr($author_nicename); ?>">
							<input type="hidden" class="form-control" name="author_url" value="<?php echo esc_attr($author_url); ?>">
							<input type="hidden" class="form-control" name="author_email" value="<?php echo esc_attr($author_user_email); ?>">
							<input type="hidden" class="form-control" name="post_id" value="<?php echo esc_attr($post_id); ?>">
						</div>
						<div class="form-group">
							<label for=""><?php echo esc_html__('Fill the details below to claim for free!', 'listingpro'); ?></label>
							<input type="text" name="fullname" id="fullname" placeholder="<?php echo esc_html__('Full Name', 'listingpro'); ?>">
						</div>
						<div class="form-group">
							<input type="text" name="phone" id="phone" placeholder="<?php echo esc_html__('Phone#', 'listingpro'); ?>">
						</div>
						<div class="form-group">
							<textarea class="form-control textarea1" rows="5" name="message" id="message" placeholder="<?php echo esc_html__('Additional proof to expedite your claim approval...', 'listingpro'); ?>" required></textarea>
						</div>
						<div class="form-group mr-bottom-0">
							<input type="submit" value="<?php echo esc_html__('Claim your business now!', 'listingpro'); ?>" class="lp-review-btn btn-second-hover">
							<i class="fa fa-circle-o-notch fa-spin fa-2x formsubmitting"></i>
							<span class="statuss"></span>
						</div>
						<div class="secure-text">
							<i class="fa fa-lock"></i>
							<span><?php echo esc_html__('Secure claim process', 'listingpro'); ?></span>
						</div>
					</div>
				</div>
			</form>	
			<a class="md-close"><i class="fa fa-close"></i></a>
		</div>
	</div>
</div>
<!-- Popup Close -->
<div class="md-overlay"></div>
<div class="claimform">
	<h3><?php echo esc_html__('Claim This Listing', 'listingpro');?></h3>
	<div class="">
		<form class="form-horizontal"  method="post" id="claimformmobile">
			<div class="form-group">
				<input type="hidden" class="form-control" name="post_title" value="<?php echo esc_attr($post_title); ?>">
				<input type="hidden" class="form-control" name="post_url" value="<?php echo esc_attr($post_url); ?>">
				<input type="hidden" class="form-control" name="author_nicename" value="<?php echo esc_attr($author_nicename); ?>">
				<input type="hidden" class="form-control" name="author_url" value="<?php echo esc_attr($author_url); ?>">
				<input type="hidden" class="form-control" name="author_email" value="<?php echo esc_attr($author_user_email); ?>">
				<input type="hidden" class="form-control" name="post_id" value="<?php echo esc_attr($post_id); ?>">
			</div>
			<div class="form-group">
				<textarea class="form-control textarea1" rows="5" name="lpmessage" id="lpmessage" placeholder="<?php echo esc_html__('Message:','listingpro');?>"></textarea>
			</div>
			<div class="form-group mr-bottom-0">
				<input type="submit" value="<?php echo esc_html__('Submit','listingpro');?>" class="lp-review-btn btn-second-hover">
				<i class="fa fa-circle-o-notch fa-spin fa-2x formsubmitting"></i>
				<span class="statuss"></span>
			</div>
		</form>	
	</div>
</div>
