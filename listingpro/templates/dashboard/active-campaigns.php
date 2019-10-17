<?php
	$currencyCode = listingpro_currency_sign();
?>
<div id="ads" class="tab-pane fade active in">
	<div class="tab-header">
		<h3><?php esc_html_e('Active Ad Campaigns','listingpro'); ?></h3>
	</div>
<?php
global $listingpro_options;
global $wpdb;
$dbprefix = '';
$dbprefix = $wpdb->prefix;
$currency_position = $listingpro_options['pricingplan_currency_position'];
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$lp_random_ads = $listingpro_options['lp_random_ads'];
$lp_detail_page_ads = $listingpro_options['lp_detail_page_ads'];
$lp_top_in_search_page_ads = $listingpro_options['lp_top_in_search_page_ads'];
$currencyprice = $listingpro_options['currency_paid_submission'];
$ads_durations = $listingpro_options['listings_ads_durations'];

?>
<div class="packages lp-active-compaign-outer">
	
		<?php
		
		$user_id = get_current_user_id();
		$args = array(
			'author'  => $user_id,
			'post_type'  => 'listing',
			'posts_per_page'      => -1,
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key'     => 'campaign_status',
					'value'   => 'active',
					'compare' => 'IN',
				),
			),
		);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) { ?>

		
					<?php
						while ( $query->have_posts() ) {
							$query->the_post(); ?>
							<?php
								$adID = listing_get_metabox_by_ID('campaign_id', get_the_ID());
								$campaigns = listing_get_metabox_by_ID('ad_type', $adID);
								$postID = listing_get_metabox_by_ID('ads_listing', $adID);

								$Random = '';
								$DetailPage = '';
								$SearchPage = '';
								$ad_date = '';
								$ad_expiryDate = '';
								$ad_date = listing_get_metabox_by_ID('ad_date', $adID);
								$ad_expiryDate = listing_get_metabox_by_ID('ad_expiryDate', $adID);
								$currency_code = '';
								$currency_code = $listingpro_options['currency_paid_submission'];
								
								
								$prices = 0;
								if( !empty($campaigns) ){
									foreach( $campaigns as $type ){
										$prices = $prices + $listingpro_options[$type];
									}
								}
								
								
								
								$results = $wpdb->get_results( "SELECT * FROM {$dbprefix}listing_campaigns WHERE user_id='".$user_id."' AND post_id='".$adID."' AND status = 'success'" );
								
								$method = '';
								$tid = '';
								
								if(!empty($results) && count($results)>0){
									$method = $results[0]->payment_method;
									if($method=="wire"){
										$method = esc_html__('wire', 'listingpro');
									}
										
									
									$tid = $results[0]->transaction_id;
									if(!empty($prices)){
										$prices =$prices;
									}
									else{
										$prices = $results[0]->price;
									}
									
									if( !empty($currency_position) ){
										if( $currency_position=="left" ){
											$prices = $currencyCode.$prices;
										}else{
											$prices = $prices.$currencyCode;
										}
										
									}else{
										$prices = $currencyCode.$prices;
									}
									
								}

							?>
							<div class="table-responsive campaign lp-invoice-table">
								<div class="top-section">
									<h3><div class="listing_pro"><?php esc_html_e('Ad','listingpro'); ?></div> <a href="<?php echo get_the_permalink();?>"><span><?php the_title(); ?></span></a><span class="active-status active"><?php esc_html_e('Active','listingpro'); ?></span></h3>
									<div class="campaign-options">
										<ul>
											<?php 
											if(!empty($campaigns)){
												foreach($campaigns as $camp){
													if($camp=="lp_random_ads"){
														$typetitle = esc_html__("Random Ads",'listingpro');
													}
													if($camp=="lp_detail_page_ads"){
														$typetitle = esc_html__("Business Detail page",'listingpro');
													}
													if($camp=="lp_top_in_search_page_ads"){
														$typetitle = esc_html__("Top in Search & Taxonomies",'listingpro');
													}
													echo '<li><i class="fa fa-check-circle"></i>'.$typetitle.'</li>';
												}
											}
											?>
										</ul>
									</div>
								</div>
								<table class="table table-striped">
									<thead>
										<tr>
											<th><?php esc_html_e('Trans ID','listingpro'); ?></th>
											<th><?php esc_html_e('Amount','listingpro'); ?></th>
											<th><?php esc_html_e('Duration','listingpro'); ?></th>
											<th><?php esc_html_e('Payment Method','listingpro'); ?></th>
											<th><?php esc_html_e('Date From','listingpro'); ?></th>
											<th><?php esc_html_e('Date To','listingpro'); ?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
										
											<td><?php echo $tid; ?></td>
											<td><?php echo $prices; ?></td>
											<td><?php													
													$lp_days = '';
													if( $ads_durations == 1 ) {
														echo $ads_durations. ' ';
														echo $lp_days = esc_html_e('Day','listingpro');
													} else {
														echo $ads_durations;
														echo $lp_days = esc_html_e('Days','listingpro');
													} 
														// echo $lp_days;													
												?>
											</td>
											<td><?php echo $method; ?></td>
											<td><?php echo date("M j, Y", strtotime($ad_date)); ?></td>
											<td><?php echo date("M j, Y", strtotime($ad_expiryDate)); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
					<?php	
						}
					wp_reset_postdata();
		}
		else{
			?>
				<div class="text-center no-result-found col-md-12 col-sm-6 col-xs-12 margin-bottom-30">
					<h1> <?php esc_html_e('Ooops!','listingpro'); ?></h1>
					<p> <?php esc_html_e('Sorry ! You have no active campaigns yet!','listingpro'); ?></p>
				</div>
			<?php
		}
		
		?>
									

							
</div>
						<!--ads-->