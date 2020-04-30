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
                url:'inputreceipt/getBookEditionOptionlist',
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

        console.log(isDuplicate);
        console.log(typeof bookEditionId);
        console.log(currentList);

        if(bookId && bookEditionId && isDuplicate) {
            let bookObj = $("#addBook").select2("data")[0]
            let bookEditionObj = $("#addBookEdition").select2("data")[0];
            item.find('.item-id').val(bookEditionObj.id);
            item.find('.choose-btn').remove();
            item.find('.book-name').html(bookObj.text);
            item.find('.book-publisher').html(bookEditionObj.publisher);
            item.find('.book-publishing-year').html(bookEditionObj.publishing_year);
            item.find('.book-quantity').val(0);
            item.find('.book-price').html(bookEditionObj.price);

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
        let total = $(this).parent().siblings('.book-total');

        if(quantity > 0) {
            let price = parseInt($(this).parent().siblings('.book-price').text());
            total.text(price*quantity);
        }
    });


    $(document).on("blur", ".book-quantity", function() {
        let totalCalc = 0;
        $(".book-total").each(function(index) {
            totalCalc += parseInt($(this).text());
        });

        total.text(totalCalc);
    });

    $('.create-button').on('click', function() {
        let valid = true;
        listArray = [];

        $(".book-total").each(function(index) {
            if(parseInt($(this).text()) == 0) {
                valid = false;
                return false;
            }
        });

        if(valid) {
            $(".blank-item").each(function(index) {
                let itemId = $(this).find('.item-id').val();
                let quantity = $(this).find('.book-quantity').val();
                
                listArray.push({id: itemId, quantity: quantity});
            });

            loading.modal('show');

            $.ajax({
                type:'POST',
                url:'inputreceipt/add',
                data: {data: listArray, _token: token},
                success:function(data){
                    loading.modal('hide');

                    if(data.success) {
                        $.notify("Success", "success");
                        setTimeout(function() {
                            document.location.href="/bookstore/inputreceipt/detail/"+data.id;
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
