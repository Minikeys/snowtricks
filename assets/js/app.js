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

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');
$(document).ready(function(){

    $('#delete').click(function(){
        $('#18').remove();
    });

    $('#scroll-top').click(function(){
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });

    $('#modal-delete-trick').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        let action_url = button.data('actionurl')
        let token = button.data('token')
        $('#form_delete').attr('action', action_url);
        $('#token').attr('value', token);
    });


});