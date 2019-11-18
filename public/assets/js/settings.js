
 function editsetting(id){

			var btn =$('#editsettingbtn'+id);	
			var formdata = $('#editsettingform').serializeArray();
			formdata.push({name: "id",
			value: id});	
 			$.ajax({
            type: "POST",
            url: $('#editsettingform').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');		
            },
			
            cache: false,
            success: function(data) {

			   btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
				$('#settingspan'+id).addClass('hide');
				$('#txtArea'+id).removeClass('hide');
				$('#editsettingbtn'+id).addClass('hide');
				$('#savesettingbtn'+id).removeClass('hide');
						

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Unable to load the  setting",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});	
						
					}
				});
    

return false;
 }
function savesetting(id){

var btn =$('#savesettingbtn'+id);

var formdata = $('#editsettingform').serializeArray();


formdata.push({
		name: "id",
		value: id
});
formdata.push({
		name: "txtArea",
		value: $('#txtArea'+id).val()
});

			$.ajax({
            type: "POST",
            url: server+"/setting/general/update",
            data: formdata,
			dataType:"json",
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');	
            },
            cache: false,
            success: function(data) {

			 if(data.status=='success'){

								  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
								 oTableToUpdate .fnDraw();
								$('#data-table-simple').dataTable().fnClearTable();

									 var i=1;
									$.each(data.details, function(key, value) {

								   
								   if((value.config_value).length> 100){
									 var config_value = (value.config_value).substr(0, 100)+'...'; 
								   }else{
									var config_value = value.config_value;    
								   }
								   
								   	 if(value.config_key=='paypal_mode'){
									var mode='';
									if(value.config_value==1){
									mode = 'Sandbox';	
									$( "#sandbox" ).prop( "checked", true );
									}else if(value.config_value==2)
									{
									mode = 'Production';	
									$( "#production" ).prop( "checked", true );
									}	
										var span = '<span id="paypalmodespan'+value.id+'">'+mode+'</span><div class="hide" id="paypalmodevalue'+value.id+'"><label class="label-radio inline"><input type="radio" name="keyvalue" id="sandbox" value="1"><span class="custom-radio"></span>Sandbox</label><label class="label-radio inline"><input type="radio" name="keyvalue" id="production" value="2" ><span class="custom-radio"></span>Production</label></div>';
										var link='<a  class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="paypalmode('+value.id+')"  style="margin-right:3px;" id="editpaypalmodebtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><a class="btn tooltipped hide" data-position="top" data-delay="50" data-tooltip="Save" onclick="savepaypalmode('+value.id+')"   style="margin-right:3px;" id="savepaypalmodebtn'+value.id+'"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
									 }else{
										var span = '<span id="settingspan'+value.id+'">'+config_value+'</span><textarea  style="width:100%" class="form-control hide" id="txtArea'+value.id+'"   style="overflow-y: auto;">'+value.config_value+'</textarea>';	
										var link='<a  class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editsetting('+value.id+')"  style="margin-right:3px;" id="editsettingbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><a  class="btn tooltipped hide" data-position="top" data-delay="50" data-tooltip="Save" onclick="savesetting('+value.id+')"  style="margin-right:3px;" id="savesettingbtn'+value.id+'"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
									 }

										 $('#data-table-simple').dataTable().fnAddData([
							  
										  ''!=null ? i : "",
										  ''!=null ? (value.config_key).replace(/_/g," ") : "",
										  ''!=null ? span: "",	
											link
												]);
									i++;
								}); 
		     		btn.prop("disabled", false).html('<i class="fa  fa-floppy-o" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'Setting  edited successfuly.',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	  
			   }
			else{
			btn.prop("disabled", false).html('<i class="fa fa-floppy-o" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  data.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
			}
			
						

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-floppy-o" aria-hidden="true"></i>');	
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Setting could not be edited",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
					
				});	
					}
				});

return false;
 }
   function paypalmode(id){

			var btn =$('#editpaypalmodebtn'+id);
			var formdata = $('#editsettingform').serializeArray();
			formdata.push({name: "id",
			value: id});	
 			$.ajax({
            type: "POST",
            url: $('#editsettingform').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function(xhr, settings) {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');		
            },
			
            cache: false,
            success: function(data) {
				
				btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');


				$.each(data, function( key, value ) {
	
				  if(value.config_value==1){

				  $( "#sandbox" ).prop( "checked", true );
				 
				  }else if(value.config_value==2)
				  {
				  $( "#production" ).prop( "checked", true );  

				  }
			  
				});
				$('#paypalmodespan'+id).addClass('hidden');
				$('#paypalmodevalue'+id).removeClass('hidden');
				$('#editpaypalmodebtn'+id).addClass('hidden');
				$('#savepaypalmodebtn'+id).removeClass('hidden');

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Unable to load the  setting",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});	
						
					}
				});
    

return false;
 }
 
  function savepaypalmode(id){

	var btn =$('#savepaypalmodebtn'+id);

	var formdata = $('#editsettingform').serializeArray();


	formdata.push({
			name: "id",
			value: id
	});
	formdata.push({
			name: "txtArea",
			value: $('input[name=keyvalue]:checked').val()
	});

			$.ajax({
            type: "POST",
            url: server+"/setting/general/update",
            data: formdata,
			dataType:"json",
            beforeSend: function(xhr, settings) {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');	
            },
            cache: false,
            success: function(data) {

			 		if(data.status=='success'){
						

								  var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
								 oTableToUpdate .fnDraw();
								$('#dataTable').dataTable().fnClearTable();

									 var i=1;
									$.each(data.details, function(key, value) {

								   
								   if((value.config_value).length> 100){
									 var config_value = (value.config_value).substr(0, 100)+'...'; 
								   }else{
									var config_value = value.config_value;    
								   }
								   
								   	 if(value.config_key=='paypal_mode'){
									var mode='';
									if(value.config_value==1){
									mode = 'Sandbox';	
									$( "#sandbox" ).prop( "checked", true );
									}else if(value.config_value==2)
									{
									mode = 'Production';	
									$( "#production" ).prop( "checked", true );
									}	
										var span = '<span id="paypalmodespan'+value.id+'">'+mode+'</span><div class="hidden" id="paypalmodevalue'+value.id+'"><label class="label-radio inline"><input type="radio" name="keyvalue" id="sandbox" value="1"><span class="custom-radio"></span>Sandbox</label><label class="label-radio inline"><input type="radio" name="keyvalue" id="production" value="2" ><span class="custom-radio"></span>Production</label></div>';
										var link='<a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="paypalmode('+value.id+')"  class="btn btn-xs btn-info" style="margin-right:3px;" id="editpaypalmodebtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Save" onclick="savepaypalmode('+value.id+')"  class="btn btn-xs btn-success hidden" style="margin-right:3px;" id="savepaypalmodebtn'+value.id+'"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
									 }else{
										var span = '<span id="settingspan'+value.id+'">'+config_value+'</span><textarea  style="width:100%" class="form-control hidden" id="txtArea'+value.id+'"   style="overflow-y: auto;">'+value.config_value+'</textarea>';	
										var link='<a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="editsetting('+value.id+')"  class="btn btn-xs btn-info" style="margin-right:3px;" id="editsettingbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Save" onclick="savesetting('+value.id+')"  class="btn btn-xs btn-success hidden" style="margin-right:3px;" id="savesettingbtn'+value.id+'"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
									 }

										 $('#dataTable').dataTable().fnAddData([
							  
										  ''!=null ? i : "",
										  ''!=null ? (value.config_key).replace(/_/g," ") : "",
										  ''!=null ? span: "",	
											link
												]);
									i++;
								}); 
								
								
		     		btn.prop("disabled", false).html('<i class="fa  fa-floppy-o" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'Setting  edited successfuly.',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	  
			   }
			else{
					btn.prop("disabled", false).html('<i class="fa fa-floppy-o" aria-hidden="true"></i>');	
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  data.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
			}
						

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-floppy-o" aria-hidden="true"></i>');	
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Setting could not be edited",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
					
				});		
					}
				});

return false;
 }