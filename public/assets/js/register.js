
var telInput = $("#tel"),
  errorMsg = $("#error-msg"),
  validMsg = $("#valid-msg");
  telInput1 = $("#tel1"),
  errorMsg1 = $("#error-msg1"),
  frmVerify = $("#step2form"),
  btnVerify = $('#step2btn'),
  frmVerify1 = $("#step4form"),
  btnVerify1 = $('#step4btn'),
  validMsg1 = $("#valid-msg1");

	 function unix_time()
	{
	return parseInt(new Date().getTime().toString().substring(0, 10));
	}
	 function datetime()
	{
		var today = new Date();
		var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
		var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
		return date+' '+time;
	}


var reset = function() {
  telInput.removeClass("error");
  errorMsg.addClass("hide");
  validMsg.addClass("hide");
  telInput.css("border-color", "");
};

var reset1 = function() {
  telInput1.removeClass("error");
  errorMsg1.addClass("hide");
  validMsg1.addClass("hide");
  telInput1.css("border-color", "");
};
// on blur: validate
telInput.blur(function() {
  reset();
  
  if ($.trim(telInput.val())) {
	  telInput.val(telInput.intlTelInput("getNumber"));
    if (telInput.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
   $(':input[type="submit"]').prop('disabled', false);
   } else {
	  $(':input[type="submit"]').prop('disabled', true);
      telInput.addClass("error");
      errorMsg.removeClass("hide");
	  telInput.css("border-color", "red");

    }
  }
});

telInput1.blur(function() {
  reset1();
  if ($.trim(telInput1.val())) {
	 telInput1.val(telInput1.intlTelInput("getNumber"));
    if (telInput1.intlTelInput("isValidNumber")) {
      validMsg1.removeClass("hide");
	  $(':input[type="submit"]').prop('disabled', false);
    } else {
	  $(':input[type="submit"]').prop('disabled', true);
      telInput1.addClass("error");
      errorMsg1.removeClass("hide");
	  telInput1.css("border-color", "red");

    }
  }
});
// on keyup / change flag: reset
telInput.on("keyup change", reset);
telInput1.on("keyup change", reset1);
    $('#superregisterbtn').click(function(e) {

			var btn = $(this);

			var phone =telInput.intlTelInput("getNumber");
			
			var formdata = $('#superregisterform').serializeArray();
			formdata.push({name: "phone",
			value: phone});
			
            $.ajax({
            type: "POST",
            url:  $('#superregisterform').attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Registering <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register'); 
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
					text:  'User added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});
				

				
									var userref = firebase.database().ref("users");
									var newUserRef = userref.push();
							
								newUserRef.set({
									'company_id':data.company_id,
									'user_id':data.user_id,
									'email':data.email,
									'admin':data.admin,
									'password':data.password,
									'active':1,
									'created_at':datetime(),
									'updated_at':datetime(),
									'code':'',
									'confirmed':0,
									'name':data.name,
									'address':'',
									'phone':phone,
									'photo':'',
									'code_expiry_time':unix_time(),
									'last_activity':unix_time(),
									'about':''	
								});	
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';

								$.each(data.details, function(key, value) {
									if(value.active == 1){
										//link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Disable" onclick="superdisableagent('+value.id+')"  id="superdisableagentbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="superdisableagent('+value.id+')" id="superdisableagentbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										//link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Enable" onclick="superenableagent('+value.id+')"  id="superenableagentbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="superenableagent('+value.id+')"  id="superenableagentbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}

									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.company  : "",
									  ''!=null ? value.email  : "",
									  status,
									  //'<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="superedit('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="supereditbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="superedit('+value.id+')" id="supereditbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link
									 // +'<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Login as User" href="'+server+'/login/'+value.id+'" class="btn btn-xs btn-info"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
									 +'<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Login as User" href="'+server+'/impersonateIn/'+value.id+'" class="btn btn-xs btn-info" target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
									]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when registering.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    
e.preventDefault();
});

 function superedit(id){

			var btn =$('#supereditbtn'+id);
			var formdata = $('#superregisterform').serializeArray();
			formdata.push({name: "id",
			value: id});	
 			$.ajax({
            type: "POST",
            url: $('#superregisterform').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');		
            },
			
            cache: false,
            success: function(data) {
			   btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
			   $('#email').val(data.details.email);
			   $('#username').val(data.details.name);
			   $('#id').val(data.details.id);
			   $('#tel1').val(data.details.phone);
               $('#addagentdiv').addClass('hide');
			   $('#editagentdiv').removeClass('hide');
			   $('#usertype option[value="'+data.details.admin+'"]').prop('selected',true);		
			   $('#company1 option[value="'+data.details.company_id+'"]').prop('selected',true);	
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Unable to load the  agent",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});	
						
					}
				});
    

return false;
 }
 
     $('#superedittbtn').click(function(e) {

			var btn = $(this);

			var phone =telInput1.intlTelInput("getNumber");
			
			var formdata = $('#supereditform').serializeArray();
			formdata.push({name: "phone",
			value: phone});
            $.ajax({
            type: "POST",
            url: $("#supereditform").attr("action"),
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
					text:  'User edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				
						var userref = firebase.database().ref("users");
						userref.orderByChild("user_id").equalTo(parseInt(data.user_id)).once("value", function(companysnapshot) {
							
						companysnapshot.forEach(function(companychildsnapshot) {
						
							var UserUpdateRef = firebase.database().ref('users/'+companychildsnapshot.key);	
							UserUpdateRef.update({email:data.email,name:data.name,phone:phone,admin:data.admin,company_id:data.company_id});												
						});
						});
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';

								$.each(data.details, function(key, value) {
									if(value.active == 1){
										//link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Disable" onclick="superdisableagent('+value.id+')"  id="superdisableagentbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="superdisableagent('+value.id+')" id="superdisableagentbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										//link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Enable" onclick="superenableagent('+value.id+')"  id="superenableagentbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="superenableagent('+value.id+')"  id="superenableagentbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}

									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.company  : "",
									  ''!=null ? value.email  : "",
									  status,
									  //'<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="superedit('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="supereditbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="superedit('+value.id+')" id="supereditbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link
									 // +'<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Login as User" href="'+server+'/login/'+value.id+'" class="btn btn-xs btn-info"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
									 +'<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Login as User" href="'+server+'/impersonateIn/'+value.id+'" class="btn btn-xs btn-info" target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
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

 function superdisableagent(id){
var answer = confirm('Are you sure you want to disable this user?');
if (answer)
{
			var btn =$('#superdisableagentbtn'+id);
			var formdata = $('#superregisterform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/user/disable",
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
					text:  'User disabled successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
						var userref = firebase.database().ref("users");
						userref.orderByChild("user_id").equalTo(parseInt(data.user_id)).once("value", function(companysnapshot) {
							
						companysnapshot.forEach(function(companychildsnapshot) {
						
							var UserUpdateRef = firebase.database().ref('users/'+companychildsnapshot.key);	
							UserUpdateRef.update({active:0});												
						});
						});
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';

								$.each(data.details, function(key, value) {
									if(value.active == 1){
										//link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Disable" onclick="superdisableagent('+value.id+')"  id="superdisableagentbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="superdisableagent('+value.id+')" id="superdisableagentbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										//link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Enable" onclick="superenableagent('+value.id+')"  id="superenableagentbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="superenableagent('+value.id+')"  id="superenableagentbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}

									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.company  : "",
									  ''!=null ? value.email  : "",
									  status,
									  //'<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="superedit('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="supereditbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="superedit('+value.id+')" id="supereditbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link
									 // +'<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Login as User" href="'+server+'/login/'+value.id+'" class="btn btn-xs btn-info"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
									 +'<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Login as User" href="'+server+'/impersonateIn/'+value.id+'" class="btn btn-xs btn-info" target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
									]);
									i++;
								}); 
                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when disabling.Please try again",
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
  function superenableagent(id){
var answer = confirm('Are you sure you want to enable this user?');
if (answer)
{
			var btn =$('#superenableagentbtn'+id);
			var formdata = $('#superregisterform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/user/enable",
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
					text:  'Agent enabled successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
					var userref = firebase.database().ref("users");
						userref.orderByChild("user_id").equalTo(parseInt(data.user_id)).once("value", function(companysnapshot) {
							
						companysnapshot.forEach(function(companychildsnapshot) {
						
							var UserUpdateRef = firebase.database().ref('users/'+companychildsnapshot.key);	
							UserUpdateRef.update({active:1});												
						});
						});
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';

								$.each(data.details, function(key, value) {
									if(value.active == 1){
										//link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Disable" onclick="superdisableagent('+value.id+')"  id="superdisableagentbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="superdisableagent('+value.id+')" id="superdisableagentbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										//link ='<a   data-toggle="tooltip" data-placement="top" title="" data-original-title="Enable" onclick="superenableagent('+value.id+')"  id="superenableagentbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="superenableagent('+value.id+')"  id="superenableagentbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}

									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.company  : "",
									  ''!=null ? value.email  : "",
									  status,
									  //'<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" onclick="superedit('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="supereditbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="superedit('+value.id+')" id="supereditbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link
									 // +'<a data-toggle="tooltip" data-placement="top" title="" data-original-title="Login as User" href="'+server+'/login/'+value.id+'" class="btn btn-xs btn-info"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
									 +'<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Login as User" href="'+server+'/impersonateIn/'+value.id+'" class="btn btn-xs btn-info" target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
									]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when enabling.Please try again",
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
    $('#registerbtn').click(function(e) {

			var btn = $(this);

			var phone =telInput.intlTelInput("getNumber");
			
			var formdata = $('#registerform').serializeArray();
			formdata.push({name: "phone",
			value: phone});
            $.ajax({
            type: "POST",
            url: $("#registerform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Registering <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register'); 
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
					text:  'User added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				
								var userref = firebase.database().ref("users");
								var newUserRef = userref.push();
							
								newUserRef.set({
									'company_id':data.company_id,
									'user_id':data.user_id,
									'email':data.email,
									'admin':data.admin,
									'password':data.password,
									'active':1,
									'created_at':datetime(),
									'updated_at':datetime(),
									'code':'',
									'confirmed':0,
									'name':data.name,
									'address':'',
									'phone':phone,
									'photo':'',
									'code_expiry_time':unix_time(),
									'last_activity':unix_time(),
									'about':''	
								});	
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								var usertype ='';
								$.each(data.details, function(key, value) {
									if(value.active == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disableagent('+value.id+')"  id="disableagentbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enableagent('+value.id+')"  id="enableagentbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   if(value.admin == 1){
									   usertype ='Admin';

								   }else{
									   usertype ='Agent';
									   link +='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Login as User" href="'+server+'/login/'+value.id+'" class="btn btn-xs btn-info"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>';
								   }
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.email  : "",
									  usertype,
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editagent('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="editagentbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
										
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when registering.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    
e.preventDefault();
});

 function editagent(id){

			var btn =$('#editagentbtn'+id);

					
			var formdata = $('#registerform').serializeArray();
			formdata.push({name: "id",
			value: id});	
 			$.ajax({
            type: "POST",
            url: $('#registerform').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');		
            },
			
            cache: false,
            success: function(data) {

			   btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
			   $('#email').val(data.details.email);
			   $('#username').val(data.details.name);
			   $('#id').val(data.details.id);
			   $('#tel1').val(data.details.phone);
               $('#addagentdiv').addClass('hide');
			   $('#editagentdiv').removeClass('hide');
			   $('option[value="'+data.details.admin+'"]').prop('selected',true);		

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Unable to load the  agent",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});	
						
					}
				});
    

return false;
 }
 	$(".agent-edit-back").click(function(){
		$("#editagentdiv").addClass("hidden");
		$("#addagentdiv").removeClass("hidden");
	});
	$(".agent-edit-back1").click(function(){
		$("#editagentdiv").addClass("hide");
		$("#addagentdiv").removeClass("hide");
	});
    $('#editagentbtn').click(function(e) {

			var btn = $(this);

			var phone =telInput1.intlTelInput("getNumber");
			
			var formdata = $('#editagentform').serializeArray();
			formdata.push({name: "phone",
			value: phone});
            $.ajax({
            type: "POST",
            url: $("#editagentform").attr("action"),
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
					text:  'User edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});
						var userref = firebase.database().ref("users");
						userref.orderByChild("user_id").equalTo(parseInt(data.user_id)).once("value", function(companysnapshot) {
							
						companysnapshot.forEach(function(companychildsnapshot) {
						
							var UserUpdateRef = firebase.database().ref('users/'+companychildsnapshot.key);	
							UserUpdateRef.update({email:data.email,name:data.name,phone:phone,admin:data.admin});												
						});
						});				
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								var usertype ='';
								$.each(data.details, function(key, value) {
									if(value.active == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disableagent('+value.id+')"  id="disableagentbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enableagent('+value.id+')"  id="enableagentbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   if(value.admin == 1){
									   usertype ='Admin';

								   }else{
									   usertype ='Agent';
									   link +='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Login as User" href="'+server+'/login/'+value.id+'" class="btn btn-xs btn-info"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>';
								   }
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.email  : "",
									  usertype,
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editagent('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="editagentbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
										
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
 function disableagent(id){
var answer = confirm('Are you sure you want to disable this user?');
if (answer)
{
			var btn =$('#disableagentbtn'+id);
			var formdata = $('#registerform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/agents/disable",
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
					text:  'Agent disabled successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
					   
					   var userref = firebase.database().ref("users");
						userref.orderByChild("user_id").equalTo(parseInt(data.user_id)).once("value", function(companysnapshot) {
							
						companysnapshot.forEach(function(companychildsnapshot) {
						
							var UserUpdateRef = firebase.database().ref('users/'+companychildsnapshot.key);	
							UserUpdateRef.update({active:0});												
						});
						});
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								var usertype ='';
								$.each(data.details, function(key, value) {
									if(value.active == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disableagent('+value.id+')"  id="disableagentbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enableagent('+value.id+')"  id="enableagentbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   if(value.admin == 1){
									   usertype ='Admin';

								   }else{
									   usertype ='Agent';
									   link +='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Login as User" href="'+server+'/login/'+value.id+'" class="btn btn-xs btn-info"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>';
								   }
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.email  : "",
									  usertype,
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editagent('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="editagentbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
										
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when disabling.Please try again",
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
 function enableagent(id){
var answer = confirm('Are you sure you want to enable this agent?');
if (answer)
{
			var btn =$('#enableagentbtn'+id);
			var formdata = $('#registerform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/agents/enable",
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
					text:  'Agent enabled successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				var userref = firebase.database().ref("users");
						userref.orderByChild("user_id").equalTo(parseInt(data.user_id)).once("value", function(companysnapshot) {
							
						companysnapshot.forEach(function(companychildsnapshot) {
						
							var UserUpdateRef = firebase.database().ref('users/'+companychildsnapshot.key);	
							UserUpdateRef.update({active:1});												
						});
						});
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								var usertype ='';
								$.each(data.details, function(key, value) {
									if(value.active == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disableagent('+value.id+')"  id="disableagentbtn'+value.id+'" class="btn btn-xs btn-danger" style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enableagent('+value.id+')"  id="enableagentbtn'+value.id+'" class="btn btn-xs btn-success" style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   if(value.admin == 1){
									   usertype ='Admin';

								   }else{
									   usertype ='Agent';
									   link +='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Login as User" href="'+server+'/login/'+value.id+'" class="btn btn-xs btn-info"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>';
								   }
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.email  : "",
									  usertype,
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editagent('+value.id+')"  class="btn btn-info btn-xs" style="margin-right:3px;" id="editagentbtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
										
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when enabling.Please try again",
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
      $('#updateprofilebtn').click(function(e) {

			var btn = $(this);

			var phone =telInput.intlTelInput("getNumber");

			
			var	_file = document.getElementById('photo'); 

			if(_file.files.length === 0){
				
			var formdata= new FormData($('#profileform')[0]);

			}else{
				 var formdata= new FormData($('#profileform')[0]);
				
				formdata.append('photo', _file.files[0]);
			
			}
			formdata.append("phone",phone);
            $.ajax({
            type: "POST",
            url: $("#profileform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Editing <i class="fa fa-spinner fa-spin"></i>');        
            },
		    contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
			
				
                 btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update'); 
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
					text:  'Profile edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
			    $('#email').val(data.details.email);
			    $('#username').val(data.details.name);
			    $('#id').val(data.details.id);
			    $('#phone').val(data.details.phone);
			    $('#address').val(data.details.address);
			    $('#about').val(data.details.about);
				$('#abouttext').text(data.details.about);
				$('#emailtext').text(data.details.email);
				$('#phonetext').text(data.details.phone);
			    $('#addresstext').text(data.details.address);
				$('#profile-username').text(data.details.name);
			
                  $('#profileimage').html('<img src="'+server+'/profile_photos/'+data.details.photo+'?v='+Math.random()+'" class="circle z-depth-2 responsive-img activator gradient-45deg-light-blue-cyan gradient-shadow" alt="User Image">');
				  }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update');
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
     $('#updatecompanyprofilebtn').click(function(e) {

			var btn = $(this);

			var	_file = document.getElementById('file2'); 

			if(_file.files.length === 0){
				
			var formdata= new FormData($('#companyprofileform')[0]);

			}else{
				 var formdata= new FormData($('#companyprofileform')[0]);
				
				formdata.append('file', _file.files[0]);
			
			}
	
            $.ajax({
            type: "POST",
            url: $("#companyprofileform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Editing <i class="fa fa-spinner fa-spin"></i>');        
            },
		    contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
			
				
                 btn.prop("disabled", false).html('<i class="material-icons left">edit</i> Edit'); 
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
					text:  'Company Profile edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
			    $('#username').val(data.details.name);
			    $('#id').val(data.details.id);
				$('#emailtext').text(data.details.email);
				$('#phonetext').text(data.details.phone);
			    $('#addresstext').text(data.details.address);
				}
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="material-icons left">edit</i> Edit');
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
$("#image2").click(function(e) {
$("#file2").click(); 
 e.preventDefault();
});
$("#file2").change(function(){
  $("#file-name2").text(this.files[0].name);
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

    $('#step1btn').click(function(e) {

			var btn = $(this);
			var phone =telInput.intlTelInput("getNumber");

		    var countryData = telInput.intlTelInput("getSelectedCountryData");
			var country = countryData.name;
			if(phone == ''){
				$("#tel").css("border-color", "red");			
			}else if(country === undefined){
				$("#tel").css("border-color", "red");
				$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  'Please select a country',
					sticky: false,
					time: '',
				    class_name: 'gritter-danger'
				});
			}else{
			var formdata = $('#step1form').serializeArray();
			formdata.push({name: "phone",
			value: phone});
			formdata.push({name: "ip",
			value: userip});
			//formdata.push({name: "country_name",
			//value: countryData.name});
            $.ajax({
            type: "POST",
            url: $('#step1form').attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Please wait...');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-sign-in" aria-hidden="true"></i> Proceed'); 
             
			if(data.status=='error'){
					$('#errors').addClass("alert alert-danger").html(data.details);
               }else if(data.status=='account_exists'){
				   
					// $('#step1div').addClass('status');
					// $('#account_exists').removeClass('success');
				 $('#step1div').hide();
				$('#account_exists').show();

                       window.setTimeout(function () {
                           window.location.replace(data.details);
                        }, 10000);
				   }else{
				   
					$('#step1div').hide();
					$('#step1success').show();
					var ref = firebase.database().ref("companies");
					var userref = firebase.database().ref("users");
					if(data.step1=='no'){
                    var newCompanyRef = ref.push();
				    var newUserRef = userref.push();
	

									newCompanyRef.set({
									'company_id':data.company_id,
									'name':'',
									'email':'',
									'api_id':data.api_id,
									'api_key':data.api_key,
									'active':0,
									'created_at':datetime(),
									'updated_at':datetime(),
									'code':data.code,
									'confirmed':1,
									'fname':'',
									'country':country,
									'lname':'',
									'address':'',
									'website':'',
									'company_size':'',
									'phone':phone,
									'logo':'',
									'step':1,
									'paid':0,
									'code_expiry_time':unix_time(),
									'extended_trial_date':''	
									});	
									
									newUserRef.set({
									'company_id':data.company_id,
									'user_id':data.user_id,
									'email':'',
									'admin':1,
									'password':'',
									'active':0,
									'created_at':datetime(),
									'updated_at':datetime(),
									'code':data.code,
									'confirmed':0,
									'fname':'',
									'lname':'',
									'address':'',
									'phone':phone,
									'photo':'',
									'code_expiry_time':unix_time(),
									'last_activity':unix_time(),
									'about':''	
								});	
				   }else if(data.step1=='exists' || data.step3=='exists'){
					   //update
					ref.orderByChild("phone").equalTo(phone).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var NameRef = firebase.database().ref('companies/'+childsnapshot.key);

								NameRef.update({ confirmed:0, code:data.code,code_expiry_time:unix_time()});
						});
						
					}
					});
				   }else{
					   //here
				   }
					 window.setTimeout(function () {
                           window.location.replace(data.details);
                        }, 4000);
				   }
				   
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                 btn.prop("disabled", false).html('<i class="fa fa-sign-in" aria-hidden="true"></i> Proceed'); 
                   $('#errors').addClass("alert alert-danger").html("An error occurred.Please try again");

					}
                });
	}
    
e.preventDefault();
});

$('#company').click(function(e) {
	console.log($(this));
	// $('.active').add();
	$('#cName').show();

});
$('#people').click(function(e) {
	console.log($(this));
	// $('.active').add();
	$('#cName').hide();

});

    $('#registercompanybtn').click(function(e) {

			var btn = $(this);
            $.ajax({
            type: "POST",
            url: $('#step3form').attr("action"),
            data: $('#step3form').serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Please wait...');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-sign-in" aria-hidden="true"></i> Proceed'); 
               if(data.status=='error'){
					$('#errors').addClass("alert alert-danger").html(data.details);
               }else{
					$('#companydiv').addClass('hidden');
					$('#confirmemaildiv').removeClass('hidden');
                       window.setTimeout(function () {
                           window.location.replace(data.details);
                        }, 4000);
                   
				  // }
				  
				   	var ref = firebase.database().ref("companies");
					if(data.step3=='no'){
					ref.orderByChild("phone").equalTo(data.phone).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var NameRef = firebase.database().ref('companies/'+childsnapshot.key);

								NameRef.update({ confirmed:0, step:3, code:data.code, name:$('#name').val(), email:$('#email').val(), lname:$('#lname').val(), fname:$('#fname').val()});
						});
						
					}
					});
					var userref = firebase.database().ref("users");
					userref.orderByChild("phone").equalTo(data.phone).once("value", function(usersnapshot) {
					if(usersnapshot.exists()){
						usersnapshot.forEach(function(userchildsnapshot) {
							var UserNameRef = firebase.database().ref('users/'+userchildsnapshot.key);

								UserNameRef.update({ email:$('#email').val(), password:data.password,admin:1,name:$('#fname').val()+" "+$('#lname').val()});
						});
						
					}
					});
					}else{
										   //update
					ref.orderByChild("phone").equalTo(data.phone).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var NameRef = firebase.database().ref('companies/'+childsnapshot.key);

								NameRef.update({ confirmed:0, code:data.code,code_expiry_time:unix_time()});
						});
						
					}
					});
					}
					}
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-sign-in" aria-hidden="true"></i> Proceed');
                   $('#errors').addClass("alert alert-danger").html("An error occurred when registering.Please try again");

					}
                });
    
e.preventDefault();
});

    $('#completeregistrationbtn').click(function(e) {

			var btn = $(this);

            var form = $("#completeregistrationform");

            $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Registering <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register'); 
               if(data.status=='error'){
					$('#errors1').addClass("alert alert-danger").html(data.details);
               }else{
					$('#companydiv').addClass('hidden');
					$('#confirmemaildiv').addClass('hidden');
					$('#loginsuccessdiv').removeClass('hidden');
                        window.setTimeout(function () {
                           window.location.replace(data.details);
                        }, 1000);

				   }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register');
                   $('#errors1').addClass("alert alert-danger").html("An error occurred when registering.Please try again");

					}
                });
    
e.preventDefault();
});

  $('#changepasswordbtn').click(function(e) {

			var btn = $(this);

            var form = $("#changepasswordform");

            $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Please Wait... <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Password'); 
               if(data.status=='error'){
					$('#errors').addClass("alert alert-danger").html(data.details);
               }else{
					$('#errors').addClass("alert alert-success").html(data.details);

				   }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Password');
                   $('#errors').addClass("alert alert-danger").html("An error occurred when registering.Please try again");

					}
                });
    
e.preventDefault();
});

    $('#changepassbtn').click(function(e) {

			var btn = $(this);

            var form = $("#changepassform");

            $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Please wait... <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-check" aria-hidden="true"></i> Confirm Password Change Request'); 
               if(data.status=='error'){
					$('#errors1').addClass("alert alert-danger").html(data.details);
               }else{
					$('#confirmdiv').addClass('hidden');
					$('#passdiv').removeClass('hidden');
				   }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-check" aria-hidden="true"></i> Confirm Password Change Request');
                   $('#errors1').addClass("alert alert-danger").html("An error occurred.Please try again");

					}
                });
    
e.preventDefault();
});

frmVerify.submit(function(ev){
	
    ev.preventDefault();
    if(check_inputs){
        $.ajax({
            type: frmVerify.attr('method'),
            url: frmVerify.attr('action'),
            data: frmVerify.serialize(),
            cache: false,
            dataType: "json",
            beforeSend: function () {
                btnVerify.prop('disabled', true).html("<i class='fa fa-spinner fa-spin'></i> Please Wait...");
            },
            success: function (data) {
				//alert(data.status);
                btnVerify.prop('disabled', false).html('Verify');
                if (data.status === "success") {
					$('#step2div').addClass('hidden');
					$('#step2success').removeClass('hidden');
                       window.setTimeout(function () {
                           window.location.replace(data.details);
                        }, 4000);
					var ref = firebase.database().ref("companies");
					ref.orderByChild("phone").equalTo(data.phone).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var NameRef = firebase.database().ref('companies/'+childsnapshot.key);

								NameRef.update({ confirmed:1, step:2});
						});
						
					}
					});
                }else{
					$('#errors').addClass("alert alert-danger").html(data.details);
				}

            },
             error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
                $('#errors').addClass("alert alert-danger").html("An error occurred.Please try again");
                btnVerify.prop('disabled', false).html('Verify');
            }
        });
    }
})
$( ".inputsL input" ).keyup( function ( event ) {
	
	if ( $.isNumeric( $( this ).val() ) ) {
       if ( $( this ).next( '.inputsL .inputs' ).length > 0 ) {
           $( this ).next( '.inputsL .inputs' )[ 0 ].focus();
       }else{
           if($(this).next().hasClass("separatoricon")){
               $(this).next().next('.inputsL .inputs')[ 0 ].focus();
           }
       }
       
   }
	
    if ( check_inputs() == false ) {

    } else {

    }
} );
function check_inputs() {


    if ( !$( "#code1" ).val() || !$( "#code2" ).val() || !$( "#code3" ).val() || !$( "#code4" ).val() || !$( "#code5" ).val() || !$( "#code6" ).val() ) {

        return true;

    } else {
        return false;
    }
}

frmVerify1.submit(function(ev){
	
    ev.preventDefault();
    if(check_inputs){
        $.ajax({
            type: frmVerify1.attr('method'),
            url: frmVerify1.attr('action'),
            data: frmVerify1.serialize(),
            cache: false,
            dataType: "json",
            beforeSend: function () {
                btnVerify1.prop('disabled', true).html("<i class='fa fa-spinner fa-spin'></i> Please Wait...");
            },
            success: function (data) {
				//alert(data.status);
                btnVerify1.prop('disabled', false).html('Verify');
                if (data.status === "success") {
					$('#step4div').addClass('hidden');
					$('#step4success').removeClass('hidden');
                       window.setTimeout(function () {
                           window.location.replace(data.details);
                        }, 4000);
					//update
					var ref = firebase.database().ref("companies");
					ref.orderByChild("phone").equalTo(data.phone).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var NameRef = firebase.database().ref('companies/'+childsnapshot.key);

								NameRef.update({ confirmed:1, step:4});
						});
						
					}
					});
                }else{
					$('#errors').addClass("alert alert-danger").html(data.details);
				}

            },
             error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
                $('#errors').addClass("alert alert-danger").html("An error occurred.Please try again");
                btnVerify1.prop('disabled', false).html('Verify');
            }
        });
    }
})
var login_verify_resend_code = false;
$("#login-verify-resend-code").click(function(e){
    var elem = $("#login-verify-resend-code-dets");
    if(login_verify_resend_code == true){
        return;
    }
	if(document.getElementById('step2form')!=null){
		var form=$('#step2form');
	}else{
		var form=$('#step4form');
	}
    $.ajax({
        type: 'post',
        url: server+"/register/resend-code",
		data:form.serialize(),
        dataType: "json",
        beforeSend: function(){
            elem.html('<i class="fa fa-spin fa-spinner"></i>');
            $("#errors").removeClass("alert alert-danger alert-success");
            login_verify_resend_code = true;
        },
		cache: false,
        success: function(res){
            if(res.status == "success"){
				
                $("#errors").addClass("alert alert-success text-center").html('A new authorization code has been sent');
                window.setTimeout(function(){
                    $("#errors").removeClass("alert alert-success").html('');
                }, 4000);
				var ref = firebase.database().ref("companies");
			if(res.step4=='yes'){
										//update
				
					ref.orderByChild("email").equalTo(res.email).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var NameRef = firebase.database().ref('companies/'+childsnapshot.key);

								NameRef.update({ code:res.code});
						});
						
					}
					});
			}else{
										//update
					
					ref.orderByChild("phone").equalTo(res.phone).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var NameRef = firebase.database().ref('companies/'+childsnapshot.key);

								NameRef.update({ code:res.code});
						});
						
					}
					});
			}
            }else if(res.status == "error"){
                $("#errors").addClass("alert alert-danger").html('An error occurred when sending the verification code. Please try again.');
                window.setTimeout(function(){
                   $("#errors").removeClass("alert alert-danger").html('');
                }, 4000);
            }
            elem.html('');
            login_verify_resend_code = false;
        },
        error: function(err){
            $("#errors").addClass("alert alert-danger").html('An error occurred when sending the verification code. Please try again.');
            window.setTimeout(function(){
                $("#errors").removeClass("alert alert-danger").html('');
            }, 4000);
            elem.html('');
            login_verify_resend_code = false;
        }
    });
	e.preventDefault();
});
    $('#mobilenobtn').click(function(e) {

			var btn = $(this);

           
			var phone =telInput.intlTelInput("getNumber");
			var countryData = telInput.intlTelInput("getSelectedCountryData");

			var formdata = $('#mobilenoform').serializeArray();
			formdata.push({name: "phone",
			value: phone});
			
			formdata.push({name: "country_name",
			value: countryData.name});
            $.ajax({
            type: "POST",
            url: $('#mobilenoform').attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Please wait...');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update'); 
               if(data.status=='error'){
				   $('#errors1').addClass("alert alert-danger").html(data.details);
					window.setTimeout(function () {
					$('#errors1').removeClass("alert alert-danger alert-success").html('');
					}, 4000);
			  }else{
				  	$('#errors1').addClass("alert alert-success").html('Mobile Number edited successfully.');
					$('#phone').val(data.phone);
					$('#mobilenospan').html(data.details);
					window.setTimeout(function () {
					$("#myModal").modal('hide');
					$('#errors1').removeClass("alert alert-danger alert-success").html('');
					}, 4000);
					//update
					var ref = firebase.database().ref("companies");
					ref.orderByChild("email").equalTo(data.email).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var NameRef = firebase.database().ref('companies/'+childsnapshot.key);

								NameRef.update({ phone:data.phone,country:countryData.name});
						});
						
					}
					});
					var userref = firebase.database().ref("users");
					userref.orderByChild("email").equalTo(data.email).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var UserNameRef = firebase.database().ref('users/'+childsnapshot.key);

								UserNameRef.update({ phone:data.phone});
						});
						
					}
					});
				   }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                 btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update'); 
                   $('#errors1').addClass("alert alert-danger").html("An error occurred.Please try again");

					}
                });
    
e.preventDefault();
});
    $('#emailbtn').click(function(e) {

			var btn = $(this);

            $.ajax({
            type: "POST",
            url: $('#emailform').attr("action"),
            data: $('#emailform').serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Please wait...');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update'); 
               if(data.status=='error'){
				   $('#errors1').addClass("alert alert-danger").html(data.details);
					window.setTimeout(function () {
					$('#errors1').removeClass("alert alert-danger alert-success").html('');
					}, 4000);
			  }else{
				  	$('#errors1').addClass("alert alert-success").html('Email edited successfully.');
					$('#email').val(data.details);
					$('#emailspan').html(data.details);
					window.setTimeout(function () {
					$("#myModal").modal('hide');
					$('#errors1').removeClass("alert alert-danger alert-success").html('');
					}, 4000);
						//update
					var ref = firebase.database().ref("companies");
					//alert(data.details+" "+data.phone);
					ref.orderByChild("phone").equalTo(data.phone).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var NameRef = firebase.database().ref('companies/'+childsnapshot.key);

								NameRef.update({ email:data.details});
						});
						
					}
					});
					var userref = firebase.database().ref("users");
					userref.orderByChild("phone").equalTo(data.phone).once("value", function(snapshot) {
					if(snapshot.exists()){
						snapshot.forEach(function(childsnapshot) {
							var UserNameRef = firebase.database().ref('users/'+childsnapshot.key);

								UserNameRef.update({ email:data.details});
						});
						
					}
					});
				   }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                 btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update'); 
                   $('#errors1').addClass("alert alert-danger").html("An error occurred.Please try again");

					}
                });
    
e.preventDefault();
});
    $('#registersuperadminbtn').click(function(e) {

			var btn = $(this);

			var phone =telInput.intlTelInput("getNumber");
			
			var formdata = $('#registersuperadminform').serializeArray();
			formdata.push({name: "phone",
			value: phone});
            $.ajax({
            type: "POST",
            url: $("#registersuperadminform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Registering <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register'); 
               if(data.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  data.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
				   				   var userref = firebase.database().ref("users");
									var newUserRef = userref.push();
							
								newUserRef.set({
									'company_id':0,
									'user_id':data.user_id,
									'email':data.email,
									'admin':1,
									'password':data.password,
									'active':1,
									'created_at':datetime(),
									'updated_at':datetime(),
									'code':'',
									'confirmed':0,
									'name':data.name,
									'address':'',
									'phone':phone,
									'photo':'',
									'code_expiry_time':unix_time(),
									'last_activity':unix_time(),
									'about':''	
								});	
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'Admin added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								var usertype ='';
								$.each(data.details, function(key, value) {
									if(value.active == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disablesuperadmin('+value.id+')" id="disablesuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enablesuperadmin('+value.id+')"  id="enablesuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}

									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.email  : "",
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editsuperadmin('+value.id+')" id="editsuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register');
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
 function editsuperadmin(id){

			var btn =$('#editsuperadminbtn'+id);	
			var formdata = $('#registersuperadminform').serializeArray();
			formdata.push({name: "id",
			value: id});	
 			$.ajax({
            type: "POST",
            url: $('#registersuperadminform').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');		
            },
			
            cache: false,
            success: function(data) {

			   btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
			   $('#email').val(data.details.email);
			   $('#username').val(data.details.name);
			   $('#id').val(data.details.id);
			   $('#tel1').val(data.details.phone);
               $('#addagentdiv').addClass('hide');
			   $('#editagentdiv').removeClass('hide');
			   $('option[value="'+data.details.admin+'"]').prop('selected',true);		

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Unable to load the  administrator details",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});	
						
					}
				});
    

return false;
 }
     $('#editsuperadminbtn').click(function(e) {

			var btn = $(this);

			var phone =telInput1.intlTelInput("getNumber");
			
			var formdata = $('#editsuperadminform').serializeArray();
			formdata.push({name: "phone",
			value: phone});
            $.ajax({
            type: "POST",
            url: $("#editsuperadminform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Editing...');        
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
					text:  'Admin edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
					var userref = firebase.database().ref("users");
						userref.orderByChild("user_id").equalTo(parseInt(data.user_id)).once("value", function(companysnapshot) {
							
						companysnapshot.forEach(function(companychildsnapshot) {
						
							var UserUpdateRef = firebase.database().ref('users/'+companychildsnapshot.key);	
							UserUpdateRef.update({email:data.email,name:data.name,phone:phone});												
						});
						});	
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								var usertype ='';
								$.each(data.details, function(key, value) {
									if(value.active == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disablesuperadmin('+value.id+')" id="disablesuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enablesuperadmin('+value.id+')"  id="enablesuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}

									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.email  : "",
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editsuperadmin('+value.id+')" id="editsuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit');
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
 function disablesuperadmin(id){
var answer = confirm('Are you sure you want to disable this super administrator?');
if (answer)
{
			var btn =$('#disablesuperadminbtn'+id);
			var formdata = $('#registersuperadminform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/super-admins/disable",
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
					text:  'Super admin disabled successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
						var userref = firebase.database().ref("users");
						userref.orderByChild("user_id").equalTo(parseInt(data.user_id)).once("value", function(companysnapshot) {
							
						companysnapshot.forEach(function(companychildsnapshot) {
						
							var UserUpdateRef = firebase.database().ref('users/'+companychildsnapshot.key);	
							UserUpdateRef.update({active:0});												
						});
						});
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								var usertype ='';
								$.each(data.details, function(key, value) {
									if(value.active == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disablesuperadmin('+value.id+')" id="disablesuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enablesuperadmin('+value.id+')"  id="enablesuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}

									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.email  : "",
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editsuperadmin('+value.id+')" id="editsuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when disabling.Please try again",
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
 
  function enablesuperadmin(id){
var answer = confirm('Are you sure you want to enable this super admin ?');
if (answer)
{
			var btn =$('#enablesuperadminbtn'+id);
			var formdata = $('#editsuperadminform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/super-admins/enable",
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
				      var userref = firebase.database().ref("users");
						userref.orderByChild("user_id").equalTo(parseInt(data.user_id)).once("value", function(companysnapshot) {
							
						companysnapshot.forEach(function(companychildsnapshot) {
						
							var UserUpdateRef = firebase.database().ref('users/'+companychildsnapshot.key);	
							UserUpdateRef.update({active:1});												
						});
						});
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'Super admin enabled successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								var usertype ='';
								$.each(data.details, function(key, value) {
									if(value.active == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disablesuperadmin('+value.id+')" id="disablesuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enablesuperadmin('+value.id+')"  id="enablesuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}

									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.email  : "",
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="editsuperadmin('+value.id+')" id="editsuperadminbtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link	
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

 