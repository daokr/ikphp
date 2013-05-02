// JavaScript Document
function addBlod(){
	var text = $('#editor_full').get_sel();
	if(text !=='') 
	{
		if(text.match(/\[b\](.*)\[\/b\]/gi))
		{
			text = text.replace(/\[b\]/,'').replace(/\[\/b\]/,'')
		}else{
			text = '[b]' + text + '[/b]';
		}
		$('#editor_full').insert_caret(text);
	}
}
function addLink(){
	
	var templ_link =    '<form class="frm-addlink">'+
				'<div class="item">'+
                '<label>链接文字：</label><input name="linktext" type="text" value="SEL">'+
                '</div>'+
                '<div class="item">'+
                '<label>网址：</label><input name="href" type="text" value="">'+
				'</div>'+
            '</form>';
	var s = $('#editor_full').get_sel();
	var thtml = templ_link.replace('SEL', s);
	pop_win([
	'<div class="rectitle"><span class="m">添加链接</span></div>',
	'<div class="panel">',thtml,
	'</div>',
	'<div class="bn-layout"><input type="button" value="确定" class="confirmbtn">',
	'<input type="button" value="取消" class="cancellinkbtn" onclick="pop_win.close();" ></div>'].join('') );
	
	var addlink = function(frm, o){
            var text = $.trim(frm.find('input[name=linktext]').val()),
            url = $.trim(frm.find('input[name=href]').val());
            if(url !== ''){
              url = /^http:\/\//.test(url)? url:"http://"+url;
              $('#editor_full').insert_caret('[url=' + url + ']' + (text===''? url : text) + "[/url]");
              o.close();
            }
        };
	$('.pop_win .confirmbtn').live('click',function(){
		addlink( $('.frm-addlink'), pop_win);	
	});
	//
 	var frmaddlink = $('.frm-addlink');
	$('input', frmaddlink).live('keydown',function(e){
		var keyCode = e.keyCode; 
		if (keyCode === 10 || keyCode === 13 ) {
			addlink( $('.frm-addlink'), pop_win);	
		}
	});	
}
function addPhoto(ajaxurl, data){
    pop_win([
        '<div class="rectitle"><span class="m">添加图片</span></div>',
        '<div class="panel">',
            '<span class="pl"> 图片的大小不超过3M </span><br><br>',
            '<form>',
                '<span class="pl">选择图片</span> ',
                '<input id="file" type="file" name="file"/>',
				'<br><br><br><input id="startup" type="button"  class="confirmbtn" onclick="ajaxFileUpload(\''+ajaxurl+'\','+data+'); return false;" value="开始上传">',
                '<input type="button" onclick="pop_win.close();" value="取消" class="cancellinkbtn">',
                '</form>',
        '</div><div class="waiting">正在上传中......</div>'].join('') );
	
}
function ajaxFileUpload(ajaxurl, data){
       $.ajaxFileUpload(
            {
                url : ajaxurl,
                fileElementId : 'file',
                dataType : 'json',
                allowType : 'jpg|png|gif|jpeg',
                extra : data,
                begin : function(){
                    $('.pop_win')
                      .find('.panel').css('visibility', 'hidden')
                      .end()
                      .find('.waiting').show()
                      .end()
                      .find('.pop_win_close').hide();
                },
                complete : function(){
                  pop_win.close();
                },
                success : function(data, status){
					
                    if(data.r == 1){
                        //console.log(data.err_msg);
                        alert(data.html);
                    }else{
                        var html = buildPhotoThumbDetail(data);
                        var oThumbList = $("#thumblst");
                        var oPhotoDiv = $(html);
                        oPhotoDiv.prependTo(oThumbList);
                        oThumbList.show();
						$('#editor_full').insert_caret("[图片" + data.seq_id +"]");
                    }
					
                },
                error : function(data, status, e){
                    // console.log(e);
                }
            }
       ); 
       return false;
}

function buildPhotoThumbDetail(data){
        var html = '<div class="thumblst">';

        html += '<div class="details"><p>图片描述（30字以内）</p> <textarea maxlength="30" name="photodesc[]">'+ data.title + '</textarea><input type="hidden" name="seqid[]" value="' + data.seq_id + '" ><br/><br/>图片位置<br/>'+ '<a name="rm_p_' + data.seq_id + '"   class="minisubmit rr j a_remove_pic" ajaxurl="'+data.ajaxurl+'" imgid="'+data.id+'" onclick="javascript:removePhoto(this, \''+ data.seq_id +'\');return false;">删除</a>';

        if(data.layout == "L"){
            html += '<label><input type="radio" value="' + "L" + '" name="layout_'+data.seq_id+'" checked="checked" /> <span class="alignleft">居左</span></label>';
        }else{
            html += '<label><input type="radio" value="' + "L" + '" name="layout_'+data.seq_id+'" /> <span class="alignleft">居左</span></label>';
        }

        if(data.layout == "C") {
            html += '<label><input type="radio" value="' + "C" + '" name="layout_'+data.seq_id+'" checked="checked" /> <span class="aligncenter">居中</span></label>';
        }else{
            html += '<label><input type="radio" value="' + "C" + '" name="layout_'+data.seq_id+'" /> <span class="aligncenter">居中</span></label>';
        }

        if(data.layout == "R") {
            html += '<label><input type="radio" value="' + "R" + '" name="layout_'+data.seq_id+'" checked="checked" /> <span class="alignright">居右</span></label>';
        }else{
            html += '<label><input type="radio" value="' + "R" + '" name="layout_'+data.seq_id+'" /> <span class="alignright">居右</span></label>';
        }

        
        html += '</div><div class="thumb"><div class="pl">[图片' + data.seq_id + ']</div> <img src="' + data.small_photo_url + '"/> </div><div class="clear"></div> </div>';
        

        return html;
}
function removePhoto(obj, seq_id){
	var ck = get_cookie('ck');
	var url = $(obj).attr('ajaxurl'), imgid = $(obj).attr('imgid');
    var data = "seq_id=" + seq_id + "&ck="+ck+ "&id="+imgid;
    $.ajax({
        type:       "post",
        url:        url,
        dataType:   "json",
        data:       data,
        success:    function(data, status){
            var oText, o = $(obj);
            if(data.r == 0){
                oText = $("textarea[name='content']");
                oText.val(oText.val().replace('[图片' + seq_id + ']', ''));
                o.closest(".thumblst").slideUp('fast',function(){$(this).remove()});
            }else{
                // console.log('fail');
            }
        },
        error:  function(data, status){
            // console.log('error');
        }
    });
}
//视频模块
var formNote = $('#form_tipic'),
	control_panel = $('.control-panel', formNote),
	videos = formNote.children('.videos'),
	nid = '{$topic_id}';
function addVideo(ajaxurl, data)
{

	pop_win([
	'<div class="rectitle"><span class="m">添加视频</span></div>',
	'<div class="panel">',
	'<div class="frm-addvideo">',
	'<div class="item tips" id="videotips" style="background-color:#fff"></div>',
	'<div class="item" style="text-align:left">',
	'目前爱客网支持抓取视频网站的有：土豆网、优酷网、酷6网、56网、的视频，其他网站视频会陆续推出。',
	'</div>',
	'<div class="item">',
	'<label>输入视频播放页地址：</label><input name="url" type="text" value="">',
	'</div>',
	'<div class="item" style="text-align:left;color:red" id="videerror"></div>',	
	'</div></div>',
	'<div class="bn-layout"><input type="button" value="确定" class="confirmbtn" onclick="addRemoteVideo(\''+ajaxurl+'\');">',
	'<input type="button" value="取消" class="cancellinkbtn" onclick="pop_win.close();" ></div>'].join('') );
}
function addRemoteVideo(ajaxurl, data){
			var frm =  $('.frm-addvideo'), o = pop_win;
			var vurl = $.trim(frm.find('input[name=url]').val());
			//var ck = get_cookie('ck');
            if(vurl!=''){
				$('.pop_win').find('.confirmbtn').attr('disabled','disabled');
	 			$.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        url: encodeURIComponent(vurl)  //编码传送
                    },
                    beforeSend: function() {
                       $('#videotips').css('color','green').html('正在抓取视频中。。');
                    },					
                    success: function(data) { 
                        if (data.r) {
                            // displayError
                            $('#videotips').css({'color':'red','background-color':'#F8F8F8'}).html(data.html);
                            return;
                        }
						buildVideoDetail(data);
						$('#videotips').html('').css('background-color','#fff');
                        $('#editor_full').insert_caret('[视频' + data.seqid + ']');
                        o.close();
						
                    },
                    error: function() {
                        that.showError('网络错误!');
                    }
                });
            }
}
function buildVideoDetail(data){
        var html = '<div class="thumblst">';

        html += '<div class="details"><p>视频标题（30字以内）</p> <textarea maxlength="30" name="video_' + data.seqid + '_title">'+ data.title + '</textarea><input type="hidden" name="videoseqid[]" value="' + data.seqid + '" ><br/><br/>视频网址：<br/>'+ '<a name="rm_p_' + data.seqid + '"   class="minisubmit rr j a_remove_pic" ajaxurl="'+data.ajaxurl+'" videoid="'+data.id+'"  onclick="javascript:removeVideo(this, \''+ data.seqid +'\');return false;">删除</a><p>'+ data.url +'</p>';
        
        html += '</div><div class="thumb"><div class="pl">[视频' + data.seqid + ']</div> <img src="' + data.imgurl + '"/> </div><div class="clear"></div> </div>';
		
		$('#videosbar').append(html).show();
}
//删除视频
function removeVideo(obj, seq_id){
	var ck = get_cookie('ck');
	var url = $(obj).attr('ajaxurl'), videoid = $(obj).attr('videoid');
    var data = "videoid=" + videoid + "&ck="+ck;
    $.ajax({
        type:       "post",
        url:        url,
        dataType:   "json",
        data:       data,
        success:    function(data, status){
            var oText, o = $(obj);
            if(data.r == 0){
                oText = $("textarea[name='content']");
                oText.val(oText.val().replace('[视频' + seq_id + ']', ''));
                o.closest(".thumblst").slideUp('fast',function(){$(this).remove()});
            }else{
                // console.log('fail');
            }
        },
        error:  function(data, status){
            // console.log('error');
        }
    });
}
$(function(){
	//字数统计
	$('#editor_full').bind('keyup',function(){
		
			var len = $(this).val().length, 
		        textnum  =  $('#ik_toolbar').find('#textnum em:eq(0)'),
				totalnum = $('#ik_toolbar').find('#textnum em:eq(1)').text();
			if(len<=parseInt(totalnum))
			{
				textnum.removeClass('red');
			}else{
				
				textnum.addClass('red');
			}
			textnum.text(len);
			
	})
})