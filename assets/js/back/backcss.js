import('../../css/back/global.css');
import('../../css/back/sb-admin-2.css');
import('../../css/back/dataTables.bootstrap4.css');
import('../../css/back/familiar.css');


tinymce.init({
    selector: 'textarea',  // change this value according to your HTML
    height: '650',
    content_css: ['https://www.dafont.com/sansation.font'],
    font_formats: 'Sensation=sensation',
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table paste imagetools wordcount image imagetools"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tiny.cloud/css/codepen.min.css'
    ]
});

$(document).ready(function () { 
    $('#dataTable').DataTable({ // tableau user list
        "language": {
            "lengthMenu": "Affiché _MENU_ résultats par page",
            "zeroRecords": "Aucun résultat",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Aucun utilisateurs",
            "loadingRecords": "Chargement...",
            "processing": "En traitement...",
            "search": "Rechercher:",
            "paginate": {
                "first": "Première",
                "last": "Dernière",
                "next": "Suivant",
                "previous": "Retour"
            }
        }
    });

    let div = $('.user-perms > div div');// css user Permissions
    div.addClass('form-group custom-control custom-switch');
    div.removeClass('form-check');

    let input = $('.user-perms > div div input');
    input.addClass('custom-control-input')

    let label = $('.user-perms > div div label');
    label.addClass('custom-control-label')
});