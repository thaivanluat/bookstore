$(function() {
    var invoiceId;
    var loading = $('#loadingModal');
    var token = $('#token').val();

    $('.delete-button').on('click', function() {
        invoiceId = $(this).siblings('.invoice-id').val();
        let invoiceName = $(this).parent().siblings('.invoice-name').text();
        $('.heading-invoice-name').text(invoiceName);
    });

    $('.delete-btn').on('click', function() {
        loading.modal('show');

        $.ajax({
            type:'POST',
            url:'invoice/delete',
            data:{id:invoiceId, _token: token},
            success:function(data){
                loading.modal('hide');

                if(data.success) {
                    $.notify("Success", "success");
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
                else {
                    $.notify("Error", "error");
                }
            },
            error: function (data) {
                loading.modal('hide');
                $.notify("Error", "error");
            }
        });
    });
});