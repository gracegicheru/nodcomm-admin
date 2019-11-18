
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});


	  
	$( ".lang" ).change( function () {
		$('#wizard').removeClass('hide');
		$('#step1').removeClass('active disabled complete');
		$('#step1').addClass('active');
		$('#step2').removeClass('active disabled complete');
		$('#step2').addClass('disabled');
		$('#step3').removeClass('active disabled complete');
		$('#step3').addClass('disabled');
		$('#step4').removeClass('active disabled complete');
		$('#step4').addClass('disabled');

	} );
    $('#translatebtn').click(function(e) {
			var btn = $(this);
			var formdata = $('#translateform').serializeArray();
			formdata.push({name: "lang_text",
			value: $(".lang option:selected").text()});
            $.ajax({
            type: "POST",
            url:  $('#translateform').attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Translating <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-language" aria-hidden="true"></i> Translate'); 
               if(data.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  data.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
				$('#step1').removeClass('active disabled complete');
				$('#step1').addClass('complete');
				$('#step2').removeClass('active disabled complete');
				$('#step2').addClass('active');
				$('#step3').removeClass('active disabled complete');
				$('#step3').addClass('disabled');
			    $('#step4').removeClass('active disabled complete');
				$('#step4').addClass('disabled');
				$.ajax({
				type: "POST",
				url:  server+'/translation/step2',
				data: {'_token':csrf,'lang_code': data.lang_code,'lang':data.lang},
				dataType:"json",
				beforeSend: function() {

				btn.prop("disabled", true).html('Translating <i class="fa fa-spinner fa-spin"></i>');        
				},
				cache: false,
				success: function(data) {

					 btn.prop("disabled", false).html('<i class="fa fa-language" aria-hidden="true"></i> Translate'); 
					$('#step1').removeClass('active disabled complete');
					$('#step1').addClass('complete');
					$('#step2').removeClass('active disabled complete');
					$('#step2').addClass('complete');
					$('#step3').removeClass('active disabled complete');
					$('#step3').addClass('active');
					$('#step4').removeClass('active disabled complete');
					$('#step4').addClass('disabled');
					$.ajax({
					type: "POST",
					url:  server+'/translation/step3',
					data: {'_token':csrf,'lang_code': data.lang_code,'lang':data.lang},
					dataType:"json",
					beforeSend: function() {

					btn.prop("disabled", true).html('Translating <i class="fa fa-spinner fa-spin"></i>');        
					},
					cache: false,
					success: function(data1) {
						var key = data.lang_code;
						var value = data.translated_array;
						var postsRef = firebase.database().ref().child("file");
						var newPostRef = postsRef.push();
						newPostRef.set({
						code : key, 
						content:value,
						country:data1.country,
						flag:data1.flag,
						lang:data.lang
						});
						 btn.prop("disabled", false).html('<i class="fa fa-language" aria-hidden="true"></i> Translate'); 
					   if(data.status=='error'){
							$.gritter.add({
							title: "<strong style='color:#fb5a43'>Oops!</strong>",
							text:  data1.details,
							sticky: false,
							time: '',
							class_name: 'gritter-danger'
						});
					   }else{
							$.gritter.add({
							title: "<strong style='color:#3ec291'>Success!</strong>",
							text:  'Language translated successfully .',
							sticky: false,
							time: '',
							class_name: 'gritter-success'
						});	
						$('#step1').removeClass('active disabled complete');
						$('#step1').addClass('complete');
						$('#step2').removeClass('active disabled complete');
						$('#step2').addClass('complete');
						$('#step3').removeClass('active disabled complete');
						$('#step3').addClass('complete');
						$('#step4').removeClass('active disabled complete');
						$('#step4').addClass('complete');
						$('#wizard').addClass('hide');
						 var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
						 oTableToUpdate .fnDraw();
						$('#data-table-simple').dataTable().fnClearTable();

										var i=1;
										var link = '';
										var status = '';

										$.each(data1.details, function(key, value) {

											 $('#data-table-simple').dataTable().fnAddData([
								  
											  ''!=null ? i : "",
											  ''!=null ? value.lang_code  : "",
											  ''!=null ? value.lang  : "",
											 '<a  data-toggle="tooltip" data-placement="top" title="" data-original-title="View File" onclick="view_file('+value.lang_code+')"  class="btn btn-xs btn-info" style="margin-right:3px;" id="view_filebtn'+value.lang_code+'"><i class="fa fa-eye" aria-hidden="true"></i></a>	'
											 ]);
											i++;
										}); 

							}
							},
							error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

							btn.prop("disabled", false).html('<i class="fa fa-language" aria-hidden="true"></i> Translate');
							$.gritter.add({
							title: "<strong style='color:#fb5a43'>Oops!</strong>",
							text:  "An error occurred.Please try again",
							sticky: false,
							time: '',
							class_name: 'gritter-danger'
						});
							}
						});
    
					 
					 
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

						btn.prop("disabled", false).html('<i class="fa fa-language" aria-hidden="true"></i> Translate');
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
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-language" aria-hidden="true"></i> Translate');
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
 function editsetting(id){

			$('#settingspan'+id).addClass('hidden');
			$('#txtArea'+id).removeClass('hidden');
			$('#editsettingbtn'+id).addClass('hidden');
			$('#savesettingbtn'+id).removeClass('hidden');
return false;
 }
  function savesetting(id){
					 var ref = firebase.database().ref("file");
					 ref.orderByChild("code").equalTo($('#lang_code'+id).val()).on("value", function(snapshot) {
						 snapshot.forEach(function(childsnapshot) {
						var NameRef = firebase.database().ref('file/'+childsnapshot.key+'/content');
						var a = id;
						var obj = {};
						obj[a] = $('#txtArea'+id).val();
						NameRef.update(obj);
						$('#settingspan'+id).removeClass('hidden');
						$('#txtArea'+id).addClass('hidden');
						$('#editsettingbtn'+id).removeClass('hidden');
						$('#savesettingbtn'+id).addClass('hidden');
								  var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
								 oTableToUpdate .fnDraw();
								$('#dataTable').dataTable().fnClearTable();

									 var i=1;
									$.each(childsnapshot.val().content, function(key, value) {

								   
								   if((value).length> 100){
									 var config_value = (value).substr(0, 100)+'...'; 
								   }else{
									var config_value = value;    
								   }
								   
										var span = '<span id="settingspan'+key+'">'+config_value+'</span><textarea  style="width:100%" class="form-control hidden" id="txtArea'+key+'"   style="overflow-y: auto;">'+value+'</textarea>';	
										var link='<a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="editsetting('+key+')"  class="btn btn-xs btn-info" style="margin-right:3px;" id="editsettingbtn'+key+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Save" onclick="savesetting('+key+')"  class="btn btn-xs btn-success hidden" style="margin-right:3px;" id="savesettingbtn'+key+'"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
									

										 $('#dataTable').dataTable().fnAddData([
							  
										  ''!=null ? key : "",
										  ''!=null ? span: "",	
											link+
											'<input  id="lang_code'+key+'" type="hidden" value="'+key+'">'
												]);
									i++;
								}); 		
				

			 });
			  });

return;
			//var btn =$('#savesettingbtn'+id);
			/*$.ajax({
            type: "POST",
            url: server+"/translation/save-file",
            data: {'lang_code':$('#lang_code'+id).val(),'array_key':id,'array_value': $('#txtArea'+id).val()},
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');	
            },
            cache: false,
            success: function(data) {
		     		//btn.prop("disabled", false).html('<i class="fa  fa-floppy-o" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'File  edited successfuly.',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});*/	  
						$('#settingspan'+id).removeClass('hidden');
						$('#txtArea'+id).addClass('hidden');
						$('#editsettingbtn'+id).removeClass('hidden');
						$('#savesettingbtn'+id).addClass('hidden');
								  var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
								 oTableToUpdate .fnDraw();
								$('#dataTable').dataTable().fnClearTable();

									 var i=1;
									$.each(data.details, function(key, value) {

								   
								   if((value).length> 100){
									 var config_value = (value).substr(0, 100)+'...'; 
								   }else{
									var config_value = value;    
								   }
								   alert(value);
										var span = '<span id="settingspan'+key+'">'+config_value+'</span><textarea  style="width:100%" class="form-control hidden" id="txtArea'+key+'"   style="overflow-y: auto;">'+value+'</textarea>';	
										var link='<a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="editsetting('+key+')"  class="btn btn-xs btn-info" style="margin-right:3px;" id="editsettingbtn'+key+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Save" onclick="savesetting('+key+')"  class="btn btn-xs btn-success hidden" style="margin-right:3px;" id="savesettingbtn'+key+'"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
									

										 $('#dataTable').dataTable().fnAddData([
							  
										  ''!=null ? key : "",
										  ''!=null ? span: "",	
											link+
											'<input  id="lang_code'+key+'" type="hidden" value="'+key+'">'
												]);
									i++;
								}); 
					/*},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-floppy-o" aria-hidden="true"></i>');	
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred, please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
					
					});	
					}
				//});*/

return false;
 }
 /*function savesetting(id){

			var btn =$('#savesettingbtn'+id);
			$.ajax({
            type: "POST",
            url: server+"/translation/save-file",
            data: {'lang_code':$('#lang_code'+id).val(),'array_key':id,'array_value': $('#txtArea'+id).val()},
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');	
            },
            cache: false,
            success: function(data) {
		     		btn.prop("disabled", false).html('<i class="fa  fa-floppy-o" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'File  edited successfuly.',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	  
			   	$('#settingspan'+id).removeClass('hidden');
				$('#txtArea'+id).addClass('hidden');
				$('#editsettingbtn'+id).removeClass('hidden');
				$('#savesettingbtn'+id).addClass('hidden');
								  var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
								 oTableToUpdate .fnDraw();
								$('#dataTable').dataTable().fnClearTable();

									 var i=1;
									$.each(data.details, function(key, value) {

								   
								   if((value).length> 100){
									 var config_value = (value).substr(0, 100)+'...'; 
								   }else{
									var config_value = value;    
								   }
								   alert(value);
										var span = '<span id="settingspan'+key+'">'+config_value+'</span><textarea  style="width:100%" class="form-control hidden" id="txtArea'+key+'"   style="overflow-y: auto;">'+value+'</textarea>';	
										var link='<a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="editsetting('+key+')"  class="btn btn-xs btn-info" style="margin-right:3px;" id="editsettingbtn'+key+'"><i class="fa fa-pencil" aria-hidden="true"></i></a><a  data-toggle="tooltip" data-placement="top" title="" data-original-title="Save" onclick="savesetting('+key+')"  class="btn btn-xs btn-success hidden" style="margin-right:3px;" id="savesettingbtn'+key+'"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>';
									

										 $('#dataTable').dataTable().fnAddData([
							  
										  ''!=null ? key : "",
										  ''!=null ? span: "",	
											link+
											'<input  id="lang_code'+key+'" type="hidden" value="'+key+'">'
												]);
									i++;
								}); 
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-floppy-o" aria-hidden="true"></i>');	
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred, please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
					
					});	
					}
				});

return false;
 }*/
 			function view_file(id){
			
			 var btn =$('#view_filebtn'+id);

			  var formdata = $('#translateform').serializeArray();
			  formdata.push({name: "id",value: id});
			 var ref = firebase.database().ref("file");
			 ref.orderByChild("code").equalTo(id).once("value", function(snapshot) {
			  
				snapshot.forEach(function(childsnapshot) {
				
				var content =JSON.stringify( childsnapshot.val().content);
			
				formdata.push({name: "content",value: content});
				$.ajax({
				type: "post",
				url: server+"/translation/retrieve-file",
				data: formdata,
				dataType:"json",
				beforeSend: function() {

				btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');		
				},
				
				cache: false,
				success: function(data) {
					btn.prop("disabled", false).html('<i class="fa fa-eye" aria-hidden="true"></i>');
					window.location.replace(data.details);
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

						btn.prop("disabled", false).html('<i class="fa fa-eye" aria-hidden="true"></i>');
						$.gritter.add({
						title: "<strong style='color:#fb5a43'>Oops!</strong>",
						text:  "An error occurred. Please try again",
						sticky: false,
						time: '',
						class_name: 'gritter-danger'
					});	
							
						}
					});
			  });

			});

			

		

	return false;
	 } 