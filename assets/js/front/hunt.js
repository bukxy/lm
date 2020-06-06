$(document).ready(function () {

    let hunt = Object.create(objHunt);
    hunt.init();

});

let objHunt = {

    init: function () {
        let context = this;

        $('.ajax-view_content').on('click', function (e) {
            e.preventDefault();
            $('.fam').remove();
            $('#ajax-no-content').css('display', 'none');
            $('#ajax-loading').css('display', 'block');
            let h_id = $(this).attr("value");
            context.ajax(h_id);
        });
    },

    ajax: function (h_id) {

        this.url = "/hunt/" + h_id

        $.post(this.url, {
            id: h_id
        })

        .done(function (response) {
            $('#ajax-loading').css('display', 'none');
            if (response.message == true) {
                r = response.result

                $('.filter-menu.category').after('<article class="fam"><div class="m-auto"></div></article>');

                $('article.fam > div').append('<img src="' + response.url + r['huntImage']['name'] + '" alt="' + r['name'] + '">')

                $('[data-toggle="tooltip"]').tooltip()
            }

            if (response.message == false ) {
                $('#ajax-no-content').css('display', 'block');
                $('#ajax-no-content').html('<div class="alert alert-danger" role="alert">Familier introuvable...</</div>');
            }
        })

        .fail(function () {
            $('#ajax-no-content').css('display', 'block');
            $('#ajax-no-content').html('<div class="alert alert-danger" role="alert">Tiens ! Tiens ! Tiens ! Hé bha il y a un problème ^^, contact l\'admin si le problème persiste...</div>');
        })
    }
}