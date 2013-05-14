var isConfirmed = false;
function ToggleCheck(source)
{
    $('input[type=checkbox]').each(function(){this.checked=source.checked;});
}
function Delete(obj){
	var itemid = '';
	var url = $(obj).attr('data-url');
	$('input[name=itemid]').each(function(){
			if(this.checked){
				itemid += this.value+',';
			}	
	});
	if(itemid==''){
		return;
	}
	isConfirmed =confirm("确定要执行删除操作吗？");
	if(isConfirmed){
		itemid = itemid.substring(0,itemid.length-1);
		//发送数据
		$.post(url,
		{
		  itemid:itemid
		},
		function(res){
			res  = $.parseJSON(res);
			if(res.r==0){window.location.reload();}
		});	
	}
}
//审核ajax
function Audit(obj){
	var itemid = '';
	var url = $(obj).attr('data-url');
	$('input[name=itemid]').each(function(){
			if(this.checked){
				itemid += this.value+',';
			}	
	});
	if(itemid==''){
		return;
	}

	itemid = itemid.substring(0,itemid.length-1);
	//发送数据
	$.post(url,
	{
	  itemid:itemid
	},
	function(res){
		res  = $.parseJSON(res);
		if(res.r==0){window.location.reload();}
	});	
}
$(function(){
	//换色
	$('.midder table tr').hover(
		function(){ 
			$(this).addClass('oddover');
		},
		function(){
			$(this).removeClass('oddover');
		}
	);
	//编辑td
	$('td .tdedit').live('click',function(){
		var _self = $(this),td = _self.parent(),text = _self.text();
		var tdinput = '<input type="text" value="'+text+'" style="width:25px;" class="tdinput">';
		_self.hide();
		td.append(tdinput);		
	});
	//提交
	$('html').click(function(e){
		var el = $(e.target), 
		classname = el.attr('class');
		if (classname == 'tdinput') {
		     return;
		}else{
			var tdinput = $(this).find('.tdinput'), val = tdinput.val();
			var tdedit = tdinput.parent().find('.tdedit');
			var url = tdedit.attr('data-action'), field = tdedit.attr('data-field');
			tdedit.show(); 
			tdinput.remove();
			//回调
			if(val!='' && val!= undefined){
					//发送数据
				$.post(url,
				{
				  field:field,
				  fieldval:val
				},
				function(res){
					res  = $.parseJSON(res);
					if(res.r==0){window.location.reload();}
				});	
			}
		}
	})
})
