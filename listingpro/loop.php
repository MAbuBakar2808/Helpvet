	<?php 
	/* The loop starts here. */
	$postGridCount = 0;
    global $listingpro_options;
    $blog_view      =   $listingpro_options['blog_view'];
    $blog_grid_view      =   $listingpro_options['blog_grid_view'];
    $blog_view_class    =   '6';
    if( $blog_view == 'list_view' )
    {
        $blog_view_class    =   '12';
    }
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post(); 
			$postGridCount++;
			
			$author_avatar_url = get_user_meta(get_the_author_meta( 'ID' ), "listingpro_author_img_url", true); 
			$avatar ='';
			if(!empty($author_avatar_url)) {
				$avatar =  $author_avatar_url;

			} else { 			
				$avatar_url = listingpro_get_avatar_url (get_the_author_meta( 'ID' ), $size = '51' );
				$avatar =  $avatar_url;

			}					
			?>
			<?php if($blog_grid_view == 'grid_view_style1'){?>
			<div class="col-md-<?php echo $blog_view_class; ?> col-sm-<?php echo $blog_view_class; ?> lp-border-radius-8" id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
				<div class="lp-blog-grid-box">
					<div class="lp-blog-grid-box-container lp-border lp-border-radius-8">
						<div class="lp-blog-grid-box-thumb">
							<a href="<?php the_permalink(); ?>">
								<?php

									if ( has_post_thumbnail() ) {
										if( $blog_view == 'list_view' )
										{
											the_post_thumbnail('full');
										}
										else
										{
											the_post_thumbnail('full');
										}
									}
									else {
										if( $blog_view == 'list_view' )
										{
											echo '<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=1170&h=440', 'listingpro').'" alt="">';
										}
										else
										{
											echo '<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=600&h=240', 'listingpro').'" alt="">';
										}

									}
								?>
							</a>
						</div>
						<div class="lp-blog-grid-box-description text-center">
								<div class="lp-blog-user-thumb margin-top-subtract-25">
									<img class="avatar" src="<?php echo esc_url($avatar); ?>" alt="">
								</div>
								
								<div class="lp-blog-grid-category">
									<a href="blog-archive.html" >
										<?php the_category(' ,'); ?>
									</a>
								</div>
								<div class="lp-blog-grid-title">
									<h4 class="lp-h4">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h4>
								</div>
								<ul class="lp-blog-grid-author">
									<li>
									
										<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
											<i class="fa fa-user"></i>
											<span><?php the_author(); ?></span>
										</a>
									</li>
									<li>
										<i class="fa fa-calendar"></i>
										<span><?php the_date(get_option('date_format')); ?></span>
									</li>
								</ul><!-- ../lp-blog-grid-author -->
						</div>
					</div>
				</div>
			</div>
			<?php }else{ ?>
				<div class="col-md-<?php echo $blog_view_class; ?> col-sm-<?php echo $blog_view_class; ?>" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class=" lp-blog-grid-box">
						
							<div class="lp-blog-grid-box-container lp-blog-grid-box-container-style2 lp-border-radius-8">
								<div class="lp-blog-grid-box-thumb">
										<a href="<?php the_permalink(); ?>">
											<?php

												if ( has_post_thumbnail() ) {
													if( $blog_view == 'list_view' )
													{
														the_post_thumbnail('full');
													}
													else
													{
														the_post_thumbnail('full');
													}
												}
												else {
													if( $blog_view == 'list_view' )
													{
														echo '<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=1170&h=440', 'listingpro').'" alt="">';
													}
													else
													{
														echo '<img src="'.esc_html__('https://placeholdit.imgix.net/~text?txtsize=33&w=600&h=240', 'listingpro').'" alt="">';
													}

												}
											?>
										</a>
									
								</div>
								<div class="lp-blog-grid-box-description  lp-border lp-blog-grid-box-description2">
										<div class="lp-blog-user-thumb margin-top-subtract-25">
											<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><img class="avatar" src="<?php echo esc_url($avatar);?>" alt=""></a>
										</div>
										
										<div class="lp-blog-grid-title">
											<h4 class="lp-h4">
												<a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a>
											</h4>
											<p><?php echo substr(strip_tags(get_the_content()),0,95);?>..</p>
										</div>
										<ul class="lp-blog-grid-author lp-blog-grid-author2">
											<li>
												<i class="fa fa-folder-open-o" aria-hidden="true"></i>
												<span><?php the_category(', '); ?></span>
											</li>
											<li>
												<i class="fa fa-calendar"></i>
												<span><?php echo get_the_date(get_option('date_format'));?></span>
											</li>
										</ul><!-- ../lp-blog-grid-author -->
										<div class="blog-read-more">
												<a href="<?php echo get_the_permalink();?>" class="blog-detail-link"><?php echo esc_html__('Read More', 'listingpro');?></a>
										</div>
								</div>
							</div>
						
					</div>
				</div>
				
				
			<?php } ?>
		
    
			<?php 
			if( $blog_view == 'list_view' ){
				if($postGridCount%3 == 0){
					echo '<div class="clearfix"></div>';
				}
			}else{
				if($postGridCount%2 == 0){
					echo '<div class="clearfix"></div>';
				}
				
			}	
		} // end while
		echo listingpro_pagination();
	}else{
		?>
		<div class="text-center margin-top-80 margin-bottom-100">
			<h2><?php esc_html_e('No Results','listingpro'); ?></h2>
			<p><?php esc_html_e('Sorry! There are no posts matching your search.','listingpro'); ?></p>
			<p><?php esc_html_e('Try changing your search Keyword','listingpro'); ?>				
			</p>
		</div>		
		<?php
	} // end if
	
	
				