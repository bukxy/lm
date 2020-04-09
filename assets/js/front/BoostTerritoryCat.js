$(document).ready(function () {

    let fByCat = Object.create(objFamiliarsByCat);
    fByCat.init();

});

let objFamiliarsByCat = {

    init: function () {
        let context = this;

        $('.ajax-view_contentByCat').on('click', function (e) {
            e.preventDefault();
            $('article.const').remove();
            $('#ajax-no-content').css('display', 'none');
            $('#ajax-loading').css('display', 'block');
            let f_id = $(this).attr("value");
            context.ajax(f_id);
        });
    },

    ajax: function (f_id) {

        this.url = "/boost/category/" + f_id

        $.post(this.url, {
            id: f_id
        })

        .done(function (response) {
            $('#ajax-loading').css('display', 'none');
            if (response.message == true) {
                r = response.result

                $.each(r, function(i) {

                    $('.filter-menu.category').after('<article id="' + r[i]['id'] +'" class="const boost"><div class="name"></div><div class="content"></div></article>');

                    $('article.const#' + r[i]['id'] +' .name').append('<div><img src="' + response.url + '/bandeau_rouge.png"></div>')
                    $('article.const#' + r[i]['id'] + ' .name div').append('<div><span>' + r[i]['name'] + '</span></div>')

                    if (r[i]['image']) {
                        $('article.const#' + r[i]['id'] + ' .name').after('<div><img src="' + response.url + '/images/' + r[i]['image']['name'] + '"></div>')
                    } else {
                        $('article.const#' + r[i]['id'] +' .name').after('<div><img src="' + response.url + '/default.png"></div>')
                    }

                    $('article.const#' + r[i]['id'] + ' .content').append('<div>' + r[i]['content'] + '</div>')
                });

                $('[data-toggle="tooltip"]').tooltip()
            }

            if (response.message == false ) {
                $('#ajax-no-content').css('display', 'block');
                $('#ajax-no-content').html('<div class="alert alert-danger" role="alert">Catégorie introuvable...</div>');
            }
        })

        .fail(function () {
            $('#ajax-no-content').css('display', 'block');
            $('#ajax-no-content').html('<div class="alert alert-danger" role="alert">Tiens ! Tiens ! Tiens ! Hé bha il y a un problème ^^, contact l\'admin si le problème persiste...</div>');
        })
    }
}