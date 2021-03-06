$(function() {
    var authorId;
    var loading = $('#loadingModal');
    var token = $('#token').val();

    $('.edit-button').on('click', function() {
    	let name = $(this).parent().siblings('.author-name').text();
    	let year = $(this).parent().siblings('.author-birthday').text(); 
    	authorId = $(this).siblings('.author-id').val();
    	$('#authorName').val(name);
    	$('#yearBirth').val(year);
    });

    $('.save-change-btn').on('click', function() {
    	let name = $('#authorName').val();
        let year = $('#yearBirth').val();
        
        loading.modal('show');

        $.ajax({
           type:'POST',
           url:'author/edit',
           data:{id:authorId, name:name, year:year, _token: token},
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
        authorId = $(this).siblings('.author-id').val();
        let name = $(this).parent().siblings('.author-name').text();
        $('.heading-author-name').text(name);
    });

    $('.delete-btn').on('click', function() {
        loading.modal('show');

        $.ajax({
            type:'POST',
            url:'author/delete',
            data:{id:authorId, _token: token},
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
        let name = $('#addAuthorName').val();
        let year = $('#addYearBirth').val();
        
        if(name && year) {
            loading.modal('show');
            $.ajax({
                type:'POST',
                url:'author/add',
                data:{name:name, year:year, _token: token},
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