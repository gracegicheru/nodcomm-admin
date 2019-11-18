
 function editfield(id){

			var btn =$('#editfieldbtn'+id);	
			var formdata = $('#prechatfieldform').serializeArray();
			formdata.push({name: "id",
			value: id});	
 			$.ajax({
            type: "POST",
            url: $('#prechatfieldform').attr("action"),
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
	
    $('#editprechatfieldbtn').click(function(e) {

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

			var formdata = $('#editprechatfieldform').serializeArray();
			formdata.push({name: "required",
			value: required});
			formdata.push({name: "visible",
			value: visible});


            $.ajax({
            type: "POST",
            url: $("#editprechatfieldform").attr("action"),
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

 
     $('#addprechatbtn').click(function(e) {

			var btn = $(this);

        
			var	_file = document.getElementById('photo'); 

			if(_file.files.length === 0){
				
			var formdata= new FormData($('#prechatform')[0]);

			}else{
				 var formdata= new FormData($('#prechatform')[0]);
				
				formdata.append('photo', _file.files[0]);
			
			}

            $.ajax({
            type: "POST",
            url: $("#prechatform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('saving <i class="fa fa-spinner fa-spin"></i>');        
            },
		    contentType: false,
            processData: false,
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
					text:  'Prechat added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
			    $('#profile-username').text(data.details.team_name);
				$('#offlinemsg').val(data.details.offline_greeting_msg);
				$('#onlinemsg').val(data.details.online_greeting_msg);
				$('#teamname').val(data.details.team_name);
				$('#onlinemsgtext').text(data.details.online_greeting_msg);
				$('#offlinemsgtext').text(data.details.offline_greeting_msg);
				$('#addprechatdiv').addClass('hide');
				$('#updateprechatdiv').removeClass('hide');
				$('#id').val(data.details.id);
				
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

$("#photo").change(function(e) {
	     $("#error").html('');
			var	_file = document.getElementById('photo'); 
			var ext= $(this).val().split('.').pop().toLowerCase();
		   if($.inArray(ext, ['png','jpg','jpeg']) == -1) 
			{
			$("#error").html('.'+ext +' file is not allowed');

			}else if((_file.size/1024/1024)>2){
			$("#error").html(file.name +' :  size is: ' + (file.size/1024/1024).toFixed(2) + 'MB. Please attach a file with less than 2MB');	

			}

});

     $('#updateprechatbtn').click(function(e) {

			var btn = $(this);

        
			var	_file = document.getElementById('photo1'); 

			if(_file.files.length === 0){
				
			var formdata= new FormData($('#updateprechatform')[0]);

			}else{
				 var formdata= new FormData($('#updateprechatform')[0]);
				
				formdata.append('photo', _file.files[0]);
			
			}

            $.ajax({
            type: "POST",
            url: $("#updateprechatform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('saving <i class="fa fa-spinner fa-spin"></i>');        
            },
		    contentType: false,
            processData: false,
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
					text:  'Prechat updated successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				
			    $('#profile-username').text(data.details.team_name);
				$('#offlinemsg').val(data.details.offline_greeting_msg);
				$('#id').val(data.details.id);
				$('#onlinemsg').val(data.details.online_greeting_msg);
				$('#teamname').val(data.details.team_name);
				$('#onlinemsgtext').text(data.details.online_greeting_msg);
				$('#offlinemsgtext').text(data.details.offline_greeting_msg);
				$('#addprechatdiv').addClass('hidden');
				$('#updateprechatdiv').removeClass('hidden');
				
				 $('.avatarimg').html('<img src="'+server+'/avatar/'+data.details.agents_avatar+'?v='+Math.random()+'" class="circle deep-orange accent-2" alt="">');
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

$("#photo1").change(function(e) {
	     $("#error1").html('');
			var	_file = document.getElementById('photo1'); 
			var ext= $(this).val().split('.').pop().toLowerCase();
		   if($.inArray(ext, ['png','jpg','jpeg']) == -1) 
			{
			$("#error1").html('.'+ext +' file is not allowed');

			}else if((_file.size/1024/1024)>2){
			$("#error1").html(file.name +' :  size is: ' + (file.size/1024/1024).toFixed(2) + 'MB. Please attach a file with less than 2MB');	

			}

});
     $('#addprechatfieldbtn').click(function(e) {

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

			var formdata = $('#prechatfieldform').serializeArray();
			formdata.push({name: "required",
			value: required});
			formdata.push({name: "visible",
			value: visible});
            $.ajax({
            type: "POST",
            url: $("#prechatfieldform").attr("action"),
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