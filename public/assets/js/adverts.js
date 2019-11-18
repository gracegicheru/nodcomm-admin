
$("#message").keyup(function(){
	$(this).css("border-color", "");
	var msg = $(this).val();
    var count = msg.length;
    if(count > 70){
    	var msg2 = msg.substr(0, 70);
    	$(this).val(msg2);
    	$("#msg-count").html(70);
    }else{
    	$("#msg-count").html(count);
    }

});
    $('#addadvertbtn').click(function(e) {

			var btn = $(this);

            $.ajax({
            type: "POST",
            url:$("#addadvertform").attr("action"),
            data: $("#addadvertform").serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('adding <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {

                 btn.prop("disabled", false).html('<i class="material-icons right">add</i> Add'); 
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
					text:  'Advert added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
			   $('#name').val(data.details.name);
			   $('#message1').val(data.details.message);
			   $('#id').val(data.details.id);
               $('#addadvertdiv').addClass('hidden');
			   $('#editadvertdiv').removeClass('hidden');
				/*  var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#dataTable').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								$.each(data.details, function(key, value) {
									if(value.status == 1){
										link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Disable" onclick="disableadvert('+value.id+')"  id="disableadvertbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Enable" onclick="enableadvert('+value.id+')"  id="enableadvertbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   if((value.message).length> 50){
									 var message = (value.message).substr(0, 50)+'...'; 
								   }else{
									var message = value.message;    
								   }
									 $('#dataTable').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? message  : "",
									  status,
									  '<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="editadvert('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="editadvertbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link
											]);
									i++;
								}); */

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

					btn.prop("disabled", false).html('<i class="material-icons right">add</i> Add'); 
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
 function editadvert(id){

			var btn =$('#editadvertbtn'+id);

					
			var formdata = $('#addadvertform').serializeArray();
			formdata.push({name: "id",
			value: id});	
 			$.ajax({
            type: "POST",
            url: $('#addadvertform').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');		
            },
			
            cache: false,
            success: function(data) {

			   btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
			   $('#name').val(data.details.name);
			   $('#message1').val(data.details.message);
			   $('#id').val(data.details.id);
               $('#addadvertdiv').addClass('hidden');
			   $('#editadvertdiv').removeClass('hidden');

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Unable to load the  advert",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});	
						
					}
				});
    

return false;
 }
     $('#editadvertbtn').click(function(e) {

			var btn = $(this);

            var form = $("#editadvertform");

            $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('editing <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="material-icons right">edit</i> Edit'); 
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
					text:  'Advert edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				 /* var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#dataTable').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								$.each(data.details, function(key, value) {
									if(value.status == 1){
										link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Disable" onclick="disableadvert('+value.id+')"  id="disableadvertbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Enable" onclick="enableadvert('+value.id+')"  id="enableadvertbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   if((value.message).length> 50){
									 var message = (value.message).substr(0, 50)+'...'; 
								   }else{
									var message = value.message;    
								   }
									 $('#dataTable').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? message  : "",
									  status,
									  '<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="editadvert('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="editadvertbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link
											]);
									i++;
								}); */
                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="material-icons right">edit</i> Edit');
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
 	$(".advert-edit-back").click(function(){
		$("#editadvertdiv").addClass("hidden");
		$("#addadvertdiv").removeClass("hidden");
	});
 function disableadvert(id){
var answer = confirm('Are you sure you want to disable this advert?');
if (answer)
{
			var btn =$('#disableadvertbtn'+id);
			var formdata = $('#addadvertform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/advertisements/disable",
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>'); 
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
					text:  'Advert disabled successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#dataTable').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								$.each(data.details, function(key, value) {
									if(value.status == 1){
										link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Disable" onclick="disableadvert('+value.id+')"  id="disableadvertbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Enable" onclick="enableadvert('+value.id+')"  id="enableadvertbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   if((value.message).length> 50){
									 var message = (value.message).substr(0, 50)+'...'; 
								   }else{
									var message = value.message;    
								   }
									 $('#dataTable').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? message  : "",
									  status,
									  '<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="editadvert('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="editadvertbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
}
else
{
  return false;
}
 }
 function enableadvert(id){
var answer = confirm('Are you sure you want to enable this advert?');
if (answer)
{
			var btn =$('#enableadvertbtn'+id);
			var formdata = $('#addadvertform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/advertisements/enable",
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>'); 
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
					text:  'Advert enabled successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#dataTable').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								$.each(data.details, function(key, value) {
									if(value.status == 1){
										link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Disable" onclick="disableadvert('+value.id+')"  id="disableadvertbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Enable" onclick="enableadvert('+value.id+')"  id="enableadvertbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   if((value.message).length> 50){
									 var message = (value.message).substr(0, 50)+'...'; 
								   }else{
									var message = value.message;    
								   }
									 $('#dataTable').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? message  : "",
									  status,
									  '<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="editadvert('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="editadvertbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
}
else
{
  return false;
}
 }