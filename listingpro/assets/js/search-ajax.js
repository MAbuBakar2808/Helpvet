/* js for search by zaheer */
jQuery(document).ready(function($) {
	
	if(jQuery('ul.list-st-img li').hasClass('lp-listing-phone')){
		var $country = '';
		var $city = '';
		var $zip = '';
		$.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?') 
		 .done (function(location){
			 $country = location.country_name;
			 $city = location.city;
			 $zip = location.postal;
		 });
		 
		jQuery('ul.list-st-img li.lp-listing-phone a').on('click', function(){
			
			var $lpID = '';
			var $this = jQuery(this);
			$lpID = $this.data('lpid');
			
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_search_term_object.ajaxurl,
				data: { 
					'action': 'listingpro_phone_clicked',
					'lp-id':$lpID,
					'lp-country':$country,
					'lp-city':$city,
					'lp-zip':$zip,
					},
				success: function(data){
					
				}
			});
		});
	}
	/* on 11th may */
	if(jQuery('ul.list-st-img li').hasClass('lp-user-web')){
		var $country = '';
		var $city = '';
		var $zip = '';
		$.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?') 
		 .done (function(location){
			 $country = location.country_name;
			 $city = location.city;
			 $zip = location.postal;
		 });
		 
		jQuery('ul.list-st-img li.lp-user-web a').on('click', function(){
			
			var $lpID = '';
			var $this = jQuery(this);
			$lpID = $this.data('lpid');
			
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_search_term_object.ajaxurl,
				data: { 
					'action': 'listingpro_website_visit',
					'lp-id':$lpID,
					'lp-country':$country,
					'lp-city':$city,
					'lp-zip':$zip,
					},
				success: function(data){
					
				}
			});
		});
	}
	/* end on 11th may */
	
	jQuery('input.lp-search-btn').on('click', function(e){
		jQuery(this).next('i').removeClass('icons8-search');
		//jQuery(this).css('color', 'transparent');
		jQuery(this).css('cssText', 'background-image:url() !important; color: transparent');
		if(jQuery('img.searchloading').hasClass('loader-inner-header')){
			jQuery('img.loader-inner-header').css({
				'top': '15px',
				'left': '90%',
				'width': 'auto',
				'height': 'auto',
				'margin-left': '0px'
			});
		}
		
		jQuery('img.searchloading').css('display', 'block');
	});
	
	
	jQuery('form i.cross-search-q').on('click', function(){
		jQuery("form i.cross-search-q").css("display","none");
		jQuery('form .lp-suggested-search').val('');
		jQuery("img.loadinerSearch").css("display","block");
		var qString = '';
		
		jQuery.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajax_search_term_object.ajaxurl,
			data: { 
				'action': 'listingpro_suggested_search', 
				'tagID': qString, 
				},
			success: function(data){
				if(data){
					jQuery("#input-dropdown ul").empty();
					var resArray = [];
					if(data.suggestions.cats){
										jQuery.each(data.suggestions.cats, function(i,v) {
							
											resArray.push(v);
										
										});
									
								}
					jQuery('img.loadinerSearch').css('display','none');
					jQuery("#input-dropdown ul").append(resArray);
					myDropDown.css('display', 'block');
				}
			}
		});
					
	});
	
	var inputField = jQuery('.dropdown_fields');
	var inputTagField = jQuery('#lp_s_tag');
	var inputCatField = jQuery('#lp_s_cat');
	var myDropDown = jQuery("#input-dropdown");
	var myDropDown1 = jQuery("#input-dropdown ul li");
	var myDropOption = jQuery('#input-dropdown > option');
	var html = jQuery('html');
	var select = jQuery('.dropdown_fields, #input-dropdown > option');
	var lps_tag = jQuery('.lp-s-tag');
	var lps_cat = jQuery('.lp-s-cat');

    var length = myDropOption.length;
    inputField.on('click', function(event) {
		//event.preventDefault();
		myDropDown.attr('size', length);
		myDropDown.css('display', 'block');
		

		
		
	});
	
	//myDropDown1.on('click', function(event) {
    jQuery(document).on('click', '#input-dropdown ul li', function(event) {
		
        myDropDown.attr('size', 0);
        var dropValue =  jQuery(this).text();
        var tagVal =  jQuery(this).data('tagid');
        var catVal =  jQuery(this).data('catid');
        var moreVal =  jQuery(this).data('moreval');
        inputField.val(dropValue);
        inputTagField.val(tagVal);
        inputCatField.val(catVal);
		if( tagVal==null && catVal==null && moreVal!=null){
			inputField.val(moreVal);
		}
        jQuery("form i.cross-search-q").css("display","block");
        myDropDown.css('display', 'none');
    });

    html.on('click', function(event) {
		//event.preventDefault();
        myDropDown.attr('size', 0);
         myDropDown.css('display', 'none');
	});

    select.on('click', function(event) {
		event.stopPropagation();
	});
	
	var resArray = [];
	var newResArray = [];
	var bufferedResArray = [];
	var prevQString = '?';
	
	//inputField.on('input', function(){
		
	function trimAttributes(node) {
        jQuery.each(node.attributes, function() {
            var attrName = this.name;
            var attrValue = this.value;
            // remove attribute name start with "on", possible unsafe,
            // for example: onload, onerror...
            //
            // remvoe attribute value start with "javascript:" pseudo protocol, possible unsafe,
            // for example href="javascript:alert(1)"
            if (attrName.indexOf('on') == 0 || attrValue.indexOf('javascript:') == 0) {
                jQuery(node).removeAttr(attrName);
            }
        });
    }
 
    function sanitize(html) {
		   var output = jQuery($.parseHTML('<div>' + html + '</div>', null, false));
		   output.find('*').each(function() {
			trimAttributes(this);
		   });
		   return output.html();
	}
	//inputField.bind('change paste keyup', function(){
	inputField.on('input', function(){
		$this = jQuery(this);
		var qString = sanitize(this.value);
		
		noresultMSG = jQuery(this).data('noresult');
		jQuery("#input-dropdown ul").empty();
		jQuery("#input-dropdown ul li").remove();
		prevQuery = $this.data('prev-value');
		$this.data( "prev-value", qString.length );
		
		
		if(qString.length==0){
			
			defCats = jQuery('#def-cats').html();
			myDropDown.css('display', 'none');
			jQuery("#input-dropdown ul").empty();
			
			jQuery("#input-dropdown ul").append(defCats);
			myDropDown.css('display', 'block');
			$this.data( "prev-value", qString.length );
			
		}
		else if( (qString.length==1 && prevQString!=qString) || (qString.length==1 && prevQuery < qString.length) ){
			
						myDropDown.css('display', 'none');
						jQuery("#input-dropdown ul").empty();
						resArray = [];
					//jQuery('#selector').val().length
					jQuery("form i.cross-search-q").css("display","none");
					jQuery("img.loadinerSearch").css("display","block");
					//jQuery(this).addClass('loaderimg');
					jQuery.ajax({
						type: 'POST',
						dataType: 'json',
						url: ajax_search_term_object.ajaxurl,
						data: { 
							'action': 'listingpro_suggested_search', 
							'tagID': qString, 
							},
						success: function(data){
							if(data){
								
									if(data.suggestions.tag|| data.suggestions.tagsncats || data.suggestions.cats || data.suggestions.titles){
											
											if(data.suggestions.tag){
													jQuery.each(data.suggestions.tag, function(i,v) {
														resArray.push(v);
													});
												
											}
											
											if(data.suggestions.tagsncats){
													jQuery.each(data.suggestions.tagsncats, function(i,v) {
														resArray.push(v);
													});
											
											}
											
												
											if(data.suggestions.cats){
												jQuery.each(data.suggestions.cats, function(i,v) {
														
														resArray.push(v);
													
													});
													
												if(data.suggestions.tag==null && data.suggestions.tagsncats==null && data.suggestions.titles==null ){
													resArray = resArray;
												}
												else{
												}
														
													
												
											}
											
											if(data.suggestions.titles){
												jQuery.each(data.suggestions.titles, function(i,v) { 		
													
														resArray.push(v);
													
												});
												
											}
										
									}
									else{
											if(data.suggestions.more){
												jQuery.each(data.suggestions.more, function(i,v) {
													resArray.push(v);
												});
											
										}
									}
									
									prevQString = data.tagID;
									
									jQuery('img.loadinerSearch').css('display','none');
									if(jQuery('form #select').val() == ''){
										jQuery("form i.cross-search-q").css("display","none");
									}
									else{
										jQuery("form i.cross-search-q").css("display","block");
									}
									
									
									bufferedResArray = resArray;
									filteredRes = [];
									qStringNow = jQuery('.dropdown_fields').val();
									jQuery.each( resArray, function( key, value ) {
										
										if(jQuery(value).find('a').length=="1"){
											rText = jQuery(value).find('a').text();
										}
										else{
											rText = jQuery(value).text();
										}
										
										if (rText.substr(0, qStringNow.length).toUpperCase() == qStringNow.toUpperCase()) {
											filteredRes.push(value);
										}
										
										
										
									});
									
									
									
									if( filteredRes.length > 0){
										myDropDown.css('display', 'none');
										jQuery("#input-dropdown ul").empty();
										
										jQuery("#input-dropdown ul").append(filteredRes);
										myDropDown.css('display', 'block');
										$this.data( "prev-value", qString.length );
										
									}
									
									else if( filteredRes.length < 1 && qStringNow.length < 2){
										myDropDown.css('display', 'none');
										jQuery("#input-dropdown ul").empty();
										jQuery('#input-dropdown ul li').remove();
										$mResults = '<strong>'+noresultMSG+' </strong>';
										$mResults = $mResults+qString;
										var defRes = '<li class="lp-wrap-more-results" data-moreval="'+qString+'">'+$mResults+'</li>';
										newResArray.push(defRes);
										jQuery("#input-dropdown ul").append(newResArray);
										myDropDown.css('display', 'block');
										$this.data( "prev-value", qString.length );
									}
									
									
										
									
									
								}
							}
						
					});
		}
		/* get results from buffered data */
		else{
			newResArray = [];
			myDropDown.css('display', 'none');
			jQuery("#input-dropdown ul").empty();
			jQuery.each( bufferedResArray, function( key, value ) {
			  var stringToCheck = jQuery(value).find('span').first().text();
			  if (stringToCheck.substr(0, qString.length).toUpperCase() == qString.toUpperCase()) {
					newResArray.push(value);
			  }
			});
			if(newResArray.length == 0){
				jQuery("#input-dropdown ul").empty();
				jQuery('#input-dropdown ul li').remove();
				$mResults = '<strong>'+noresultMSG+' </strong>';
				$mResults = $mResults+qString;
				var defRes = '<li class="lp-wrap-more-results" data-moreval="'+qString+'">'+$mResults+'</li>';
				newResArray.push(defRes);
			}
			
			jQuery("#input-dropdown ul").append(newResArray);
			myDropDown.css('display', 'block');
		}
	});
	
	/* ******************************************************** */
    
    
});
/* end js for search by zaheer */



jQuery(document).ready(function($){
	
	jQuery(".lp-search-cats-filter-dropdown").on('click', function(){
		jQuery('.lp-tooltip-div').css({
			'opacity': '0',
			'visibility': 'hidden',
			'top': 'auto',
			'z-index': '0'
		});
	});

	
	jQuery("select#searchcategory").change(function() {
		$thiscat = jQuery(this);
		jQuery('.tags-area').remove();
		jQuery('.lp-filter-pagination-ajx').remove();
		jQuery(".chosen-select").val('').trigger('chosen:updated');
		jQuery("#searchtags").prop('disabled', true).trigger('chosen:updated');
		listStyle = jQuery("#page").data('list-style');
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_search_term_object.ajaxurl,
				data: { 
					'action': 'ajax_search_term', 
					'term_id': $thiscat.val(), 
					'list_style': listStyle 
					},
				success: function(data){
					if(data){
							jQuery(".search-row .form-inline").after( data.html );
							jQuery(".lp-features-filter").css( 'opacity','1' );
						
					}
				}
			});
	});


	jQuery("select#searchcategory").change(function() {
		var $thiscat = jQuery(this);
		var docHeight = jQuery( document ).height();
		jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
		jQuery('#full-overlay').css('height',docHeight+'px');
		jQuery('#content-grids').html(' ');
		jQuery('.lp-filter-pagination-ajx').remove();
		jQuery('#content-grids').addClass('content-loading');
		jQuery('.map-view-list-container').remove();
		jQuery('.lp-filter-pagination').hide();
		listStyle = jQuery("#page").data('list-style');
		var inexpensive='';
		moderate = '';
		pricey = '';
		ultra = '';
		averageRate = '';
		mostRewvied = '';
		listing_openTime = '';
		mostViewed = '';
		
		inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
		moderate = jQuery('.currency-signs #two').find('.active').data('price');
		pricey = jQuery('.currency-signs #three').find('.active').data('price');
		ultra = jQuery('.currency-signs #four').find('.active').data('price');
		
		mostViewed = jQuery('.search-filters li#mostviewed').find('.active').data('value');
		averageRate = jQuery('.search-filters li#listingRate').find('.active').data('value');
		mostRewvied = jQuery('.search-filters li#listingReviewed').find('.active').data('value');
		listing_openTime = jQuery('.search-filters li.listing_openTime').find('.active').data('value');
		
		var tags_name = [];
		tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
		  return jQuery(this).val();
		}).get();
		
		if(tags_name.length > 0){
		}else{
		   tags_name.push(jQuery('#check_featuretax').val());
		}
		skeyword = jQuery('input#lp_current_query').val();
		var clatval = jQuery('#searchform input[name=clat]').val();
		var clongval = jQuery('#searchform input[name=clong]').val();
		
		if(clatval && clongval){
		}else{
			clatval =  jQuery("#pac-input").attr( 'data-lat' );
			clongval = jQuery("#pac-input").attr( 'data-lng' );
		}
		
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_search_term_object.ajaxurl,
				data: { 
					'action': 'ajax_search_tags', 
					'lpstag': jQuery("#lpstag").val(), 
					'cat_id': $thiscat.val(),
					'loc_id': jQuery("#lp_search_loc").val(),
					'inexpensive':inexpensive,
					'moderate':moderate,
					'pricey':pricey,
					'ultra':ultra,
					'averageRate':averageRate,
					'mostRewvied':mostRewvied,
					'mostviewed':mostViewed,
					'listing_openTime':listing_openTime,
					'tag_name':tags_name,
					'list_style': listStyle,
					'skeyword': skeyword,
					'clat': clatval,
					'clong': clongval,
					'my_bounds_ne_lat' 	: jQuery("#pac-input").attr( 'data-ne-lat' ),
					'my_bounds_ne_lng' 	: jQuery("#pac-input").attr( 'data-ne-lng' ),
					'my_bounds_sw_lat' 	: jQuery("#pac-input").attr( 'data-sw-lat' ),
					'my_bounds_sw_lng' 	: jQuery("#pac-input").attr( 'data-sw-lng' ),
					'data_zoom' 	: jQuery( '#pac-input' ).attr( 'data-zoom'),
					'distance_range' 	: jQuery("#distance_range").val()
					},
				success: function(data){
					jQuery('#full-overlay').remove();
					if(data){
						listing_update(data);
						lp_append_distance_div();
						
					}
				}
			});
	});

	jQuery(document).on('change','.tags-area input[type=checkbox]',function(e){
		var docHeight = jQuery( document ).height();
		jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
		jQuery('#full-overlay').css('height',docHeight+'px');
		var tags_name = [];
		tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
		  return jQuery(this).val();
		}).get();
		
		if(tags_name.length > 0){
		}else{
		   tags_name.push(jQuery('#check_featuretax').val());
		}
		
		jQuery('.lp-filter-pagination').hide();
		
		
		jQuery('#content-grids').html(' ');
		jQuery('.lp-filter-pagination-ajx').remove();
		jQuery('#content-grids').addClass('content-loading');
		jQuery('.map-view-list-container').remove();
		listStyle = jQuery("#page").data('list-style');
		var inexpensive='';
		moderate = '';
		pricey = '';
		ultra = '';
		averageRate = '';
		mostRewvied = '';
		listing_openTime = '';
		mostViewed = '';
		
		inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
		moderate = jQuery('.currency-signs #two').find('.active').data('price');
		pricey = jQuery('.currency-signs #three').find('.active').data('price');
		ultra = jQuery('.currency-signs #four').find('.active').data('price');
		
		mostViewed = jQuery('.search-filters li#mostviewed').find('.active').data('value');
		averageRate = jQuery('.search-filters li#listingRate').find('.active').data('value');
		mostRewvied = jQuery('.search-filters li#listingReviewed').find('.active').data('value');
		listing_openTime = jQuery('.search-filters li.listing_openTime').find('.active').data('value');
		
		skeyword = jQuery('input#lp_current_query').val();
		var clatval = jQuery('#searchform input[name=clat]').val();
		var clongval = jQuery('#searchform input[name=clong]').val();
		
		if(clatval && clongval){
		}else{
			clatval =  jQuery("#pac-input").attr( 'data-lat' );
			clongval = jQuery("#pac-input").attr( 'data-lng' );
		}
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_search_term_object.ajaxurl,
				data: { 
					'action': 'ajax_search_tags', 
					'lpstag': jQuery("#lpstag").val(), 
					'cat_id': jQuery("#searchform select#searchcategory").val(),
					'loc_id': jQuery("#lp_search_loc").val(),
					'inexpensive':inexpensive,
					'moderate':moderate,
					'pricey':pricey,
					'ultra':ultra,
					'averageRate':averageRate,
					'mostRewvied':mostRewvied,
					'mostviewed':mostViewed,
					'listing_openTime':listing_openTime,					
					'tag_name':tags_name,					
					'list_style': listStyle, 
					'skeyword': skeyword, 
					'clat': clatval, 
					'clong': clongval,
					'my_bounds_ne_lat' 	: jQuery("#pac-input").attr( 'data-ne-lat' ),
					'my_bounds_ne_lng' 	: jQuery("#pac-input").attr( 'data-ne-lng' ),
					'my_bounds_sw_lat' 	: jQuery("#pac-input").attr( 'data-sw-lat' ),
					'my_bounds_sw_lng' 	: jQuery("#pac-input").attr( 'data-sw-lng' ),
					'data_zoom' 	: jQuery( '#pac-input' ).attr( 'data-zoom'),
					'distance_range' 	: jQuery("#distance_range").val()
					},
				success: function(data){
					jQuery('#full-overlay').remove();
					if(data){
						listing_update(data);
						lp_append_distance_div();
						
					}
				}
			});
			e.preventDefault();
	});


	
	/* =========================================================== */
	jQuery("ul#select-lp-more-filter li a, .currency-signs ul li a").on('click', function(event) {
		var $this = jQuery(this);
		$this.toggleClass('active');
		var docHeight = jQuery( document ).height();
		jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
		jQuery('#full-overlay').css('height',docHeight+'px');
		event.preventDefault();
		jQuery('.lp-filter-pagination').hide();
		jQuery('#content-grids').html(' ');
		jQuery('.lp-filter-pagination-ajx').remove();
		jQuery('#content-grids').addClass('content-loading');
		jQuery('.map-view-list-container').remove();
		var inexpensive='';
		moderate = '';
		pricey = '';
		ultra = '';
		averageRate = '';
		mostRewvied = '';
		listing_openTime = '';
		mostViewed = '';
		
		inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
		moderate = jQuery('.currency-signs #two').find('.active').data('price');
		pricey = jQuery('.currency-signs #three').find('.active').data('price');
		ultra = jQuery('.currency-signs #four').find('.active').data('price');
		
		mostViewed = jQuery('.search-filters li#mostviewed').find('.active').data('value');
		averageRate = jQuery('.search-filters li#listingRate').find('.active').data('value');
		mostRewvied = jQuery('.search-filters li#listingReviewed').find('.active').data('value');
		listing_openTime = jQuery('.search-filters li.listing_openTime').find('.active').data('value');
		
		var tags_name = [];
		tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
		  return jQuery(this).val();
		}).get();
		
		if(tags_name.length > 0){
		}else{
		   tags_name.push(jQuery('#check_featuretax').val());
		}
		
		skeyword = jQuery('input#lp_current_query').val();
		var clatval = jQuery('#searchform input[name=clat]').val();
		var clongval = jQuery('#searchform input[name=clong]').val();
		
		if(clatval && clongval){
		}else{
			clatval =  jQuery("#pac-input").attr( 'data-lat' );
			clongval = jQuery("#pac-input").attr( 'data-lng' );
		}
		
		listStyle = jQuery("#page").data('list-style');
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_search_term_object.ajaxurl,
				data: { 
					'action': 'ajax_search_tags', 
					'inexpensive':inexpensive,
					'moderate':moderate,
					'pricey':pricey,
					'ultra':ultra,
					'averageRate':averageRate,
					'mostRewvied':mostRewvied,
					'mostviewed':mostViewed,
					'listing_openTime':listing_openTime,
					'lpstag': jQuery("#lpstag").val(),
					'tag_name':tags_name,
					'cat_id': jQuery("#searchform select#searchcategory").val(), 
					'loc_id': jQuery("#lp_search_loc").val(),
					'list_style': listStyle, 
					'skeyword': skeyword, 
					'clat': clatval, 
					'clong': clongval,
					'my_bounds_ne_lat' 	: jQuery("#pac-input").attr( 'data-ne-lat' ),
					'my_bounds_ne_lng' 	: jQuery("#pac-input").attr( 'data-ne-lng' ),
					'my_bounds_sw_lat' 	: jQuery("#pac-input").attr( 'data-sw-lat' ),
					'my_bounds_sw_lng' 	: jQuery("#pac-input").attr( 'data-sw-lng' ),
					'data_zoom' 	: jQuery( '#pac-input' ).attr( 'data-zoom'),
					'distance_range' 	: jQuery("#distance_range").val()
					},
				success: function(data) {
					jQuery('#full-overlay').remove();
					if(data){
						listing_update(data);
						lp_append_distance_div();
							
					}
				  } 
			});
	});
	
	
	
	/* ===============================for best match by  z============================ */
	jQuery("li.lp-search-best-matches").on('click', function(event) {
		var $this = jQuery( this );
		var docHeight = jQuery( document ).height();
		jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
		jQuery('#full-overlay').css('height',docHeight+'px');
		event.preventDefault();
		jQuery(this).toggleClass('active');
		jQuery('.lp-filter-pagination').hide();
		jQuery('#content-grids').html(' ');
		jQuery('.lp-filter-pagination-ajx').remove();
		jQuery('#content-grids').addClass('content-loading');
		jQuery('.map-view-list-container').remove();
		var inexpensive='';
		moderate = '';
		pricey = '';
		ultra = '';
		averageRate = '';
		mostRewvied = '';
		listing_openTime = '';
		mostViewed = '';
		
		
		inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
		moderate = jQuery('.currency-signs #two').find('.active').data('price');
		pricey = jQuery('.currency-signs #three').find('.active').data('price');
		ultra = jQuery('.currency-signs #four').find('.active').data('price');
		
		$this.find('a').toggleClass('active');
		if($this.find('a').hasClass('active')){
			jQuery('.search-filters li#mostviewed a').addClass("active");
			jQuery('.search-filters li#listingRate a').addClass("active");
			jQuery('.search-filters li#listingReviewed a').addClass("active");
			jQuery('.search-filters li.listing_openTime a').addClass("active");
			jQuery('.search-filters li.listing_openTime').find('.active').data('value', 'open');
		}
		else{
			jQuery('.search-filters li#mostviewed a').removeClass("active");
			jQuery('.search-filters li#listingRate a').removeClass("active");
			jQuery('.search-filters li#listingReviewed a').removeClass("active");
			
			jQuery('.search-filters li.listing_openTime a').removeClass("active");
			jQuery('.search-filters li.listing_openTime a').data('value', 'close');
		}
		
		
		
		mostViewed = jQuery('.search-filters li#mostviewed').find('.active').data('value');
		averageRate = jQuery('.search-filters li#listingRate').find('.active').data('value');
		mostRewvied = jQuery('.search-filters li#listingReviewed').find('.active').data('value');
		listing_openTime = jQuery('.search-filters li.listing_openTime').find('.active').data('value');
		
		var tags_name = [];
		tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
		  return jQuery(this).val();
		}).get();
		
		if(tags_name.length > 0){
		}else{
		   tags_name.push(jQuery('#check_featuretax').val());
		}
		
		skeyword = jQuery('input#lp_current_query').val();
		var clatval = jQuery('#searchform input[name=clat]').val();
		var clongval = jQuery('#searchform input[name=clong]').val();
		
		if(clatval && clongval){
		}else{
			clatval =  jQuery("#pac-input").attr( 'data-lat' );
			clongval = jQuery("#pac-input").attr( 'data-lng' );
		}
		
		listStyle = jQuery("#page").data('list-style');
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_search_term_object.ajaxurl,
				data: { 
					'action': 'ajax_search_tags', 
					'inexpensive':inexpensive,
					'moderate':moderate,
					'pricey':pricey,
					'ultra':ultra,
					'averageRate':averageRate,
					'mostRewvied':mostRewvied,
					'listing_openTime':listing_openTime,
					'mostviewed':mostViewed,
					'lpstag': jQuery("#lpstag").val(),
					'tag_name':tags_name,
					'cat_id': jQuery("#searchform select#searchcategory").val(), 
					'loc_id': jQuery("#lp_search_loc").val(),
					'list_style': listStyle, 
					'skeyword': skeyword, 
					'clat': clatval, 
					'clong': clongval,
					'my_bounds_ne_lat' 	: jQuery("#pac-input").attr( 'data-ne-lat' ),
					'my_bounds_ne_lng' 	: jQuery("#pac-input").attr( 'data-ne-lng' ),
					'my_bounds_sw_lat' 	: jQuery("#pac-input").attr( 'data-sw-lat' ),
					'my_bounds_sw_lng' 	: jQuery("#pac-input").attr( 'data-sw-lng' ),
					'data_zoom' 	: jQuery( '#pac-input' ).attr( 'data-zoom'),
					'distance_range' 	: jQuery("#distance_range").val()
					},
				success: function(data) {
					jQuery('#full-overlay').remove();
					if(data){
						listing_update(data);
						lp_append_distance_div();
							
					}
				  } 
			});
	});
	
	
	/* =============================by saj br============================== */
	
	jQuery(document).on('change', '.search-filter-attr input[type="checkbox"]#bestmatch', function(e){
        if(jQuery('.search-filter-attr input[type="checkbox"]#bestmatch').is(':checked')){
            jQuery('input[type="checkbox"].listing_openTime').addClass('active');
            jQuery('.search-filter-attr input[type="checkbox"]#listingRate').addClass('active');
            jQuery('.search-filter-attr input[type="checkbox"]#mostviewed').addClass('active');
            jQuery('.search-filter-attr input[type="checkbox"]#listingReviewed').addClass('active');
            jQuery('input[type="checkbox"].listing_openTime').prop('checked', true);
            jQuery('.search-filter-attr input[type="checkbox"]#listingRate').prop('checked', true);
            jQuery('.search-filter-attr input[type="checkbox"]#mostviewed').prop('checked', true);
            jQuery('.search-filter-attr input[type="checkbox"]#listingReviewed').prop('checked', true);
        }else{
            jQuery('input[type="checkbox"].listing_openTime').removeClass('active');
            jQuery('.search-filter-attr input[type="checkbox"]#listingRate').removeClass('active');
            jQuery('.search-filter-attr input[type="checkbox"]#mostviewed').removeClass('active');
            jQuery('.search-filter-attr input[type="checkbox"]#listingReviewed').removeClass('active');
            jQuery('input[type="checkbox"].listing_openTime').prop('checked', false);
            jQuery('.search-filter-attr input[type="checkbox"]#listingRate').prop('checked', false);
            jQuery('.search-filter-attr input[type="checkbox"]#mostviewed').prop('checked', false);
            jQuery('.search-filter-attr input[type="checkbox"]#listingReviewed').prop('checked', false);
        }
        var docHeight = jQuery( document ).height();
        jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
        jQuery('#full-overlay').css('height',docHeight+'px');
        event.preventDefault();
        jQuery(this).toggleClass('active');
        jQuery('.lp-filter-pagination').hide();
        jQuery('#content-grids').html(' ');
        jQuery('.lp-filter-pagination-ajx').remove();
        jQuery('#content-grids').addClass('content-loading');
		jQuery('.map-view-list-container').remove();
        var inexpensive='';
        moderate = '';
        pricey = '';
        ultra = '';
        averageRate = '';
        mostRewvied = '';
        listing_openTime = '';
        mostViewed = '';
        inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
        moderate = jQuery('.currency-signs #two').find('.active').data('price');
        pricey = jQuery('.currency-signs #three').find('.active').data('price');
        ultra = jQuery('.currency-signs #four').find('.active').data('price');
        if( jQuery( '.search-filter-attr input[type="checkbox"]#listingRate' ).hasClass('active') )
        {
            averageRate = jQuery( '.search-filter-attr input[type="checkbox"]#listingReviewed' ).val();
        }
        if( jQuery( '.search-filter-attr input[type="checkbox"]#listingRate' ).hasClass('active') )
        {
            mostRewvied = jQuery( '.search-filter-attr input[type="checkbox"]#listingReviewed' ).val();
        }
        if( jQuery( '.search-filter-attr input[type="checkbox"]#mostviewed' ).hasClass('active') )
        {
            mostviewed = jQuery( '.search-filter-attr input[type="checkbox"]#mostviewed' ).val();
        }
        if( jQuery( '.search-filter-attr input[type="checkbox"].listing_openTime' ).hasClass('active') )
        {
            listing_openTime = jQuery( '.search-filter-attr input[type="checkbox"].listing_openTime' ).val();
        }
        if( jQuery(this).hasClass('active') ){
            jQuery(this).parent('label').children('.app-filter-loader').addClass('app-filter-loader-active').show().html('<i class="fa fa-spinner" aria-hidden="true"></i>');
        }
        else
        {
            jQuery(this).parent('label').children('.app-filter-loader').hide().html('<i class="fa fa-spinner" aria-hidden="true"></i>');
        }
        var tags_name = [];
        tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
            return jQuery(this).val();
        }).get();
		
		if(tags_name.length > 0){
		}else{
		   tags_name.push(jQuery('#check_featuretax').val());
		}
		
        skeyword = jQuery('input#lp_current_query').val();
        listStyle = jQuery("#page").data('list-style');
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_search_term_object.ajaxurl,
            data: {
                'action': 'ajax_search_tags',
                'inexpensive':inexpensive,
                'moderate':moderate,
                'pricey':pricey,
                'ultra':ultra,
                'averageRate':averageRate,
                'mostRewvied':mostRewvied,
                'mostviewed':mostViewed,
                'listing_openTime':listing_openTime,
				'lpstag': jQuery("#lpstag").val(),
                'tag_name':tags_name,
                'cat_id': jQuery("#searchform select#searchcategory").val(),
                'loc_id': jQuery("#lp_search_loc").val(),
                'list_style': listStyle,
                'skeyword': skeyword,
            },
            success: function(data) {
                jQuery('.app-filter-loader-active').html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
                jQuery('#full-overlay').remove();
                if(data){
                    listing_update(data);
                    lp_append_distance_div();
                }
            }
        });
    })
	/* ===============================2nd================================== */
	jQuery(document).on('change', '.search-filter-attr input[type="checkbox"]#listingRate, .search-filter-attr input[type="checkbox"]#listingReviewed, .search-filter-attr input[type="checkbox"]#mostviewed', function(event) {
        var docHeight = jQuery( document ).height();
        jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
        jQuery('#full-overlay').css('height',docHeight+'px');
        event.preventDefault();
        jQuery(this).toggleClass('active');
        jQuery('.lp-filter-pagination').hide();
        jQuery('#content-grids').html(' ');
        jQuery('.lp-filter-pagination-ajx').remove();
        jQuery('#content-grids').addClass('content-loading');
		jQuery('.map-view-list-container').remove();
        var inexpensive='';
        moderate = '';
        pricey = '';
        ultra = '';
        averageRate = '';
        mostRewvied = '';
        listing_openTime = '';
        mostViewed = '';

       inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
        moderate = jQuery('.currency-signs #two').find('.active').data('price');
        pricey = jQuery('.currency-signs #three').find('.active').data('price');
        ultra = jQuery('.currency-signs #four').find('.active').data('price');


        if( jQuery( '.search-filter-attr input[type="checkbox"]#listingRate' ).hasClass('active') )
        {
            averageRate = jQuery( '.search-filter-attr input[type="checkbox"]#listingReviewed' ).val();
        }
        if( jQuery( '.search-filter-attr input[type="checkbox"]#listingRate' ).hasClass('active') )
        {
            mostRewvied = jQuery( '.search-filter-attr input[type="checkbox"]#listingReviewed' ).val();
        }
        if( jQuery( '.search-filter-attr input[type="checkbox"]#mostviewed' ).hasClass('active') )
        {
            mostviewed = jQuery( '.search-filter-attr input[type="checkbox"]#mostviewed' ).val();
        }

       if( jQuery( '.search-filter-attr input[type="checkbox"].listing_openTime' ).hasClass('active') )
        {
            listing_openTime = jQuery( '.search-filter-attr input[type="checkbox"].listing_openTime' ).val();
        }

        if( jQuery(this).hasClass('active') ){
            jQuery(this).parent('label').children('.app-filter-loader').addClass('app-filter-loader-active').show().html('<i class="fa fa-spinner" aria-hidden="true"></i>');
        }
        else
        {
                jQuery(this).parent('label').children('.app-filter-loader').hide().html('<i class="fa fa-spinner" aria-hidden="true"></i>');
        }
        var tags_name = [];
        tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
            return jQuery(this).val();
        }).get();
		
		if(tags_name.length > 0){
		}else{
		   tags_name.push(jQuery('#check_featuretax').val());
		}
		
        skeyword = jQuery('input#lp_current_query').val();

       listStyle = jQuery("#page").data('list-style');
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_search_term_object.ajaxurl,
            data: {
                'action': 'ajax_search_tags',
                'inexpensive':inexpensive,
                'moderate':moderate,
                'pricey':pricey,
                'ultra':ultra,
                'averageRate':averageRate,
                'mostRewvied':mostRewvied,
                'mostviewed':mostViewed,
                'listing_openTime':listing_openTime,
				'lpstag': jQuery("#lpstag").val(),
                'tag_name':tags_name,
                'cat_id': jQuery("#searchform select#searchcategory").val(),
                'loc_id': jQuery("#lp_search_loc").val(),
                'list_style': listStyle,
                'skeyword': skeyword,
            },
            success: function(data) {
                jQuery('.app-filter-loader-active').html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
                jQuery('#full-overlay').remove();
                if(data){
                    listing_update(data);
                    lp_append_distance_div();

               }
            }
        });
    });
	/* =============================end by saj br============================== */
	
	/* =========================================================== */
	jQuery(document).on('click', '.lp-filter-pagination-ajx ul li span.haspaglink', function(event){
		jQuery('#lp-pages-in-cats').hide(200);
		var $this = jQuery(this);
		jQuery('.lp-filter-pagination-ajx ul li span').removeClass('active');
		var docHeight = jQuery( document ).height();
		jQuery('html, body').animate({scrollTop:0},500);
		jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
		jQuery('#full-overlay').css('height',docHeight+'px');
		event.preventDefault();
		jQuery(this).toggleClass('active');
		
		jQuery('#content-grids').html(' ');
		jQuery('.lp-filter-pagination-ajx').remove();
		jQuery('#content-grids').addClass('content-loading');
		jQuery('.map-view-list-container').remove();
		var inexpensive='';
		moderate = '';
		pricey = '';
		ultra = '';
		averageRate = '';
		mostRewvied = '';
		listing_openTime = '';
		mostViewed = '';
		
		inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
		moderate = jQuery('.currency-signs #two').find('.active').data('price');
		pricey = jQuery('.currency-signs #three').find('.active').data('price');
		ultra = jQuery('.currency-signs #four').find('.active').data('price');
		
		mostViewed = jQuery('.search-filters li#mostviewed').find('.active').data('value');
		averageRate = jQuery('.search-filters li#listingRate').find('.active').data('value');
		mostRewvied = jQuery('.search-filters li#listingReviewed').find('.active').data('value');
		listing_openTime = jQuery('.search-filters li.listing_openTime').find('.active').data('value');
		
		pageno = jQuery(this).data('pageurl');
		skeywork = jQuery(this).data('skeyword');
		
		var tags_name = [];
		tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
		  return jQuery(this).val();
		}).get();
		
		if(tags_name.length > 0){
		}else{
		   tags_name.push(jQuery('#check_featuretax').val());
		}
		
		listStyle = jQuery("#page").data('list-style');
		var clatval = jQuery('#searchform input[name=clat]').val();
		var clongval = jQuery('#searchform input[name=clong]').val();
		
		if(clatval && clongval){
		}else{
			clatval =  jQuery("#pac-input").attr( 'data-lat' );
			clongval = jQuery("#pac-input").attr( 'data-lng' );
		}
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_search_term_object.ajaxurl,
				data: { 
					'action': 'ajax_search_tags', 
					'inexpensive':inexpensive,
					'moderate':moderate,
					'pricey':pricey,
					'ultra':ultra,
					'averageRate':averageRate,
					'mostRewvied':mostRewvied,
					'mostviewed':mostViewed,
					'listing_openTime':listing_openTime,
					'lpstag': jQuery("#lpstag").val(),
					'tag_name':tags_name,
					'cat_id': jQuery("#searchform select#searchcategory").val(), 
					'loc_id': jQuery("#lp_search_loc").val(),
					'list_style': listStyle, 
					'pageno': pageno,
					'skeywork': skeywork,
					'clat': clatval,
					'clong': clongval,
					'my_bounds_ne_lat' 	: jQuery("#pac-input").attr( 'data-ne-lat' ),
					'my_bounds_ne_lng' 	: jQuery("#pac-input").attr( 'data-ne-lng' ),
					'my_bounds_sw_lat' 	: jQuery("#pac-input").attr( 'data-sw-lat' ),
					'my_bounds_sw_lng' 	: jQuery("#pac-input").attr( 'data-sw-lng' ),
					'data_zoom' 	: jQuery( '#pac-input' ).attr( 'data-zoom'),
					'distance_range' 	: jQuery("#distance_range").val()
					},
				success: function(data) {
					$this.addClass('active');
					jQuery('#full-overlay').remove();
					if(data){
						listing_update(data);
						lp_append_distance_div();	
					}
				  } 
			});
	});

	
	
	
	
	/* =======================Open now========================= */
	jQuery(document).on('click','.search-filters li.listing_openTime a, input[type="checkbox"].listing_openTime',function(event) {

		var docHeight = jQuery( document ).height();
		jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
		jQuery('#full-overlay').css('height',docHeight+'px');
		jQuery('.lp-filter-pagination').hide();
		jQuery('#content-grids').html(' ');
		jQuery('.lp-filter-pagination-ajx').remove();
		jQuery('#content-grids').addClass('content-loading');
		jQuery('.map-view-list-container').remove();
		var inexpensive='';
		moderate = '';
		pricey = '';
		ultra = '';
		averageRate = '';
		mostRewvied = '';
		var listing_openTime = '';
		mostViewed = '';
		
		inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
		moderate = jQuery('.currency-signs #two').find('.active').data('price');
		pricey = jQuery('.currency-signs #three').find('.active').data('price');
		ultra = jQuery('.currency-signs #four').find('.active').data('price');
		
		if( !jQuery('body').hasClass('listing-app-view') )
		{
            mostViewed = jQuery('.search-filters li#mostviewed').find('.active').data('value');
			averageRate = jQuery('.search-filters li#listingRate').find('.active').data('value');
			mostRewvied = jQuery('.search-filters li#listingReviewed').find('.active').data('value');
			listing_openTime = jQuery('.search-filters li.listing_openTime').find('.active').data('value');
			event.preventDefault();
		}
		else
		{
            if( jQuery( '.search-filter-attr input[type="checkbox"]#listingRate' ).hasClass('active') )
            {
                averageRate = jQuery( '.search-filter-attr input[type="checkbox"]#listingReviewed' ).val();
            }
            if( jQuery( '.search-filter-attr input[type="checkbox"]#listingRate' ).hasClass('active') )
            {
                mostRewvied = jQuery( '.search-filter-attr input[type="checkbox"]#listingReviewed' ).val();
            }
		}

		jQuery(this).toggleClass('active');
		if(jQuery(this).hasClass("active")){
			jQuery(this).parent('label').children('.app-filter-loader').addClass('app-filter-loader-active').show().html('<i class="fa fa-spinner" aria-hidden="true"></i>');
			jQuery(this).attr('data-value', 'open');
			listing_openTime = 'open';

		}
		else{
			jQuery(this).parent('label').children('.app-filter-loader').hide().html('<i class="fa fa-spinner" aria-hidden="true"></i>');
			jQuery(this).attr('data-value', 'close');
			listing_openTime = 'close';			
		}
		//listing_openTime = jQuery(this).data('value');

		var tags_name = [];
		tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
		  return jQuery(this).val();
		}).get();
		
		if(tags_name.length > 0){
		}else{
		   tags_name.push(jQuery('#check_featuretax').val());
		}
		
		skeyword = jQuery('input#lp_current_query').val();
		
		var clatval = jQuery('#searchform input[name=clat]').val();
		var clongval = jQuery('#searchform input[name=clong]').val();
		
		if(clatval && clongval){
		}else{
			clatval =  jQuery("#pac-input").attr( 'data-lat' );
			clongval = jQuery("#pac-input").attr( 'data-lng' );
		}
		
		listStyle = jQuery("#page").data('list-style');
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_search_term_object.ajaxurl,
				data: { 
					'action': 'ajax_search_tags', 
					'inexpensive':inexpensive,
					'moderate':moderate,
					'pricey':pricey,
					'ultra':ultra,
					'averageRate':averageRate,
					'mostRewvied':mostRewvied,
					'mostviewed':mostViewed,
					'listing_openTime':listing_openTime,
					'lpstag': jQuery("#lpstag").val(),
					'tag_name':tags_name,
					'cat_id': jQuery("#searchform select#searchcategory").val(), 
					'loc_id': jQuery("#lp_search_loc").val(),
					'list_style': listStyle, 
					'skeyword': skeyword,
					'clat': clatval, 
					'clong': clongval,
					'my_bounds_ne_lat' 	: jQuery("#pac-input").attr( 'data-ne-lat' ),
					'my_bounds_ne_lng' 	: jQuery("#pac-input").attr( 'data-ne-lng' ),
					'my_bounds_sw_lat' 	: jQuery("#pac-input").attr( 'data-sw-lat' ),
					'my_bounds_sw_lng' 	: jQuery("#pac-input").attr( 'data-sw-lng' ),
					'data_zoom' 	: jQuery( '#pac-input' ).attr( 'data-zoom'),
					'distance_range' 	: jQuery("#distance_range").val()
					},
				success: function(data) {
					jQuery('.app-filter-loader-active').html('<i class="fa fa-check-circle" aria-hidden="true"></i>');
					jQuery('#full-overlay').remove();
					if(data){
						listing_update(data);
						lp_append_distance_div();
						if(data.opentime!=''){
							var timevalue = ''; 
							timevalue = data.opentime;
							/* if(timevalue=='open'){
								jQuery('#content-grids .lp-grid-box-contianer .grid-closed:contains("Closed Now")') .closest( ".lp-grid-box-contianer" ).css('display','none');
							}
							if(timevalue=='close'){
								jQuery('#content-grids .lp-grid-box-contianer .grid-closed:contains("Closed Now")') .closest( ".lp-grid-box-contianer" ).css('display','block');
							} */
							
						}
					}
				  } 
			});
			
	});
	/* =====by zaheer on 13 march====== */
	
	jQuery(document).on('click', '.add-to-fav',function(e) {
        e.preventDefault() 
        $this = jQuery(this);
        $this.find('i').addClass('fa-spin fa-spinner');
        var val = jQuery(this).data('post-id');
        var type = jQuery(this).data('post-type');
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_search_term_object.ajaxurl,
                data: { 
                    'action': 'listingpro_add_favorite', 
                    'post-id': val, 
                    'type': type,
                    },
                success: function(data) {
                    if(data){
                        if(data.active == 'yes'){
                            $this.removeClass('add-to-fav');
                            $this.addClass('remove-fav');
                            $this.find('i').removeClass('fa-spin fa-spinner');
                            if(data.type == 'grids' || data.type == 'list'){
                            var successText = $this.data('success-text');
                            $this.find('span').text(successText);
                            //alert($this.find('i'));
                            $this.find('.fa').removeClass('fa-bookmark-o');
                            $this.find('.fa').addClass('fa-bookmark');
                            }else{
                                var successText =$this.data('success-text');
                                $this.find('span').text(successText);
                                $this.find('i').removeClass('fa-bookmark-o');
                                $this.find('i').addClass('fa-bookmark');
                            }               
                        }               
                    }
                  } 
            });
    });
    
    
    jQuery(document).on('click', '.remove-fav', function(e) {
            e.preventDefault() 
            var val = jQuery(this).data('post-id');
            jQuery(this).find('i').removeClass('fa-close');
            jQuery(this).find('i').addClass('fa-spinner fa-spin');
            $this = jQuery(this);
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajax_search_term_object.ajaxurl,
                    data: { 
                        'action': 'listingpro_remove_favorite', 
                        'post-id': val, 
                        },
                    success: function(data) {
                        if(data){
                            if(data.remove == 'yes'){
                                $this.removeClass('remove-fav');
                                $this.addClass('add-to-fav');
                                $this.find('.fa').removeClass('fa-spinner fa-spin');
                                $this.find('.fa').addClass('fa-bookmark-o');
                                $this .parent( ".lp-grid-box-contianer" ).fadeOut();
                            }
                        }
                      }
                });         
            
    });
	


});

/* for near me locations */
jQuery(document).ready(function($){
	jQuery('#lp-find-near-me a.near-me-btn').on('click', function(event){
			$this = jQuery(this);
			event.preventDefault();
			var docHeight = jQuery( document ).height();
			
			var clatval = '';
			var clongval ='';
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			} else { 
				alert("Geolocation is not supported by this browser.");
			}
			function showPosition(position) {
				$this.toggleClass("active");
				
				var clat = position.coords.latitude;
				var clong = position.coords.longitude;
				if ( $this.hasClass( "active" ) ){
					
					jQuery('.lp-tooltip-div-hidden').addClass('active');
					
					jQuery('#searchform input[name=clat]').val(clat);
					jQuery('#searchform input[name=clong]').val(clong);
					clatval= clat;
					clongval = clong;
				}
				else{
					jQuery('#searchform input[name=clat]').val('');
					jQuery('#searchform input[name=clong]').val('');
					jQuery('.lp-tooltip-div-hidden').removeClass('active');
				}
				
				jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
				jQuery('#full-overlay').css('height',docHeight+'px');
				
				jQuery('.lp-filter-pagination').hide();
				jQuery('.lp-filter-pagination-ajx').remove();
				jQuery('#content-grids').html(' ');
				jQuery('#content-grids').addClass('content-loading');
				jQuery('.map-view-list-container').remove();
				
				
				var tags_name = [];
				tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
				  return jQuery(this).val();
				}).get();
				
				if(tags_name.length > 0){
				}else{
				   tags_name.push(jQuery('#check_featuretax').val());
				}
				
				listStyle = jQuery("#page").data('list-style');
				var inexpensive='';
				moderate = '';
				pricey = '';
				ultra = '';
				averageRate = '';
				mostRewvied = '';
				listing_openTime = '';
				mostViewed = '';
				
				inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
				moderate = jQuery('.currency-signs #two').find('.active').data('price');
				pricey = jQuery('.currency-signs #three').find('.active').data('price');
				ultra = jQuery('.currency-signs #four').find('.active').data('price');
				
				mostViewed = jQuery('.search-filters li#mostviewed').find('.active').data('value');
				averageRate = jQuery('.search-filters li#listingRate').find('.active').data('value');
				mostRewvied = jQuery('.search-filters li#listingReviewed').find('.active').data('value');
				listing_openTime = jQuery('.search-filters li.listing_openTime').find('.active').data('value');
				
				skeyword = jQuery('input#lp_current_query').val();

				jQuery.ajax({
					type: 'POST',
					dataType: 'json',
					url: ajax_search_term_object.ajaxurl,
					data: { 
						'action': 'ajax_search_tags', 
						'lpstag': jQuery("#lpstag").val(), 
						'cat_id': jQuery("#searchform select#searchcategory").val(),
						'loc_id': jQuery("#lp_search_loc").val(),
						'inexpensive':inexpensive,
						'moderate':moderate,
						'pricey':pricey,
						'ultra':ultra,
						'averageRate':averageRate,
						'mostRewvied':mostRewvied,
						'mostviewed':mostViewed,
						'listing_openTime':listing_openTime,					
						'tag_name':tags_name,					
						'list_style': listStyle, 
						'skeyword': skeyword, 
						'clat': clatval, 
						'clong': clongval,
						'my_bounds_ne_lat' 	: jQuery("#pac-input").attr( 'data-ne-lat' ),
						'my_bounds_ne_lng' 	: jQuery("#pac-input").attr( 'data-ne-lng' ),
						'my_bounds_sw_lat' 	: jQuery("#pac-input").attr( 'data-sw-lat' ),
						'my_bounds_sw_lng' 	: jQuery("#pac-input").attr( 'data-sw-lng' ),
						'data_zoom' 	: jQuery( '#pac-input' ).attr( 'data-zoom'),
						'distance_range' 	: jQuery("#distance_range").val()
						},
					success: function(data){
						jQuery('#full-overlay').remove();
						if(data){
							listing_update(data);
							lp_append_distance_div();
						}
					}
				});
			
			}
		
	});

});

function lp_append_distance_div(){
	if(jQuery(document).find('.lp-nearby-dist-data').length!=0){
		jQuery(document).find(".lp-nearby-dist-data").each(function(){
			var $this = jQuery(this);
			disdata = $this.data('lpnearbydist');
			$this.next('.lp-grid-box-contianer').find('.lp-grid-box-bottom .pull-left').after('<div class="lp-nearest-distance">'+disdata+'</div>');
			$this.next('.lp-grid-box-contianer').find('.lp-grid-box-bottom-app-view .pull-left').after('<div class="lp-nearest-distance">'+disdata+'</div>');
			
		});
	}
}


function decode_utf8(utf8String) {
    if (typeof utf8String != 'string') throw new TypeError('parameter ‘utf8String’ is not a string');
    // note: decode 3-byte chars first as decoded 2-byte strings could appear to be 3-byte char!
    const unicodeString = utf8String.replace(
        /[\u00e0-\u00ef][\u0080-\u00bf][\u0080-\u00bf]/g,  // 3-byte chars
        function(c) {  // (note parentheses for precedence)
            var cc = ((c.charCodeAt(0)&0x0f)<<12) | ((c.charCodeAt(1)&0x3f)<<6) | ( c.charCodeAt(2)&0x3f);
            return String.fromCharCode(cc); }
    ).replace(
        /[\u00c0-\u00df][\u0080-\u00bf]/g,                 // 2-byte chars
        function(c) {  // (note parentheses for precedence)
            var cc = (c.charCodeAt(0)&0x1f)<<6 | c.charCodeAt(1)&0x3f;
            return String.fromCharCode(cc); }
    );
    return unicodeString;
}

			function listing_update(data){
				
					var pars = decode_utf8(data.html);
						jQuery('#content-grids').hide();
						jQuery('#content-grids').html(pars); 
						
						//jQuery('#listing_found').html('<p>'+data.found+' '+data.foundtext+'</p>'); 	
						jQuery('#content-grids').fadeIn('slow'); 					
						jQuery('#content-grids').removeClass('content-loading');						
						
					var taxonomy = jQuery('section.taxonomy').attr('id');
					
						if(taxonomy == 'location'){
							if(data.cat != ''){
								var CatName = data.cat;
								CatName = CatName.replace('&amp;', '&');
								jQuery('.filter-top-section .lp-title span.term-name').html(CatName+' Listings <span style="font-weight:normal;"> In </span>');
								jQuery('.filter-top-section .lp-title span.font-bold:last-child').text(data.city);
								//window.history.pushState("Details", "Title", 'location/'+data.cat);	
							}
							
						}else if(taxonomy == 'listing-category'){
	
							if(data.cat != ''){
								var CatName = data.cat;
								CatName = CatName.replace('&amp;', '&');
								jQuery('.filter-top-section .lp-title span.term-name').text(CatName);
								//window.history.pushState("Details", "Title", 'location/'+data.cat);	
							}
							
						}else if(taxonomy == 'features'){
							jQuery('.showbread').show();
							jQuery('.fst-term').html(data.tags);
							if(data.keyword != ''){
								jQuery('.s-term').html(',&nbsp;keyword&nbsp;"'+data.keyword+'"');
							}else{
								jQuery('.s-term').html(' ');
							}
							if(data.city != ''){
								if(data.cat != ''){									
									jQuery('.sec-term').html('&amp;&nbsp;'+data.city);
								}else{
									jQuery('.sec-term').html(data.city);
								}
							}else{
								jQuery('.sec-term').html(' ');
							}
							if(data.tags != ''){
								jQuery('.tag-term').html(',&nbsp;tagged&nbsp;('+data.tags+')');
							}
							if(data.tags == null){
								jQuery('.tag-term').html('');
							}
						}
						
						
						else if(taxonomy == 'keyword'){
							jQuery('.showbread').show();
							jQuery('.fst-term').html(data.cat);
							if(data.keyword != ''){
								jQuery('.s-term').html(',&nbsp;keyword&nbsp;"'+data.keyword+'"');
							}else{
								jQuery('.s-term').html(' ');
							}
							if(data.city != ''){
								if(data.cat != ''){									
									jQuery('.sec-term').html('&amp;&nbsp;'+data.city);
								}else{
									jQuery('.sec-term').html(data.city);
								}
							}else{
								jQuery('.sec-term').html(' ');
							}
							
							if(data.tags != ''){
								jQuery('.tag-term').html(',&nbsp;tagged&nbsp;('+data.tags+')');
							}
							if(data.tags == null){
								jQuery('.tag-term').html('');
							}
						}else{
							if(data.cat != ''){
								var CatName = data.cat;
								CatName = CatName.replace('&amp;', '&');
								jQuery('.filter-top-section .lp-title span.term-name').text(CatName);
								//window.history.pushState("Details", "Title", 'location/'+data.cat);	
							}
						}
						
					
					jQuery( ".all-list-map" ).trigger('click');
					jQuery( ".listing-app-view-bar .right-icons .map-view-icon" ).trigger('click');
                    jQuery( ".open-app-view" ).trigger('click');
					//jQuery( ".qickpopup" ).trigger('click');
					 
					
			}
			
/* for find near me filter */

/* radiou filter code starts */
jQuery(document).ready(function() {
	
	jQuery(document).on('click', '#distance_range_div .slider', function(){
			jQuery( '#pac-input' ).attr( 'data-zoom', '' );
			listingproc_update_results();
	});

	jQuery(document).on('input', '#distance_range_div .slider', function(){
			jQuery( '#pac-input' ).attr( 'data-zoom', '' );
			listingproc_update_results();
	});

});


function listingproc_update_results() {
	
	var docHeight = jQuery( document ).height();
	jQuery( "body" ).prepend( '<div id="full-overlay"></div>' );
	jQuery('#full-overlay').css('height',docHeight+'px');
	jQuery('#content-grids').html(' ');
	jQuery('.solitaire-infinite-scroll').remove();
	jQuery('#content-grids').addClass('content-loading');
	jQuery('.map-view-list-container').remove();
	jQuery('.lp-filter-pagination-ajx').remove();
	listStyle = jQuery("#page").data('list-style');
	var inexpensive='';
	moderate = '';
	pricey = '';
	ultra = '';
	averageRate = '';
	mostRewvied = '';
	listing_openTime = '';
	mostViewed = '';

	inexpensive = jQuery('.currency-signs #one').find('.active').data('price');
	moderate = jQuery('.currency-signs #two').find('.active').data('price');
	pricey = jQuery('.currency-signs #three').find('.active').data('price');
	ultra = jQuery('.currency-signs #four').find('.active').data('price');
	
	
	averageRate = jQuery('.search-filters li#listingRate').find('.active').data('value');
	mostRewvied = jQuery('.search-filters li#listingReviewed').find('.active').data('value');
	listing_openTime = jQuery('.search-filters li.listing_openTime').find('.active').data('value');
	
	var clatval = jQuery('#searchform input[name=clat]').val();
	var clongval = jQuery('#searchform input[name=clong]').val();

	if(clatval && clongval){
	}else{
		clatval =  jQuery("#pac-input").attr( 'data-lat' );
		clongval = jQuery("#pac-input").attr( 'data-lng' );
	}

	var tags_name = [];
	tags_name = jQuery('.tags-area input[type=checkbox]:checked').map(function(){
		return jQuery(this).val();
	}).get();
	
	if(tags_name.length > 0){
	}else{
	   tags_name.push(jQuery('#check_featuretax').val());
	}
	
	jQuery.ajax({
		type: 'POST',
		dataType: 'json',
		url: ajax_search_term_object.ajaxurl,
		data: {
			'action': 'ajax_search_tags',
			'lpstag': jQuery("#lpstag").val(),
			'cat_id': jQuery("#searchform select#searchcategory").val(),
			'loc_id': jQuery("#lp_search_loc").val(),
			'sloc_address' : jQuery("#pac-input").val(),
			'clat' 	: clatval,
			'clong' 	: clongval,
			'my_bounds_ne_lat' 	: jQuery("#pac-input").attr( 'data-ne-lat' ),
			'my_bounds_ne_lng' 	: jQuery("#pac-input").attr( 'data-ne-lng' ),
			'my_bounds_sw_lat' 	: jQuery("#pac-input").attr( 'data-sw-lat' ),
			'my_bounds_sw_lng' 	: jQuery("#pac-input").attr( 'data-sw-lng' ),
			'data_zoom' 	: jQuery( '#pac-input' ).attr( 'data-zoom'),
			'distance_range' 	: jQuery("#distance_range").val(),

			'inexpensive':inexpensive,
			'moderate':moderate,
			'pricey':pricey,
			'ultra':ultra,
			'averageRate':averageRate,
			'mostRewvied':mostRewvied,
			'listing_openTime':listing_openTime,
			'tag_name':tags_name,
			'list_style': listStyle
		},
		success: function(data){
			jQuery('#full-overlay').remove();
			if(data){
				listing_update(data);
				lp_append_distance_div();
			}
		}
	});
}


function initialize() {
	if( jQuery('#pac-input').length ){
		var input = document.getElementById('pac-input');
		var autocomplete = new google.maps.places.Autocomplete(input);
		autocomplete.addListener('place_changed', function () {
			var place = autocomplete.getPlace();

			jQuery( '#pac-input' ).attr( 'data-zoom', '' );

			var loc_lat 	= place.geometry.location.lat();
			var loc_lng 	= place.geometry.location.lng();

			jQuery( '#pac-input' ).attr( 'data-lat', loc_lat );
			jQuery( '#pac-input' ).attr( 'data-lng', loc_lng );

			jQuery( '#pac-input' ).attr( 'data-center-lat', place.geometry.viewport.getCenter().lat() );
			jQuery( '#pac-input' ).attr( 'data-center-lng', place.geometry.viewport.getCenter().lng() );

			jQuery( '#pac-input' ).attr( 'data-ne-lat', place.geometry.viewport.getNorthEast().lat() );
			jQuery( '#pac-input' ).attr( 'data-ne-lng', place.geometry.viewport.getNorthEast().lng() );
			jQuery( '#pac-input' ).attr( 'data-sw-lat', place.geometry.viewport.getSouthWest().lat() );
			jQuery( '#pac-input' ).attr( 'data-sw-lng', place.geometry.viewport.getSouthWest().lng() );

			listingproc_update_results();
		});
	}
}


function listingproc_get_radius( center_lat, center_lng, ne_lat, ne_lng ){

	// r = radius of the earth in statute miles
	var r = 6371.0;

	// Convert lat or lng from decimal degrees into radians (divide by 57.2958)
	var lat1 = center_lat / 57.2958;
	var lon1 = center_lng / 57.2958;
	var lat2 = ne_lat / 57.2958;
	var lon2 = ne_lng / 57.2958;

	// distance = circle radius from center to Northeast corner of bounds
	return r * Math.acos(Math.sin(lat1) * Math.sin(lat2) + Math.cos(lat1) * Math.cos(lat2) * Math.cos(lon2 - lon1));

}


function getLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition( initMap );
	}
}// getLocation


function initMap( position ) {
	var geocoder = new google.maps.Geocoder();
	geocodeLatLng( geocoder, position.coords.latitude, position.coords.longitude );
}// initMap


function geocodeLatLng( geocoder, lat, lng ) {
	var latlng 		= {lat : lat, lng : lng};
  geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === 'OK') {
      if (results[1]) {

				jQuery( '#pac-input' ).attr( 'data-zoom', '' );

				jQuery( '#pac-input' ).val( results[1].formatted_address );
				jQuery( '#pac-input' ).attr( 'data-lat', lat );
				jQuery( '#pac-input' ).attr( 'data-lng', lng );
				listingproc_update_results();
      }
    }
  });
}// geocodeLatLng


function listingproc_update_markers( map ){
	map.on( 'zoomend dragend', function(){

		var bounds 	= map.getBounds();
		window.bounds 	= bounds;

		console.log(window.bounds);

		//jQuery( '#pac-input' ).val('');

		jQuery( '#pac-input' ).attr( 'data-zoom', 'yes' );

		jQuery( '#pac-input' ).attr( 'data-ne-lat', bounds._northEast.lat );
		jQuery( '#pac-input' ).attr( 'data-ne-lng', bounds._northEast.lng );
		jQuery( '#pac-input' ).attr( 'data-sw-lat', bounds._southWest.lat );
		jQuery( '#pac-input' ).attr( 'data-sw-lng', bounds._southWest.lng );

		listingproc_update_results();
	});
}// listingproc_update_markers


var hasOwnProperty = Object.prototype.hasOwnProperty;
function listingproc_isEmpty(obj) {

    // null and undefined are "empty"
    if (obj == null) return true;

    // Assume if it has a length property with a non-zero value
    // that that property is correct.
    if (obj.length > 0)    return false;
    if (obj.length === 0)  return true;

    // If it isn't an object at this point
    // it is empty, but it can't be anything *but* empty
    // Is it empty?  Depends on your application.
    if (typeof obj !== "object") return true;

    // Otherwise, does it have any properties of its own?
    // Note that this doesn't handle
    // toString and valueOf enumeration bugs in IE < 9
    for (var key in obj) {
        if (hasOwnProperty.call(obj, key)) return false;
    }

    return true;
}// listingproc_isEmpty

/* radiou filter code ends */

/* new radius code  */
jQuery(document).ready(function($){
	jQuery('.lp-radus-filter-wrap li.lp-tooltip-outer .lp-distancesearchbtn').on('click', function(){
		$this = jQuery(this);
		$this.toggleClass('active');
		if($this.hasClass('active')){
			if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(showPositionn);
			} else { 
				alert("Geolocation is not supported by this browser.");
			}
			function showPositionn(position) {
				var loc_lat = position.coords.latitude;
				var loc_lng = position.coords.longitude;
				
				var myLatlng = new google.maps.LatLng(loc_lat, loc_lng);
				var mapProp = {
					center: myLatlng,
					zoom: 8,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				var map = new google.maps.Map(document.getElementById("lp-hidden-map"), mapProp);
				var viewportBox;
				google.maps.event.addListener(map, 'idle', function(event) {
					var bounds = map.getBounds();
					var ne = bounds.getNorthEast();
					var sw = bounds.getSouthWest();
					
					var viewportPoints = [
						ne, new google.maps.LatLng(ne.lat(), sw.lng()),
						sw, new google.maps.LatLng(sw.lat(), ne.lng()), ne
					];
					if (viewportBox) {
						viewportBox.setPath(viewportPoints);
					} else {
						viewportBox = new google.maps.Polyline({
							path: viewportPoints,
							strokeColor: '#FF0000',
							strokeOpacity: 1.0,
							strokeWeight: 4 
						});
						viewportBox.setMap(map);
					};

					
					var geocoder = geocoder = new google.maps.Geocoder();
					var faddress;
					geocoder.geocode({ 'latLng': myLatlng }, function (results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							if (results[1]) {
								faddress = results[1].formatted_address;
								
								jQuery( '#pac-input' ).val(faddress );
								
								jQuery( '#pac-input' ).attr( 'data-lat', loc_lat );
								jQuery( '#pac-input' ).attr( 'data-lng', loc_lng );

								jQuery( '#pac-input' ).attr( 'data-ne-lat', ne.lat() );
								jQuery( '#pac-input' ).attr( 'data-ne-lng', ne.lng() );
								jQuery( '#pac-input' ).attr( 'data-sw-lat', sw.lat() );
								jQuery( '#pac-input' ).attr( 'data-sw-lng', sw.lng() );

								listingproc_update_results();
							}
						}
					});
				});
				
			}
		}else{
			jQuery( '#pac-input' ).val('' );
							
			jQuery( '#pac-input' ).attr( 'data-lat', '' );
			jQuery( '#pac-input' ).attr( 'data-lng', '' );

			jQuery( '#pac-input' ).attr( 'data-center-lat', '' );
			jQuery( '#pac-input' ).attr( 'data-center-lng', '' );

			jQuery( '#pac-input' ).attr( 'data-ne-lat', '' );
			jQuery( '#pac-input' ).attr( 'data-ne-lng', '' );
			jQuery( '#pac-input' ).attr( 'data-sw-lat', '' );
			jQuery( '#pac-input' ).attr( 'data-sw-lng', '' );
			jQuery( '#distance_range' ).val( '');

			listingproc_update_results();
		}

	});
});
/* end new radius code  */