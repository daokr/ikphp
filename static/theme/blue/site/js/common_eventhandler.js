(function(){


Douban.init_rec_btn = function(e) {

var show_dialog = function(s, cb) {
  Do('dialog', function(){
    var dlg = dui.Dialog({
      title: '推荐',
      content: s,
      width: 500,
      buttons: [
      {
        text: '确定',
        method: function(o){
          o.footer.find('input:submit, input:button').attr('disabled', 1);
          o.submit(function(res){
              var dlg = dui.Dialog({
                  width: 300,
                  iframe: true,
                  isHideClose: true,
                  isHideTitle: true, 
                  content: '<div class="dlg-success">推荐已成功提交！</div>'
                  }, true).open();
             o.close();
             setTimeout(function(){dlg.close();dlg.node.remove();}, 500);
          });
        }
      },
      'cancel']
    }),
    frm;

    dlg.open();

    if (cb) {
      cb(dlg);
    }

    dlg.setTitle(dlg.node.find('.rectitle .m').html() || '推荐');
    dlg.updateSize();
    dlg.updatePosition();

    frm = dlg.node.find('form');
    frm.append('<input type="hidden" name="ck" value="' + get_cookie('ck') + '">');
    frm.find('.reccomment label').click(function(){ $(this).next().focus(); });
    frm.find('.reccomment textarea').focus(function(){ 
        $(this).css('border-color', '#666').prev().hide(); 
    }).blur(function(e){
        var el = $(this);
        if ($.trim(el.val()) === '') {
          el.css('border-color', '').prev().show(); 
        }
    });
  });
},

  that = $(this), 
  _ = that.attr('name').split('-'), 
  cur_date = that.attr('data-date')
  url = '/j/recommend',
  rdialog = 'rdialog-' + _[1] + '-' + _[2],
  f = function () {
     var uid = ((_[1] == 'I')&&(_[2]==undefined)) ? $('input',$(o).parent())[0].value : _[2],
         rec = (_[3]==undefined) ? '':_[3],
         fcs = function(type, node){
           var s;
           if(type == 'I'){
             s = $('.text', node);
             if(s.length){
               if(s[0].value.length){s[1].focus();}
             else{s[0].focus();}
             }
           }else{
             node.find(':submit').focus();
           }

           if (that.hasClass('novote')){ 
             //it's a new test version of rec btn
             $('form', node).append('<input name="novote" value="1" type="hidden">');
           }
         };

         if($('#' + rdialog).length){
           show_dialog($('#' + rdialog).html(), function(o){
             fcs(_[1], o.node);
           });
         }else{
           $.getJSON(url, {type:_[1], uid:uid, rec:rec, date:cur_date}, function(r){
             var rechtml;
             show_dialog(r.html, function(o){
               if(_[1]!='I'){
                 rechtml = $('<div id="'+rdialog+'"></div>');
                 rechtml.html(r.html).appendTo('body').hide();
               }
               fcs(_[1], o.node);
             });
          });
        }
  };

  f();
  if(_[1] == 'I'){
    that.parent().parent().submit(f);
  }
};

Douban.init_show_login = function (e) {
  IK('dialog', function(){
    var api = siteUrl + 'user/misc/login';
    dui.Dialog({
      title: '登录',
      url: api,
      width: 350,
      cache: true,
      callback: function(da, o) {
        o.node.addClass('dialog-login');
        o.node.find('h2').css('display', 'none');
        o.node.find('.hd h3').replaceWith(o.node.find('.bd h3'));
        o.node.find('form').css({
          border: 'none',
          width: 'auto',
          padding: '0'
        });
        o.updateSize();
        o.updatePosition();
      }
    }).open();
  });
}; 

Douban.init_click_tip = function(e){
  var el = $(this), 
      mark = 'a_click_tip_inited',
      tip = el.parent().find('.blocktip');
  tip.show().blur_hide();
  m = tip.width() + tip.pos().x - $.viewport_size()[0] > 0?  -tip.width() : 0;
  tip.css('margin-left', m);
  if (!el.hasClass(mark)) {
    $('.hideme',tip).click(function(){ tip.hide(); });
    el.addClass(mark);
  }
};

Douban.init_confirm_link = function(e) {
  var el = $(this), text = el.attr('title') || el.text();
  if(confirm(text)){
      self.location = el.attr('href');
  }
};

Douban.init_rating_stars = function(o) {
    var ratewords = {1:'很差', 2:'较差', 3:'还行', 4:'推荐', 5:'力荐'}, 
    num = $('#n_rating'),
    stars = o.find('img'),
    handle = function(i) {
        var rating = num.val() || 0;
        stars.each(function(j){
            this.src =  this.src.replace(/\w*\.gif$/, ((j<i) ? 'sth' : ((j<rating) ? 'st' : 'nst')) + '.gif');
        });
        if (i) {
                $('#rateword').text(ratewords[i]);
        } else {
                $('#rateword').text(rating ? ratewords[rating] : '');
        }
    };

    stars.hover(function(){
        handle(parseInt(this.id.match(/\d+/)[0]));
    },
    function(){
        handle(0);
    });

    if(num.attr('name')){
        stars.click(function(){
            var rating = parseInt(this.id.match(/\d+/)[0]);
            num.val(rating);
            handle(rating);
        });
    }
};

Douban.init_collect_btn = function(e) {
            var _ = $(this).attr('name').split('-'),
            btn_type = _[0], sid = _[1],
            interest = _[2], rating = _[3],
            url = '/j/subject/'+sid+'/interest?'+
            (interest ? 'interest='+interest : '')+
            (rating ? '&rating='+rating : '')+
            (btn_type == 'cbtn' ? '&cmt=1':''),
            populate_tag_btns = function(title, div, tags, hash){
                if (tags.length) {
                    var p = $('<dl><dt>'+title+'</dt></dl>'),d = $('<dd></dd>');
                    $.each(tags, function(i,tag) {
                      var btn = $('<span class="tagbtn"/>').addClass(hash[tag.toLowerCase()]?'rdact':'gract').text(tag);
                          d.append(btn).append(' &nbsp; ');
                      });
                    p.append(d);
                    div.append(p);
                }
            };
            

            Do('dialog', function(){
                var tags,
                content,
                hash = {},
                oprd,
                rate,
                r,
                f,
                save = function(o){
                    var frm = o.node.find('form'),
                    da = Douban.get_form_fields(frm);
                    $(':submit', o.node).css('disabled', 1);
                    $.post_withck(frm.attr('action'), 
                    da, 
                    function(e){
                        o.close();
                    }, 
                    'json');
                },
 
                updateUI = function(o){
                  $('.gact,.bd h2,form input:submit, form input:button', o.node).hide();
                  $('input[name=tags]', o.node).val((content.length > 1)? content + ' ' : content)
                  $.each(tags, function(i,tag){hash[tag.toLowerCase()]=true;});
                  populate_tag_btns('我的标签:', $('#mytags', o.node), r['my_tags'], hash);
                  populate_tag_btns("常用标签:", $('#populartags', o.node), r['popular_tags'], hash);
                  $('form', o.node).append('<input type="hidden" name="ck" value="' + get_cookie('ck') + '">');
                },

                bindEvent = function(o){
                    var frm = o.node.find('form'),
                    timer,
                    rating,
                    checkLength = function(e){
                        var el = $(this),
                        max = 140,
                        err = el.next(),
                        frm = el.parents('form');

                        if ($.trim(el.val()).length > max) {
                            frm.data('hasError', 1);
                            if (!err.hasClass('attn')) {
                                err = $('<div class="attn"></div>').insertAfter(el);
                            }
                            err.html('最多只能写' + max + '字');
                            o.updateSize();
                            o.updatePosition();
                        } else if(err.hasClass('attn')) {
                            err.html('');
                            o.updateSize();
                            o.updatePosition();
                        }
                    };

                    $('#showtags').click(function(){
                      if($('#advtags').is(':hidden')){
                        $(this).html('缩起 ▲');
                        $('#advtags').show();
                        $('#foldcollect').val('U');
                      }else{
                        $(this).html($(this).attr('rel'));
                        $('#advtags').hide();
                        $('#foldcollect').val('F');
                      }
                      $(this).blur();
                      o.updateSize();
                      o.updatePosition();
                    });

                    frm.submit(function(e){
                        e.preventDefault();
                        save(o);
                    });

                    $('#populartags .tagbtn').click(function(e){
                        var el = $(e.currentTarget), 
                        word = el.html(), 
                        inp = frm[0].elements['tags'];

                        if ((' ' + inp.value + ' ').indexOf(' ' + word + ' ') + 1){
                            el.removeClass('selected');
                            inp.value =  $.trim((' ' + inp.value + ' ').replace(' ' + word + ' ', ' '));
                        } else {
                            el.addClass('selected');
                            inp.value =  $.trim(inp.value + ' ' + word);
                        }
                    });

                    $('input[name=tags]', frm).keyup(function(e){
                        var inp = $(this);
                        if (timer) {
                            window.clearTimeout(timer);
                        }

                        timer = window.setTimeout(function(){
                            var tags = $('#populartags .tagbtn');

                            tags.removeClass('selected');
                            $($.trim(inp[0].value).split(' ')).each(function(i, tag){
                                tags.each(function(i, e){
                                    var el = $(e);
                                    if ( el.html() === tag) {
                                        el.addClass('selected');
                                    }
                                });
                            });
                        }, 500);
                    });

                    $('textarea[name=comment]', frm).keyup(checkLength).mouseup(checkLength);
                    rating = o.node.find('.a_stars'); 
                    if (rating.length) {
                        Douban.init_rating_stars(rating);
                    }
                };

                dui.Dialog({
                    isHideTitle: true,
                    width: 500,
                    url: url,
                    buttons: [
                    {
                      text: '保存',
                      method: function(o){
                          save(o);
                      }
                    },
                    'cancel'],
                    callback: function(res, o){
                        r = res,
                        tags = r.tags;
                        content = tags.join(' ');

                        o.setContent('<div class="collect-dialog">' + r.html + '</div>');
                        o.setTitle(o.node.find('h2').html());
                        o.node.find('.hd').show();

                        updateUI(o);
                        bindEvent(o);

                        o.updateSize();
                        o.updatePosition();
                    }
                }).open();
            });
};

Douban.init_post_link = function(e) {
    var el = $(this),
        href = el.attr("href"),
        text = el.attr("title") || el.text() + "?",
        post_url = href.split("?")[0],
        post_args = {},
        args = href.split("?")[1] || [];
    
    if (typeof args === 'string') {
        args = args.split("&");
    }
    
    e.preventDefault();
    
    // prevent continuous click
    if (el.hasClass('processing')) {
        return;
    };

    // parse query string
    for (i=0; i<args.length; i++) {
        var pair = args[i].split("=");
        post_args[pair[0]] = pair[1];
    }
    
    // first confirm the operation
    if (confirm(text)) {
        el.addClass('processing');
        $.post_withck(post_url, post_args, 
        function(e){
            el.removeClass('processing');
            location.reload(true);
        });
    }
};


//自变改变聊天室窗口大小
Douban.autoUpdateChatWindow = function(h) {
  if (!Douban.currentChatWindow) {
    return;
  }
  var dlg = Douban.currentChatWindow;
  dlg.node.find('iframe')[0].height = h;
  dlg.update();
};

//打开聊天室
Douban.init_chat_room = function(e) {
  var el = $(this),
  init = function(){
    var dlg = dui.Dialog({
      content: '<iframe src="' + el.attr('href') + '" width="100%" height="200" frameborder="0" scrolling="no"></iframe>',
      isHideTitle: true,
      width: 650
    }).open();
    dlg.node.find('.dui-dialog-close').unbind().click(function(){
      if (confirm('确认要离开聊天室吗?')) {
        dlg.node.find('iframe')[0].contentWindow.onWindowClose();
        dlg.setContent('');
        dlg.close();
      }
    });
    dlg.node.addClass('dialog-chat');
    Douban.currentChatWindow = dlg;
  };

  Do('dialog', init);
};


//聊天室激活和续租
Douban.init_chat_activate = function(e) {
    var el = $(this),
    // param: id|datetime|balance|is_relet
    param = el.attr('href').split('#')[1].split('|'),
    balance = param[2],
    label = typeof param[3] === 'undefined'? '激活' : '续租',
    dlg,
    content = '<div class="join-tips"><h3>' + label + '聊天桌需要花 '+ CHAT_FEE +' 颗小豆</h3><p>使用期限: ' + (param[1] || '(未激活)') + '</p></div>',
    handleActivate = function() {
        $.getJSON('/j/widget/chat/' + param[0] + '/activate', {}, function (o) {
             failure = {
               content: label + '失败:' + o.error, 
               buttons: ['confirm']
             };

             if (o.r == 1) {
               location.reload();
             }else{
               dlg.set(failure);
             }
        });
    },
    buttons = [{text: label, method: handleActivate}, 'cancel'];

    if (balance < CHAT_FEE) {
        content = '<div class="join-tips"><h3>' + label + '聊天桌需要花 '+ CHAT_FEE +' 颗小豆</h3>'
                + '<p>使用期限: ' + (param[1] || '(未激活)') + '</p>'
                + '<p>目前小豆数: <span style="color:red">' + balance + '</span></p></div>';
        buttons = [{
            text: '知道了', 
            method: function() { 
                dlg.close();
            }
        }];
    }

    Do('dialog', function(){
       dlg = dui.Dialog();
       dlg.set({
        width: 350,
        content: content,
        buttons: buttons
      }).open();

      dlg.updateSize();
      dlg.updatePosition();
    });
};


})();
