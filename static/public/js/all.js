// JavaScript Document
function searchForm(obj)
{
	var keyword = $(obj).find('input[name=q]'); 
	if( keyword.val() =='')
	{
		return false;
	}
	return true;
}
$(function(){
	$('#search_bar input[name=q]').bind('click',function(){
		if($(this).val()!=''){
			$(this).css({"color":"#000"});	
		}
	});	
	$('#search_bar input[name=q]').bind('change',function(){
		if($(this).val()!=''){
			$(this).css({"color":"#000"});	
		}
	});
	$('#search_bar input[name=q]').bind('blur',function(){
		if($(this).val()!=''){
			$(this).css({"color":"#000"});	
		}
	});
})

