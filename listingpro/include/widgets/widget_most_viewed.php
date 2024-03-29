<?php
/**
 * Extend Recent Posts Widget 
 *
 * Adds different formatting to the default WordPress Recent Posts Widget
 */

class recent_listing_Widget extends WP_Widget{
function __construct() {
	parent::__construct(
		'listingPro_widget', // Base ID
		'ListingPro - Recent Listing Widget', // Name
		array('description' => esc_html__('', 'listingpro') )
   	);
}
function form($instance) {
	if( $instance) {
		$title = esc_attr($instance['title']);
		$numberOfListings = esc_attr($instance['numberOfListings']);
	} else {
		$title = '';
		$numberOfListings = '';
        $video_posts_style = '';
	}
	?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_html__('Title', 'listingpro'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('numberOfListings')); ?>"><?php echo esc_html__('Number of Listings:', 'listingpro'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('numberOfListings'); ?>" name="<?php echo esc_attr($this->get_field_name('numberOfListings')); ?>" type="text" value="<?php echo $numberOfListings; ?>" />
			<!-- <select id="<?php echo $this->get_field_id('numberOfListings'); ?>"  name="<?php echo esc_attr($this->get_field_name('numberOfListings')); ?>">
				<?php for($x=1;$x<=10;$x++): ?>
				<option <?php echo $x == $numberOfListings ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
				<?php endfor;?>
			</select> -->
		</p>
       
        <!-- <p>
            <label for="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php echo esc_html__('Social Style:', 'listingpro' );?></label>
            <select class='widefat' id="<?php echo $this->get_field_id('video_posts_style'); ?>" name="<?php echo esc_attr($this->get_field_name('video_posts_style')); ?>" type="text">
                <option value='style_one'<?php echo ($video_posts_style=='style_one')?'selected':''; ?>><?php echo esc_html__('Style One', 'listingpro' );?></option>
                <option value='style_two'<?php echo ($video_posts_style=='style_two')?'selected':''; ?>><?php echo esc_html__('Style Two', 'listingpro' );?></option>
                <option value='style_three'<?php echo ($video_posts_style=='style_three')?'selected':''; ?>><?php echo esc_html__('Style Three', 'listingpro' );?></option>
            </select>                
        </p> -->
	<?php
}

function widget($args, $instance) {
	extract( $args );
	$title = apply_filters('widget_title', $instance['title']);
	$numberOfListings = $instance['numberOfListings'];
    $video_posts_style = $instance['video_posts_style'];
	echo $before_widget;

	if ( $title ) {
		echo $before_title . $title . $after_title;
	}

	global $post;
	
		$videosPosts = new WP_Query();
		$videosPosts->query('post_type=listing&post_status=publish&posts_per_page=' . $numberOfListings );
		if($videosPosts->found_posts > 0) {
			while ($videosPosts->have_posts()) {
				

				$videosPosts->the_post();
				if(has_post_thumbnail()) {
					$images = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'listingpro-listing-grid' );
					$image = '<img src="'.$images[0].'" alt="">';
				}else {
					$image = '<img src="'.esc_url('https://placeholdit.imgix.net/~text?txtsize=33&w=184&h=135').'" alt="Listing Pro Placeholder">';
				}
				$gAddress = listing_get_metabox_by_ID('gAddress',get_the_ID());
				$rating = listing_get_metabox_by_ID('rating' ,get_the_ID());
				$rate = $rating;
				?>
				<article>
					<figure>
						<a href="<?php echo get_permalink(); ?>">
							<?php echo $image; ?>
						</a>
					</figure>
					<div class="details">
						<h4><a href="<?php echo get_permalink(); ?>"><?php echo substr(get_the_title(), 0, 45); ?></a></h4>
						<div class="widget-options">
							
							<span class="post-reviews widget-rating-box">
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
									}
								?>
							
							</span>
						</div>
						<div class="clearfix"></div>
						<?php if(!empty($gAddress)) { ?>
							<p><i class="fa fa-map-marker"></i> <?php echo $gAddress ?></p>
						<?php } ?>
					</div>
				</article>
				<?php
			}
		}else{
			echo '<p style="padding:25px;">No listing found</p>';
		}
wp_reset_postdata();
	echo $after_widget;
}



function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['numberOfListings'] = strip_tags($new_instance['numberOfListings']);
    $instance['video_posts_style'] = strip_tags($new_instance['video_posts_style']);
	return $instance;
}
 
 
} //end class recent_listing_Widget

function recent_listing_widget_registration() {
	register_widget('recent_listing_Widget');
}
add_action('widgets_init', 'recent_listing_widget_registration');