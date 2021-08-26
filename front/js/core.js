(function ($) {
    $(function () {
        var search = {
            empty: null,
            emptyDefaultText: null,
            form: null,
            formText: null,
            list: null,
            itemTpl: null,

            fail: function (data) {
                this.list.addClass('d-none');
            },

            success: function (data) {
                this.list.find('.js-item').remove();
                if (Array.isArray(data)) {
                    if (data.length) {
                        for (var a = 0; a < data.length; a++) {
                            let item = this.itemTpl.clone();
                            for (prop in data[a]) {
                                let val = data[a][prop];
                                if (prop === 'name' && this.formText.val()) {
                                    let regexp = new RegExp(this.formText.val(), 'ig');
                                    matches = val.match(regexp);
                                    val = val.replace(
                                        regexp,
                                        '<span>' + matches[0] + '</span>'
                                    );
                                }
                                item.find('.js-' + prop).html(val);
                            }
                            this.list.append(item);
                        }
                        this.empty.addClass('d-none');
                        this.list.removeClass('d-none');
                    } else {
                        this.list.addClass('d-none');
                        this.empty.removeClass('d-none');
                    }
                } else
                    console.log(data);
            },

            getProducts: function () {
                this.formText.val(this.formText.val().trim());
                var self = this;
                let data = {
                    action: 'search',
                    params: JSON.stringify(
                        {
                            where: [
                                {
                                    name: 'name',
                                    op: 'like',
                                    value: this.formText.val()
                                }, {
                                    name: 'quantity',
                                    op: '>',
                                    value: 0
                                }
                            ]
                        }
                    )
                };
                $.get(
                    'server.php',
                    data,
                    function (data) {
                        self.success.call(self, data);
                    }
                ).fail(function (data) {
                    self.fail.call(self, data);
                });
            },

            init: function () {
                this.form = $('.js-form-search');
                if (!this.form)
                    return;
                var self = this;
                this.formText = this.form.find('.js-form-text');
                this.form.on('submit', function (event) {
                    event.preventDefault();
                    self.getProducts.call(self);
                });
                this.empty = $('.js-product-list-empty');
                this.emptyDefaultText = this.empty.text();
                this.list = $('.js-product-list');
                this.itemTpl = this.list.find('.js-item-tpl');
                this.itemTpl.removeClass('js-item-tpl');
            }
        };
        search.init();

        var logger = {
            btn: null,
            defaultText: '',
            status: null,

            log: function () {
                var self = this;
                self.status.addClass('invisible');
                $.get(
                    'server.php',
                    { action: 'log' },
                    function (data) {
                        var text = self.defaultText;
                        if (data && 'affected' in data)
                            text += '' + data.affected;
                        else
                            text = 'Нет строк для записи.';
                        self.status.text(text).removeClass('invisible');
                    }
                );
            },

            init: function () {
                let box = $('.js-logger');
                if (!box)
                    return;
                this.btn = box.find('.js-logger-btn');
                this.status = box.find('.js-logger-status');
                this.defaultText = this.status.text();
                var self = this;
                this.btn.on('click', function (event) {
                    self.log.call(self);
                });
            }
        };
        logger.init();
    });
})(jQuery);