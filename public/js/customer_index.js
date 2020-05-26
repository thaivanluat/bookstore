$(function() {
    var customerId;
    var loading = $('#loadingModal');
    var token = $('#token').val();

    function toDate(dateStr) {
        var parts = dateStr.split("-")
        return new Date(parts[2], parts[1] - 1, parts[0])
      }

    $('.edit-button').on('click', function() {
    	let name = $(this).parent().siblings('.customer-name').text();
        let phone = $(this).parent().siblings('.customer-phone').text(); 
        let address = $(this).parent().siblings('.customer-address').text(); 
        let email = $(this).parent().siblings('.customer-email').text(); 
        let birthday = $(this).parent().siblings('.customer-birthday').text(); 
        let date = toDate(birthday);

        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);

        var datetext = date.getFullYear()+"-"+(month)+"-"+(day);

    	customerId = $(this).siblings('.customer-id').val();
    	$('#customerName').val(name);
        $('#customerPhone').val(phone);
        $('#customerAddress').val(address);
        $('#customerEmail').val(email);
        $('#customerBirthday').val(datetext);
    });

    $('.save-change-btn').on('click', function() {
    	let name = $('#customerName').val();
        let phone = $('#customerPhone').val();
        let address = $('#customerAddress').val();
        let email = $('#customerEmail').val();
        let birthday = $('#customerBirthday').val();

        loading.modal('show');

        $.ajax({
           type:'POST',
           url:'customer/edit',
           data:{id:customerId, name:name, phone:phone, address:address,birthday: birthday, email:email,_token: token},
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
    });

    $('.add-btn').on('click', function() {
        let name = $('#addCustomerName').val();
        let phone = $('#addCustomerPhone').val();
        let address = $('#addCustomerAddress').val();
        let email = $('#addCustomerEmail').val();
        let birthday =  $('#addCustomerBirthday').val();
        
        if(name && phone && address && email && birthday) {
            loading.modal('show');
            $.ajax({
                type:'POST',
                url:'customer/add',
                data:{name:name, phone:phone, address:address,birthday: birthday,email:email,_token: token},
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