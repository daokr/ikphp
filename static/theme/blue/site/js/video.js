Douban.init_add_video = function(o) {
    var url = $(this)[0].href.replace('/widget/', '/j/widget/'),
    add = function(e){
      if(e){
        e.preventDefault();
      }
      Douban.remote_submit_json(this.node.find('form')[0], $.proxy(function(r){
        var err;
        if(!r.error){
            location.reload();
            return;
        }
        err = this.node.find('.bd .attn');
        if(err.length === 0){
          this.node.find('.bd').append('<div class="attn">' + r.error + '</div>');
        }else{
          err.html(r.error);
        }
        this.updateSize();
        this.updatePosition();
      }, this), false);
    };
    $.getJSON(url, function(r){
        var dlg = dui.Dialog({
            title: '添加视频',
            content: r.html,
            width: 500,
            buttons: [
            {text: '添加',
            method:function(o){
                add.call(o, null);
            }},
            'cancel'
            ]
        }).open();
        dlg.node.find('form').submit($.proxy(add, dlg));;
    });
};

Douban.init_edit_video = function(o) {
    var url = $(this).attr('href').replace('/widget/', '/j/widget/'),
    edit = function(frm, o){
        Douban.remote_submit_json(frm, $.proxy(function(r){
            var err;
            if(!r.error){
                location.reload();
                return;
            }
            err = this.node.find('.bd .attn');
            if(err.length === 0){
              this.node.find('.bd').append('<div class="attn">' + r.error + '</div>');
            }else{
              err.html(r.error);
            }
            this.updateSize();
            this.updatePosition();
        }, o), false);
    };
    $.getJSON(url, function(r){
        var dlg = dui.Dialog({
            title: '修改视频',
            content: r.html,
            width: 500,
            buttons: [
            {text: '修改',
            method:function(o){
              edit(o.node.find('form')[0], o);
            }},
            'cancel'
            ]
        }).open();
        dlg.node.find('form').submit(function(e){
            e.preventDefault();
            edit(this, dlg);
        });
    });
};
