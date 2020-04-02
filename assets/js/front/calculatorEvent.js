$(document).ready(function () {

    let c = Object.create(objCalculEvent);
    c.event();

});

let objCalculEvent = {

    event: function () {
        $('.calculatorMenu .view_speedUp').on('click', function (e) {
            e.preventDefault();
            $('.speedUp').css('display', 'flex');
            $('.research').css('display', 'none');
            $('.merging').css('display', 'none');
            $('.training').css('display', 'none');
            $('.wall').css('display', 'none');
            $('.healing').css('display', 'none');
        });
        $('.calculatorMenu .view_research').on('click', function (e) {
            e.preventDefault();
            $('.speedUp').css('display', 'none');
            $('.research').css('display', 'flex');
            $('.merging').css('display', 'none');
            $('.training').css('display', 'none');
            $('.wall').css('display', 'none');
            $('.healing').css('display', 'none');
        });
        $('.calculatorMenu .view_merging').on('click', function (e) {
            e.preventDefault();
            $('.speedUp').css('display', 'none');
            $('.research').css('display', 'none');
            $('.merging').css('display', 'flex');
            $('.training').css('display', 'none');
            $('.wall').css('display', 'none');
            $('.healing').css('display', 'none');
        });
        $('.calculatorMenu .view_training').on('click', function (e) {
            e.preventDefault();
            $('.speedUp').css('display', 'none');
            $('.research').css('display', 'none');
            $('.merging').css('display', 'none');
            $('.training').css('display', 'flex');
            $('.wall').css('display', 'none');
            $('.healing').css('display', 'none');
        });
        $('.calculatorMenu .view_healing').on('click', function (e) {
            e.preventDefault();
            $('.speedUp').css('display', 'none');
            $('.research').css('display', 'none');
            $('.merging').css('display', 'none');
            $('.training').css('display', 'none');
            $('.wall').css('display', 'none');
            $('.healing').css('display', 'flex');
        });
        $('.calculatorMenu .view_wall').on('click', function (e) {
            e.preventDefault();
            $('.speedUp').css('display', 'none');
            $('.research').css('display', 'none');
            $('.merging').css('display', 'none');
            $('.training').css('display', 'none');
            $('.wall').css('display', 'flex');
            $('.healing').css('display', 'none');
        });
    },
}