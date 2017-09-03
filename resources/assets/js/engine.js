var m = function () {
    var id = function (len) {
        len = len || 9;
        return '_' + Math.random().toString(36).substr(2, len);
    };

    var initial_debug = function () {
        if ($('#initial_debug').length && $('#initial_debug').attr('content') != '') console.warn(JSON.parse($('#initial_debug').attr('content')));
    };

    var ajax = function (options) {
        var autohide = true;
        var success = function () {
            console.trace();
        };
        var ah_time = 250;
        var req_time = Date.now();
        setTimeout(function () {
            autohide = false;
        }, ah_time);

        function showPreloader() {
            $('body').append('<div class="preloader-container"><div class=\'preloader uil-sunny-css\' style=\'transform:scale(0.6);\'><div class="uil-sunny-circle"></div><div class="uil-sunny-light"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div></div>');
            $('.preloader-container').css('opacity', 0).animate({opacity: 1}, 250);
        }

        function hidePreloader() {
            $('.preloader-container').animate({opacity: 0}, 250);
            setTimeout(function () {
                $('.preloader-container').remove();
            }, ah_time);
        }

        options = options || {};
        options = $.extend({
            type: 'POST',
            method: 'POST'
        }, options);
        options.headers = options.headers || {};
        options.headers = $.extend(options.headers, {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        });
        options.correct_ending = false;
        if (options.to) {
            showPreloader();
            options.headers = $.extend(options.headers, {
                'to': options.to,
            });
        }
        options.success = function (result) {
            if (typeof result == 'string') {
                hidePreloader();
                m.modal({
                    heading: 'Соединение нарушено',
                    content: result,
                });
            } else {
                if ((typeof options.to == 'string' || $(options.to).length) && typeof result.html == 'string') $(options.to).html(result.html);
                if (result.status && typeof options.user_success == 'function') {
                    options.user_success(result.data, result.errors);
                } else if (typeof options.user_fail == 'function') {
                    options.user_fail(result.data, result.errors);
                }
                if (result.debug && typeof result.errors != 'undefined' && result.errors && result.errors.length) {
                    for (var i = 0; i < result.errors.length; i++) {
                        console.error(result.errors[i]);
                    }
                }
                if (result.debug && typeof result.debug_messages == 'object' && result.debug_messages != null) console.warn(result.debug_messages);
                setTimeout(function () {
                    hidePreloader();
                    if (options.time) console.log('spent time', Date.now() - req_time);
                }, autohide ? ah_time : 0);
            }
        };
        options.error = function (e) {
            hidePreloader();
            m.modal({
                heading: 'Ошибка AJAX-соединения',
                content: e.responseText,
                // confirmation: {
                //     phrase: 'Сохранить лог ошибки в файл?',
                //     on_success: function () {
                //         alert('he')
                //     },
                //     on_decline: function () {
                //         alert('ho')
                //     },
                // }
            });
        };
        return $.ajax(options);
    };

    var modal = function (options) {
        var popup_uclass = m.id();
        var default_options = {
            heading: '',
            content: '',
            auto_close: false,
            confirmation: false,
            acceptance: false,
            popup_custom_class: '',
            heading_custom_class: '',
            content_custom_class: '',
            width: undefined,
            height: undefined,
            closeContent: '<a class="btn btn-xs btn-danger">✕</a>',
            // acceptance: {
            //     phrase: '',
            //     on_success: function () {}
            // }
            // confirmation: {
            //     phrase: '',
            //     on_success: function () {},
            //     on_decline: function () {},
            // }
        };
        options = $.extend(default_options, options);

        var popup = new $.Popup({
            afterClose: function () {
                $('body').removeClass('noscroll');
            },
            closeContent: '<a class="btn btn-xs btn-danger">Ы</a>',
            height: options.height,
            width: options.width
        });

        var html = '<div id="lost_wrapper">' +
            '<div class="morgentau-popup ' + popup_uclass + ' ' + options.popup_custom_class + '">' +
            '<div class="popup_close">' + options.closeContent + '</div>' +
            '<div class="morgentau-popup-header ' + options.heading_custom_class + '">' +
            (options.heading != '' ? '<h2>' + options.heading + '</h2>' : '') +
            '</div>' +
            (options.content != '' ? '<div class="morgentau-popup-content ' + options.content_custom_class + '">' + options.content +
                '</div>' : '') +
            (options.confirmation ? '<div class="morgentau-popup-confirmation"><h2 class="morgentau-popup-modal-heading"">' + options.confirmation.phrase + '</h2><a href="javascript: void(0)" class="btn btn-success morgentau-popup-confirmation-yes">Подтвердить</a><a href="javascript: void(0)" class="btn btn-warning morgentau-popup-confirmation-no">Отмена</a></div>' : '') +
            (options.acceptance ? '<div class="morgentau-popup-acceptance"><h2 class="morgentau-popup-modal-heading"">' + options.acceptance.phrase + '</h2><a href="javascript: void(0)" class="btn btn-success morgentau-popup-acceptance-yes">OK</a></div>' : '') +
            '</div>' +
            '</div>';

        if (options.confirmation !== false && typeof options.confirmation == 'object') {
            if (typeof options.confirmation.on_success == 'function') $('body').on('click', '.' + popup_uclass + ' .morgentau-popup-confirmation-yes', options.confirmation.on_success);
            if (typeof options.confirmation.on_decline == 'function') $('body').on('click', '.' + popup_uclass + ' .morgentau-popup-confirmation-no', options.confirmation.on_decline);
        }

        //TODO: добраться-таки до контроллера и сортировки

        if (options.acceptance !== false && typeof options.confirmation == 'object') {
            if (typeof options.acceptance.on_success == 'function') $('body').on('click', '.' + popup_uclass + ' .morgentau-popup-acceptance-yes', options.acceptance.on_success);
        }

        $('body').on('click', '.' + popup_uclass + ' .popup_close', popup.close);
        $('body').addClass('noscroll');
        popup.open($(html));
        if (typeof options.auto_close == 'number') setTimeout(popup.close, options.auto_close);

        return popup;
    };

    initial_debug();

    return {
        ajax: ajax,
        modal: modal,
        id: id
    }
};
var m = m();