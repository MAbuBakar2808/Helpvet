/* Main.js contains all main JS  */
/*  Author : CrdioStudio Dev team */

/*moin 31-03-017 strt*/
jQuery.noConflict();


jQuery(window).on('resize load live', function (){
	jQuery(window).resize( function () {
		
		if (jQuery(window).width() <= 768) {
			jQuery('a.open-map-view').on('click', function(event) {
				event.preventDefault();
				jQuery('.sidemap-container').addClass('open-map');
				jQuery('header').addClass('map-view-content');
			});
			

			jQuery('a.open-img-view').on('click', function(event) {
				event.preventDefault();
				jQuery('.sidemap-container').removeClass('open-map');
				jQuery('header').removeClass('map-view-content');
			});
			
			if(jQuery('#wpadminbar').length > 0) {
				jQuery('html body').css('margin-top','-46px');
			}
		} else {
			jQuery('.sidemap-container').removeClass('open-map');
			if(jQuery('#wpadminbar').length > 0) {
				jQuery('html body').css('margin-top','0px');
			}
		}
		if (jQuery(window).width() <= 480) {
			jQuery('#more_filters').hide();
		} else {
			jQuery('#more_filters').show();
		}

	});
});
jQuery(document).ready(function() {


	// Search Top margin in map view
	var hh = jQuery('header').outerHeight();
	var ab = jQuery('.absolute');
	ab.css('top', hh);
	
	
	// Touch Behaviorr for Mobile devices
	if (jQuery('.chosen-container').length > 0) {
	  	jQuery('.chosen-container').on('touchstart', function(e) {
			e.stopPropagation(); e.preventDefault();
			// Trigger the mousedown event.
			jQuery(this).trigger('mousedown');
	  	});
	}
	
	jQuery('#see_filter').on('click', function(event) {
		event.preventDefault();
		var filter = jQuery('#more_filters');
		jQuery(this).next('#more_filters').toggleClass('open_filter');
		if(filter.hasClass('open_filter')) {
			jQuery(this).next('#more_filters').slideDown(400);
		}else {
			jQuery(this).next('#more_filters').slideUp(400);
		};
	});
});
/*moin 31-03-017 ends*/

/* by zaheer on 30 march */
jQuery(document).ready(function($){
	var loc = jQuery('.ui-widget').data('option');
	var apiType = jQuery('#page').data('ipapi');

	if (loc == 'yes') {
		if( jQuery('.form-group').is('.lp-location-search') || jQuery('.form-group').is('.lp-location-inner-search') ){
			if(apiType==="geo_ip_db"){
				jQuery.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?') 
				 .done (function(location)
				{
					
					//jQuery('.lp-home-sear-location').val(location.city);
					//jQuery(".chosen-select").val('').trigger('chosen:updated');
					jQuery("#searchlocation").prop('disabled', true).trigger('chosen:updated');
					jQuery('#searchlocation').find('#def_location').text(location.city);
					jQuery('#searchlocation').find('#def_location').val(location.city);
					jQuery('#cities').val(location.city);
					jQuery('input[name=lp_s_loc]').val(location.city);
					jQuery(".select2-selection__rendered").attr("title",location.city).text(location.city);
					jQuery("#searchlocation").prop('disabled', false).trigger('chosen:updated');
					jQuery('.select2-selection__rendered').parent('.select2-selection').addClass('slide-right');
					jQuery('.lp-location-search .ui-widget > i').fadeOut('slow');
				});
			}
			else{
				jQuery.get("https://ipapi.co/json", function(location) {
					
					jQuery("#searchlocation").prop('disabled', true).trigger('chosen:updated');
					jQuery('#searchlocation').find('#def_location').text(location.city);
					jQuery('#searchlocation').find('#def_location').val(location.city);
					jQuery('#cities').val(location.city);
					jQuery('input[name=lp_s_loc]').val(location.city);
					jQuery(".select2-selection__rendered").attr("title",location.city).text(location.city);
					jQuery("#searchlocation").prop('disabled', false).trigger('chosen:updated');
					jQuery('.select2-selection__rendered').parent('.select2-selection').addClass('slide-right');
					jQuery('.lp-location-search .ui-widget > i').fadeOut('slow');
				}, "json");
			}
			
		}
	}else if (loc == 'no') {
		jQuery('.lp-location-search .ui-widget > i').on('click', function(event) {
			event.preventDefault();
			jQuery(this).addClass('fa-circle-o-notch fa-spin');
			jQuery(this).removeClass('fa-crosshairs');
			if(jQuery('.form-group').is('.lp-location-search')){
				if(apiType==="geo_ip_db"){
					jQuery.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?') 
					 .done (function(location)
					{
						//jQuery('.lp-home-sear-location').val(location.city);
						//jQuery(".chosen-select").val('').trigger('chosen:updated');
						jQuery('.chosen-single').addClass('remove-margin');
						jQuery("#searchlocation").prop('disabled', true).trigger('chosen:updated');
						
						if(location.city==null){
						}
						else{
							jQuery('#searchlocation').find('#def_location').text(location.city);
							jQuery('#searchlocation').find('#def_location').val(location.city);
							jQuery('#cities').val(location.city);
							jQuery('input[name=lp_s_loc]').val(location.city);
							jQuery(".select2-selection__rendered").attr("title",location.city).text(location.city);
						}
						jQuery("#searchlocation").prop('disabled', false).trigger('chosen:updated');
						jQuery('.select2-selection__rendered').parent('.select2-selection').addClass('slide-right');
						jQuery('.lp-location-search .ui-widget > i').fadeOut('slow');
					});
				}
				else{
					jQuery.get("https://ipapi.co/json", function(location) {
						
						jQuery('.chosen-single').addClass('remove-margin');
						jQuery("#searchlocation").prop('disabled', true).trigger('chosen:updated');
						
						if(location.city==null){
						}
						else{
							jQuery('#searchlocation').find('#def_location').text(location.city);
							jQuery('#searchlocation').find('#def_location').val(location.city);
							jQuery('#cities').val(location.city);
							jQuery('input[name=lp_s_loc]').val(location.city);
						}
						
						jQuery(".select2-selection__rendered").attr("title",location.city).text(location.city);
						jQuery("#searchlocation").prop('disabled', false).trigger('chosen:updated');
						jQuery('.select2-selection__rendered').parent('.select2-selection').addClass('slide-right');
						jQuery('.lp-location-search .ui-widget > i').fadeOut('slow');
						
					}, "json");
				}
			}
		});
	}
	
	
	
	jQuery('#ads_promotion').on('submit', function(e){
		var $this = jQuery(this);
		totalPrice = $this.find('input[name="total"]').val(); 
		method = $this.find('input[name="method"]:checked').val();
		currency = $this.find('input[name="currency"]').val();
		listing_id = jQuery('input[name=listing_id]').val();
		listing_name = jQuery('input[name=cur_listing_title]').val();
		if (listing_id==='' || !jQuery('input[name="method"]').is(":checked") ) {
			alert(jQuery('input#ad-blank-errorMsg').val());
			e.preventDefault();
		}
		else if(method==='stripe'){
			
				//totalPrice = parseFloat(totalPrice)*100;
				totalPrice = jQuery('input[name="lp_total_price"]').val();
				totalPrice = parseFloat(totalPrice)*100;
			
			
			handler.open({
			name: listing_name,
			description: "",
			zipCode: true,
			amount: totalPrice,
			currency: currency
		  });
			e.preventDefault();
		}
		else if(method==='2checkout'){
			var packages = [];
			jQuery('input.checked_class[type="checkbox"]:checked').each(function () {
				 packages.push($this.data('package'));
			 });
			jQuery('#myCCForm #tprice').val(totalPrice);
			jQuery('#myCCForm #listing_id').val(listing_id);
			jQuery('#myCCForm #packages').val(packages);
			jQuery('#myCCForm #taxprice').val($this.find('input[name="taxprice"]').val());
			jQuery("button.lp-2checkout-modal2").trigger('click');
			e.preventDefault();
		}
		
	});
});
/* end by zaheer on 30 march */

jQuery(window).load(function() {
	
	
	jQuery('.lp-suggested-search').on('click', function(event) {

		jQuery("#input-dropdown").niceScroll({
			cursorcolor:"#363F48",
			cursoropacitymax: 1,
			boxzoom:false,
			cursorwidth: "10px",
			cursorborderradius: "0px",
			cursorborder: "0px solid #fff",
			touchbehavior:true,
			preventmultitouchscrolling: false,
			cursordragontouch: true,	
			background: "#f7f7f7",
			horizrailenabled: false,
			autohidemode: false,
			zindex : "999999",
		});

	});
	
	
	// Notices Box Script
	jQuery('.notice a.close').on('click', function(event) {
		event.preventDefault();
		jQuery(this).parent('.notice').fadeOut('slow');
	});

	jQuery('.lp-header-full-width .lp-menu-bar .header-filter, .lp-menu-bar .header-filter.pos-relative.form-group').css('display', 'block');

	var logoH = jQuery('.lp-logo').outerHeight();
	var acHgt = jQuery('.header-right-panel.clearfix');
	var a = parseInt(logoH + 10);
	var b = jQuery('.header-right-panel').height();
	var c = a - b;
	var d = c/2;
	//alert(b);
	acHgt.css({ 'padding-top': d+'px' });

	jQuery('.rating-symbol:nth-child(1)').hover(function() {
		jQuery('.review.angry').css({
			'opacity': '1',
			'visibility': 'visible',
		});
	}, function() {
		jQuery('.review.angry').css({
			'opacity': '0',
			'visibility': 'hidden',
		});
	});
	jQuery('.rating-symbol:nth-child(2)').hover(function() {
		jQuery('.review.cry').css({
			'opacity': '1',
			'visibility': 'visible',
		});
	}, function() {
		jQuery('.review.cry').css({
			'opacity': '0',
			'visibility': 'hidden',
		});
	});
	jQuery('.rating-symbol:nth-child(3)').hover(function() {
		jQuery('.review.sleeping').css({
			'opacity': '1',
			'visibility': 'visible',
		});
	}, function() {
		jQuery('.review.sleeping').css({
			'opacity': '0',
			'visibility': 'hidden',
		});
	});
	jQuery('.rating-symbol:nth-child(4)').hover(function() {
		jQuery('.review.smily').css({
			'opacity': '1',
			'visibility': 'visible',
		});
	}, function() {
		jQuery('.review.smily').css({
			'opacity': '0',
			'visibility': 'hidden',
		});
	});
	jQuery('.rating-symbol:nth-child(5)').hover(function() {
		jQuery('.review.cool').css({
			'opacity': '1',
			'visibility': 'visible',
		});
	}, function() {
		jQuery('.review.cool').css({
			'opacity': '0',
			'visibility': 'hidden',
		});
	});
	
	

	var rtngSym = jQuery('.rating-symbol');
	var rtngTip = jQuery('input.rating-tooltip');
	

	jQuery('.rating-symbol:first-of-type').hover(function() {
		jQuery('.rating-symbol:first-of-type .rating-symbol-foreground span').css('color', '#de9147');
	}, function() { });
	jQuery('.rating-symbol:nth-of-type(2)').hover(function() {
		jQuery('.rating-symbol:first-of-type .rating-symbol-foreground span').css('color', '#de9147');
		jQuery('.rating-symbol:nth-of-type(2) .rating-symbol-foreground span').css('color', '#de9147');
	}, function() { });
	jQuery('.rating-symbol:nth-of-type(3)').hover(function() {
		jQuery('.rating-symbol:first-of-type .rating-symbol-foreground span').css('color', '#dec435');
		jQuery('.rating-symbol:nth-of-type(2) .rating-symbol-foreground span').css('color', '#dec435');
		jQuery('.rating-symbol:nth-of-type(3) .rating-symbol-foreground span').css('color', '#dec435');
	}, function() { });
	jQuery('.rating-symbol:nth-of-type(4)').hover(function() {
		jQuery('.rating-symbol:first-of-type .rating-symbol-foreground span').css('color', '#c5de35');
		jQuery('.rating-symbol:nth-of-type(2) .rating-symbol-foreground span').css('color', '#c5de35');
		jQuery('.rating-symbol:nth-of-type(3) .rating-symbol-foreground span').css('color', '#c5de35');
		jQuery('.rating-symbol:nth-of-type(4) .rating-symbol-foreground span').css('color', '#c5de35');
	}, function() { });
	jQuery('.rating-symbol:nth-of-type(5)').hover(function() {
		jQuery('.rating-symbol:first-of-type .rating-symbol-foreground span').css('color', '#73cf42');
		jQuery('.rating-symbol:nth-of-type(2) .rating-symbol-foreground span').css('color', '#73cf42');
		jQuery('.rating-symbol:nth-of-type(3) .rating-symbol-foreground span').css('color', '#73cf42');
		jQuery('.rating-symbol:nth-of-type(4) .rating-symbol-foreground span').css('color', '#73cf42');
		jQuery('.rating-symbol:nth-of-type(5) .rating-symbol-foreground span').css('color', '#73cf42');
	}, function() { });
	rtngSym.on('click', function(event) {
		event.preventDefault();
		var thsVal 	= jQuery('input.rating-tooltip').val();

		//alert(thsVal);
		if (thsVal == 1) {
			jQuery('.review.angry').addClass('visible');
			jQuery('.rating-symbol:first-of-type').addClass('angry');
			jQuery('.rating-symbol').removeClass('cry');
			jQuery('.rating-symbol').removeClass('sleeping');
			jQuery('.rating-symbol').removeClass('smily');
			jQuery('.rating-symbol').removeClass('cool');
		}else{
			jQuery('.review.angry').removeClass('visible');
		};

		if (thsVal == 2) {
			jQuery('.review.cry').addClass('visible');
			jQuery('.rating-symbol:first-of-type').addClass('cry');
			jQuery('.rating-symbol:nth-of-type(2)').addClass('cry');
			jQuery('.rating-symbol').removeClass('angry');
			jQuery('.rating-symbol').removeClass('sleeping');
			jQuery('.rating-symbol').removeClass('smily');
			jQuery('.rating-symbol').removeClass('cool');
		}else{
			jQuery('.review.cry').removeClass('visible');
		};

		if (thsVal == 3) {
			jQuery('.review.sleeping').addClass('visible');
			jQuery('.rating-symbol:first-of-type').addClass('sleeping');
			jQuery('.rating-symbol:nth-of-type(2)').addClass('sleeping');
			jQuery('.rating-symbol:nth-of-type(3)').addClass('sleeping');
			jQuery('.rating-symbol').removeClass('angry');
			jQuery('.rating-symbol').removeClass('cry');
			jQuery('.rating-symbol').removeClass('smily');
			jQuery('.rating-symbol').removeClass('cool');
		}else{
			jQuery('.review.sleeping').removeClass('visible');
		};

		if (thsVal == 4) {
			jQuery('.review.smily').addClass('visible');
			jQuery('.rating-symbol:first-of-type').addClass('smily');
			jQuery('.rating-symbol:nth-of-type(2)').addClass('smily');
			jQuery('.rating-symbol:nth-of-type(3)').addClass('smily');
			jQuery('.rating-symbol:nth-of-type(4)').addClass('smily');
			jQuery('.rating-symbol').removeClass('angry');
			jQuery('.rating-symbol').removeClass('cry');
			jQuery('.rating-symbol').removeClass('sleeping');
			jQuery('.rating-symbol').removeClass('cool');
		}else{
			jQuery('.review.smily').removeClass('visible');
		};

		if (thsVal == 5) {
			jQuery('.review.cool').addClass('visible');
			jQuery('.rating-symbol:first-of-type').addClass('cool');
			jQuery('.rating-symbol:nth-of-type(2)').addClass('cool');
			jQuery('.rating-symbol:nth-of-type(3)').addClass('cool');
			jQuery('.rating-symbol:nth-of-type(4)').addClass('cool');
			jQuery('.rating-symbol:nth-of-type(5)').addClass('cool');
			jQuery('.rating-symbol').removeClass('angry');
			jQuery('.rating-symbol').removeClass('cry');
			jQuery('.rating-symbol').removeClass('sleeping');
			jQuery('.rating-symbol').removeClass('smily');
		}else{
			jQuery('.review.cool').removeClass('visible');
		};

	});
});

		
jQuery(document).ready(function(){
	'use-strict';

	// Disable next button
	var checkdInput = jQuery('.checkboxx input.checked_class');
	checkdInput.on('change', function(event) {
		event.preventDefault();
		if (checkdInput.is(':checked')) {
			jQuery('a#lp-next').css('display', 'block');
			jQuery('a#lp-next').removeClass('hide');
			jQuery('span.show').removeClass('show');
			jQuery('.promotional-section > .lp-face.lp-pay-options.lp-dash-sec > span').addClass('hide');
		}else {
			jQuery('a#lp-next').addClass('hide');
			jQuery('.promotional-section > .lp-face.lp-pay-options.lp-dash-sec > span').addClass('show');
		};
	});

	var rdoInput = jQuery('.lp-method-wrap input.radio_checked');
	rdoInput.on('change', function(event) {
		event.preventDefault();
		if (rdoInput.is(':checked')) {
			jQuery('input.lp-next2.promotebtn').css('display', 'block');
			jQuery('input.lp-next2.promotebtn').removeClass('hide');
			jQuery('.promotional-section span.proceed-btn').removeClass('show');
			jQuery('.promotional-section span.proceed-btn').addClass('hide');
		}else {
			jQuery('input.lp-next2.promotebtn').addClass('hide');
			jQuery('.promotional-section span.proceed-btn').addClass('show');
		};
		
	});
	
	//Dashboard promotional script
	jQuery('.promotional-section a.lp-submit-btn').on('click', function(event) {
		event.preventDefault();
		jQuery(this).parent('.promotional-section').slideUp(500);
		jQuery(this).parent('.promotional-section').next('.lp-card > form#ads_promotion').slideDown(1000);
	});

	// Dashboard Left Panel Script
	
	var dash = jQuery('.dashboard-tabs.lp-main-tabs.text-center > ul > li.dropdown > a');
		
	var dashli = jQuery('.dashboard-tabs.lp-main-tabs.text-center > ul > li.dropdown');
		
	var dashul = jQuery('.dashboard-tabs.lp-main-tabs.text-center > ul > li.dropdown > ul');

		
	dash.on('click', function(event) {
			
	event.preventDefault();
			
	if(dashli.hasClass('opened')) {
		
		jQuery( dashli ).removeClass('opened');
			
		jQuery(dashul).removeClass('opened');
				
		jQuery(this).parent('li').addClass('opened');
				
		jQuery(this).next('ul').addClass('opened');
			
	} else {

		//if(dashli.hasClass('dropdown'))
		
		jQuery(dashul).removeClass('opened');
			
		jQuery( dashli ).removeClass('opened');
			
		jQuery(this).parent('li').addClass('opened');
			
		jQuery(this).next('ul').addClass('opened');

		
		};
		
	});

	
	// Review Script
	jQuery('h3#reply-title').on('click', function(event) {
		event.preventDefault();
		var thiss = jQuery(this);
		if (thiss.hasClass('active')) {
			jQuery(this).removeClass('active');
			jQuery(this).next('#rewies_form').slideUp();
			jQuery(this).next('#rewies_formm').slideUp();
		}else{
			jQuery(this).addClass('active');
			jQuery(this).next('#rewies_form').slideDown();
			jQuery(this).next('#rewies_formm').slideDown();
		};
		//jQuery(this).next('#rewies_form').toggleClass('open_review_form');
	});
	jQuery('#clicktoreview').on('click', function(event) {
		event.preventDefault();
		
		var thiss = jQuery('#reply-title');
			thiss.addClass('active');
			thiss.next('#rewies_form').slideDown();	
			thiss.next('#rewies_formm').slideDown();	
			jQuery('html, body').animate({
                scrollTop: jQuery('#reply-title').offset().top
            }, 2000);
	});
	
	jQuery('.leadformtrigger').on('click', function(e){
            e.preventDefault();
            jQuery('.app-view-lead-form').slideToggle(500);

    });
    jQuery('.open-lead-form-app-view').on('click', function(e){
        jQuery('.app-view-lead-form').slideToggle(500);
        jQuery('html, body').animate({
            scrollTop: jQuery('.leadformtrigger').offset().top
        }, 2000);

    })
	
	jQuery('#rewies_form input[type=file]').change(function(e) {
		$in = jQuery(this);
		$in.prev().prev().text($in.val());
		
	});
		// listing layout
	//jQuery('.listing-simple').addClass('listing_list_view');
	jQuery('a.grid').on('click', function(event) {
		event.preventDefault();
		jQuery('a.list').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.listing-simple').removeClass('listing_list_view');
		
		// Listing with Map
		jQuery('.post-with-map-container').find('.lp-grid-box-contianer.card1.lp-grid-box-contianer1').removeClass('col-sm-12 list_view');
		jQuery('.post-with-map-container').find('.lp-grid-box-contianer.card1.lp-grid-box-contianer1').addClass('col-md-6 col-sm-12 grid_view2');
		
		// Listing Simple
		jQuery('.listing-simple').find('.lp-grid-box-contianer.card1.lp-grid-box-contianer1').removeClass('col-sm-12 list_view');
		jQuery('.listing-simple').find('.lp-grid-box-contianer.card1.lp-grid-box-contianer1').addClass('col-md-4 col-sm-12 grid_view2');
	});
	jQuery('a.list').on('click', function(event) {
		event.preventDefault();
		jQuery('a.grid').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.listing-simple').addClass('listing_list_view');
		
		// Listing with Map
		jQuery('.post-with-map-container').find('.lp-grid-box-contianer.card1.lp-grid-box-contianer1').removeClass('col-md-6 col-sm-6 grid_view2');
		jQuery('.post-with-map-container').find('.lp-grid-box-contianer.card1.lp-grid-box-contianer1').addClass('col-sm-12 list_view');
		
		// Listing Simple
		jQuery('.listing-simple').find('.lp-grid-box-contianer.card1.lp-grid-box-contianer1').removeClass('col-md-4 col-sm-6 grid_view2');
		jQuery('.listing-simple').find('.lp-grid-box-contianer.card1.lp-grid-box-contianer1').addClass('col-sm-12 list_view');
	});

//============================================ Harry Code ==================================================//
	// Open Hours Script
	jQuery('a.show-all-timings').on('click', function(event) {
		event.preventDefault();
		jQuery(this).toggleClass('opened');
		jQuery(this).next('ul.hidding-timings').slideToggle(400);
	});
	
	// shebi Script
	jQuery( ".detail-page2-tab-content .review-form h3" ).removeAttr( "id" );
	
	jQuery('.listing-app-view .listing-app-view-bar .pricy-form-group #lp-find-near-me-outer ul > li > a').click(function() {
		jQuery(this).toggleClass('margin-right-0 lp-remove-border');
	});
	
	
	
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});

		// Firefox bug fix
		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
	});

/* from sheibi */
	
if(jQuery('body').hasClass('home') || jQuery('body').hasClass('app-view-home')){
   jQuery('.listing-app-view.home .map-view-list-container2,.listing-app-view.app-view-home .map-view-list-container2').slick({
    centerMode: false,
    centerPadding: '0px',
    infinite: true,
    accesibility: false,
    draggable: true,
    swipe: true,
    touchMove: false,
    autoplaySpeed: 1400,
    speed: 100,
    slidesToShow: 2,
    dots: true, 
    arrows: false
  });
   
    jQuery('.listing-app-view.home .lp-location-slider,.listing-app-view.app-view-home .lp-location-slider').slick({
    centerMode: false,
    centerPadding: '0px',
    infinite: true,
    accesibility: false,
    draggable: true,
    swipe: true,
    touchMove: false,
    autoplaySpeed: 1400,
    speed: 100,
    slidesToShow: 3,
    dots: true,  
    arrows: false
  }); 
  }
  
 jQuery('#map-view-icon2').click(function () {
   jQuery("#search-filter-attr-filter").animate({width: "toggle"}, 5);
 });
  jQuery("#app-view-login-popup .signUpClick").on('click' , function() {
	  jQuery('.signInClick').removeClass('active');
	  jQuery('.siginincontainer2').hide();
	  jQuery('.forgetpasswordcontainer2').hide();
	  jQuery('.siginupcontainer2').fadeIn();
	  jQuery(this).addClass('active');
  });
 jQuery("#app-view-login-popup .signInClick").on('click' , function() {
	  jQuery('.signUpClick').removeClass('active');
	  jQuery(this).addClass('active');
	  jQuery('.forgetpasswordcontainer2').hide();
	  jQuery('.siginupcontainer2').hide();
	  jQuery('.siginincontainer2').fadeIn();
  });
 jQuery("#app-view-login-popup .forgetPasswordClick").on('click' , function() { 
  jQuery('.siginupcontainer2').hide();
  jQuery('.siginincontainer2').hide(); 
  jQuery('.forgetpasswordcontainer2').fadeIn();

  });
 jQuery("#app-view-login-popup .cancelClick").on('click' , function() { 
  jQuery('.siginupcontainer2').hide();
  jQuery('.forgetpasswordcontainer2').hide();
  jQuery('.siginincontainer2').fadeIn(); 

  });
   jQuery('.listing-app-view .lp-search-toggle .user-menu').click(function(e){
           
    jQuery(".lp-user-menu").toggleClass("main");
    
  });
  
jQuery(document).mouseup(function(e){
	var container = jQuery(".lp-user-menu");
	if (!container.is(e.target) && container.has(e.target).length === 0){
		jQuery('.lp-user-menu').removeClass('main');
	}
});
 jQuery('.lp-detail-page-template-3 #clicktoreview2').on('click', function(event) {
  event.preventDefault(); 
   jQuery(".single-tabber2 ul li").removeClass('active');
   jQuery(".detail-page2-tab-content .tab-content .tab-pane").removeClass('active');
    jQuery('.single-tabber2 ul .lpreviews').addClass('active');
    jQuery('.detail-page2-tab-content .tab-content .lpreviews').addClass('active');
    
  
 });
	// end shoaib Script
	
	jQuery('[data-toggle="tooltip"]').tooltip();

	// Open review reply
	jQuery('a.see_more_btn').on('click', function(event) {
		event.preventDefault();
		var $this = jQuery(this);
		if($this.hasClass('closedd')){
			$this.removeClass('closedd');
			$this.addClass('openedd');
			jQuery(this).find('i').removeClass('fa-arrow-down');
			jQuery(this).find('i').addClass('fa-arrow-up');
			
		}
		else{
			$this.removeClass('openedd');
			$this.addClass('closedd');
			jQuery(this).find('i').removeClass('fa-arrow-up');
			jQuery(this).find('i').addClass('fa-arrow-down');
			
		}
		jQuery(this).next('.review-content').slideToggle(200);		
	});
	
	
	jQuery('a.open-reply').on('click', function(event) {
		event.preventDefault();
		var $this = jQuery(this);
		if($this.hasClass('closeddd')){
			$this.removeClass('closeddd');
			$this.addClass('openeddd');
			jQuery(this).find('i').removeClass('fa-arrow-down');
			jQuery(this).find('i').addClass('fa-arrow-up');
			
		}
		else{
			$this.removeClass('openeddd');
			$this.addClass('closeddd');
			jQuery(this).find('i').removeClass('fa-arrow-up');
			jQuery(this).find('i').addClass('fa-arrow-down');
			
		}
		jQuery(this).next('.post_response').slideToggle(200);		
	});
	
	// Add hours
	jQuery('button.add-hours').on('click', function(event) {
		event.preventDefault();
		var $this = jQuery(this);
		var lp2times = $this.closest('#day-hours-BusinessHours').data('lpenabletwotimes');
		var error = false;
		var fullday = '';
		var fullhoursclass = '';
		
		var lpdash = "-";
		
		if(lp2times=="disable"){
		
			var weekday = jQuery('select.weekday').val();
			if(jQuery(".fulldayopen").is(":checked")){
				jQuery('.fulldayopen').attr('checked', false);
				jQuery('select.hours-start').prop("disabled", false);
				jQuery('select.hours-end').prop("disabled", false);
				var startVal ='';
				var endVal ='';
				var hrstart ='';
				var hrend ='';
				fullday = $this.data('fullday');
				fullhoursclass = 'fullhours';
				lpdash = "";
			}
			else{
				var startVal = jQuery('select.hours-start').val();
				var endVal = jQuery('select.hours-end').val();
				var hrstart = jQuery('select.hours-start').find('option:selected').text();
				var hrend = jQuery('select.hours-end').find('option:selected').text();
				
				var startVal_digit = hrstart.replace(':', '');
				var endVal_digit = hrend.replace(':', '');
				
				if(startVal_digit > endVal_digit){
					nextWeekday = jQuery("select.weekday option:selected+option").val();
					if(typeof nextWeekday === "undefined"){
						nextWeekday = jQuery("select.weekday").find("option:first-child").val();
					}
					
					weekday = weekday+"-"+nextWeekday;
				}
				
				
			}
			
			
			var sorryMsg = jQuery(this).data('sorrymsg');
			var alreadyadded = jQuery(this).data('alreadyadded');
			var remove = jQuery(this).data('remove');
			jQuery('.hours-display .hours').each(function(index, element) { 
				var weekdayTExt = jQuery(element).children('.weekday').text();
				if(weekdayTExt == weekday){
					alert(sorryMsg+'! '+weekday+' '+alreadyadded);
					error = true;
				}
			});
			if(error != true){
				jQuery('.hours-display').append("<div class='hours "+fullhoursclass+"'><span class='weekday'>"+ weekday +"</span><span class='start-end fullday'>"+fullday+"</span><span class='start'>"+ hrstart +"</span><span>"+lpdash+"</span><span class='end'>"+ hrend +"</span><a class='remove-hours' href='#'>"+remove+"</a><input name='business_hours["+weekday+"][open]' value='"+startVal+"' type='hidden'><input name='business_hours["+weekday+"][close]' value='"+endVal+"' type='hidden'></div>");
				var current = jQuery('select.weekday').find('option:selected');
				var nextval = current.next();
				current.removeAttr('selected');
				nextval.attr('selected','selected');
				jQuery('select.weekday').trigger('change.select2');
			}
		}
		else{
			var lptwentlyfourisopen = '';
			/* 2times */
			var weekday = jQuery('select.weekday').val();
			var weekday1 = weekday;
			var weekday2 = weekday;
			if(jQuery(".fulldayopen").is(":checked")){
				
				lptwentlyfourisopen = 'yes';
				
				jQuery('.fulldayopen').attr('checked', false);
				jQuery('select.hours-start').prop("disabled", false);
				jQuery('select.hours-end').prop("disabled", false);
				
				jQuery('select.hours-start2').prop("disabled", false);
				jQuery('select.hours-end2').prop("disabled", false);
				
				var startVal1 ='';
				var endVal1 ='';
				var hrstart1 ='';
				var hrend1 ='';
				
				var startVal2 ='';
				var endVal2 ='';
				var hrstart2 ='';
				var hrend2 ='';
				
				
				
				fullday = $this.data('fullday');
				fullhoursclass = 'fullhours';
				
				lpdash = "";
			}
			else{
				var startVal1 = jQuery('select.hours-start').val();
				var endVal1 = jQuery('select.hours-end').val();
				var hrstart1 = jQuery('select.hours-start').find('option:selected').text();
				var hrend1 = jQuery('select.hours-end').find('option:selected').text();
				
				var startVal1_digit = hrstart1.replace(':', '');
				var endVal1_digit = hrend1.replace(':', '');
				
				
				
				if(startVal1_digit > endVal1_digit){
					
					nextWeekday = jQuery("select.weekday option:selected+option").val();
					if(typeof nextWeekday === "undefined"){
						nextWeekday = jQuery("select.weekday").find("option:first-child").val();
						
					}
					
					weekday1 = weekday+"-"+nextWeekday;
					
				}
				
				
				var startVal2 = jQuery('select.hours-start2').val();
				var endVal2 = jQuery('select.hours-end2').val();
				var hrstart2 = jQuery('select.hours-start2').find('option:selected').text();
				var hrend2 = jQuery('select.hours-end2').find('option:selected').text();
				
				var startVal2_digit = hrstart2.replace(':', '');
				var endVal2_digit = hrend2.replace(':', '');
				
				if(startVal2_digit > endVal2_digit){
					nextWeekday = jQuery("select.weekday option:selected+option").val();
					if(typeof nextWeekday === "undefined"){
						nextWeekday = jQuery("select.weekday").find("option:first-child").val();
					}
					
					weekday2 = weekday+"-"+nextWeekday;
				}
				
				
			}
			
			var sorryMsg = jQuery(this).data('sorrymsg');
			var alreadyadded = jQuery(this).data('alreadyadded');
			var remove = jQuery(this).data('remove');
			jQuery('.hours-display .hours').each(function(index, element) { 
				var weekdayTExt = jQuery(element).children('.weekday').text();
				if(weekdayTExt == weekday){
					alert(sorryMsg+'! '+weekday+' '+alreadyadded);
					error = true;
				}
			});
			
			if(error != true){
				
				if( (jQuery(".lp-check-doubletime .enable2ndday").is(":checked")) && (lptwentlyfourisopen==="") ){
					
					jQuery('.hours-display').append("<div class='hours "+fullhoursclass+"'><span class='weekday'>"+ weekday +"</span><span class='start-end fullday'>"+fullday+"</span><span class='start'>"+ hrstart1 +"</span><span>"+lpdash+"</span><span class='end'>"+ hrend1 +"</span><a class='remove-hours' href='#'>"+remove+"</a><br><span class='weekday'>&nbsp;</span><span class='start'>"+ hrstart2 +"</span><span>"+lpdash+"</span><span class='end'>"+ hrend2 +"</span><input name='business_hours["+weekday1+"][open][0]' value='"+startVal1+"' type='hidden'><input name='business_hours["+weekday1+"][close][0]' value='"+endVal1+"' type='hidden'><input name='business_hours["+weekday2+"][open][1]' value='"+startVal2+"' type='hidden'><input name='business_hours["+weekday2+"][close][1]' value='"+endVal2+"' type='hidden'></div>");
				}else{
					
					jQuery('.hours-display').append("<div class='hours "+fullhoursclass+"'><span class='weekday'>"+ weekday1 +"</span><span class='start-end fullday'>"+fullday+"</span><span class='start'>"+ hrstart1 +"</span><span>"+lpdash+"</span><span class='end'>"+ hrend1 +"</span><a class='remove-hours' href='#'>"+remove+"</a><input name='business_hours["+weekday1+"][open]' value='"+startVal1+"' type='hidden'><input name='business_hours["+weekday1+"][close]' value='"+endVal1+"' type='hidden'></div>");
				}
				var current = jQuery('select.weekday').find('option:selected');
				var nextval = current.next();
				current.removeAttr('selected');
				nextval.attr('selected','selected');
				jQuery('select.weekday').trigger('change.select2');
			}
			
			/* 2times */
		}
	});
	
	jQuery(document).ready(function(){
		jQuery('select.hours-start2').prop("disabled", true);
		jQuery('select.hours-end2').prop("disabled", true);
		jQuery(".lp-check-doubletime .enable2ndday").change(function() {
			if(this.checked) {
				jQuery('select.hours-start2').prop("disabled", false);
				jQuery('select.hours-end2').prop("disabled", false);
				jQuery('.hours-select.lp-slot2-time').slideToggle(300);
			}
			else{
				jQuery('select.hours-start2').prop("disabled", true);
				jQuery('select.hours-end2').prop("disabled", true);
				jQuery('.hours-select.lp-slot2-time').slideToggle(300);
			}
		});	
	});	
	
	

	// Remove Hours Script
	
	jQuery(document).on('click','a.remove-hours',function(event){
		event.preventDefault();
		jQuery(this).parent('.hours').remove();
	});
	// Toggle Script for Currency area
	jQuery('a.toggle-currencey-area').on('click', function(event) {
		event.preventDefault();
		jQuery(this).next('.currency-area').slideToggle(400);
		jQuery(this).toggleClass('active');
	});
		// Magnific Popup 
	jQuery('.review-img-slider').magnificPopup({
		delegate: 'a',
      	type: 'image',
      	tLoading: 'Loading image #%curr%...',
      	mainClass: 'mfp-img-mobile',
      	gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
      	},
      	image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            titleSrc: function(item) {
          		return item.el.attr('title') + '<small>by Listingpro team</small>';
            }
      	}
			

	});
	
	jQuery(document).ready(function(){
		jQuery(".fulldayopen").change(function() {
			if(this.checked) {
				jQuery('select.hours-start').prop("disabled", true);
				jQuery('select.hours-end').prop("disabled", true);
				jQuery('select.hours-start2').prop("disabled", true);
				jQuery('select.hours-end2').prop("disabled", true);
			}
			else{
				jQuery('select.hours-start').prop("disabled", false);
				jQuery('select.hours-end').prop("disabled", false);
				jQuery('select.hours-start2').prop("disabled", false);
				jQuery('select.hours-end2').prop("disabled", false);
			}
		});	
	});
	
	jQuery(document).ready(function() {
		jQuery(".add-more").click(function() {
			jQuery("#lp_feature_panel").slideToggle("slow");
		});
		
		jQuery('#listings_checkout').on('submit', function(e){
			var $this = jQuery(this);
			method = $this.find('input[name="plan"]:checked').val();
			listing_id = $this.find('input[name="listing_id"]:checked').val();
			post_title = $this.find('input[name="listing_id"]:checked').data('title');
			errormsg = jQuery('input[name="errormsg"]').val();
			recurring = $this.data('recurring');
			if(recurring==="yes"){
			}
			//plan_price = $this.find('input[name="listing_id"]:checked').data('price');
			plan_price = jQuery('span#lp_price_subtotal').text();
			plan_price = parseFloat(plan_price)*100;
			if (!jQuery('input[name="listing_id"]').is(":checked") || !jQuery('input[name="plan"]').is(":checked") ) {
				alert(errormsg);
				e.preventDefault();
			}
			else if(method==='stripe'){
				//jQuery('#stripe-submit').trigger( "click" );
				handler.open({
				name: post_title,
				description: "",
				zipCode: true,
				amount: plan_price,
				currency: currency
			  });
				e.preventDefault();
			}
			else if(method==='2checkout'){
				plan_price = jQuery('span#lp_price_subtotal').text();
				jQuery('#myCCForm input#tprice').val(plan_price);
				jQuery('#myCCForm input#listing_id').val(listing_id);
				jQuery("button.lp-2checkout-modal").trigger('click');
				e.preventDefault();
			}
			
		});
		
	});
		var hdrHeight = jQuery('header.header-normal').outerHeight();

		jQuery('.top-section .absolute').css('top', hdrHeight);
		
		
	if(jQuery('body').is('.single-listing')){	
		if (jQuery(window).width() >= 768) { 
			// Listing Detail Gallery
			jQuery("a[rel^='prettyPhoto']").prettyPhoto({
				animation_speed:'fast',
				theme:'dark_rounded',
				slideshow:7000,
				autoplay_slideshow: true,
				social_tools: '',
				deeplinking: false,
				show_title: false,
			}); 
		}
	}

	
	


	jQuery('a.onlineform').on('click', function(event) {
		event.preventDefault();
		jQuery(this).next('.booking-form').slideToggle(400);
		jQuery(this).toggleClass('active');
	});

	jQuery('.listing-second-view .ask-question-area > a.ask_question_popup').on('click', function(event) {
		event.preventDefault();
		jQuery(this).next('.faq-form').slideToggle(400);
	});
	
	if(jQuery('body').is('.single-listing')){
		var sliderstyle = jQuery('body').data('sliderstyle');
		
		if(sliderstyle=="style1"){
			var images = jQuery( ".listing-slide" ).data('images-num');
			var center_mode = true;
			if(images > 5 ) {
				images = 5;
				center_mode = true;
			}else {
				center_mode = false;
			}
			// Listing Detail Slider
			jQuery('.listing-slide').slick({
				centerPadding: '10px',
				slidesToShow: images,
				autoplay: true,
				draggable: false,
				autoplaySpeed: 5000,
				centerMode: center_mode,
				focusOnSelect: true,
				arrows: true,
				responsive: [
					{
						breakpoint: 768,
						settings: {
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 5
						}
					},
					{
						breakpoint: 480,
						settings: {
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 1
						}
					}
				]
			});
		}
		else if(sliderstyle=="style2"){
			
			var images = jQuery( ".listing-slide" ).data('images-num');
			//alert(images);
			var center_mode = true;
			var variable = true;
			if(images > 3 ) {
				center_mode = false;
			} else if(images = 3) {
				//jQuery('.listing-slide img').css('height','auto');
				jQuery('.single-page-slider-container').addClass('three-imgs');
				variable = false;
			} else if(images = 2) {
				jQuery('.single-page-slider-container').addClass('new-cls');
			} else if(images = 1) {
				jQuery('.single-page-slider-container').addClass('one-img');
			} else {
				center_mode = false;
				variable = false;
			}
			
			// Listing Detail Slider
			jQuery('.listing-slide').slick({
				slidesToShow: 2,
				autoplay: true,
				draggable: false,
				autoplaySpeed: 5000,
				centerMode: true,
				focusOnSelect: true,
				variableWidth: variable,
				adaptiveHeight: true,
				responsive: [
					{
						breakpoint: 768,
						settings: {
							arrows: true,
							centerMode: false,
							centerPadding: '0px',
							//slidesToShow: 5
						}
					},
					{
						breakpoint: 480,
						settings: {
							arrows: false,
							centerMode: false,
							centerPadding: '0px',
							slidesToShow: 1
						}
					}
				]
			});

		}
	}
	
	
	jQuery( ".select2" ).select2();
	
	if(jQuery('body').is('.single-listing')){	
		jQuery('.review-img-slider').slick({
	  	infinite: true,
	  	slidesToShow: 3,
	  	slidesToScroll: 1,
		autoplay: false,
  		autoplaySpeed: 5000,
	  	arrows:true,
	  	dots:false,
	   	responsive: [
			{
		  		breakpoint: 790,
		  		settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '40px',
					slidesToShow: 2
		 		}
			},
			{
			  	breakpoint: 480,
			  	settings: {
					slidesToShow: 1
			  	}
			}
	  	]
		});
		/* end  by haroon */
		
		jQuery('.post-slide').slick({
		  infinite: true,
		  slidesToShow: 2,
		  slidesToScroll: 1,
		  arrows:false,
		  dots:true,
		   responsive: [
			{
			  breakpoint: 2,
			  settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '40px',
				slidesToShow: 3
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1
			  }
			}
		  ]
		});
		
		//Slick One Per Slide Testimonials
		jQuery('.testimonial-slider').slick({
			dots: true,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 1000,
			speed: 1000,
			arrows: false,
			slidesToShow: 1
		});
	}
	// Accordion
	var icons = {
		header: "fa fa-plus",
		activeHeader: "fa fa-minus"
	};
		jQuery( "#accordion" ).accordion({
			icons: icons,
			heightStyle: "content",
		});
	jQuery( "#toggle" ).button().on('click',function() {
		if ( jQuery( "#accordion" ).accordion( "option", "icons" ) ) {
			jQuery( "#accordion" ).accordion( "option", "icons", null );
		} else {
			jQuery( "#accordion" ).accordion( "option", "icons", icons );
	}
	});
	// Popup Gallery
	jQuery('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
	  disableOn: 319,
	  type: 'iframe',
	  mainClass: 'mfp-fade',
	  removalDelay: 160,
	  preloader: false,
	  fixedContentPos: false
	});
	
	jQuery('.popup-gallery').magnificPopup({
		delegate: '.image-popup',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		}
	});
	//Boostrap Rating
	//http://dreyescat.github.io/bootstrap-rating/
	 jQuery('input.check').on('change', function () {
          alert('Rating: ' + jQuery(this).val());
        });
		if(jQuery('body').is('.single-listing')){
        jQuery('#programmatically-set').on('click' , function () {
          jQuery('#programmatically-rating').rating('rate', jQuery('#programmatically-value').val());
        });
        jQuery('#programmatically-get').on('click' , function () {
          alert(jQuery('#programmatically-rating').rating('rate'));
        });
        
        jQuery('.rating-tooltip-manual').rating({
          extendSymbol: function () {
            var title;
            jQuery(this).tooltip({
              container: 'body',
              placement: 'bottom',
              trigger: 'manual',
              title: function () {
                return title;
              }
            });
            jQuery(this).on('rating.rateenter', function (e, rate) {
              title = rate;
              jQuery(this).tooltip('show');
            })
            .on('rating.rateleave', function () {
              jQuery(this).tooltip('hide');
            });
          }
        });
        jQuery('.rating').each(function () {
          jQuery('<span class="label label-default"></span>')
            .text(jQuery(this).val() || ' ')
            .insertAfter(this);
        });
        jQuery('.rating').on('change', function () {
          jQuery(this).next('.label').text(jQuery(this).val());
        });
		}
	// Popup Form
	jQuery(".signUpClick").on('click' , function() {
		jQuery('.signInClick').removeClass('active');
        jQuery(this).addClass('active');
		jQuery('.siginincontainer').fadeOut();
		jQuery('.forgetpasswordcontainer').fadeOut();
		jQuery('.siginupcontainer').fadeIn();
	 });
	jQuery(".signInClick").on('click' , function() {
		jQuery('.signUpClick').removeClass('active');
		jQuery(this).addClass('active');
		jQuery('.forgetpasswordcontainer').fadeOut();
		jQuery('.siginupcontainer').fadeOut();
		jQuery('.siginincontainer').fadeIn();
	 });
	jQuery(".forgetPasswordClick").on('click' , function() { 
		jQuery('.siginupcontainer').fadeOut();
		jQuery('.siginincontainer').fadeOut(); 
		jQuery('.forgetpasswordcontainer').fadeIn();

	 });
	jQuery(".cancelClick").on('click' , function() { 
		jQuery('.siginupcontainer').fadeOut();
		jQuery('.forgetpasswordcontainer').fadeOut();
		jQuery('.siginincontainer').fadeIn(); 

	 });
	 // Mapbox 
	jQuery(window).load(function(){
		
		if (jQuery(this).width() < 981) {
			jQuery(".claimformtrigger").on('click' , function() {
				if(jQuery('.claimform').hasClass('claimform-open')) {
					jQuery('.claimform').removeClass("claimform-open");
					jQuery('.claimform').hide(); 
				} else { 
					jQuery(this).closest('.post-row').addClass('rowopen');
					jQuery('.claimform').addClass("claimform-open"); 
					jQuery('.claimform').show();
				}
			});
		}
		
		jQuery(window).resize(function () {
			
			if (jQuery(this).width() < 781) {
					jQuery('.mobilemap').removeAttr('id');
					jQuery('.mobilemap').removeClass('md-modal');
					jQuery('.mobilemap').removeClass('md-effect-3');
					jQuery('.mobilelink').removeClass('md-trigger');
					jQuery('.mobile-map-space .md-overlayi').removeClass('md-overlay');
					jQuery('.listing-container-right .md-overlayi').removeClass('md-overlay');
					jQuery(".mobilelink").on('click' , function() {  
						if(jQuery('.mobilemap').hasClass('map-open')) {
							jQuery('.mobilemap').removeClass("map-open"); 
							jQuery('.mobilemap .mapbilemap-content').css({"opacity":"0","margin-top":"-520px"});
							jQuery("a.mobilelink").text("View on map");
						}
						else{   
							jQuery('.mobilemap').addClass("map-open"); 
							jQuery('.mobilemap .mapbilemap-content').css({"opacity":"1","margin-top":"0px"});
							jQuery("a.mobilelink").text("Close map");
						}
				    });
					jQuery(".quickformtrigger").on('click' , function() { 
						if(jQuery('.quickform').hasClass('quickform-open')) {
							jQuery('.quickform').removeClass("quickform-open");
							jQuery('.quickform').slideUp(600); 
							
							}
						else{
							jQuery('.quickform').addClass("quickform-open"); 
							jQuery('.quickform').slideDown(600);
						}
					});
			} else {
					var headertop = jQuery('header').height();
					jQuery('.section-fixed').css('padding-top',headertop+'px');
		
			}
			  
		}).resize();//triggcurrentColorer the event manually when the page is loaded

		jQuery('.listing-sidebar-left .form-inline').fadeTo( 600 , 1);
		jQuery('.post-with-map-container .form-inline').fadeTo( 600 , 1);	
		jQuery('#menu').css('display','block');
		jQuery('.spinner').css("display","none");
		jQuery('.single-page-slider-container').css("opacity","1");
		
			
/*
 * L.TileLayer is used for standard xyz-numbered tile layers.
 */


L.Google = L.Class.extend({
	includes: L.Mixin.Events,

	options: {
		minZoom: 0,
		maxZoom: 18,
		tileSize: 256,
		subdomains: 'abc',
		errorTileUrl: '',
		attribution: '',
		opacity: 1,
		continuousWorld: false,
		noWrap: false,
		mapOptions: {
			backgroundColor: '#dddddd'
		}
	},

	// Possible types: SATELLITE, ROADMAP, HYBRID, TERRAIN
	initialize: function(type, options) {
		L.Util.setOptions(this, options);

		this._ready = google.maps.Map != undefined;
		if (!this._ready) L.Google.asyncWait.push(this);

		this._type = type || 'SATELLITE';
	},

	onAdd: function(map, insertAtTheBottom) {
		this._map = map;
		this._insertAtTheBottom = insertAtTheBottom;

		// create a container div for tiles
		this._initContainer();
		this._initMapObject();

		// set up events
		map.on('viewreset', this._resetCallback, this);

		this._limitedUpdate = L.Util.limitExecByInterval(this._update, 150, this);
		map.on('move', this._update, this);

		map.on('zoomanim', this._handleZoomAnim, this);

		//20px instead of 1em to avoid a slight overlap with google's attribution
		map._controlCorners['bottomright'].style.marginBottom = "20px";

		this._reset();
		this._update();
	},

	onRemove: function(map) {
		this._map._container.removeChild(this._container);
		//this._container = null;

		this._map.off('viewreset', this._resetCallback, this);

		this._map.off('move', this._update, this);

		this._map.off('zoomanim', this._handleZoomAnim, this);

		map._controlCorners['bottomright'].style.marginBottom = "0em";
		//this._map.off('moveend', this._update, this);
	},

	getAttribution: function() {
		return this.options.attribution;
	},

	setOpacity: function(opacity) {
		this.options.opacity = opacity;
		if (opacity < 1) {
			L.DomUtil.setOpacity(this._container, opacity);
		}
	},

	setElementSize: function(e, size) {
		e.style.width = size.x + "px";
		e.style.height = size.y + "px";
	},

	_initContainer: function() {
		var tilePane = this._map._container,
			first = tilePane.firstChild;

		if (!this._container) {
			this._container = L.DomUtil.create('div', 'leaflet-google-layer leaflet-top leaflet-left');
			this._container.id = "_GMapContainer_" + L.Util.stamp(this);
			this._container.style.zIndex = "auto";
		}

		tilePane.insertBefore(this._container, first);

		this.setOpacity(this.options.opacity);
		this.setElementSize(this._container, this._map.getSize());
	},

	_initMapObject: function() {
		if (!this._ready) return;
		this._google_center = new google.maps.LatLng(0, 0);
		var map = new google.maps.Map(this._container, {
		    center: this._google_center,
		    zoom: 0,
		    tilt: 0,
		    mapTypeId: google.maps.MapTypeId[this._type],
		    disableDefaultUI: false,
		    keyboardShortcuts: false,
		    draggable: false,
		    disableDoubleClickZoom: true,
		    scrollwheel: false,
		    streetViewControl: true,
		    styles: this.options.mapOptions.styles,
		    backgroundColor: this.options.mapOptions.backgroundColor
		});

		var _this = this;
		this._reposition = google.maps.event.addListenerOnce(map, "center_changed",
			function() { _this.onReposition(); });
		this._google = map;

		google.maps.event.addListenerOnce(map, "idle",
			function() { _this._checkZoomLevels(); });
	},

	_checkZoomLevels: function() {
		//setting the zoom level on the Google map may result in a different zoom level than the one requested
		//(it won't go beyond the level for which they have data).
		// verify and make sure the zoom levels on both Leaflet and Google maps are consistent
		if (this._google.getZoom() !== this._map.getZoom()) {
			//zoom levels are out of sync. Set the leaflet zoom level to match the google one
			this._map.setZoom( this._google.getZoom() );
		}
	},

	_resetCallback: function(e) {
		this._reset(e.hard);
	},

	_reset: function(clearOldContainer) {
		this._initContainer();
	},

	_update: function(e) {
		if (!this._google) return;
		this._resize();

		var center = e && e.latlng ? e.latlng : this._map.getCenter();
		var _center = new google.maps.LatLng(center.lat, center.lng);

		this._google.setCenter(_center);
		this._google.setZoom(this._map.getZoom());

		this._checkZoomLevels();
		//this._google.fitBounds(google_bounds);
	},

	_resize: function() {
		var size = this._map.getSize();
		if (this._container.style.width == size.x &&
		    this._container.style.height == size.y)
			return;
		this.setElementSize(this._container, size);
		this.onReposition();
	},


	_handleZoomAnim: function (e) {
		var center = e.center;
		var _center = new google.maps.LatLng(center.lat, center.lng);

		this._google.setCenter(_center);
		this._google.setZoom(e.zoom);
	},


	onReposition: function() {
		if (!this._google) return;
		google.maps.event.trigger(this._google, "resize");
	}
});

L.Google.asyncWait = [];
L.Google.asyncInitialize = function() {
	var i;
	for (i = 0; i < L.Google.asyncWait.length; i++) {
		var o = L.Google.asyncWait[i];
		o._ready = true;
		if (o._container) {
			o._initMapObject();
			o._update();
		}
	}
	L.Google.asyncWait = [];
};



	L.HtmlIcon = L.Icon.extend({
		options: {
			/*
			html: (String) (required)
			iconAnchor: (Point)
			popupAnchor: (Point)
			*/
		},

		initialize: function(options) {
			L.Util.setOptions(this, options);
		},

		createIcon: function() {
			var div = document.createElement('div');
			div.innerHTML = this.options.html;
			if (div.classList)
				div.classList.add('leaflet-marker-icon');
			else
				div.className += ' ' + 'leaflet-marker-icon';
			return div;
		},

		createShadow: function() {
			return null;
		}
	});
		
			
			 	jQuery( ".all-list-map" ).on('click', function() {
					//alert('ghgfh');
					jQuery('.map-pop').empty();
					if(jQuery('#map-section').is('.map-container3')) {
						jQuery('.map-pop').html('<div class="mapSidebar" id="map"></div>');
					}else{
						jQuery('.map-pop').html('<div class="listingmap" id="map"></div>');
					}
					var map = null
					$mtoken = jQuery('#page').data("mtoken");	
					$mapboxDesign = jQuery('#page').data("mstyle");
					
					if($mtoken != ''){
						
						L.mapbox.accessToken = $mtoken;
						 map = L.mapbox.map('map', 'mapbox.streets');
						L.tileLayer('https://api.tiles.mapbox.com/v4/'+$mapboxDesign+'/{z}/{x}/{y}.png?access_token='+$mtoken+'', {
									maxZoom: 18,
									attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
										'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
										'Imagery © <a href="http://mapbox.com">Mapbox</a>',
									id: 'mapbox.light'
						}).addTo(map);						
						 
						var markers = new L.MarkerClusterGroup();
						initializeMap(markers);
						if(markers===undefined){}else{
							map.fitBounds(markers.getBounds());
							map.scrollWheelZoom.disable();
						}
					}else{	
						
						var map = new L.Map('map', {
							minZoom: 3,							
						}).setView(new L.LatLng(0, -0), 18);
						L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
							maxZoom: 18,
							subdomains:['mt0','mt1','mt2','mt3'],
							noWrap: true,
						});
						var googleLayer = new L.Google('ROADMAP');						
						map.addLayer(googleLayer);
						var markers = new L.MarkerClusterGroup();
						initializeMap(markers);
						if(markers===undefined){}else{
							
							map.fitBounds(markers.getBounds(), {padding: [50, 50]});
							
						}							
					}
						
						
						
						
					function initializeMap(markers) {
						markers.clearLayers();
						
						jQuery(".lp-grid-box-contianer").each(function(i){
			
							var LPtitle  = jQuery(this).data("title");
							var LPposturl  = jQuery(this).data("posturl");
							var LPlattitue  = jQuery(this).data("lattitue");
							var LPlongitute  = jQuery(this).data("longitute");
							var LPpostid  = jQuery(this).data("postid");
							var LPaddress  = jQuery(this).find('.gaddress').text();
							var LPimageSrc  = jQuery(this).find('.lp-grid-box-thumb').find('img').attr('src');
							var LPiconSrc  = jQuery(this).find('.cat-icon').find('img').attr('src');
							if(LPlattitue != '' && LPlongitute != ''){
								var LPimage = '';
								if(LPimageSrc != ''){
									LPimage = LPimageSrc;
								}
								
								var LPicon = '';
								if(LPiconSrc != ''){
									LPicon = LPiconSrc;
								}
								
								var markerLocation = new L.LatLng(LPlattitue, LPlongitute); // London

								var CustomHtmlIcon = L.HtmlIcon.extend({
									options : {
										html : "<div class='lpmap-icon-shape pin card"+LPpostid+"'><div class='lpmap-icon-contianer'><img src='"+LPicon+"' /></div></div>",
									}
								});

								var customHtmlIcon = new CustomHtmlIcon(); 

								var marker = new L.Marker(markerLocation, {icon: customHtmlIcon}).bindPopup('<div class="map-post"><div class="map-post-thumb"><a href="'+LPposturl+'"><img src="'+LPimage+'" ></a></div><div class="map-post-des"><div class="map-post-title"><h5><a href="'+LPposturl+'">'+LPtitle+'</a></h5></div><div class="map-post-address"><p><i class="fa fa-map-marker"></i> '+LPaddress+'</p></div></div></div>').addTo(map);
								markers.addLayer(marker);
								map.addLayer(markers);
							
							}
							
						});
					};
						
					
				});
				
				jQuery(document).on('click', '.listing-app-view-bar .right-icons a, .sidemap-fixed .sidemarpInside', function(e){
					if(jQuery('#map').is('.mapSidebar')) {
						
						var defmaplat = jQuery('body').data('defaultmaplat');
						var defmaplong = jQuery('body').data('defaultmaplot');
					
						jQuery('.map-pop').empty();
						jQuery('.map-pop').html('<div class="mapSidebar" id="map"></div>');
						var map = null
						$mtoken = jQuery('#page').data("mtoken");					
						$mapboxDesign = jQuery('#page').data("mstyle");					
						
						if($mtoken != ''){
							
							L.mapbox.accessToken = $mtoken;
							 map = L.mapbox.map('map', 'mapbox.streets')
							 .setView([defmaplat, defmaplong], 2);
							L.tileLayer('https://api.tiles.mapbox.com/v4/'+$mapboxDesign+'/{z}/{x}/{y}.png?access_token='+$mtoken+'', {
										maxZoom: 18,
										attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
											'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
											'Imagery © <a href="http://mapbox.com">Mapbox</a>',
										id: 'mapbox.light'
							}).addTo(map);						
							 
							var markers = new L.MarkerClusterGroup();
							initializeMap(markers);
							map.fitBounds(markers.getBounds(), {padding: [50, 50]});
							jQuery(document).on('click','.open-map-view', function() { 
							  L.Util.requestAnimFrame(map.invalidateSize,map,!1,map._container);
							});
							
						}else{
							
							var map = new L.Map('map', {
								minZoom: 3,
							}).setView(new L.LatLng(defmaplat, defmaplong), 6);
							L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
								maxZoom: 6,
								subdomains:['mt0','mt1','mt2','mt3'],
								noWrap: true,
							});
							var googleLayer = new L.Google('ROADMAP');						
							map.addLayer(googleLayer);
							
							
							var markers = new L.MarkerClusterGroup();
								resmarkers = initializeMap(markers);
								//if(resmarkers!== "undefined"){
								//console.log(resmarkers);
								//if(typeof resmarkers  == 'undefined'){}
								if( resmarkers  === undefined){}
								else{
									map.fitBounds(markers.getBounds(), {padding: [50, 50]});
									map.scrollWheelZoom.enable();
									map.invalidateSize();
									map.dragging.enable();
									jQuery(document).on('click','.open-map-view', function() { 
									  L.Util.requestAnimFrame(map.invalidateSize,map,!1,map._container);
									});
								}
							
						}
						
						function initializeMap(markers) {
							
							if( jQuery('.lp-grid-box-contianer').length !=0 ){
								markers.clearLayers();
								jQuery(".lp-grid-box-contianer").each(function(i){
					
									var LPtitle  = jQuery(this).data("title");
									var LPposturl  = jQuery(this).data("posturl");
									var LPlattitue  = jQuery(this).data("lattitue");
									var LPlongitute  = jQuery(this).data("longitute");
									var LPpostid  = jQuery(this).data("postid");
									var LPaddress  = jQuery(this).find('.gaddress').text();
									var LPimageSrc  = jQuery(this).find('.lp-grid-box-thumb').find('img').attr('src');
									var LPiconSrc  = jQuery(this).find('.cat-icon').find('img').attr('src');
									if(LPlattitue != '' && LPlongitute != ''){
										
										var LPimage = '';
										if(LPimageSrc != ''){
											LPimage = LPimageSrc;
										}
										
										var LPicon = '';
										if(LPiconSrc != ''){
											LPicon = LPiconSrc;
										}
										
										var markerLocation = new L.LatLng(LPlattitue, LPlongitute); // London

										var CustomHtmlIcon = L.HtmlIcon.extend({
											options : {
												html : "<div class='lpmap-icon-shape pin card"+LPpostid+"'><div class='lpmap-icon-contianer'><img src='"+LPicon+"' /></div></div>",
											}
										});

										var customHtmlIcon = new CustomHtmlIcon(); 

										var marker = new L.Marker(markerLocation, {icon: customHtmlIcon}).bindPopup('<div class="map-post"><div class="map-post-thumb"><a href="'+LPposturl+'"><img src="'+LPimage+'" ></a></div><div class="map-post-des"><div class="map-post-title"><h5><a href="'+LPposturl+'">'+LPtitle+'</a></h5></div><div class="map-post-address"><p><i class="fa fa-map-marker"></i> '+LPaddress+'</p></div></div></div>').addTo(map);
										markers.addLayer(marker);
										map.addLayer(markers);
									
									}
									
								});
								return true;
							}
						}
					
					}
				});
					
		 if(jQuery('#cpmap').is('.contactmap')) {
			 
			 jQuery('#cpmap').empty();
			var map = null;
			 $mtoken = jQuery('#page').data("mtoken");
				$siteURL = jQuery('#page').data("site-url");
				$lat = jQuery('.cp-lat').data("lat");
				$lan = jQuery('.cp-lan').data("lan");
				if($mtoken != ''){
					L.mapbox.accessToken = $mtoken;
					
					var map = L.mapbox.map('cpmap', 'mapbox.streets')
					.setView([$lat,$lan], 14);
					map.scrollWheelZoom.disable();
					
				}else{
					
					var map = new L.Map('cpmap', '').setView(new L.LatLng($lat, $lan), 16);
						
						var googleLayer = new L.Google('ROADMAP');						
						map.addLayer(googleLayer);
						
						map.scrollWheelZoom.disable();
					}
					
					var markers = new L.MarkerClusterGroup();
					var $pinicon = jQuery('#cpmap').data('pinicon');
					if($pinicon===""){
						$pinicon = "<div class='lpmap-icon-shape pin'><div class='lpmap-icon-contianer'><img src='"+$siteURL+"wp-content/themes/listingpro/assets/images/pins/lp-logo.png'  /></div></div>";
					}
					else{
						$pinicon = "<div style='width:50px; height:50px; margin: -50px 0 0 -20px;'><img src='"+$pinicon+"'  /></div>";
					}
					
						var markerLocation = new L.LatLng($lat, $lan); // London

						var CustomHtmlIcon = L.HtmlIcon.extend({
							options : {
								html : $pinicon,
							}
						});

						var customHtmlIcon = new CustomHtmlIcon(); 

						var marker = new L.Marker(markerLocation, {icon: customHtmlIcon}).bindPopup('').addTo(map);
						markers.addLayer(marker);
						
			
			}else if(jQuery('#map').is('.singlebigpost')) {
				jQuery( ".singlebigmaptrigger" ).click(function() {
					
					$mtoken = jQuery('#page').data("mtoken");
					$siteURL = jQuery('#page').data("site-url");
					$lat = jQuery('.singlebigmaptrigger').data("lat");
					$lan = jQuery('.singlebigmaptrigger').data("lan");
					if($mtoken != ''){
						
						L.mapbox.accessToken = $mtoken;
						var map = L.mapbox.map('map', 'mapbox.streets')
						.setView([$lat,$lan], 14);
						
						var markers = new L.MarkerClusterGroup();
						
							var markerLocation = new L.LatLng($lat, $lan); // London

							var CustomHtmlIcon = L.HtmlIcon.extend({
								options : {
									html : "<div class='lpmap-icon-shape pin '><div class='lpmap-icon-contianer'><img src='"+$siteURL+"wp-content/themes/listingpro/assets/images/pins/lp-logo.png'  /></div></div>",
								}
							});

							var customHtmlIcon = new CustomHtmlIcon(); 

							var marker = new L.Marker(markerLocation, {icon: customHtmlIcon}).bindPopup('').addTo(map);
							markers.addLayer(marker);
							map.fitBounds(markers.getBounds());
						
							map.scrollWheelZoom.disable();
							map.invalidateSize();
						
						
					}else{
							var map = new L.Map('map', {center: new L.LatLng($lat,$lan), zoom: 14});
							var googleLayer = new L.Google('ROADMAP');
							map.addLayer(googleLayer);
							var markers = new L.MarkerClusterGroup();
						
							var markerLocation = new L.LatLng($lat, $lan); // London

							var CustomHtmlIcon = L.HtmlIcon.extend({
								options : {
									html : "<div class='lpmap-icon-shape pin '><div class='lpmap-icon-contianer'><img src='"+$siteURL+"wp-content/themes/listingpro/assets/images/pins/lp-logo.png'  /></div></div>",
								}
							});

							var customHtmlIcon = new CustomHtmlIcon(); 

							var marker = new L.Marker(markerLocation, {icon: customHtmlIcon}).bindPopup('').addTo(map);
							markers.addLayer(marker);
							map.fitBounds(markers.getBounds());
						
							map.scrollWheelZoom.disable();
							map.invalidateSize();
					}
					
				});
			}

		});
				
		
	// Autocomplete
	
    jQuery.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = jQuery( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = jQuery( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left lp-search-input location_input lp-home-locaton-input" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
		  .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        jQuery( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .on('click' , function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = jQuery( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( jQuery( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
	
    jQuery( ".comboboxs" ).combobox();
		jQuery( "#toggle" ).on('click' , function(){
		jQuery( ".comboboxs" ).toggle();
    });	
   // jQuery( "#searchcategory" ).combobox();
		jQuery( "#toggle" ).on('click' , function(){
		jQuery( "#searchcategory" ).toggle();
    });	
    jQuery( ".ui-autocomplete" ).autocomplete({
	  appendTo: ".input-group"
	});    
	jQuery('.custom-combobox-input').autocomplete({ minLength: 0 });
	jQuery('.custom-combobox-input').on( "click", function(){
		jQuery(this).autocomplete("search", "");
	});
	
  
	// Location Placeholder
	jQuery(".location_input").attr("placeholder", "Your Location");
	jQuery(".comboboxCategory .location_input").attr("placeholder", "Food");
	jQuery(".postSubmitCat .location_input").attr("placeholder", "Chose one or more than one categories");
	
	
	jQuery(document).on('click', '.md-close', function(){	
		jQuery('.md-modal').modal('hide');
		jQuery('.md-modal').removeClass('md-show');
		jQuery('.modal-backdrop').remove();
	});
	// Popup Data
	jQuery(document).on('click', '.qickpopup', function(){
  // variables
  var LPtitle  = jQuery(this).closest('.lp-grid-box-contianer').data("title");
  var LPlattitue  = jQuery(this).closest('.lp-grid-box-contianer').data("lattitue");
  var LPlongitute  = jQuery(this).closest('.lp-grid-box-contianer').data("longitute");
  var LPpostID  = jQuery(this).closest('.lp-grid-box-contianer').data("postid");
		jQuery('#listing-preview-popup .md-close').hide();
        var docHeight = jQuery( document ).height();
        jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
        jQuery('#full-overlay').css('height',docHeight+'px');

        jQuery('#listing-preview-popup .popup-inner-left-padding').html('').css('min-hegiht', '300px');

        if(jQuery('#listing-preview-popup').is('.md-show')) {

        }else{
            jQuery('#listing-preview-popup').modal({
                show: 'true'
            });
            jQuery('#listing-preview-popup').addClass('md-show');
        }

        jQuery.ajax({
            url: ajax_search_term_object.ajaxurl,
            dataType: "json",
            data: {
                'action':'quick_preivew_cb',
                'LPpostID' : LPpostID
            },
            success:function(data) {
				jQuery('#listing-preview-popup .md-close').show().children('i').css('right', '20px');

             var ad_markup = '';
             var rate_markup = '';
			 if(data.noreview){
				 rate_markup = data.noreview;
			 }
                if(data.adStatus == 'active')
                {
                    ad_markup = '<span class="listing-pro">'+data.ad+'</span>';
                }
                if(data.rate != ''){
                 rate_markup = '<span class="rate">'+ data.rate +'<sup>/5</sup></span>'
    }
             var popLeftSide = '<div class="col-md-6 lp-insert-data">' +
     '<div class="lp-grid-box-thumb">' +
      '<div class="slide"><img src="'+ data.post_thumb +'" alt="'+ data.ptitle +'"></div>' +
     '</div>' +
     '<div class="lp-grid-desc-container lp-border clearfix">' +
      '<div class="lp-grid-box-description ">' +
       '<div class="lp-grid-box-left pull-left">' +
        '<h4 class="lp-h4"><a href="'+ data.permalink +'">'+ ad_markup + LPtitle +'</a></h4>' +
        '<ul>' +
         '<li>'+ rate_markup +'</li>';
		 if(data.pricey!=null){
			 popLeftSide +='<li class="middle">' + data.pricey +'</li>';
		 }
         
		 popLeftSide += '<li>' + data.cats_markup +'</li>' +
         '<li>' +
          '<a href="tel:'+ data.phone +'">'+ data.phone +'</a>' +
         '</li>' +
        '</ul>';
		if(data.post_content!=false){
			popLeftSide +=
			'<div class="lp-grid-desc">' +
			'<p>'+ data.post_content +'</p>' +
			'</div>';
		}
		popLeftSide +=
       '</div>' +
       '<div class="lp-grid-box-right pull-right"></div>' +
      '</div>' +
      '<div class="lp-grid-box-bottom">' +
       '<div class="pull-left">' + data.adress_markup +'</div>' +
       '<div class="pull-right">' +
        '<a href="#" class="status-btn">'+ data.openStatus +'</a>' +
       '</div>' +
       '<div class="clearfix"></div>' +
      '</div>' +
     '</div>' +
    '</div>';

                var rightSideMarkup = '<div class="col-md-6">' +
      '<div id="quickmap'+ LPpostID +'" class="quickmap"></div>';
     '</div>';
                jQuery('#listing-preview-popup .popup-inner-left-padding').html(popLeftSide + rightSideMarkup);
                var markers = false;
                $mtoken = jQuery('#page').data("mtoken");
                $siteURL = jQuery('#page').data("site-url");
                $lat = LPlattitue;
                $lan = LPlongitute;

                if($mtoken != ''){

                    L.mapbox.accessToken = $mtoken;
                    map = L.mapbox.map('quickmap'+LPpostID, 'mapbox.streets');
                }else{
                    var map = new L.Map('quickmap'+LPpostID, {center: new L.LatLng($lat,$lan), zoom: 14});
                    var googleLayer = new L.Google('ROADMAP');
                    map.addLayer(googleLayer);
                }

                map.setView([$lat,$lan], 14);

                markers = new L.MarkerClusterGroup();

                var markerLocation = new L.LatLng($lat, $lan); // London

                var CustomHtmlIcon = L.HtmlIcon.extend({
                    options : {
                        html : "<div class='lpmap-icon-shape pin '><div class='lpmap-icon-contianer'><img src='"+$siteURL+"wp-content/themes/listingpro/assets/images/pins/lp-logo.png'  /></div></div>",
                    }
                });

                var customHtmlIcon = new CustomHtmlIcon();

                var marker = new L.Marker(markerLocation, {icon: customHtmlIcon}).bindPopup('').addTo(map);
                markers.addLayer(marker);
                jQuery('.md-close.widget-map-click').on('click', function(e){
								jQuery('#full-overlay').remove();
				});


                //alert(data.cats_markup);
            },
            error: function(errorThrown){
                alert(errorThrown);
            }
        });

 });
	
	//href Smooth Scroll
	
	// handle links with @href started with '#' only
 	jQuery('.post-meta-right-box a.secondary-btn[href^="#"]').on('click',function (e) {
	    e.preventDefault();

	    var target = this.hash;
	    var $target = jQuery(target);

	    jQuery('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
	}); 
	var submitlink = jQuery('body').data('submitlink');
	var siteurl = jQuery('#page').data('site-url');
	var sitelogo = jQuery('#page').data('sitelogo');
	
	jQuery('#menu').mmenu({
		navbar: {
			title: ""
		},
		navbars		: {
			height 	: 3,
			content :  [ 
				'<a href="'+siteurl+'" class="userimage"><img class="icon icons8-Contacts" src="'+sitelogo+'" alt="user"></a>',					
			]
		}
	});
	var API = jQuery("#menu").data( "mmenu" );
	jQuery(".lpl-button.md-trigger, .sign-login-wrap .md-trigger").click(function() {
		API.close();
	});
	//Tags Container 
	jQuery('.chosen-select2').chosen({
		disable_search: true
	});
	jQuery('.chosen-select1').chosen({
		disable_search: true
	});
	jQuery('.chosen-select7').chosen({
		disable_search: true
	});
	
	jQuery('.chosen-select5').chosen({
		disable_search: true
	});
	
	var $tags = jQuery('#searchtags').chosen(),
		LPnewTags = function() {
                    jQuery('.LPtagsContainer').empty();
                    $tags.find(':selected').each(function(i, obj) {
                        jQuery('<div class="active-tag">' + obj.value + '<div class="remove-tag"><i class="fa fa-times"></i></div></div>').appendTo('.LPtagsContainer').on('click', function() {
                            jQuery(this).remove();
                            jQuery(obj).attr('selected', false);
                            $tags.trigger("chosen:updated");
                            jQuery('.LPtagsContainer input[value="' + obj.value + '"]').remove();
                        });

                        jQuery('<input type="hidden" name="select_tag" value="' + obj.value + '" />').appendTo('.LPtagsContainer');
                    });
                };

            $tags.on('change', LPnewTags);
	
		/* Social Share */
		var social = jQuery('.post-stat li ul.social-icons.post-socials');
		var socialOvrly = jQuery('.reviews.sbutton .md-overlay');

		jQuery('.sbutton a.reviews-quantity').on('click', function(event) { 
			event.preventDefault();
			social.fadeIn(400);

			if(socialOvrly.hasClass('hide')){
				jQuery(socialOvrly).removeClass('hide');
				jQuery(socialOvrly).addClass('show');
			}
			else{
				jQuery(socialOvrly).removeClass('show');
				jQuery(socialOvrly).addClass('hide');
			}
		});

		socialOvrly.on('click', function(event) { 
			event.preventDefault();
			social.fadeOut(400);

			if(socialOvrly.hasClass('show')){
				jQuery(socialOvrly).removeClass('show');
				jQuery(socialOvrly).addClass('hide');
			}
			else{
				jQuery(socialOvrly).removeClass('hide');
				jQuery(socialOvrly).addClass('show');
			}
		});
		
		// Reserwa Popup
		jQuery('a.make-reservation').on('click', function(event) {
			event.preventDefault();
			jQuery('.ifram-reservation').fadeIn(400);
		});
		jQuery('a.close-btn').on('click', function(event) {
			event.preventDefault();
			jQuery('.ifram-reservation').fadeOut(400);
		});

		//Menu Popup
		if ( jQuery(window).width() > 767 ) {
			//Menu Popup
			jQuery('.widget-box a.open-modal').on('click', function(event) {
				event.preventDefault();
				jQuery('.hotel-menu').fadeIn(400);
			});
			jQuery('a.close-menu-popup').on('click', function(event) {
				event.preventDefault();
				jQuery('.hotel-menu').fadeOut(400);
			});
		} else if(jQuery(window).width() < 767) {
			//Menu Popup
			jQuery('.widget-box a.open-modal').on('click', function(event) {
				event.preventDefault();
				jQuery('.hotel-menu').slideToggle(400);
			});
			
		}


		// Resurva Booking Switcher
		jQuery('a.switch-fields').on('click', function(event) {
			event.preventDefault();
			jQuery(this).toggleClass('active');
			jQuery('.hidden-items').fadeToggle(400);
		});

		// Dashboard Notices
		jQuery('a.dismiss').on('click', function(event) {
			event.preventDefault();
			jQuery(this).parent('.panel-dash-dismiss').slideUp(400);
		});
		
		
		
		
		/* Pins Hover */

		jQuery(document).on('mouseenter','.lp-grid-box-contianer',function() {
			var cardID  = jQuery(this).data("postid");
			var	cardclass = '.lpmap-icon-shape.card'+cardID;
			if(jQuery(cardclass).hasClass('cardHighlight')) {
				jQuery(cardclass).removeClass("cardHighlight"); 
			 }
			 else{   
				jQuery(cardclass).addClass("cardHighlight"); 
			 }
		  });
		  jQuery(document).on('mouseleave','.lp-grid-box-contianer',function() {
				var cardID  = jQuery(this).data("postid");
				var	cardclass = '.lpmap-icon-shape.card'+cardID;
				jQuery(cardclass).removeClass("cardHighlight"); 			 
		  });
		  
		  
		  
	 /* Select Category */
	 jQuery('.postsubmitSelect').on('change', function(){
		 jQuery('.featuresDataRow').show();
		var cvalue =	jQuery(this).val() ;
		jQuery('.featuresData').css({'opacity':'0','visibility':'hidden','display':'none'});
		jQuery('.featuresDataContainer').find('.featuresData'+cvalue).css({'opacity':'1','visibility':'visible','display':'block'});
	});
	
});
jQuery(document).on('change', '.btn-file :file', function() {
  var input = jQuery(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});






jQuery(document).ready(function(){
	if(jQuery('form').is('#lp-submit-formdf')) {
		var validator = new FormValidator('lp-submit-form', [
		{
			name: 'postTitle',
			display: 'Title',
			rules: 'required'
		}, {
			name: 'category',
			display: 'Category',
			rules: 'required'
		}, {
			name: 'postContent',
			display: 'Description',
			rules: 'required'
		},  {
			name: 'location',
			display: 'Location',
			rules: 'required'
		},  {
			name: 'gAddress',
			display: 'Google Address',
			rules: 'required'
		},{
			name: 'email',
			rules: 'valid_email',
			
		},{
			name: 'username',
			display: 'UserName',
			rules: 'required'
			
		},{
			name: 'policycheck',
			display: 'Terms and Conditions Check',
			rules: 'required'
			
		}], function(errors, evt) {


			var SELECTOR_ERRORS = jQuery('.error_box'),
				SELECTOR_SUCCESS = jQuery('.success_box');

			if (errors.length > 0) {
				SELECTOR_ERRORS.empty();

				for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
					SELECTOR_ERRORS.append(errors[i].message + '<br />');
				}

				SELECTOR_SUCCESS.css({ display: 'none' });
				SELECTOR_ERRORS.fadeIn(200);
			} else {
				SELECTOR_ERRORS.css({ display: 'none' });
				SELECTOR_SUCCESS.fadeIn(200);
			}

			
		});
	}	
});
var image_custom_uploader;
var $thisItem = '';

jQuery(document).on('click','.upload-author-image', function(e) {
	e.preventDefault();

	$thisItem = jQuery(this);
	$form = jQuery('#profileupdate');

	//If the uploader object has already been created, reopen the dialog
	if (image_custom_uploader) {
	    image_custom_uploader.open();
	    return;
	}

	//Extend the wp.media object
	image_custom_uploader = wp.media.frames.file_frame = wp.media({
	    title: 'Choose Image',
	    button: {
	        text: 'Choose Image'
	    },
	    multiple: false
	});

	//When a file is selected, grab the URL and set it as the text field's value
	image_custom_uploader.on('select', function() {
	    attachment = image_custom_uploader.state().get('selection').first().toJSON();
	    var url = '';
	    url = attachment['url'];
	    var attachId = '';
	    attachId = attachment['id'];
		
	   jQuery( "img.author-avatar" ).attr({
	        src: url
	    });
	  $form.parent().parent().find( ".criteria-image-url" ).attr({
	        value: url
	    });
	    $form.parent().parent().find( ".criteria-image-id" ).attr({
	        value: attachId
	    });
	});

	//Open the uploader dialog
	image_custom_uploader.open();
});
									
									
/* update by zaheer on 25 feb  */									
jQuery(document).ready(function($){
	jQuery('#listings_checkout input[name=listing_id]').on('change', function() {
	jQuery('#listings_checkout input[name=post_id]').val(jQuery(this, '#listings_checkout').val());
	});
	jQuery('#listings_checkout input[name=plan]').on('change', function() {
	jQuery('#listings_checkout input[name=method]').val(jQuery(this, '#listings_checkout').val());
	});
	
	
	jQuery('.lp-promotebtn').on('click', function(){
		var $this = jQuery(this);
		jQuery('#ads_promotion input[name=listing_id]').val($this.data('listingnid'));
		var listtitle = $this.data('listingtitle');
		jQuery('input[name=cur_listing_title]').val(listtitle);
	});
	jQuery('#ads_promotion input[name=plan]').on('change', function() {
	jQuery('#ads_promotion input[name=method]').val(jQuery(this, '#listings_checkout').val());
	});


});
/* by zaheer on 25 feb */
	jQuery('.availableprice_options input').change(function($){
		var $total, taxrate='', taxprice, taxTotal;
		if(jQuery('span').hasClass('pricetax')){
			taxrate = jQuery('span.pricetax').data('taxprice');
		}
		$oldtotal = jQuery('#totalprice').val();
		oldTax = jQuery('input[name="taxprice"]').val();
		if (jQuery(this).is(":checked")){
			var $val = jQuery(this).val();
			$total = parseFloat($val)+parseFloat($oldtotal);
			taxprice = parseFloat((taxrate/100)*$val);
			taxTotal = parseFloat(oldTax)+parseFloat(taxprice);
			$total = $total+taxprice;
			$total = $total.toFixed(2);
			taxTotal = taxTotal.toFixed(2);
			jQuery('#totalprice').val($total);
			jQuery('.pricetotal #price').html($total);
			jQuery('input[name="lp_total_price"]').val($total);
			jQuery('input[name="taxprice"]').val(taxTotal);
		}
		else{
			var $val = jQuery(this).val();
			$total = parseFloat($oldtotal)-parseFloat($val);
			taxprice = parseFloat((taxrate/100)*$val);
			taxTotal = parseFloat(oldTax)-parseFloat(taxprice);
			$total = $total-taxprice;
			$total = $total.toFixed(2);
			taxTotal = taxTotal.toFixed(2);
			if($total>0){
				jQuery('#totalprice').val($total);
				jQuery('.pricetotal #price').html($total);
				jQuery('input[name="lp_total_price"]').val($total);
				jQuery('input[name="taxprice"]').val(taxTotal);
			}
			else{
				$total = 0.00;
				jQuery('#totalprice').val($total);
				jQuery('.pricetotal #price').html($total);
				jQuery('input[name="lp_total_price"]').val($total);
				jQuery('input[name="taxprice"]').val(taxTotal);
			}
			
		}
		
	});
	

/* update by zaheer on 25 feb  */
jQuery('.lp-front').on('click','#lp-front' ,function(e) {
	e.preventDefault();
	//jQuery('.lp-front').hide(200);
	jQuery('.lp-front').slideUp(500);
	jQuery('.lp-back1').slideDown(1000);
	//jQuery('.lp-back').show(500);
});
jQuery('.lp-back1').on('click','#lp-back1' ,function(e) {
	e.preventDefault();
	jQuery('.lp-back1').slideUp(500);
	jQuery('.lp-front').slideDown(1000);
});
jQuery('.lp-back1').on('click','#lp-next' ,function(e) {
	e.preventDefault();
	jQuery('.lp-back1').slideUp(500);
	jQuery('.lp-back2').slideDown(1000);
});
jQuery('.lp-back2').on('click','#lp-back2' ,function(e) {
	e.preventDefault();
	jQuery('.lp-back2').slideUp(500);
	jQuery('.lp-back1').slideDown(1000);
});
/* end update by zaheer on 25 feb  */

//dynamic model for invoices by zaheer
jQuery(document).ready(function($){
	
	jQuery('.invoice-section a.showme').click(function(ev){
		var $this = jQuery(this);
		$this.after( '<i class="lp-modal-spinn fa-li fa fa-spinner fa-spin"></i>' );
             ev.preventDefault();
             var rowid = jQuery(this).data('id');
				 reqlink = jQuery(this).data('url');
				 var invoiceFor = '';
				 invoiceFor = jQuery(this).data('lpinvoice');
				 //invoiceFor = 'dddf';
				 
				jQuery.get(reqlink+'?lp_p_id=' + rowid+'&lp_invoice=' + invoiceFor, function(html){
                 jQuery('#modal-invoice .modal-body').html('');
                 jQuery('#modal-invoice .modal-body').html(html);
                 jQuery('#modal-invoice').modal('show', {backdrop: 'static'});
				 $this.next( '.lp-modal-spinn' ).hide('');
				 $this.next( '.lp-modal-spinn' ).remove('');
             });
         });
		
});



/* print preview */
jQuery(function($) { 'use strict';
            jQuery("#modal-invoice").find('.lp-print-list').on('click', function() {
                //jQuery.print("#modal-invoice");
                jQuery("#modal-invoice").print({
					noPrintSelector : ".modal-footer",
				});
				 
            });
});

jQuery(document).ready(function($) {  
    jQuery('.googleAddressbtn').on('click', function(e) {		
		var dtype = jQuery(this).data('type');
		if(dtype=="gaddress") {
			jQuery('.post-submit #inputAddresss').slideUp(300);
			jQuery('.lp-custom-lat').slideUp(300);
			jQuery('.post-submit #inputAddress').slideDown();
			jQuery('.post-submit .googlefulladdress').slideDown(300);
			jQuery('.post-submit #latitude').attr('type', 'hidden');
			jQuery('.post-submit #longitude').attr('type', 'hidden');
			jQuery(this).next('.googleAddressbtn').removeClass('active');
			jQuery(this).addClass('active');
		} else {
			jQuery('.post-submit #inputAddress').slideUp();
			jQuery('.post-submit .googlefulladdress').slideUp(300);
			jQuery('.post-submit #inputAddresss').slideDown(300);
			jQuery('.lp-custom-lat').slideDown(300);
			jQuery('.post-submit #latitude').attr('type', 'text');
			jQuery('.post-submit #longitude').attr('type', 'text');
			jQuery(this).prev('.googleAddressbtn').removeClass('active');
			jQuery(this).addClass('active');
		}
		e.preventDefault();        
    });
});


/* ======27 may mm=========== */
jQuery(document).ready(function($) {
    jQuery('#slide-nav.navbar-inverse').after(jQuery('<div class="inverse" id="navbar-height-col"></div>'));  
    jQuery('#slide-nav.navbar-default').after(jQuery('<div id="navbar-height-col"></div>'));  
    var toggler = '.navbar-toggle';
    var pagewrapper = '#page-content';
    var navigationwrapper = '.navbar-header';
    var menuwidth = '100%';
    var slidewidth = '80%';
    var menuneg = '-100%';
    var slideneg = '-80%';
    jQuery("#slide-nav").on("click", toggler, function (e) {
        var selected = $(this).hasClass('slide-active');
        jQuery('#slidemenu').stop().animate({
            left: selected ? menuneg : '0px'
        });
        jQuery('#navbar-height-col').stop().animate({
            left: selected ? slideneg : '0px'
        });
        jQuery(pagewrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });
        jQuery(navigationwrapper).stop().animate({
            left: selected ? '0px' : slidewidth
        });
        jQuery(this).toggleClass('slide-active', !selected);
        jQuery('#slidemenu').toggleClass('slide-active');
        jQuery('#page-content, .navbar, body, .navbar-header').toggleClass('slide-active');
    });
    var selected = '#slidemenu, #page-content, body, .navbar, .navbar-header';
    jQuery(window).on("resize", function () {
        if (jQuery(window).width() > 767 && $('.navbar-toggle').is(':hidden')) {
            jQuery(selected).removeClass('slide-active');
        }
    });
	
	jQuery('.lp_price_trigger_checkout input').on('click', function($){
		var taxEnable = jQuery(this).data('taxenable');
		plantitle = jQuery(this).data('title');
		planprice = jQuery(this).data('planprice');
		taxprice = '';
		totalprice = '';
		if(taxEnable=="1"){
			taxrate = jQuery('.lp_price_trigger_checkout input').data('taxrate');
			taxprice = (taxrate/100)*planprice;
			taxprice = taxprice.toFixed(2);
			jQuery('input[name="listings_tax_price"]').attr('value', taxprice);
			totalprice = parseFloat(planprice) + parseFloat(taxprice);
			totalprice = totalprice.toFixed(2);
			jQuery('span#lp_price_plan').text(plantitle);
			jQuery('span#lp_price_plan_price').text(planprice);
			jQuery('span#lp_tax_price').text(taxprice);
			jQuery('span#lp_price_subtotal').text(totalprice);
			jQuery('.lp_section_inner .lp_billing_total').show(400);
		}
		else{
			totalprice = parseFloat(planprice);
			jQuery('span#lp_price_plan').text(plantitle);
			jQuery('span#lp_price_plan_price').text(planprice);
			jQuery('span#lp_price_subtotal').text(totalprice);
		}
		
	});
	
	if(jQuery('form#register .check_policy').is('.termpolicy')){
		jQuery("input#lp_usr_reg_btn").prop('disabled',true);
		jQuery('.check_policy').on('click', function(){
			if(jQuery('#check_policy').is(':checked')){
				jQuery("input#lp_usr_reg_btn").prop('disabled',false);
			}
			else{
				jQuery("input#lp_usr_reg_btn").prop('disabled',true);
			}
		});
	}
	
	if(jQuery('.blue-section .check_policy').is('.termpolicy')){
		jQuery("#listingsubmitBTN").prop('disabled',true);
		jQuery("#listingsubmitBTN").addClass('dissablebutton');
		jQuery('.check_policy').on('click', function(){
			if(jQuery('#policycheck').is(':checked')){
				jQuery("#listingsubmitBTN").prop('disabled',false);
				jQuery("#listingsubmitBTN").removeClass('dissablebutton');
			}
			else{
				jQuery("#listingsubmitBTN").prop('disabled',true);
				jQuery("#listingsubmitBTN").addClass('dissablebutton');
			}
		});
	}
});

jQuery( window ).ready(function() {
	
	if(jQuery('.header-container').hasClass('.lp-vedio-bg')){
		jQuery( '#lp_vedio' ).play();
	}	
	if(jQuery('input').is('.rating-tooltip')){
		
		jQuery('.rating-tooltip').rating({
		  extendSymbol: function (rate) {
			jQuery(this).tooltip({
			  container: 'body',
			  placement: 'bottom',
			  title: 'Rate ' + rate
			});
		  }
		});
	
	}
	
});

jQuery(document).ready(function($){
	
	
	if(jQuery('.lp-home-banner-contianer').is('.lp-home-banner-with-loc')){
		
		var locType = jQuery('.lp_auto_loc_container h1').data('locnmethod');
		
		var apiType = jQuery('#page').data('ipapi');
		
		if(locType=="withip"){
			if(apiType==="geo_ip_db"){
				$.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?') 
				 .done (function(location)
				 {
					 var locc = location.city;
					 if(locc == null){
						 
					 }else{
						 jQuery('.lp-dyn-city').text(location.city);
					 }
					
				 });
			}
			else{
				jQuery.get("https://ipapi.co/json", function(location) {
					var locc = location.city;
					 if(locc == null){
						 
					 }else{
						 jQuery('.lp-dyn-city').text(location.city);
					 }
				}, "json");
			}
			
		}
		else if(locType=="withgps"){
			checkLocation();
			function checkLocation(){
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(getLocation,locationFailed);
					//document.write("you have geolocation");
				}
				else {
					document.write("you don't have geolocation");
				}
			}//ends checkLocation()

			function getLocation(position){
				var latitud = position.coords.latitude;
				var longitud = position.coords.longitude;
				var exactitud = position.coords.accuracy;
				
				$.get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' + latitud + ',' + longitud + '&sensor=true', function(data) {
					jQuery('.lp-dyn-city').text(data.results[2].address_components[0].long_name);
				});

				//alert("latitud: " + latitud + " longitud: " + longitud + " exactitud: " + exactitud);
				//document.write("we received your location");
			}   
			function locationFailed(){
				document.write("we didn't get your location. Please check your settings");
			}
			
		}
	}
	
});
function hexToRGB(hexStr) {
    var col = {};
    col.r = parseInt(hexStr.substr(1,2),16);
    col.g = parseInt(hexStr.substr(3,2),16);
    col.b = parseInt(hexStr.substr(5,2),16);
    return col;
}

/* for recurring stripe */
jQuery(document).ready(function(){
	var plantype = '';
	var recurringtext = '';
	var recurringhtml = '';
	var $thislisting = '';
	var $thisplan = '';
	var $recurringon = '';
	$recurringon = jQuery('form#listings_checkout').data('recurring');
	if($recurringon==="yes"){
		jQuery('#listings_checkout input[type=radio]').on('change', function($){
			if( jQuery('#listings_checkout input[name=listing_id]').is(':checked') && jQuery('#listings_checkout input[name=plan]').is(':checked') ){

				$thislisting = jQuery('#listings_checkout input[name=listing_id]:checked');
				$thisplan = jQuery('#listings_checkout input[name=plan]:checked').val();
				plantype = $thislisting.closest('.lp-user-listings').data('plantype');
				if(plantype==="Pay Per Listing"){
					
					recurringtext = $thislisting.closest('.lp-user-listings').data('recurringtext');
					recurringhtml = '<div class="checkbox"><input type="checkbox" id="listing-recurring-recurrsive" name="lp-recurring-option" value="yes"><label for="listing-recurring-recurrsive">'+recurringtext+'</label></div>';
						if($thisplan==="stripe"){
							jQuery('div.lp-recurring-button-wrap').html( recurringhtml );
						}
						else{
							jQuery('div.lp-recurring-button-wrap').html('');
						}
				}
				else{
					jQuery('div.lp-recurring-button-wrap').html('');
				}
			}
			else{
				jQuery('div.lp-recurring-button-wrap').html('');
			}
			
			
		});
	}
	
	/* for dynamic location */
	if (jQuery('input#cities').length) {
		jQuery('input#cities').cityAutocomplete();
	}
	if (jQuery('input#citiess').length) {
		jQuery('input#citiess').cityAutocomplete();
	}
	
	jQuery(document).on('click', function(e) {
		var target = e.target;
		if (!jQuery(target).is('.help') ) {
			if(jQuery('input#citiess').length){
				var isseleted = jQuery('input#citiess').data('isseleted');
				if(isseleted == false){
					jQuery('input#citiess').val('');
				}
			}
			
		}
	});
	
	if (jQuery('input#citiess').length) {
		jQuery('#citiess').on('input', function(){
			jQuery(this).data('isseleted', false);
		});
	}
	
})
/* for recurring stripe */
jQuery(document).ready(function($){
	jQuery('#select-plan-form .select-plan-form input[name=plans-posts]').on('click', function(){
		jQuery("a.lp_change_plan_action").hide('');
		jQuery("div.lp-action-div form").hide('');
	});
});

/* for range slider */
var nearmeunit = jQuery("#lp-find-near-me").data('nearmeunit');
jQuery('#distance_range').bootstrapSlider({
	
	formatter: function(value) {
		return value+' ' + nearmeunit;
	},
	tooltip: 'always'
});

/* for show click on div radius */
jQuery('li.lp-tooltip-outer').on('click', function(){
	var $this = jQuery(this);
	jQuery('.lp-tooltip-div').removeClass('active');
	$this.find('.lp-tooltip-div').addClass('active');
	
});

/* for hide div on outer click to divs */
jQuery(document).mouseup(function(e) 
{
    var container = jQuery(".lp-tooltip-div");
    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        jQuery('.lp-tooltip-div').removeClass('active');
    }
	
	var containerr = jQuery(".lp-tooltip-div-hidden");
	if (!containerr.is(e.target) && containerr.has(e.target).length === 0) 
    {
        jQuery('.lp-tooltip-div-hidden').removeClass('active');
    }
	
	var foodmenucontainer = jQuery(".hotel-menu .inner-menu");
	if (!foodmenucontainer.is(e.target) && foodmenucontainer.has(e.target).length === 0) 
    {
		jQuery(".hotel-menu").fadeOut();
	}
	
	
});

jQuery("li.lp-tooltip-outer").hover(function() {
	var $this = jQuery(this);
	jQuery('.lp-tooltip-div').removeClass('active');
	jQuery('.lp-tooltip-div-hidden').removeClass('active');
	$this.find('.lp-tooltip-div').addClass('active');
	if($this.find('a.near-me-btn').hasClass('active')){
		jQuery('.lp-tooltip-div-hidden').addClass('active');
	}
	
});

/* for first tab auto active on listing detail page style 2 */
jQuery(document).ready(function($) {
	jQuery('.lp-detail-page-template-3 #reply-title2 ul li').first().addClass('active');
	jQuery('.lp-detail-page-template-3 .detail-page2-tab-content .tab-pane').first().addClass('active');
	
	/* app view search dumm loader */
	jQuery(document).on('click', '.listing-app-view .app-view-filters .close', function(){
		
		var docHeight = jQuery( document ).height();
		jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
		jQuery('#full-overlay').css('height',docHeight+'px');
		jQuery('#full-overlay').addClass('content-loading');
		var timer = '';
		 function lpcloseloadnow(){
			jQuery('#full-overlay').remove();
			jQuery('#full-overlay').removeClass('content-loading');
			clearTimeout(timer);
		}
		timer = setTimeout(lpcloseloadnow, 2000);

	});
	
	/* multiselect for google location  */
	jQuery(document).on('click','.city-autocomplete .help', function(){
		var $thisSelected = jQuery(this).text();
		var $thisSelecteds = $thisSelected.split(",")[0];
		var $selectLocationData = '<div class="lpsinglelocselected '+$thisSelected+'">'+$thisSelected+'<i class="fa fa-times lp-removethisloc"></i><input type="hidden" name="location[]" value="'+$thisSelecteds+'"></div>';
		jQuery( $selectLocationData ).appendTo( ".lp-selected-locs" );
		
		if(jQuery('div').hasClass('lp-selected-locs')){
			jQuery("input#citiess").val('');
		}
		
	});
	
	jQuery(document).on('click','.lp-removethisloc', function(){
		jQuery(this).closest('.lpsinglelocselected').remove();
	});
	
	jQuery('.top-search-form .lp-search-btn-header .lp-search-btn').on('click', function(){
		var locvals=$.trim($("input#cities").val());
		if(locvals.length>0)
		{}else{
			jQuery('input[name="lp_s_loc"]').val('');
		}
	});
	
	
	/* when google location and user don't select the suggestions and hit enters */
	jQuery('input#cities').on('change', function(){
		jQuery('input[name=lp_s_loc]').val(jQuery(this).val());
	});
	
	/* overlay close on cross click */
	jQuery('.md-close.widget-map-click').on('click', function(e){
		jQuery('#full-overlay').css('height','0px');
	});

	
});


function lpshowsidemap() {
		if(jQuery('#map').is('.mapSidebar')) {
			jQuery( "<div class='sidemarpInside'></div>" ).appendTo( jQuery( ".sidemap-fixed" ) );
			jQuery( ".sidemap-fixed .sidemarpInside" ).trigger('click');
		}
}
window.onload = lpshowsidemap;

/* for 1.2.7 */
jQuery(document).ready(function($){
	if(jQuery('form#registertmp .check_policyy').is('.termpolicy')){
		jQuery("input#lp-template-registerbtn").prop('disabled',true);
		jQuery('.check_policyy').on('click', function(){
			if(jQuery('#check_policyy').is(':checked')){
				jQuery("input#lp-template-registerbtn").prop('disabled',false);
			}
			else{
				jQuery("input#lp-template-registerbtn").prop('disabled',true);
			}
		});
	}
});
/* end for 1.2.7 */