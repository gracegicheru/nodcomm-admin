$('#ticketbtn').click(function(){
    console.log("this");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"post",
        url: "/salesSupport",
        data:{
            'title': $('#title').val(),
            'category': $('#category').val(),
            'priority': $('#priority').val(),
            'message': $('#message').val(),

        },
        success:function(data){
            console.log('data', data);
            if(data.status=='ok'){

            }

        },

        error: function (xhr, errmsg, err) {


            console.log("error ajax");
            console.log("error", xhr);
            console.log("new", errmsg);
            console.log("sale", err);
        }
    });

});