$(function () {
    $('#inquiry form').submit(function (event) {
        event.preventDefault();
        $.ajax('/inquiry/send', {
            method: 'POST',
            async: false,
            data: $(this).serialize(),
            success: function () {
                $('#inquiry').hide();
                $('#inquiry-result').show();
            }
        });
    });
});
