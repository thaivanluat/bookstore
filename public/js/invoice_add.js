$(function() {
    var token = $('#token').val();
    var loading = $('#loadingModal');
    var total = $('#total');
    var emptyItem = $('.blank-item')[0].outerHTML;
    var item = $('tr.blank-item');

    var bookId;
    var bookEditionId;

    // Render options template in select box
    function renderOption(state) {
        let optionHTML = $('<div><small>Book Edition ID:  </small> <span class="badge badge-primary">'+state.id+'</span></div>'+
                            '<div><small>Publisher:  </small> <span class="badge badge-info">'+state.publisher+'</span></div>'+
                            '<div><small>Publising Year:  </small> <span class="badge badge-info">'+state.publishing_year+'</span></div>'+
                            '<div><small>Price:  </small> <span class="badge badge-success">'+state.price+' VND</span></div>'+
                            '<div><small>Quantity:  </small> <span class="badge badge-success">'+state.quantity+'</span></div>');
        return optionHTML;
    }

    // Render options selected in select box
    function renderSelection(state) {
        return state.id;
    }

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

    function resetSelectBox() {
        $('#addBook').val([]).trigger('change');

        $('#addBookEdition').select2('destroy');

        $('#addBookEdition').val([]).select2({
            placeholder: "Select Book edition",
            theme: "bootstrap"
        });
    }

    $('.add-button').on('click', function() {
        let item = emptyItem;
        $('#listItem tbody').append(item);
    });

    $(document).on("click", "a.remove-item-btn" , function() {
        $(this).closest('tr').remove();
    });

    $('#addBook').val([]).select2({
        placeholder: "Select a Book",
        theme: "bootstrap"
    });

    $('#addBookEdition').val([]).select2({
        placeholder: "Select Book edition",
        theme: "bootstrap"
    });

    $('#addBook').change(function() {
        let selectedOption = $(this).val();
        let optionList = [];
        if(selectedOption) {
            loading.modal('show');

            $.ajax({
                type:'POST',
                url:'invoice/getBookEditionOptionlist',
                data:{id:selectedOption, _token: token},
                success:function(data){
                    loading.modal('hide');
                    if(data && data.length) {
                        $.each(data, function(index,data) {

                            optionList.push({
                                id: parseInt(data.masach),
                                text: '',
                                publisher: data.nhaxuatban,
                                publishing_year: data.namxuatban,
                                price: data.dongiaban,
                                quantity: data.soluongton
                            });
                        });
                    }    

                    $("#addBookEdition").select2('destroy');
                    $("#addBookEdition").empty();
                
                    $('#addBookEdition').select2({
                        data: optionList,
                        placeholder: "Select Book edition",
                        theme: "bootstrap",
                        templateSelection: renderSelection,
                        templateResult: renderOption
                    });
                },
                error: function (data) {
                    loading.modal('hide');
                    $.notify("Error", "error");
                }
            }); 
        }
    }); 

    $(document).on("click", ".choose-btn" , function() {
        item = $(this).closest('tr');
    });

    $('.add-btn').on('click', function() {
        bookId =  $('#addBook').select2('val');
        bookEditionId = $('#addBookEdition').select2('val');
        let isDuplicate = true;

        let currentList = [];
        $(".blank-item").each(function(index) {
            let itemId = $(this).find('.item-id').val();
            currentList.push(itemId);
        });

        if($.inArray(bookEditionId, currentList) >= 0) {
            isDuplicate = false;
        }

        if(bookId && bookEditionId && isDuplicate) {
            let bookObj = $("#addBook").select2("data")[0]
            let bookEditionObj = $("#addBookEdition").select2("data")[0];
            item.find('.item-id').val(bookEditionObj.id);
            item.find('.choose-btn').remove();
            item.find('.book-name').html(bookObj.text);
            item.find('.book-publisher').html(bookEditionObj.publisher);
            item.find('.book-publishing-year').html(bookEditionObj.publishing_year);
            item.find('.book-quantity').val(0);
            let bookPriceText = new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(bookEditionObj.price);
            item.find('.book-price').html(bookPriceText);
            item.find('.book-price-value').val(bookEditionObj.price);

            resetSelectBox();
            $('#chooseModal').modal('hide');
        }
        else if(!isDuplicate) {
            $.notify("Book already exists in list", "warn");
        }
        else {
            $.notify("Please choose all information", "warn");
        }
    });
    

    $(document).on("blur", ".book-quantity" , function() {
        let quantity = $(this).val();
        let totalItem = $(this).parent().siblings('.book-total');

        if(quantity >= 0) {
            let price = $(this).parent().siblings('.book-price-value').val();
            totalItem.siblings('.book-total-value').val(price*quantity);
            totalItemPriceText = new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(price*quantity);
            totalItem.text(totalItemPriceText);
        }
    });


    $(document).on("blur", ".book-quantity", function() {
        let totalCalc = 0;
        $(".book-total-value").each(function(index) {
            totalCalc += parseInt($(this).val());
        });

        let text = new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(totalCalc);
        total.text(text);
    });

    $('.create-button').on('click', function() {
        let valid = true;
        let customerId = $('#customerSearch').select2('val');
        let amountReceived = $('.amount-received').val();
        listArray = [];

        $(".book-quantity").each(function(index) {
            if($(this).val() == 0) {
                valid = false;
                return false;
            }
        });

        let totalValue = parseInt($('#total').text().replace('₫', '').replace('.', ''));

        if(amountReceived > totalValue) {
            alert('Amount received is greater than total !');
            $('.amount-received').val('').focus();
            valid = false;
        }

        if(valid && customerId && amountReceived > 0) {
            $(".blank-item").each(function(index) {
                let itemId = $(this).find('.item-id').val();
                let quantity = $(this).find('.book-quantity').val();
                
                listArray.push({id: itemId, quantity: quantity});
            });

            loading.modal('show');

            $.ajax({
                type:'POST',
                url:'invoice/add',
                data: {data: listArray,customer_id: customerId, amount: amountReceived ,_token: token},
                success:function(data){
                    loading.modal('hide');

                    if(data.success) {
                        $.notify("Success", "success");
                        setTimeout(function() {
                            document.location.href="/bookstore/invoice/detail/"+data.id;
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

        $('#customerInfo').show();
        
        $('.customer-id').html(customerObj.id);
        $('.customer-name').html(customerObj.name);
        $('.customer-phone').html(customerObj.phone);
        $('.customer-email').html(customerObj.email);
        $('.customer-address').html(customerObj.address);
        $('.customer-debt').html(customerObj.debt);  
    });
});
