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

    // for comparison of array of objects
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
                        tags += '<图片' + slot.seq + '>\n'
                    }
                }
                textarea.insert_caret(tags);
                $.tmpl(IMAGE_ITEM_TMPL, list).appendTo(imageList);
                imageList.show().
                    trigger('image:saved');
            }
        };
    }();

    var sizeLimit = 1024 * 1000 * 5;
    var uploadArea = {
        // init function
        initDnd: function() {
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
        initUploadify: function() {
            var data = {
                note_id: nid,
                ck: get_cookie('ck')
            };
            data[postParams.siteCookie.name] = postParams.siteCookie.value;
            $('#image_file').uploadify({
                queueID: null,
                uploader: '/swf/uploadify.swf',
                expressInstall: '/swf/expressInstall.swf',
                script: upload_photo_url,
                fileDataName: 'file',
                scriptData: data,
                auto: true,
                multi: true,
                buttonText: '',
                buttonImg: '/pics/upload-pic-btn.png',
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
                        name: fileObj.file_name,
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
        initBasic: function() {
            var that = this;
            Do('iframe-post-form', function() {
                var fileInput = $('#image_file'),
                    form = $('#upload-area');

                fileInput.change(function(e) {
                    var name = (/([^[\\\/]*)$/.exec(fileInput[0].value) || [])[1],
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
                        name: name,
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
            var new_id = imageTable.addSlot(file.fileName, file.fileSize);

            if (new_id === undefined) {
                return;
            }

            if (file.fileSize > sizeLimit) {
                var error = {
                    name: file.fileName,
                    sizeText: parseSize(file.fileSize),
                    size: file.fileSize,
                    ID: new_id,
                    msg: '图片不超过5M'
                };
                imageTable.errorSlot(error, new_id);
                return;
            }
            var formData = new FormData();
            formData.append('image_file', file);
            formData.append('note_id', nid);
            formData.append('ck', get_cookie('ck'));
            formData.append(postParams.siteCookie.name, postParams.siteCookie.value);

            var xhr = new XMLHttpRequest();

            xhr.open('POST', upload_photo_url, true);
            xhr.onreadystatechange = function(e) {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) { // success
                        var response = $.parseJSON(xhr.responseText);
                        if (response.r !== 0) {
                            var error = {
                                name: file.fileName,
                                sizeText: parseSize(file.fileSize),
                                size: file.fileSize,
                                ID: new_id,
                                msg: response.err
                            };
                            imageTable.errorSlot(error, new_id);
                            return;
                        }
                        var photo = response.photo;
                        var real = {
                            name: file.fileName,
                            sizeText: parseSize(photo.file_size),
                            size: photo.file_size,
                            seq: photo.seq,
                            thumb: photo.thumb,
                            ID: new_id
                        };
                        imageTable.finishSlot(real, new_id);
                    } else { // error
                        var error = {
                            name: file.fileName,
                            sizeText: parseSize(file.fileSize),
                            size: file.fileSize,
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
