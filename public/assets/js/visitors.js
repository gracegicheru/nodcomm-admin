	$(document).on("click", ".v-dets", function(){
	
		var data = $(this).data("visitor");
		
		var location = "";
		var visits = "";
		var chats = "";

		if(data.city != "" && data.region != "" && data.country != ""){
			location = data.city + "," + data.region + "," + data.country;
		}else if(data.city == "" && data.region != "" && data.country != ""){
			location = data.region + "," + data.country;
		}else if(data.city != "" && data.region == "" && data.country != ""){
			location = data.city + "," + data.country;
		}else if(data.city == "" && data.region == "" && data.country != ""){
			location = data.country;
		}else{
			location = data.city + "," + data.region + "," + data.country;
		}

		if(data.chats == 0){
			chats = "0 chats";
		}else if(data.chats == 1){
			chat = "1 chat";
		}else{
			chat = data.chats + " chats";
		}

		if(data.visits == 0){
			visits = "0 visits";
		}else if(data.visits == 1){
			visits = "1 visit";
		}else{
			visits = data.visits + " visits";
		}

		$("#visitor-ip").html(data.ip);
		$("#visitor-location").html(location);
		$("#visitor-where-from").html(data.current_page);
		$("#visitor-visits").html(visits);
		$("#visitor-chats").html(chats);
		$("#visitor-browser").html(data.browser);
		$("#visitor-os").html(data.os);
		//$("#").html(data.);

		$(".visitor-details-container").show();
	});
		$(document).on("click", ".online-v-dets", function(){
	
		var data = JSON.parse(decodeURIComponent($(this).data("visitor")));
	
		var location = "";
		var visits = "";
		var chats = "";

		if(data.city != "" && data.region != "" && data.country != ""){
			location = data.city + "," + data.region + "," + data.country;
		}else if(data.city == "" && data.region != "" && data.country != ""){
			location = data.region + "," + data.country;
		}else if(data.city != "" && data.region == "" && data.country != ""){
			location = data.city + "," + data.country;
		}else if(data.city == "" && data.region == "" && data.country != ""){
			location = data.country;
		}else{
			location = data.city + "," + data.region + "," + data.country;
		}

		if(data.chats == 0){
			chats = "0 chats";
		}else if(data.chats == 1){
			chat = "1 chat";
		}else{
			chat = data.chats + " chats";
		}

		if(data.visits == 0){
			visits = "0 visits";
		}else if(data.visits == 1){
			visits = "1 visit";
		}else{
			visits = data.visits + " visits";
		}

		$("#visitor-ip").html(data.ip);
		$("#visitor-location").html(location);
		$("#visitor-where-from").html(data.current_page);
		$("#visitor-visits").html(visits);
		$("#visitor-chats").html(chats);
		$("#visitor-browser").html(data.browser);
		$("#visitor-os").html(data.os);
		//$("#").html(data.);

		$(".visitor-details-container").show();
	});
	 function assignagent(id){

	$('#id').val(id);

	return false;
 }
     $('#assignagentbtn').click(function(e) {

			var btn = $(this);

            var form = $("#assignagentform");

            $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Assigning <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {

                 btn.prop("disabled", false).html('<i class="fa fa-user-plus" aria-hidden="true"></i> Assign Agent'); 
               if(data.status=='error'){

				$("#error").addClass("alert alert-danger").html(data.details);
				
               }else{
				   $("#myModal").modal('hide');
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'Agent assigned  successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#dataTable').dataTable().fnClearTable();


								var ip='';
								$.each(data.details, function(key, value) {

									ip +='<span style="padding-right: 5px;"><img style="width:20px;height:20px;" src="'+value.flag+'"></span>';
									ip +=' <span>'+value.ip+'</span>';
									ip +='<span><a class="online-v-dets" data-visitor="'+encodeURIComponent(JSON.stringify(value))+'">Details</a></span>';
									 $('#dataTable').dataTable().fnAddData([
						  
									  '<i class="fa fa-user" style="color:green;"></i>',
									  ''!=null ? ip : "",
									  ''!=null ? value.current_page  : "",
									  ''!=null ? value.visits  : "",
									  ''!=null ? value.chats  : "",
									  '<a onclick="assignagent('+value.id+')" class="btn btn-info btn-sm "   data-toggle="modal" data-target="#myModal"><i class="fa fa-user-plus" aria-hidden="true"></i> Assign Agent</a>'
											]);
								
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					$("#error").addClass("alert alert-danger").html('An error occurred when assigning an agent.Please try again');
                    btn.prop("disabled", false).html('<i class="fa fa-user-plus" aria-hidden="true"></i> Assign Agent');

					}
                });
    
e.preventDefault();
});
     $('.assignagentbtn').click(function(e) {

			var btn = $(this);

            var form = $("#pickagentform");

            $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Picking <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {

                 btn.prop("disabled", false).html('<i class="fa fa-user-plus" aria-hidden="true"></i> Pick Visitor'); 
               if(data.status=='error'){

				$("#error").addClass("alert alert-danger").html(data.details);
				
               }else{
				   $("#myModal").modal('hide');
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'Visitor picked  successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#dataTable').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#dataTable').dataTable().fnClearTable();


								var ip='';
								$.each(data.details, function(key, value) {

									ip +='<span style="padding-right: 5px;"><img style="width:20px;height:20px;" src="'+value.flag+'"></span>';
									ip +=' <span>'+value.ip+'</span>';
									ip +='<span><a class="online-v-dets" data-visitor="'+encodeURIComponent(JSON.stringify(value))+'">Details</a></span>';
									 $('#dataTable').dataTable().fnAddData([
						  
									  '<i class="fa fa-user" style="color:green;"></i>',
									  ''!=null ? ip : "",
									  ''!=null ? value.current_page  : "",
									  ''!=null ? value.visits  : "",
									  ''!=null ? value.chats  : "",
									  '<a  class="btn btn-info btn-sm assignagentbtn"  ><i class="fa fa-user-plus" aria-hidden="true"></i> Pick Visitor</a>'
											]);
								
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					$("#error").addClass("alert alert-danger").html('An error occurred when assigning an agent.Please try again');
                    btn.prop("disabled", false).html('<i class="fa fa-user-plus" aria-hidden="true"></i> Pick Visitor');

					}
                });
    
e.preventDefault();
});