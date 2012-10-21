function isUrl(s) {
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
	return regexp.test(s);
}

function isNaturalNumber( sText ) {
    var re = /^[\d]+$/;
	return re.test( sText );
}

function isIntNumber( sText ) {
    if( sText.toString( ) == '-0' ) return false;
	
	var re = /^\-?[\d]+$/;
	return re.test( sText );
	
}
 
function isFloatNumber( sText ) {
	if( sText.toString( ) == '-0' ) return false;
	
	var re = /^\-?[\d]+$/;
	if( re.test( sText ) ) return true;
	re = /^\-?[\d]+\.[\d]+$/;
	return re.test( sText );
} 

function isEmpty( sText ) {
	if( sText ) return false;
    
	return true;
}

function isNumberFormat( sText, sFormat ) {
	var specCharPattern = /[\D]/;
	var specChar = sFormat.match( specCharPattern );
	var aNum = sFormat.split( specChar );
	
	var sCmd = "var re = /^";
	for( var iC = 0; iC < aNum.length; iC++ ) {
		if( iC != 0 )
			sCmd += "\\" + specChar; 
		sCmd += "[0-9]{" + aNum[iC] + "}";
	}
	sCmd += "$/;";
	eval( sCmd );
	return re.test( sText );
}
 
function isEmail( sText ) {
    var str = sText;
	if(str == "") {
        return false;
    }
    var re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
    if (!str.match(re)) {
        return false;
    } else {
        return true;
    }
}


function stdzSlashes(dm) {
	var len = dm.elements.length;
	var i = 0;
	for(i = 0; i < len; i++) {
		if( dm.elements[i].value ) {
			dm.elements[i].value = dm.elements[i].value.replace(RegExp("\'{1}" , "g"), "\\\'");
		}
	}
	return true;
}


function addSlashes( sText ) {
	if( sText) {
		return sText.replace(/'|\\'/g, "\\'");
	} else
		return sText;
}

Array.prototype.in_array = function(p_val) {
	 for(var i = 0, l = this.length; i < l; i++) {
		  if(this[i] == p_val) {
			  return true;
		  }
	 }
	 return false;
}

// ex: arr.remove(value);
Array.prototype.remove= function(){
    var what, a= arguments, L= a.length, ax;
    while(L && this.length){
        what= a[--L];
        while((ax= this.indexOf(what))!= -1){
            this.splice(ax, 1);
        }
    }
    return this;
}


function urlencode (str) {
    str = (str + '').toString();
   
    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
    replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
}	
	
//remove arr by index
Array.prototype.removeAr = function(from, to) {
	  var rest = this.slice((to || from) + 1 || this.length);
	  this.length = from < 0 ? this.length + from : from;
	  return this.push.apply(this, rest);
}

//remove all element in array
var removeAll = function(array){
	if(array.length == 0) return;
	array.removeAr(0);
	removeAll(array);
}

function removeArrayElement(array, item){
    for(var i in array){
        if(array[i]==item){
            array.splice(i,1);
            break;
        }
    }
	return array;
}

function pausecomp(ms) {
	ms += new Date().getTime();
	while (new Date() < ms){}
} 

jQuery.fn.center = function() {
    return this.each(function(){
                var el = $(this);
                var h = el.height();
                var w = el.width();
                var w_box = $(window).width();
                var h_box = $(window).height(); 
                var w_total = (w_box - w)/2; //400
                var h_total = (h_box - h)/2;
                var css = {"position": 'absolute', "left": w_total+"px", "top":h_total+"px"};//

                el.css(css)
    });
};

function queryurl(url){
	window.location = url;
}

function reload(){
	window.location.reload();
}

(function(a){jQuery.browser.mobile=/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);

function getMultiCheckbox(name){
	var allVals = [];
	$('input[name='+name+'\\[\\]]:checked').each(function() {
	   allVals.push($(this).val());
	});
	return allVals;
}

function getArrayNameTextInput(name){
	var allVals = [];
	$('input[name='+name+'\\[\\]]').each(function() {
	   allVals.push($(this).val());
	});
	return allVals;
}

function daysInMonth(Month, Year)
{
 return 32 - new Date(Year, Month, 32).getDate();
}

function debug(msg){
	if(WMODE == 'dev'){
		alert(msg);
	}	
}

function uniqueid(){
    // always start with a letter (for DOM friendlyness)
    var idstr=String.fromCharCode(Math.floor((Math.random()*25)+65));
    do {                
        // between numbers and characters (48 is 0 and 90 is Z (42-48 = 90)
        var ascicode=Math.floor((Math.random()*42)+48);
        if (ascicode<58 || ascicode>64){
            // exclude all chars between : (58) and @ (64)
            idstr+=String.fromCharCode(ascicode);    
        }                
    } while (idstr.length<32);

    return (idstr);
}