/**
(function(){
var p = {
url:location.href,
showcount:'1', 
desc:'', 
summary:'', 
title:'', 
site:'', 
pics:'',  
style:'102',
width:145,
height:30
};
var s = [];
for(var i in p){
s.push(i + '=' + encodeURIComponent(p[i]||''));
}
document.write(['<a version="1.0" class="qzOpenerDiv" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?',s.join('&'),'" target="_blank">分享</a>'].join(''));
})();


document.write( '<script src="http://qzonestyle.gtimg.cn/qzone/app/qzlike/qzopensl.js#jsdate=20111201" charset="utf-8"></script>' );
**/
 
	 
	(function(){
	var p = {
	url:location.href,
	showcount:'1', 
	desc:'', 
	summary:'', 
	title:'', 
	site:'', 
	pics:'',  
	style:'103',
	width:135,
	height:22
	};
	var s = [];
	for(var i in p){
	s.push(i + '=' + encodeURIComponent(p[i]||''));
	}
	document.write(['<a version="1.0" class="qzOpenerDiv" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?',s.join('&'),'" target="_blank">分享</a>'].join(''));
	})();
	 
	document.write( '<script src="http://qzonestyle.gtimg.cn/qzone/app/qzlike/qzopensl.js#jsdate=20111201" charset="utf-8"></script>'); 
	 




