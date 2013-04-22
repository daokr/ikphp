function tips(c){ $.dialog({content: '<font style="font-size:14px;">'+c+'</font>',fixed: true, width:300, time:1500});}
function succ(c){ $.dialog({icon: 'succeed',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}
function error(c){$.dialog({icon: 'error',content: '<font  style="font-size:14px;">'+c+'</font>' , time:2000});}


IK.ready(function(){var a;$(".member_photo li").hover(function(){$this=$(this);a=setTimeout(function(){$this.find(".member-tip").fadeIn("fast");clearTimeout(a)},200)},function(){if(a){clearTimeout(a)}$(this).find(".member-tip").fadeOut("fast")})});