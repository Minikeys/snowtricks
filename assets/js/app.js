/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
const $ = require('jquery');
require('bootstrap');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(document).ready(function(){
    var offset = 5;
    var userRating = document.querySelector('#tricks');
    var pathloadmore = userRating.dataset.loadmore;
    var total_tricks = userRating.dataset.totaltricks;
    var userRating = document.querySelector('.js-user-rating');
    var isAuthenticated = userRating.dataset.isAuthenticated;
    var load_img = '<button class="btn btn-primary" type="button" id="load" disabled>\n' +
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>\n' +
        'Chargement...\n' +
        '</button>';

    $('#load-more').click(function(){
        $.ajax({
            url: pathloadmore,
            type: "POST",
            data : {offset : offset},
            dataType: "json",
            beforeSend: function(){
                $("#load-more").hide();
                $("#end").append(load_img);
            }
        }).done(function(data){

            let dddd = JSON.parse(data);
            $('#tricks').append( dddd.html );

            offset = offset + 5;

            if (offset > total_tricks){
                $('#end').remove();
            }else {
                $('#load').remove();
                $("#load-more").show();
            }
        }).fail(function(err) {
            $('#load-more').before(err);
        }).always(function() {
            //do  something whether request is ok or fail
        });

    });

    $('#delete').click(function(){
        $('#18').remove();
    });

    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (offset >= 15 && (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30)) {
            document.getElementById("scroll-top").style.display = "block";
        } else {
            document.getElementById("scroll-top").style.display = "none";
        }
    }

    $('#scroll-top').click(function(){
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });

    $("#delete-trick").click(function(id){
        document.getElementById("delete").classList.add(id);
        $("#modal-delete-trick").modal();

    });

    $('#modal-delete-trick').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        let action_url = button.data('actionurl')
        let token = button.data('token')
        $('#form_delete').attr('action', action_url);
        $('#token').attr('value', token);
    })


});