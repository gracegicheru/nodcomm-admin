	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
$("#sendmessageform").submit(function(evt){
	evt.preventDefault();

	var btn = $("#sendmessagebtn"),
		form = $(this),
		txt = $("#message").val();

	if(txt == '' ){
		$("#message").css("border-color", "red");
	}else{

		$.ajax({
			type:  "post",
			data:  form.serialize(),
			url:   form.attr("action"),
			dataType:  "json",
			beforeSend:  function(){
				btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Sending');
			},
			success:  function(res){
				if(res.status == "success"){
					btn.prop("disabled", false).html('<i class="fa fa-send" aria-hidden="true"></i> Send');
					$("#message").val('');
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								$.each(res.details, function(key, value) {

									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.support_description  : "",
									  ''!=null ? value.user  : "",
									  '<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="View Response" href="'+server+'/support/reply/'+value.id+'" target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'		
											]);
									i++;
								}); 
					$.gritter.add({
						title: "<strong style='color:#3ec291'>Success!</strong>",
						text: 'The message has been sent successfully',
						sticky: false,
						time: '',
						class_name: 'gritter-success'
					});
				}else{
					btn.prop("disabled", false).html('<i class="fa fa-send" aria-hidden="true"></i> Send');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  res.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
				}
			},
			error:  function(err){
					btn.prop("disabled", false).html('<i class="fa fa-send" aria-hidden="true"></i> Send');
				$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text: 'An error occured. Please try again.',
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
			}
		});
	}
}); 
 function marksolved(id){
var answer = confirm('Are you sure you want to mark this message solved?');
if (answer)
{
			var btn =$('#marksolvedbtn'+id);

	        $.ajax({
            type: "POST",
            url: server+"/support/mark-solved",
            data: {'id': id,'_token':csrf},
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
				
                 btn.prop("disabled", false).html('<i class="fa fa-check" aria-hidden="true"></i>'); 
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
					text:  'Message marked solved successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#data-table-simple1').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple1').dataTable().fnClearTable();
									var i=1;
									var link = '';
									var status = '';
									$.each(data.details, function(key, value) {
									if(value.solved == 1){
										link ='<a  class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Mark Unsolved" onclick="markunsolved('+value.id+')"   style="margin-right:3px;" id="markunsolvedbtn'+value.id+'"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Solved';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Mark Solved" onclick="marksolved('+value.id+')"   style="margin-right:3px;" id="marksolvedbtn'+value.id+'"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Not Solved';
									}

									 $('#data-table-simple1').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.support_description  : "",
									  ''!=null ? value.company  : "",
									  ''!=null ? value.user  : "",
									  status,
									  link+'<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Reply" style="margin-right:3px;" href="'+server+'/support/reply/'+value.id+'"><i class="fa fa-reply" aria-hidden="true"></i></a>'
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                 btn.prop("disabled", false).html('<i class="fa fa-check" aria-hidden="true"></i>'); 
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
  function markunsolved(id){
var answer = confirm('Are you sure you want to mark this message unsolved?');
if (answer)
{
			var btn =$('#markunsolvedbtn'+id);

	        $.ajax({
            type: "POST",
            url: server+"/support/mark-unsolved",
            data: {'id': id,'_token':csrf},
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
					text:  'Message marked unsolved successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#data-table-simple1').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple1').dataTable().fnClearTable();
									var i=1;
									var link = '';
									var status = '';
									$.each(data.details, function(key, value) {
									if(value.solved == 1){
										link ='<a  class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Mark Unsolved" onclick="markunsolved('+value.id+')"   style="margin-right:3px;" id="markunsolvedbtn'+value.id+'"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Solved';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Mark Solved" onclick="marksolved('+value.id+')"   style="margin-right:3px;" id="marksolvedbtn'+value.id+'"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Not Solved';
									}

									 $('#data-table-simple1').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.support_description  : "",
									  ''!=null ? value.company  : "",
									  ''!=null ? value.user  : "",
									  status,
									  link+'<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Reply" style="margin-right:3px;" href="'+server+'/support/reply/'+value.id+'"><i class="fa fa-reply" aria-hidden="true"></i></a>'
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