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

	$(".wpsite_twitter_reshare_admin_settings_add_edit_submitdelete").click(function(){
		wpsite_twitter_reshare_delete($(this).attr('id').substring(30), $("#wpsite_twitter_reshare_delete_url_" + $(this).attr('id').substring(30)).text());
	});

	$(".wpsite_twitter_reshare_message_delete").click(function(){
		wpsite_twitter_reshare_delete($(this).attr('id').substring(38), $("#wpsite_twitter_reshare_delete_url_" + $(this).attr('id').substring(38)).text());
	});

	$("#wps_general_hashtag_type").change(function() {
		$(".wpsite_general_specific_hashtag").hide();

		if ($(this).val() == 'specific_hashtags') {
			$(".wpsite_general_specific_hashtag").show();
		}
	});

	$(".wpsite_general_specific_hashtag").hide();

	if ($("#wps_general_hashtag_type").val() == 'specific_hashtags') {
		$(".wpsite_general_specific_hashtag").show();
	}

	/* Exclude Posts */

	if (typeof(categories) != "undefined" && categories !== null) {
		$("#wpsite_twitter_reshare_exclude_posts_category").change(function() {

			$(".wpsite_twitter_reshare_exclude_posts_general").hide();

			if ($(this).val() != '') {
				$(".wpsite_twitter_reshare_cat_" + $(this).val()).show();
			} else {
				$(".wpsite_twitter_reshare_exclude_posts_general").show();
			}
		});
	}

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