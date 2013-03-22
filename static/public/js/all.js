// JavaScript Document
function searchForm(obj)
{
	var keyword = $(obj).find('input[name=kw]'), defval = keyword.attr('placeholder');
	if( keyword.val() =='' || keyword.val()==defval)
	{
		return false;
	}
	return true;
}
$(function(){
	$('#search_bar input[name=kw]').bind('click',function(){
		var defval = $(this).attr('placeholder');
		
		if($(this).val() == defval)
		{
		  
		  $(this).val('');$(this).css({"color":"#333"});
		  
		}else if($(this).val()!=''){
			
		  $(this).css({"color":"#555"});	
		  
		}
	});
	$('#search_bar input[name=kw]').bind('blur',function(){
		var defval = $(this).attr('placeholder');
		if($(this).val() == '')
		{
		  $(this).val(defval);$(this).css({"color":"#d4d4d4"});	
		}
	});
})

