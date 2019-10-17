 jQuery(document).ready(function($){
	 jQuery('#claimform').on('submit', function(e){
		$this = jQuery(this);
		$this.find('.statuss').html('');
		jQuery(this).find('.formsubmitting').css('visibility','visible');
		e.preventDefault();
		var formData = $(this).serialize();
		
		jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: single_ajax_object.ajaxurl,
            data: { 
                'action': 'listingpro_claim_list', 
                'formData': formData, 
			},   
            success: function(res){
				if (jQuery("form#claimform .g-recaptcha-response").length){
					lp_reset_grecaptcha();
				}
				$this.find('.formsubmitting').css('visibility','hidden');
                //alert(res.state);
				$this.find('.statuss').html(res.state);
				
				$this[0].reset();
            }
        });
		//return false;
		 //alert(formData);
	 });
	 
	  jQuery('#claimformmobile').on('submit', function(e){
		$this = jQuery(this);
		$this.find('.statuss').html('');
		jQuery(this).find('.formsubmitting').css('visibility','visible');
		e.preventDefault();
		var formData = $(this).serialize();
		
		jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: single_ajax_object.ajaxurl,
            data: { 
                'action': 'listingpro_claim_list', 
                'formData': formData, 
			},   
            success: function(res){
				if (jQuery("form#claimformmobile .g-recaptcha-response").length){
					lp_reset_grecaptcha();
				}
				$this.find('.formsubmitting').css('visibility','hidden');
                //alert(res.state);
				$this.find('.statuss').html(res.state);
				
				$this[0].reset();
            }
        });
		//return false;
		 //alert(formData);
	 });
	 
	 
	 
	 jQuery('#contactOwner').on('submit', function(e){
		
		$this = jQuery(this);
		$this.find('.lp-search-icon').removeClass('fa-send');	
		$this.find('.lp-search-icon').addClass('fa-spinner fa-spin');
		e.preventDefault();
		var formData = $(this).serialize();
		
		jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: single_ajax_object.ajaxurl,
            data: { 
                'action': 'listingpro_contactowner', 
                'formData': formData, 
			},   
            success: function(res){
				if (jQuery("form#contactOwner .g-recaptcha-response").length){
					lp_reset_grecaptcha();
				}
				if(res.result==="fail"){
					jQuery.each(res.errors, function (k, v) {
						if(k==="email"){
							jQuery("input[name='email7']").addClass('error-msg');
						}
						if(k==="message"){
							jQuery("textarea[name='message7']").addClass('error-msg');
						}
						if(k==="name7"){
							jQuery("input[name='name7']").addClass('error-msg');
						}
						$this.find('.lp-search-icon').removeClass('fa-spinner fa-spin');	
						$this.find('.lp-search-icon').addClass('fa-cross');
						//$this.append(res.state);
					});
				}
				else{
					$this.find('.lp-search-icon').removeClass('fa-spinner fa-spin');	
					$this.find('.lp-search-icon').addClass('fa-check');
					//$this.append(res.state);
					$this[0].reset();
				}
            }
        });
		//return false;
		 //alert(formData);

	 });
	 
	 
/* jquery ajax code for expired listing plan change */
	jQuery('.lp-change-proceed-link').on('click', function(e){
		jQuery('div.lp-existing-plane-container').slideToggle(700);
		jQuery('div.lp-new-plane-container').slideToggle(700);
		e.preventDefault();
	})
	
	jQuery('.lp-role-back-to-current-plan').on('click', function(e){
		jQuery('div.lp-existing-plane-container').slideToggle(700);
		jQuery('div.lp-new-plane-container').slideToggle(700);
		e.preventDefault();
	})
	
	
	jQuery('.lp-change-plan-btn').on('click', function(e){
		var listing_id = '';
		var listing_status = '';
		var plan_title = '';
		var plan_price = '';
		var haveplan = '';
		listing_id = jQuery(this).data('listingid');
		plan_title = jQuery(this).data('plantitle');
		plan_price = jQuery(this).data('planprice');
		haveplan = jQuery(this).data('haveplan');
		listing_status = jQuery(this).data('listingstatus');
		jQuery('.lp-selected-plan-price h3' ).html('');
		jQuery('.lp-selected-plan-price h3' ).text(plan_title);
		jQuery('.lp-selected-plan-price h4' ).html('');
		jQuery('.lp-selected-plan-price h4' ).html(plan_price);
		jQuery('#select-plan-form input#listing_id' ).val(listing_id);
		jQuery('#select-plan-form input#listing_statuss' ).val(listing_status);
		//jQuery('.pay-again-button').removeClass('lp-new-button-added');
		//jQuery(this).closest('li').next('.pay-again-button').addClass('lp-new-button-added');
		e.preventDefault();
	});
	jQuery('#select-plan-form').submit(function(event){
		var plan_id = '';
		$this = jQuery(this);
		listing_idd = '';
		listing_status = '';
		listing_idd = jQuery("input[name='plans-posts']:checked").val();
		listing_id = jQuery("input[name='listing-id']").val();
		listing_status = jQuery("input[name='listing_status']").val();
		jQuery('.lp-change-plane-status .lp-action-div').html('');
		if( typeof(listing_idd)  !== "undefined" ){
			jQuery("div.lp-expire-update-status").html('<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>');
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: single_ajax_object.ajaxurl,
				data: { 
					'action': 'listingpro_change_plan', 
					'ch_plan_id': listing_idd, 
					'ch_listing_id': listing_id, 
					'ch_listing_status': listing_status, 
				},   
				success: function(data){
					//jQuery('#select-plan-form')[0].reset();
					if( data.subscribed ){
						if(data.subscribed=="yes"){
							alert(data.alertmsg);
						}
					}
					jQuery("div.lp-expire-update-status").html('');
					jQuery('.lp-change-plane-status .lp-action-div').html('');
					jQuery('.lp-change-plane-status .lp-action-div').html(data.action);
					
				}
			});
			
		}
		event.preventDefault();
	})
	 
 });
 
 
 /* change plan proceedings */
 jQuery(document).on('click', '.lp_change_plan_action', function(e){
	 var planid = jQuery('.lp-action-div input[name="planid"]').val();
	 var listingid = jQuery('.lp-action-div input[name="listingid"]').val();
	 jQuery('.lp-action-div').html('');
	 jQuery("div.lp-expire-update-status").html('<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw"></i>');
	 jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: single_ajax_object.ajaxurl,
				data: { 
					'action': 'listingpro_change_plan_proceeding', 
					'plan_iddd': planid, 
					'listing_iddd': listingid, 
				},   
				success: function(data){
					//jQuery('#select-plan-form')[0].reset();
					jQuery("div.lp-expire-update-status").html('');
					jQuery("div.lp-expire-update-status").html(data.message);
				}
			});
	 
	 e.preventDefault();
 })
 /* end change plan proceedings */ 
 
 /* delete subscription proceedings */
 jQuery(document).on('click', 'a.delete-subsc-btn', function(e){
	 var $this = jQuery(this);
	 jQuery('body').addClass('listingpro-loading');
	 var subscript_id = jQuery(this).attr('href');
	 jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: single_ajax_object.ajaxurl,
				data: { 
					'action': 'listingpro_cancel_subscription_proceeding', 
					'subscript_id': subscript_id, 
				},   
				success: function(data){
					jQuery('body').removeClass('listingpro-loading');
					alert(data.msg);
					if(data.status=="success"){
						$this.closest('tr').slideToggle();
					}
					
				},
				error: function(jqXHR, textStatus, errorThrown) {
					jQuery('body').removeClass('listingpro-loading');
					console.log(textStatus, errorThrown);
				}
			});
	 
	 e.preventDefault();
 })
 
 /* Report listing or Report Review */
 jQuery(document).on('click', '#lp-report-listing a#lp-report-this-listing, #lp-report-review a#lp-report-this-review', function(e){
	 var $this = jQuery(this);
	 var $posttype = $this.data('posttype');
	 var $postid = $this.data('postid');
	 var $reportedby = $this.data('reportedby');
	 jQuery('body').addClass('listingpro-loading');
	 jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: single_ajax_object.ajaxurl,
				data: { 
					'action': 'listingpro_report_this_post', 
					'posttype': $posttype, 
					'postid': $postid, 
					'reportedby': $reportedby 
				},   
				success: function(data){
					jQuery('body').removeClass('listingpro-loading');
					jQuery('div.lp-top-notification-bar').html('');
					var alertmsgs = '';
					if(data.status==="success"){
						alertmsgs = '<div class="lp-reporting-success">'+data.msg+'</div>';
						jQuery('div.lp-top-notification-bar').html(alertmsgs);
					}
					else{
						alertmsgs = '<div class="lp-reporting-error">'+data.msg+'</div>';
						jQuery('div.lp-top-notification-bar').html(alertmsgs);
					}
					jQuery('div.lp-top-notification-bar').slideDown('slow').delay(2000).slideUp('slow');
					//alert(data.msg);
					
				},
				error: function(jqXHR, textStatus, errorThrown) {
					jQuery('body').removeClass('listingpro-loading');
					console.log(textStatus, errorThrown);
				}
			});
	 
	 e.preventDefault();
 })