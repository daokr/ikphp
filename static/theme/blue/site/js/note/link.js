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
            $(textarea_selector).insert_caret('<a href="' + url + '">' + (text==''?url:text) + "</a>");
        }
    }
}
