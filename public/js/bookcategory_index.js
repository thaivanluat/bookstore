$(function() {
    var categoryId;
    var loading = $('#loadingModal');
    var token = $('#token').val();

    $('.edit-button').on('click', function() {
    	let name = $(this).parent().siblings('.category-name').text();
    	categoryId = $(this).siblings('.category-id').val();
    	$('#categoryName').val(name);
    });

    $('.save-change-btn').on('click', function() {
    	let name = $('#categoryName').val();
        
        loading.modal('show');

        $.ajax({
           type:'POST',
           url:'bookcategory/edit',
           data:{id:categoryId, name:name, _token: token},
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
        categoryId = $(this).siblings('.category-id').val();
        let name = $(this).parent().siblings('.category-name').text();
        $('.heading-category-name').text(name);
    });

    $('.delete-btn').on('click', function() {
        loading.modal('show');

        $.ajax({
            type:'POST',
            url:'bookcategory/delete',
            data:{id:categoryId, _token: token},
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
        let name = $('#addCategoryName').val();
        
        if(name) {
            loading.modal('show');
            $.ajax({
                type:'POST',
                url:'bookcategory/add',
                data:{name:name, _token: token},
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