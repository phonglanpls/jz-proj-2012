
/*
 * CometChat
 * Copyright (c) 2012 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccbackstage = (function () {

		var title = 'Buy Backstage Photo';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				//baseUrl = $.cometchat.getBaseUrl();
				//baseData = $.cometchat.getBaseData();
				queryurl(BASE_URI+'user/gotoid/'+id+'/backstages/');
			}

        };
    })();
 
})(jqcc);