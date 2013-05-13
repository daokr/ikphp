(function(){
  Douban.init_lnk_like = function(e){
  		e.preventDefault();
		var el = $(this),
			siteid = $("body").attr('id'),
			followed = $('#followed').val(),
			siteacurl  = el.attr('href'),
			init='',
			site_is_commercial = el.attr('commercial')==null ? false : true;//是否是推广
		$.post_withck(
			siteacurl,{'siteid':siteid,'ik':'like'},
			function(res){
				var res = $.parseJSON(res);
				if(res.r==1)
				{
					//错误
					location.href='http://www.12ik.com/site/';
				}
				if (!site_is_commercial && followed == 0)
				{
					init = function(){
							var dlg = dui.Dialog({
								width: 300,
								url: pop_like_form,
								callback: function(e, o) {
									o.setTitle('我喜欢这个小站');
									//提交对话
									$('#follow_submit').click(function (e) {
										e.preventDefault();
										var url = siteacurl;
										var fllowdata ='';
										if($('#is_follow').attr('checked') == 'checked'){
											//收听
											fllowdata = {'ik':'follow','siteid':siteid,'isfollow':'0'};
										}
										else{
											fllowdata = {'ik':'unfollow','siteid':siteid,'isfollow':'1'};
										}
										$.post_withck(
											url,fllowdata,
											function (o) {
												location.reload(1);
											}
										);
										dlg.close();
									});
								}
							}).open();
							
							dlg.node.find('.dui-dialog-close').click(function(){
								location.reload(1);
							});	
					};
					
					IK('dialog', init);		

				}else{
					location.reload(1);
				}
				
			});
			
  };//like
  
  //unlike
  Douban.init_lnk_unlike = function(e){
  		e.preventDefault();
		var el = $(this),
			siteid = $("body").attr('id'),
			followed = $('#followed').val(),
			siteacurl  = el.attr('href'),
			init = '',
			site_is_commercial = el.attr('commercial')==null ? false : true;//是否是推广
						
		$.post_withck(
			siteacurl,{'siteid':siteid,'ik':'unlike'},
			function(res){
				var res = $.parseJSON(res);
				
				if (site_is_commercial){
					//推广
                        $.post_withck(siteacurl,{'ik':'unfollow'},function (o) {location.reload();});

                }else{
					
					if (followed == 1)
					{
						init = function(){
								var dlg = dui.Dialog({
									width: 300,
									url: pop_unlike_form,
									callback: function(e, o) {
										o.setTitle('取消喜欢这个小站');
										$('#unfollow_submit').click(function (e) {
											e.preventDefault();
											var url = siteacurl;
											var fllowdata ='';
											if($('#un_follow').attr('checked') == 'checked')
											{
												//不收听广播
												fllowdata = {'ik':'unfollow','siteid':siteid,'isfollow':'1'};
											}else{
												location.reload(1);
											}
											//取消关注
											$.post_withck(url,fllowdata,function (o) {
												location.reload(1);
											});
											dlg.close();
										});
									}
								}).open();
							   dlg.node.find('.dui-dialog-close').click(function(){
								   location.reload(1);
							   });
					   }
					   
					   IK('dialog', init);		
					   
					}else{
					  location.reload();
					}
				
				}

			});	
				
  };
  
})();

