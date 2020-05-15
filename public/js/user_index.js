$(function() {
    var userId;
    var loading = $('#loadingModal');
    var token = $('#token').val();
    
    $('#userType').select2({
        theme: "bootstrap"
    });
    $('#addUserType').select2({
        theme: "bootstrap"
    });

    $('.edit-button').on('click', function() {
        userId = $(this).siblings('.user-id').val();
        userType = $(this).siblings('.user-type').val();

        let name = $(this).parent().siblings('.username').text();
        $('.heading-edit-user-name').text(name);

        $('#userType').val(userType);
        $('#userType').trigger('change');
    });

    $('.save-change-btn').on('click', function() {
        let userType = $('#userType').val();
        
        loading.modal('show');

        $.ajax({
           type:'POST',
           url:'user/edit',
           data:{id:userId, type:userType, _token: token},
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
        userId = $(this).siblings('.user-id').val();
        let name = $(this).parent().siblings('.username').text();
        $('.heading-user-name').text(name);
    });

    $('.delete-btn').on('click', function() {
        loading.modal('show');

        $.ajax({
            type:'POST',
            url:'user/delete',
            data:{id:userId, _token: token},
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
        let username = $('#addUserName').val();
        let phone = $('#addPhone').val();
        let email = $('#addEmail').val();
        let name = $('#addName').val();
        let birthday = $('#addBirthday').val();
        let userType = $('#addUserType').val();
        
        if(name && phone && email && username && userType) {
            loading.modal('show');
            $.ajax({
                type:'POST',
                url:'user/add',
                data:{username: username, name:name, phone:phone, email:email,birthday: birthday, type: userType,_token: token},
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