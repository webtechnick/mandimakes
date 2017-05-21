$('.confirm').on('click', function () {
    let message = 'Are you sure?';
    let elem = $(this);
    if (elem.attr('confirm-message')) {
        message = elem.attr('confirm-message');
    }
    return confirm(message);
});