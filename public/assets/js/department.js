function selectagent(id,element){
	
	if($(element).hasClass("selected")){
		$(element).removeClass('selected');
		
	}else{
		$(element).addClass('selected');
	}
	

return false;	
}
	$('#selectagentbtn').click(function(e) {

            var ul= $('#unselectedagentul').children('li');
			
			var finalli;
		   $.each(ul, function(key, value) {
			   if($(value).hasClass("selected")){
				finalli= $(value).removeClass("selected");
			    $('#selectedagentul').append(finalli);
				}
		   });

		
		e.preventDefault();
	});
		$('#editselectagentbtn').click(function(e) {

            var ul= $('#editunselectedagentul').children('li');
			
			var finalli;
		   $.each(ul, function(key, value) {
			   if($(value).hasClass("selected")){
				finalli= $(value).removeClass("selected");
			    $('#editselectedagentul').append(finalli);
				}
		   });

		
		e.preventDefault();
	});
		$('#unselectagentbtn').click(function(e) {

            var ul= $('#selectedagentul').children('li');
			
			var finalli;
		   $.each(ul, function(key, value) {
			   if($(value).hasClass("selected")){
				finalli= $(value).removeClass("selected");
			    $('#unselectedagentul').append(finalli);
				}
		   });

		
		e.preventDefault();
	});
			$('#editunselectagentbtn').click(function(e) {

            var ul= $('#editselectedagentul').children('li');
			
			var finalli;
		   $.each(ul, function(key, value) {
			   if($(value).hasClass("selected")){
				finalli= $(value).removeClass("selected");
			    $('#editunselectedagentul').append(finalli);
				}
		   });

		
		e.preventDefault();
	});
	     $('#adddepartmentbtn').click(function(e) {
			var ids=[];
			var ul= $('#selectedagentul').children('li');
		   $.each(ul, function(key, value) {

				ids.push($(value).data('id'));
				
		   });


			var btn = $(this);
			var formdata = $('#departmentform').serializeArray();
			formdata.push({name: "agentids",
			value: ids});	

            $.ajax({
            type: "POST",
            url: $("#departmentform").attr("action"),
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
					text:  'Department added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;

								$.each(data.details, function(key, value) {
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.department_name  : "",
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editdepartment('+value.id+')"  style="margin-right:3px;" id="editdepartmentbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
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
 function editdepartment(id){

			var btn =$('#editdepartmentbtn'+id);	
			var formdata = $('#departmentform').serializeArray();
			formdata.push({name: "id",
			value: id});	
 			$.ajax({
            type: "POST",
            url: $('#departmentform').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');		
            },
			
            cache: false,
            success: function(data) {
				console.log(data);
			   btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');

			   $('#name').val(data.details.department.department_name);
			   $('#description').val(data.details.department.description);
			   $('#id').val(data.details.department.id);
			   
			   
               $('#adddepartmentdiv').addClass('hide');
			   $('#updatedepartmentdiv').removeClass('hide');
			   var ul='';
				$.each(data.details.agents, function(key, value) {
				ul += '<li class="list-group-item selectedagent" data-id="'+value.id+'" style="cursor: pointer;" onclick="selectagent('+value.id+',this)">'+value.name+' </li>';
				}); 
				$('#editselectedagentul').html(ul);
				
				var ul1='';
				$.each(data.details.users, function(key, value) {
				ul1 += '<li class="list-group-item selectedagent" data-id="'+value.id+'" style="cursor: pointer;" onclick="selectagent('+value.id+',this)">'+value.name+' </li>';
				}); 
				$('#editunselectedagentul').html(ul1);
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Unable to load the  department",
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
	
    $('#updatedepartmentbtn').click(function(e) {
			var ids=[];
			var ul= $('#editselectedagentul').children('li');
		   $.each(ul, function(key, value) {

				ids.push($(value).data('id'));
				
		   });


			var btn = $(this);
			var formdata = $('#updatedepartmentform').serializeArray();
			formdata.push({name: "agentids",
			value: ids});	
            $.ajax({
            type: "POST",
            url: $("#updatedepartmentform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Editing <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
				console.log();
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
					text:  'Department edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;

								$.each(data.details, function(key, value) {
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.department_name  : "",
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editdepartment('+value.id+')"  style="margin-right:3px;" id="editdepartmentbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'
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




   