IK = (typeof IK === 'undefined')? function(fn){setTimeout(fn, 0);} : IK;
//IK事件模拟器
IKCOM = new Object();
IKCOM.EventMonitor = function(){
    this.listeners = new Object();
}
IKCOM.EventMonitor.prototype.broadcast=function(widgetObj, msg, data){
    var lst = this.listeners[msg];
    if(lst != null){
        for(var o in lst){
            lst[o](widgetObj, data);
        }
    }
}
IKCOM.EventMonitor.prototype.subscribe=function(msg, callback){
    var lst = this.listeners[msg];
    if (lst) {
        lst.push(callback);
    } else {
        this.listeners[msg] = [callback];
    }
}
IKCOM.EventMonitor.prototype.unsubscribe=function(msg, callback){
    var lst = this.listener[msg];
    if (lst != null){
        lst = lst.filter(function(ele, index, arr){return ele!=callback;});
    }
}
// Page scope event-monitor obj. 
var event_monitor = new IKCOM.EventMonitor();
// 装载监听
function load_event_monitor(root) {
    var re = /a_(\w+)/;
    var fns = {}; 
    $(".i", root).each(function(i) {
        var m = re.exec(this.className);  
        if (m) {
            var actionName = m[1],
                f = fns[actionName];
            if (!f) {
                f = eval("IKCOM.init_"+actionName);
                fns[actionName] = f;
            }
            f && f(this);
        }
    });
}
//推荐
IKCOM.init_recommend_btn = function(o){
    $(o).click(function(e){
		var self = $(e.currentTarget), posturl = self.attr('href');
					
		pop_win([
		'<div class="rectitle"><span class="m">推荐到爱客网</span></div>',
		'<div class="panel">',
		'<div class="frm-recbox">',
			'<div class="item">',
			'<textarea cols="30" rows="3" name="content" maxlength="150" id="status_textarea" style="color: rgb(34, 34, 34);"></textarea>',
			'</div>',
			'<div class="media-info">',
				'<h6><a title="'+self.data('title')+'" target="_blank" href="'+self.data('url')+'">'+self.data('title')+'</a></h6>',
				'<p class="desc">'+self.data('desc')+'</p>',
			'</div>',			
		'</div></div>',
		'<div class="rec-submit"><div class="bd"><span class="num" id="rec_txt_num">150</span>',
		'<span class="bn-flat"><input type="button" value="推荐" id="submit-rec-btn"></span></div></div>',		
		   ].join('') );
		$('#status_textarea').bind('keyup',function(){
			var num = 150 - $(this).val().length;
			$('#rec_txt_num').text(num);
		});
		$('#submit-rec-btn').bind('click',function(){
			var data = {
					tid: self.data('tid'),
					tkind: self.data('tkind'),
					uid: self.data('tuid'),
					content: $('#status_textarea').val()
					};
			$.post_withck(
				posturl,
				data,
				function (res) {
					var res = $.parseJSON(res);
					if(res.r==0)
					{
						pop_win(['<div class="panel" style="line-height:50px;font-size:14px">恭喜您，推荐成功了！</div>',].join('') );
						setTimeout(function(){pop_win.close()},800);
						$('#rec-num').text(res.num +'人');
					}else if(res.r==1){
						pop_win(['<div class="panel" style="line-height:50px;font-size:14px">'+res.html+'</div>',].join('') );
						setTimeout(function(){pop_win.close()},800);						
					}
				}
				
			);
			
		});		

        return false;
    });
}

//喜欢
IKCOM.init_like_btn = function(o){
    $(o).click(function(e){
		var self = $(e.currentTarget),
			posturl = self.attr('href'),
			data = {
					tid: self.data('tid'),
					tkind: self.data('tkind'),
					uid: self.data('tuid')
			};
		$.post_withck(
			posturl,
			data,
			function (res) {
				var res = $.parseJSON(res);
				if(res.r==1)
				{
					$('#like-num').text(res.num +'人');
					self.attr('title','标为喜欢');
					self.removeClass('fav-cancel');
					self.addClass('fav-add');					
				}else if(res.r==0)
				{
					$('#like-num').text(res.num +'人');
					self.attr('title','取消喜欢');
					self.removeClass('fav-add');
					self.addClass('fav-cancel');
				}
			}
		);	
        return false;
    });
}
//分享
IKCOM.init_share_btn = function(o){
    $(o).click(function(e){
		var self = $(e.currentTarget), shareDiv = '';
		
		var title = self.data('title'); //标题
		var content = self.data('desc');
		//var hash = window.document.getElementById("bigImage").src.replace(/.*key=([^&]+).*/,'$1');
		var siteUrl = self.data('url') ; //分享地址
		var img = self.data('pic'); //分享的图片
		
		var html = '<div id="db-div-sharing"><div class="hd" style="width: 46px;">&nbsp;</div>'+
    				'<div class="bd">'+
    				'<ul>'+
    				'<li class="rec-sina"><a class="i a_lnk_share" href="javascript:;" rel="http://v.t.sina.com.cn/share/share.php?appkey=|sina|'+title+'|'+content+'|'+siteUrl+'|'+img+'">新浪微博</a></li>'+
					'<li class="rec-tx"><a class="i a_lnk_share" href="javascript:;" rel="http://v.t.qq.com/share/share.php?source=|qzone|'+title+'|'+content+'|'+siteUrl+'|'+img+'">腾讯微博</a></li>'+					
    				'<li class="rec-qq"><a class="i a_lnk_share" href="javascript:;" rel="http://v.t.qq.com/share/share.php?source=|qzone|'+title+'|'+content+'|'+siteUrl+'|'+img+'">QQ空间</a></li>'+
    				'<li class="rec-ren"><a class="i a_lnk_share" href="javascript:;" rel="http://share.renren.com/share/buttonshare/post/1?|renren|'+title+'|'+content+'|'+siteUrl+'|'+img+'">人人网</a></li>'+
    				'<li class="rec-kx"><a class="i a_lnk_share" href="javascript:;" rel="http://www.kaixin001.com/repaste/share.php?|kaixing|'+title+'|'+content+'|'+siteUrl+'|'+img+'">开心网</a></li>'+
    				'<li class="rec-db"><a class="i a_lnk_share" href="javascript:;" rel="http://www.douban.com/recommend/?|douban|'+title+'|'+content+'|'+siteUrl+'|'+img+'">豆瓣</a></li>'+
    				'<li class="rec-msn"><a class="i a_lnk_share" href="javascript:;" rel="http://profile.live.com/badge?|msn|'+title+'|'+content+'|'+siteUrl+'|'+img+'">MSN</a></li>'+  
    				'</ul>'+
    				'</div> '+                       
    				'</div>';

		var left = self.offset().left, top = self.offset().top;
		self.addClass('bn-sharing-on');
		if($('body').find('#db-div-sharing').length>0)
		{
			shareDiv = $('#db-div-sharing');	
		}else{
			$('body').append(html);
			shareDiv = $('#db-div-sharing');
		}	
		shareDiv.css({'left':left-50, 'top':top+19}).slideDown(100);
		load_event_monitor('#db-div-sharing');
	    //改变窗口
		$(window).bind('resize', function() {
		   self.removeClass('bn-sharing-on');	
		   shareDiv.slideUp(100);
		});
		$(document).bind('click', function(e) {
			if($(e.target).parents('#db-div-sharing').length==0)
		    {shareDiv.slideUp(100);self.removeClass('bn-sharing-on');}
		});		
        return false;
    });
}
//转移==> js/lib/sharetool.js
IKCOM.init_lnk_share = function(o){ 
 	$(o).click(function(e){
		var el = $(this), param = el.attr('rel').split('|');
		var url = param[0];
		var stype = param[1];
		var title = param[2];
		var content = param[3];
		//var hash = window.document.getElementById("bigImage").src.replace(/.*key=([^&]+).*/,'$1');
		var siteUrl = param[4] ;
		var img = param[5];
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
		
		if (stype == "msn"){
			url = url + "url=" + siteUrl + pin + "&title=" + title + "&description=" + content + "&screenshot=" + img;
		}
				
		$('.bn-sharing').removeClass('bn-sharing-on');	
		$('#db-div-sharing').hide();
		window.open(encodeURI(url),"","height=500, width=600");	
		return false;
	});	
};
//IK ajax
$.post_withck = function( url, data, callback, type, traditional) {
    if ($.isFunction(data)) {
        type = callback;
        callback = data;
        data = {};
    }
    return $.ajax({
        type: "POST",
        traditional: typeof traditional == 'undefined' ? true : traditional,
        url: url,
        data: $.extend(data,{ck:get_cookie('ck')}),
        success: callback,
        dataType: type || 'text'
    });
};
// 转移==> core/cookie.js
var set_cookie = function(dict, days, domain, path){
    var date = new Date();
    date.setTime(date.getTime()+((days || 30)*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
    for (var i in dict){
        document.cookie = i+"="+dict[i]+expires+"; domain=" + (domain || "12ik.com") + "; path=" + (path || "/");
    }
}
// 转移==> core/cookie.js
function get_cookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length,c.length).replace(/\"/g,'');
        }
    }
    return null;
}
//转移==> core/tmpl.js
(function(){
    var cache = {};
    $.tmpl = function(str, data){
        var fn = cache[str] = cache[str] ||
        new Function("obj", "var p=[];with(obj){p.push('" +
         str.replace(/[\r\t\n]/g, " ")
         .replace(/'(?=[^%]*%})/g,"\t")
         .split("'").join("\\'")
         .split("\t").join("'")
         .replace(/{%=(.+?)%}/g, "',$1,'")
         .split("{%").join("');")
         .split("%}").join("p.push('")
         + "');}return p.join('');");
        return fn(data);
    }
})();

function pop_win (htm, hide_close) {
    if (!window.__pop_win) {
        var pop_win_bg = document.createElement('div');
        pop_win_bg.className = 'pop_win_bg';
        document.body.appendChild(pop_win_bg);

        var pop_win_body = document.createElement('div');
        pop_win_body.className = 'pop_win';
        document.body.appendChild(pop_win_body);

        __pop_win = {
            bg: pop_win_bg,
            body: pop_win_body,
            body_j: $(pop_win_body),
            bg_j: $(pop_win_bg)
        };
    }
    var b = __pop_win.body,
        body_j = __pop_win.body_j,
        dom = js_parser(htm);

    if (hide_close !== true) {
        dom.htm = '<a onclick="pop_win.close()" href="javascript:;" class="pop_win_close">X</a>' + dom.htm;
    }
    b.innerHTML = dom.htm;
    var cr = {
        left: '50%',
        top: '50%',
        marginLeft: -(b.offsetWidth/2) + 'px',
        marginTop: -(b.offsetHeight/2) + 'px'
    };
    if(document.documentElement.clientHeight<b.offsetHeight){
        cr.top = '0';
        cr.marginTop = '0';
        cr.height = document.documentElement.clientHeight - 40 + 'px';
        cr.overflow = 'auto';
    }
    body_j.css({ display: 'block' }).css(cr).css({ visibility: 'visible', zIndex: 9999});
    dom.js();
    pop_win.fit();
    if(!window.XMLHttpRequest){
        __pop_win.bg.style.top = '';
        __pop_win.bg.style.marginTop = '';
    }
}

pop_win.fit = function () {
    if (window.__pop_win) {
        var b=__pop_win.body;
        var h = b.offsetHeight + 16;
        var w = b.offsetWidth + 16;
        __pop_win.bg_j.css({
            height: h + 'px',
            width: w + 'px',
            left: '50%',
            top: '50%',
            marginTop: -(h/2) + 'px',
            marginLeft: -(w/2) + 'px',
            zIndex: 8888
        }).show();
    }
}

pop_win.close=function(){
    $(__pop_win.bg).remove()
    $(__pop_win.body).remove();
    window.__pop_win = null;
}

pop_win.load=function(url,cache){
    pop_win("<div style=\"padding:20px 60px;\">加载中, 请稍等...</div>")
    $.ajax({url: url, success: pop_win, cache: cache||false, dataType: 'html'});
    return false
}
function js_parser(htm){
    var tag="script>",begin="<"+tag,end="</"+tag,pos=pos_pre=0,result=script="";
    while(
        (pos=htm.indexOf(begin,pos))+1
    ){
        result+=htm.substring(pos_pre,pos);
        pos+=8;
        pos_pre=htm.indexOf(end,pos);
        if(pos_pre<0){
            break;
        }
        script+=htm.substring(pos,pos_pre)+";";
        pos_pre+=9;
    }
    result+=htm.substring(pos_pre,htm.length);

    return {
        htm:result,
        js:function(){eval(script)}
    };
}
var paras = function(s){
    var o = {};
    if(s.indexOf('?') == -1) return {};
    var vs = s.split('?')[1].split('&');
    for(var i=0;i<vs.length;i++){
        if(vs[i].indexOf('=') != -1){
            var k = vs[i].split('=');
            o[k[0]+''] = k[1] + '';
        }
    }
    return o;
}
jQuery.fn.extend({
	insert_caret:function(t){
        var o = this[0];
        if(document.all && o.createTextRange && o.p){
            var p=o.p;
            p.text = p.text.charAt(p.text.length-1) == '' ? t+'' : t;
        } else if(o.setSelectionRange){
            var s=o.selectionStart;
            var e=o.selectionEnd;
            var t1=o.value.substring(0,s);
            var t2=o.value.substring(e);
            o.value=t1+t+t2;
            o.focus();
            var len=t.length;
            o.setSelectionRange(s+len,s+len);
            o.blur();
        } else {
            o.value+=t;
        }
    },	
    get_sel:function(){
        var o = this[0];
        return document.all && o.createTextRange && o.p ?
            o.p.text : o.setSelectionRange ?
            o.value.substring(o.selectionStart,o.selectionEnd) : '';
    }	
});

$(function() {
    load_event_monitor(document);
    // request_log_ad_displays();
});