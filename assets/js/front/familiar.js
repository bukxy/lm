$(document).ready(function () {

    let familiars = Object.create(objFamiliars);
    familiars.init();

});

let objFamiliars = {

    init: function () {
        let context = this;

        $('.ajax-view_content').on('click', function (e) {
            e.preventDefault();
            let f_id = $(this).attr("value");
            context.ajax(f_id);
        });
    },

    ajax: function (f_id) {

        this.url = "/familiar/" + f_id

        $.post(this.url, {
            id: f_id
        })

        .done(function (response) {
            if (response.message == true) {
                r = response.result

                $('#ajax-no-content').remove();
                $('.fam').remove();

                $('.filter-menu.category').after('<article class="fam"><div class="m-auto"></div></article>');

                if (r['imageBackground']) {
                    $('article.fam > div').append('<img src="' + response.url + r['imageBackground']['name'] + '" alt="' + r['name'] + '">')
                } else {
                    $('article.fam > div').append('<img src="' + response.defaultImage + '" alt="Aucune information">')
                }

                $('article.fam > div').append('<div class="fam-name">' + r['name'] + '</div>');
                $('article.fam > div').append('<div class="fam-lvlPreview"><p>Level 60</p></div>');

                if (r['competence1']) {
                    $('article.fam > div').append('<div class="fam-comp1"></div>')
                    $('.fam-comp1').append('<div class="comp1-img" tabindex="0" data-toggle="tooltip" data-placement="top" title="' + r['competence1Desc'] + '"></div>');
                    $('.fam-comp1').append(r['competence1']);
                }

                if (r['competence2']) {
                    $('article.fam > div').append('<div class="fam-comp2"></div>')
                    $('.fam-comp2').append('<div class="comp2-img" tabindex="0" data-toggle="tooltip" data-placement="top" title="' + r['competence2Desc'] + '"></div>');
                    $('.fam-comp2').append(r['competence2']);
                }

                if (r['competence3']) {
                    $('article.fam > div').append('<div class="fam-comp3"></div>')
                    $('.fam-comp3').append('<div class="comp3-img" tabindex="0" data-toggle="tooltip" data-placement="top" title="' + r['competence3Desc'] + '"></div>');
                    $('.fam-comp3').append(r['competence3']);
                }

                if (r['talent']) {
                    $('article.fam > div').append('<div class="fam-talent"></div>')
                    $('.fam-talent').append('<div class="talent-img" tabindex="0" data-toggle="tooltip" data-placement="top" title="' + r['talentDesc'] + '"></div>');
                    $('.fam-talent').append(r['talent']);
                }

                $('[data-toggle="tooltip"]').tooltip()
            }

            if (response.message == false ) {
                $('#ajax-no-content').remove();
                $('.fam').remove();

                $('.filter-menu.category').after('<div id="ajax-no-content">Familier introuvable...</div>');
            }
        })

        .fail(function () {
            $('#ajax-no-content').remove();
            $('.fam').remove();
            $('.filter-menu.category').after('<div id="ajax-no-content">Tiens ! Tiens ! Tiens ! Hé bha il y a un problème ^^, contact l\'admin si le problème persiste...</div>');
        })
    }
}