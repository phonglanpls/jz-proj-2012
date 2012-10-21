
/*
 * CometChat
 * Copyright (c) 2012 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccpet = (function () {

		var title = 'Buy as a pet';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				//baseUrl = $.cometchat.getBaseUrl();
				//baseData = $.cometchat.getBaseData();
				callFuncAddThisPet(id);
			}

        };
    })();
 
})(jqcc);