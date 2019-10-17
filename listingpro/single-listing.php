<?php
/**
 * The template for displaying Listing single page.
 *
 */


    global $listingpro_options;
    $listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
	$lp_detail_page_styles = $listingpro_options['lp_detail_page_styles'];

	if( $listing_mobile_view == 'app_view' && wp_is_mobile() )
	{
        get_header('app-view');
        get_template_part( 'mobile/templates/listing_app_view' );
        get_footer('app-view');

    }else
    {
	get_header();
	if($lp_detail_page_styles == 'lp_detail_page_styles1') {
		
	get_template_part( 'templates/listing_detail2' );
	
	}else{ 
		get_template_part( 'templates/listing_detail3' );
	} 
        get_footer();
    }
	 