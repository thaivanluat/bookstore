$(function() {
    var customerId;
    var loading = $('#loadingModal');
    var token = $('#token').val();

    $('.edit-button').on('click', function() {
    	let name = $(this).parent().siblings('.customer-name').text();
        let phone = $(this).parent().siblings('.customer-phone').text(); 
        let address = $(this).parent().siblings('.customer-address').text(); 
        let email = $(this).parent().siblings('.customer-email').text(); 
    	customerId = $(this).siblings('.customer-id').val();
    	$('#customerName').val(name);
        $('#customerPhone').val(phone);
        $('#customerAddress').val(address);
        $('#customerEmail').val(email);
    });

    $('.save-change-btn').on('click', function() {
    	let name = $('#customerName').val();
        let phone = $('#customerPhone').val();
        let address = $('#customerAddress').val();
        let email = $('#customerEmail').val();
        
        loading.modal('show');

        $.ajax({
           type:'POST',
           url:'customer/edit',
           data:{id:customerId, name:name, phone:phone, address:address, email:email,_token: token},
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

    $('.delete-button').on('click', function() {
        customerId = $(this).siblings('.customer-id').val();
        let name = $(this).parent().siblings('.customer-name').text();
        $('.heading-customer-name').text(name);
    });

    $('.delete-btn').on('click', function() {
        loading.modal('show');

        $.ajax({
            type:'POST',
            url:'customer/delete',
            data:{id:customerId, _token: token},
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

    $('.add-btn').on('click', function() {
        let name = $('#addCustomerName').val();
        let phone = $('#addCustomerPhone').val();
        let address = $('#addCustomerAddress').val();
        let email = $('#addCustomerEmail').val();
        
        if(name && phone && address && email) {
            loading.modal('show');
            $.ajax({
                type:'POST',
                url:'customer/add',
                data:{name:name, phone:phone, address:address, email:email,_token: token},
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
        }
        else {
            $.notify("Please complete all information", "warn");
        }
    });
});