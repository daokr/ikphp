function tips(c){ $.dialog({content: '<font style="font-size:14px;">'+c+'</font>',fixed: true, width:300, time:1500}); }
function succ(c){ $.dialog({icon: 'succeed',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}
function error(c){$.dialog({icon: 'error',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}

/*显示隐藏回复*/
function commentOpen(id,gid)
{
	$('#rcomment_'+id).slideToggle('fast');
}
//Ctrl+Enter 回应
function keyComment(obj,event)
{
     if(event.ctrlKey == true)
	 {
		if(event.keyCode == 13)
		if(checkComment(obj))
		{
			$(obj).submit();
		}
		return false;
	}
}
//安全性检测 回应帖子
function checkComment(obj)
{

	if($(obj).find('textarea[name=content]').val() == ''){ error('你回应的内容不能为空'); return false;}
	if($(obj).find('textarea[name=content]').val().length > 2000){ error('你已经输入了<font color="red">'+$(obj).find('textarea[name=content]').val().length+'</font>个字；你回应的内容不能超过<font color="red">2000</font>个字。');return false;}
	
	$(obj).find('input[type=submit]').val('正在提交^_^').attr('disabled',true);
	
	return true;
}

//Ctrl+Enter 回复评论
function keyRecomment(rid,tid,event)
{
     if(event.ctrlKey == true)
	 {
		if(event.keyCode == 13)
		recomment(rid,tid);
		return false;
	}
}
//回复评论
function recomment(rid,tid,itemid){

	c = $('#recontent_'+rid).val();
	if(c==''){tips('回复内容不能为空');return false;}
	var url = siteUrl+'index.php?app=article&a=comment&ik=recomment';
	$('#recomm_btn_'+rid).hide();
	$.post(url,{referid:rid,nid:tid,infoid:itemid,content:c} ,function(rs){
				if(rs == 0)
				{
					succ('回复成功');
					window.location.reload();
				}else if( rs == 1){
					
					tips('回复内容写这么多干啥，删除点吧老大^_^')
					$('#recomm_btn_'+rid).show();
				}
	})	
}

//提交新建
function checkForm(that)
{
	var title = $(that).find('input[name=title]').val();
	var arrimport = $(that).find('select[name=cateid]').val();
	var content = $(that).find('textarea[name=content]').val();
	if(arrimport == 0){ tips('请选择一个分类再发表吧！'); return false;}
	if(title == '' || content == ''){tips('请填写标题和内容'); return false;}

	$(that).find('input[type=submit]').val('正在提交^_^').attr('disabled',true);
}