$(document).ready(function () {

    let c = Object.create(objConst);
    c.init();

});

let objConst = {

    init: function () {
        let context = this;

        $('.ajax-view_content').on('click', function (e) {
            e.preventDefault();
            let id = $(this).attr("value");
            context.ajax(id);
        });
    },

    ajax: function (id) {

        this.url = "/construction/" + id

        $.post(this.url, {
            id: id
        })

        .done(function (response) {
            if (response.message == true) {
                r = response.result

                $('#ajax-no-content').remove();
                $('article.const').remove();

                $('.filter-menu').after('<article class="const"><div class="name"></div><div class="content"></div></article>');

                $('article.const .name').append('<div><img src="'+ response.url +'/bandeau_rouge.png"></div>')
                $('article.const .name div').append('<div><span>'+ r['name'] +'</span></div>')

                if (r['image']) {
                    $('article.const .name').after('<div><img src="' + response.url + '/images/' + r['image']['name'] +'"></div>')
                } else {
                    $('article.const .name').after('<div><img src="' + response.url + '/uploads/default.png"></div>')
                }

                $('article.const .content').append('<div>'+ r['content'] +'</div>')

                $('[data-toggle="tooltip"]').tooltip()
            }

            if (response.message == false) {
                $('#ajax-no-content').remove();
                $('article.const').remove();
                $('.filter-menu').after('<div id="ajax-no-content">Construction introuvable...</div>');
            }
        })

        .fail(function () {
            $('#ajax-no-content').remove();
            $('article.const').remove();
            $('.filter-menu').after('<div id="ajax-no-content">Tiens ! Tiens ! Tiens ! Hé bha il y a un problème ^^, contact l\'admin si le problème persiste...</div>');
        })
    }
}