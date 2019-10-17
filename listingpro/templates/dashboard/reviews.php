<?php 
	global $listingpro_options;
	$post_author = get_post_field( 'post_author', get_the_ID() );
	$author_obj = get_user_by('id', $post_author);
	$username = $author_obj->user_login;
	$userEmail = $author_obj->user_email;
?>
<div id="reviews" role="tab" class="tab-pane fade in">
	<div class="tab-header">
		<h3><?php echo esc_html__('Reviews Received', 'listingpro'); ?></h3>
	</div>
	<div class="aligncenter">
		<div id="commentsdiv" class="postbox  hide-if-js" style="display: block;">
			<div class="postbox">
				<div class="inside">
					<table class="widefat fixed striped comments wp-list-table comments-box">
						<tbody id="the-comment-list" data-wp-lists="list:comment">
							
							<div class="panel with-nav-tabs panel-default lp-tabs">
								
								<div class="panel-body">
									<div class="tab-content">
									  <div id="2" class="tab-pane fade in active">
										<!--place pending here -->
										<?php
											global $paged, $wp_query;
											if(isset($_POST['submit_response'])){
												
												$pid = '';
												$userName = '';
												$userEmail = '';
												$pid = $_POST['rewID'];
												$userName = $_POST['userName'];
												$userEmail = $_POST['userEmail'];
												$authEmail = $_POST['authEmail'];
												$review_author = get_post_field('post_author', $pid);
												$review_obj = get_user_by('id', $review_author);
												$reviewuserEmail = $review_obj->user_email;
												$review_res = '';
												$review_res = $_POST['review_reply'];
												// moin here strt
												$review_reply_time = '';
												$review_reply_time = $_POST['reviewTime'];
												listing_set_metabox('review_reply_time', $review_reply_time, $pid);
												// moin here ends
												$body = $review_res;
												listing_set_metabox('review_reply', $review_res, $pid);
												$from = $userEmail;
												$headers[] = 'Content-Type: text/html; charset=UTF-8';
												$headers[]= 'From: '.$from . "\r\n";
												
												$mailSubj = $listingpro_options['listingpro_subject_listing_rev_reply'];
												$mailBody = $listingpro_options['listingpro_msg_listing_rev_reply'];
												
												$formated_mailBody = lp_sprintf2("$mailBody", array(
													'review_reply_text' => "$body"
												));
												
												wp_mail( $reviewuserEmail, $mailSubj, $formated_mailBody, $headers );
												
												
											}
											/* by zaheer on 28 march */
											$recentReviews = array();
											$recentReviews = getAllReviewsArray();
											if(!empty($recentReviews) && count($recentReviews)>0){
											$args = array(
												'post_type' => 'lp-reviews', 
												'posts_per_page' => -1, 
												'post__in'	=> $recentReviews,
												'orderby' => 'date',
												'order'   => 'DESC',
												'paged' => $paged,
												'post_status'	=> 'publish'
											);
											/* end by zaheer on 28 march */
											
											$wp_query = new WP_Query( $args );

											if ( $wp_query->have_posts() ) {
												while ( $wp_query->have_posts() ) {
													$wp_query->the_post();
													
													$authorid = $wp_query->post_author;
													$review_post = listing_get_metabox_by_ID('listing_id', get_the_ID());
													
														
														echo '<tr id="comment-'.get_the_ID().'" class="comment byuser comment-author-admin bypostauthor even thread-even depth-1 approved" style="background-color: rgb(255, 255, 255);">';
	
														$data_active = '';
														$data_passive = '';

														$rating = listing_get_metabox_by_ID('rating' ,get_the_ID());
														/* by zaheer on 28 march */
														if(!empty($rating)){
															$rate = $rating;
														}
														else{
															$rate = 0;
														}
														/* end by zaheer on 28 march */
														
														$review_author_email = get_the_author_meta( 'user_email');
														$review_reply = listing_get_metabox_by_ID('review_reply',get_the_ID());
														echo '<td class="comment column-comment has-row-actions column-primary" data-colname="Comment">
															<h4> <span>'.get_the_author_meta('display_name').'</span>'.esc_html__(' posted a review on ', 'listingpro').'<a href="'.get_the_permalink($review_post).'">'.get_the_title($review_post).'</a>
															</h4>
															<div class="review-count">
																<div class="reviews">
																	<h4>
																		<span>'.esc_html__('Rating:', 'listingpro').'</span>';
																		if( !empty($rating) ){
																			$blankstars = 5;
																			while( $rating > 0 ){
																				echo '<i class="fa fa-star"></i>';
																				$rating--;
																				$blankstars--;
																			}
																			while( $blankstars > 0 ){
																				echo '<i class="fa fa-star-o"></i>';
																				$blankstars--;
																			}
																		}
																		echo
																	'</h4>
																</div>
															</div>
															<a href="#" class="see_more_btn closedd"><i class="fa fa-arrow-down"></i>'.esc_html__('See More', 'listingpro').'</a>
															<div class="review-content">
																<p><span><strong>'.esc_html__('Review:', 'listingpro').'</strong></span>'.get_the_content().'</p>
																<div class="reviews">';
																	if( !empty($review_reply) ){
																		echo '<span class="pull-left">'.esc_html__('Reply Closed','listingpro').'</span>';
																	}else{
																		echo '<a href="#" class="open-reply pull-left closeddd"><i class="fa fa-arrow-down"></i>'.esc_html__('Reply this review','listingpro').'</a>';
																	}
																	if( !empty($review_reply) ){
																		echo "<div class='reply-response'>";
																		echo '<h4>'.esc_html__('Response','listingpro').'</h4>';
																		echo  '<p>'.$review_reply.'</p>';
																		echo "</div>";
																	}
																	else{
																		echo "<div class='post_response'>";
																		echo '<form name="post_response" method="post" action="">';
																		echo '<h4>'.esc_html__('Add Reply', 'listingpro').'</h4>';
																		echo '<textarea placeholder="'.esc_html__('Write something in reply of this review','listingpro').'" id="'.get_the_ID().'" name="review_reply" class="review_reply" style="width:100%"></textarea>';
																		echo '<input type="submit" value="'.esc_html__('Send Reply', 'listingpro').'" name="submit_response" class="lp-review-btn">';
																		echo '<input type="hidden" value="'.get_the_ID().'" name="rewID">';
																		echo '<input type="hidden" value="'.$userEmail.'" name="userEmail">';
																		echo '<input type="hidden" value="'.$username.'" name="userName">';
																		echo '<input type="hidden" value="'.$review_author_email.'" name="authEmail">';
																		echo '<input type="hidden" value="'.date("F j, Y, g:i a").'" name="reviewTime">';
																		
																		echo '</form>';
																		echo '</div>';
																	}
																	echo '
																</div>
															</div>';
															
															
															echo '
														</td>';
														
														
														
														echo '</tr>';
														echo '<tr class="style="background-color: rgb(255, 255, 255);">';
														echo '<td></td>';
														echo '</tr>';
														
													
												}
												wp_reset_postdata();
											}
											
										}
										else{	?>
													<div class="text-center no-result-found col-md-12 col-sm-6 col-xs-12 margin-bottom-30">
														<h1><?php esc_html_e('Ooops!','listingpro'); ?></h1>
														<p><?php esc_html_e('Sorry ! You have no received Reviews yet!','listingpro'); ?></p>
													</div>
													<?php
											}
										?>
										
										
									  </div>
									  
									</div>
								</div>
							</div>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!--reviews-->