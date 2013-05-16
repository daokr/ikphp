$(function(){
	$('.a_share').bind('click',function(){
		pop_win([
		'<div class="rectitle"><span class="m">分享地址：</span></div>',
		'<div class="panel">',
		'</div>',
		'<div class="bn-layout"><input type="button" value="确定" class="confirmbtn">',
		'<input type="button" value="取消" class="cancellinkbtn" onclick="pop_win.close();" ></div>'].join('') );
		
		return false;;
	})
})