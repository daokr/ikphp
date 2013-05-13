(function($) {
    $.fn.extend({
        slider: function (options) {
            var defaults = {
                    slide_items: 4,
                    item_width: 166
                },
                options = $.extend(defaults, options),
                current = 0,
                items_per_page = options.slide_items,
                css_slider_wrap = '.widgets-slider',
                css_slider_list = '.widgets-slider ul',
                css_slider_item = '.widgets-slider li',
                css_btn_prev = '.switcher-prev',
                css_btn_next = '.switcher-next',
                css_dot_item = '.switcher-dot li',
                css_switcher_dis = 'switcher-dis',
                css_switcher_dot = '.switcher-dot',
                templ_dot_item = '<li>{NUM}</li>';

            return this.each(function () {
                var self = this,
                    items_total = $(css_slider_item, this).length,
                    page_nums = Math.ceil(items_total / items_per_page),
                    max_page_index = page_nums - 1,
                    slider_width = items_total * options.item_width + 'px', 
                    oSlider = $(css_slider_list, this),
                    oSwitcher = $(css_btn_prev + ', ' + css_btn_next, this),
                    oSwitcherDot = $(css_dot_item, this)
                    last_nums = items_total,
                    actionSlider = function (obj, step) {
                        var width_each_slide = parseInt($(css_slider_wrap, self).css('width')),
                            duration = Math.abs(step - current) * (items_total - Math.abs(step - current)) * .2 * 200,
                            oSwitcherWrap = obj.parent().next();

                        oSwitcherWrap.children('span').removeClass(css_switcher_dis);
                        if (step === max_page_index) {
                            oSwitcherWrap.children(css_btn_next).addClass(css_switcher_dis);
                        }
                        if (step === 0) {
                            oSwitcherWrap.children(css_btn_prev).addClass(css_switcher_dis);
                        }
                        obj.animate({ 'left': - step * width_each_slide }, duration);
                        oSwitcherWrap.children().children('.on').removeClass();
                        oSwitcherWrap.children().children(':contains("' + step + '")').addClass('on');
                        current = step;
                    };

                // change slider wrapper width
                oSlider.css('width', slider_width);

                // add switcher dots
                if (page_nums > 1) { 
                    for (i = 0; i < page_nums; i++) {
                        $(css_switcher_dot, this).append(templ_dot_item.replace('{NUM}', i));
                    }
                    $(css_switcher_dot + ' li:first', this).addClass('on');
                } else {
                    $(css_btn_next, this).addClass('switcher-dis');
                }

                oSwitcherDot.live('click', function (e) {
                    var step = parseInt($(this).text()),
                        obj = $(this).parent().parent().prev().children(); 

                    actionSlider(obj, step);
                });
                oSwitcher.click(function (e) {
                    var isPrev = $(e.target).hasClass('switcher-prev'),
                        obj = $(this).parent().prev().children(),
                        slide_step = parseInt($(this).parent().children().children('.on').text());

                    if (isPrev) { slide_step -= 1; }
                    else { slide_step += 1; }
                    slide_step = slide_step < 0 ? 0 : slide_step;
                    slide_step = slide_step < max_page_index ? slide_step : max_page_index;
                    if (page_nums > 1) {
                        actionSlider(obj, slide_step);
                    }
                });
            });
        }
    });
})(jQuery);
