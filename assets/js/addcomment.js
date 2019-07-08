const $ = require('jquery');
require('jquery-form');
require('bootstrap');


$("form[name='comment']").submit(function (e) {

    e.preventDefault();
    $form = $(e.target);

    var $submitButton = $form.find(':submit');
    $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');
    $submitButton.prop('disabled', true);

    $form.ajaxSubmit({
        type: 'post',
        success: function(data) {
            console.log(data);
            var json = $.parseJSON(data);
            if(json.message == 'success'){
                console.log('ok');
                $("#comment").prepend("<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">\n" +
                    "  Commentaire ajouté\n" +
                    "  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                    "    <span aria-hidden=\"true\">&times;</span>\n" +
                    "  </button>\n" +
                    "</div>");
                $(':input','#comment')
                    .not(':button, :submit, :reset, :hidden')
                    .val('');
                $submitButton.html('Ajouter un commentaire');
                $submitButton.prop('disabled', false);
            }else{
                $("#comment").prepend("<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">\n" +
                    "  Erreur, veuillez ressayé ultérieurement\n" +
                    "  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                    "    <span aria-hidden=\"true\">&times;</span>\n" +
                    "  </button>\n" +
                    "</div>");
                $submitButton.html('Enregistrer');
                $submitButton.prop('disabled', false);

            }

        },
        error: function(jqXHR, status, error) {
            console.log(error);
        }
    });
});