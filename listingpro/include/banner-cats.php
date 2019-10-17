<?php

/**
 * Banner Categories.
 *
 */



/* ============== ListingPro Banner Categories ============ */



	if (!function_exists('listingpro_banner_categories')) {



		function listingpro_banner_categories() {

			global $listingpro_options;

			if(isset($listingpro_options['home_banner_cats'])){

				$homeBannerCategory = $listingpro_options['home_banner_cats'];

			}

			else{

				$homeBannerCategory = '';

			}





			$search_view = $listingpro_options['search_views'];

			$search_layout = $listingpro_options['search_layout'];

			$alignment = $listingpro_options['search_alignment'];

			$top_banner_styles = $listingpro_options['top_banner_styles'];

			$cat_txt = $listingpro_options['cat_txt'];



			$alignClass = '';

			if ( $alignment == 'align_top' ) {

				$alignClass = 'lp-align-top';

			}elseif ( $alignment == 'align_middle' ) {

				$alignClass = 'lp-align-underBanner';

			}elseif ( $alignment == 'align_bottom' ) {

				$alignClass = 'lp-align-bottom';

			}





			$output = '';

			if(isset($homeBannerCategory) && !empty($homeBannerCategory)){



				$output .= '<div class="lp-section-row margin-bottom-60">';

					$output .= '<div class="container">';

						$output .= '<div class="row">';

							$output .= '<div class="col-md-12">';

								if( $top_banner_styles == 'map_view' ) {

									if( $alignment == 'align_middle' || $alignment == 'align_bottom' ) {

										$output .= '

										<div class="col-md-8 col-xs-12 col-md-offset-2 col-sm-offset-0">

											<div class="text-center lp-search-description">

												<p>'.$cat_txt.'</p>

												<img src="'.get_template_directory_uri().'/assets/images/banner-arrow-dark.png" alt="banner-arrow" class="banner-arrow">

											</div>

										</div>';

									}

								}

								$output .= '<ul class="lp-home-categoires padding-left-0">';

									$ucat = array(

									 'post_type' => 'listing',

									  'hide_empty' => false,

									  'include'=> $homeBannerCategory

									);

									$categories = get_terms( 'listing-category',$ucat);

									foreach($categories as $category) {

										$category_image = listing_get_tax_meta($category->term_id,'category','image2');

										if(empty($category_image)){

											$category_image = listing_get_tax_meta($category->term_id,'category','image');

										}

										$output .= '<li>';

										//$output .= '<a href="'.get_term_link($category->term_id, 'listing-category').'" class="lp-border-radius-5">';
										$output .= '<a data-name="'.$category->name.'" data-id="'.$category->term_id.'" href="#" class="lp-border-radius-5">';	

											$output .= '<span>';

											if(!empty($category_image)){

											$output .= '<img class="icon icons-banner-cat" src="'.$category_image.'" alt="Food" /><br>';

											}

											$output .= $category->name;

											$output .= '</span>';

										$output .= '</a>';

										$output .= '</li>';

									}



								$output .= '</ul>';

							$output .= '</div>';

						$output .= '</div>';

					$output .= '</div>';

				$output .= '</div>';

			}

			return $output;

		}



	}
