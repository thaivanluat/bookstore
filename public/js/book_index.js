$(function() {
    $('#addAuthor').select2({
        theme: "bootstrap"
    });
    $('#addCategory').select2({
        theme: "bootstrap"
    });

    var bookId;
    var categoryId;
    var authorId;

    var loading = $('#loadingModal');
    var token = $('#token').val();

    $('.edit-button').on('click', function() {
    	let name = $(this).parent().siblings('.book-name').text();
        bookId = $(this).siblings('.book-id').val();
        categoryId = $(this).siblings('.category-id').val();
        authorId = $(this).siblings('.author-id').val();

    	$('#bookName').val(name);
        $('#bookCategory').val(categoryId);
        $('#bookAuthor').val(authorId);
    });

    $('.save-change-btn').on('click', function() {
    	let name = $('#bookName').val();
        let bookCategory = $('#bookCategory').val();
        let bookAuthor = $('#bookAuthor').val();
        
        loading.modal('show');

        $.ajax({
           type:'POST',
           url:'book/edit',
           data:{id:bookId, name:name, category:bookCategory, author:bookAuthor, _token: token},
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
        bookId = $(this).siblings('.book-id').val();
        let name = $(this).parent().siblings('.book-name').text();
        $('.heading-book-name').text(name);
    });

    $('.delete-btn').on('click', function() {
        loading.modal('show');

        $.ajax({
            type:'POST',
            url:'book/delete',
            data:{id:bookId, _token: token},
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
        let name = $('#addBookName').val();
        let bookCategory = $('#addCategory').val();
        let bookAuthor = $('#addAuthor').val();
        
        if(name && bookCategory && bookAuthor) {
            loading.modal('show');
            $.ajax({
                type:'POST',
                url:'book/add',
                data:{name:name, category:bookCategory, author:bookAuthor, _token: token},
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