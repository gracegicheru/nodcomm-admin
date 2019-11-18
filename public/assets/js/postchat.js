
 function editfield(id){

			var btn =$('#editfieldbtn'+id);	
			var formdata = $('#postchatfieldform').serializeArray();
			formdata.push({name: "id",
			value: id});	
 			$.ajax({
            type: "POST",
            url: $('#postchatfieldform').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');		
            },
			
            cache: false,
            success: function(data) {

			   btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
			   if(data.details.visible==1){
				 $('#field_visible1').prop('checked', true);				 
			   }else{
				$('#field_visible1').prop('checked', false);
			   }
			   if(data.details.required==1){
				 $('#field_required1').prop('checked', true);				 
			   }else{
				$('#field_required1').prop('checked', false);
			   }
			   $('#fieldname').val(data.details.name);
			   $('#fieldid').val(data.details.id);
               $('#addfielddiv').addClass('hide');
			   $('#editfielddiv').removeClass('hide');
						

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Unable to load the  field",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});	
						
					}
				});
    

return false;
 }
 	$(".field-edit-back").click(function(){
		$("#editfielddiv").addClass("hide");
		$("#addfielddiv").removeClass("hide");
	});
	
    $('#editpostchatfieldbtn').click(function(e) {

			var btn = $(this);
			if($('#field_required1').prop('checked')) {
				var required =1;
			} else {
				var required =0;
			}
						
			if($('#field_visible1').prop('checked')) {
				var visible =1;
			} else {
				var visible =0;
			}

			var formdata = $('#editpostchatfieldform').serializeArray();
			formdata.push({name: "required",
			value: required});
			formdata.push({name: "visible",
			value: visible});


            $.ajax({
            type: "POST",
            url: $("#editpostchatfieldform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Editing <i class="fa fa-spinner fa-spin"></i>');        
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
					text:  'Field edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;

								$.each(data.details, function(key, value) {
									if(value.visible == 1){
										var visible = '<p><input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" /><label for="filled-in-box"></label></p>';
									}else{
										var visible = '<p><input type="checkbox" id="test5" /><label for="test5"></label></p>';
									}
								    if(value.required == 1){
										var required = '<p><input type="checkbox" class="filled-in" id="filled-in-box1" checked="checked" /><label for="filled-in-box1"></label></p>';
									}else{
										var required = '<p><input type="checkbox" id="test6" /><label for="test6"></label></p>';
									}
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? required  : "",
									  ''!=null ? visible  : "",
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editfield('+value.id+')"  style="margin-right:3px;" id="editfieldbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when editing.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    
e.preventDefault();
});

 
     $('#addpostchatbtn').click(function(e) {

			var btn = $(this);

            $.ajax({
            type: "POST",
            url: $("#postchatform").attr("action"),
            data: $("#postchatform").serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('saving <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Save'); 
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
					text:  'Postchat added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
			    
				
				$('#greetingmsg').val(data.details.greeting_msg);
				
				$('#greetingmsgtext').text(data.details.greeting_msg);

				$('#addpostchatdiv').addClass('hidden');
				$('#updatepostchatdiv').removeClass('hidden');
				$('#id').val(data.details.id);

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Save');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when saving.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    
e.preventDefault();
});



     $('#updatepostchatbtn').click(function(e) {
			var btn = $(this);
            $.ajax({
            type: "POST",
            url: $("#updatepostchatform").attr("action"),
            data: $("#updatepostchatform").serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('saving <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i> Update '); 
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
					text:  'Postchat updated successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				

				$('#id').val(data.details.id);

				$('#greetingmsg').val(data.details.greeting_msg);
				
				$('#greetingmsgtext').text(data.details.greeting_msg);

				$('#addpostchatdiv').addClass('hidden');
				$('#updatepostchatdiv').removeClass('hidden');
				
				//$('#profileimage').html('<img src="/storage/profile_images/'+data.details.photo+'" class="img-circle" alt="User Image">');
                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i> Update ');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when editing.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    
e.preventDefault();
});


     $('#addpostchatfieldbtn').click(function(e) {

			var btn = $(this);
			
			if($('#field_required').prop('checked')) {
				var required =1;
			} else {
				var required =0;
			}
						
			if($('#field_visible').prop('checked')) {
				var visible =1;
			} else {
				var visible =0;
			}

			var formdata = $('#postchatfieldform').serializeArray();
			formdata.push({name: "required",
			value: required});
			formdata.push({name: "visible",
			value: visible});
            $.ajax({
            type: "POST",
            url: $("#postchatfieldform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('saving <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Save'); 
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
					text:  'Field added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;

								$.each(data.details, function(key, value) {
									if(value.visible == 1){
										var visible = '<p><input type="checkbox" class="filled-in" id="filled-in-box" checked="checked" /><label for="filled-in-box"></label></p>';
									}else{
										var visible = '<p><input type="checkbox" id="test5" /><label for="test5"></label></p>';
									}
								    if(value.required == 1){
										var required = '<p><input type="checkbox" class="filled-in" id="filled-in-box1" checked="checked" /><label for="filled-in-box1"></label></p>';
									}else{
										var required = '<p><input type="checkbox" id="test6" /><label for="test6"></label></p>';
									}
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? required  : "",
									  ''!=null ? visible  : "",
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editfield('+value.id+')"  style="margin-right:3px;" id="editfieldbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
											]);
									i++;
								}); 
				
				//$('#profileimage').html('<img src="/storage/profile_images/'+data.details.photo+'" class="img-circle" alt="User Image">');
                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Save');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when saving.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    
e.preventDefault();
});