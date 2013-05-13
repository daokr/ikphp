(function(){
  var site_list = /http:\/\/movie.douban.com\/sogou_search|http:\/\/audit.douban.com/;
  if (self !== top && document.referrer.search(site_list) === -1) {
    top.location = self.location;
  }
})();

var Douban = Douban || {};

if (top.location !== self.location && document.referrer.search(/http:\/\/[^\/]+\.douban\.com/i) !== 0) {
  top.location = self.location;
}

Douban.errdetail = [
    '','未知错误','文件过大',
    '信息不全','域名错误','分类错误',
    '用户错误','权限不足','没有文件',
    '保存文件错误','不支持的文件格式','超时',
    '文件格式有误','','添加文件出错',
    '已经达到容量上限','不存在的相册','删除失败',
    '错误的MP3文件','有禁用的内容,请修改重试'];

Douban.trace = function(o){
    if(!/^http:\/\/(www|movie|music\.|book|douban\.fm)/.test(location.href) && window.console && window.console.log){
        $(arguments).each(console.log);
    }
}

Douban.report = function(s){$.get('/j/report?e='+s)}


Douban.get_form_fields = function(form) {
    var param = {};
    $(':input', form).each(function(i){
        var name = this.name;
        if (this.type == 'radio') {
            if (this.checked) param[name] = this.value;
        } else if (this.type == 'checkbox') {
            if (this.checked) param[name] = this.value;
        } else if (this.type == 'submit'){
            if (/selected/.test(this.className)) param[name] = this.value;
        } else {
            if (name) param[name] = this.value;
        }
        if(/notnull/.test(this.className) && this.value == ''){
            $(this).prev().addClass('errnotnull');
            param['err'] = 'notnull';
        }
    });
    return param;
};

Douban.check_form = function(form){
    var _re = true;
    $(':input',form).each(function(){
        if((/notnull/.test(this.className) && this.value == '')
            || (/most/.test(this.className) && this.value && this.value.length>/most(\d*)/.exec(this.className)[1]))
        {
            $(this).next().show();
            _re = false;
        }else{
            if(/attn/.test($(this).next().attr('className'))) $(this).next().hide();
        }
    })
    return _re;
};

Douban.remote_submit_json = function(form, func, disable, action) {
    var fvalue = Douban.get_form_fields(form);
    if(fvalue['err'] != undefined) return;
    $(':submit,:input',form).attr('disabled',disable==false?0:1);
    var act = action || form.action;
    $.post_withck(act, fvalue, function(ret){
        func(ret);
    }, 'json');
};

Douban.initHandler = function(selector, eventType, callback, root, context) {
  $(root || 'body').delegate(selector, eventType, $.proxy(function(e){
      e.preventDefault();
      callback.call(this, e);
    }, context));
};

var set_cookie = function(dict, days){
    days = days || 30;
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
    for (var i in dict){
        document.cookie = i+"="+dict[i]+expires+"; path=/";
    }
};

var get_cookie = function(name) {
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
};

var paras = function(s){
  var o = {};
  if(s.indexOf('?') == -1) return {};
  var vs = s.split('?')[1].split('&');
  for(var i=0;i<vs.length;i++){
    if(vs[i].indexOf('=') != -1){
      var k = vs[i].split('=');
      o[k[0]] = k[1];
    }
  }
  return o;
}


$('html').click(function(e){
    var el = $(e.target), 
    classname = el.attr('class');
	if (classname === '' || typeof classname === 'undefined') {
      return;
    }
	//console.log(classname.match(/a_(\w+)/gi))
    $(classname.match(/a_(\w+)/gi)).each($.proxy(function(i, n){
    var fn = Douban[n.replace(/^a_/, 'init_')];
    if (typeof fn === 'function') {
        e.preventDefault();
        fn.call(this, e);
    }
    }, el[0]));
}); 

$.viewport_size = function(){
    var size = [0, 0];
    if (typeof window.innerWidth != 'undefined'){
        size = [window.innerWidth, window.innerHeight];
    }else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0){
        size = [document.documentElement.clientWidth, document.documentElement.clientHeight];
    }else{
        size = [document.body.clientWidth, document.body.clientHeight];
    }
    return size;
}

$.ajax_withck = function(options){
    if(options.type=="POST")
        options.data=$.extend(options.data||{},{ck:get_cookie('ck')});
    return $.ajax(options)
}

$.postJSON_withck = function(url, data, callback){
    $.post_withck(url, data, callback, "json");
}

$.post_withck = function( url, data, callback, type ) {
    if ($.isFunction(data)) {
        type = callback;
        callback = data;
        data = {};
    }
    return $.ajax({
        type: "POST",
        url: url,
        data: $.extend(data,{ck:get_cookie('ck')}),
        success: callback,
        dataType: type || 'text'
    });
};

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

jQuery.fn.extend({
    pos:function() {
        var o = this[0];
        if(o.offsetParent) {
            for(var posX=0, posY=0; o.offsetParent; o=o.offsetParent){
                posX += o.offsetLeft;
                posY += o.offsetTop;
            }
            return {x:posX, y:posY};
        } else return {x:o.x, y:o.y};
    },

    chop: function(callback, inv ) {
        var ret = [], nret = [];
        for ( var i = 0, length = this.length; i < length; i++ )
            if ( !inv != !callback( this[i], i )){
                ret.push( this[i] );
            } else {
                nret.push( this[i] );
            }
        return [ret, nret];
    },
    sum: function(name, sp){
        var len = this.length, s = zero = sp ? '' : 0;
        while(len) s += this[--len][name] + (len && sp || zero);
        return s
    },
    set_len_limit : function(limit){
        var s = this.find(':submit:first');
        var oldv = s.attr('value');
        var check = function(){
            if(this.value && this.value.length > limit){
                s.attr('disabled',1).attr('value','å­—æ•°ä¸èƒ½è¶…è¿‡'+limit+'å­—');
            } else {
                s.attr('disabled',0).attr('value', oldv);
            }
        }
        $('textarea', this).focus(check).blur(check).keydown(check).keyup(check);
    },

    display_limit : function(limit, n){
        var self = this, oldv,
        f = function(e){
            var v = self.val();
            if (v == oldv) return;
            if (v.length>=limit){
                self.val(v.substring(0, limit));
            }
            n.text(limit - self.val().length);
            oldv = self.val();
        };
        this.keyup(f);
        f();
    },

    set_caret: function(){
        if(!$.browser.msie) return;
        var initSetCaret = function(){this.p = document.selection.createRange().duplicate()};
        this.click(initSetCaret).select(initSetCaret).keyup(initSetCaret);
    },

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
    },
    blur_hide:function(){
        var s=this,h=function(){return false};
        s.mousedown(h)
        $(document.body).mousedown(function(){
            s.hide().unbind('mousedown',h)
            $(document.body).unbind('mousedown',arguments.callee);
        })
        return this;
    },
    yellow_fade:function() {
        var m = 0,setp=1,self=this;
        function _yellow_fade(){
            self.css({backgroundColor:"rgb(100%,100%,"+m+"%)"})
            m += setp;setp+=.5;
            if(m <= 100){
                setTimeout(_yellow_fade,35)
            }else{
                self.css({backgroundColor:""})
            }
        };
        _yellow_fade();
        return this;
    },

    hover_fold:function(type){
        var i = {folder:[1,3], unfolder:[0,2]}, s = function(o,n){
            return function(){$('img',o).attr("src","/pics/arrow"+n+".gif");}
        }
        return this.hover(s(this,i[type][0]),s(this,i[type][1]));
    },

    multiselect:function(opt){
        var nfunc = function(){return true},
        onselect = opt.onselect || nfunc,
        onremove = opt.onremove || nfunc,
        onchange = opt.onchange || nfunc,
        sel = opt.selclass || 'sel',
        values = opt.values || [];
        return this.click(function(){
            var id = /id(\d*)/.exec(this.className)[1],
            i = $.inArray(id, values);
            if(i != -1){
                if (!onremove(this)) return;
                values.splice(i,1);
                $(this).removeClass(sel);
            }else{
                if (!onselect(this)) return;
                values.push(id);
                $(this).addClass(sel);
            }
            onchange(values);
            return false;
        })
    }
});

try { document.execCommand("BackgroundImageCache", false, true); } catch(err) {}

Douban.init_donate = function(){
    var templ_container  = '<div class="blocktip dou-tip">{BODY}</div>',
        templ_form = '<form action="" method="post"><div class="frm-item">你将向{{= to_whom}}赠送<b>1</b>颗小豆</div><div class="frm-item"><label for="dou-inp-msg">顺带捎个话...</label><input id="dou-inp-msg" type="text" name="note"></div><div class="frm-submit"><span class="bn-flat"><input type="submit" value="送出"></span><a href="#" class="tip-bn-cancel">取消</a></div></form>',
        templ_tip = '<p>“感谢”将向作者赠送<b>1</b>颗小豆，你还没有小豆。<br><a href="http://www.douban.com/help/account#t4-q1">怎样获取小豆?</a></p><span class="bn-flat"><input type="button" class="tip-bn-cancel"  value="知道了"></span>',
        templ_error = '<span class="donated-fail">{MSG}</span>',
        templ_success = '<span class="donated-success">{MSG}</span>',
        templ_processing = '<p>处理中，请稍候...</p>',

        css_closetip = '.tip-bn-cancel',
        css_process = 'processing',

        displayError = function(node, msg) {
            node.replaceWith(templ_error.replace('{MSG}', msg));
            hideOverlay();
        },

        showOverlay = function(cont, node) {
            hideOverlay();
            var overlay = $(templ_container.replace('{BODY}', cont)).appendTo('body'), 
                pos = node.offset(),
                overlay_pos = [],
                win = $(window),
                winH = win.scrollTop() + win.height();

            if ((winH - pos.top) < (overlay.height() + 20)) {
                overlay_pos = [pos.left, pos.top - overlay.height() - node.height()];
            } else {
                overlay_pos = [pos.left, pos.top + node.height()];
            }

            overlay.css({
                position: 'absolute',
                left: overlay_pos[0] + 'px', 
                top: overlay_pos[1] + 'px' 
            });

            return overlay.show();
        },

        hideOverlay = function() {
            $('.dou-tip').remove();
        },

        updateOverlay = function(overlay, node) {
            var pos = node.offset(),
            overlay_pos = [],
            win = $(window),
            winH = win.scrollTop() + win.height();

            if ((winH - pos.top) < (overlay.height() + 20)) {
                overlay_pos = [pos.left, pos.top - overlay.height() - node.height()];
            } else {
                overlay_pos = [pos.left, pos.top + node.height()];
            }

            overlay.css({
                left: overlay_pos[0] + 'px', 
                top: overlay_pos[1] + 'px' 
            });
        },

        handleDonateSubmit = function(e) {
            var handler = function(ret) {
                if (ret.error) {
                    this.elm.replaceWith(templ_error.replace('{MSG}', ret.error));
                } else {
                    this.elm.replaceWith(templ_success.replace('{MSG}', ret.msg));
                }
                hideOverlay();
            };
            e.preventDefault();
            this.args.is_first = 0;
            this.args.note = $.trim(e.target.elements['note'].value);
            this.relateTip.html(templ_processing);
            updateOverlay(this.relateTip, this.elm);
            $.dataPoster(this.url, this.args, $.proxy(handler, this), 'post', 'json');
        },

        handleCloseTip = function(e) {
            e.preventDefault();
            hideOverlay();
            if (this.elm) {
                this.elm.removeClass(css_process);
            }
        },

        handler = function(ret){
            var elm = this.elm, pos, bn, tip;

            if (ret.error) {
                displayError(elm, ret.error);
                return;
            }

            if (ret.balance) {
                templ_form = templ_form.replace('{{= to_whom}}', '小站');
                tip = showOverlay(templ_form, elm);
                this.relateTip = tip;
                tip.find('form').bind('submit', $.proxy(handleDonateSubmit, this));
                tip.find(css_closetip).bind('click', $.proxy(handleCloseTip, this));
                tip.find('input[type=text]').bind({
                    'focusin': function(e){
                        $(this).prev().hide();
                    },
                    'focusout': function(e){
                        if (this.value === '') {
                            $(this).prev().show();
                        }
                    }
                });
            } else {
                // 余额不足
                tip = showOverlay(templ_tip, elm);
                tip.css('width', 260 + 'px');
                this.relateTip = tip;
                tip.find(css_closetip).bind('click', $.proxy(handleCloseTip, this));
            }

            $(window).bind('resize', function() {
                updateOverlay(tip, elm);
            });
        };

    $('body').delegate('.btn-donate', 'click', function(e){
        var elm = $(e.currentTarget),
        url = elm.attr('href').split('?'), 
        param,
        p, i, len,
        o = {
            elm: elm
        },
        args = {is_first: 1};

    e.preventDefault();
    if (elm.hasClass(css_process)) {
        return;
    }
    elm.addClass(css_process);
    if (url[1]) {
        param = url[1].split('&');
        for (i = 0, len = param.length; i<len; i++) {
            p = param[i].split('=');
            args[p[0]] = p[1] || '';
        }
    }

    o.args = args;
    o.url = url[0];
    $.dataPoster(url[0], args, $.proxy(handler, o), 'post', 'json');
    });
};

var moreurl = function(self, dict){
    var more = ['ref='+encodeURIComponent(location.pathname)];
    for (var i in dict) more.push(i + '=' + dict[i]);
    set_cookie({report:more.join('&')}, 0.0001)
}
