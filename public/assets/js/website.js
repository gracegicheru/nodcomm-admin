var telInput = $("#tel"),
  errorMsg = $("#error-msg"),
  telInput1 = $("#tel1"),
  errorMsg1 = $("#error-msg1"),
  validMsg1 = $("#valid-msg1")
  validMsg = $("#valid-msg");

var reset = function() {
  telInput.removeClass("error");
  errorMsg.addClass("hide");
  validMsg.addClass("hide");
  telInput.css("border-color", "");
};

// on blur: validate
telInput.blur(function() {
  reset();
  if ($.trim(telInput.val())) {
    if (telInput.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
    } else {

      telInput.addClass("error");
      errorMsg.removeClass("hide");
	  telInput.css("border-color", "red");

    }
  }
});

// on keyup / change flag: reset
	telInput.on("keyup change", reset);
	var reset1 = function() {
  telInput1.removeClass("error");
  errorMsg1.addClass("hide");
  validMsg1.addClass("hide");
  telInput1.css("border-color", "");
};

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
telInput1.on("keyup change", reset1);
var resetemail1 = function() {
  $("#email").removeClass("error");
  $("#error-email1").addClass("hide");
  $("#valid-email1").addClass("hide");
  $("#email").css("border-color", "");
};
$("#email").blur(function() {
  resetemail1();
  if ($.trim($("#email").val())) {
	if(validateEmail($("#email").val())) {
     $("#valid-email1").removeClass("hide");
    } else {
      $("#email").addClass("error");
      $("#error-email1").removeClass("hide");
	  $("#email").css("border-color", "red");
    }
  }
});
var resetemail = function() {
  $("#email1").removeClass("error");
  $("#error-email").addClass("hide");
  $("#valid-email").addClass("hide");
  $("#email1").css("border-color", "");
};
$("#email1").blur(function() {
  resetemail();
  if ($.trim($("#email1").val())) {
	if(validateEmail($("#email1").val())) {
     $("#valid-email").removeClass("hide");
    } else {
      $("#email1").addClass("error");
      $("#error-email").removeClass("hide");
	  $("#email1").css("border-color", "red");
    }
  }
});
$("#email1").on("keyup change", resetemail);
$("#email").on("keyup change", resetemail1);
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};
    
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
    $('#addwebsitebtn').click(function(e) {

						var btn = $(this);

						var phone =telInput.intlTelInput("getNumber");
						var countryData = telInput.intlTelInput("getSelectedCountryData");
						var name = $('#name1').val();
						var website = $('#website1').val();
						var company_size = $('#company_size1').val();
						var fname = $('#fname1').val();
						var lname = $('#lname1').val();
						var email = $('#email1').val();
						var phone =telInput.intlTelInput("getNumber");
						var country = countryData.name;
						var address = $('#address1').val();
			var formdata = $('#addwebsiteform').serializeArray();
			formdata.push({name: "phone",
			value: phone});
			
			/*formdata.push({name: "country_name",
			value: countryData.name});*/
			formdata.push({name: "ip",
			value: userip});
			alert(userip);
            $.ajax({
            type: "POST",
            url:$("#addwebsiteform").attr("action"),
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
					text:  'Company registered successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
					
				});				
								var ref = firebase.database().ref("companies");
								var userref = firebase.database().ref("users");
								var newCompanyRef = ref.push();
							    var newUserRef = userref.push();
									newCompanyRef.set({
									'company_id':data.company_id,
									'name':name,
									'email':email,
									'api_id':data.api_id,
									'api_key':data.api_key,
									'active':1,
									'created_at':datetime(),
									'updated_at':datetime(),
									'code':data.code,
									'confirmed':1,
									'fname':fname,
									'country':country,
									'lname':lname,
									'address':address,
									'website':website,
									'company_size':company_size,
									'phone':phone,
									'logo':'',
									'step':4,
									'paid':1,
									'code_expiry_time':unix_time(),
									'extended_trial_date':''	
									});	
									
									newUserRef.set({
									'company_id':data.company_id,
									'user_id':data.user_id,
									'email':email,
									'admin':1,
									'password':data.password,
									'active':1,
									'created_at':datetime(),
									'updated_at':datetime(),
									'code':data.code,
									'confirmed':1,
									//'fname':fname,
									//'lname':lname,
									'name':fname+" "+lname,
									'address':address,
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
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disablewebsite('+value.id+')"  id="disablewebsitebtn'+value.id+'"  style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enablewebsite('+value.id+')"  id="enablewebsitebtn'+value.id+'"  style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.website  : "",
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="return editwebsite('+value.id+',\''+value.name+'\''+',\''+value.company_size+'\''+',\''+ value.website +'\''+',\''+ value.fname+'\''+',\''+value.lname+'\''+',\''+value.email+'\''+',\''+value.phone+'\''+',\''+value.address+'\')"  style="margin-right:3px;" id="editwebsitebtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link+
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="View" onclick="viewwebsite('+value.id+')"   style="margin-right:3px;" id="viewwebsitebtn'+value.id+'"><i class="fa fa-eye" aria-hidden="true"></i></a>'
									  +'<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Login as Company" href="'+server+'/admin/login/'+value.id+'"  target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
											]);
									i++;
								}); 

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-plus" aria-hidden="true"></i> Register');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred while registering.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    
e.preventDefault();
});

  function editwebsite(id,name,company_size,website, fname, lname, email, phone, address){
    
	$('#name').val(name);
    $('#website').val(website);
    $('#id').val(id);
    $('#fname').val(fname);
	$('#lname').val(lname);
	$('#tel1').val(phone);
	$('#email').val(email);
	$('#address').val(address);
	$('option[value="'+company_size+'"]').prop('selected',true);
    $('#addwebsitediv').addClass('hide');
    $('#editwebsitediv').removeClass('hide');
	$('#viewwebsitediv').addClass('hide');		
	$(".company-wrapper").slideToggle("slow");
   return false;
 }
 	$(".website-edit-back").click(function(){
		$("#editwebsitediv").addClass("hide");
		$("#addwebsitediv").removeClass("hide");
		$('#viewwebsitediv').addClass('hide');
	});
	$(".website-edit-back1").click(function(){
		$("#editwebsitediv").addClass("hide");
		$("#addwebsitediv").removeClass("hide");
		$('#viewwebsitediv').addClass('hide');
	});
    $('#editwebsitebtn').click(function(e) {

			var btn = $(this);

            var form = $("#editwebsiteform");
						var countryData = telInput1.intlTelInput("getSelectedCountryData");
						var name = $('#name').val();
						var website = $('#website').val();
						var company_size = $('#company_size').val();
						var fname = $('#fname').val();
						var lname = $('#lname').val();
						var email = $('#email').val();
						var phone =telInput1.intlTelInput("getNumber");
						var country = countryData.name;
						var address = $('#address').val();
           var formdata = $('#editwebsiteform').serializeArray();
		   formdata.push({name: "phone",
			value: phone});
			
			formdata.push({name: "country_name",
			value: countryData.name});
		   $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('editing <i class="fa fa-spinner fa-spin"></i>');        
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
					text:  'Company edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
						var id = $('#id').val();
						var ref = firebase.database().ref("companies");
						var userref = firebase.database().ref("users");
						ref.orderByChild("company_id").equalTo(parseInt(id)).once("value", function(usersnapshot) {
							
						usersnapshot.forEach(function(userchildsnapshot) {
							var UpdateRef = firebase.database().ref('companies/'+userchildsnapshot.key);	
							UpdateRef.update({ name:name, email:email,fname:fname,lname:lname,country:country,address:address,website:website,company_size:company_size,phone:phone});												
						});
						});

						userref.orderByChild("company_id").equalTo(parseInt(id)).once("value", function(companysnapshot) {
							
						companysnapshot.forEach(function(companychildsnapshot) {
						
							var UserUpdateRef = firebase.database().ref('users/'+companychildsnapshot.key);	
							UserUpdateRef.update({email:email,name:fname+" "+lname,address:address,phone:phone});												
						});
						});
				///
				  var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								var link = '';
								var status = '';
								$.each(data.details, function(key, value) {
									if(value.active == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disablewebsite('+value.id+')"  id="disablewebsitebtn'+value.id+'"  style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enablewebsite('+value.id+')"  id="enablewebsitebtn'+value.id+'"  style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.website  : "",
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="return editwebsite('+value.id+',\''+value.name+'\''+',\''+value.company_size+'\''+',\''+ value.website +'\''+',\''+ value.fname+'\''+',\''+value.lname+'\''+',\''+value.email+'\''+',\''+value.phone+'\''+',\''+value.address+'\')"  style="margin-right:3px;" id="editwebsitebtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link+
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="View" onclick="viewwebsite('+value.id+')"   style="margin-right:3px;" id="viewwebsitebtn'+value.id+'"><i class="fa fa-eye" aria-hidden="true"></i></a>'
									  +'<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Login as Company" href="'+server+'/admin/login/'+value.id+'"  target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
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
 function disablewebsite(id){
var answer = confirm('Are you sure you want to disable this company?');
if (answer)
{
			var btn =$('#disablewebsitebtn'+id);
			var formdata = $('#addwebsiteform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/admin/company/disable",
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
					text:  'Company disabled successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
						var ref = firebase.database().ref("companies");
						var userref = firebase.database().ref("users");
						ref.orderByChild("company_id").equalTo(parseInt(id)).once("value", function(usersnapshot) {
							
						usersnapshot.forEach(function(userchildsnapshot) {
							var UpdateRef = firebase.database().ref('companies/'+userchildsnapshot.key);	
							UpdateRef.update({ active:0});												
						});
						});

						userref.orderByChild("company_id").equalTo(parseInt(id)).once("value", function(companysnapshot) {
							
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
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disablewebsite('+value.id+')"  id="disablewebsitebtn'+value.id+'"  style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enablewebsite('+value.id+')"  id="enablewebsitebtn'+value.id+'"  style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.website  : "",
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="return editwebsite('+value.id+',\''+value.name+'\''+',\''+value.company_size+'\''+',\''+ value.website +'\''+',\''+ value.fname+'\''+',\''+value.lname+'\''+',\''+value.email+'\''+',\''+value.phone+'\''+',\''+value.address+'\')"  style="margin-right:3px;" id="editwebsitebtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link+
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="View" onclick="viewwebsite('+value.id+')"   style="margin-right:3px;" id="viewwebsitebtn'+value.id+'"><i class="fa fa-eye" aria-hidden="true"></i></a>'
									  +'<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Login as Company" href="'+server+'/admin/login/'+value.id+'"  target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
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
 function enablewebsite(id){
var answer = confirm('Are you sure you want to enable this company?');
if (answer)
{
			var btn =$('#enablewebsitebtn'+id);
			var formdata = $('#addwebsiteform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/admin/company/enable",
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
					text:  'Company enabled successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
										var ref = firebase.database().ref("companies");
						var userref = firebase.database().ref("users");
						ref.orderByChild("company_id").equalTo(parseInt(id)).once("value", function(usersnapshot) {
							
						usersnapshot.forEach(function(userchildsnapshot) {
							var UpdateRef = firebase.database().ref('companies/'+userchildsnapshot.key);	
							UpdateRef.update({ active:1});												
						});
						});

						userref.orderByChild("company_id").equalTo(parseInt(id)).once("value", function(companysnapshot) {
							
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
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Disable" onclick="disablewebsite('+value.id+')"  id="disablewebsitebtn'+value.id+'"  style="margin-right:3px;" ><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Active';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Enable" onclick="enablewebsite('+value.id+')"  id="enablewebsitebtn'+value.id+'"  style="margin-right:3px;" ><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Inactive';
									}
								   
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.name  : "",
									  ''!=null ? value.website  : "",
									  status,
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Edit" onclick="return editwebsite('+value.id+',\''+value.name+'\''+',\''+value.company_size+'\''+',\''+ value.website +'\''+',\''+ value.fname+'\''+',\''+value.lname+'\''+',\''+value.email+'\''+',\''+value.phone+'\''+',\''+value.address+'\')"  style="margin-right:3px;" id="editwebsitebtn'+value.id+'"><i class="fa fa-pencil" aria-hidden="true"></i></a>'+link+
									  '<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="View" onclick="viewwebsite('+value.id+')"   style="margin-right:3px;" id="viewwebsitebtn'+value.id+'"><i class="fa fa-eye" aria-hidden="true"></i></a>'
									  +'<a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Login as Company" href="'+server+'/admin/login/'+value.id+'"  target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a>'
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
 
  function viewwebsite(id){

			var btn =$('#viewwebsitebtn'+id);

					
			var formdata = $('#addwebsiteform').serializeArray();
			formdata.push({name: "id",
			value: id});	
 			$.ajax({
            type: "POST",
            url: $('#addwebsiteform').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {

      		btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');		
            },
			
            cache: false,
            success: function(data) {

			   btn.prop("disabled", false).html('<i class="fa fa-eye" aria-hidden="true"></i>');
			   $('#api_id').html(data.details.api_id);
			   $('#api_key').html(data.details.api_key);
			   $('#websitetitle').html(data.details.name+' API');
               $('#addwebsitediv').addClass('hide');
			   $('#editwebsitediv').addClass('hide');
			   $('#viewwebsitediv').removeClass('hide');	

					},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-eye" aria-hidden="true"></i>');
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "Unable to load the  company API",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});	
						
					}
				});
    

return false;
 }
	$(".addcompany").click(function(){
		$(".company-wrapper").slideToggle("slow");
		$(this).addClass("hide");
	}); 
		$(".close-companies").click(function(){
		$(".company-wrapper").slideToggle("slow");
		$(".addcompany").removeClass("hide");
	});
 