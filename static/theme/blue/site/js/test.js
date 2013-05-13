$(function(){
    var config = {
        opacity: .6,
        handle: '.hd h2',
        placeholder: 'sort_helper',
        connectWith: '.drop-area',
        items: '.sort',
        scroll: true,
        tolerance: 'pointer',
        start: function (e, ui) {
            ui.placeholder.height(ui.helper.height() - 4);
            ui.placeholder.css('margin-bottom', ui.helper.css('margin-bottom'));
        },
        change: function (e, ui) {
            var placeholder = ui.placeholder, self = ui.item[0];
            if ($(self).hasClass('vonly') && this !== self.parentNode) {
                placeholder.html('此模块只能垂直拖动');
            } else {
                placeholder.html('');
            }
        },
        stop: function (e, ui) {
            var self = ui.item[0], 
            mod_id = self.id.toLowerCase(),
            container = self.parentNode,
            pos = $(container).hasClass('aside')? 'r' : 'l',
            mods = [];
            r_mods = [];

            if (this !== container) {
                if ($(self).hasClass('vonly')) {
                    $(this).sortable('cancel');
                } else {
                    $.getJSON('/j/widget/'+ mod_id.split('-').join('/') + '/?pos=' + pos, 
                            function(da){
                                $(self).replaceWith(da.html)
                            }
                    );
                }
            }

            $('.main .sort').each(function () {
                var extra = $(this).find("#extra")[0];
                mods.push(extra ? this.id + extra.value : this.id);
            });

            $('.aside .sort').each(function () {
                var extra = $(this).find("#extra")[0];
                r_mods.push(extra ? this.id + extra.value : this.id);
            });

            $.post(mine_page_url, {
                mods: mods.join(','),
                r_mods: r_mods.join(','),
                ck: get_cookie('ck')
            });
        }
    };

    $(function(){
		
        $('.main').addClass('drop-area').sortable(config);
        if ($('.aside').length) {
            $('.aside').addClass('drop-area').sortable(config);
        }
    });
});

