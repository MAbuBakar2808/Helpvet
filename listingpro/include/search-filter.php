<?php
/**
 * Search Filters.
 *
 */
/* ============== ListingPro get child term (tags) in search ============ */
?>
<?php
if (!function_exists('listingpro_search_term_method')) {
    function listingpro_search_term_method()
    {
        wp_register_script('search-ajax-script', get_template_directory_uri() . '/assets/js/search-ajax.js', array(
            'jquery'
        ));
        wp_enqueue_script('search-ajax-script');
        wp_localize_script('search-ajax-script', 'ajax_search_term_object', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
    }
    if (!is_admin()) {
        add_action('init', 'listingpro_search_term_method');
    }
}
/* ============== ListingPro Search Term ============ */
add_action('wp_ajax_ajax_search_term', 'ajax_search_term');
add_action('wp_ajax_nopriv_ajax_search_term', 'ajax_search_term');
if (!function_exists('ajax_search_term')) {
    function ajax_search_term()
    {
        $term_id     = sanitize_text_field($_POST['term_id']);
        $count       = 1;
        $tagsHTML    = '';
        $featureName = '';
        $termparent  = '';
        $parent      = '';
		$hasfeature = false;
		$showdivwrap = true;
        if (!empty($term_id)) {
            $termparent = get_term_by('id', $term_id, 'listing-category');
            $parent     = $termparent->parent;
        }
        $features = listingpro_get_term_meta($term_id, 'lp_category_tags');
        if (empty($features)) {
            $features = listingpro_get_term_meta($parent, 'lp_category_tags');
        }
		
        if (!empty($features)) {
            
            foreach ($features as $feature) {
                $terms = get_term_by('id', $feature, 'features');
                if (!empty($terms)) {
					$featurCount = lp_count_postcount_taxonomy_term_byID('listing','features', $terms->term_id);
					
					if(!empty($featurCount)){
						$hasfeature = true;
					}
					if($hasfeature==true && $showdivwrap == true){
						
						$tagsHTML = '<div class="form-inline lp-features-filter tags-area"><div class="form-group"><div class="input-group margin-right-0"><ul>';
						
						$showdivwrap = false;
					}
					
						if(!empty($featurCount)){
							
						$tagsHTML .= '<li>';
						$tagsHTML .= '<div class="pad-bottom-10 checkbox">';
						$tagsHTML .= '<input type="checkbox" name="searchtags[' . $count . ']" id="check_' . $count . '" class="searchtags" value="' . $terms->term_id . '">';
						$tagsHTML .= '<label for="' . $terms->term_id . '">' . $terms->name . '</label>';
						$tagsHTML .= '</div>';
						$tagsHTML .= '</li>';
					}
					
                    $count++;
					
                }
            }
			if($hasfeature==true){
				$tagsHTML .= '</ul>';
				$tagsHTML .= '</div>';
				$tagsHTML .= '</div>';
				$tagsHTML .= '</div>';
			}
            
        }
        $term_group_result = json_encode(array(
            'html' => $tagsHTML
        ));
        die($term_group_result);
    }
}
/* ============== ListingPro Search Filter========== */
add_action('wp_ajax_ajax_search_tags', 'ajax_search_tags');
add_action('wp_ajax_nopriv_ajax_search_tags', 'ajax_search_tags');
if (!function_exists('ajax_search_tags')) {
    function ajax_search_tags()
    {
        global $listingpro_options;
		
		$lporderby = 'date';
		$lporders = 'DESC';
		if( isset($listingpro_options['lp_archivepage_listingorder']) ){
			$lporders = $listingpro_options['lp_archivepage_listingorder'];
		}
		if( isset($listingpro_options['lp_archivepage_listingorderby']) ){
			$lporderby = $listingpro_options['lp_archivepage_listingorderby'];
		}
		
		if($lporderby=="rand"){
			$lporders = '';
		}
		
		$pageno           = '';
        if (isset($_POST['pageno'])) {
            $pageno = $_POST['pageno'];
        }
		
		/* for radious filter */
		$sloc_address       = ( isset( $_POST[ 'sloc_address' ] ) ) ? $_POST[ 'sloc_address' ] : '';
		$my_bounds_ne_lat   = ( isset( $_POST[ 'my_bounds_ne_lat' ] ) ) ? $_POST[ 'my_bounds_ne_lat' ] : '';
		$my_bounds_ne_lng   = ( isset( $_POST[ 'my_bounds_ne_lng' ] ) ) ? $_POST[ 'my_bounds_ne_lng' ] : '';
		$my_bounds_sw_lat   = ( isset( $_POST[ 'my_bounds_sw_lat' ] ) ) ? $_POST[ 'my_bounds_sw_lat' ] : '';
		$my_bounds_sw_lng   = ( isset( $_POST[ 'my_bounds_sw_lng' ] ) ) ? $_POST[ 'my_bounds_sw_lng' ] : '';
		
		$units = $listingpro_options['lp_nearme_filter_param'];
		if(empty($units)){
			$units = 'km';
		}
	
		
		$squery = '';
		if(isset($_POST['skeyword'])){
			$squery               = sanitize_text_field($_POST['skeyword']);
		}
		
		$latlongfilter = false;
		$latlongArray = array();
		$openNowArray = array();
		$clat = '';
		$clong = '';
		if(isset($_POST['clat'])){
			$clat = sanitize_text_field($_POST['clat']);
		}
		if(isset($_POST['clong'])){
			$clong = sanitize_text_field($_POST['clong']);
		}
		
        $info                   = array('');
        $info['tag_name']         = $_POST['tag_name'];
        $info['cat_id']           = sanitize_text_field($_POST['cat_id']);
		
		if(isset($_POST['loc_id'])){
			if( is_numeric($_POST['loc_id'] ) ){
				$info['loc_id']    = ( $sloc_address != '' || $my_bounds_ne_lat != '' ) ? '': sanitize_text_field($_POST['loc_id']);
			}
			else{
				$locTerm = get_term_by('name', $_POST['loc_id'], 'location');
				$loc_ID = $locTerm->term_id;
				$info['loc_id']           = ( $sloc_address != '' || $my_bounds_ne_lat != '' ) ? '': $loc_ID;
			}
		}
        
        $info['listStyle']        = sanitize_text_field($_POST['list_style']);
        $info['inexpensive']      = sanitize_text_field($_POST['inexpensive']);
        $info['moderate']         = sanitize_text_field($_POST['moderate']);
        $info['pricey']           = sanitize_text_field($_POST['pricey']);
        $info['ultra']            = sanitize_text_field($_POST['ultra']);
        $info['averageRate']      = sanitize_text_field($_POST['averageRate']);
        $info['mostRewvied']      = sanitize_text_field($_POST['mostRewvied']);
        $info['listing_openTime'] = sanitize_text_field($_POST['listing_openTime']);
        $info['mostviewed'] 	  = sanitize_text_field($_POST['mostviewed']);
        $info['lp_s_tag'] 	  	  = sanitize_text_field($_POST['lpstag']);
        $tagQuery                 = '';
        $catQuery                 = '';
        $searchtagQuery                 = '';
        $listing_time             = '';
		$opentimeswitch = false;
		$opentimefilter = false;
        $sFeatures                = '';
        $sFeatures                = $_POST['tag_name'];
        if (!empty($info['listing_openTime'])) {
            $listing_time = $info['listing_openTime'];
			$opentimeswitch = true;
        }
		global $paged;
        if (!empty($pageno)) {
            $paged = $pageno;
        }
        $priceQuery   = array();
        $categoryName = '';
        $LocationName = '';
        $locQuery     = '';
        $currentTax   = '';
        if (!empty($info['tag_name'])) {
            $tagQuery = array(
				'taxonomy' => 'features',
				'field' => 'id',
				'terms' => $info['tag_name'],
				'operator' => 'AND',
            );
        }
        if (!empty($info['cat_id'])) {
            $categoryName = get_term_by('id', $info['cat_id'], 'listing-category');
            $categoryName = $categoryName->name;
            $catQuery     = array(
                'taxonomy' => 'listing-category',
                'field' => 'id',
                'terms' => $info['cat_id']
            );
        }
        if (!empty($info['loc_id'])) {
            $LocationName = get_term_by('id', $info['loc_id'], 'location');
            $LocationName = $LocationName->name;
            $locQuery     = array(
                'taxonomy' => 'location',
                'field' => 'id',
                'terms' => $info['loc_id']
            );
        }
		
		if( !empty($info['lp_s_tag']) && isset($info['lp_s_tag'])){
			$lpsTag = $info['lp_s_tag'];
			$searchtagQuery = array(
				'taxonomy' => 'list-tags',
				'field' => 'id',
				'terms' => $lpsTag,
				'operator'=> 'IN' //Or 'AND' or 'NOT IN'
			);
		}
        /* added by zaheer on 13 march */
        $orderBy        = $lporderby;
		
        $rateArray      = '';
        $reviewedArray  = '';
        $viewedArray    = array();
        $statusArray    = array();
        $optenTimeArray = array();
        $lpcountwhile = 1;
        $relation       = 'OR';
        if (!empty($info['averageRate'])) {
            $orderBy   = 'meta_value_num';
            $rateArray = array(
                'key' => $info['averageRate'],
                'compare' => 'EXIST'
            );
			
			$lporders = '';
			
        }
		if (!empty($info['mostviewed'])) {
            $orderBy       = 'meta_value_num';
            $viewedArray = array(
                'key' => 'post_views_count',
				'value'   => '1',
                'compare' => '>='
            );
			$lporders = '';
        }
        if (!empty($info['mostRewvied'])) {
            $orderBy       = 'meta_value_num';
            $reviewedArray = array(
                'key' => $info['mostRewvied'],
                'compare' => 'EXIST'
            );
			$lporders = '';
        }
        if (!empty($info['inexpensive'])) {
            $inexArray = array(
                'key' => 'lp_listingpro_options',
                'value' => 'inexpensive',
                'compare' => 'LIKE'
            );
        }
        if (!empty($info['moderate'])) {
            $moderArray = array(
                'key' => 'lp_listingpro_options',
                'value' => 'moderate',
                'compare' => 'LIKE'
            );
        }
        if (!empty($info['pricey'])) {
            $pricyArray = array(
                'key' => 'lp_listingpro_options',
                'value' => 'pricey',
                'compare' => 'LIKE'
            );
        }
        if (!empty($info['ultra'])) {
            $ultrArray = array(
                'key' => 'lp_listingpro_options',
                'value' => 'ultra_high_end',
                'compare' => 'LIKE'
            );
        }
        if (!empty($info['inexpensive']) || !empty($info['moderate']) || !empty($info['pricey']) || !empty($info['ultra'])) {
            $statusArray = array(
                'key' => 'lp_listingpro_options',
                'value' => 'price_status',
                'compare' => 'LIKE'
            );
            $relation    = "AND";
        }
        if (!empty($info['inexpensive']) || !empty($info['moderate']) || !empty($info['pricey']) || !empty($info['ultra']) || !empty($info['averageRate']) || !empty($info['mostRewvied']) || !empty($info['mostviewed']) ) {
            $priceQuery = array(
                'relation' => $relation, // Optional, defaults to "AND"
                $statusArray,
                array(
                    'relation' => 'OR',
                    $inexArray,
                    $moderArray,
                    $pricyArray,
                    $ultrArray
                ),
                array(
                    'relation' => 'OR',
                    $rateArray,
                    $reviewedArray,
					$viewedArray
                )
            );
        }
		
		$listingperpage = '';
		if(isset($listingpro_options['listing_per_page']) && !empty($listingpro_options['listing_per_page'])){
			$listingperpage = $listingpro_options['listing_per_page'];
		}
		else{
			$listingperpage = 10;
		}
		
		/* if nearme is on */
		$listingperpageMain = '';
		if( (!empty($clat) && !empty($clong)) || $listing_time=="open" ){
			
			$listingperpageMain = -1;
			
		}else{
			$listingperpageMain = $listingperpage;
		}
		/* end if nearme is on */
		
        /* added by zaheer on 13 march */
        $searchQuery = '';
        $TxQuery     = array(
			$searchtagQuery,
            $tagQuery,
            $catQuery,
            $locQuery
        );
        if (empty($TxQuery)) {
            $TxQuery = array();
        }
        $ad_campaignsIDS = listingpro_get_campaigns_listing('lp_top_in_search_page_ads', TRUE, $TxQuery, $searchQuery, $priceQuery, null, null, null);
        $type            = 'listing';
        $args            = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => $listingperpageMain,
            'paged' => $paged,
            's' => $squery,
            'post__not_in' => $ad_campaignsIDS,
            'orderby' => $orderBy,
			'order'   => $lporders,
            /* 'meta_key'  => $metaKey, */
            'meta_query' => $priceQuery,
            'tax_query' => array(
				$searchtagQuery,
                $tagQuery,
                $catQuery,
                $locQuery
            )
        );
		
		$lp_lat = '';
		$lp_lng = '';
		
        $my_query        = null;
        $output          = null;
        $result          = null;
        $found           = null;
        $my_query        = new WP_Query($args);
        $found           = $my_query->found_posts;
        $output .= '<div class="promoted-listings">';
        ob_start();
        $output .= listingpro_get_campaigns_listing('lp_top_in_search_page_ads', false, $TxQuery, $searchQuery, $priceQuery, $s=null, $noOFListing=null, $ad_campaignsIDS);
        $output .= ob_get_contents();
        ob_end_clean();
		ob_flush();
        $output .= '</div>';
        if ($my_query->have_posts()) {
			/* $listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
            if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
            {
				$htmlOutput .=  '<div class="map-view-list-container">';
			   while ($my_query->have_posts()):
				   $my_query->the_post();
				   ob_start();
				   get_template_part('mobile/listing-loop-app-view2');
				   $htmlOutput .= ob_get_contents();
				   ob_end_clean();
			   endwhile;
			   wp_reset_query();
			   $htmlOutput .=  '</div>';
			} */
            while ($my_query->have_posts()):
                $my_query->the_post();
				
				/* ///////radious filter starts//////// */
				$flag   = true;
				if ( (isset( $_POST[ 'sloc_address' ] ) && $_POST[ 'sloc_address' ] != '' ) || (!empty($clat) && !empty($clong))) {
					
					if(!empty($clat) && !empty($clong)){
						$my_bounds_ne_lat = $clat;
						$my_bounds_ne_lng = $clong;
						
						$my_bounds_sw_lat = $clat;
						$my_bounds_sw_lng = $clong;
					}
					
					$lp_lat = listing_get_metabox_by_ID('latitude', get_the_ID());
					$lp_lng = listing_get_metabox_by_ID('longitude', get_the_ID());

				  $lp_my_distance_range   = (int)$_POST[ 'distance_range' ];
				  $ne_distance       = haversineGreatCircleDistance( $lp_lat, $lp_lng, $my_bounds_ne_lat, $my_bounds_ne_lng );
				  $sw_distance       = haversineGreatCircleDistance( $lp_lat, $lp_lng, $my_bounds_sw_lat, $my_bounds_sw_lng );

				  $flag1   = ( $lp_my_distance_range >= $ne_distance || $lp_my_distance_range >= $sw_distance ) ? true : false;
				  if ( ! $flag1 ) {
					$flag   = $flag1;
				  }

					//$latlongfilter = true;
					
				}

				//Zoom Search
				$lp_data_zoom              = ( isset( $_POST[ 'data_zoom' ] ) ) ? $_POST[ 'data_zoom' ] : '';
				if ( ! $flag || $lp_data_zoom == 'yes' ) {
				  $flag2   = listingproc_inBounds($lp_lat, $lp_lng, $my_bounds_ne_lat, $my_bounds_ne_lng, $my_bounds_sw_lat, $my_bounds_sw_lng);
				  if ( ! $flag2 ) {
					continue;
				  }
				}
				/* ///////radious filter end//////// */
				
                if ($listing_time == 'open') {
                    $openStatus = listingpro_check_time(get_the_ID(), true);
                    if ($openStatus == 'open') {
						
						$this_lat = listing_get_metabox_by_ID('latitude',get_the_ID());
						$this_long = listing_get_metabox_by_ID('longitude',get_the_ID());
						if( !empty($clat) && !empty($clong) ){
							if( !empty($this_lat) && !empty($this_long) ){
								$latlongfilter = true;
								$calDistance = GetDrivingDistance($clat, $this_lat, $clong, $this_long, $units);
								if(!empty($calDistance['distance'])){
									$latlongArray[get_the_ID()] = $calDistance['distance'];
								}
							}
							
						}
						
						if($latlongfilter==false){
							$optenTimeArray[get_the_ID()] = get_the_ID();
							/* ob_start();
							global $listingpro_options;
							$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
							if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
							{
								get_template_part('mobile/listing-loop-app-view');
							}
							else
							{
								get_template_part('listing-loop');
							}							
							$htmlOutput .= ob_get_contents();
							ob_end_clean();
							ob_flush(); */
						}
                        
                    }
                } else {
					$this_lat = listing_get_metabox_by_ID('latitude',get_the_ID());
					$this_long = listing_get_metabox_by_ID('longitude',get_the_ID());
					if( !empty($clat) && !empty($clong) ){
						if( !empty($this_lat) && !empty($this_long) ){
							$latlongfilter = true;
							$calDistance = GetDrivingDistance($clat, $this_lat, $clong, $this_long, $units);
							if(!empty($calDistance['distance'])){
								$latlongArray[get_the_ID()] = $calDistance['distance'];
							}
						}
						
					}
					if($latlongfilter==false){
						ob_start();
						global $listingpro_options;
						$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
						if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
						{
							get_template_part('mobile/listing-loop-app-view');
						}
						else
						{
							get_template_part('listing-loop');
						}							
						$htmlOutput .= ob_get_contents();
						ob_end_clean();
						ob_flush();
					}
                }
            endwhile;
            wp_reset_query();
			
			
			if($latlongfilter==true){
						$keysArrray = array();
						if(!empty($latlongArray)){
							asort($latlongArray);
							foreach ($latlongArray as $key=>$val){
								$keysArrray [] = $key;
							}
						}
						
						
					$argss            = array(
					'post_type' => $type,
					'posts_per_page' => $listingperpage,
					'paged' => $paged,
					'post__in' => $keysArrray,
					'orderby'        => 'post__in',
					'order'          => 'ASC'
					
					);
					$my_query        = null;
					$my_query        = new WP_Query($argss);
					$found           = $my_query->found_posts;
					 if ($my_query->have_posts()) {
						$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
						if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
						{ 
							$htmlOutput .=  '<div class="map-view-list-container">';
						   while ($my_query->have_posts()):
							   $my_query->the_post();
							   ob_start();
							   get_template_part('mobile/listing-loop-app-view2');
							   $htmlOutput .= ob_get_contents();
							   ob_end_clean();
						   endwhile;
						   wp_reset_query();
						   $htmlOutput .=  '</div>';
						}
						 
						while ($my_query->have_posts()):
							
							$my_query->the_post();
							$this_lat = listing_get_metabox_by_ID('latitude',get_the_ID());
							$this_long = listing_get_metabox_by_ID('longitude',get_the_ID());
							
							$calDistance = GetDrivingDistance($clat, $this_lat, $clong, $this_long, $units);
							
							if ( isset( $_POST[ 'sloc_address' ] ) && $_POST[ 'sloc_address' ] != '' ) {
							}else{
								if(!empty($calDistance['distance'])){
									$nearbydata= $calDistance['distance'].' '.$units;
									$htmlOutput .= '<div class="lp-nearby-dist-data" data-lpnearbydist = "'.$nearbydata.'"></div>';
								}
							}
							ob_start();
							global $listingpro_options;
							$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
							if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
							{
								get_template_part('mobile/listing-loop-app-view');
							}
							else
							{
								get_template_part('listing-loop');
							}							
							$htmlOutput .= ob_get_contents();
							ob_end_clean();
							ob_flush();
							if(!empty($calDistance['distance'])){
								$htmlOutput.='</div>';
							}
							
						endwhile;
						wp_reset_query();
					 }
			}
			if( !empty($optenTimeArray) ){
						$keysArrray = array();
						if(!empty($optenTimeArray)){
							asort($optenTimeArray);
							foreach ($optenTimeArray as $key=>$val){
								$keysArrray [] = $key;
							}
						}
						
						
					$argss            = array(
					'post_type' => $type,
					'posts_per_page' => $listingperpage,
					'paged' => $paged,
					'post__in' => $keysArrray,
					'orderby'        => 'post__in',
					'order'          => 'ASC'
					
					);
					$my_query        = null;
					$my_query        = new WP_Query($argss);
					$found           = $my_query->found_posts;
					 if ($my_query->have_posts()) {
						$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
						if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
						{ 
							$htmlOutput .=  '<div class="map-view-list-container">';
						   while ($my_query->have_posts()):
							   $my_query->the_post();
							   ob_start();
							   get_template_part('mobile/listing-loop-app-view2');
							   $htmlOutput .= ob_get_contents();
							   ob_end_clean();
						   endwhile;
						   wp_reset_query();
						   $htmlOutput .=  '</div>';
						}
						 
						while ($my_query->have_posts()):
							
							$my_query->the_post();
							
							ob_start();
							global $listingpro_options;
							$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
							if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
							{
								get_template_part('mobile/listing-loop-app-view');
							}
							else
							{
								get_template_part('listing-loop');
							}							
							$htmlOutput .= ob_get_contents();
							ob_end_clean();
							ob_flush();
							
							
						endwhile;
						wp_reset_query();
					 }
			}
		
            if (empty($htmlOutput)) {
                $output .= '


						<div class="text-center margin-top-80 margin-bottom-80">


							<h2>' . esc_html__('No Results', 'listingpro') . '</h2>


							<p>' . esc_html__('Sorry! There are no listings matching your search.', 'listingpro') . '</p>


							<p>' . esc_html__('Try changing your search filters or ', 'listingpro') . '<a href="' . $currentURL . '">' . esc_html__('Reset Filter', 'listingpro') . '</a></p>


						</div>


						';
            } else {
                $output .= $htmlOutput;
            }
        } elseif (empty($ad_campaignsIDS)) {
            $output .= '


						<div class="text-center margin-top-80 margin-bottom-80">


							<h2>' . esc_html__('No Results', 'listingpro') . '</h2>


							<p>' . esc_html__('Sorry! There are no listings matching your search.', 'listingpro') . '</p>


							<p>' . esc_html__('Try changing your search filters or ', 'listingpro') . '<a href="' . $currentURL . '">' . esc_html__('Reset Filter', 'listingpro') . '</a></p>


						</div>


						';
        }
        if (($found > 0)) {
            $foundtext = 'Results';
        } else {
            $foundtext = 'Result';
        }
		if (!empty($htmlOutput)) {
			$output .= listingpro_load_more_filter($my_query, $pageno, $squery);
			/* if ($opentimeswitch==true) {
				if($opentimefilter==true){
					$output .= listingpro_load_more_filter($my_query, $pageno, $squery);
				}
			}
			else{
				$output .= listingpro_load_more_filter($my_query, $pageno, $squery);
			} */
		}
        $output            = utf8_encode($output);
        $term_group_result = json_encode(array(
            "foundtext" => $foundtext,
            "found" => $found,
            "tags" => $info['tag_name'],
            "cat" => $categoryName,
            "city" => $LocationName,
            "html" => $output,
            "opentime" => $listing_time,
            "dfdfdfdf" => $latlongArray,
			"latlongfilter" => $latlongfilter,
			"opentimefilter" => $opentimefilter,
        ));
        die($term_group_result);
    }
}
/* ddfd */
/* ============== ListingPro Home page========== */
add_action('wp_ajax_listingpro_suggested_search', 'listingpro_suggested_search');
add_action('wp_ajax_nopriv_listingpro_suggested_search', 'listingpro_suggested_search');
if (!function_exists('listingpro_suggested_search')) {
    function listingpro_suggested_search()
    {
        global $listingpro_options;
        $qString      = '';
        $qString      = sanitize_text_field($_POST['tagID']);
        $qString      = strtolower($qString);
        $output       = null;
        $TAGOutput    = null;
        $CATOutput    = null;
        $TagCatOutput = null;
        $TitleOutput  = null;
        if (empty($qString)) {
            global $listingpro_options;
            $cats;
            $ucat       = array(
                'post_type' => 'listing',
                'hide_empty' => false,
                'orderby' => 'count',
                'order' => 'ASC',
                'parent' => 0
            );
            $catIcon    = '';
            $categories = get_terms('listing-category', $ucat);
            foreach ($categories as $cat) {
                $catIcon = listingpro_get_term_meta($cat->term_id, 'lp_category_image');
                if (!empty($catIcon)) {
                    $catIcon = '<img src="' . $catIcon . '" />';
                }
                $cats[] = '<li class="lp-default-cats" data-catid="' . $cat->term_id . '">' . $catIcon . '<span class="lp-s-cat">' . $cat->name . '</span></li>';
            }
            $output           = array(
                'tag' => '',
                'cats' => $cats,
                'tagsncats' => '',
                'titles' => '',
                'more' => ''
            );
            $query_suggestion = json_encode(array(
                "tagID" => $qString,
                "suggestions" => $output
            ));
            die($query_suggestion);
        } else {
            $args     = array(
                'posts_per_page' => -1, // Number of related posts to display.
                'post_type' => 'listing',
                'post_status' => 'publish'
            );
            $my_query = new wp_query($args);
            if ($my_query->have_posts()) {
                while ($my_query->have_posts()):
                    $my_query->the_post();
                    $tagTerms = get_the_terms(get_the_ID(), 'list-tags');
                    $catTerms = get_the_terms(get_the_ID(), 'listing-category');
                    $locTerms = get_the_terms(get_the_ID(), 'location');
                    $catName  = '';
                    $catIcon  = '';
                    $locNames = '';
                    if (!empty($catTerms) && !empty($tagTerms)) {
                        $catName = $catTerms[0];
                        $term_id = $catName->term_id;
                        $parent  = '';
                        if (!empty($term_id)) {
                            $termparent = get_term_by('id', $term_id, 'listing-category');
                            $parent     = $termparent->parent;
                        }
                        $catIcon = listingpro_get_term_meta($catName->term_id, 'lp_category_image');
                        if (empty($catIcon)) {
                            $catIcon = listingpro_get_term_meta($parent, 'lp_category_image');
                        }
                        if (!empty($catIcon)) {
                            $catIcon = '<img class="lp-s-caticon" src="' . $catIcon . '" />';
                        }
                        foreach ($tagTerms as $tag) {
                            if (strpos(strtolower($tag->name), $qString) === 0) {
                                $TAGOutput[]    = '<li class="lp-wrap-tags" data-tagid="' . $tag->term_id . '"><span class="lp-s-tag">' . $tag->name . '</span></li>';
                                $TagCatOutput[] = '<li class="lp-wrap-catsntags" data-tagid="' . $tag->term_id . '" data-catid="' . $catName->term_id . '">' . $catIcon . '<span class="lp-s-tag">' . $tag->name . '</span><span> '.esc_html__('in', 'listingpro').' </span><span class="lp-s-cat">' . $catName->name . '</span></li>';
                            }
                        }
                        foreach ($catTerms as $cat) {
                            if (strpos(strtolower($cat->name), $qString) === 0) {
                                $CATOutput[] = '<li class="lp-wrap-cats" data-catid="' . $cat->term_id . '">' . $catIcon . '<span class="lp-s-cat">' . $cat->name . '</span></li>';
                            }
                        }
                    }
					if ( !empty($tagTerms) ) {
						foreach ($tagTerms as $tag) {
							if (strpos(strtolower($tag->name), $qString) === 0) {
								$TAGOutput[]    = '<li class="lp-wrap-tags" data-tagid="' . $tag->term_id . '"><span class="lp-s-tag">' . $tag->name . '</span></li>';
							}
						}
					}
					
					if( !empty($catTerms) ){
						foreach ($catTerms as $cat) {
                            if (strpos(strtolower($cat->name), $qString) === 0) {
                                $CATOutput[] = '<li class="lp-wrap-cats" data-catid="' . $cat->term_id . '">' . $catIcon . '<span class="lp-s-cat">' . $cat->name . '</span></li>';
                            }
                        }
					}
					
                    $listThumb = '';
                    if (has_post_thumbnail()) {
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail');
                        if (!empty($image[0])) {
                            $listThumb = "<img src='" . $image[0] . "' />


											";
                        } else {
                            $listThumb = '<img src="' . esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=50&h=50', 'listingpro') . '" alt="">';
                        }
                    }
                    $listTitle  = get_the_title();
                    $listTitle  = strtolower($listTitle);
                    $machTitles = strpos($listTitle, $qString);
                    if ($machTitles !== false) {
                        $TitleOutput[] = '<li class="lp-wrap-title" data-url="' . get_the_permalink() . '">' . $listThumb . '<span class="lp-s-title"><a href="' . get_the_permalink() . '">' . $listTitle . ' <span class="lp-loc">' . $locTerms[0]->name . '</span></a></span></li>';
                    }
                endwhile;
                wp_reset_postdata();
            }
            $TAGOutput    = array_unique($TAGOutput);
            $CATOutput    = array_unique($CATOutput);
            $TagCatOutput = array_unique($TagCatOutput);
            $TitleOutput  = array_unique($TitleOutput);
            if ((!empty($TAGOutput) && count($TAGOutput) > 0) || (!empty($CATOutput) && count($CATOutput) > 0) || (!empty($TagCatOutput) && count($TagCatOutput) > 0) || (!empty($TitleOutput) && count($TitleOutput) > 0)) {
                $output = array(
                    'tag' => $TAGOutput,
                    'cats' => $CATOutput,
                    'tagsncats' => $TagCatOutput,
                    'titles' => $TitleOutput,
                    'more' => '',
                    'matches' => $machTitles
                );
            } else {
                $moreResult = array();
                $mResults   = '<strong>' . esc_html__('More results for ', 'listingpro') . '</strong>';
                $mResults .= $qString;
                $moreResult[] = '<li class="lp-wrap-more-results" data-moreval="' . $qString . '">' . $mResults . '</li>';
                $output       = array(
                    'tag' => '',
                    'cats' => '',
                    'tagsncats' => '',
                    'titles' => '',
                    'more' => $moreResult
                );
            }
            $query_suggestion = json_encode(array(
                "tagID" => $qString,
                "suggestions" => $output
            ));
            die($query_suggestion);
        }
    }
}
/* ======================show cateogries on focus================ */
add_action('wp_ajax_listingpro_suggested_cats', 'listingpro_suggested_cats');
add_action('wp_ajax_nopriv_listingpro_suggested_cats', 'listingpro_suggested_cats');
if (!function_exists('listingpro_suggested_cats')) {
    function listingpro_suggested_cats()
    {
        global $listingpro_options;
        $cats;
        $homeSearchCategory = $listingpro_options['home_banner_search_cats'];
        $ucat               = array(
            'post_type' => 'listing',
            'hide_empty' => false,
            'orderby' => 'count',
            'order' => 'ASC',
            'include' => $homeSearchCategory
        );
        $categories         = get_terms('listing-category', $ucat);
        foreach ($categories as $category) {
            $cats[] = $category->name;
        }
        $query_suggestion = json_encode(array(
            "cats" => $cats
        ));
        die($query_suggestion);
    }
}
/* ======================show cateogries on focus================ */

	/* ============== ListingPro website visits ============ */
	
	add_action('wp_ajax_listingpro_website_visit',        'listingpro_website_visit');
	add_action('wp_ajax_nopriv_listingpro_website_visit', 'listingpro_website_visit');
	
	if (!function_exists('listingpro_website_visit')) {
		function listingpro_website_visit(){
			$lpCountry = '';
			$lpCity = '';
			$lpZip = '';
			$lp_id = '';
			$lp_id = $_POST['lp-id'];
			$lpCountry = $_POST['lp-country'];
			$lpCity = $_POST['lp-city'];
			$lpZip = $_POST['lp-zip'];
			$actor = esc_html__('Someone', 'listingpro');
			if ( is_user_logged_in() ) {
				$current_user = wp_get_current_user();
				$actor = $current_user->user_login;
			}
			
			$visitorInfo = esc_html__('Country : ', 'listingpro');
			$visitorInfo .= $lpCountry;
			$visitorInfo .= esc_html__(' City : ', 'listingpro');
			$visitorInfo .= $lpCity;
			$visitorInfo .= esc_html__(' Zip : ', 'listingpro');
			$visitorInfo .= $lpZip;
			
			$listing_id = $lp_id;
			$listingData = get_post($listing_id);
			$authID = $listingData->post_author;
			//$currentdate = date("Y-m-d h:i:a");
			//$currentdate = date("d-m-Y h:i:a");
			$currentdate =  current_time('mysql');
			
			/* updating lead */
			$leadsCount = '';
			$leadsCount = get_user_meta( $authID, 'leads_count', true );
			if( isset($leadsCount) ){
				$leadsCount = (int)$leadsCount + 1;
				update_user_meta($authID, 'leads_count', $leadsCount);
			}
			else{
				$leadsCount = 0;
				update_user_meta($authID, 'leads_count', $leadsCount);
			}
			/*  */
			$activityData = array();
			$activityData = array( array(
				'type'	=>	'visit',
				'actor'	=>	$actor,
				'reviewer'	=>	$visitorInfo,
				'listing'	=>	$listing_id,
				'rating'	=>	'',
				'time'	=>	$currentdate
			));
			
			$updatedActivitiesData = array();
			$lp_recent_activities = get_option( 'lp_recent_activities' );
				if( $lp_recent_activities!=false ){
					
					$existingActivitiesData = get_option( 'lp_recent_activities' );
					if (array_key_exists($authID, $existingActivitiesData)) {
						$currenctActivityData = $existingActivitiesData[$authID];
						if(!empty($currenctActivityData)){
							if(count($currenctActivityData)>=20){
							$currenctActivityData =	array_slice($currenctActivityData,1,20);
								$updatedActivityData = array_merge($currenctActivityData,$activityData);
							}
							else{
								$updatedActivityData = array_merge($currenctActivityData,$activityData);
							}
						}
						$existingActivitiesData[$authID] = $updatedActivityData;
					}
					else{
						$existingActivitiesData[$authID] = $activityData;
					}
					$updatedActivitiesData = $existingActivitiesData;
				}
				else{
					$updatedActivitiesData[$authID] = $activityData;
				}
				update_option( 'lp_recent_activities', $updatedActivitiesData );
			
			
			
			$lp_response = json_encode(array("success"=>"ok"));
			die($lp_response);
		}
	}
/* ============== ListingPro phone number clicked ============ */
	
	add_action('wp_ajax_listingpro_phone_clicked',        'listingpro_phone_clicked');
	add_action('wp_ajax_nopriv_listingpro_phone_clicked', 'listingpro_phone_clicked');
	
	if (!function_exists('listingpro_phone_clicked')) {
		function listingpro_phone_clicked(){
			$lpCountry = '';
			$lpCity = '';
			$lpZip = '';
			$lp_id = '';
			$lp_id = $_POST['lp-id'];
			$lpCountry = $_POST['lp-country'];
			$lpCity = $_POST['lp-city'];
			$lpZip = $_POST['lp-zip'];
			$actor = esc_html__('Someone', 'listingpro');
			if ( is_user_logged_in() ) {
				$current_user = wp_get_current_user();
				$actor = $current_user->user_login;
			}
			
			$visitorInfo = esc_html__('Country : ', 'listingpro');
			$visitorInfo .= $lpCountry;
			$visitorInfo .= esc_html__(' City : ', 'listingpro');
			$visitorInfo .= $lpCity;
			$visitorInfo .= esc_html__(' Zip : ', 'listingpro');
			$visitorInfo .= $lpZip;
			
			$listing_id = $lp_id;
			$listingData = get_post($listing_id);
			$authID = $listingData->post_author;
			//$currentdate = date("Y-m-d h:i:a");
			//$currentdate = date("d-m-Y h:i:a");
			$currentdate =  current_time('mysql');
			
			
			/* updating lead */
			$leadsCount = '';
			$leadsCount = get_user_meta( $authID, 'leads_count', true );
			if( isset($leadsCount) ){
				$leadsCount = (int)$leadsCount + 1;
				update_user_meta($authID, 'leads_count', $leadsCount);
			}
			else{
				$leadsCount = 0;
				update_user_meta($authID, 'leads_count', $leadsCount);
			}
			/*  */
			$activityData = array();
			$activityData = array( array(
				'type'	=>	'phone',
				'actor'	=>	$actor,
				'reviewer'	=>	$visitorInfo,
				'listing'	=>	$listing_id,
				'rating'	=>	'',
				'time'	=>	$currentdate
			));
			
			$updatedActivitiesData = array();
			$lp_recent_activities = get_option( 'lp_recent_activities' );
				if( $lp_recent_activities!=false ){
					
					$existingActivitiesData = get_option( 'lp_recent_activities' );
					if (array_key_exists($authID, $existingActivitiesData)) {
						$currenctActivityData = $existingActivitiesData[$authID];
						if(!empty($currenctActivityData)){
							if(count($currenctActivityData)>=20){
							$currenctActivityData =	array_slice($currenctActivityData,1,20);
								$updatedActivityData = array_merge($currenctActivityData,$activityData);
							}
							else{
								$updatedActivityData = array_merge($currenctActivityData,$activityData);
							}
						}
						$existingActivitiesData[$authID] = $updatedActivityData;
					}
					else{
						$existingActivitiesData[$authID] = $activityData;
					}
					$updatedActivitiesData = $existingActivitiesData;
				}
				else{
					$updatedActivitiesData[$authID] = $activityData;
				}
				update_option( 'lp_recent_activities', $updatedActivitiesData );
			
			
			
			$lp_response = json_encode(array("success"=>"ok"));
			die($lp_response);
		}
	}
	
	
if(!function_exists('listingproc_inBounds')){	
	function listingproc_inBounds($pointLat, $pointLong, $boundsNElat, $boundsNElong, $boundsSWlat, $boundsSWlong) {
		$eastBound = $pointLong < $boundsNElong;
		$westBound = $pointLong > $boundsSWlong;

		if ($boundsNElong < $boundsSWlong) {
			$inLong = $eastBound || $westBound;
		} else {
			$inLong = $eastBound && $westBound;
		}

		$inLat = $pointLat > $boundsSWlat && $pointLat < $boundsNElat;
		return $inLat && $inLong;
	}
}// listingproc_inBounds

if(!function_exists('haversineGreatCircleDistance')){
	
	function haversineGreatCircleDistance( $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371){
	  $latFrom = deg2rad($latitudeFrom);
	  $lonFrom = deg2rad($longitudeFrom);
	  $latTo = deg2rad($latitudeTo);
	  $lonTo = deg2rad($longitudeTo);

	  $latDelta = $latTo - $latFrom;
	  $lonDelta = $lonTo - $lonFrom;

	  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
	  cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	  return $angle * $earthRadius;
	}
}