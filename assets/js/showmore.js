const $ = require('jquery');
require('bootstrap');

$(document).ready(function(){

    let offset = 5;
    let userRating = document.querySelector('#showmore');
    let pathloadmore = userRating.dataset.loadmore;
    let totalitem = userRating.dataset.totalitem;
    let load_img = '<button class="btn btn-primary" type="button" id="load" disabled>\n' +
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

            let render = JSON.parse(data);
            $('#tricks').append( render.html );

            offset = offset + 5;

            if (offset > totalitem){
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

});