$(function(){
	$('.a_share').bind('click',function(){
	var templ_link ='<form class="frm-addlink">'+
                '<div class="item">'+
                '<label>网址：</label><input name="href" type="text" value="" placeholder="将商品网址粘贴到这里">'+
				'</div>'+
            '</form>';
	pop_win([
	'<div class="rectitle"><span class="m">添加链接</span></div>',
	'<div class="panel">',templ_link,
	'</div>',
	'<div class="bn-layout"><input type="button" value="确定" class="confirmbtn">',
	'<input type="button" value="取消" class="cancellinkbtn" onclick="pop_win.close();" ></div>'].join('') );
	
	var addlink = function(frm, o){
            var url = $.trim(frm.find('input[name=href]').val());
            if(url !== ''){
              url = /^http:\/\//.test(url)? url:"http://"+url;
              //执行ajax
              o.close();
            }
    };
	
	$('.pop_win .confirmbtn').live('click',function(){
		addlink( $('.frm-addlink'), pop_win);	
	});
		return false;;
	})
})