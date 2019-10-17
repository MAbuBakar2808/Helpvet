<?php


/**
 * Listingpro Functions.
 *
 */
	define('THEME_PATH', get_template_directory());
	define('THEME_DIR', get_template_directory_uri());
	define('STYLESHEET_PATH', get_stylesheet_directory());
	define('STYLESHEET_DIR', get_stylesheet_directory_uri());


	/* ============== Theme Setup ============ */

	add_action( 'after_setup_theme', 'listingpro_theme_setup' );
	function listingpro_theme_setup() {

		/* Text Domain */
		load_theme_textdomain( 'listingpro', get_template_directory() . '/languages' );

		/* Theme supports */

		add_editor_style();
		add_theme_support( 'post-thumbnails' );
		add_theme_support( "title-tag" );
		add_theme_support( "custom-header" );
		add_theme_support( "custom-background" ) ;
		add_theme_support('automatic-feed-links');

		remove_post_type_support( 'page', 'thumbnail' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
			'search-form',
			'comment-form',
			'comment-list'
			)
		);

		// We are using three menu locations.
		register_nav_menus( array(
			'primary'         => esc_html__( 'Homepage Menu', 'listingpro' ),
			'primary_inner'   => esc_html__( 'Inner Pages Menu', 'listingpro' ),
			'top_menu'        => esc_html__( 'Top Bar Menu', 'listingpro' ),
			'footer_menu' 	  => esc_html__( 'Footer Menu', 'listingpro' ),
			'mobile_menu' 	  => esc_html__( 'Mobile Menu', 'listingpro' ),
		) );

		/* Image sizes */
		add_image_size( 'listingpro-blog-grid', 372, 240, true ); // (cropped)
		add_image_size( 'listingpro-blog-grid2', 372, 400, true ); // (cropped)
		add_image_size( 'listingpro-blog-grid3', 672, 430, true ); // (cropped)
		add_image_size( 'listingpro-listing-grid', 272, 231, true ); // (cropped)
		add_image_size( 'listingpro-listing-gallery', 580, 408, true ); // (cropped)
		add_image_size( 'listingpro-list-thumb',287, 190, true ); // (cropped)
		add_image_size( 'listingpro-author-thumb',63, 63, true ); // (cropped)
		add_image_size( 'listingpro-gallery-thumb1',458, 425, true ); // (cropped)
		add_image_size( 'listingpro-gallery-thumb2',360, 198, true ); // (cropped)
		add_image_size( 'listingpro-gallery-thumb3',263, 198, true ); // (cropped)
		add_image_size( 'listingpro-gallery-thumb4',653, 199, true ); // (cropped)

		add_image_size( 'listingpro-detail_gallery',383, 454, true ); // (cropped)

		add_image_size( 'listingpro-checkout-listing-thumb',220, 80, true ); // (cropped)
		add_image_size( 'listingpro-review-gallery-thumb',184, 135, true ); // (cropped)
		add_image_size( 'listingpro-thumb4',272, 300, true ); // (cropped)

		//for location
		add_image_size( 'listingpro_location270_400',270, 400, true ); // (cropped)
		add_image_size( 'listingpro_location570_455',570, 455, true ); // (cropped)
		add_image_size( 'listingpro_location570_228',570, 228, true ); // (cropped)
		add_image_size( 'listingpro_location270_197',270, 197, true ); // (cropped)

		add_image_size( 'listingpro_cats270_213',270, 213, true ); // (cropped)



	}

	if ( ! isset( $content_width ) ) $content_width = 900;
	/* ============== Dynamic options and Styling ============ */
	require_once THEME_PATH . '/include/dynamic-options.php';

	/* ============== Breadcrumb ============ */
	require_once THEME_PATH . '/templates/breadcrumb.php';

	/* ============== Blog Comments ============ */
	require_once THEME_PATH . '/templates/blog-comments.php';

	/* ============== Required Plugins ============ */
	require_once THEME_PATH . "/include/plugins/install-plugin.php";

	/* ============== icons ============ */
	require_once THEME_PATH . "/include/icons.php";

	/* ============== List confirmation ============ */
	require_once THEME_PATH . "/include/list-confirmation.php";

	/* ============== Login/Register ============ */
	require_once THEME_PATH . "/include/login-register.php";

	/* ============== Search Filter ============ */
	require_once THEME_PATH . "/include/search-filter.php";

	/* ============== Claim List ============ */
	require_once THEME_PATH . "/include/single-ajax.php";

	/* ============== Social Share ============ */
	require_once THEME_PATH . "/include/social-share.php";

	/* ============== Ratings ============ */
	require_once THEME_PATH . "/include/reviews/ratings.php";

	/* ============== Last Review ============ */
	require_once THEME_PATH . "/include/reviews/last-review.php";

	/* ============== Check Time status ============ */
	require_once THEME_PATH . "/include/time-status.php";

	/* ============== Banner Catss ============ */
	require_once THEME_PATH . "/include/banner-cats.php";

	/* ============== Fav Function ============ */
	require_once THEME_PATH . "/include/favorite-function.php";

	/* ============== Live Chat ============ */

	/* ============== listing Widgets ============ */
	require_once THEME_PATH . "/include/widgets/widget_most_viewed.php";
	require_once THEME_PATH . "/include/widgets/widget_ads_listing.php";
	require_once THEME_PATH . "/include/widgets/widget_nearby_listing.php";
	require_once THEME_PATH . "/include/widgets/contact_widget.php";
	require_once THEME_PATH . "/include/widgets/category_widget.php";
	require_once THEME_PATH . "/include/widgets/recent_posts_widget.php";

	/* ============== Reviews Form ============ */
	require_once THEME_PATH . "/include/reviews/reviews-form.php";

	/* ============== all reviews ============ */
	require_once THEME_PATH . "/include/reviews/all-reviews.php";

	/* ============== review-submit ============ */
	require_once THEME_PATH . "/include/reviews/review-submit.php";

	/* ============== all reviews ============ */
	require_once THEME_PATH . "/include/all-extra-fields.php";


		/* ============== listing campaign save  ============ */
	require_once THEME_PATH . "/include/paypal/campaign-save.php";

	/* ============== invoice function ============ */
	require_once THEME_PATH . "/include/invoices/invoice-functions.php";

	require_once THEME_PATH . "/include/invoices/invoice-modal.php";


	/* ============== Approve review ============ */
	require_once THEME_PATH . "/include/reviews/approve-review.php";

	/* ============== setup wizard =============== */
	require_once THEME_PATH . "/include/setup/envato_setup.php";
	//importer
	require_once THEME_PATH . "/include/setup/importer/init.php";

	/* ============== listing data db save ============ */
	require_once THEME_PATH . "/include/listingdata_db_save.php";

	/* ============== listing home map  ============ */
	require_once THEME_PATH . "/include/home_map.php";

	/* ============== listing stripe ajax  ============ */

	require_once THEME_PATH . "/include/stripe/stripe-ajax.php";

	/* ============== 2checkout ajax payment  ============ */

	require_once THEME_PATH . "/include/2checkout/payment.php";
	require_once THEME_PATH . "/include/2checkout/payment-campaigns.php";


	/* ============== ListingPro Style Load ============ */
	add_action('wp_enqueue_scripts', 'listingpro_style');
	function listingpro_style() {

		wp_enqueue_style('bootstrap', THEME_DIR . '/assets/lib/bootstrap/css/bootstrap.css');
		wp_enqueue_style('Magnific-Popup', THEME_DIR . '/assets/lib/Magnific-Popup-master/magnific-popup.css');
		wp_enqueue_style('popup-component', THEME_DIR . '/assets/lib/popup/css/component.css');
		wp_enqueue_style('Font-awesome', THEME_DIR . '/assets/lib/font-awesome/css/font-awesome.min.css');
		wp_enqueue_style('Mmenu', THEME_DIR . '/assets/lib/jquerym.menu/css/jquery.mmenu.all.css');
		wp_enqueue_style('MapBox', THEME_DIR . '/assets/css/mapbox.css');
		wp_enqueue_style('Chosen', THEME_DIR . '/assets/lib/chosen/chosen.css');

		global $listingpro_options;
		$app_view_home  =   $listingpro_options['app_view_home'];
		$app_view_home  =   url_to_postid( $app_view_home );
		if(is_page( $app_view_home ) || is_singular('listing') || (is_front_page()) ||  is_tax( 'listing-category' ) || is_tax( 'feature' ) || is_tax( 'location' ) || ( is_search()  && isset( $_GET['post_type'] )  && $_GET['post_type'] == 'listing' ) ){
			   wp_enqueue_style('Slick-css', THEME_DIR . '/assets/lib/slick/slick.css');
			   wp_enqueue_style('Slick-theme', THEME_DIR . '/assets/lib/slick/slick-theme.css');
			   wp_enqueue_style('css-prettyphoto', THEME_DIR . '/assets/css/prettyphoto.css');
		}

		if(!is_front_page()){
			wp_enqueue_style('jquery-ui', THEME_DIR . '/assets/css/jquery-ui.css');
		}
		wp_enqueue_style('icon8', THEME_DIR . '/assets/lib/icon8/styles.min.css');
		wp_enqueue_style('Color', THEME_DIR . '/assets/css/colors.css');
		wp_enqueue_style('custom-font', THEME_DIR . '/assets/css/font.css');
		wp_enqueue_style('Main', THEME_DIR . '/assets/css/main.css');
		wp_enqueue_style('Responsive', THEME_DIR . '/assets/css/responsive.css');
		/* by haroon */
		wp_enqueue_style('select2', THEME_DIR . '/assets/css/select2.css');
		/* end by haroon */
		/* for location */
		wp_enqueue_style('dynamiclocation', THEME_DIR . '/assets/css/city-autocomplete.css');
		wp_enqueue_style('lp-body-overlay', THEME_DIR . '/assets/css/common.loading.css');
		/* end for location */

		//if(is_archive()){
			wp_enqueue_style('bootstrapslider', THEME_DIR . '/assets/lib/bootstrap/css/bootstrap-slider.css');
		//}

		wp_enqueue_style('listingpro', STYLESHEET_DIR . '/style.css');

	}


	/* ============== ListingPro Script Load ============ */

	add_action('wp_enqueue_scripts', 'listingpro_scripts');

	function listingpro_scripts() {


		global $listingpro_options;

		wp_enqueue_script('Mapbox', THEME_DIR . '/assets/js/mapbox.js', 'jquery', '', true);
		wp_enqueue_script('Mapbox-leaflet', THEME_DIR . '/assets/js/leaflet.markercluster.js', 'jquery', '', true);

		//wp_enqueue_script('Build', THEME_DIR . '/assets/js/build.min.js', 'jquery', '', true);

		wp_enqueue_script('Chosen',THEME_DIR. '/assets/lib/chosen/chosen.jquery.js', 'jquery', '', true);

		wp_enqueue_script('bootstrap', THEME_DIR . '/assets/lib/bootstrap/js/bootstrap.min.js', 'jquery', '', true);

		wp_enqueue_script('Mmenu', THEME_DIR . '/assets/lib/jquerym.menu/js/jquery.mmenu.min.all.js', 'jquery', '', true);

		wp_enqueue_script('magnific-popup', THEME_DIR . '/assets/lib/Magnific-Popup-master/jquery.magnific-popup.min.js', 'jquery', '', true);

		wp_enqueue_script('select2', THEME_DIR . '/assets/js/select2.full.min.js', 'jquery', '', true);

		wp_enqueue_script('popup-classie', THEME_DIR . '/assets/lib/popup/js/classie.js', 'jquery', '', true);

		wp_enqueue_script('modalEffects', THEME_DIR. '/assets/lib/popup/js/modalEffects.js', 'jquery', '', true);
		wp_enqueue_script('2checkout', THEME_DIR. '/assets/js/2co.min.js', 'jquery', '', true);

		if(class_exists('Redux')){
			$mapAPI = '';
			$mapAPI = $listingpro_options['google_map_api'];
			if(empty($mapAPI)){
				$mapAPI = 'AIzaSyDQIbsz2wFeL42Dp9KaL4o4cJKJu4r8Tvg';
			}
			wp_enqueue_script('mapsjs', 'https://maps.googleapis.com/maps/api/js?v=3&amp;key='.$mapAPI.'&amp;libraries=places', 'jquery', '', false);
		}
		if(!is_front_page()){
			wp_enqueue_script('pagination', THEME_DIR . '/assets/js/pagination.js', 'jquery', '', true);
		}
		/* IF ie9 */
			wp_enqueue_script('html5shim', 'https://html5shim.googlecode.com/svn/trunk/html5.js', array(), '1.0.0', true);
			wp_script_add_data( 'html5shim', 'conditional', 'lt IE 9' );

			wp_enqueue_script('nicescroll', THEME_DIR. '/assets/js/jquery.nicescroll.min.js', 'jquery', '', true);
			wp_enqueue_script('chosen-jquery', THEME_DIR . '/assets/js/chosen.jquery.min.js', 'jquery', '', true);
			wp_enqueue_script('jquery-ui',THEME_DIR . '/assets/js/jquery-ui.js', 'jquery', '', true);
		if(is_page_template( 'template-dashboard.php' )){
			wp_enqueue_script('bootstrap-rating', THEME_DIR . '/assets/js/bootstrap-rating.js', 'jquery', '', true);
		}
		wp_enqueue_script('droppin', THEME_DIR. '/assets/js/drop-pin.js', 'jquery', '', true);
		if(is_singular('listing')){
			wp_enqueue_script('singlemap', THEME_DIR. '/assets/js/singlepostmap.js', 'jquery', '', true);
			wp_enqueue_script('socialshare', THEME_DIR . '/assets/js/social-share.js', 'jquery', '', true);
			wp_enqueue_script('jquery-prettyPhoto', THEME_DIR. '/assets/js/jquery.prettyPhoto.js', 'jquery', '', true);
			wp_enqueue_script('bootstrap-rating', THEME_DIR . '/assets/js/bootstrap-rating.js', 'jquery', '', true);
			wp_enqueue_script('Slick', THEME_DIR . '/assets/lib/slick/slick.min.js', 'jquery', '', true);
		}
		/* ==============start add by sajid ============ */
		global $listingpro_options;
		$app_view_home  =   $listingpro_options['app_view_home'];
		$app_view_home  =   url_to_postid( $app_view_home );
		if(is_page( $app_view_home ) || is_tax( 'location' ) || (is_front_page()) || is_tax( 'listing-category' ) || is_tax( 'feature' ) || (
				is_search()
				&& isset( $_GET['post_type'] )
				&& $_GET['post_type'] == 'listing'
		) ){
		wp_enqueue_script('Slick', THEME_DIR . '/assets/lib/slick/slick.min.js', 'jquery', '', true);
		}
		/* ==============end add by sajid ============ */
		wp_enqueue_script('dyn-location-js', THEME_DIR . '/assets/js/jquery.city-autocomplete.js', 'jquery', '', true);
		//if(is_archive()){
			wp_enqueue_script('bootstrapsliderjs', THEME_DIR . '/assets/lib/bootstrap/js/bootstrap-slider.js', 'jquery', '', true);
		//}
		wp_enqueue_script('Main', THEME_DIR. '/assets/js/main.js', 'jquery', '', true);

		wp_register_script( 'lp-icons-colors', THEME_DIR. '/assets/js/lp-iconcolor.js' , 'jquery', '', true );
		wp_enqueue_script( 'lp-icons-colors' );


		if ( is_singular('post') && comments_open() ) wp_enqueue_script( 'comment-reply' );


	}

	/* ============== ListingPro Stripe JS ============ */
	add_filter( 'wp_enqueue_scripts', 'listingpro_stripeJsfile', 0 );
	if(!function_exists('listingpro_stripeJsfile')){
		function listingpro_stripeJsfile(){

				wp_enqueue_script('stripejs', THEME_DIR . '/assets/js/checkout.js', 'jquery', '', false);

		}
	}




	/* ============== ListingPro Options ============ */

	if ( !isset( $listingpro_options ) && file_exists( dirname( __FILE__ ) . '/include/options-config.php' ) ) {
		require_once( dirname( __FILE__ ) . '/include/options-config.php' );
	}



	/* ============== ListingPro Load media ============ */
	if ( ! function_exists( 'listingpro_load_media' ) ) {
		function listingpro_load_media() {
		  wp_enqueue_media();
		}

	}
	add_action( 'admin_enqueue_scripts', 'listingpro_load_media' );

		if ( ! function_exists( 'listingpro_admin_css' ) ) {
			function listingpro_admin_css() {
			  wp_enqueue_style('adminpages-css', THEME_DIR . '/assets/css/admin-style.css');
			}

		}
		add_action( 'admin_enqueue_scripts', 'listingpro_admin_css' );


	/* ============== ListingPro Author Contact meta ============ */
	if ( ! function_exists( 'listingpro_author_meta' ) ) {
		function listingpro_author_meta( $contactmethods ) {

			// Add telefone
			$contactmethods['phone'] = 'Phone';
			// add address
			$contactmethods['address'] = 'Address';
			// add Social
			$contactmethods['facebook'] = 'Facebook';
			$contactmethods['google'] = 'Google';
			$contactmethods['linkedin'] = 'Linkedin';
			$contactmethods['instagram'] = 'Instagram';
			$contactmethods['twitter'] = 'Twitter';
			$contactmethods['pinterest'] = 'Pinterest';

			return $contactmethods;

		}
		add_filter('user_contactmethods','listingpro_author_meta',10,1);
	}





	/* ============== ListingPro User avatar URL ============ */

	if ( ! function_exists( 'listingpro_get_avatar_url' ) ) {

		function listingpro_get_avatar_url($author_id, $size){
			$get_avatar = get_avatar( $author_id, $size );
			preg_match("/src='(.*?)'/i", $get_avatar, $matches);
			return ( $matches[1] );
		}

	}





	/* ============== ListingPro Author image ============ */

	if (!function_exists('listingpro_author_image')) {

		function listingpro_author_image() {

			if(is_user_logged_in()){

				$current_user = wp_get_current_user();

				$author_avatar_url = get_user_meta($current_user->ID, "listingpro_author_img_url", true);

				if(!empty($author_avatar_url)) {

					$avatar =  $author_avatar_url;

				} else {

					$avatar_url = listingpro_get_avatar_url ( $current_user->ID, $size = '94' );
					$avatar =  $avatar_url;

				}
			}


			return $avatar;

		}

	}


	/* ============== ListingPro Single Author image ============ */

	if (!function_exists('listingpro_single_author_image')) {

		function listingpro_single_author_image() {

			if(is_single()){

				$author_avatar_url = get_user_meta(get_the_author_meta('ID'), "listingpro_author_img_url", true);

				if(!empty($author_avatar_url)) {

					$avatar =  $author_avatar_url;

				} else {

					$avatar_url = listingpro_get_avatar_url ( get_the_author_meta('ID'), $size = '94' );
					$avatar =  $avatar_url;

				}
			}


			return $avatar;

		}

	}




	/* ============== ListingPro Subscriber can upload media ============ */

	if ( ! function_exists( 'listingpro_subscriber_capabilities' ) ) {

		if ( current_user_can('subscriber')) {
			add_action('init', 'listingpro_subscriber_capabilities');
		}

		function listingpro_subscriber_capabilities() {
			//if (!is_admin()) {
			$contributor = get_role('subscriber');
			$contributor->add_cap('upload_files');
			$contributor->add_cap('edit_posts');
			$contributor->add_cap('assign_location');
			$contributor->add_cap('assign_list-tags');
			$contributor->add_cap('assign_listing-category');
			$contributor->add_cap('assign_features');

			  show_admin_bar(false);

			//}
		}

	}
	if ( ! function_exists( 'listingpro_admin_capabilities' ) ) {

		add_action('init', 'listingpro_admin_capabilities');

		function listingpro_admin_capabilities() {
			$contributor = get_role('administrator');
			$contributor->add_cap('assign_location');
			$contributor->add_cap('assign_list-tags');
			$contributor->add_cap('assign_listing-category');
			$contributor->add_cap('assign_features');
		}

	}


	if( !function_exists('listingpro_vcSetAsTheme') ) {
		add_action('vc_before_init', 'listingpro_vcSetAsTheme');
		function listingpro_vcSetAsTheme()
		{
			vc_set_as_theme($disable_updater = false);
		}
	}

	/* ============== ListingPro Block admin acccess ============ */
	if ( !function_exists( 'listingpro_block_admin_access' ) ) {

		add_action( 'init', 'listingpro_block_admin_access' );

		function listingpro_block_admin_access() {
			if( is_user_logged_in() ) {
		if (is_admin() && !current_user_can('administrator')  && isset( $_GET['action'] ) != 'delete' && !(defined('DOING_AJAX') && DOING_AJAX)) {
					wp_die(esc_html__("You don't have permission to access this page.", "listingpro"));
					exit;
				}
			}
		}

	}



	/* ============== ListingPro Media Uploader ============ */

	if ( ! function_exists( 'listingpro_add_media_upload_scripts' ) ) {

		function listingpro_add_media_upload_scripts() {
			if ( is_admin() ) {
				 return;
			   }
			wp_enqueue_media();
		}
		//add_action('wp_enqueue_scripts', 'listingpro_add_media_upload_scripts');

	}


	/* ============== ListingPro Search Form ============ */

	if ( ! function_exists( 'listingpro_search_form' ) ) {

		function listingpro_search_form() {

			$form = '<form role="search" method="get" id="searchform" action="' . esc_url(home_url('/')) . '" >
			<div class="input">
				<i class="icon-search"></i><input class="" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __('Type and hit enter', 'listingpro') . '">
			</div>
			</form>';

			return $form;
		}
	}

	add_filter('get_search_form', 'listingpro_search_form');


	/* ============== ListingPro Favicon ============ */

	if ( ! function_exists( 'listingpro_favicon' ) ) {

		function listingpro_favicon() {
			global $listingpro_options;
		   if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {

			   if($listingpro_options['theme_favicon'] != ''){

					echo '<link rel="shortcut icon" href="' . wp_kses_post($listingpro_options['theme_favicon']['url']) . '"/>';
				} else {
					echo '<link rel="shortcut icon" href="' . THEME_DIR . '/assets/img/favicon.ico"/>';
				}
			}

		}
	}


	/* ============== ListingPro Title ============ */

	if ( ! function_exists( 'listingpro_title' ) ) {

		function listingpro_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
		}
		add_action( 'wp_head', 'listingpro_title' );

	}

	/* ============== ListingPro Top bar menu ============ */

	if (!function_exists('listingpro_top_bar_menu')) {

		function listingpro_top_bar_menu() {
			$defaults = array(
				'theme_location'  => 'top_menu',
				'menu'            => '',
				'container'       => 'false',
				'menu_class'      => 'lp-topbar-menu',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
			if ( has_nav_menu( 'top_menu' ) ) {
				return wp_nav_menu( $defaults );
			}
		}

	}

	/* ============== ListingPro Primary menu ============ */

	if (!function_exists('listingpro_primary_menu')) {

		function listingpro_primary_menu() {
			$defaults = array(
				'theme_location'  => 'primary',
				'menu'            => '',
				'container'       => 'div',
				'menu_class'      => '',
				'menu_id'         => '',
				'echo'            => true,
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
			if ( has_nav_menu( 'primary' ) ) {
				return wp_nav_menu( $defaults );
			}
		}

	}


	/* ============== ListingPro Inner pages menu ============ */

	if (!function_exists('listingpro_inner_menu')) {

		function listingpro_inner_menu() {
			$defaults = array(
				'theme_location'  => 'primary_inner',
				'menu'            => '',
				'container'       => 'div',
				'menu_class'      => '',
				'menu_id'         => '',
				'echo'            => true,
				'items_wrap'      => '<ul id="%1$s" class="inner_menu %2$s">%3$s</ul>',
			);
			if ( has_nav_menu( 'primary_inner' ) ) {
				return wp_nav_menu( $defaults );
			}
		}

	}

	/* ============== ListingPro Footer menu ============ */

	if (!function_exists('listingpro_footer_menu')) {

		function listingpro_footer_menu() {
			$defaults = array(
				'theme_location'  => 'footer_menu',
				'menu'            => '',
				'container'       => 'false',
				'menu_class'      => 'footer-menu',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);

			if ( has_nav_menu( 'footer_menu' ) ) {
				return wp_nav_menu( $defaults );
			}
		}

	}

	/* ==============start add by sajid ============ */
	if (!function_exists('listingpro_footer_menu_app')) {

		function listingpro_footer_menu_app() {
			$defaults = array(
				'theme_location'  => 'footer_menu',
				'menu'            => '',
				'container'       => 'false',
				'menu_class'      => '',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);

			if ( has_nav_menu( 'footer_menu' ) ) {
				return wp_nav_menu( $defaults );
			}
		}
	}

	/* ==============end add by sajid ============ */

	/* ============== ListingPro Mobile menu ============ */

	if (!function_exists('listingpro_mobile_menu')) {

		function listingpro_mobile_menu() {
			$defaults = array(
				'theme_location'  => 'mobile_menu',
				'menu'            => '',
				'container'       => 'false',
				'menu_class'      => 'mobile-menu',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);

			if ( has_nav_menu( 'mobile_menu' ) ) {
				return wp_nav_menu( $defaults );
			}
		}

	}

	/* ============== ListingPro Default sidebar ============ */

	if (!function_exists('listingpro_sidebar')) {

		function listingpro_sidebar() {
			global $listingpro_options;
			$footer_style = '';
			if(isset($listingpro_options['footer_style'])){
				$footer_style = $listingpro_options['footer_style'];
			}

			register_sidebar(array(
				'name' => 'Default sidebar',
				'id' => 'default-sidebar',
				'before_widget' => '<aside class="widget %2$s" id="%1$s">',
				'after_widget' => '</aside>',
				'before_title' => '<div class="imo-widget-title-container"><h2 class="widget-title">',
				'after_title' => '</h2></div>',
			));
			register_sidebar(array(
				'name' => 'Listing Detail sidebar',
				'id' => 'listing_detail_sidebar',
				'before_widget' => '<div class="widget-box viewed-listing %2$s" id="%1$s">',
				'after_widget' => '</div>',
				'before_title' => '<h2>',
				'after_title' => '</h2>',
			));
			/* ============== shaoib start ============ */

			if($footer_style == 'footer2'){
					register_sidebar(array(
						'name' => esc_html__("Footer sidebar widget ", "listingpro"),
						'id' => "footer-sidebar",
						'description' => esc_html__('The footer sidebar widget area', 'listingpro'),
						'before_widget' => '<aside class="col-md-3 widget widgets %2$s" id="%1$s">',
						'after_widget' => '</aside>',
						'before_title' => '<div class="widget-title"><h2>',
						'after_title' => '</h2></div>',

					));

			}
			/* ============== shoaib end ============ */

		}

	}
	add_action('widgets_init', 'listingpro_sidebar');

	/* ============== ListingPro Primary Logo ============ */

	if (!function_exists('listingpro_primary_logo')) {

		function listingpro_primary_logo() {

			global $listingpro_options;
			$lp_logo = $listingpro_options['primary_logo']['url'];
			if(!empty($lp_logo)){
				echo '<img src="'.$lp_logo.'" alt="" />';
			}

		}

	}


	/* ============== ListingPro Seconday Logo ============ */

	if (!function_exists('listingpro_secondary_logo')) {

		function listingpro_secondary_logo() {

			global $listingpro_options;
			$lp_logo2 = $listingpro_options['seconday_logo']['url'];
			if(!empty($lp_logo2)){
				echo '<img src="'.$lp_logo2.'" alt="" />';
			}

		}

	}



	/* ============== ListingPro URL Settings ============ */

	if (!function_exists('listingpro_url')) {

		function listingpro_url($link) {
			global $listingpro_options;
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( is_plugin_active( 'listingpro-plugin/plugin.php' ) ) {
				if($link == 'add_listing_url_mode'){
					//$url = $listingpro_options[$link];
					$paidmode = $listingpro_options['enable_paid_submission'];
					if( $paidmode=="per_listing" || $paidmode=="membership" ){
						$url = $listingpro_options['pricing-plan'];
					}else{
						$url = $listingpro_options['submit-listing'];
					}
				}else{
					$url = $listingpro_options[$link];
				}

				return $url;
			}else{
				return false;
			}
		}

	}



	/* ============== ListingPro translation ============ */

	if (!function_exists('listingpro_translation')) {

		function listingpro_translation($word) {


				return $word;

		}
	}



	/* ============== ListingPro filter page pagination ============ */

	if (!function_exists('listingpro_load_more_filter')) {

		function listingpro_load_more_filter($my_query, $pageno=null, $sKeyword='') {

			$output = '';
			$pages = '';
			$pages = $my_query->max_num_pages;
			$totalpages = $pages;
			if(!empty($pages) && $pages>1){
				$output .='<div class="lp-pagination pagination lp-filter-pagination-ajx">';
				$output .='<ul class="page-numbers">';
				$n=1;
				$flagAt = 7;
				$flagAt2 = 7;
				$flagOn = 0;
				while($pages > 0){

					if(isset($pageno) && !empty($pageno)){

						if(!empty($totalpages) && $totalpages<7){
							if($pageno==$n){
								$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink current">'.$n.'</span></li>';
							}
							else{
								$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
							}
						}
						elseif(!empty($totalpages) && $totalpages>6){
							$flagOn = $pageno - 5;
							$flagOn2 = $pageno + 7;
							if($pageno==$n){
								$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink current">'.$n.'</span></li>';
							}
							else{
								if($n<=4){
									$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
								}

								elseif($n > 4 && $flagAt2==7){
									$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
									$output .='<li><span data-skeyword="'.$sKeyword.'"  class="page-numbers">...</span></li>';
									$flagAt2=1;

								}
								elseif($n > 4  && $n >=$flagOn && $n<$flagOn2){
									$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';

								}
								elseif($n == $totalpages){
									$output .='<li><span data-skeyword="'.$sKeyword.'" class="page-numbers">...</span></li>';
									$output .='<li><span data-skeyword="'.$sKeyword.'" data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';

								}

							}

						}


					}
					else{

						if($n==1){
							$output .='<li><span data-pageurl="'.$n.'"  class="page-numbers  haspaglink current">'.$n.'</span></li>';
						}
						else if( $n<7 ){
							$output .='<li><span data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
						}

						else if( $n>7 && $pages>7 && $flagAt==7 ){
							$output .='<li><span  class="page-numbers">...</span></li>';
							$flagAt = 1;
						}

						else if( $n>7 && $pages<7 && $flagAt==1 ){
							$output .='<li><span data-pageurl="'.$n.'"  class="page-numbers haspaglink">'.$n.'</span></li>';
						}

					}

					$pages--;
					$n++;
					$output .='</li>';
				}
				$output .='</ul>';
				$output .='</div>';
			}


			return $output;
		}

	}


	/* ============== ListingPro Infinite load ============ */

	if (!function_exists('listingpro_load_more')) {

		function listingpro_load_more($wp_query) {
			$pages = $wp_query->max_num_pages;
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			if (empty($pages)) {
				$pages = 1;
			}

			if (1 != $pages) {

				$big = 9999; // need an unlikely integer
				echo "
				<div class='lp-pagination pagination lp-filter-pagination'>";

					$pagination = paginate_links(
					array(
						'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
						'end_size' => 3,
						'mid_size' => 6,
						'format' => '?paged=%#%',
						'current' => max(1, get_query_var('paged')),
						'total' => $wp_query->max_num_pages,
						'type' => 'list',
						'prev_text' => __('&laquo;', 'listingpro'),
						'next_text' => __('&raquo;', 'listingpro'),
					));
					print $pagination;
				echo "</div>";
			}
		}

	}


	/* ============== ListingPro Icon8 base64 Icons ============ */

	if (!function_exists('listingpro_icons')) {

		function listingpro_icons($icons) {
			$colors = new listingproIcons();
			$icon = '';
			if($icons != ''){
				$iconsrc = $colors->listingpro_icon($icons);
				$icon = '<img class="icon icons8-'.$icons.'" src="'.$iconsrc.'" alt="'.$icons.'">';
				return $icon;
			}else{
				return $icon;
			}
		}
	}



	/* ============== ListingPro Search Filter ============ */

	if (!function_exists('listingpro_searchFilter')) {


		function listingpro_searchFilter() {
			global $wp_post_types;
			$wp_post_types['page']->exclude_from_search = true;
		}
		add_action('init', 'listingpro_searchFilter');

	}


	/* ============== ListingPro Price Dynesty Text============ */

	if (!function_exists('listingpro_price_dynesty_text')) {
		function listingpro_price_dynesty_text($postid) {
			$output = null;
			if(!empty($postid)){
				$priceRange = listing_get_metabox_by_ID('price_status', $postid);
				//$listingptext = listing_get_metabox('list_price_text');
				$listingprice = listing_get_metabox_by_ID('list_price', $postid);
				if(!empty($priceRange ) && !empty($listingprice )){
					$output .='
					<span class="element-price-range list-style-none">';
						$dollars = '';
						$tip = '';
						if( $priceRange == 'notsay' ){
							$dollars = '';
							$tip = '';

						}elseif( $priceRange == 'inexpensive' ){
							$dollars = '1';
							$tip = esc_html__('Inexpensive', 'listingpro');

						}elseif( $priceRange == 'moderate' ){
							$dollars = '2';
							$tip = esc_html__('Moderate', 'listingpro');

						}elseif( $priceRange == 'pricey' ){
							$dollars = '3';
							$tip = esc_html__('Pricey', 'listingpro');

						}elseif( $priceRange == 'ultra_high_end' ){
							$dollars = '4';
							$tip = esc_html__('Ultra High End', 'listingpro');
						}
						global $listingpro_options;
						$lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];
						if( $priceRange != 'notsay' ){
							$output .= '<span class="grayscale simptip-position-top simptip-movable" data-tooltip="'.$tip.'" title="'.$tip.'">';
							for ($i=0; $i < $dollars ; $i++) {
								$output .= $lp_priceSymbol;
							}
							$output .= '</span>';

						}
						$output .= '
					</span>';
				}
			}
			return $output;
		}
	}

	/* ============== ListingPro Price Dynesty ============ */

	if (!function_exists('listingpro_price_dynesty')) {
		function listingpro_price_dynesty($postid) {
			if(!empty($postid)){
				$priceRange = listing_get_metabox_by_ID('price_status', $postid);
				$listingpTo = listing_get_metabox('list_price_to');
				$listingprice = listing_get_metabox_by_ID('list_price', $postid);
				if( ($priceRange != 'notsay' && !empty($priceRange)) || !empty($listingpTo) || !empty($listingprice) ){
					?>
					<div class="post-row price-range">
						<ul class="list-style-none post-price-row line-height-16">
					<?php if( $priceRange != 'notsay' && !empty($priceRange) ){ ?>
							<li class="grayscale-dollar">
								<?php
									$dollars = '';
									$tip = '';
									if( $priceRange == 'notsay' ){
										$dollars = '';
										$tip = '';

									}elseif( $priceRange == 'inexpensive' ){
										$dollars = '1';
										$tip = esc_html__('Inexpensive', 'listingpro');

									}elseif( $priceRange == 'moderate' ){
										$dollars = '2';
										$tip = esc_html__('Moderate', 'listingpro');

									}elseif( $priceRange == 'pricey' ){
										$dollars = '3';
										$tip = esc_html__('Pricey', 'listingpro');

									}elseif( $priceRange == 'ultra_high_end' ){
										$dollars = '4';
										$tip = esc_html__('Ultra High End', 'listingpro');
									}

									global $listingpro_options;
									$lp_priceSymbol = $listingpro_options['listing_pricerange_symbol'];

										echo '<span class="simptip-position-top simptip-movable" data-tooltip="'.$tip.'" title="'.$tip.'">';
											echo '<span class="active">';
											for ($i=0; $i < $dollars ; $i++) {
												echo wp_kses_post( $lp_priceSymbol );
											}
											echo '</span>';

											echo '<span class="grayscale">';
											$greyDollar = 4 - $dollars;
											for($i=1;$i<=$greyDollar;$i++){
												echo wp_kses_post($lp_priceSymbol);
											}
											echo '</span>';
										echo '</span>';

								?>
							</li>
							<?php
							}
							if(!empty($listingpTo ) || !empty($listingprice )){
							?>
							<li>
								<span class="post-rice">
									<span class="text">
										<?php echo esc_html__('Price Range', 'listingpro'); ?>
									</span>
									<?php

										if(!empty($listingprice)){
											echo esc_html($listingprice);
										}
										if(!empty($listingpTo)){
											echo ' - ';
											echo esc_html($listingpTo);
										}


									?>
								</span>
							</li>
							<?php
								}
							?>
						</ul>
					</div>
					<?php
				}
			}
		}
	}

	/* ============== ListingPro email and mailer filter ============ */
	add_filter('wp_mail_from', 'listingpro_mail_from');
	add_filter('wp_mail_from_name', 'listingpro_mail_from_name');
	if( !function_exists('listingpro_mail_from') ){
		function listingpro_mail_from($old) {

			$mailFrom = null;
			if( class_exists( 'Redux' ) ) {
				global $listingpro_options;
				$mailFrom = $listingpro_options['listingpro_general_email_address'];
			}
			else{
				$mailFrom = get_option( 'admin_email' );
			}
			return $mailFrom;
		}
	}
	if( !function_exists('listingpro_mail_from_name') ){
		function listingpro_mail_from_name($old) {

			$mailFromName = null;
			if( class_exists( 'Redux' ) ) {
				global $listingpro_options;
				$mailFromName = $listingpro_options['listingpro_general_email_from'];
			}
			else{
				$mailFromName = get_option( 'blogname' );
			}
			return $mailFromName;
		}
	}

	/* ============== email html support ============ */
	if( !function_exists('listingpro_set_content_type') ){
		add_filter( 'wp_mail_content_type', 'listingpro_set_content_type' );
		function listingpro_set_content_type( $content_type ) {
			return 'text/html';
		}
	}

	/* ==================textarea to editor============= */

	if( !function_exists('get_textarea_as_editor') ){
		function get_textarea_as_editor($editor_id, $editor_name, $pcontent){
			$content = $pcontent;
			$settings = array(

			'wpautop' => true,
						'textarea_name' => $editor_name,
			'textarea_rows' => 8,


			'media_buttons' => false,

						'tinymce' => array(
							'theme_advanced_buttons1' => '',
							'theme_advanced_buttons2' => false,
							'theme_advanced_buttons3' => false,
							'theme_advanced_buttons4' => false,
						),

			'quicktags' => false,

			);

			ob_start();
			wp_editor( $content, $editor_id, $settings );
			$output = ob_get_contents();
			ob_end_clean();
			ob_flush();
			return $output;

		}
	}

	/* ================= button in editor=========== */

	add_filter( 'tiny_mce_before_init', 'lp_format_TinyMCE' );
	if( !function_exists('lp_format_TinyMCE') ){
        function lp_format_TinyMCE( $in ) {
            if(!is_admin()){
                $in['toolbar'] = 'formatselect,|,bold,italic,underline,|,' .
                    'bullist,numlist,blockquote,|,justifyleft,justifycenter' .
                    ',justifyright,justifyfull,|,link,unlink,|' .
                    ',spellchecker,';
                $in['toolbar1'] = '';
                $in['toolbar2'] = '';
                return $in;
            }else{
                return $in;
            }

        }
    }

	/* ============== Listingpro term Exist ============ */

		if(!function_exists('listingpro_term_exist')){
			function listingpro_term_exist($name,$taxonomy){
				$term = term_exists($name, $taxonomy);
				if (!empty($term)) {
				 return $term;
				}else{
					return 0;
				}
			}
		}



	/* ============== Listingpro add new term ============ */

		if(!function_exists('listingpro_insert_term')){
			function listingpro_insert_term($name,$taxonomy){
				if ( ! taxonomy_exists($taxonomy) ){
					return 0;
				}
				else{
					$term = term_exists($name, $taxonomy);
					if (!empty($term)) {
					 return 0;
					}else{
						$loc = wp_insert_term($name, $taxonomy);
						return $loc;
					}
				}
			}
		}



	/* ============== Listingpro compaigns ============ */
	if(!function_exists('listingpro_get_campaigns_listing')){
		function listingpro_get_campaigns_listing( $campaign_type, $IDSonly, $taxQuery=array(), $searchQuery=array(),$priceQuery=array(),$s=null, $noOfListings = null, $posts_in = null ){

			global $listingpro_options;
			$listing_mobile_view = $listingpro_options['single_listing_mobile_view'];

			$postsidsin;
			if(!empty($posts_in)){
				$postsidsin = "'post__in' => ".$posts_in."";
			}
			else{
				$postsidsin = "'' => ''";
			}
			$adsType = array(
			'lp_random_ads',
			'lp_detail_page_ads',
			'lp_top_in_search_page_ads'
			);

			global $listingpro_options;
			$listing_style = '';
			$listing_style = $listingpro_options['listing_style'];
			$postNumber = '';
			if($listing_style == '3' && !is_front_page()){
				if(empty($noOfListings)){
					$postNumber = 2;
				}
				else{
					$postNumber = $noOfListings;
				}

			}else{
				if(empty($noOfListings)){
					$postNumber = 3;
				}
				else{
					$postNumber = $noOfListings;
				}
			}


			if( !empty($campaign_type) ){
				if( in_array($campaign_type, $adsType, true) ){

					$TxQuery = array();
					if( !empty( $taxQuery ) && is_array($taxQuery)){
						$TxQuery = $taxQuery;
					}elseif(!empty($searchQuery) && is_array($searchQuery)){
						$TxQuery = $searchQuery;
					}
					$args = array(
						'orderby' => 'rand',
						'post_type' => 'listing',
						'post_status' => 'publish',
						'posts_per_page' => $postNumber,
						$postsidsin,
						'tax_query' => $TxQuery,
						'meta_query' => array(
							'relation'=>'AND',
							array(
								'key'     => 'campaign_status',
								'value'   => array( 'active' ),
								'compare' => 'IN',
							),
							array(
								'key'     => $campaign_type,
								'value'   => array( 'active' ),
								'compare' => 'IN',
							),
							$priceQuery,
						),
					);
					if(!empty($s)){
						$args = array(
							'orderby' => 'rand',
							'post_type' => 'listing',
							'post_status' => 'publish',
							's' => $s,
							'posts_per_page' => $postNumber,
							'tax_query' => $TxQuery,
							'meta_query' => array(
								'relation'=>'AND',
								array(
									'key'     => 'campaign_status',
									'value'   => array( 'active' ),
									'compare' => 'IN',
								),
								array(
									'key'     => $campaign_type,
									'value'   => array( 'active' ),
									'compare' => 'IN',
								),
								$priceQuery,
							),
						);
					}
					$idsArray = array();
					$the_query = new WP_Query( $args );
					if ( $the_query->have_posts() ) {
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							if( $IDSonly==TRUE ){
								$idsArray[] =  get_the_ID();

							}
							else{
								if(is_singular('listing') ){
									if( $listing_mobile_view == 'app_view' && wp_is_mobile() ) {
										echo  '<div class="row app-view-ads lp-row-app">';
										get_template_part('mobile/listing-loop-app-view');
										echo '</div>';
									}else{
										get_template_part( 'templates/details-page-ads' );
									}
								}
							elseif( ( is_page()  || is_home() || is_singular('post') ) &&  is_active_sidebar( 'default-sidebar' ) ){
									get_template_part( 'templates/details-page-ads' );
								}
								elseif(is_singular( 'post' )){
									get_template_part( 'templates/details-page-ads' );
								}
								else{
									$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
                                    if( $listing_mobile_view == 'app_view' && wp_is_mobile() ){
                                        get_template_part( 'mobile/listing-loop-app-view' );
                                    }else
                                    {
                                        get_template_part( 'listing-loop' );
                                    }
								}

							}

							wp_reset_postdata();
						}
						if( $IDSonly==TRUE ){
							if(!empty($idsArray)){
								return $idsArray;
							}
						}

					}



				}
			}


		}
	}
	/* ============== Listingpro Sharing ============ */
	if(!function_exists('listingpro_sharing')){
		function listingpro_sharing() {
			?>
			<a class="reviews-quantity">
				<span class="reviews-stars">
					<i class="fa fa-share-alt"></i>
				</span>
				<?php echo esc_html__('Share', 'listingpro');?>
			</a>
			<div class="md-overlay hide"></div>
			<ul class="social-icons post-socials smenu">
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('facebook'); ?>" target="_blank"><!-- Facebook icon by Icons8 -->
						<i class="fa fa-facebook"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('gplus'); ?>" target="_blank"><!-- Google Plus icon by Icons8 -->
						<i class="fa fa-google-plus"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('twitter'); ?>" target="_blank"><!-- twitter icon by Icons8 -->
						<i class="fa fa-twitter"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('linkedin'); ?>" target="_blank"><!-- linkedin icon by Icons8 -->
						<i class="fa fa-linkedin"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('pinterest'); ?>" target="_blank"><!-- pinterest icon by Icons8 -->
						<i class="fa fa-pinterest"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('reddit'); ?>" target="_blank"><!-- reddit icon by Icons8 -->
						<i class="fa fa-reddit"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('stumbleupon'); ?>" target="_blank"><!-- stumbleupon icon by Icons8 -->
						<i class="fa fa-stumbleupon"></i>
					</a>
				</li>
				<li>
					<a href="<?php echo listingpro_social_sharing_buttons('del'); ?>" target="_blank"><!-- delicious icon by Icons8 -->
						<i class="fa fa-delicious"></i>
					</a>
				</li>
			</ul>
			<?php
		}
	}


	/* Post Views */

if(!function_exists('getPostViews')){
	function getPostViews($postID){
	    $count_key = 'post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count=='' || $count=='0'){
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	        return esc_html__('0 View', 'listingpro');
	    }else{
			if(!empty($count)){
				if($count=="1"){
					return $count.esc_html__(' View', 'listingpro');
				}
				else{
					return $count.esc_html__(' Views', 'listingpro');
				}
			}
			else{
				return $count.esc_html__('0 View', 'listingpro');
			}
		}

	}
}

// function to count views.
if(!function_exists('setPostViews')){
	function setPostViews($postID) {
	    $count_key = 'post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        $count = 0;
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	    }else{
	        $count++;
	        update_post_meta($postID, $count_key, $count);
	    }
	}
}

// function to get all post meta value by keys
if(!function_exists('getMetaValuesByKey')){
	function getMetaValuesByKey($key){
		global $wpdb;
		$metaVal = $wpdb->get_col("SELECT meta_value
		FROM $wpdb->postmeta WHERE meta_key = '$key'" );
		return $metaVal;
	}
}

// function to get total views
if(!function_exists('getTotalPostsViews')){
	function getTotalPostsViews(){
		$totalCount = 0;
		$totalArray = getMetaValuesByKey('post_views_count');
		if(!empty($totalArray)){
			foreach( $totalArray as $count ){
				$totalCount = $totalCount + $count;
			}
		}
		return $totalCount;
	}
}

// function to get author listing total views
if(!function_exists('getAuthorPostsViews')){
	function getAuthorPostsViews(){
		$count = 0;
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		$args = array(
			'post_type' => 'listing',
			'author' => $user_id,
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$n = get_post_meta(get_the_ID(), 'post_views_count', true);
				$count = $count + (int)$n;
			}
			wp_reset_postdata();
		}
		return $count;
	}
}

// function to get author listing total reviews
if(!function_exists('getAuthorTotalViews')){
	function getAuthorTotalViews(){
		$count = 0;
		$review_ids = '';
		$result = array();
		$review_new = array();
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
		$review_ids = array();

		$args = array(
			'post_type' => 'listing',
			'author' => $user_id,
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$key = 'reviews_ids';
				$review_idss = listing_get_metabox_by_ID($key ,get_the_ID());

				if( !empty($review_idss) ){
					if (strpos($review_idss, ",") !== false) {
						$review_ids = explode( ',', $review_idss );
						$result = array_merge($result, $review_ids);
					}
					else{
						$result[] = $review_idss;
					}

				}
			}
			wp_reset_postdata();
			$count = $count + count($result);
		}
		return $count;
	}
}

//function to get all reviews in array on author's posts
if(!function_exists('getAllReviewsArray')){
	function getAllReviewsArray(){
		$review_ids = '';
		$result = array();
		$review_new = array();
		$review_idss = '';
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		$postid = array();

		$args = array(
			'post_type' => 'listing',
			'author' => $user_id,
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$key = 'reviews_ids';

				$review_idss = listing_get_metabox_by_ID($key ,get_the_ID());

				if( !empty($review_idss) ){
					if (strpos($review_idss, ",") !== false) {
						$review_ids = explode( ',', $review_idss );
						$result = array_merge($result, $review_ids);
					}
					else{
						$result[] = $review_idss;
					}

				}

			}
			//wp_reset_postdata();
		}
		return $result;
	}
}


/*========================================get ads invoices list============================================*/
//function to retreive invoices
if(!function_exists('get_ads_invoices_list')){
	function get_ads_invoices_list($userid, $method, $status){
		global $wpdb;
		$prefix = '';
		$prefix = $wpdb->prefix;
		$table_name = $prefix.'listing_campaigns';

		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {

			if( empty($userid)  && !empty($method) && !empty($status) && is_admin() ){
				//return on admin side only
				$results = $wpdb->get_results(
								$wpdb->prepare("SELECT * FROM {$prefix}listing_campaigns WHERE payment_method=%s AND status=%s", $method, $status)
							 );
				return $results;
			}
			else if( !empty($userid) && isset($userid) && !empty($status)){
				//return for all users by id

				$results = $wpdb->get_results(
								$wpdb->prepare("SELECT * FROM {$prefix}listing_campaigns WHERE user_id=%d AND status=%s", $userid, $status)
							 );
				return $results;

			}

		}
	}
}

/*====================================================================================*/
// Delete post action
if(!function_exists('lp_delete_any_post')){
add_action( 'before_delete_post', 'lp_delete_any_post' );
	function lp_delete_any_post( $postid ){
		global $post_type;

		if($post_type == 'listing'){
			$listing_id = $postid;
			$campaignID = listing_get_metabox_by_ID('campaign_id', $listing_id);
			$get_reviews = listing_get_metabox_by_ID('reviews_ids', $listing_id);

			wp_delete_post($campaignID);
			if(!empty($get_reviews)){
				$reviewsArray = array();
				if (strpos($get_reviews, ',') !== false) {
					$reviewsArray = explode(",",$get_reviews);
				}
				else{
					$reviewsArray[] = $get_reviews;
				}
				$args = array(
					'posts_per_page'      => -1,
					'post__in'            => $reviewsArray,
					'post_type' => 'lp-reviews',
				);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						wp_delete_post(get_the_ID());
					}
				}
			}


		}
		else if($post_type == 'lp-reviews'){

			$review_id = $postid;
			$action = 'delete';
			$listing_id = listing_get_metabox_by_ID('listing_id', $postid);

			listingpro_set_listing_ratings($review_id, $listing_id, '', $action);

		}
		else if($post_type == 'lp-ads'){
			$listing_id = listing_get_metabox_by_ID('ads_listing', $postid);
			$ad_type = listing_get_metabox_by_ID('ad_type', $postid);
			if(!empty($ad_type)&& count($ad_type)>0){
				foreach($ad_type as $type){
					delete_post_meta( $listing_id, $type );
				}
			}

			listing_delete_metabox('campaign_id', $listing_id);
			delete_post_meta( $listing_id, 'campaign_status' );

		}


	}
}

//=======================================================
//						Pagination
//=======================================================
if(!function_exists('listingpro_pagination')){

	function listingpro_pagination() {
		global $wp_query;

		$pages = $wp_query->max_num_pages;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		if (empty($pages)) {
			$pages = 1;
		}

		if (1 != $pages) {

			$big = 9999; // need an unlikely integer
			echo "
			<div class='lp-pagination pagination'>";
				$pagination = paginate_links(
				array(
					'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
					'end_size' => 3,
					'mid_size' => 6,
					'format' => '?paged=%#%',
					'current' => max(1, get_query_var('paged')),
					'total' => $wp_query->max_num_pages,
					'type' => 'list',
					'prev_text' => __('&laquo;', 'listingpro'),
					'next_text' => __('&raquo;', 'listingpro'),
				));
				print $pagination;
			echo "</div>";
		}
	}
}

//=======================================================
//						Login Screen
//=======================================================
	if(!function_exists('listingpro_login_screen')){
		function listingpro_login_screen() {
			wp_enqueue_style( 'listable-custom-login', get_template_directory_uri() . '/assets/css/login-page.css' );
			wp_enqueue_style('Font-awesome', THEME_DIR . '/assets/lib/font-awesome/css/font-awesome.min.css');
		}

		add_action( 'login_enqueue_scripts', 'listingpro_login_screen' );
	}
/*====================================================================================*/

/*====================================================================================*/
/* calculate average rate for listing */
	if(!function_exists('lp_cal_listing_rate')){
		function lp_cal_listing_rate($listing_id,$post_type = 'listing', $is_reviewcall = false){

			global $listingpro_options;
			$reviewEnabled = $listingpro_options['lp_review_switch'];

			if($post_type == 'lp_review'){
				$rating = listing_get_metabox_by_ID('rating' ,$listing_id);
			}else{
				$rating = get_post_meta( $listing_id, 'listing_rate', true );
			}
			$ratingRes = '';
			if(!empty($rating) && $rating > 0){

				if($rating < 1){
					$ratingRes = '<span class="rate lp-rate-worst">'.$rating.'<sup>/ 5</sup></span>';
				}

				else if($rating >=1 && $rating < 2){
					$ratingRes = '<span class="rate lp-rate-bad">'.$rating.'<sup>/ 5</sup></span>';
				}

				else if($rating >=2 && $rating < 3.5){
					$ratingRes = '<span class="rate lp-rate-satisfactory">'.$rating.'<sup>/ 5</sup></span>';
				}

				else if($rating >=3.5 && $rating <= 5){
					$ratingRes = '<span class="rate lp-rate-good">'.$rating.'<sup>/ 5</sup></span>';
				}

			}
			else{
				if (class_exists('ListingReviews')) {
					if ( is_singular('listing') ){

						if($is_reviewcall==true){
							$ratingRes = '';
						}
						else{
							if(get_post_status( $listing_id )!='publish'){
								$ratingRes = '<span class="no-review">'.esc_html__("Rating only enabled on published listing", "listingpro").'</span>';
							}
							else{
								if($reviewEnabled=="1"){
									$ratingRes = '<span class="no-review">'.esc_html__("Be the first one to rate!", "listingpro").'</span>';
								}
							}
						}
					}else{
						//$ratingRes = '<span class="no-review">'.esc_html__("0 Review", "listingpro").'</span>';
					}
				}

			}

			return $ratingRes;

		}
	}


	/* =============================================== cron-job for listing==================================== */
	add_action( 'wp', 'lp_expire_listings' );
	function lp_expire_listings() {
		if (! wp_next_scheduled ( 'lp_daily_cron_listing' )) {
		wp_schedule_event(time(), 'daily', 'lp_daily_cron_listing');
		}
	}
	add_action('lp_daily_cron_listing', 'lp_expire_this_listing');

	if(!function_exists('lp_expire_this_listing')){
		function lp_expire_this_listing(){
			global $wpdb;
			$dbprefix = $wpdb->prefix;
			$args=array(
				'post_type' => 'listing',
				'post_status' => 'publish',
				'posts_per_page' => -1,
			);
			$wp_query = null;
			$wp_query = new WP_Query($args);
			if( $wp_query->have_posts() ) {
				while ($wp_query->have_posts()) : $wp_query->the_post();
					$listing_id = get_the_ID();
					$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
					$plan_price = listing_get_metabox_by_ID('plan_price', $listing_id);
					if(!empty($plan_id)){
						$plan_duration = get_post_meta($plan_id, 'plan_time', true);
						if(!empty($plan_duration)){
							$sql =
								"UPDATE {$wpdb->posts}
								SET post_status = 'expired'
								WHERE (ID = '$listing_id' AND post_type = 'listing' AND post_status = 'publish')
								AND DATEDIFF(NOW(), post_date) > %d";
							$res = $wpdb->query($wpdb->prepare( $sql, $plan_duration ));
							if($res!=false){

								if(!empty($plan_price) && is_numeric($plan_price)){
									/* update in db table */
									$update_data = array('status' => 'in progress');
									$where = array('post_id' => $listing_id);
									$update_format = array('%s');
									$wpdb->update($dbprefix.'listing_orders', $update_data, $where, $update_format);
									/* update in db table */
								}

								$campaign_status = get_post_meta($listing_id, 'campaign_status', true);
								if(!empty($campaign_status)){
									delete_post_meta( $listing_id, 'campaign_status');
								}
								$adID = listing_get_metabox_by_ID('campaign_id', $listing_id);
								if(!empty($adID)){
									wp_delete_post( $adID, true );
								}

								$post_author_id = get_post_field( 'post_author', $listing_id );
								$user = get_user_by( 'id', $post_author_id );
								$useremail = $user->user_email;
								$website_url = site_url();
								$website_name = get_option('blogname');
								$listing_title = get_the_title($listing_id);
								$listing_url = get_the_permalink($listing_id);
								/* email to user */
								$headers[] = 'Content-Type: text/html; charset=UTF-8';

								$u_mail_subject_a = '';
								$u_mail_body_a = '';
								$u_mail_subject = $listingpro_options['listingpro_subject_listing_expired'];
								$u_mail_body = $listingpro_options['listingpro_listing_expired'];

								$u_mail_subject_a = lp_sprintf2("$u_mail_subject", array(
									'website_url' => "$website_url",
									'listing_title' => "$listing_title",
									'listing_url' => "$listing_url",
									'website_name' => "$website_name"
								));

								$u_mail_body_a = lp_sprintf2("$u_mail_body", array(
									'website_url' => "$website_url",
									'listing_title' => "$listing_title",
									'listing_url' => "$listing_url",
									'website_name' => "$website_name"
								));

								wp_mail( $useremail, $u_mail_subject_a, $u_mail_body_a, $headers);

							}
						}
					}
				endwhile;
			}
		}
	}

	/* =============================================== cron-job for ads ==================================== */

	add_action( 'wp', 'lp_expire_listings_ads' );
	function lp_expire_listings_ads() {
		if (! wp_next_scheduled ( 'lp_daily_cron_listing_ads' )) {
		wp_schedule_event(time(), 'daily', 'lp_daily_cron_listing_ads');
		}
	}
	add_action('lp_daily_cron_listing_ads', 'lp_expire_this_ad');
	if(!function_exists('lp_expire_this_ad')){
		function lp_expire_this_ad(){
			global $wpdb, $listingpro_options;
			$ads_durations = $listingpro_options['listings_ads_durations'];
			$args=array(
				'post_type' => 'lp-ads',
				'post_status' => 'publish',
				'posts_per_page' => -1,
			);
			$wp_query = null;
			$wp_query = new WP_Query($args);
			if( $wp_query->have_posts() ) {
				while ($wp_query->have_posts()) : $wp_query->the_post();
					$adID = get_the_ID();
					$ad_expiryDate = listing_get_metabox_by_ID('ad_expiryDate', $adID);
					$ads_listing = listing_get_metabox_by_ID('ads_listing', $adID);
					$currentdate = date("d-m-Y");
					if(strtotime($currentdate) > strtotime($ad_expiryDate)){
						$campaign_status = get_post_meta($ads_listing, 'campaign_status', true);
						if(!empty($campaign_status)){
							delete_post_meta( $ads_listing, 'campaign_status');
						}
						wp_delete_post( $adID, true );

						$listing_id = $ads_listing;
						$post_author_id = get_post_field( 'post_author', $listing_id );
						$user = get_user_by( 'id', $post_author_id );
						$useremail = $user->user_email;
						$website_url = site_url();
						$website_name = get_option('blogname');
						$listing_title = get_the_title($listing_id);
						$listing_url = get_the_permalink($listing_id);
						/* email to user */
						$headers[] = 'Content-Type: text/html; charset=UTF-8';

						$u_mail_subject_a = '';
						$u_mail_body_a = '';
						$u_mail_subject = $listingpro_options['listingpro_subject_ads_expired'];
						$u_mail_body = $listingpro_options['listingpro_ad_campaign_expired'];

						$u_mail_subject_a = lp_sprintf2("$u_mail_subject", array(
							'website_url' => "$website_url",
							'listing_title' => "$listing_title",
							'listing_url' => "$listing_url",
							'website_name' => "$website_name"
						));

						$u_mail_body_a = lp_sprintf2("$u_mail_body", array(
							'website_url' => "$website_url",
							'listing_title' => "$listing_title",
							'listing_url' => "$listing_url",
							'website_name' => "$website_name"
						));

						wp_mail( $useremail, $u_mail_subject_a, $u_mail_body_a, $headers);

					}

				endwhile;
			}
		}
	}

	/* =============================================== cron-job for recurring email ==================================== */

	add_action( 'wp', 'lp_payment_cron_alert_email' );
	function lp_payment_cron_alert_email() {
		if (! wp_next_scheduled ( 'lp_payments_cron_alets' )) {
		wp_schedule_event(time(), 'daily', 'lp_payments_cron_alets');
		}
	}
	add_action('lp_payments_cron_alets', 'lp_notify_payment_recurring');
	if(!function_exists('lp_notify_payment_recurring')){
		function lp_notify_payment_recurring(){
			global $wpdb, $listingpro_options;
			$lp_nofify;
			if(isset($listingpro_options['lp_recurring_notification_before'])){
				$lp_nofify = $listingpro_options['lp_recurring_notification_before'];
				$lp_nofify = trim($lp_nofify);
				$lp_nofify = (int)$lp_nofify;
			}
			else{
				$lp_nofify = 2;
			}
			$wherecond = 'status = "success" AND summary="recurring"';
			$recurringData = lp_get_data_from_db('listing_orders', '*', $wherecond);
			if(!empty($recurringData)){
				foreach($recurringData as $data){
					$plan_id = $data->plan_id;
					$plan_id = trim($plan_id);
					$listing_id = $data->post_id;
					$listing_id = trim($listing_id);
					$user_id = $data->user_id;
					$user_id = trim($user_id);

					$plan_title = get_the_title($plan_id);
					$listing_title = get_the_title($listing_id);

					$plan_price = get_post_meta($plan_id, 'plan_price', true);
					$plan_time = get_post_meta($plan_id, 'plan_time', true);

					if(is_numeric($plan_time)){
						$currentTime = date("Y-m-d");
						$publishedTime = get_the_time('Y-m-d', $listing_id);
						$currentTime = date_create($currentTime);
						$publishedTime = date_create($publishedTime);
						$interval = date_diff($currentTime, $publishedTime);
						/*2 days before plan end*/
						$plan_time = (int)$plan_time - $lp_nofify;
						$daysDiff = $interval->format('%d');
						if($daysDiff == $plan_time){

							$author_obj = get_user_by('id', $user_id);
							$author_email = $author_obj->user_email;
							$headers[] = 'Content-Type: text/html; charset=UTF-8';

							/* user email */
							$subject = $listingpro_options['listingpro_subject_recurring_payment'];
							$mail_content = $listingpro_options['listingpro_content_recurring_payment'];

							$formated_mail_content = lp_sprintf2("$mail_content", array(
								'listing_title' => "$listing_title",
								'plan_title' => "$plan_title",
								'plan_price' => "$plan_price",
								'plan_duration' => "$plan_time",
								'notifybefore' => "$lp_nofify"
							));

							wp_mail( $author_email, $subject, $formated_mail_content, $headers );

							/* admin email */
							$admin_email = get_option('admin_email');

							$subjectadmin = $listingpro_options['listingpro_subject_recurring_payment_admin'];
							$mail_content_admin = $listingpro_options['listingpro_content_recurring_payment_admin'];

							$formated_mail_content_admin = lp_sprintf2("$mail_content_admin", array(
								'listing_title' => "$listing_title",
								'plan_title' => "$plan_title",
								'plan_price' => "$plan_price",
								'plan_duration' => "$plan_time",
								'notifybefore' => "$lp_nofify"
							));

							wp_mail( $admin_email, $subjectadmin, $formated_mail_content_admin, $headers );

						}
					}

				}
			}

		}
	}

	/* =============================================== cron-job for renew listing==================================== */
	add_action( 'wp', 'lp_renew_recurring_listings' );
	function lp_renew_recurring_listings() {
		if (! wp_next_scheduled ( 'lp_daily_cron_revew_listing' )) {
		wp_schedule_event(time(), 'daily', 'lp_daily_cron_revew_listing');
		}
	}
	add_action('lp_daily_cron_revew_listing', 'lp_renew_this_listing');

	if(!function_exists('lp_renew_this_listing')){
		function lp_renew_this_listing(){

			global $wpdb, $listingpro_options;

			$wherecond = 'status = "success" AND summary="recurring"';
			$recurringData = lp_get_data_from_db('listing_orders', '*', $wherecond);
			if(!empty($recurringData)){
				foreach($recurringData as $data){
					$main_id = $data->main_id;
					$plan_id = $data->plan_id;
					$plan_id = trim($plan_id);
					$listing_id = $data->post_id;
					$listing_id = trim($listing_id);

					$plan_time = get_post_meta($plan_id, 'plan_time', true);
					$plan_time = trim($plan_time);

					if(is_numeric($plan_time)){
						$currentTime = date("Y-m-d");
						$publishedTime = get_the_time('Y-m-d', $listing_id);
						$currentTime = date_create($currentTime);
						$publishedTime = date_create($publishedTime);
						$interval = date_diff($currentTime, $publishedTime);
						$daysDiff = $interval->format('%d');
						if($daysDiff >= $plan_time){

							/* 1- update listing publish time and post status */
							$my_listing = array( 'ID' => $listing_id, 'post_date'  => date("Y-m-d H:i:s"), 'post_status'   => 'publish' );
							wp_update_post( $my_listing );
							/* 2- update date in database also */
							$table = 'listing_orders';
							$date = date('d-m-Y');
							$data = array('date'=>$date);
							$where = array('main_id'=>$main_id);
							lp_update_data_in_db($table, $data, $where);
						}
					}

				}
			}

		}
	}

	/* =============================================== getClosestTimezone ==================================== */


	function getClosestTimezone($lat, $lng)
	  {
		$diffs = array();
		foreach(DateTimeZone::listIdentifiers() as $timezoneID) {
		  $timezone = new DateTimeZone($timezoneID);
		  $location = $timezone->getLocation();
		  $tLat = $location['latitude'];
		  $tLng = $location['longitude'];
		  $diffLat = abs($lat - $tLat);
		  $diffLng = abs($lng - $tLng);
		  $diff = $diffLat + $diffLng;
		  $diffs[$timezoneID] = $diff;
		}

		$timezone = array_keys($diffs, min($diffs));
		$timestamp = time();
		date_default_timezone_set($timezone[0]);
		$zones_GMT = date('P', $timestamp);
		return $zones_GMT;

	  }
	/* ===========================listingpro remove version from css and js======================== */
	if(!function_exists('listingpro_remove_scripts_styles_version')){
		function listingpro_remove_scripts_styles_version( $src ) {
			if ( strpos( $src, 'ver=' ) )
				$src = remove_query_arg( 'ver', $src );
			return $src;
		}
	}
	add_filter( 'style_loader_src', 'listingpro_remove_scripts_styles_version', 9999 );
	add_filter( 'script_loader_src', 'listingpro_remove_scripts_styles_version', 9999 );

	/* js for invoice print */
	if(!function_exists('lp_call_invoice_print_preview')){
		function lp_call_invoice_print_preview(){
		wp_enqueue_script('lp-print-invoice', THEME_DIR. '/assets/js/jQuery.print.js', 'jquery', '', true);

		}
	}
	add_action( 'lp_enqueue_print_script', 'lp_call_invoice_print_preview' );

	/* check for receptcha */
	if(!function_exists('lp_check_receptcha')){
		function lp_check_receptcha($type){

				global $listingpro_options;
				if(isset($listingpro_options['lp_recaptcha_switch'])){
					if($listingpro_options['lp_recaptcha_switch']==1){

						if(isset($listingpro_options["$type"])){
							if($listingpro_options["$type"]==1){
								return true;
							}
						}
						else{
							return false;
						}

					}
					else{
						return false;
					}
				}
				else{
					return false;
				}
		}
	}

	/* check if package has purchased and has credit */
	if(!function_exists('lp_check_package_has_credit')){
		function lp_check_package_has_credit($plan_id){
			global $listingpro_options, $wpdb;
			$dbprefix = '';
			$dbprefix = $wpdb->prefix;
			$user_ID = get_current_user_id();
			$plan_type = '';
			$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
			$planPrice = get_post_meta($plan_id, 'plan_price', true);
			if( !empty($plan_type) && $plan_type=="Package" ){
				$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_id='$plan_id' AND status = 'success' AND plan_type='$plan_type'" );
				if( !empty($results) && count($results)>0 && !empty($planPrice) ){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}


	/* get used listing in package*/
	if(!function_exists('lp_get_used_listing_in_package')){
		function lp_get_used_listing_in_package($plan_id){
			global $listingpro_options, $wpdb;
			$used = 0;
			$dbprefix = '';
			$dbprefix = $wpdb->prefix;
			$user_ID = get_current_user_id();
			$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
			if( !empty($plan_type) && $plan_type=="Package" ){
				$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_Id='$plan_id' AND plan_type='$plan_type' AND status = 'success'" );
					if(!empty($results) && count($results)>0){
						foreach ( $results as $info ) {
								$used = $info->used;
						}
					}
			}
			return $used;
		}
	}

		/* check if listing is purchased and pending*/
	if(!function_exists('lp_if_listing_in_purchased_package')){
		function lp_if_listing_in_purchased_package($plan_id, $listing_id){
			global $wpdb;
			$postsIds = '';
			$postsIdsArray = array();
			$dbprefix = '';
			$dbprefix = $wpdb->prefix;
			$user_ID = get_current_user_id();
			$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
			if( !empty($plan_type) && $plan_type=="Package" ){
				$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_Id='$plan_id' AND plan_type='$plan_type' AND (status = 'success' OR status = 'expired')" );
					if(!empty($results) && count($results)>0){
						foreach ( $results as $info ) {
								$postsIds .= $info->post_id;
						}
					}
			}
			if(!empty($postsIds)){
				$postsIdsArray = explode(",",$postsIds);
				if (in_array($listing_id, $postsIdsArray)){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}

		}
	}


	/* package update credit */
	if(!function_exists('lp_update_credit_package')){
		function lp_update_credit_package($listing_id){
			global $listingpro_options, $wpdb;
			$listing_ids = '';
			$used = 0;
			$returnVal = false;
			$dbprefix = '';
			$dbprefix = $wpdb->prefix;
			$user_ID = get_current_user_id();
			$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
			$plan_type = get_post_meta($plan_id, 'plan_package_type', true);
			$posts_allowed_in_plan = get_post_meta($plan_id, 'plan_text', true);
			if( !empty($plan_type) && $plan_type=="Package" ){
				$packageHasCredit = lp_check_package_has_credit($plan_id);
				if(!empty($packageHasCredit) && $packageHasCredit=="1"){

					$results = $wpdb->get_results( "SELECT * FROM ".$dbprefix."listing_orders WHERE user_id ='$user_ID' AND plan_Id='$plan_id' AND plan_type='$plan_type' AND status = 'success'" );
					if(!empty($results) && count($results)>0){
						foreach ( $results as $info ) {
								$used = $info->used;
								$listing_ids = $info->post_id;
						}
						if(!empty($listing_ids)){
							$listing_ids = $listing_ids.','.$listing_id;
						}
						else{
							$listing_ids = $listing_id;
						}

						if( $used < $posts_allowed_in_plan ){
							$used++;
							$update_data = array('post_id' => $listing_ids, 'used' => $used);
							$where = array('user_id' => $user_ID, 'plan_id'=> $plan_id, 'plan_type' => $plan_type, 'status' => 'success');
							$update_format = array('%s', '%s');
							$wpdb->update($dbprefix.'listing_orders', $update_data, $where, $update_format);
							$returnVal = true;

						}

						if( $used == $posts_allowed_in_plan ){
							$update_data = array();
							$update_data = array('status' => 'expired');
							$where = array('user_id' => $user_ID, 'plan_id'=> $plan_id, 'plan_type' => $plan_type, 'status' => 'success');
							$update_format = array('%s');
							$wpdb->update($dbprefix.'listing_orders', $update_data, $where, $update_format);
						}


					}

				}
			}

			return $returnVal;
		}
	}

	/* change plan button */
	if(!function_exists('listingpro_change_plan_button')){
		function listingpro_change_plan_button($post, $listing_id=''){
			global $listingpro_options;
			$buttonEnabled = $listingpro_options['lp_listing_change_plan_option'];
			if($buttonEnabled=="enable"){
				$currency = listingpro_currency_sign();
				$buttonCode = '';
				$havePlan = "no";
				$planPrice = '';
				$listing_status = '';
				if(empty($listing_id)){
					$listing_id = $post->ID;
					$listing_status =  get_post_status( $listing_id );
					$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
					$planTitle = '';
					if(!empty($plan_id)){
						$planTitle = get_the_title($plan_id);
						$planPrice = get_post_meta($plan_id, 'plan_price', true);
						if(!empty($planPrice)){
							$planPrice = $currency.$planPrice;
						}
						else{
							$planPrice = esc_html__('Free', 'listingpro');
						}
						$planPrice .='/<small>'. get_post_meta($plan_id, 'plan_package_type', true).'</small>';
						$havePlan = "yes";

					}
					else{
						$planTitle = esc_html__('No Plan Assigned Yet', 'listingpro');
					}
					$buttonCode = '<a href="#" class="lp-review-btn btn-second-hover text-center lp-change-plan-btn" data-toggle="modal" data-target="#modal-packages" data-listingstatus="'.$listing_status.'" data-planprice="'.$planPrice.'"  data-haveplan="'.$havePlan.'" data-plantitle = "'.$planTitle.'" data-listingid="'.$listing_id.'" title="change">'.esc_html__('Change Plan', 'listingpro').'</a>';
				}
				else{
					$listing_id = $post->ID;
					$listing_status =  get_post_status( $listing_id );
					$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
					$planTitle = '';
					if(!empty($plan_id)){
						$planPrice = get_post_meta($plan_id, 'plan_price', true);
						if(!empty($planPrice)){
							$planPrice = $currency.$planPrice;
						}
						else{
							$planPrice = esc_html__('Free', 'listingpro');
						}
						$planTitle = get_the_title($plan_id);
						$planpkgtype = '';
						$plantype = get_post_meta($plan_id, 'plan_package_type', true);
						if($plantype=="Package"){
							$planpkgtype = esc_html__('Package', 'listingpro');
						}
						else{
							$planpkgtype = esc_html__('Pay Per Listing', 'listingpro');
						}
						$planPrice .='/<small>'. $planpkgtype.'</small>';
						$havePlan = "yes";

					}
					else{
						$planTitle = esc_html__('No Plan Assigned Yet', 'listingpro');
					}
					$buttonCode = '<a href="#" class="lp-review-btn btn-second-hover text-center lp-change-plan-btn" data-toggle="modal" data-target="#modal-packages" data-listingstatus="'.$listing_status.'"  data-planprice="'.$planPrice.'"  data-haveplan="'.$havePlan.'" data-plantitle = "'.$planTitle.'" data-listingid="'.$listing_id.'" title="change">'.esc_html__('Change Plan', 'listingpro').'</a>';
				}


				global $listingpro_options;
				$paidmode = $listingpro_options['enable_paid_submission'];
				if( !empty($paidmode) && $paidmode=="yes" ){
				return $buttonCode;
				}else{
					return;
				}
			}
		}
	}

	/* listingpro get payments status of listing */
	if(!function_exists('lp_get_payment_status_column')){
		function lp_get_payment_status_column($listing_id){
			global $wpdb;
			$returnStatus = '';
			$table_name = $wpdb->prefix . 'listing_orders';
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
				$field_name = 'status';
				$prepared_statement = $wpdb->prepare( "SELECT {$field_name} FROM {$table_name} WHERE  post_id = %d", $listing_id );
				$values = $wpdb->get_col( $prepared_statement );
				if(!empty($values)){
					if($values[0]=="success"){
						$returnStatus = esc_html__('Success', 'listingpro');
					}
					else{
						$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
						if(!empty($plan_id)){
							$plan_price = get_post_meta($plan_id, 'plan_price', true);
							if(!empty($plan_price)){
								$returnStatus = esc_html__('Pending', 'listingpro');
							}
							else{
								$returnStatus = esc_html__('Free', 'listingpro');
							}

						}
						else{
							$returnStatus = esc_html__('Free', 'listingpro');
						}

					}
				}
				else{
					$returnStatus = esc_html__('Free', 'listingpro');
				}
			}
			return $returnStatus;
		}
	}

	/* listingpro get payments status of listing by id */
	if(!function_exists('lp_get_payment_status_by_ID')){
		function lp_get_payment_status_by_ID($listing_id){
			global $wpdb;
			$returnStatus = '';
			$table_name = $wpdb->prefix . 'listing_orders';
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
				$field_name = 'status';
				$prepared_statement = $wpdb->prepare( "SELECT {$field_name} FROM {$table_name} WHERE  post_id = %d", $listing_id );
				$values = $wpdb->get_col( $prepared_statement );
				if(!empty($values)){
					if($values[0]=="success"){
						$returnStatus = 'success';
					}
					else{
						$plan_id = listing_get_metabox_by_ID('Plan_id', $listing_id);
						if(!empty($plan_id)){
							$plan_price = get_post_meta($plan_id, 'plan_price', true);
							if(!empty($plan_price)){
								$returnStatus = 'pending';
							}
							else{
								$returnStatus = 'free';
							}

						}
						else{
							$returnStatus = 'free';
						}

					}
				}
				else{
					$returnStatus = 'free';
				}
			}
			return $returnStatus;
		}
	}


	/* lp count user campaign by id */
	if(!function_exists('lp_count_user_campaigns')){
		function lp_count_user_campaigns($userid){
			$count = 0;
			$args = array(
				'post_type' => 'lp-ads',
				'posts_per_page' => -1,
				'post_status' => 'publish'
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$listingID = listing_get_metabox_by_ID('ads_listing', get_the_ID());
					$listing_author = get_post_field( 'post_author', $listingID );
					if($userid==$listing_author){
						$count++;
					}
				}
				wp_reset_postdata();
			}
			return ($count) ? $count : 0;
		}
	}

	/* count no.of post by user id */
	if(!function_exists('count_user_posts_by_status')){
		function count_user_posts_by_status($post_type = 'listing',$post_status = 'publish',$user_id = 0, $userListing=false){
			global $wpdb;
			$count = 0;
			if($userListing==false){

				$count = $wpdb->get_var(
					$wpdb->prepare(
					"
					SELECT COUNT(ID) FROM $wpdb->posts
					WHERE post_status = %s
					AND post_type = %s
					AND post_author = %d",
					$post_status,
					$post_type,
					$user_id
					)
				);

			}
			else{
				$pid = $wpdb->get_col(
					$wpdb->prepare(
					"
					SELECT ID FROM $wpdb->posts
					WHERE post_status = %s
					AND post_type = %s
					AND post_author = %d",
					$post_status,
					$post_type,
					$user_id
					)
				);
				if(!empty($pid)){
					foreach($pid as $id){
						$listingID = listing_get_metabox_by_ID('ads_listing', $id);
						$uid = get_post_field( 'post_author', $listingID );
						if($uid==$user_id){
							$count++;
						}
					}
				}
			}

			return ($count) ? $count : 0;

		}
	}

	/* check user reviews by user id and listing id */
	if(!function_exists('lp_check_user_reviews_for_listing')){
		function lp_check_user_reviews_for_listing($uid, $listing_id){
			$returnVal = false;
			if(!empty($uid) && !empty($listing_id)){

				$args = array(
					'post_type'  => 'lp-reviews',
					'post_status'	=> 'publish',
					'author' => $uid,
					'posts_per_page' => -1,

			 	);
			 	$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$listingid = listing_get_metabox_by_ID('listing_id', get_the_ID());
						if($listingid==$listing_id){
							$returnVal = true;
						}
					}
					wp_reset_postdata();
				}

			}
			else{
				$returnVal = false;
			}
			return $returnVal;
		}
	}

	/* adding new user meta for new subscription */
	if(!function_exists('lp_add_new_susbcription_meta')){
		function lp_add_new_susbcription_meta($new_susbcription){
			if(!empty($new_susbcription)){
				$uid = get_current_user_id();
				$existing_subsc = get_user_meta($uid, 'listingpro_user_sbscr', true);
				if(!empty($existing_subsc)){
					array_push($existing_subsc, $new_susbcription);
					update_user_meta($uid, 'listingpro_user_sbscr', $existing_subsc);
				}
				else{
					$new_subsc[] = $new_susbcription;
					update_user_meta($uid, 'listingpro_user_sbscr', $new_subsc);
				}
			}
		}
	}

	/* cancel subscription from stripe */
	if(!function_exists('lp_cancel_stripe_subscription')){
		function lp_cancel_stripe_subscription($listing_id, $plan_id){
			if(!empty($plan_id) && !empty($listing_id)){
				global $listingpro_options;
				require_once THEME_PATH . '/include/stripe/stripe-php/init.php';
				$secritKey = $listingpro_options['stripe_secrit_key'];
				\Stripe\Stripe::setApiKey("$secritKey");

				$uid = get_current_user_id();
				$userSubscriptions = get_user_meta($uid, 'listingpro_user_sbscr', true);
				if(!empty($userSubscriptions)){
					foreach($userSubscriptions as $key=>$subscriptions){
						$subc_listing_id = $subscriptions['listing_id'];
						$subc_plan_id = $subscriptions['plan_id'];
						$subc_id = $subscriptions['subscr_id'];
						if( ($subc_listing_id== $listing_id) && ($subc_plan_id == $plan_id) ){
							$subscription = \Stripe\Subscription::retrieve($subc_id);
							$subscription->cancel();
							unset($userSubscriptions[$key]);
							break;
						}
					}
				}

				/* update metabox */
				if(!empty($userSubscriptions)){
					update_user_meta($uid, 'listingpro_user_sbscr', $userSubscriptions);
				}
				else{
					delete_user_meta($uid, 'listingpro_user_sbscr');
				}

			}
		}
	}

	/* remove trash ads permanently */
	if(!function_exists('listingpro_trash_ads_delete')){
		function listingpro_trash_ads_delete($post_id) {
			if (get_post_type($post_id) == 'lp-ads') {
				// Force delete
				wp_delete_post( $post_id, true );
			}
		}
	}
	add_action('wp_trash_post', 'listingpro_trash_ads_delete');



	/* get distance between co-ordinates */
	if(!function_exists('GetDrivingDistance')){

		function GetDrivingDistance($latitudeFrom,$latitudeTo, $longitudeFrom,$longitudeTo, $unit){
			$unit = strtoupper($unit);
			$theta = $longitudeFrom - $longitudeTo;
			$dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = $dist * 60 * 1.1515;
			if ($unit == "KM") {
				  $distance = ($miles * 1.609344);
				  $dist = round($distance, 1);
				  return array('distance' => $dist);
			  }else {
				  $dist = round($miles, 1);
				  return array('distance' => $dist);
			  }



		}

	}

	/* get lat and long from address and set for listing */
	if(!function_exists('lp_get_lat_long_from_address')){
		function lp_get_lat_long_from_address($address, $listing_id){
			$exLat = listing_get_metabox_by_ID('latitude', $listing_id);
			$exLong = listing_get_metabox_by_ID('longitude', $listing_id);
			if(empty($exLat) && empty($exLong)){
				if( !empty($address) && !empty($listing_id) ){
					$address = str_replace(" ", "+", $address);
					//$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
					$url = "https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

					$data = curl_exec($ch);
					curl_close($ch);

					//$json = json_decode($json);
					$json = json_decode($data);
					if(!empty($json)){
					$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
						$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
						if(!empty($lat) && !empty($long)){
							//set lat and long for listing
							listing_set_metabox('latitude', $lat, $listing_id);
							listing_set_metabox('longitude', $long, $listing_id);
						}
					}

				}
			}
		}
	}

	/* hide activatio notice vc */
	add_action('admin_head', 'lp_hide_vc_notification_css');
	if(!function_exists('lp_hide_vc_notification_css')){
		function lp_hide_vc_notification_css() {
			echo '<style>#vc_license-activation-notice { display: none !important; }</style>';
		}
	}

	/* ==============start add by sajid ============ */
	add_filter('body_class', 'listing_view_class');
	if(!function_exists('listing_view_class')){
		function listing_view_class( $classes ){
			global $listingpro_options;
			$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
			if( $listing_mobile_view == 'app_view' && wp_is_mobile()){
			$classes[]  =   'listing-app-view';
			}
			$app_view_home  =   $listingpro_options['app_view_home'];
			 $app_view_home  =   url_to_postid( $app_view_home );
			if( is_page( $app_view_home ) && $listing_mobile_view == 'app_view' && wp_is_mobile() )
			{
			   $classes[]  =   'app-view-home';
			}
			return $classes;
		}
	}

	/* ========listingpro_footer_menu_app======== */

	if (!function_exists('listingpro_footer_menu_app')) {
		function listingpro_footer_menu_app() {
			$defaults = array(
				'theme_location'  => 'footer_menu',
				'menu'            => '',
				'container'       => 'false',
				'menu_class'      => '',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);

			if ( has_nav_menu( 'footer_menu' ) ) {
				return wp_nav_menu( $defaults );
			}
		}
	}

	/* ==============end add by sajid ============ */


/* ===========================listingpro check plugin version======================== */
if(!function_exists('lp_notice_plugin_version')){
	function lp_notice_plugin_version() {

		$lp_theme = wp_get_theme();
		if($lp_theme=="Listingpro"){
			$themeVersion = $lp_theme->Version;
			$lpallPlugins = get_plugins();
			if(class_exists('ListingproPlugin')){
				$listpro_plugin = $lpallPlugins['listingpro-plugin/plugin.php'];
				if(array_key_exists("Version",$listpro_plugin)){
					$pluginVersion = $listpro_plugin['Version'];
					if($themeVersion != $pluginVersion){
						$class = 'notice notice-warning';

						$message = '<h3>'.__('Important Update Notice!', 'listingpro-plugin').'</h3>';

						$message .= __('Thanks for updating your theme, now we highly recommend you to also update the following plugin called  ', 'listingpro-plugin');
						$message .= '<strong>';
						$message .= __('ListingPro Plugin', 'listingpro-plugin');
						$message .= '</strong>';
						$message .= __( '  Go to Plugins, deactivate and delete  *ListingPro Plugin*. After deleting, the following notice will appear,  ', 'listingpro-plugin' );
						$message .= '<strong>';
						$message .= __('This theme requires the following plugin - Listingpro Plugin', 'listingpro-plugin');
						$message .= '</strong>';
						$message .= __( '  Click  ', 'listingpro-plugin' );

						$message .= '<strong>';
						$message .= __('begin installing plugin', 'listingpro-plugin');
						$message .= '</strong>';
						$message .= __( '  link. After installation is complete, activate the plugin. Listingpro plugin will be up to date', 'listingpro-plugin' );
						$message .= '<br/>';
						$message .= __( '  Additional Note for CHILD THEME Users: If you are using child theme then please switch to parent theme and follow the above steps and then switch back to child theme', 'listingpro-plugin' );




						printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
					}
				}
			}
		}

	}
}
add_action( 'admin_notices', 'lp_notice_plugin_version' );

	/* ==============lp get free fields ============ */
	if (!function_exists('listingpro_get_term_openfields')) {
		function listingpro_get_term_openfields($onbackend=false) {


			$lpAllCatIds = array();
			$lp_catterms = get_terms( array(
				'taxonomy' => 'listing-category',
				'hide_empty' => false,
			) );

			if(!empty($lp_catterms)){
				foreach($lp_catterms as $term){
					array_push($lpAllCatIds,$term->term_id);
				}
			}


			$output = null;
			$fieldIDs = array();

			$texQuery = array(
                'key' => 'lp_listingpro_options',
                'value' => $lpAllCatIds,
                'compare' => 'NOT IN'
            );



			$argss = array(
					'post_type'  => 'form-fields',
					'posts_per_page'  => -1,
					'meta_query' => array(
						$texQuery
					)
			);
			$the_queryy = null;
			$the_queryy = new WP_Query( $argss );
			if ( $the_queryy->have_posts() ) {
				while ( $the_queryy->have_posts() ) {
					$the_queryy->the_post();
					$fID = get_the_ID();
					$yesString = esc_html__('Yes', 'listingpro');
					$exclusiveCheck = listing_get_metabox_by_ID('exclusive_field', $fID);
					if( !empty($exclusiveCheck) && $exclusiveCheck==$yesString ){
						array_push($fieldIDs,get_the_ID());
					}
					wp_reset_postdata();
				}
			}
			if($onbackend==false){
				$output = listingpro_field_type($fieldIDs);
			}else{
				$output = $fieldIDs;
			}


			return $output;

		}
	}
	/* ============== /// ============ */

	/* ==============  get post count of taxonomy term============ */
	if(!function_exists('lp_count_postcount_taxonomy_term_byID')){
		function lp_count_postcount_taxonomy_term_byID($post_type,$taxonomy, $termid){
			$postcounts = 0;
			$argss = array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => 'term_id',
						'terms'    => array($termid),
					),
				),
			);
			$the_query = new WP_Query( $argss );
			if ( $the_query->have_posts() ) {
				$postcounts = $the_query->post_count;
			}
			return $postcounts;
		}
	}

	/* ============== is favourite or not only ============ */
	if ( !function_exists('listingpro_is_favourite_new' ) )
	{
		function listingpro_is_favourite_new( $postid )
		{
			$favposts = ( isset( $_COOKIE['newco'] ) ) ? explode(',', (string) $_COOKIE['newco']) : array();
			$favposts = array_map('absint', $favposts); // Clean cookie input, it's user input!
			$return =   'no';
			if ( in_array( $postid,$favposts  ) )
			{
				$return =   'yes';
			}
			return $return;
		}
	}

	/* ============== for mail sprintfto function============= */
	if ( !function_exists('lp_sprintf2' ) ){
		function lp_sprintf2($str='', $vars=array(), $char='%'){
			if (!$str) return '';
			if (count($vars) > 0)
			{
				foreach ($vars as $k => $v)
				{
					$str = str_replace($char . $k, $v, $str);
				}
			}

			return $str;
		}
	}

	/* ============== default featured image for listing ============= */
	if ( !function_exists('lp_default_featured_image_listing' ) ){
		function lp_default_featured_image_listing(){
			global $listingpro_options;
			$deafaultFeatImg = '';
			if( isset($listingpro_options['lp_def_featured_image']) && !empty($listingpro_options['lp_def_featured_image']) ){

				$deafaultFeatImgID = $listingpro_options['lp_def_featured_image']['id'];
				if( !empty($deafaultFeatImgID) ){
					$deafaultFeatImg = wp_get_attachment_image_src($deafaultFeatImgID, 'listingpro-blog-grid', true );
					$deafaultFeatImg = $deafaultFeatImg[0];
				}else{
					$deafaultFeatImg = $listingpro_options['lp_def_featured_image']['url'];
				}
			}
			return $deafaultFeatImg;
		}
	}
