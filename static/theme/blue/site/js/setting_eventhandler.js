(function(){

 var isIE8 = $.browser.msie && parseInt($.browser.version) === 8,
 siteId = $('body').attr('id'),
 ERR_BLANK = '模块标题不能为空',
 switchSetting = function(el, stat) {
   var mod = el.parents('.mod'),
   hd = mod.find('.hd'),
   lnk = hd.find('a.a_lnk_mod_setting');
   if (stat === 'on' ) {
     el.slideDown('fast');
     hd.addClass('stat-active');
     lnk.addClass('on');
     lnk.html('关闭设置');
   }else{
     el.slideUp('fast', function(){
         if(isIE8){
           $(this).parent().find('.fix_ie8_bug').remove();
           $('<div class="fix_ie8_bug" style="height:1px;overflow:hidden;margin-top:-1px;"></div>').insertBefore(this);
         }
     });
     el.find('form')[0].reset();
     mod.find('.setting-panel .attn').html('');
     hd.removeClass('stat-active');
     lnk.removeClass('on');
     lnk.html('设置');
   }
 }, 

 initSettingForm = function(frm){
   //提交时触发
   frm.submit(function(e){
     e.preventDefault();
     var frm = $(this), 
         err,
         title = frm.find('input[name=title]'),
         url = frm.attr('action');

         if ($.trim(title.val()) === '') {
             err = title.next();
             if (err.length && err.hasClass('attn')) {
                 err.html(ERR_BLANK);
             } else {
                 $(' <span class="attn">' + ERR_BLANK + '</span>').insertAfter(title);
             }
             return;
         }

         frm.find('input:submit').attr('disabled', true);

         $.post_withck(url, 
         Douban.get_form_fields(frm),
         $.proxy(function(e){
           var url, frm = this, title, mod, err, e = (typeof e === 'object')? e : $.parseJSON(e);
           frm.find('input:submit').attr('disabled', false);
           //r=1,has error
           if(e.r){
            err = frm.prev();
            if (err.length && err.hasClass('attn')) {
                err.html(e.error);
            } else {
                $('<div class="attn">' + e.error + '</div>').insertBefore(frm);
            }
             return;
           }

           mod = frm.parents('.mod');

           //change room
           if (e.html === '') {
               mod.fadeOut(function(){ $(this).remove(); });
               return;
           }

           //success update content
           title = $('input[name=title]', frm).val();
           mod.find('.bd').html(e.html);
		   // setting panel within archives list when
		   // there's an archives attrbute on mod object.
		   if (typeof mod.attr('archives') == 'undefined') {
			   mod.find('.hd h2 span:eq(0)').html(title);
		   }
		   else {
			   mod.find('.hd span:eq(1) a').text(title);
		   }
           switchSetting(frm.parents('.setting-panel'), 'off');
         }, frm));
		
   });
 };

  Douban.init_cancel_setting_panel = function(e){
    switchSetting($(this).parents('.setting-panel'), 'off');
  };

  Douban.init_archive_mod = function(e) {
	  var el = $(this);
	  var url = el.attr('href');
	  var is_archive = url.indexOf('unarchive') < 0;
	  var msg = '确定要将' + el.attr('screen_name') + '"' + el.attr('title') + '"' + (
		  is_archive
			  ? '存档？<br/><span style="color:#999">提示：存档后可在房间底部的“更多应用”内找到。<span>'
			  : '恢复到' + el.attr('room_name') + '?');
	  dui.Dialog({
		  width: 360,
		  iframe: true,
		  content: msg,
		  buttons: [{
		      text: '确定',
			  method: function(o){
				  o.close();
				  $.post_withck(
					  url, {}, function(r) {
						  var da = (typeof r === 'string') ? $.parseJSON(r) : r;
						  
						  if (da.r === 1) {
							  dui.Dialog({width: 360, iframe: true, content: da.error, buttons: ['confirm']}).open();
							  return;
						  }
						  el.parents('.mod').fadeOut(function(){ $(this).remove(); });
						  // 出现“更多应用”的链接
						  if (is_archive) {
							  var div = el.parents('.mod').siblings('div#div_archives');
							  if(div && div.css('display') == 'none') {
								  div.fadeIn();
							  }
						  }
					  }
				  );
			  }
		  }, 'cancel']
	  }).open();
	  return;
  };

  Douban.init_delete_mod = function(e){
      var el = $(this), text = el.attr('title') || el.text(), url = el.attr('href');
      if(confirm(text)){
          $.post_withck(url, {}, $.proxy(function(r){
              var da = (typeof r === 'string') ? $.parseJSON(r) : r;
              if (da.r === 1) {
                  var error_tip = da.error ? da.error : '删除失败。';
                  dui.Dialog({width: 300, iframe: true, content: error_tip, buttons: ['confirm']}).open();
                  return;
              }
              this.parents('.mod').fadeOut(function(){ $(this).remove(); });
          },el));
      }
  };

  Douban.init_lnk_mod_setting = function(e){ 
    var el = $(this),
    mod = el.parents('.mod'),
    hd = mod.find('.hd').first(),
	url = el.attr('rel');
   // url = siteUrl + 'index.php?app=site&siteid=' + siteId +'&a=' + mod.attr('id').split('-')[0] + "&ik=settings&"+ mod.attr('id').split('-')[0] +'id='+ mod.attr('id').split('-')[1], 
    //url = siteUrl + 'index.php?app=site&a=' + mod.attr('id').split('-')[0] + "&ik=settings&"+ mod.attr('id').split('-')[0] +'id='+ mod.attr('id').split('-')[1], 
    setting = mod.find('.setting-panel'); 
    // can't click while loading.
    if (el.hasClass('lnk_setting_loading')){
        return;
    }
    if (el.hasClass('on')) {
      switchSetting(setting, 'off');
    } else {
      if(setting.length === 0){
        $('<div class="setting-panel"></div>').insertAfter(hd);
        setting = mod.find('.setting-panel');
       }
       el.addClass('lnk_setting_loading');
       setting.html('<div class="loading">下载中......</div>');
       $.getJSON(url, $.proxy(function(r){
          this.html(r.html);
          el.removeClass('lnk_setting_loading');
          initSettingForm(this.find('form'));
          switchSetting(setting, 'on');
        }, setting));
		

    }
  };

})();
