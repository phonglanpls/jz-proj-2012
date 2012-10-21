
/*
 * CometChat
 * Copyright (c) 2012 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccpeep = (function () {

		var title = 'Buy Peeped';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				//baseUrl = $.cometchat.getBaseUrl();
				//baseData = $.cometchat.getBaseData();
				callFuncBuyPeepAccess_CMC(id);
			}

        };
    })();
 
})(jqcc);