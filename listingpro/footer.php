<?php
global $listingpro_options;
$listing_mobile_view    =   $listingpro_options['single_listing_mobile_view'];
if( $listing_mobile_view == 'app_view' && wp_is_mobile() ){
    get_template_part( 'footer-app-view' );
}else
{

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
    $footer_style = $listingpro_options['footer_style'];

    $footerNeed = true;
    $listing_style = $listingpro_options['listing_style'];
    if(isset($_GET['list-style']) && !empty($_GET['list-style'])){
        $listing_style = esc_html($_GET['list-style']);
    }
    if(is_tax('location') || is_tax('listing-category')  || is_tax('list-tags') || is_tax('features') || is_search()){
        if($listing_style == '2' || $listing_style == '3'){
            $footerNeed = false;
        }
    }

    if($footerNeed == true){

        ?>
        <!--==================================Footer Open=================================-->
        <?php if($footer_style == 'footer1') { ?>
            <footer class="text-center">
                <?php
                if(has_nav_menu('footer_menu')):
                    ?>
                    <div class="footer-upper-bar">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo listingpro_footer_menu(); ?>
                                </div>
                            </div>
                        </div>
                    </div><!-- ../footer-upper-bar -->
                <?php endif; ?>
                <div class="footer-bottom-bar">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="footer-about-company">

                                    <?php

                                    if( $copy_right ){
                                        echo '<li>'.$copy_right.'</li>';
                                    }

                                    ?>

                                    <?php

                                    if( $footer_address ){
                                        echo '<li>'.$footer_address.'</li>';
                                    }

                                    ?>

                                    <?php

                                    if( $phone_number ){
                                        echo '<li>'.esc_html__('Tel', 'listingpro').' '.$phone_number.'</li>';
                                    }

                                    ?>

                                </ul>

                                <?php

                                if( $author_info ){
                                    echo '<p class="credit-links">'.$author_info.'</p>';
                                }

                                ?>
                                <?php if(!empty($tw) || !empty($gog) || !empty($fb) || !empty($insta) || !empty($tumb) || !empty($fpintereset) || !empty($flinked) || !empty($fyout) || !empty($fvk)){ ?>
                                    <ul class="social-icons footer-social-icons">
                                        <?php if(!empty($fb)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($fb); ?>" target="_blank">
                                                    <?php echo listingpro_icons('facebook'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($gog)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($gog); ?>" target="_blank">
                                                    <?php echo listingpro_icons('google'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($tw)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($tw); ?>" target="_blank">
                                                    <?php echo listingpro_icons('tw-footer'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($insta)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($insta); ?>" target="_blank">
                                                    <?php echo listingpro_icons('instagram'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($fyout)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($fyout); ?>" target="_blank">
                                                    <?php echo listingpro_icons('ytwite'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($flinked)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($flinked); ?>" target="_blank">
                                                    <?php echo listingpro_icons('linkedin'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($fpintereset)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($fpintereset); ?>" target="_blank">
                                                    <?php echo listingpro_icons('pinterest'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($tumb)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($tumb); ?>" target="_blank">
                                                    <?php echo listingpro_icons('tumbler'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if(!empty($fvk)){ ?>
                                            <li>
                                                <a href="<?php echo esc_url($fvk); ?>" target="_blank">
                                                    <?php echo listingpro_icons('vk'); ?>
                                                </a>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div><!-- ../footer-bottom-bar -->

            </footer>
        <?php } elseif( $footer_style == 'footer2'){ ?>
            <div class="clearfix"></div>
            <footer class="footer-style2 padding-top-60 padding-bottom-60">

                <?php if(is_active_sidebar('footer-sidebar')) { ?>
                    <div class="container clearfix">
                        <?php
                        dynamic_sidebar("footer-sidebar");
                        ?>
                    </div>
                <?php } ?>

            </footer>

        <?php } ?>

        <!-- End Main -->
        </div>
    <?php }else{
        if(!is_tax('location') && is_tax('listing-category') && is_tax('list-tags') && is_tax('features') && is_search()){
            ?>
            <div class="footer-bottom-bar">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="footer-about-company">

                                <?php

                                if( $copy_right ){
                                    echo '<li>'.$copy_right.'</li>';
                                }

                                ?>

                                <?php

                                if( $footer_address ){
                                    echo '<li>'.$footer_address.'</li>';
                                }

                                ?>

                                <?php

                                if( $phone_number ){
                                    echo '<li>'.esc_html__('Tel', 'listingpro').' '.$phone_number.'</li>';
                                }

                                ?>

                            </ul>

                            <?php

                            if( $author_info ){
                                echo '<p class="credit-links">'.$author_info.'</p>';
                            }

                            ?>
                            <?php if(!empty($tw) || !empty($gog) || !empty($fb) || !empty($insta) || !empty($tumb) || !empty($fpintereset) || !empty($flinked) || !empty($fyout) || !empty($fvk)){ ?>
                                <ul class="social-icons footer-social-icons">
                                    <?php if(!empty($fb)){ ?>
                                        <li>
                                            <a href="<?php echo esc_url($fb); ?>" target="_blank">
                                                <?php echo listingpro_icons('facebook'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if(!empty($gog)){ ?>
                                        <li>
                                            <a href="<?php echo esc_url($gog); ?>" target="_blank">
                                                <?php echo listingpro_icons('google'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if(!empty($tw)){ ?>
                                        <li>
                                            <a href="<?php echo esc_url($tw); ?>" target="_blank">
                                                <?php echo listingpro_icons('tw-footer'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if(!empty($insta)){ ?>
                                        <li>
                                            <a href="<?php echo esc_url($insta); ?>" target="_blank">
                                                <?php echo listingpro_icons('instagram'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if(!empty($fyout)){ ?>
                                        <li>
                                            <a href="<?php echo esc_url($fyout); ?>" target="_blank">
                                                <?php echo listingpro_icons('ytwite'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if(!empty($flinked)){ ?>
                                        <li>
                                            <a href="<?php echo esc_url($flinked); ?>" target="_blank">
                                                <?php echo listingpro_icons('linkedin'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if(!empty($fpintereset)){ ?>
                                        <li>
                                            <a href="<?php echo esc_url($fpintereset); ?>" target="_blank">
                                                <?php echo listingpro_icons('pinterest'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if(!empty($tumb)){ ?>
                                        <li>
                                            <a href="<?php echo esc_url($tumb); ?>" target="_blank">
                                                <?php echo listingpro_icons('tumbler'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if(!empty($fvk)){ ?>
                                        <li>
                                            <a href="<?php echo esc_url($fvk); ?>" target="_blank">
                                                <?php echo listingpro_icons('vk'); ?>
                                            </a>
                                        </li>
                                    <?php } ?>

                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div><!-- ../footer-bottom-bar -->
            <?php
        }
        ?>

        <?php
    }
}?>


<?php wp_footer(); ?>

</body>
</html>