const $ = require('jquery');
require('bootstrap');

$(document).ready(function(){

    var offset = 5;
    let userRating = document.querySelector('#showmore');
    let pathloadmore = userRating.dataset.loadmore;
    let totalitem = userRating.dataset.totalitem;
    let id = userRating.dataset.id;
    let load_img = '<button class="btn btn-primary" type="button" id="load" disabled>\n' +
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>\n' +
        'Chargement...\n' +
        '</button>';

    $('#load-more').click(function(){
        $.ajax({
            url: pathloadmore,
            type: "POST",
            data : {offset : offset, id : id},
            dataType: "json",
            beforeSend: function(){
                $("#load-more").hide();
                $("#end").append(load_img);
            }
        }).done(function(data){

            let render = JSON.parse(data);
            $('#content').append( render.html );

            offset = offset + 5;

            if (offset >= totalitem){
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

    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (offset >= 15 && (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30)) {
            document.getElementById("scroll-top").style.display = "block";
        } else {
            document.getElementById("scroll-top").style.display = "none";
        }
    }

});