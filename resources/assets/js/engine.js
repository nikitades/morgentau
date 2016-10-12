var ajax = function (options) {
    options = options || {};
    options.success = function (data) {
        console.log(data);
    };
    return $.ajax(options);
};