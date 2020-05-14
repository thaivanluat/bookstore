$(function() {
    var receiptId;
    var loading = $('#loadingModal');
    var token = $('#token').val();

    // Render customer options template
    function renderCustomerOption(state) {
        let optionHTML = $('<div><small>Customer ID:  </small> <span class="badge badge-primary">'+state.id+'</span></div>'+
                            '<div><small>Customer Name:  </small> <span class="badge badge-info">'+state.name+'</span></div>'+
                            '<div><small>Phone:  </small> <span class="badge badge-info">'+state.phone+'</span></div>'+
                            '<div><small>Email:  </small> <span class="badge badge-info">'+state.email+' </span></div>'+
                            '<div><small>Address:  </small> <span class="badge badge-info">'+state.address+' </span></div>'+
                            '<div><small>Debt:  </small> <span class="badge badge-danger">'+state.debt+' VND</span></div>');
        if(state.name) {
            return optionHTML;
        }
        return state.text;
    }

    // Render customer options selected in select box
    function renderCustomerSelection(state) {
        return state.name;
    }

    $("#customerSearch").select2({
        minimumInputLength: 1,
        placeholder: { name:'Please select customer'},
        theme: "bootstrap",
        ajax: {
            type: 'POST',
            url: 'invoice/searchCustomer',
            dataType: 'json',
            delay: 500,
            data: function (params) {
                return {
                    q: $.trim(params.term),
                    _token: token
                };
            },
            processResults: function (data) {
                var myResults = [];
                $.each(data, function (index, data) {
                    myResults.push({
                        id : data.makhachhang,
                        name : data.hoten, 
                        phone : data.dienthoai,
                        email: data.email,
                        address: data.diachi,
                        debt: data.tongno
                    });
                });   
                return {results: myResults};
            },
            cache: true
        },
        templateResult: renderCustomerOption,
        templateSelection: renderCustomerSelection,
    });

    $("#customerSearch").on('change', function() {
        let customerObj = $(this).select2("data")[0];
        $('.customer-debt').val(customerObj.debt); 
    });

    $('.delete-button').on('click', function() {
        receiptId = $(this).siblings('.receipt-id').val();
        let receiptName = $(this).parent().siblings('.receipt-name').text();
        $('.heading-receipt-name').text(receiptName);
    });

    $('.delete-btn').on('click', function() {
        loading.modal('show');

        $.ajax({
            type:'POST',
            url:'receipt/delete',
            data:{id:receiptId, _token: token},
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
        let value = parseInt($('#addReceiptValue').val());
        let customerId = $('#customerSearch').select2('val');
        let debt = parseInt($('.customer-debt').val());
        let valid = true;

        if(value > debt) {
            alert('Receipt value can not greater than debt');
            $('#addReceiptValue').val('').focus();
            valid = false;
        }
        
        if(valid && value && customerId) {
            loading.modal('show');
            $.ajax({
                type:'POST',
                url:'receipt/add',
                data:{customer_id: customerId, value:value, _token: token},
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