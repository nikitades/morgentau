$(document).ready(function () {
    var prevX;
    var prevY;
    var x;
    var y;
    var currentX;
    var currentY;
    var diffX;
    var diffY;
    var coef = 2;

    $(document).mouseenter(function (e) {
        prevX = e.clientX;
        prevY = e.clientY;
    });

    $(document).mousemove(function (e) {
        el = $('#slider.homePage-slider');
        x = e.clientX;
        y = e.clientY;
        diffX = 100 - (x / coef / ($(document).width() / 100))
        diffY = 100 - (y / ($(document).width() / 100));
        $(el).css('background-position', diffX + "% " + diffY + "%");
    });

});