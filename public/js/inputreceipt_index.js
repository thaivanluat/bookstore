$(function() {
    var inputReceiptId;
    var loading = $('#loadingModal');
    var token = $('#token').val();

    $('.delete-button').on('click', function() {
        inputReceiptId = $(this).siblings('.input-receipt-id').val();
        let inputReceiptName = $(this).parent().siblings('.input-receipt-name').text();
        $('.heading-input-receipt-name').text(inputReceiptName);
    });

    $('.delete-btn').on('click', function() {
        loading.modal('show');

        $.ajax({
            type:'POST',
            url:'inputreceipt/delete',
            data:{id:inputReceiptId, _token: token},
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
    })
});