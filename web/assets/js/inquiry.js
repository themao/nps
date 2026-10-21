$(function () {
    $('#inquiry form').submit(function (event) {
        event.preventDefault();

        $.ajax('/inquiry/send', {
            method: 'POST',
            async: false,
            data: $(this).serialize(),
            success: function () {
                if (typeof tracker !== 'undefined') {
                    tracker.send({
                        hitType: 'event',
                        eventCategory: 'Inquiry',
                        eventAction: 'send',
                        eventLabel: currentProductTitle
                    });
                } else {
                    console.warn('No tracker defined!');
                }
                $('#inquiry').hide();
                $('#inquiry-result').show();
            },
            error: function() {
                $('#inquiry-error').show();
                setTimeout(function () {
                    $('#inquiry-error').slideUp();
                }, 2500);
            }
        });
    });

    $('#inquiry form input, #inquiry form textarea').focus(function () {
        if (typeof tracker !== 'undefined') {
            tracker.send({
                hitType: 'event',
                eventCategory: 'Inquiry',
                eventAction: 'focus',
                eventLabel: currentProductTitle
            });
        } else {
            console.warn('No tracker defined!');
        }
    });
});
