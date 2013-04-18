$(function(){
	var currtNum = 1;
	var prenum = 4;
    var num = $('#ui-ul li').length; 
	var iMax = Math.ceil(num/4);
	var liw = $('#ui-ul li').outerWidth();
	$('#ui-ul').width(num*liw);
	currtNum==1 ? $('#ui-control .btn-prev').addClass('btn-prev-disabled'): '';
	$('#ui-control .btn-next').click(function(){
	   if(currtNum<iMax)
	   {
			   $('#ui-ul').animate({"left":-liw*prenum*currtNum},300);
			   currtNum++;
			   $('#ui-control').find('span').html(currtNum+'/'+prenum);
			   currtNum>=iMax ? $(this).addClass('btn-next-disabled'): $('#ui-control .btn-prev').removeClass('btn-prev-disabled');
	   }	  
	});
	$('#ui-control .btn-prev').click(function(){
	   if(currtNum>1)
	   {	   --currtNum;	
			   $('#ui-ul').animate({"left":-liw*prenum*(currtNum-1)},300);
			   $('#ui-control').find('span').html(currtNum+'/'+prenum);
			    currtNum<=1 ? $(this).addClass('btn-prev-disabled'): $('#ui-control .btn-next').removeClass('btn-next-disabled');
	   }	  
	});
	
})
IK.add('lazyimage', {
	path : siteUrl+'static/public/js/lib/lazy_image.js',
	type : 'js'
});
IK('lazyimage', function() {
	$('.events-list').lazyImage({
		ratioSrc : function(src, ratio) {
			/*if(ratio >= 1.5) {
				if(src.indexOf('small') !== -1) {
					return src.replace('small', 'median');
				}
				return src.replace('median', 'large');
			}
			*/
			return src;
		}
	});
});