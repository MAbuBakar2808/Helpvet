<?php
class listingpro_contactinfo extends WP_Widget {

    function __construct() {
        $widget_ops = array(
            'classname' => 'contact_widget',
            'description' => 'Contact info.'
        );
        $control_ops = array('width' => 80, 'height' => 80);
        parent::__construct(false, 'listingpro contact info', $widget_ops, $control_ops);
    }

    function form($instance) {
       
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
       
        return $instance;
    }

    function widget($args, $instance) {
        extract($args);
       $class = apply_filters('widget_class', empty($instance['class']) ? '' : $instance['class'], $instance);

        echo wp_kses_post($before_widget);

        
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
		$fpintereset = $listingpro_options['f-pintereset'];
		 
		if($listingpro_options['primary_logo'] != ''){ 
		echo '<div class="footer-logoo"><img src="'.wp_kses_post($listingpro_options['primary_logo']['url']).'" alt="footer" /></a></div>';
		}	
						
						
				
			
         echo '<div class="contact-info-widget marggin-bottom-20">';
            echo '<ul>';
				if(!empty($phone_number)){
                    echo '<li><div><i class="fa fa-phone" aria-hidden="true"></i>'.$phone_number.'</div></li>';
                }
				 
                if(!empty($footer_address)){
                    echo '<li><div><i class="fa fa-map-marker" aria-hidden="true"></i>'.$footer_address.'</div></li>';
                }
				if(!empty($author_info)){
                    echo '<li><div>'.$copy_right.' '.$author_info.'</div></li>';
                }
				
               
            echo '</ul>';
        echo '</div>';
		
		if(!empty($tw) || !empty($gog) || !empty($fb) || !empty($insta) || !empty($tumb) ){ 
		echo '<ul class="social-icons footer-social-icons footer-social-icons-widget">';
			if(!empty($fb)){
                    echo '<li>
								<a href="'.$fb.'" target="_blank">
									'.listingpro_icons('facebook').'
								</a>
							</li>';
                }
			if(!empty($tw)){
                    echo '<li>
								<a href="'.$tw.'" target="_blank">
									'.listingpro_icons('tw-footer').'
								</a>
							</li>';
                }	 
			if(!empty($gog)){
                    echo '<li>
								<a href="'.$gog.'" target="_blank">
									'.listingpro_icons('google').'
								</a>
							</li>';
                }
		
			if(!empty($insta)){
                    echo '<li>
								<a href="'.$insta.'" target="_blank">
									'.listingpro_icons('instagram').'
								</a>
							</li>';
                }
			if(!empty($tumb)){
                    echo '<li>
								<a href="'.$tumb.'" target="_blank">
									'.listingpro_icons('tumbler').'
								</a>
							</li>';
                }	
			if(!empty($fpintereset)){
                    echo '<li>
								<a href="'.$fpintereset.'" target="_blank">
									'.listingpro_icons('pinterest').'
								</a>
							</li>';
                }	
		 echo '</ul>';
						
        }?>

        <?php
        echo wp_kses_post($after_widget);
    }

}

add_action('widgets_init', create_function('', 'return register_widget("listingpro_contactinfo");'));
?>