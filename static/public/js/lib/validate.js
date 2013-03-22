(function($) {
    var defaultConfig = {
        errorRequired: '此项为必填项',
        errorTempl: '<span class="validate-error">{msg}</span>',
        optionTempl: '<span class="validate-option">{msg}</span>',
        callback: null
    },

    CSS_ITEM = '.item',
    CSS_ERROR = '.validate-error',
    CSS_OPTION = '.validate-option',

    validateForm = function(el, oRules, oErrorMsg, oOptions, oConfig) {
        if (!oRules || !el) {
            return;
        }
        this.asyncList = [];
        this.asyncEndHandle = null;
        this._init(el, oRules, oErrorMsg, oOptions, oConfig);
    };

    validateForm.prototype = {
        _init: function(el, oRules, oErrorMsg, oOptions, oConfig) {
            var node;
            node = this.node = $(el);
            this.form = (node.attr('tagName').toLowerCase() === 'form') ? node : node.find('form');
            this.config = $.extend(defaultConfig, oConfig);
            this.rules = oRules;
            this.errorMsg = oErrorMsg || {};
            this.optionMsg = oOptions || {};
            node.data('validateForm', this);
            this._bindEvent();
        },

        _bindEvent: function() {
            if (this.node.data('hasBindValidateEvent')) {
                return;
            }
            this.node.data('hasBindValidateEvent', true);
            //bind form.
            this.form.submit($.proxy(function(e) {
                this.validate();
                this._handleFormSubmit(e);
            }, this)).find('input, select, textarea').bind({
                //bind error verifny
                blur: $.proxy(function(e) {
                    this._handleBlur(e);
                }, this),
                //bind option msg 
                focus: $.proxy(function(e) {
                    this._handleFocus(e);
                }, this)
            });

            this._bindRules();
        },

        _bindRules: function() {
            var rules = this.rules,
                k;
            for (k in rules) {
                if (rules.hasOwnProperty(k)) {
                    $(rules[k].elems, this.form).each(function(i, e) {
                        var $e = $(e),
                            r = $e.data('validate-rules') || '';
                        $e.data('validate-rules', r + ',' + k)
                    });
                }
            }
        },

        _handleBlur: function(e) {
            var $e = $(e.target),
                $item = $e.parents(CSS_ITEM).eq(0),
                i,
                r,
                len,
                k,
                hasError = false,
                rules = $e.data('validate-rules');

            $item.find(CSS_OPTION).hide();

            if (!rules) {
                return;
            }

            rules = rules.split(',').slice(1);
            for (i = 0, len = rules.length; i < len; i++) {
                r = this.rules[rules[i]];
                this.validate(r, this.errorMsg[rules[i]], $e);
            }
        },

        _handleFocus: function(e) {
            var na = e.target.getAttribute('name'),
                msg;
            if (!na) {
                return;
            }
            if (msg = this.optionMsg[na.toLowerCase()]) {
                this.displayOptionMsg($(e.target), msg);
            }
        },

        _handleFormSubmit: function(e) {
            e.preventDefault();
            var errorItems,
                processItems,
                o = this;

            errorItems = this.form.find('.has-error');
            if (errorItems.length > 0) {
                e.preventDefault();
                $(o.form).trigger('hasError');
                return;
            }

            processItems = this.form.find('.has-process');
            if (processItems.length > 0) {
                e.preventDefault();
                this.asyncEndHandle = function() {
                    o.asyncEndHandle = null;
                    o._handleFormSubmit(e);
                };
                return;
            }

            if (o.config.callback) {
                e.preventDefault();
                o.config.callback(o.form);
            } else {
                o.form[0].submit();
            }
        },

        clearErrorMsg: function(el) {
            var item = el.parents(CSS_ITEM).eq(0);
            item.find(CSS_ERROR).hide();
        },

        displayError: function(el, msg) {
            var item = el.parents(CSS_ITEM).eq(0),
                option = item.find(CSS_OPTION),
                error = item.find(CSS_ERROR);

            option.hide();
            if (error.length === 0) {
                $(this.config.errorTempl.replace('{msg}', msg)).appendTo(item).show();
                return;
            }

            error.show().html(msg);
            return;
        },

        displayOptionMsg: function(el, msg) {
            if (!msg) {
                return;
            }

            var item = el.parents(CSS_ITEM).eq(0),
                option = item.find(CSS_OPTION),
                error = item.hasClass('has-error');

            if (error) {
                return;
            }

            if (option.length === 0) {
                $(this.config.optionTempl.replace('{msg}', msg)).appendTo(item).show();
                return;
            }

            option.show().html(msg);
            return;
        },

        asyncValidate: function(el, url, cb) {
          if (!el || !url) {
            return;
          }
          var item = el.parent();
          if (item.hasClass('has-process')) {
              return;
          }
          item.addClass('has-process');
          this.asyncList.push($.getJSON(url, $.proxy(function(da){
              var list = this.asyncList;
              cb && cb(da);
              item.removeClass('has-process');
              this.asyncList.pop();
              if (list.length === 0) {
                this.asyncEndHandle && this.asyncEndHandle();
              }
          }, this))); 
          $('body').ajaxError(function(){
              alert('远程验证失败！\n请稍候重试或将此问题反馈给我们(help@12ik.com)');
          });
        },

        validate: function(rule, errorMsg, el) {
            var errorRequired = this.errorMsg.errorRequired,
                verify = function(r, errmsg, el, o) {
                    var item = el.parents(CSS_ITEM).eq(0),
                        hasError = false,
                        k;
                    if (r.isRequired && $.trim(el.val()) === '') {
                        o.displayError(el, errorRequired || defaultConfig.errorRequired);
                        hasError = true;
                        item.addClass('has-error');
                    } else {
                        for (k in r) {
                            if (r.hasOwnProperty(k) && typeof r[k] === 'function') {
                                if (r[k](el, o)) {
                                    o.displayError(el, errmsg[k]);
                                    item.addClass('has-error');
                                    hasError = true;
                                    break;
                                }
                            }
                        }
                        if (!hasError) {
                            o.clearErrorMsg(el);
                            item.removeClass('has-error');
                        }
                    }
                },
                r,
                rules,
                errors,
                k;

            if (!rule) {
                rules = this.rules;
                errors = this.errorMsg;
                for (k in rules) {
                    if (rules.hasOwnProperty(k)) {
                        r = rules[k];
                        $(r.elems, this.form).each($.proxy(function(i, e) {
                            verify(r, errors[k], $(e), this);
                        },
                        this));
                    }
                }
            } else {
                verify(rule, errorMsg, el, this);
            }
        }
    };

    // public validate methods.
    $.extend({
        validate: {
            isEmail: function(s) {
                return /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(s);
            }
        }
    });

    $.fn.validateForm = function(oRules, oErrorMsg, oOptions, oConfig) {
        var options = oOptions,
            config = oConfig;
        if (arguments.length === 3) {
            options = null;
            config = oOptions;
        }
        this.each(function() {
            new validateForm(this, oRules, oErrorMsg, options, config);
        });
        return this;
    };
})(jQuery);
