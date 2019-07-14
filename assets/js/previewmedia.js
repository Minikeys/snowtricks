const $ = require('jquery');
require('jquery-form');
require('bootstrap');

$('#modal-preview-media').on('shown.bs.modal', function (event) {
    var modal = $(this);
    var button = $(event.relatedTarget);
    var type = button.data('type');
    var link = button.data('link');
    var file = button.data('file');
    var id = button.data('id');

    if(type == 'picture'){
        modal.find('.modal-title').html('Preview Media ' + id);
        modal.find('.modal-body').html('<img src="/uploads/media/'+ file +'"'+
            '     alt=""'+
            '     width="100%">');
    }else if(type == 'youtube'){
        modal.find('.modal-title').html('Preview Media ' + id);
        modal.find('.modal-body').html('<iframe width="100%" src="https://www.youtube.com/embed/'+ link +'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
    }else if(type == 'dailymotion'){
        modal.find('.modal-title').html('Preview Media ' + id);
        modal.find('.modal-body').html('<iframe frameborder="0" width="100%" src="//www.dailymotion.com/embed/video/'+ link +'?autoplay=0&mute=0" allowfullscreen allow="autoplay"></iframe>');
    }

});

$('#modal-preview-media').on('hidden.bs.modal', function () {
    var modal = $(this);
    modal.find('.modal-title').html('');
    modal.find('.modal-body').html('');
});