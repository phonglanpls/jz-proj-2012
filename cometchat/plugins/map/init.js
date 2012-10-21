
/*
 * CometChat
 * Copyright (c) 2012 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccmap = (function () {

		var title = 'Buy map location';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				//baseUrl = $.cometchat.getBaseUrl();
				//baseData = $.cometchat.getBaseData();
				callFuncBuyAccessMapFlirtCMChat(id);
			}

        };
    })();
 
})(jqcc);