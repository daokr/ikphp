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
