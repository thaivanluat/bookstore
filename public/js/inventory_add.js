$(function() {
    var token = $('#token').val();
    var loading = $('#loadingModal');
    var emptyItem = $('.blank-item')[0].outerHTML;
    var item = $('tr.blank-item');

    var bookId;
    var bookEditionId;

    // Render options template in select box
    function renderOption(state) {
        let optionHTML = $('<div><small>Mã sách:  </small> <span class="badge badge-primary">'+state.id+'</span></div>'+
                            '<div><small>Nhà xuất bản:  </small> <span class="badge badge-info">'+state.publisher+'</span></div>'+
                            '<div><small>Năm xuât bản:  </small> <span class="badge badge-info">'+state.publishing_year+'</span></div>'+
                            '<div><small>Giá:  </small> <span class="badge badge-success">'+state.price+' VND</span></div>'+
                            '<div><small>Số lượng tồn:  </small> <span class="badge badge-success">'+state.quantity+'</span></div>');
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
            placeholder: "Chọn sách",
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
        placeholder: "Chọn đầu sách",
        theme: "bootstrap"
    });

    $('#addBookEdition').val([]).select2({
        placeholder: "Chọn sách",
        theme: "bootstrap"
    });

    $('#addBook').change(function() {
        let selectedOption = $(this).val();
        let optionList = [];
        if(selectedOption) {
            loading.modal('show');

            $.ajax({
                type:'POST',
                url:'inventory/getBookEditionOptionlist',
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
                                quantity: data.soluongton,
                                author: data.tentacgia,
                                category: data.tentheloai
                            });
                        });
                    }    

                    $("#addBookEdition").select2('destroy');
                    $("#addBookEdition").empty();
                
                    $('#addBookEdition').select2({
                        data: optionList,
                        placeholder: "Chọn sách",
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
            item.find('.book-category').html(bookEditionObj.category);
            item.find('.book-author').html(bookEditionObj.author);
            item.find('.book-publisher').html(bookEditionObj.publisher);
            item.find('.book-publishing-year').html(bookEditionObj.publishing_year);
            item.find('.book-stock').html(bookEditionObj.quantity);
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
    

    $('.create-button').on('click', function() {
        let valid = true;
        listArray = [];

        $(".book-quantity").each(function(index) {
            if($(this).val() == 0) {
                valid = false;
                return false;
            }
        });

        if(valid) {
            $(".blank-item").each(function(index) {
                let itemId = $(this).find('.item-id').val();
                let quantity = $(this).find('.book-check-stock').val();
                
                listArray.push({id: itemId, quantity: quantity});
            });

            loading.modal('show');

            $.ajax({
                type:'POST',
                url:'inventory/add',
                data: {data: listArray, _token: token},
                success:function(data){
                    loading.modal('hide');

                    if(data.success) {
                        $.notify("Success", "success");
                        setTimeout(function() {
                            document.location.href="/bookstore/inventory/detail/"+data.id;
                        }, 1000);
                    }
                    else {
                        if(data.message) {
                            $.notify(data.message, "error");      
                        }
                        else {
                            $.notify("Error", "error");
                        }       
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
