
$("#message_title").keyup(function(){
	$(this).css("border-color", "");
	var msg = $(this).val();
    var count = msg.length;
    if(count > 50){
    	var msg2 = msg.substr(0, 50);
    	$(this).val(msg2);
    	$("#title").html(msg2);
    }else{
    	$("#title").html(msg);
		$(this).val(msg);
    }

});

$("#message_text").keyup(function(){
	
	$(this).css("border-color", "");
	var msg = $(this).val();
    var count = msg.length;
    if(count > 125){
    	var msg2 = msg.substr(0, 125);
    	$(this).val(msg2);
    	$("#content1").html(msg2);
    }else{
    	$("#content1").html(msg);
		$(this).val(msg);
    }

});

 $( ".link" ).change( function (e) {
	var sites = $(this).val();
	var res = sites.split("|");
	var msg = res[0];
	$(this).css("border-color", "");
	//var msg = $(this).val();
    $(this).val(msg);
	$('#site_idinput').val( res[1]);
	$('#urlinput').val(res[0]);
    $("#url").html(msg);
});
    $('#sendpushbtn').click(function(e) {

	var btn = $(this);
	e.preventDefault();
		$.ajax({
			type:  "post",
			data:  $('#sendCampaignform').serialize(),
			url:   $('#sendCampaignform').attr("action"),
			dataType:  "json",
			beforeSend:  function(){
				btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Sending');
			},
			success:  function(res){
				console.log(res);
				btn.prop("disabled", false).html('<i class="fa fa-send" aria-hidden="true"></i> Send');
				if(res.status == "success"){

					/*$("#message").val('');
					$("#msg-count").val('0');
				  var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#dataTable').dataTable().fnClearTable();

							    var i=1;
								$.each(res.details, function(key, value) {

									 $('#dataTable').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.phone  : "",
									  ''!=null ? value.message  : "",
									  ''!=null ? value.company  : ""
											]);
									i++;
								}); */
					$.gritter.add({
						title: "<strong style='color:#3ec291'>Success!</strong>",
						text: 'The campaign has been sent successfully',
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
				btn.prop("disabled", false).html('<i class="fa fa-send" aria-hidden="true"></i> Send SMS');
				$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text: 'An error occured. Please try again.',
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
			}
		});

}); 