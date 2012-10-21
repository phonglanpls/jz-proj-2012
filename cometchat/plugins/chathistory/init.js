<?php

		include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/en.php";

		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php")) {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php";
		} 

		foreach ($chathistory_language as $i => $l) {
			$chathistory_language[$i] = str_replace("'", "\'", $l);
		}
?>

/*
 * CometChat
 * Copyright (c) 2012 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccchathistory = (function () {

		var title = '<?php echo $chathistory_language[0];?>';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				baseUrl = $.cometchat.getBaseUrl();
				baseData = $.cometchat.getBaseData();
				loadCCPopup(baseUrl+'plugins/chathistory/index.php?history='+id+'&basedata='+baseData, 'chathistory',"status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=1, width=640,height=480",640,480,'<?php echo $chathistory_language[6];?>'); 
			}

        };
    })();
 
})(jqcc);