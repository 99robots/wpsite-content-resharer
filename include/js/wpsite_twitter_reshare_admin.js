/**
 * Created by Kyle Benk
 *	
 * @author Kyle Benk <kjbenk@gmail.com> 
 */
 
jQuery(document).ready(function($) {
	
	/* Admin form make the name field required */
	
	$("#wpsite_twitter_reshare_account_form").submit(function(e){
		$("#wps_settings_account_id").removeClass('wpsite_twitter_reshare_admin_required');
		
		/* Account id */
		
		if ($("#wps_settings_account_id").val() == '') {
			$("#wps_settings_account_id").addClass('wpsite_twitter_reshare_admin_required');
			e.preventDefault();	
		}
	});
	
	/* Admin form make the name field required */
	
	$("#wpsite_twitter_reshare_message_form").submit(function(e){
		$("#wps_settings_message_id").removeClass('wpsite_twitter_reshare_admin_required');
		
		/* Field group */
		
		if ($("#wps_settings_message_id").val() == '') {
			$("#wps_settings_message_id").addClass('wpsite_twitter_reshare_admin_required');
			e.preventDefault();	
		}
	});
	
	$(".wpsite_twitter_reshare_admin_delete_ahref").click(function(){
		wpsite_twitter_reshare_delete($(this).attr('class').substring(83), $("#wpsite_twitter_reshare_delete_url_" + $(this).attr('class').substring(83)).text());
	});

	/* Loop through all accounts */
		
	if (typeof(wpsite_twitter_reshare_accounts_ahref) != "undefined" && wpsite_twitter_reshare_accounts_ahref !== null) {
		for (var i = 0; i < wpsite_twitter_reshare_accounts_ahref.length; i++) {
			
			/* Set all links to hidden */
			$('.wpsite_twitter_reshare_admin_delete_ahref' + wpsite_twitter_reshare_accounts_ahref[i]).css('visibility', 'hidden');
			
			$(".wpsite_twitter_reshare_admin_accounts_delete_tr" + wpsite_twitter_reshare_accounts_ahref[i]).mouseover(function(){
				$('.wpsite_twitter_reshare_admin_delete_ahref' + $(this).attr('class').substring(95)).css('visibility', 'visible');
			});
			
			$(".wpsite_twitter_reshare_admin_accounts_delete_tr" + wpsite_twitter_reshare_accounts_ahref[i]).mouseout(function(){
				$('.wpsite_twitter_reshare_admin_delete_ahref' + $(this).attr('class').substring(95)).css('visibility', 'hidden');
			});
		}
	}
	
	/* Loop through all messages */
		
	if (typeof(wpsite_twitter_reshare_messages_ahref) != "undefined" && wpsite_twitter_reshare_messages_ahref !== null) {
		for (var i = 0; i < wpsite_twitter_reshare_messages_ahref.length; i++) {
		
			/* Set all links to hidden */
			$('.wpsite_twitter_reshare_admin_delete_ahref' + wpsite_twitter_reshare_messages_ahref[i]).css('visibility', 'hidden');
			
			$(".wpsite_twitter_reshare_admin_messages_delete_tr" + wpsite_twitter_reshare_messages_ahref[i]).mouseover(function(){
				$('.wpsite_twitter_reshare_admin_delete_ahref' + $(this).attr('class').substring(95)).css('visibility', 'visible');
			});
			
			$(".wpsite_twitter_reshare_admin_messages_delete_tr" + wpsite_twitter_reshare_messages_ahref[i]).mouseout(function(){
				$('.wpsite_twitter_reshare_admin_delete_ahref' + $(this).attr('class').substring(95)).css('visibility', 'hidden');
			});
		}
	}
	
	/* Show and Hide all API settings */
	
	/*
$("#wps_settings_account_type").change(function(){
	
		$(".wpsite_api_settings_twitter").hide();
		$(".wpsite_api_settings_facebook").hide();
		$(".wpsite_api_settings_google").hide();
		$(".wpsite_api_settings_linkedin").hide();
		$(".wpsite_api_settings_pinterest").hide();
		
		if ($(this).val() == 'twitter') {
			$(".wpsite_api_settings_twitter").show();
		}else if ($(this).val() == 'facebook') {
			$(".wpsite_api_settings_facebook").show();
		}else if ($(this).val() == 'google') {
			$(".wpsite_api_settings_google").show();
		}else if ($(this).val() == 'linkedin') {
			$(".wpsite_api_settings_linkedin").show();
		}else if ($(this).val() == 'pinterest') {
			$(".wpsite_api_settings_pinterest").show();
		}
	});
	
	$(".wpsite_api_settings_twitter").hide();
	$(".wpsite_api_settings_facebook").hide();
	$(".wpsite_api_settings_google").hide();
	$(".wpsite_api_settings_linkedin").hide();
	$(".wpsite_api_settings_pinterest").hide();
	
	if ($("#wps_settings_account_type").val() == 'twitter') {
		$(".wpsite_api_settings_twitter").show();
	}else if ($("#wps_settings_account_type").val() == 'facebook') {
		$(".wpsite_api_settings_facebook").show();
	}else if ($("#wps_settings_account_type").val() == 'google') {
		$(".wpsite_api_settings_google").show();
	}else if ($("#wps_settings_account_type").val() == 'linkedin') {
		$(".wpsite_api_settings_linkedin").show();
	}else if ($("#wps_settings_account_type").val() == 'pinterest') {
		$(".wpsite_api_settings_pinterest").show();
	}
*/
	
	/* Facebook Page ID */
	
	/*
$("#wps_facebook_type").change(function(){
	
		$(".wpsite_api_settings_facebook_page_id").hide();
		
		if ($(this).val() == 'page') {
			$(".wpsite_api_settings_facebook_page_id").show();
		}
	});
	
	$(".wpsite_api_settings_facebook_page_id").hide();
		
	if ($("#wps_facebook_type").val() == 'page') {
		$(".wpsite_api_settings_facebook_page_id").show();
	}
*/
	
	/* Message Preview */
	
	$("#wps_settings_message_text").keyup(function(){
		$(".wps_settings_message_preview").text($(this).val());
	});
	
	$(".wps_settings_message_preview").text($("#wps_settings_message_text").val());
	
	$("#wps_settings_message_place").change(function(){
		$("#wps_settings_message_preview_before").hide();
		$("#wps_settings_message_preview_after").hide();
	
		if ($(this).val() == 'before') {
			$("#wps_settings_message_preview_before").show();
		} else {
			$("#wps_settings_message_preview_after").show();
		}
	});
	
	$("#wps_settings_message_preview_before").hide();
	$("#wps_settings_message_preview_after").hide();

	if ($("#wps_settings_message_place").val() == 'before') {
		$("#wps_settings_message_preview_before").show();
	} else {
		$("#wps_settings_message_preview_after").show();
	}
});

function wpsite_twitter_reshare_delete(message, url) {
	
	var c = confirm("Are you sure you want to delete: " + message);
	
	if (c == true) {
		window.location = url;
	}
}