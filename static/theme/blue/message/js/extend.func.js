//发送盒子
/**
function sendbox(userid){

$("#msgbox").html("加载消息中......")
$("#sendbox").html("加载输入框中......")

	$.ajax({
		type: "GET",
		url:  siteUrl+"index.php?app=message&a=msgbox&userid="+userid,
		success: function(msg){
			$('#msgbox').html(msg);
			
			var msgbox=document.getElementById('msgbox');
			if(msgbox.scrollHeight>msgbox.offsetHeight) msgbox.scrollTop=msgbox.scrollHeight-msgbox.offsetHeight+20;
			
		}
	});

	$.ajax({
		type: "GET",
		url:  siteUrl+"index.php?app=message&a=sendbox&userid="+userid,
		success: function(msg){
			$('#sendbox').html(msg);
		}
	});
}

//发送消息
function sendmsg(userid,touserid){
	var content = $("#boxcontent").val();
	if(content == ''){
		alert("请输入你要发送的内容！");return false;
	}
	//清空内容
	$("#boxcontent").attr("value",'');
	$("#sendbutton").css('display','none');
	$("#loading").css('display','block');

	
	$.ajax({
		type: "POST",
		url: siteUrl+"index.php?app=message&a=sendmsg",
		data: "userid="+userid+"&touserid="+touserid+"&content="+content,
		beforeSend: function(){},
		success: function(result){
			if(result == '1'){
				$.ajax({
					type: "GET",
					url:  siteUrl+"index.php?app=message&a=msgbox&userid="+touserid,
					success: function(msg){
					
						$('#msgbox').html(msg);
						
						var msgbox=document.getElementById('msgbox');
						if(msgbox.scrollHeight>msgbox.offsetHeight) msgbox.scrollTop=msgbox.scrollHeight-msgbox.offsetHeight+20;
						
						$("#loading").css('display','none');
						$("#sendbutton").css('display','block');
						
					}
				});
			}
			
		}
	});
}

//系统消息盒子
function systembox(userid){
	$("#sendbox").html("");
	$("#msgbox").html("加载系统消息中......")
	$.ajax({
		type: "GET",
		url:  siteUrl+"index.php?app=message&a=systembox&userid="+userid,
		success: function(msg){
			$('#msgbox').html(msg);
			var msgbox=document.getElementById('msgbox');
			if(msgbox.scrollHeight>msgbox.offsetHeight) msgbox.scrollTop=msgbox.scrollHeight-msgbox.offsetHeight+20;
			
		}
	});
}
**/
//****************新增2012-11-5*****************
//邮件收件箱
var isConfirmed = false;
$(function(){  

    $(".olt tr").bind('mouseenter mouseleave', function (e) {
        switch (e.type) {
        case "mouseenter":
            $(this).find(".mail_options").show();
            break;
        case "mouseleave":
            $(this).find(".mail_options").hide();
            break;
        }
    });

    $('input[name="mc_submit"]').bind('click', function() {
        var num_checked = $('input[type=checkbox]:checked').length;
        
        if (num_checked > 0) {
			if($(this).val()=='删除')
			{
            	isConfirmed = confirm($(this).attr('data-confirm'));
			}else{
				isConfirmed = true;
			}
        }
        else {
            isConfirmed = false;
        }
    });	
    
});
function ToggleCheck(source)
{
    $('input[type=checkbox]').each(function(){this.checked=source.checked;});
}
