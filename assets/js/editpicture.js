const $ = require('jquery');
require('jquery-form');
require('bootstrap');

$('#modal-edit-media').on('shown.bs.modal', function (event) {
    var modal = $(this);
    var button = $(event.relatedTarget);
    var title = button.data('title');
    var pathupdate = button.data('pathupdate');
    modal.find('.modal-title').text(title);
    $.ajax(pathupdate , {
        success: function(data) {
            modal.find('.modal-body').html(data);
        }
    });
});

$(document).on('submit', "form[name='edit_picture_trick']", function (e) {

    console.log('test');

    e.preventDefault();

    $form = $(e.target);
    modal = $('#modal-edit-media');

    var title = 'test';

    var $submitButton = $form.find(':submit');
    $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
    $submitButton.prop('disabled', true);

    // ajaxSubmit du plugin ajaxForm nécessaire pour l'upload de fichier
    $form.ajaxSubmit({
        type: 'post',
        success: function(data) {
            if (data == 'ok') {
                $('ul').append('<li>' + title + '</li>');
                modal.modal('toggle');
            } else {
                modal.find('.modal-body').html(data);
            }
        },
        error: function(jqXHR, status, error) {
            $submitButton.html(button.data('label'));
            $submitButton.prop('disabled', false);
        }
    });
});