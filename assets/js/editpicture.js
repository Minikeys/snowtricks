const $ = require('jquery');
require('jquery-form');
require('bootstrap');



$('#modal-edit-media').on('shown.bs.modal', function (event) {
    var modal = $(this);
    var button = $(event.relatedTarget);
    var path = button.data('path');
    $.ajax(path , {
        success: function(data) {
            modal.find('.modal-content').html(data);
        }
    });
});

$('#modal-edit-media').on('hidden.bs.modal', function () {
    var modal = $(this);
    modal.find('.modal-content').html('');
});

$(document).on('submit', "form[name='edit_picture_trick']", function (e) {

    e.preventDefault();

    $form = $(e.target);
    var modal = $('#modal-edit-media');

    var $submitButton = $form.find(':submit');
    $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
    $submitButton.prop('disabled', true);

    $form.ajaxSubmit({
        type: 'post',
        success: function(data) {
            console.log(data);
            var json = $.parseJSON(data);
            if(json.message == 'success'){
                $("#trick").css("background-image", "url(" + json.newpicture + ")");
                $(modal).modal('hide');
                $("#btndeletepicture").show()
            }else{
                for(error in json.error){
                    $("#error").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                        json.error[error] +
                        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                        '    <span aria-hidden="true">×</span>'+
                        '  </button>'+
                        '</div>');
                }
                $submitButton.html('Enregistrer');
                $submitButton.prop('disabled', false);

            }

        },
        error: function(jqXHR, status, error) {
            console.log(error);
        }
    });
});

$(document).on('submit', "form[name='delete_main_picture']", function (e) {

    e.preventDefault();

    $form = $(e.target);
    var modal = $('#modal-edit-media');

    var $submitButton = $form.find(':submit');
    $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
    $submitButton.prop('disabled', true);

    $form.ajaxSubmit({
        type: 'post',
        success: function(data) {
            console.log(data);
            var json = $.parseJSON(data);
            if(json.message == 'success'){
                $("#trick").css("background-image", "url(/img/background_home.jpg)");
                $(modal).modal('hide');
                $("#btndeletepicture").hide()
            }else{
                for(error in json.error){
                    $("#error").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                        json.error[error] +
                        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                        '    <span aria-hidden="true">×</span>'+
                        '  </button>'+
                        '</div>');
                }
                $submitButton.html('Enregistrer');
                $submitButton.prop('disabled', false);

            }
        },
        error: function(jqXHR, status, error) {
            console.log(error);
        }
    });
});

$(document).on('submit', "form[name='delete_media']", function (e) {

    e.preventDefault();

    $form = $(e.target);
    var modal = $('#modal-edit-media');

    var $submitButton = $form.find(':submit');
    $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
    $submitButton.prop('disabled', true);

    $form.ajaxSubmit({
        type: 'post',
        success: function(data) {
            console.log(data);
            var json = $.parseJSON(data);
            if(json.message == 'success'){
                $(modal).modal('hide');
                $('#media-'+json.id).remove();
                $('.carousel').slick('refresh');
            }else{
                for(error in json.error){
                    $("#error").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                        json.error[error] +
                        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                        '    <span aria-hidden="true">×</span>'+
                        '  </button>'+
                        '</div>');
                }
                $submitButton.html('Enregistrer');
                $submitButton.prop('disabled', false);

            }
        },
        error: function(jqXHR, status, error) {
            console.log(error);
        }
    });
});

$(document).on('submit', "form[name='add_media_picture']", function (e) {

    e.preventDefault();

    $form = $(e.target);
    var modal = $('#modal-edit-media');

    var $submitButton = $form.find(':submit');
    $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
    $submitButton.prop('disabled', true);

    $form.ajaxSubmit({
        type: 'post',
        success: function(data) {
            console.log(data);
            var json = $.parseJSON(data);
            if(json.message == 'success'){
                console.log(data);
                $(modal).modal('hide');
                location.reload();

            }else{
                for(error in json.error){
                    $("#error").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                        json.error[error] +
                        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                        '    <span aria-hidden="true">×</span>'+
                        '  </button>'+
                        '</div>');
                }
                $submitButton.html('Enregistrer');
                $submitButton.prop('disabled', false);

            }
        },
        error: function(jqXHR, status, error) {
            console.log(error);
        }
    });
});

$(document).on('submit', "form[name='add_media_movie']", function (e) {

    e.preventDefault();

    $form = $(e.target);
    var modal = $('#modal-edit-media');

    var $submitButton = $form.find(':submit');
    $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
    $submitButton.prop('disabled', true);

    $form.ajaxSubmit({
        type: 'post',
        success: function(data) {
            console.log(data);
            var json = $.parseJSON(data);
            if(json.message == 'success'){
                console.log(data);
                $(modal).modal('hide');
                location.reload();
            }else{
                for(error in json.error){
                    $("#error").append('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                        json.error[error] +
                        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                        '    <span aria-hidden="true">×</span>'+
                        '  </button>'+
                        '</div>');
                }
                $submitButton.html('Enregistrer');
                $submitButton.prop('disabled', false);

            }
        },
        error: function(jqXHR, status, error) {
            console.log(error);
        }
    });
});