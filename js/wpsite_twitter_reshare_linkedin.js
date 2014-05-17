/**
 * Created by Kyle Benk
 *	
 * @author Kyle Benk <kjbenk@gmail.com> 
 */

jQuery(document).ready(function($) {

	$.getScript("http://platform.linkedin.com/in.js?async=true", function success() {
        IN.init({
        	api_key: wpsite_linkedin.api_key,
            onLoad: "onLinkedInLoad",
            authorize: true,
            credentials_cookie: true,
			credentials_cookie_crc: true
        });
    });
});

function onLinkedInLoad() {
	
	if (!IN.User.isAuthorized()) {
		console.log('check false login user');
	}else {
		console.log('check true');
		
		if (wpsite_linkedin.image) {
			console.log('image');
			IN.API.Raw("/people/~/shares") // Update (PUT) the status
			  .method("POST")
			  .body(JSON.stringify({
			  	"content": {
					"submitted-url": wpsite_linkedin.url,
					"submitted-image-url": wpsite_linkedin.image_url,
					"description": wpsite_linkedin.message
				},
				"visibility": {
					"code": "anyone"
				}
			  }))
			  .result(function(r) { 
			      alert("POST OK");
				  if (wpsite_linkedin.test) {
					  window.location = "admin.php?page=wpsite-reshare-menu";
					}
			  })
			  .error(function(r) {
			      alert("POST FAIL");
			      console.log(r);
			  });
		}else {
			IN.API.Raw("/people/~/current-status") // Update (PUT) the status
			  .method("PUT")
			  .body(JSON.stringify({
			  	"content": {
					"submitted-url": wpsite_linkedin.url,
					"description": wpsite_linkedin.message
				},
				"visibility": {
					"code": "anyone"
				}
			  }))
			  .result(function(r) { 
			      alert("POST OK");
				  if (wpsite_linkedin.test) {
					  window.location = "admin.php?page=wpsite-reshare-menu";
					}
			  })
			  .error(function(r) {
			      alert("POST FAIL");
			      console.log(r);
			  });
		}
		
	}
}