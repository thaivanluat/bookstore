$(function() {
    var total = 0;
    var finalTotal = parseInt($('#finalTotal').text().replace(/\,/g, ''));

    $('.invoice-item-total').each(function() {
        let totalItem = parseInt($(this).text().replace(/\,/g, ''));
        total = total + totalItem;
    });

    if(finalTotal == total) {
        let text = new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(total);
        text.replace('₫', '').replace(/\./g, ',');
        $('#total').text(text);
    }
    else {
        let text = new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(total);
        text.replace('₫', '').replace(/\./g, ',');

        let discount = 100 - (finalTotal/total)*100;
        $('.discount-area').show();
        $('#discount').text(discount);
        $('#total').text(text);
    }
});