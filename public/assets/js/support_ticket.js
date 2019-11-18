$('#ticketbtn').click(function(event){
    console.log('this');

    event.preventDefault();
    let formSupport = $('#techicalform').serializeArray();

    $.ajax({
        type:'post',
        url:'/technicalsupport',
        data:formSupport,
        dataType:'json',

        success: function (data) {
            console.log("thisdata", data);
            if(data.status=='ok'){

                $('#title').val('');

                $('#department').val("one");
                $('#priority').val("two");
                $('#message').val('');

                $.gritter.add({
                    title: "<strong style='color:#3ec291'>Success!</strong>",
                    text: 'Your Ticket has successfully been submitted!',
                    sticky: false,
                    time: '',
                    class_name: 'gritter-success'
                });

                $('#modal').modal('close');

            }
        },

        error: function (xhr, errmsg, err) {
            console.log("error", xhr);
            console.log("new", errmsg);
            console.log("ticket", err);
        },

    });

});