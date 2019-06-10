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
            $.each(JSON.parse(data), function ( i, item) {
                $('#tricks').append(
                    `<div class="col-lg-3" id="${item.trick_id}">
                            <div class="card">
                                <img src="img/background_home.jpg" class="card-img-top" alt="test">
                                <div class="card-body d-flex justify-content-between bd-highlight mb-3">
                                    <div class="d-flex justify-content-start">
                                        <h5 class="card-title">
                                            <a href="${item.trick_url}"> ${item.trick_name}</a>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                    </div>`
                );
            });
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
        var button = $(event.relatedTarget), // Button that triggered the modal
            content = button.siblings('.read-more').html(),
            modal = $(this);

        modal.find('.modal-body').html(content);
    });


});