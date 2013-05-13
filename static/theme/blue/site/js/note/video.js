function openVideoDialog(opt) {
    // opt check
    var textarea_selector = opt && opt.textarea_selector;
    if (!textarea_selector) return;

    var VIDEO_ITEM_TMPL = $.template(null, $('#video_item_tmpl').html()),
        VIDEO_DLG = $('#video_dlg').html(),
        videoList = $('.videos', document.getElementById('form_note')),
        dlg = dui.Dialog();

    var resetTimer,
        updateDlg = function() {
        clearTimeout(resetTimer);
        resetTimer = setTimeout(function() {
            dlg.update();
        }, 100)
    };

    /*
     * ## WIDGET
     * 1. videoURL
     */
    var videoURL = function() {
        var input, msg;

        var isProcessing = false;

        return {
            init: function() {
                var that = this;
                input = $('#video_url');
                msg = input.next();
                // event
                input.focus();
                // event binding
                input.keypress(function(e) {
                    e.preventDefault();
                    if (e.which === 13) {
                        that.saveVideo();
                    }
                });
            },
            showLoading: function() {
                isProcessing = true;
                input.hide();
                msg.show().
                    html('<span class="loading-video">\
                              解析地址中... \
                          </span>');
                updateDlg();
            },
            showError: function(msgStr) {
                isProcessing = true;
                input.hide();
                msg.show().
                    html(msgStr + '&nbsp;&nbsp;&nbsp;<a class="retry">重新输入</a>');
                updateDlg();
            },
            resume: function() {
                isProcessing = false;
                input.val('').show().focus();
                msg.hide();
                updateDlg();
            },
            saveVideo: function() {
                if (isProcessing) {
                    return;
                }

                var url = input.val(),
                    that = this;

                if ($.trim(url) === '') {
                    return;
                }

                $.ajax({
                    type: 'get',
                    url: '/j/video',
                    data: {
                        url: encodeURIComponent(url)
                    },
                    beforeSend: function() {
                        that.showLoading();
                    },
                    success: function(data) {
                        if (data.r) {
                            // displayError
                            that.showError(data.error);
                            return;
                        }
                        // TODO: parse
                        // video seq, according to client
                        var videoData, seq;
                        $.tmpl(VIDEO_ITEM_TMPL, videoData).
                            appendTo(videoList);
                        videoList.show();

                        $(textarea_selector).insert_caret('<视频' + seq + '>');
                        dlg.close();
                    },
                    error: function() {
                        that.showError('网络错误!');
                    }
                });
            }
        };
    }();

    var app = {
        open: function() {
            dlg.set({
                title: '添加视频',
                content: VIDEO_DLG,
                iframe: true,
                width: 400,
                buttons: [{
                    text: '确定',
                    method: function() {
                        videoURL.saveVideo();
                    }
                }, {
                    text: '取消',
                    method: function(o) {
                        o.close();
                    }
                }]
            });

            dlg.open();
            return this;
        },
        initWidgets: function() {
            videoURL.init();
            return this;
        },
        bindEvents: function() {
            dlg.body.find('.video-dlg').delegate(
                '.retry',
                'click',
                function(e) {
                    e.preventDefault();
                    videoURL.resume();
                }
            );
            return this;
        }
    };

    app.open().initWidgets().bindEvents();
}
