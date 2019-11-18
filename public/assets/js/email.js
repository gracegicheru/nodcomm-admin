
    $('#addemailbtn').click(function(e) {

			var btn = $(this);

            $.ajax({
            type: "POST",
            url:$("#addemailform").attr("action"),
            data: $("#addemailform").serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> adding');        
            },
            cache: false,
            success: function(data) {

                 btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register'); 
               if(data.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  data.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'Email setting added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
			   $('#name').val(data.details.username);
			   $('#port').val(data.details.port);
			   $('#host').val(data.details.host);
			   $('#encryption').val(data.details.encryption);
			   $('#password').val(data.details.password);
			   $('#id').val(data.details.id);
               $('#addemaildiv').addClass('hidden');
			   $('#editemaildiv').removeClass('hidden');

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    
e.preventDefault();
});

     $('#editemailbtn').click(function(e) {

			var btn = $(this);

            var form = $("#editemailform");

            $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Editing');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit'); 
               if(data.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  data.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'Email setting edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
			   $('#name').val(data.details.username);
			   $('#port').val(data.details.port);
			   $('#host').val(data.details.host);
			   $('#encryption').val(data.details.encryption);
			   $('#password').val(data.details.password);
			   $('#id').val(data.details.id);
                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    
e.preventDefault();
});
 	