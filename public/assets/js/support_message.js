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
			success:  function(data){
		
				if(data.status == "success"){
					btn.prop("disabled", false).html('<i class="fa fa-send" aria-hidden="true"></i> Send');
					$("#message").val('');
					var div='<div class="row msg_container base_sent"><div class="col s10"><div class="messages msg_sent"><p style="color:blue;">Support #'+data.details.user+'</p><p>'+data.details.description+'</p>';
					div+='<p class="time_date"><span>Sent: </span>'+data.details.time+'</p></div></div><div class="col s2 avatar"><i class="fa fa-user" aria-hidden="true"></i></div></div>';
					$("#chatdiv").append(div);	
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
					text:  data.details,
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
 