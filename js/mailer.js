$(function() {
    var form = $('#contact-form');
    var formMessages = $('#form-messages');

    form.submit(function(event){
        event.preventDefault();

        var formData = form.serialize();
        $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData
            })
            .done(function(response){
                formMessages.removeClass('error').addClass('success').text(response);
                form.hide();
            })
            .fail(function(data) {
                formMessages.removeClass('success').addClass('error');
                if (data.responseText !== '') {
                    formMessages.text(data.responseText);
                } else {
                    formMessages.text('Oops! An error occurred at and your message could not be sent.');
                }
            });
    })
});