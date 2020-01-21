import('../../css/back/global.css');
import('../../css/back/sb-admin-2.css');

tinymce.init({
    selector: 'textarea',  // change this value according to your HTML
    height: '650'
});

$(document).ready(function () { // css user Permissions
    let div = $('.user-perms > div div');
    div.addClass('form-group custom-control custom-switch');
    div.removeClass('form-check');

    let input = $('.user-perms > div div input');
    input.addClass('custom-control-input')

    let label = $('.user-perms > div div label');
    label.addClass('custom-control-label')
});