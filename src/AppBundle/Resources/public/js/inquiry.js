$(function () {
    $('#inquiry form').submit(function (event) {
        event.preventDefault();

        $.ajax('/inquiry/send', {
            method: 'POST',
            async: false,
            data: $(this).serialize(),
            success: function () {
                if (typeof ga !== 'undefined') {
                    ga('send', {
                        hitType: 'event',
                        eventCategory: 'Inquiry',
                        eventAction: 'send',
                        eventLabel: currentProductTitle
                    });
                } else {
                    console.warn('No ga defined!');
                }
                $('#inquiry').hide();
                $('#inquiry-result').show();
            }
        });
    });

    $('#inquiry form input, #inquiry form textarea').focus(function () {
        if (typeof ga !== 'undefined') {
            ga('send', {
                hitType: 'event',
                eventCategory: 'Inquiry',
                eventAction: 'focus',
                eventLabel: currentProductTitle
            });
        } else {
            console.warn('No ga defined!');
        }
    });
});
