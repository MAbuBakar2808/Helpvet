<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<?php
global $listingpro_options;
$listing_mobile_view   =  $listingpro_options['single_listing_mobile_view'];
$lp_default_map_location_lat = 0;
$lp_default_map_location_long = -0;
if( (isset($listingpro_options['lp_default_map_location_lat'])) && (isset($listingpro_options['lp_default_map_location_long'])) ){
	if( (!empty($listingpro_options['lp_default_map_location_lat'])) && (!empty($listingpro_options['lp_default_map_location_long'])) ){
		$lp_default_map_location_lat   =  $listingpro_options['lp_default_map_location_lat'];
		$lp_default_map_location_long   =  $listingpro_options['lp_default_map_location_long'];
	}
}
if( !is_admin() && $listing_mobile_view == 'app_view' && wp_is_mobile() && is_front_page())
{

   $app_view_home  =   $listingpro_options['app_view_home'];
   if( $app_view_home != '' && !empty( $app_view_home ) ){
       wp_redirect( $app_view_home );
       exit;
   }

}
if( $listing_mobile_view == 'app_view' && wp_is_mobile() ){
    get_template_part( 'header-app-view' );
}else
{
?>

<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
	   <!-- Mobile Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">		<!-- Favicon -->
		<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
		<?php listingpro_favicon(); 
			global $listingpro_options;
			$listing_detail_slider_style = $listingpro_options['lp_detail_slider_styles'];
		?>	
		<?php wp_head(); ?>
    </head>
    <body <?php body_class() ?> data-submitlink="<?php echo listingpro_url('submit-listing'); ?>" data-sliderstyle="<?php echo esc_attr($listing_detail_slider_style); ?>" data-defaultmaplat="<?php echo esc_attr($lp_default_map_location_lat); ?>" data-defaultmaplot="<?php echo esc_attr($lp_default_map_location_long); ?>">
	
	<?php
		$mapbox_token= '';
		$map_style= '';
		$mapOption = $listingpro_options['map_option'];

		$search_view = $listingpro_options['search_views'];
		$search_layout = $listingpro_options['search_layout'];
		$alignment = $listingpro_options['search_alignment'];
		$top_banner_styles = $listingpro_options['top_banner_styles'];

		$alignClass = '';
		if( $top_banner_styles == 'map_view' ) {			
			if ( $alignment == 'align_top' ) {
				$alignClass = 'lp-align-top';
			}elseif ( $alignment == 'align_middle' ) {
				$alignClass = 'lp-align-underBanner';
			}elseif ( $alignment == 'align_bottom' ) {
				$alignClass = 'lp-align-bottom';
			}
		}


		if($mapOption == 'mapbox'){
			$mapbox_token = $listingpro_options['mapbox_token'];
			$map_style = $listingpro_options['map_style'];
		}
		
		
		$primary_logo = $listingpro_options['primary_logo']['url'];
		$listing_style = '';
		$listing_styledata = '';
		$listing_style = $listingpro_options['listing_style'];
		if(isset($_GET['list-style']) && !empty($_GET['list-style'])){
			$listing_styledata = 'data-list-style="'.esc_attr($_GET['list-style']).'"';
			$listing_style = esc_html($_GET['list-style']);
		}

		$header_views = $listingpro_options['header_views'];
		$topBannerView = $listingpro_options['top_banner_styles'];
		$ipAPI = $listingpro_options['lp_current_ip_type'];
		$videoBanner = '';
		$imgClass = '';
		if( $topBannerView == 'map_view' ) {
			$imgClass = '';
		}elseif ( $topBannerView=="banner_view") {
			
			$videoBanner = $listingpro_options['lp_video_banner_on'];
			if($videoBanner=="video_banner"){
				$imgClass = 'lp-vedio-bg';
			}
			else{
				$imgClass = 'lp-header-bg';
			}
			
		}
		
		$locPattern = '';
		
		if(isset($listingpro_options['lp_listing_locations_field_options'])){
			$locPattern  = $listingpro_options['lp_listing_locations_field_options'];
		}
		
		
		
	?>
	
	<div id="page" class="clearfix" <?php echo esc_attr($listing_styledata); ?> data-lpattern="<?php echo esc_attr($locPattern); ?>" data-mtoken="<?php echo esc_attr($mapbox_token); ?>"  data-mstyle="<?php echo esc_attr($map_style); ?>" data-sitelogo="<?php echo esc_attr($primary_logo); ?>" data-site-url="<?php echo esc_url(home_url('/')); ?>"  data-ipapi="<?php echo $ipAPI ?>">
	
	<!--==================================Header Open=================================-->
<div class="pos-relative">
	<div class="header-container <?php if(is_front_page()){ echo esc_attr($imgClass); } ?> ">
	
		<?php
			switch ($header_views) {
				case 'header_with_topbar':
					get_template_part( 'templates/headers/header-with-topbar');
					break;
				case 'header_menu_bar':
					get_template_part( 'templates/headers/header-menu-dropdown');
					break;
				case 'header_without_topbar':
					get_template_part( 'templates/headers/header-without-topbar');
					break;

				default:
					break;
			}
			get_template_part( 'templates/popups');
			get_template_part( 'templates/banner');
		?>
	</div>
	<!--==================================Header Close=================================-->

	<!--================================== Search Close =================================-->
	<?php 
	if(is_front_page() && !is_home()){
		$topBannerView = $listingpro_options['top_banner_styles'];
		if( $topBannerView == 'map_view' ) {
			get_template_part( 'templates/search/template_search1' );
		}
	}
	?>

	<!--================================== Search Close =================================-->
</div>

<?php 
	if ( is_front_page() ) { ?>
		<div class="home-categories-area <?php echo esc_attr($alignClass); ?>">
			<?php echo listingpro_banner_categories(); ?>
		</div>
		<?php
	}
?>
<?php
	}
?>