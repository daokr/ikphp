//加载编辑器
$(pageInit);
function pageInit()
{
	
	var tsplugin={
		
		tsAttach:{c:'tsAttach',t:'插入附件',e:function(){
			var _this=this;
			  _this.saveBookmark();
			 _this.showIframeModal('选择附件',siteUrl+'index.php?app=attach&ac=ajax&ik=my',function(v){  _this.pasteHTML(v,false); },400,420);
		}},
		tsImg:{c:'tsImg',t:'插入图片',e:function(){
			var _this=this;
			 _this.saveBookmark(); 
			 _this.showIframeModal('选择图片',siteUrl+'index.php?app=photo&ac=ikupload&ik=image&type='+type+'&typeid='+typeid,function(v){ _this.pasteHTML(v,false); },400,200);
		}},
		
		
		tsMusic:{c:'tsMusic',t:'插入远程音乐',h:1,e:function(){
			var _this=this;
			var title = '';
			
			var htmlCode=$('<div>插入MP3音乐</div><div>地址：<input type="text" id="xheMusicUrl" value="http://" class="xheText" /></div>'+
						   '<div>标题：<input type="text" id="xheMusicTit" value="" class="xheText" /></div><div style="text-align:right;"><input type="button" id="xheSave" value="确定" /></div>');
			var jCode=$(htmlCode),jSave=$('#xheSave',jCode),jValue=$('#xheMusicUrl',jCode),jTit=$('#xheMusicTit',jCode);
			jSave.click(function(){
				if(jValue.val() !='http://'){
					if(jTit.val() !='') { title = ','+jTit.val();}
					_this.pasteHTML('[mp3='+jValue.val()+title+']',false);
				}
				_this.hidePanel();
				return false;	
			});
			
			_this.saveBookmark();
			_this.showDialog(htmlCode);
		}},
		
		tsVideo:{c:'tsVideo',t:'插入视频地址',h:1,e:function(){
			var _this=this;
			_this.saveBookmark();
			var htmlCode=$('<div>爱客网支持抓取视频网站的有：土豆网、优酷网、酷6网、56网、的视频。</div><div><img src="" id="urlImg" style="display:none"/></div><div>输入视频播放页地址: <input type="text" id="xheVidoeUrl" value="" class="xheText" /></div><div>标题: <input type="text" id="xheVidoeTitle" value="" class="xheText" /></div><div style="text-align:right;"><input type="button" id="xheSave" value="解析" /></div>');
			var jCode=$(htmlCode),jSave=$('#xheSave',jCode),jimg=$('#urlImg',jCode),jtitle=$('#xheVidoeTitle',jCode),jValue=$('#xheVidoeUrl',jCode);
			jSave.click(function(){
				if(jimg.attr('src') != '')
				{
					_this.pasteHTML('[video='+rsJson.result.coverurl+','+rsJson.result.flash+','+jtitle.val()+']',false);
					_this.hidePanel();
				}
				if(jValue.val() !='')
				{
					url = jValue.val();
					var urls = siteUrl+'index.php?app=group&ac=do&ik=parseurl';
					jSave.val('稍等...');jSave.attr('disabled',true);
					$.post(urls,{parseurl:url},function(rs){
								rsJson = eval('(' + rs + ')');
							if(rsJson.err != 0)
							{
								jSave.val('解析网址');jSave.attr('disabled',false);
								alert(rsJson.msg);	return false;
							}else{
								jSave.val('完成');jSave.attr('disabled',false);
								jimg.attr('src',rsJson.result.coverurl);jimg.show();
								jtitle.val(rsJson.result.title);
							 return false;
							}		
					})
				}
				
				return false;	
			});
			_this.saveBookmark();
			_this.showDialog(htmlCode);
		}},

		tsCode:{c:'tsCode',t:'插入代码',h:1,e:function(){
			var _this=this;
			var htmlCode='<div>插入代码</div><div><textarea id="xheCodeValue" wrap="soft" spellcheck="false" style="width:300px;height:100px;" /></div><div style="text-align:right;"><input type="button" id="xheSave" value="确定" /></div>';			
			var jCode=$(htmlCode),jValue=$('#xheCodeValue',jCode),jSave=$('#xheSave',jCode);
			jSave.click(function(){
				_this.loadBookmark();
				if(jValue.val() != '')
					_this.pasteHTML('<pre class="code">'+_this.domEncode(jValue.val())+'</pre>');
				_this.hidePanel();
				return false;	
			});
			_this.saveBookmark();
			_this.showDialog(jCode);
		}}
	};



	var fulltools = 'Paste,|,Bold,FontSize,Italic,Underline,Strikethrough,|,FontColor,BackColor,Align,List,Outdent,Indent,|,Link,Unlink,|,tsAttach,tsImg,tsMusic,Flash,tsVideo,Emot,tsCode,|,Fullscreen';
	var minitools = 'Bold,FontSize,Italic,Underline,Strikethrough,|,FontColor,BackColor,Align,List,Outdent,Indent,|,Link,Unlink,|,tsImg,tsVideo,tsCode,|,Source,|,Preview,Fullscreen';
	
	
	
	$('#editor_mini').xheditor({plugins:tsplugin,tools:minitools,skin:'nostyle',urlType:'abs',internalStyle:false,emotPath:siteUrl+'public/emot/',emots:{360:{name:'360',count:24,width:32,height:32,line:8}},shortcuts:{'ctrl+enter':miniSubmit}});
	
	$('#editor_full').xheditor({plugins:tsplugin,tools:fulltools,skin:'nostyle',layerShadow:4,internalStyle:false,urlType:'abs',emotPath:siteUrl+'public/emot/',emots:{360:{name:'360',count:24,width:32,height:32,line:8}}});
	
}


function miniSubmit()
{
	if($('#editor_mini').val() == '')
	{
		tips('请输入内容');
	}else{
		$('#formMini').find('input[type=submit]').val('正在提交^_^').attr('disabled',true);
		$('#formMini').submit();
	}
}



function insertEditor(val)
{
	callback(val);
	unloadme();
}