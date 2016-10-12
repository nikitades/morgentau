var ajax = function (options) {
    options = options || {};
    if (options.to) {
        options.headers = {
            'to': options.to,
        };
    }
    options.success = function (result) {
        console.log(result);
        if (typeof options.to == 'string' && typeof result.html == 'string') $(options.to).html(result.html);
        if (result.status && typeof options.user_success == 'function') {
            options.user_success(result.data, result.errors);
        } else if (typeof options.user_fail == 'function')  {
            options.user_fail(result.data, result.errors);
        }
    };
    return $.ajax(options);
};