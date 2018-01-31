$(function () {
    if (typeof ga !== 'undefined') {
        var allGa = ga.getAll();
        if (allGa.length) {
            var tracker = allGa[0];
        }
    }

    var timer = null;
    var type = null;
    var counter = {};

    $('.contact-watch').hover(null, function () {
        if (timer && type === $(this).data('type')) {
            clearTimeout(timer);
        }

        type = $(this).data('type');
        if (typeof counter[type] === 'undefined') {
            counter[type] = 0;
        }
        counter[type]++;

        timer = setTimeout(function() {
            if (typeof tracker !== 'undefined') {
                tracker.send({
                    hitType: 'event',
                    eventCategory: 'Contact',
                    eventAction: 'hover',
                    eventLabel: $(this).data('type'),
                    eventValue: counter[type]
                });
            } else {
                console.warn('No ga defined!');
            }
        }, 1500)
    });

    $('a[href="mailto:nppnps@gmail.com"]').click(function() {
        if (typeof tracker !== 'undefined') {
            tracker.send({
                hitType: 'event',
                eventCategory: 'Contact',
                eventAction: 'click',
                eventLabel: 'email link'
            });
        } else {
            console.warn('No ga defined!');
        }
    });

    $('a[data-lightbox="gallery"]').click(function() {
        if (typeof tracker !== 'undefined') {
            tracker.send({
                hitType: 'event',
                eventCategory: 'Gallery',
                eventAction: 'click',
                eventLabel: currentProductTitle
            });
        } else {
            console.warn('No ga defined!');
        }
    });
});
