$(document).ready(function () {

    let fByCat = Object.create(objFamiliarsByCat);
    fByCat.init();

});

let objFamiliarsByCat = {

    init: function () {
        let context = this;

        $('.ajax-view_contentByCat').on('click', function (e) {
            e.preventDefault();
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
            if (response.message == true) {
                r = response.result

                $('#ajax-no-content').remove();
                $('article.const').remove();

                $.each(r, function(i) {

                    $('.filter-menu.category').after('<article class="const"><div class="name"></div><div class="content"></div></article>');

                    $('article.const .name').append('<div><img src="' + response.url + '/bandeau_rouge.png"></div>')
                    $('article.const .name div').append('<div><span>' + r['name'] + '</span></div>')

                    if (r['image']) {
                        $('article.const .content').append('<div><img src="' + response.url + '/images/' + r['image']['name'] + '"></div>')
                    } else {
                        $('article.const .content').append('<div><img src="' + response.url + '/default.png"></div>')
                    }

                    $('article.const .content').append('<div>' + r['content'] + '</div>')
                });

                $('[data-toggle="tooltip"]').tooltip()
            }

            if (response.message == false ) {
                $('#ajax-no-content').remove();
                $('article.const').remove();
                $('.filter-menu.category').after('<div id="ajax-no-content">Catégorie introuvable...</div>');
            }
        })

        .fail(function () {
            $('#ajax-no-content').remove();
            $('article.const').remove();
            $('.filter-menu.category').after('<div id="ajax-no-content">Tiens ! Tiens ! Tiens ! Hé bha il y a un problème ^^, contact l\'admin si le problème persiste...</div>');
        })
    }
}