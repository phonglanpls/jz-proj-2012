$(document).ready(function() {
	/**
	(function() {
		var e = document.createElement('script');
		e.type = 'text/javascript';
		e.src = document.location.protocol +
			'//connect.facebook.net/en_US/all.js';
		e.async = true;
		document.getElementById('fb-root').appendChild(e);
	}());
	**/
	window.fbAsyncInit = function() {
		FB.init({appId: FBID, status: true, cookie: true, xfbml: true});
		if($.browser.msie ) 		{
		  FB.XD._origin = window.location.protocol + "//" + document.domain + "/" + FB.guid();
			FB.XD.Flash.init();
			FB.XD._transport = "flash";
		}
	}	
	
	
	FB.Event.subscribe('auth.login', function(response) {
		FB._oauth = false;
		FB.Cookie.setEnabled(true);
		FB.Auth.setSession(response.authResponse, response.status);
		FB._oauth = true;
		console.log(response);
	});
	
});


