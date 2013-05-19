function tips(c){ $.dialog({content: '<font style="font-size:14px;">'+c+'</font>',fixed: true, width:300, time:1500});}
function succ(c){ $.dialog({icon: 'succeed',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}
function error(c){$.dialog({icon: 'error',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}

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

//新建小组
function createCheck(that)
{
	var name = $(that).find('input[name=title]').val();
	var desc = $(that).find('textarea[name=content]').val();
	var arrimport = $(that).find('select[name=cateid]').val();
	
	
	if(name == ''){tips('专辑名称必须填写'); return false;}
	if(desc == ''){tips('专辑描述必须填写'); return false;}
	if(arrimport == 0){ tips('请选择一个分类吧！'); return false;}
	
	$(that).find('input[type=submit]').val('正在提交^_^').attr('disabled',true);

}
