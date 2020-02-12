$(document).ready(function () {

    let fByCat = Object.create(objFamiliarsByCat);
    fByCat.init();

});

let objFamiliarsByCat = {

    init: function () {
        let context = this;

        $('.view_familiarByCat').on('click', function (e) {
            e.preventDefault();
            let f_id = $(this).attr("value");
            context.ajax(f_id);
            console.log('click');
        });
    },

    ajax: function (f_id) {

        this.url = "/familiar/category/" + f_id

        $.post(this.url, {
            id: f_id
        })

        .done(function (response) {
            if (response.message == true) {
                r = response.result
                $('.fam').remove();
                $.each(r, function(i) {

                    if (i === 0) {
                        $('.filter-menu').after('<article id="'+ r[i]['id'] +'" class="fam"><div class="m-auto"></div></article>');
                    } else {
                        $('.fam').after('<article id="' + r[i]['id'] +'" class="fam"><div class="m-auto"></div></article>');
                    }

                    if (r[i]['imageBackground']['name'] !== null) {
                        $('article.fam#' + r[i]['id'] +' > div').append('<img src="'+ response.url + r[i]['imageBackground']['name'] + '" alt="' + r[i]['name'] + '">')
                    } else {
                        $('article.fam#' + r[i]['id'] +' > div').append('<img src="'+ response.defaultImage + '" alt="Aucune information">')
                    }

                    $('article.fam#' + r[i]['id'] +' > div').append('<div class="fam-name">'+ r[i]['name'] +'</div>');
                    $('article.fam#' + r[i]['id'] +' > div').append('<div class="fam-lvlPreview"><p>Level 60</p></div>');

                    if (r[i]['competence1']) {
                        $('article.fam#' + r[i]['id'] +' > div').append('<div class="fam-comp1"></div>')
                        $('.fam-comp1').append('<div class="comp1-img" tabindex="0" data-toggle="tooltip" data-placement="top" title="' + r[i]['competence1Desc'] + '"></div>');
                        $('.fam-comp1').append(r[i]['competence1']);
                    }

                    if (r[i]['competence2']) {
                        $('article.fam#' + r[i]['id'] +' > div').append('<div class="fam-comp2"></div>')
                        $('.fam-comp2').append('<div class="comp2-img" tabindex="0" data-toggle="tooltip" data-placement="top" title="' + r[i]['competence2Desc'] + '"></div>');
                        $('.fam-comp2').append(r[i]['competence2']);
                    }

                    if (r[i]['competence3']) {
                        $('article.fam#' + r[i]['id'] +' > div').append('<div class="fam-comp3"></div>')
                        $('.fam-comp3').append('<div class="comp3-img" tabindex="0" data-toggle="tooltip" data-placement="top" title="' + r[i]['competence3Desc'] + '"></div>');
                        $('.fam-comp3').append(r[i]['competence3']);
                    }

                    if (r[i]['talent']) {
                        $('article.fam#' + r[i]['id'] +' > div').append('<div class="fam-talent"></div>')
                        $('.fam-talent').append('<div class="talent-img" tabindex="0" data-toggle="tooltip" data-placement="top" title="' + r[i]['talentDesc'] + '"></div>');
                        $('.fam-talent').append(r[i]['talent']);
                    }
                });
                $('[data-toggle="tooltip"]').tooltip()

            }

            if (response.message == false ) {
                console.log("nop")
            }
        })

        .fail(function () {
            console.log("fail")
        })
    }
}