(function(){
  Douban.init_lnk_share = function(e){ 
  	var el = $(this), param = el.attr('rel').split('|');
	
	var url = param[0];
	var stype = param[1];
	var title = param[2];
	var content = param[3];
	//var hash = window.document.getElementById("bigImage").src.replace(/.*key=([^&]+).*/,'$1');
	var img ="";
	var siteUrl = param[4] ;
	var pin = "";

	if (stype == "qzone"){
		url = url + "&title=" + content + "&pic=" + img + "&url=" + siteUrl + pin;
	}
	
	if (stype == "sina"){
		url = url + "&title=" + content + "&pic=" + img + "&url=" + siteUrl + pin;
	}
	
	if (stype == "renren"){
		url = url + "title=" + title +"&content="+ content + "&pic=" + img + "&url=" + siteUrl + pin;
	}
	
	if (stype == "kaixing"){
		url = url + "rtitle=" + title + "&rcontent=" + content + "&rurl=" + siteUrl + pin;
	}
	
	if (stype == "douban"){
		url = url + "title=" + title + "&comment=" + content + "&url=" + siteUrl + pin;
	}
	
	if (stype == "MSN"){
		url = url + "url=" + siteUrl + pin + "&title=" + title + "&description=" + content + "&screenshot=" + img;
	}

	window.open(encodeURI(url),"","height=500, width=600");
  };

})();

