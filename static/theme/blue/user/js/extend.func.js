function tips(c){ $.dialog({content: '<font style="font-size:14px;">'+c+'</font>',fixed: true, width:300, time:1500});}
function succ(c){ $.dialog({icon: 'succeed',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}
function error(c){$.dialog({icon: 'error',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}

//显示和隐藏
function viewcontent(){
	$("#displaycontent").toggle();
	$("#displaytitle").hide();
}
//显示和隐藏
function closecontent(){
	$("#displaycontent").hide();
	$("#displaytitle").toggle();
}

/*显示标签界面*/
function showTagFrom(){ $('#tagFrom').toggle('fast');}
/*提交标签*/
function savaTag(tid)
{
	var tag = $('#tags').val();
		if(tag ==''){ tips('请输入标签哟^_^');$('#tagFrom').show('fast');}else{
			var url = siteUrl+'index.php?app=tag&ac=add_ajax&ik=do';
			$.post(url,{objname:'user',idname:'userid',tags:tag,objid:tid},function(rs){  window.location.reload()   })
		}
	
}
