$(function() {
    var inventoryCheckId;
    var loading = $('#loadingModal');
    var token = $('#token').val();

    $('.delete-button').on('click', function() {
        inventoryCheckId = $(this).siblings('.inventory-check-id').val();
        let inventoryCheckName = $(this).parent().siblings('.inventory-check-name').text();
        $('.heading-inventory-check-name').text(inventoryCheckName);
    });

    $('.delete-btn').on('click', function() {
        loading.modal('show');

        $.ajax({
            type:'POST',
            url:'inventory/delete',
            data:{id:inventoryCheckId, _token: token},
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