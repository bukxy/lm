$(document).ready(function () {

    let hByCat = Object.create(objHuntsByCat);
    hByCat.init();

});

let objHuntsByCat = {

    init: function () {
        let context = this;

        $('.ajax-view_contentByCat').on('click', function (e) {
            e.preventDefault();
            let h_id = $(this).attr("value");
            context.event(h_id);
        });

        $('.ajax-view_contentAll').on('click', function (e) {
            $('.ajax-view_content img').css('filter', 'grayscale(0%)');
        });
    },

    event: function (h_id) {
        $('.ajax-view_content img').css('filter', 'grayscale(100%)');
        $('.ajax-view_content#' + h_id + ' img').css('filter', 'grayscale(0%)');
    }
}