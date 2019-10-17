<?php 
	global $listingpro_options;
	
	$copy_right = $listingpro_options['copy_right'];
	$footer_address = $listingpro_options['footer_address'];
	$phone_number = $listingpro_options['phone_number'];
	$author_info = $listingpro_options['author_info'];
	$fb = $listingpro_options['fb'];
	$tw = $listingpro_options['tw'];
	$gog = $listingpro_options['gog'];
	$insta = $listingpro_options['insta'];
	$tumb = $listingpro_options['tumb'];
	$fyout = $listingpro_options['f-yout'];
	$flinked = $listingpro_options['f-linked'];
	$fpintereset = $listingpro_options['f-pintereset'];
	$fvk = $listingpro_options['f-vk'];
	
	
	$footerNeed = true;
	$listing_style = $listingpro_options['listing_style'];
	if(isset($_GET['list-style']) && !empty($_GET['list-style'])){
		$listing_style = esc_html($_GET['list-style']);
	}
	if(is_tax('location') || is_tax('listing-category') || is_tax('list-tags') || is_tax('features') || is_search()){
		if($listing_style == '2' || $listing_style == '3'){
			$footerNeed = false;
		}
	}
	
	$latitude = listing_get_metabox('latitude');
    $longitude = listing_get_metabox('longitude');
    $phone = listing_get_metabox('phone');
    $col_class  =   '4';
    if(empty($phone)){
        $col_class  =   '6';
    }

?>
<!--==================================Footer Open=================================-->
<?php if( !is_singular('listing')){ ?>
<div class="footer-app-menu">
    <?php
    if(has_nav_menu('footer_menu')):
        echo listingpro_footer_menu_app();
    else:
        if( $author_info ){
            echo '<p class="credit-links">'.$author_info.'</p>';
        }
    endif;
    ?>
</div>
<?php } ?>
	<?php if(is_singular('listing')): ?>
		<footer class="text-center">
			<div class="footer-upper-bar footer-upper-bar-for-app">
				<div class="container">
					<div class="row">
                        <?php
                        if( !empty($phone)){
                           ?>
                            <div class="col-sm-4 col-xs-4"><a href="tel:<?php echo $phone; ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAACe0lEQVRIS8WWgVEbMRBF/3ZAKojTASWQCkIHMRVABzgdkAqACkIqCKkASnAqCB38zNOsbnSXw76zj0EzjAedpL/79++XQu80Yi6u7TtJLxFxNXdvu34nsO0zSduI2LLJNmBrSWcR8bIosO0TSbeSziX9ycPvImJje5XZFlDbp5JWEfEwN4j/Mrb9LAk6OexREoczd1qztE1Q15LYvzka2PZG0kmtn22AmYPex4ggIDLlf0rA94NGL2Pb1LLNrNRT0g0sRATZLzI64BQStAHUDdvUE0CoX0fEc9b2Sy66r+KbE1ELTN1Qa69Nkn7OhA2+rxOY9YybQxTeAkMrCqWmbcYomfqubDsiZvf+GBN7qU4xQbMlfRiWYg697doWmP5Fqfz2RhoHJeiEdyhg3TdUNZmh3p4hpMCoL/28yBgCo+gxZSOs8zcDznpiCmRdzQKKASag5fu48pd+DDjUbtNCUTrtg6ovluB6tDXSEq/IMC8NBIeREBB9W9g4Zrzak+29m+DFQPICuY2I768Bp+l8lISrjfr5vvsYFZcMk4V6YfD7V9LF0LVs4+swBCD6YN23YQD7gOsBY+Bkz8GXEXGfwsT9qvNdM1/vgDSgLoC99pc0d7VNn6bPf0BlghPEL0mfsxzEQQDMtwHARkliL3BmUjMvtc1gyjMoPRw/5697JuU+5roAJH1invtgEnADjprx7FJbAphyM2WLEsDX3Dst41a9qVhqWSic01L50Cj+MDnjAXiPwikBDJ/FBwE3Lod4yB5XQ2wPEfFzECTfLnmx8ogYvZ3m0DY4HPEBUF4xkp7yO97+O5XcM5KjMt7hXEXlu16hbwI8hbl3A/4H+MVJLuHKNL4AAAAASUVORK5CYII=" /></a></div>
                            <?php
                        }
                        ?>
                        <div class="col-sm-<?php echo $col_class; ?> col-xs-<?php echo $col_class; ?>"><a class="open-lead-form-app-view"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAABv0lEQVRIS+WW7VECQRBEezIwAzQCyUCMQI1AiECMQIxAjUCNQI1AzUAjUDMwg7be1R61fNyBcHA/2D9QxbFve6Z7bkMtrWiJqx0E236T5G2XPGwDfZT0vSX4vqTzEnwcESjf+LLdk/Ragj8kAf/dJNn2HlBJ3RL8k/p8FhEcovFluyvpSSqS1BmXWlJf0klS3ig8QVH6IukhL3XRY9sjSVeSBhHBA2sv2wi6l3QdEaPpHo/NlT04jIi7dcjzhFSCAaUfn+lJRAxWgdumYqeSerlvasEJjhmIGL2h9Es5PjkXEx0AnjbrQnCCY/9ysi2MWxYXnIvSmcMuBc7KjmomW2XcMudy2MqBtBQ4MxomY0PiBnxiyqXNKC9xQeVFVTIWgjNz4O4iWraHkm4k8cl8ZwEhhpcRcZueI0J8nzFnXZwY4uWE6c8xB05l004CM/U4HCkYr1R6DsxLaOyPueCsZO9Msjonp41VN2KT2YAflS2aATO4UxmLCbNKdqv+kw0SWvQ5/XYid6icKFlTB7BNi1D/lb+dOAVh3+hlwDb+Qdhh6xcBSrBRtVnLUN1H8VauPNNe2cF7dVNx+e8+rZX6D45VP1danI7yAAAAAElFTkSuQmCC" /></a></div>
                        <div class="col-sm-<?php echo $col_class; ?> col-xs-<?php echo $col_class; ?>"><a target="_blank" href="https://www.google.com/maps?daddr=<?php echo esc_attr($latitude); ?>,<?php echo esc_attr($longitude); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAChklEQVRIS62X/VEUQRDFX0egRKBEIGQAEYARQAZCBGAEYARgBGoEYgRKBGAEkkFbv6ueq9m5+drS+Wer9nb6db9+/WbOtHK5+2tJ7yTxZL1IejQzntPLZr909yNJHySdxp7HeJIE66ukT2b2MBNzCBwV3kg6l/RZ0q2Z/cqDu/uBpAtJZ5LuJV2OGOgCB+h3SXx3ambPvWrc/W1U7pKOe+AjYOgj2NGogpRQJAvdT2b2vpVoE9jdofYW4FnQDJxkace5mZH8zuoBQ+u9mV2Xu4LSJKoftcTcnX1nZrY/DRxi+SlprwwaAa8k/Y6AbyRdm9nHQnCM2x9J+zVtVCt2dxQKTah1u+I9lSC0zdjEmEEn4LQm/x66YW3xng9awARHUMxuHgiTuDAzRiZ/jx5uzGyveE9yD7V29YARFQE3K/r61KC/Squ7k+DzWuBFxTEm1Z61knL31RVD8V2pSHenZ1CHBnKq6eFBozVbPeR7WlQjqh1Vh9qpAjdLfaYdx6GJrZVmDB2WFtsUV/SUOUappZAwh02FUQFgCG5hp2FA7Of7ndUzkORa6TSq7W++c3dGDGEt2pI29IAB/FJT8SiDEc1dqjO6q7bZAw93Q1QLAxqKK5tdhHPV8tsaeFTLvHMmL/QxDRxVV92qVXFUi91WRTXscVY14uBQwOy796rZaoc9zsCbR2RhJFCL1S48ftU4FQEJhGlUj7hoSTIdrjzDC9/wspdVzVy+MjNcame17LSlhTXAnEDJzcpzl2OUCcCvp+7X08BBZzKVrf9mt5UpiqdVXVLl7lR7IukwfuMw+dayxn+muhAbBwMmwUJwTYf638Dp+krc1dff6TluqHjjTKN/F62K/wJMt08u3bnztwAAAABJRU5ErkJggg=="/></a></div>
                    </div>
				</div>
			</div><!-- ../footer-upper-bar -->
		</footer>
	<?php endif; ?>

<!-- End Main -->
</div>
<?php wp_footer(); ?>

	</body>	
</html>
