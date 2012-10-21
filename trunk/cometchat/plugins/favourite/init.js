
/*
 * CometChat
 * Copyright (c) 2012 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccfavourite = (function () {

		var title = 'Add to my favorite';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				//baseUrl = $.cometchat.getBaseUrl();
				//baseData = $.cometchat.getBaseData();
				callFuncAddUserToMyFavouriteList(id);
			}

        };
    })();
 
})(jqcc);