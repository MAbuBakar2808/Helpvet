<?php
	/* ============== ListingPro Get Home map content ============ */
		/* ============== ListingPro get child term (tags) in search ============ */
	
	if (!function_exists('listingpro_home_map')) {
		
		function listingpro_home_map(){
			wp_register_script('listingpro_home_map', get_template_directory_uri() . '/assets/js/home-map.js', array('jquery') ); 
			wp_enqueue_script('listingpro_home_map');

			wp_localize_script( 'listingpro_home_map', 'listingpro_home_map_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			));

		
		}
		if(!is_admin()){
			if(!is_front_page()){
				add_action('init', 'listingpro_home_map');
			}
		}
	}
	
	if (!function_exists('listingpro_home_map_content')) {
		
		add_action('wp_ajax_listingpro_home_map_content',        'listingpro_home_map_content');
		add_action('wp_ajax_nopriv_listingpro_home_map_content', 'listingpro_home_map_content');
		function listingpro_home_map_content() {
			$final;
			$lat;
			$long;
			$action = $_POST['trig'];
			if($action == 'home_map'){
				$type = 'listing';
				$args=array(
					'post_type' => $type,
					'post_status' => 'publish',
					'posts_per_page' => -1,
				);
				$my_query = new WP_Query($args);
				if( $my_query->have_posts() ) {
					while ($my_query->have_posts()) : $my_query->the_post();
					if ( has_post_thumbnail()) {
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), 'listingpro-blog-grid' );
							if(!empty($image[0])){
								$image = "<a href='".get_the_permalink()."' >
										<img src='" . $image[0] . "' />
									</a>";
							}	
					}else {
						$image = '<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=372&h=284', 'listingpro').'" alt="">';
					}
					
					
					$ids = get_the_ID();
					$cats = get_the_terms( get_the_ID(), 'listing-category' );										
					foreach ( $cats as $cat ) {
						$category_image = listing_get_tax_meta($cat->term_id,'category','image');		
					}
					$gAddress = listing_get_metabox('gAddress');
					$url = get_the_permalink();
					$lat = listing_get_metabox('latitude');
					$long = listing_get_metabox('longitude');
					$output[$ids] = array("latitude"=>$lat,"longitude"=>$long,"title"=>get_the_title(),"icon"=>$category_image,"address"=>$gAddress,"url"=>$url,"image"=>$image);
					endwhile;	
					
				}
			}
			$final = json_encode($output);
			die($final);
		}
		
	}