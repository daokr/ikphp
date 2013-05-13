IK('dialog', 'effects', function () {
    $(function () {
        /* global var */
        var adding = false,
            renamePath = '',
            dlg = dui.Dialog(),
            color_fade = '#ffc',
            oTips = $('.widget-tips'),
            oFnBox = $('.sp-fn-box'),
            oSpUser = $('#sp-user'),
            oRename = $('#room-rename'),
            oSaveName = oRename.next(),
            oBoxClose = $('.box-close'),
            oRoomDelBn = $('.room-del'),
            oCreateRoom = $('#new-room'),
            oWidgetsBox = $('.widgets-box'),
            oAddWidget = $('.widgets-slider .lnk-add'),
            oCurrTab = $('.nav-items li > a:has("em") span'),
            oCurrEditor = $('.nav-items li > a:has("em") em, .street-editor'),
            siteId = $('body').attr('id'),
            roomName = $('#room-rename').val(),
            css_mod_wrap = '#content .main',
            templ_added = '<em></em>添加成功',
            templ_add_tips = '<span class="txt-added">正在添加</span>';
            templ_box_loading = '<p class="box-loading">正在载入...</p>',
            isModEmpty = $('.main .sort').length==0 ? true : false,
            showBox = function (speed) {
                oFnBox.children().hide();
                oSpUser.css('margin-top', '0');
                oFnBox.slideDown(speed).
                    append(templ_box_loading);
                setTimeout(function () {
                    $('.box-loading').remove();
                    if ($.browser.msie && $.browser.version === '8.0') {
                        oFnBox.children().show();
                    } else {
                        oFnBox.children().fadeIn();
                    } 
                    oWidgetsBox.hide().eq(0).show();
                    if (isRoomEmpty) {
                        oRename.focus();
                    }
                }, speed);
            },
            DoCreateRoom = function (e) {
                $.post_withck(
					siteUrl+'index.php?app=site&a=create_room&siteid=' + siteId,
                    function (o) {
                        if (!o.error) {
                            location.href = o.room;
                        } else {
                            dlg.set({
                                width: 300,
                                content: o.error,
                                buttons: ['confirm']
                            }).open();
                        }
                    }, 'json'
                );
            },
            roomRename = function (name,roomid) {
                oCurrTab.text(name);//设置名称 发送ajax
                $.post_withck(
                    siteUrl+'index.php?app=site&a=roomRename&siteid=' + siteId+'&roomid='+roomid,
                    { 'name': name }
                );
            };

        oWidgetsBox.slider();

        // load fn-box for blank room
        if (!isSiteFirstEnter && isRoomEmpty && isModEmpty) {
            showBox(500);
        }

        // var renamePath
        if (location.pathname.split('/').length === 3) {
            renamePath = 'room_settings/'; // for homepage
        } else {
            renamePath = 'settings/'
        }

        // widgets-list type swither
        oTips.click(function () {
            var type = $(this).attr('id').split('-')[1];
            oTips.removeClass('selected');
            $(this).addClass('selected');
            oWidgetsBox.hide();
            $('#widget-' + type).fadeIn();
        });

        // delete room/
        oRoomDelBn.click(function (e) {
            e.preventDefault();
            isModEmpty = !$('.main .sort').length && !$('#div_archives').length ? true : false;
            var delUrl = '/j/site/' + siteId + '/room/' + $(this).attr('id').split('_')[1] + '/settings/delete';
            if (isModEmpty) {
                dlg.set({
                    width: 300,
                    content: '确定要删除房间？',
                    buttons: [{
                        text: '确定',
                        method: function (o) {
                            o.close();
                            $.post_withck(
                                delUrl, 
                                { 'name': roomName },
                                function () {
                                    // back to home
                                    location.href = '/' + siteId + '/';
                                }
                            );
                        }
                    }, 'cancel']
                }).open();
            } else {
                dlg.set({
                    width: 300,
                    content: '需要先把空间里的应用模块清理掉 再删除房间',
                    buttons: ['confirm']
                }).open();
            }
        });

        // create new room
        oCreateRoom.click(function (e) {
            e.preventDefault(); 
            $.post_withck(
                siteUrl+'index.php?app=site&a=create_room_check&siteid=' + siteId,
                function (o) {
                    if (o.code == 'go_ahead') {
                        DoCreateRoom();
                    } else if (o.code == 'reach_max_limit') {
                        dlg.set({
                            width: 300,
                            content: o.error,
                            buttons: ['confirm']
                        }).open();
                    } else if (o.code == 'not_enough') {
                        dlg.set({
                            width: 320,
                            content: o.error,
                            buttons: [{
                                text: '我知道了',
                                method: function (x){
                                    x.close();
                                }
                            }]
                        }).open();
                    } else if (o.code == 'need_confirm') {
                        dlg.set({
                            width: 300,
                            content: o.error,
                            buttons: [{
                                text: '确定增加',
                                method: function (o) {
                                    o.close();
                                    DoCreateRoom(1);
                                }
                            }, 'cancel']
                        }).open();
                    } else if (o.code == 'cant_admin_dou') {
                        dlg.set({
                            width: 280,
                            content: o.error,
                            buttons: [{
                                text: '我知道了',
                                method: function (o) {
                                    o.close();
                                }
                            }]
                        }).open();
                    }
                }, 'json'
            );
        });

        // fn-box switcher
        oCurrEditor.click(function (e) {
            e.preventDefault(); 
            if (oFnBox.is(':hidden')) {
                showBox(500);
                $(this).addClass('current');
            } else {
                oFnBox.slideUp(300);
                $(this).removeClass();
                oSpUser.css('margin-top', '-100px');
            }
        });

        // room rename
        oRename.keyup(function (e) {
            if (e.keyCode === 13) {
                var newName = e.target.value;
				var roomId = oRename.attr('roomid');
                roomRename(newName,roomId);
            }
        });
        oSaveName.click(function (e) {
            var newName = oRename.val();
			var roomId = oRename.attr('roomid');
            roomRename(newName,roomId);
        });

        // close fn-box
        oBoxClose.click(function (e) {
            e.preventDefault();
			$(this).parent().slideUp(300);
            oFnBox.slideUp(300);
            oCurrEditor.removeClass();
            oSpUser.css('margin-top', '-100px');
        });

        // add widgets
        oAddWidget.click(function (e) {
            e.preventDefault();
            var self = this,
				roomid = $(self).attr('roomid'),
                widget_kind = e.target.id.split('-')[1]; 

            if (!$(this).data('adding')) {
                $(this).data('adding', 1);
                $.post_withck(
				    siteUrl+'index.php?app=site&a=widgets&siteid=' + siteId+'&roomid='+ roomid,
                    { 'kind': widget_kind },
                    function (mod) {
                        if (!mod.error) {
                            $(self).hide().after(templ_add_tips);
                            $(css_mod_wrap).prepend(mod.html);
                            $(css_mod_wrap + ' .mod:first').
                                css('backgroundColor', color_fade).
                                animate({ backgroundColor: 'white' }, 1500);
                            $(self).next().html(templ_added);
                            setTimeout(function () {
                                $(self).show().next().remove().
                                    end().data('adding', 0);
                            }, 10000); 
                        } else {
                            dlg.set({
                                width: 300,
                                content: mod.error,
                                buttons: ['confirm']
                            }).open();
                        }
                    }, 'json'
                );
            }
        });

        // user guide
        if (isSiteFirstEnter) {
            (function () {
                var siteId = $('body').attr('id'),
                    tmpl_tips = '<div class="user-guide"><em></em><h1>{TITLE}</h1><span>{PAGE}</span><p>{CONTENT}</p><a id="{ID}" href="#" class="lnk-add">{BUTTON}</a></div>',
                    oTxtStep1 = {
                        'title': '小站设置',
                        'page': '1/2',
                        'content': '16套主题模板，让你的小站与众不同。',
                        'button': '知道了',
                        'id': 'next-step'
                    },
                    oTxtStep2 = {
                        'title': '房间改名和添加应用',
                        'page': '2/2',
                        'content': '不仅可以随心搭配多种精彩的应用，还可以通过拖拽标签来改变房间顺序。',
                        'button': '立即开启',
                        'id': 'close'
                    };

                $('#room-admin').append(tmpl_tips.
                    replace('{TITLE}', oTxtStep1.title).
                    replace('{PAGE}', oTxtStep1.page).
                    replace('{CONTENT}', oTxtStep1.content).
                    replace('{BUTTON}', oTxtStep1.button).
                    replace('{ID}', oTxtStep1.id)
                );
                $('#next-step').live('click', function (e) {
                    e.preventDefault();
                    $(this).parent().remove();
                    $('.nav-items .on').append(tmpl_tips.
                        replace('{TITLE}', oTxtStep2.title).
                        replace('{PAGE}', oTxtStep2.page).
                        replace('{CONTENT}', oTxtStep2.content).
                        replace('{BUTTON}', oTxtStep2.button).
                        replace('{ID}', oTxtStep2.id)
                    );
                    $('.user-guide').css('left', '4px');
                });
                $('#close').live('click', function (e) {
                    e.preventDefault();
                    $(this).parent().remove();
                    showBox(500);
                    $.post_withck(
                        siteUrl+'index.php?app=site&a=tips&siteid=' + siteId,
                        { isSetting: '1'}
                    );
                });
            })();
        }
    });
});
