function tips(c){ $.dialog({content: '<font style="font-size:14px;">'+c+'</font>',fixed: true, width:300, time:1500}); }
function succ(c){ $.dialog({icon: 'succeed',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}
function error(c){$.dialog({icon: 'error',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}

var loading = {
		show: function(obj){ $(obj).show();},
		hide: function(obj){ $(obj).hide();}
	}
//加小站list
function loadSite(text, page)
{
	if(text=='全部') return;
	var url = siteUrl+'index.php?app=site&a=explore&ik=tag';
	$.ajax({
		async: false,//同步加载数据
		type:"POST",
		url: url,
		dataType:"json",
		data:"tagname="+text+"&page="+page,
		beforeSend:function(){ loading.show('.site-loading'); 
		},
		success:function(res){
			var items='';
			if(res==null){ 
				$('.site-list').html('<li class="pl" style="text-align:center; line-height:35px">暂无该标签的小站；重新发现小站吧！</li>');$('.site-more').fadeOut(100); loading.hide('.site-loading'); return;
			} 

				for(var i=0; i<res.length; i++)
				{
					
					
					items += '<li class="site-item">'
					+'<div class="pic">'
						+'<a title="'+res[i]['sitename']+'" href="'+res[i]['url']+'" target="_blank">'
							+'<img width="75" height="75" src="'+res[i]['icon_75']+'" alt="'+res[i]['sitename']+'">'
						+'</a>'
					+'</div>'
					+'<div class="info">'
					  +'<div class="title">'
						+'<a title="'+res[i]['sitename']+'" href="'+res[i]['url']+'" target="_blank">'+res[i]['sitename']+'</a>'
					  +'</div>'
					  +'<p>'+res[i]['sitedesc']+'</p>'
					+'</div>'
					+'</li>';
				}
				if(page==1)
				{
					$('.site-list').html(items); 
					loading.hide('.site-loading');
				}else{ 
					$('.site-list').append(items);
					loading.hide('.site-loading');
				}
				 
				if(page==res[0]['page'])
				{
					$('.site-more').fadeOut(100);

				}else
				{
					 $('.site-more').html('<span class="stat"><a href="javascript:;" onclick="loadSite(\''+res[0]['tagname']+'\','+(page+1)+')">加载更多</a></span>').fadeIn(100);
				}

		}
	})
}

//新建小站 tag-items
function tags(obj)
{
	var text = $(obj).text(), input = $('#tag');
	var vals = $('#tag').val();
	//设置input
	if($(obj).hasClass('selected'))
	{ 
		$(obj).removeAttr('class');
		//删除
		var value = vals.replace(' '+text, '').replace(text, '').replace(/\s+/, ' ');
		input.val($.trim(value));

	}else{
		if(vals.split(' ').length < 5)
		{
			$(obj).attr('class','selected');
			input.val(vals ? vals + " " + text : text);
		}
	}
}
//提交新建site
function createSite(that)
{
	var title = $(that).find('input[name=sitename]').val();

	var content = $(that).find('textarea[name=sitedesc]').val();
	if(title == '' || content == ''){tips('请填写标题和内容'); return false;}

	$(that).find('input[type=submit]').val('正在提交^_^').attr('disabled',true);
}