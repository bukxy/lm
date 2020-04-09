import('../css/front/front.css');
// import('../css/front/front.min.css');

import('../css/front/login.css');
import('../css/front/news.css');
import('../css/front/familiar.css');
import('../css/front/construction.css');
import('../css/front/boost.css');
import('../css/front/calculator.css');
import('../css/front/article.css');

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$(document).scroll(function () {
    if ($(this).scrollTop() > 800) {
        $('.backToTop').fadeIn();
    } else {
        $('.backToTop').fadeOut();
    }
});

$(document).ready(function () {
    // var stickyTop = $('.leftNav .navbar').offset().top;

    // $(window).scroll(function () {
    //     if ($(this).width() >= 1200 ) {
    //         var windowTop = $(window).scrollTop();
    //         if (stickyTop < windowTop && $(".leftNav").height() > windowTop) {
    //             $('.leftNav .navbar').addClass('sticky');
    //         } else {
    //             $('.leftNav .navbar').removeClass('sticky');
    //             $('.leftNav .navbar').css('transition','.5s');
    //         }
    //     }
    // });

    // Add smooth scrolling on all links inside the navbar
    $(".backToTop a").on('click', function (event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {

            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 400, function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });

        } // End if

    });
});