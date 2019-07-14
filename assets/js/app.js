/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
const $ = require('jquery');
require('bootstrap');
require('slick-carousel');

$(document).on('change', '.custom-file-input', function(event) {
    var inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);
});

$(document).on("click", "#showmedia", function() {
    $("#media").show();
    $("#showmedia").hide();
    $('.responsive').slick('refresh');
});


$(document).ready(function(){

    $('#scroll-top').click(function(){
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });

    $('#modal-delete-trick').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let action_url = button.data('actionurl');
        let token = button.data('token');
        $('#form_delete').attr('action', action_url);
        $('#token').attr('value', token);
    });

});