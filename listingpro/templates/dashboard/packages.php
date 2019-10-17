<?php
	$currencyCode = listingpro_currency_sign();
?>
<div class="tab-pane fade in active" id="updateprofile">
	<div class="tab-header">
		<h3><?php echo esc_html__('Packages', 'listingpro'); ?></h3>
	</div>
	<?php
		global $listingpro_options;
		$currency_position = $listingpro_options['pricingplan_currency_position'];
		global $wpdb;
		$dbprefix = '';
		$post_ids = '';
		$dbprefix = $wpdb->prefix;
		$user_ID = '';
		$user_ID = get_current_user_id();
		$results = '';
		$resultss = '';
		$results = $wpdb->get_results( "SELECT * FROM {$dbprefix}listing_orders WHERE user_id ='$user_ID' AND plan_type ='Package' AND status='success'" );
		$resultss = $wpdb->get_results( "SELECT * FROM {$dbprefix}listing_orders WHERE user_id ='$user_ID' AND plan_type ='Package' AND status='expired'" );
	?>
	<!-- Active Packages -->
	<div class="packages">
		<div class="active-packages-area">
			<?php if(!empty($results) && count($results)>0 ){ ?>
			
					<?php foreach ( $results as $info ) 
					{ ?>
						<?php
						$plainID = '';
						$plainName = '';
						$plainType = '';
						$plainDate = '';
						$plainExpiry = '';
						$plainPrice = '';
						$plainUsed = '';
						$plainRemains = '';
						$plainTID = '';
						$pendingListings = 0;
						$activeListings = 0;
						
						$plainTID = $info->order_id;
						$plainID = $info->plan_id;
						$plainName = $info->plan_name;
						$plainType = $info->plan_type;
						if( !empty($currency_position) ){
							if( $currency_position=="left" ){
								$plainPrice = $currencyCode.$info->price;
							}else{
								$plainPrice = $info->price.$currencyCode;
							}
							
						}else{
							$plainPrice = $currencyCode.$info->price;
						}
						
						if(!empty($info->used)){
							$plainUsed = $info->used;
							$post_ids = $info->post_id;
						}
						
						$activeListingArray = array();
						$activeListingArray = explode(',', $post_ids);
						
						if(!empty($activeListingArray)){
							foreach($activeListingArray as $pid){
								if(get_post_status( $pid )=="pending"){
								$pendingListings++;
								}
								else if(get_post_status( $pid )=="publish"){
								$activeListings++;
								}
							}
						}
						
						$plainDate = $info->date;
						
						//$plainDate = strtr($plainDate, '/', '-');
						
						
						
						$days = '';
						$totalPosts = '';
						$planTIme = get_post_meta( $plainID, 'plan_time', true );
						if(!empty($planTIme)){
							$days = get_post_meta( $plainID, 'plan_time', true );
						}
						
						if(!empty($days)){
							$plainExpiry = date('Y-m-d', strtotime($plainDate. ' + '.$days.' days'));
							$plainExpiry = date('d-m-Y', strtotime($plainExpiry));
						}
						else{
							$plainExpiry = 'Unlimited';
						}
						$planText = get_post_meta( $plainID, 'plan_text', true );
						if(!empty($planText)){
							$totalPosts = get_post_meta( $plainID, 'plan_text', true );
							$plainRemains = $totalPosts - $plainUsed;
						}
						else{
							$plainRemains = 'unlimited';
							$planText = 'unlimited';
						}
						
						?>
						<div class="table-responsive lp-invoice-table">
							<div class="top-area">
							<?php
							if($plainRemains=="0"){?>
								<h2><?php echo $plainName; ?> <span class="active-status inactive"><?php esc_html_e('Expired','listingpro'); ?></span></h2>
                            <?php							
							}else{ ?>
								<h2><?php echo $plainName; ?> <span class="active-status active"><?php esc_html_e('Active','listingpro'); ?></span></h2>
							<?php } ?>
								<div class="listing-options">
									<ul>
										<li><?php esc_html_e('Listings Used : ','listingpro'); ?><span><?php echo $plainUsed; ?></span></li>
										<li><?php esc_html_e('Remaining Listings : ','listingpro'); ?><span><?php echo $plainRemains; ?></span></li>
									</ul>
								</div>
							</div>
							<table class="table table-striped">
								<thead>
									<tr>
										<th><?php esc_html_e('Trans ID','listingpro'); ?></th>
										<th><?php esc_html_e('Date','listingpro'); ?></th>
										<th><?php esc_html_e('Amount','listingpro'); ?></th>
										<th><?php esc_html_e('Duration','listingpro'); ?></th>
										<th><?php esc_html_e('Total Listings','listingpro'); ?></th>
										<th><?php esc_html_e('Status','listingpro'); ?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?php echo $plainTID; ?></td>
										<td><?php echo date("M j, Y", strtotime($plainDate)); ?></td>
										<td><?php echo $plainPrice; ?></td>
										<?php if(!empty($days) && $days>1) { ?>
										<td><?php echo $days;?> <?php esc_html_e('Days','listingpro'); ?></td>
										<?php } else { ?>
										<td><?php echo $days;?> <?php esc_html_e('Day','listingpro'); ?></td>
										<?php } ?>
										<td><?php echo $planText; ?></td>
										<?php
										if($plainRemains=="0"){?>
											<td><?php esc_html_e('Inactive','listingpro'); ?></td>
										<?php }else { ?>
										<td><?php esc_html_e('Active','listingpro'); ?></td>
										<?php } ?>
									</tr>
								</tbody>
							</table>
						</div>
				<?php } ?>
				
		<?php } if(!empty($resultss) && isset($resultss) ){ ?>
			<?php foreach ( $resultss as $info ) 
					{ ?>
						<?php
						$plainID = '';
						$plainName = '';
						$plainType = '';
						$plainDate = '';
						$plainExpiry = '';
						$plainPrice = '';
						$plainUsed = '';
						$plainRemains = '';
						$plainTID = '';
						
						$plainTID = $info->order_id;
						$plainID = $info->plan_id;
						$plainName = $info->plan_name;
						$plainType = $info->plan_type;
						//$plainPrice = $currencyCode.$info->price;
						if( !empty($currency_position) ){
							if( $currency_position=="left" ){
								$plainPrice = $currencyCode.$info->price;
							}else{
								$plainPrice = $info->price.$currencyCode;
							}
							
						}else{
							$plainPrice = $currencyCode.$info->price;
						}
						if(!empty($info->used)){
							$plainUsed = $info->used;
							$post_ids = $info->post_id;
						}
						
						
						$plainDate = $info->date;
						
						//$plainDate = strtr($plainDate, '/', '-');
						
						
						
						$days = '';
						$totalPosts = '';
						$planTIme = get_post_meta( $plainID, 'plan_time', true );
						if(!empty($planTIme)){
							$days = get_post_meta( $plainID, 'plan_time', true );
						}
						
						if(!empty($days)){
							$plainExpiry = date('Y-m-d', strtotime($plainDate. ' + '.$days. 'days'));
							$plainExpiry = date('d-m-Y', strtotime($plainExpiry));
						}
						else{
							$plainExpiry = esc_html__('Unlimited','listingpro');
						}
						$planText = get_post_meta( $plainID, 'plan_text', true );
						if(!empty($planText)){
							$totalPosts = get_post_meta( $plainID, 'plan_text', true );
							$plainRemains = $totalPosts - $plainUsed;
						}
						else{
							$plainRemains = 'unlimited';
							$planText = 'unlimited';
						}
						
						?>
			<div class="table-responsive lp-invoice-table">
				<div class="top-area">
					<h2><?php echo $plainName; ?> <span class="active-status inactive"><?php esc_html_e('Expired','listingpro'); ?></span></h2>
					<div class="listing-options">
						<ul>
						<!--
							<li>Remaining Listings: <span>0</span></li>
							<li>Pending: <span>2</span></li>
							<li>Active: <span>2</span></li>
						-->
						</ul>
					</div>
				</div>
				<table class="table table-striped">
					<thead>
					  	<tr>
							<th><?php esc_html_e('Trans ID','listingpro'); ?></th>
							<th><?php esc_html_e('Date','listingpro'); ?></th>
							<th><?php esc_html_e('Amount','listingpro'); ?></th>
							<th><?php esc_html_e('Duration','listingpro'); ?></th>
							<th><?php esc_html_e('Total Listings','listingpro'); ?></th>
							<th><?php esc_html_e('Status','listingpro'); ?></th>
					  	</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $plainTID; ?></td>
							<td><?php echo date("M j, Y", strtotime($plainDate)); ?></td>
							<td><?php echo $plainPrice; ?></td>
							<td><?php echo $days;?> <?php esc_html_e('Days','listingpro'); ?></td>
							<td><?php echo $planText; ?></td>
							<td><?php esc_html_e('Inactive','listingpro'); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php } ?>
		<?php } if(empty($results) && empty($resultss) ){ ?>
				<div class="text-center no-result-found col-md-12 col-sm-6 col-xs-12 margin-bottom-30">
					<h1><?php esc_html_e('Ooops!','listingpro'); ?></h1>
					<p><?php esc_html_e('Sorry ! You have no active or exired Package yet!','listingpro'); ?></p>
				</div>
				<?php } ?>
		</div>
	
	
</div>
	
