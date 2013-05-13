//@import /js/sns/note/image.js
//@import /js/sns/note/video.js
//@import /js/sns/note/link.js

IK('template', 'dialog', 'modernizr.dnd', 'uploadify', function() {
    var formNote = $('#form_note'),
        control_panel = $('.control-panel', formNote),
        images = formNote.children('.images'),
        videos = formNote.children('.videos'),
        noteTitle = $('#note_title'),
        noteText = $('#note_text'),
        notePrivacy = formNote.find('.note-privacy'),
        noteSubmitButton = formNote.find('#publish_note'),
        cannotReply = $('#cannot_reply'),
        NOTE_TEXT = '#note_text';

    var nid = $('#note_id').val();
	var userid = $('#userid').val(); 

    var readyToLeave = false;

    /*
     * 错误信息模块
     */
    var errorInfo = function() {
        var tip = $('<div class="error-msg tip"></div>'),
            board = formNote.find('.footer .error-msg'),
            reset;
        tip.appendTo('body');
        return {
            putAside: function (anchor, msg) {
                clearTimeout(reset);
                var pos = anchor.offset(),
                    width = anchor.outerWidth();
                tip.text(msg).
                    css({
                        top: pos.top + 5,
                        left: pos.left + width + 5
                    }).
                    show();
                $('html, body').animate({
                    scrollTop: pos.top - 10
                });

                reset = setTimeout(function() {
                   tip.hide();
                }, 5000);
            },
            showBoard: function (msg) {
                board.text(msg).show();
                setTimeout(function() {
                   board.text('');
                }, 5000);
            },
            clear: function() {
                tip.hide();
                board.hide();
            }
        }
    }();

    // control_panel 预处理
    control_panel.delegate('a', 'click', function(e) {
        e.preventDefault();
    });
    noteText.set_caret();

    /*
     * 图片模块
     */
    if (images.children().length !== 0) {
        images.show();
    }
    control_panel.delegate('.image-btn', 'click', function(e) {
        e.preventDefault();
        openImageDialog({
            textarea_selector: NOTE_TEXT,
            nid: nid,
            upload_photo_url: UPLOAD_PHOTO_URL
        });
    });
    images.delegate('.delete-image', 'click', function(e) {
        e.preventDefault();
        var item = $(this).parent('.image-item'),
            tagName = item.find('.image-name').text(); 
        item.slideUp(function() {
            item.remove();
        });
        //noteText[0].value = noteText[0].value.replace(new RegExp(tagName, 'g'), '');
		noteText[0].value = noteText[0].value.replace(tagName, '');

        if (images.children().length === 0) {
            images.hide();
        }
    });
    images.bind('image:saved', autoSave);

    /*
     * 视频模块
     */
    if (videos.children().length !== 0) {
        videos.show();
    }
    control_panel.delegate('.video-btn', 'click', function(e) {
        e.preventDefault();
        openVideoDialog({
			textarea_selector: NOTE_TEXT,
			nid: nid,
            upload_video_url: UPLOAD_VIDEO_URL
			});
    });
    videos.delegate('.delete-video', 'click', function(e) {
        e.preventDefault();
        var item = $(this).parent('.video-item'),
            tagName = item.find('.video-name').text();
        item.slideUp(function() {
            item.remove();
        });
        //noteText[0].value = noteText[0].value.replace(new RegExp(tagName, 'g'), '');
		noteText[0].value = noteText[0].value.replace(tagName, '');
        if (videos.children().length === 0) {
            videos.hide();
        }
    });

    /*
     * 链接模块
     */
    control_panel.delegate('.link-btn', 'click', function(e) {
        e.preventDefault();
        openLinkDialog({
            textarea_selector: NOTE_TEXT,
            selected_text: noteText.get_sel()
        });
    });

    /*
     * 验证模块
     */
    function validate() {
        if ($.trim(noteTitle.val()) === '') {
            errorInfo.putAside(noteTitle, '给日记加个标题吧');
            return false;
        }
        if ($.trim(noteText.val()) === '') {
            errorInfo.putAside(noteText, '日记正文还没写呢');
            return false;
        }

        return true;
    }
    formNote.submit(function () {
        if (validate() && !noteSubmitButton.attr('isPublishing')) {
            noteSubmitButton.attr('isPublishing', 'true');
            readyToLeave = true;
            return true;
        } else {
            return false;
        }
    });

    /*
     * 获取note的数据, 服务ajax的data
     */
    function getFormData() {
        var data = {};
        $.each(formNote.serializeArray(), function(i, elem) {
            data[elem.name] = elem.value;
        });
        return data;
    }

    /*
     * 预览模块
     */
    var preview = $('#preview'),
        previewNote= $('#preview_note'),
        isPreviewing = false,

        PREVIEW_TMPL = $.template(null, $('#preview_tmpl').html());
    previewNote.click(function(e) {
        e.preventDefault();
        if (validate() && !isPreviewing) {
            $.ajax({
                type: 'post',
                url: PREVIEW_URL,
                data: getFormData(),
                beforeSend: function() {
                    isPreviewing = true;
                    previewNote.val('预览中...');
                },
                success: function(response) {
                    if (!response) {
                        errorInfo.showBoard('预览内容解析错误');
                        return;
                    }
                    if (response.r) {
                        // show error
                        errorInfo.showBoard(response.err);
                    } else {
                        response.content.cannot_reply = cannotReply.is(':checked') ? '日记被作者设为不可回应' : '';
                        var privacy = notePrivacy.find('input:checked').val();
                        response.content.note_privacy = (privacy === 'S') ? '仅朋友可见' : (privacy === 'X' ? '仅自己可见' : '');
                        // show preview
                        formNote.hide();
                        preview.empty().
                            append($.tmpl(PREVIEW_TMPL, response.content)).
                            show();
                    }
                },
                error: function() {
                    // show error
                    errorInfo.showBoard('发生网络错误了，暂时不能预览');
                },
                complete: function() {
                    isPreviewing = false;
                    previewNote.val('预览');
                }
            });
        }
        autoSave();
    });
    preview.delegate('.continue-edit', 'click', function(e) {
        preview.hide();
        formNote.show();
    });
    preview.delegate('.submit-note', 'click', function(e) {
        if (!noteSubmitButton.attr('isPublishing')) {
            noteSubmitButton.click();
            noteSubmitButton.attr('isPublishing', 'true');
            readyToLeave = true;
        }
    });

    /*
     * 自动保存
     */
    function autoSave() {
        $.ajax({
            type: 'post',
            url: AUTOSAVE_URL,
            data: getFormData()
        });
    }

    noteText.keydown(function(e) {
        if (String.fromCharCode(e.which).toLowerCase() == 's' && e.ctrlKey) {
            e.preventDefault();
            autoSave();
            return false;
        }
    });

    //setInterval(autoSave, 1000 * 60 * 5 ); // 5分钟保存一次

    /*
     * 离开时提醒
     */
  /*  window.onbeforeunload = function(e) {
        if (!readyToLeave) {
            return '日记还没有提交';
        }
    };
*/
    var isRealCancel = false;
    $('#cancel_note').click(function(e) {
        if (isRealCancel) {
            return true;
        }
        e.preventDefault();
        var dlg = dui.Dialog({
            title: '取消新加日记',
            content: '日记还未保存，确定要放弃编辑吗？',
            iframe: true,
            width: 370,
            buttons: [{
                text: '确定离开',
                method: function(o) {
                    readyToLeave = true;
                    o.close();
                    isRealCancel = true;
                    $('#cancel_note').click();
                }
            }, {
                text: '留在此页',
                method: function(o) {
                    o.close();
                }
            }]
        });

        dlg.open();
    });
});
////////////////////////////////////
function openLinkDialog(opt) {
    var textarea_selector = opt && opt.textarea_selector,
    selected_text = opt && opt.selected_text;
    if (!textarea_selector) return;

    var dlg = dui.Dialog(),
        LINK_DLG = $('#link_dlg')[0].innerHTML;

    dlg.set({
        title: '添加链接',
        iframe: true,
        content: LINK_DLG.replace('SEL', selected_text),
        width: 400,
        buttons: [{
            text: '确定',
            method: saveLink
        },{
            text: '取消',
            method: function(o) {
                o.close();
            }
        }]
    });
    dlg.open();

    // app event binding
    if (selected_text) {
        $('#link_url').focus();
    } else {
        $('#link_text').focus();
    }

    $('#link_url').keypress(function(e) {
        if (e.which === 13) {
            saveLink();
        }
    });

    // app method
    function saveLink() {
        var text = $('#link_text').val(),
            url = $.trim($('#link_url').val());
        dlg.close();
        if (url!== '') {
            url = (/^https?:\/\//.test(url) ? url : "http://"+url);
			$(textarea_selector).insert_caret('[url=' + url + ']' + (text===''? url : text) + "[/url]");
        }
    }
}
//////////////////////////////////////////////////
function openImageDialog(opt) {
    var textarea_selector = opt && opt.textarea_selector,
        isBasic = opt && opt.isBasic,
        nid = opt && opt.nid,
        upload_photo_url = opt && opt.upload_photo_url;
    if (!textarea_selector) return;

    var IMAGE_ITEM_TMPL = $.template(null, $('#image_item_tmpl').html()),
        IMAGE_DLG_TMPL = $.template(null, $('#image_dlg_tmpl').html()),
        SLOT_TMPL = $.template(null, $('#image_slot').html()),
        SLOT_TMPL_LOADING = $.template(null, $('#image_slot_loading').html()),
        SLOT_TMPL_ERROR = $.template(null, $('#image_slot_error').html());

        textarea = $(textarea_selector),
        dlg = dui.Dialog();

    var resetTimer,
        updateDlg = function() {
        clearTimeout(resetTimer);
        resetTimer = setTimeout(function() {
            dlg.update();
        }, 100)
    };

    var parseSize = function(size) {
        var suffix = ['B', 'KB', 'MB', 'GB'],
            tier = 0;
        while (size > 1024) {
            size = size / 1024;
            tier++;
        }

        return Math.round(size*10) / 10 + "" + suffix[tier];
    };

    // for comparison of array of objects 比较数组对象
    var by = function(name) {
        return function(o, p) {
            var a, b;
            if (typeof o === 'object' &&
                typeof p === 'object' &&
                o &&
                p) {
                a = o[name];
                b = p[name];
                if (a === b) {
                    return 0;
                }
                if (typeof a === typeof b) {
                    return a < b ? -1 : 1;
                }
                return typeof a < typeof b ? -1 : 1;
            } else {
                throw {
                    name: 'Error',
                    message: 'Expected an object when sorting by ' + name
                };
            }
        };
    }


    /*
     * ## WIDGET
     * 1. imageTable 下面的图片列表
     * 2. uploadArea 上方的上传区域，根据浏览器初始化
     */
    var imageTable = function() {
        var slots, imageList, self, footer, image_num, total_size;

        var list =  [],
            id = 0;

        return {
            init: function() {
                self = $('.upload-info');
                slots = $('#image-slots');
                imageList = $('.images', document.getElementById('form_note'));
                footer = $('.footer', document.getElementById('image_upload'));
                image_num = footer.find('.image-num');
                total_size = footer.find('.image-total-size');



                var that = this;
                // event binding
                slots.delegate('a.image-delete', 'click', function(e) {
                    e.preventDefault();
                    var ID = $(this).closest('.slot').attr('data_id');
                    that.removeSlot(ID);
                });
            },
            addSlot: function(name, size, ID) {
                if (list.length >= 20) {
                    footer.find('.total-num').find('.num-warning').show();
                    return undefined;
                }
                //每个文件有唯一的id，uploadify用它自己的，而其他则用累加器
                var ID = ID || id++;
                var isBasic = !size;
                if (isBasic) {
                   $.tmpl(SLOT_TMPL_LOADING, {
                        isBasic: isBasic,
                        name: name,
                        ID: ID
                    }).appendTo(slots);
                } else {
                    $.tmpl(SLOT_TMPL_LOADING, {
                        isBasic: isBasic,
                        name: name,
                        sizeText: parseSize(size),
                        ID: ID
                    }).appendTo(slots);
                }

                updateDlg();

                list.push({
                    ID: ID,
                    unfinished: true
                });
                self.show();

                return ID;
            },
            removeSlot: function(ID) {
                if (ID === undefined) {
                    return;
                }
                slots.find('[data_id="' + ID + '"]').remove();
                for (var i=list.length-1; i>=0; i--) {
                    if (list[i].ID == ID) {
                        list.splice(i, 1);
                        break;
                    }
                }
                if (list.length === 0) {
                    self.hide();
                }
                updateDlg();
                this.updateInfo();
            },
            finishSlot: function(real, ID) {
                if (!real) return;
                var slot = slots.find('[data_id="' + ID + '"]');
                if (slot.length < 1) { 
                    $.tmpl(SLOT_TMPL, real).addClass('done').appendTo(slots); 
                } else {
                    $.tmpl(SLOT_TMPL, real).addClass('done').insertAfter(slot);
                    slot.remove();
                }
                for (var i=list.length-1; i>=0; i--) {
                    if (list[i].ID === ID) {
                        list.splice(i, 1, real);
                        break;
                    }
                }
                updateDlg();
                this.updateInfo();
            },
            errorSlot: function(error, ID) {
                var slot = slots.find('[data_id="' + ID + '"]');
                if (!error.isBasic) {
                    error.isBasic = false;
                }
                if (error.cb) {
                    error.retry = true;
                }
                if (slot.length < 1) {
                    $.tmpl(SLOT_TMPL_ERROR, error).appendTo(slots);
                } else {
                    $.tmpl(SLOT_TMPL_ERROR, error).insertAfter(slot);
                    slot.remove();
                }
                self.show();

                if (error.cb) {
                    slot = slots.find('[data_id="' + ID + '"]');
                    slot.find('a.image-retry').click(function(e) {
                        e.preventDefault();
                        error.cb();
                    });
                }

                error.unfinished = true;

                for (var i=list.length-1; i>=0; i--) {
                    if (list[i].ID === ID) {
                        list.splice(i, 1, error);
                        break;
                    }
                }
                updateDlg();
            },
            progressSlot: function(percentage, ID) {
                var ID = ID || id;
                var slot = slots.find('.slot[data_id="' + ID + '"]');
                slot.find('.percentage').text(percentage + '%');
                slot.find('.progress').css({
                    width: percentage + '%'
                });
            },
            updateInfo: function() {
                var num = 0, size = 0,
                    i, slot;

                for (i = list.length - 1; i>=0; i--) {
                    slot = list[i];
                    if (!slot.unfinished){
                        num += 1;
                        size += slot.size;
                    }
                }

                image_num.text(num);
                total_size.text(parseSize(size));
            },
            saveImages: function() {
                var i, len, slot, tags;
                list.sort(by('seq'));
                for (i=0, len=list.length, tags = ''; i<len; i++) {
                    slot = list[i];
                    if (slot.unfinished){
                        list.splice(i, 1);
                    } else {
                        tags += '[图片' + slot.seq + ']\n'
                    }
                }
                textarea.insert_caret(tags);
                $.tmpl(IMAGE_ITEM_TMPL, list).appendTo(imageList);
                imageList.show().
                    trigger('image:saved');
            }
        };
    }();

    var sizeLimit = 1024 * 1000 * 2;
    var uploadArea = {
        // init function
        initDnd: function() { //初始化拖拽上传
            var that = this;
            var droppable = $('.drag-drop', document.getElementById('upload-area'));
            droppable[0].addEventListener('dragover', function(e) {
                e.stopPropagation();
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
            }, false);
            droppable[0].addEventListener('drop', function(e) {
                e.stopPropagation();
                e.preventDefault();

                var files = e.dataTransfer.files; 
                for (var i=0, f; f=files[i]; i++) { 
                    if (f.type.match(/image.*/)) {
                        that.dndUploadFile(f);
                    }
                }
            }, false);
        },
        initUploadify: function() {//flash 上传
            var data = {
                note_id: nid, 
				userid: $('#userid').val(),
                ck: get_cookie('ck')
            }; 
            data[postParams.siteCookie.name] = postParams.siteCookie.value; 
            $('#image_file').uploadify({ 
                queueID: null,
                uploader: siteUrl + 'app/site/swf/uploadify.swf',
                expressInstall: siteUrl + 'app/site/swf/expressInstall.swf',
                script: upload_photo_url,
                fileDataName: 'file',
                scriptData: data,
                auto: true,
                multi: true,
                buttonText: '',
                buttonImg: siteUrl + 'app/site/pics/upload-pic-btn.png',
                width: 90,
                height: 22,
                rollover: true,
                sizeLimit: sizeLimit,
                fileDataName: 'image_file',
                fileExt: '*.jpeg;*.gif;*.jpg;*.png;',
                fileDesc: '图片文件',
                onError: function(e, ID, fileObj, errorObj) {
                    var error = {
                        name: fileObj.name,
                        sizeText: parseSize(fileObj.size),
                        size: fileObj.size,
                        ID: ID
                    };
                    if (errorObj.type == 'HTTP' || errorObj.type === 'IO') { 
                        error.msg = '网络错误';
                        imageTable.errorSlot(error, ID);
                    }
                    if (errorObj.type == 'File Size') {
                        error.msg = '图片太大';
                        imageTable.errorSlot(error, ID);
                    }
                },
                onOpen: function(e, ID, fileObj) { 
                    var new_id = imageTable.addSlot(fileObj.name, fileObj.size, ID);
                    if (new_id === undefined) {
                        $('#image_file').uploadifyCancel(ID);
                    }
                },
                onCancel: function(e, ID, fileObj, data) { 
                    return false;
                },
                onComplete: function(e, ID, fileObj, response, data) {  
                    response = $.parseJSON(response); 
                    if (response.r !== 0) { 
                        var error = {
                            name: fileObj.file_name,
                            sizeText: parseSize(fileObj.size),
                            size: fileObj.size,
                            ID: ID,
                            msg: response.err
                        };
                        imageTable.errorSlot(error, ID);
                    }
                    var photo = response.photo; 
                    var real = {
                        //name: fileObj.file_name, //原版bug
						name: photo.file_name,
                        sizeText: parseSize(photo.file_size),
                        size: photo.file_size,
                        seq: photo.seq,
                        thumb: photo.thumb,
                        ID: ID
                    };
                    imageTable.finishSlot(real, ID);
                },
                onProgress: function(e, ID, fileObj, data) { 
                    imageTable.progressSlot(data.percentage, ID);
                    return false;
                },
                onSWFReady: function() {
                    updateDlg();
                }
            });
        },
        initBasic: function() { //初始化基本上传
            var that = this;
            IK('iframe-post-form', function() {
                var fileInput = $('#image_file'),
                    form = $('#upload-area'); 

                fileInput.change(function(e) { //当点击浏览按钮
                    var name = (/([^[\\\/]*)$/.exec(fileInput[0].value) || [])[1],//文件名称
                        new_id = imageTable.addSlot(name); // basic				

                    if (new_id === undefined) {
                        return;
                    }
                    that.basicUploadFile(new_id, form, fileInput);
                });
            });
        },
        basicUploadFile: function(new_id, form, fileInput) {
            var suffix = /\.([^\.]+)$/,
                fileName = /([^\\\/]*)$/,

                options = {
                json: true,
                iframeID: 'iframe-post-' + new_id,
                post: function() {
                    var hash = {
                            'jpeg': 1,
                            'png': 1,
                            'jpg': 1,
                            'gif': 1
                        };
                    var path = fileInput[0].value; 
                    if (!hash[(suffix.exec(path) || [])[1]]) { 
                        var error = {
                            name: (fileName.exec(path) || [])[1],
                            ID: new_id,
                            sizeText: '',
                            msg: '请选择图片文件(JPG/JPEG, PNG,或GIF)'
                        };
                        imageTable.errorSlot(error, new_id);
                        fileInput.val('');
                        return false;
                    }
                },
                complete: function(response) { 
                    var path = fileInput[0].value,
                        name = (fileName.exec(path) || [])[1];
					var response = $.parseJSON(response);
                    if (response === null) { 
                        var error = {
                            name: name,
                            ID: new_id,
                            sizeText: '',
                            msg: '网络错误',
                            cb: function() {
                                var returnNewId;
                                imageTable.removeSlot(new_id);
                                returnNewId = imageTable.addSlot(name, undefined, new_id);
                                if (returnNewId === undefined) {
                                    return;
                                }
                                form.trigger('submit');
                            }
                        };
                        imageTable.errorSlot(error, new_id);
                        return;
                    } 
                    if (response.r !== 0) {
                        var error = {
                            name: name,
                            ID: new_id,
                            sizeText: '',
                            msg: response.err
                        };
                        imageTable.errorSlot(error, new_id);
                        fileInput.val('');
                        return;
                    }
                    var photo = response.photo;
                    var real = {
                        //name: name,
                        name: photo.file_name,
						sizeText: parseSize(photo.file_size),
                        size: photo.file_size,
                        seq: photo.seq,
                        thumb: photo.thumb,
                        ID: new_id
                    };
					
                    imageTable.finishSlot(real, new_id);
                }
            };
            form.unbind('submit');
            form.iframePostForm(options);
            form.trigger('submit');
        },
        // upload function
        dndUploadFile: function(file) { 
            //var new_id = imageTable.addSlot(file.fileName, file.fileSize);
			var new_id = imageTable.addSlot(file.name, file.size); 
            if (new_id === undefined) {
                return;
            }

            if (file.size > sizeLimit) {
                var error = {
                    name: file.name,
                    sizeText: parseSize(file.size),
                    size: file.size,
                    ID: new_id,
                    msg: '图片不超过5M'
                };
                imageTable.errorSlot(error, new_id);
                return;
            }
            var formData = new FormData();
            formData.append('image_file', file);
            formData.append('note_id', nid);
			formData.append('userid', $('#userid').val()); 
            formData.append('ck', get_cookie('ck'));
            formData.append(postParams.siteCookie.name, postParams.siteCookie.value);//神作业

            var xhr = new XMLHttpRequest();

            xhr.open('POST', upload_photo_url, true); 
            xhr.onreadystatechange = function(e) {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) { // success
                        var response = $.parseJSON(xhr.responseText);
                        if (response.r !== 0) {
                            var error = {
                                name: file.name,
                                sizeText: parseSize(file.size),
                                size: file.name,
                                ID: new_id,
                                msg: response.err
                            };
                            imageTable.errorSlot(error, new_id);
                            return;
                        }
                        var photo = response.photo;
                        var real = {
                           // name: file.fileName,
                            name: photo.file_name,
							sizeText: parseSize(photo.file_size),
                            size: photo.file_size,
                            seq: photo.seq,
                            thumb: photo.thumb,
                            ID: new_id
                        };
                        imageTable.finishSlot(real, new_id);
                    } else { // error
                        var error = {
                            name: file.name,
                            sizeText: parseSize(file.size),
                            size: file.size,
                            ID: new_id,
                            msg: '网络错误',
                            cb: function() {
                                xhr.open('POST', upload_photo_url, true);
                                xhr.send(formData);
                            }
                        };
                        imageTable.errorSlot(error, new_id);
                    }
                }
            };
            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    var percentage = parseInt((e.loaded/e.total)*100, 10);
                    imageTable.progressSlot(percentage, new_id);
                }
            };
            xhr.send(formData);
        }
    };

    var app = {
        tmplData: {},
        init: function(isBasic) { 
            var tmplData = this.tmplData;
            tmplData.nid = nid;
            tmplData.UPLOAD_URL = UPLOAD_PHOTO_URL;
            if (Modernizr.draganddrop && !$.browser.msie && (typeof FormData !== 'undefined')) {
                tmplData.dnd = true;
            } else {
                tmplData.dnd = false;
            }

            var flashVersion = swfobject.getFlashPlayerVersion(); 
            if (flashVersion.major > 9) {
                tmplData.flash = true;
            } else {
                tmplData.flash = false;
            }
            if (isBasic) {
                tmplData.dnd = false;
                tmplData.flash = false;
                tmplData.basic = true;
            } else {
                tmplData.basic = false;
            }

            return this;
        },
        open: function() {
            var that = this;
            dlg.set({
                title: '添加图片',
                content: $.tmpl(IMAGE_DLG_TMPL, that.tmplData),
                iframe: true,
                width: 650,
                buttons: [{
                    text: '保存',
                    method: function(o) {
                        imageTable.saveImages();
                        o.close();
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
            var tmplData = this.tmplData; 
            if (tmplData.dnd) {
                uploadArea.initDnd();
            }
            if (tmplData.flash) {
                uploadArea.initUploadify();
            }
            if (!tmplData.flash) {
                uploadArea.initBasic();
            }

            imageTable.init();

            return this;
        },
        bindEvents: function() {
            var uploadAlter = $('.upload-alternative', document.getElementById('image_upload'));

            uploadAlter.delegate('.upload-basic', 'click', function(e) {
                e.preventDefault();
                openImageDialog({
                    textarea_selector: textarea_selector,
                    nid: nid,
                    isBasic: true
                });
            });
            uploadAlter.delegate('.upload-multi', 'click', function(e) {
                e.preventDefault();
                openImageDialog({
                    textarea_selector: textarea_selector,
                    nid: nid
                });
            });
            return this;
        }
    };

    app.init(isBasic).
        open().
        initWidgets().
        bindEvents();
}
////////////////////////////////////////////////////
function openVideoDialog(opt) {
    // opt check
    var textarea_selector = opt && opt.textarea_selector,
	    nid = opt && opt.nid,
        upload_video_url = opt && opt.upload_video_url;
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
                //input.focus();
                // event binding
                input.keypress(function(e) {
                    //e.preventDefault();
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
                    type: 'post',
                    url: upload_video_url,
                    data: {
						nid: nid,
                        url: encodeURIComponent(url)  //编码传送
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
                        /*var videoData, seq;
                        $.tmpl(VIDEO_ITEM_TMPL, videoData).
                            appendTo(videoList);
                        videoList.show();
						*/
						var html = '<div class="video-item">'+
							'<input type="hidden" name="video'+data.seqid+'" value="'+data.seqid+'" />'+
							'<a href="#" class="delete-video" title="删除该视频" onclick="">X</a>'+
							'<div class="thumbnail">'+
							'<label class="video-name">[视频'+data.seqid+']</label>'+
							'<div class="video-thumb">'+
							'<div class="video_overlay"></div>'+
							'<a href="'+data.url+'" target="_blank">'+
							'<img src="'+data.imgurl+'" />'+
							'</a>'+
							'</div>'+
							'</div>'+
							'<div class="video-info">'+
							'<label>视频信息</label>'+
							'<div>'+
							'<textarea maxlength="30" name="videotitle" id="videotitle" style="height:60px; width:385px">'+data.title+'</textarea>'+
							'</div>'+
							'</div>'+
							'</div>';
						$('.videos').append(html).show();
                        $(textarea_selector).insert_caret('[视频' + data.seqid + ']');
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

