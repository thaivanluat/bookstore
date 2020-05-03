$(function() {
    var bookEditionId;

    var loading = $('#loadingModal');
    var token = $('#token').val();

    $('.edit-button').on('click', function() {
        let publisherName = $(this).parent().siblings('.book-publisher').text();
        let publishingYear = $(this).parent().siblings('.book-publishing-year').text();
        let price = $(this).parent().siblings('.book-price').text();
        bookEditionId = $(this).siblings('.book-edition-id').val();

        $('#bookPublisher').val(publisherName);
        $('#bookPublishingYear').val(publishingYear);
        $('#bookPrice').val(price);
    });

    $('.save-change-btn').on('click', function() {
        let publisherName = $('#bookPublisher').val();
        let publishingYear = $('#bookPublishingYear').val();
        let price = $('#bookPrice').val();

        loading.modal('show');

        $.ajax({
           type:'POST',
           url:'bookedition/edit',
           data:{id:bookEditionId, publisher:publisherName, publishing_year:publishingYear, price:price, _token: token},
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
        bookEditionId = $(this).siblings('.book-edition-id').val();
        let publisher = $(this).parent().siblings('.book-publisher').text();
        let publishingYear = $(this).parent().siblings('.book-publishing-year').text();
        let price = $(this).parent().siblings('.book-price').text();
        let amount = $(this).parent().siblings('.book-amount').text();
        $('.heading-book-publisher').text(publisher);
        $('.heading-book-publishing-year').text(publishingYear);
        $('.heading-book-price').text(price+' VND');
        $('.heading-book-amount').text(amount);
    });

    $('.delete-btn').on('click', function() {
        loading.modal('show');

        $.ajax({
            type:'POST',
            url:'bookedition/delete',
            data:{id:bookEditionId, _token: token},
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
        let bookId = $('#bookId').val();
        let bookPublisher = $('#addBookPublisher').val();
        let bookPublishingYear = $('#addBookPublishingYear').val();
        let bookPrice = $('#addBookPrice').val();

        if(bookPublisher && bookPublishingYear && bookPrice) {
            loading.modal('show');
            $.ajax({
                type:'POST',
                url:'bookedition/add',
                data:{book_id:bookId, publisher:bookPublisher, publishing_year:bookPublishingYear, price: bookPrice, _token: token},
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