import('../css/front/front.css');
import('../css/front/familiar.css');
import('../css/front/construction.css');

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function () {
    var stickyTop = $('.leftNav .navbar').offset().top;

    $(window).scroll(function () {
        var windowTop = $(window).scrollTop();
        if (stickyTop < windowTop && $(".leftNav").height() > windowTop) {
            $('.leftNav .navbar').addClass('sticky');
        } else {
            $('.leftNav .navbar').removeClass('sticky');
            $('.leftNav .navbar').css('transition','.5s');
        }
    });
});