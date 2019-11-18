var telInput = $("#tel"),
  errorMsg = $("#error-msg"),
  validMsg = $("#valid-msg"),
  telInput1 = $("#tel1"),
  errorMsg1 = $("#error-msg1"),
  validMsg1 = $("#valid-msg1"),
  telInput2 = $("#tel2"),
  errorMsg2 = $("#error-msg2"),
  validMsg2 = $("#valid-msg2");

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
var reset2 = function() {
  telInput2.removeClass("error");
  errorMsg2.addClass("hide");
  validMsg2.addClass("hide");
  telInput2.css("border-color", "");
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
telInput2.blur(function() {
  reset2();
  if ($.trim(telInput2.val())) {
	 telInput2.val(telInput2.intlTelInput("getNumber"));
    if (telInput2.intlTelInput("isValidNumber")) {
      validMsg2.removeClass("hide");
	  $(':input[type="submit"]').prop('disabled', false);
    } else {
	  $(':input[type="submit"]').prop('disabled', true);
      telInput2.addClass("error");
      errorMsg2.removeClass("hide");
	  telInput2.css("border-color", "red");

    }
  }
});
// on keyup / change flag: reset
telInput.on("keyup change", reset);
telInput1.on("keyup change", reset1);
telInput2.on("keyup change", reset2);
$("#message").keyup(function(){
	$(this).css("border-color", "");
	var msg = $(this).val();
    var count = msg.length;
    if(count > 80){
    	var msg2 = msg.substr(0, 80);
    	$(this).val(msg2);
    	$("#msg-count").html(80);
    }else{
    	$("#msg-count").html(count);
    }

});
$("#sendSMSform").submit(function(evt){
	
	evt.preventDefault();
    
	var btn = $("#sendSMSbtn"),
		form = $(this),
		txt = $("#message").val();
		var formdata = form.serializeArray();
  if($("#mobile_numbers_div").hasClass("hide")){
		
		formdata.push({name: "contact_name",value: $("#contact").val()});
	}
	if($("#tel").val() =='' && $("#contactdiv").hasClass("hide")){
		
		$("#tel").css("border-color", "red");
	}
	else if(txt == '' ){
		
		$("#message").css("border-color", "red");
	}else{
			if($("#mobile_numbers_div").hasClass("hide")){
				var phone = $("#contact").val();
			}
			else if ($("#phonesdiv1").hasClass("hide")) {
				var phone = telInput.val();
			}else{
				var phone = $("#mobilenos1").text();
			}
			
			formdata.push({name: "phone",
			value: phone});
		$.ajax({
			type:  "post",
			data:  formdata,
			url:   form.attr("action"),
			dataType:  "json",
			beforeSend:  function(){
				btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Sending');
			},
			success:  function(res){
				console.log("response", res);
				if(res.status == "success"){
					btn.prop("disabled", false).html('<i class="fa fa-send" aria-hidden="true"></i> Send SMS');
					$("#message").val('');
					$("#msg-count").val('0');
				 /* var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								$.each(res.details, function(key, value) {
									if((value.message).length > 30){
									var message = '<p>'+(value.message).substr(0, 30)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(30, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
								   }else{
									var message = value.message;    
									}
									 $('#data-table-simple').dataTable().fnAddData([
						  
									  ''!=null ? i : "",
									  ''!=null ? value.phone  : "",
									  ''!=null ? message  : "",
									  ''!=null ? value.company  : ""
											]);
									i++;
								}); */
					$.gritter.add({
						title: "<strong style='color:#3ec291'>Success!</strong>",
						text: 'The message has been sent successfully',
						sticky: false,
						time: '',
						class_name: 'gritter-success'
					});
					 //location.reload(true);
					$('#tel').val('');
					//$('#sendSMSform').val('');
					 				}else{
					btn.prop("disabled", false).html('<i class="fa fa-send" aria-hidden="true"></i> Send SMS');
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
					text: 'An error occured when sending the message. Please try again.',
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
			}
		});
	}
}); 
// Hide the extra content initially, using JS so that if JS is disabled, no problemo:
$('.read-more-content').addClass('hide')
$('.read-more-show, .read-more-hide').removeClass('hide')

// Set up the toggle effect:
$(document).on("click", ".read-more-show", function(e){
//$('.read-more-show').on('click', function(e) {
  $(this).next('.read-more-content').removeClass('hide');
  $(this).addClass('hide');
  e.preventDefault();
});

$(document).on("click", ".read-more-hide", function(e){
//$('.read-more-hide').on('click', function(e) {
  var p = $(this).parent('.read-more-content');
  p.addClass('hide');
  p.prev('.read-more-show').removeClass('hide'); // Hide only the preceding "Read More"
  e.preventDefault();
});
$('#tel1').keypress(function (e) {
    if ($.trim(telInput1.val())) {
	 telInput1.val(telInput1.intlTelInput("getNumber"));
    if (telInput1.intlTelInput("isValidNumber")) {
      validMsg1.removeClass("hide");
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
	   $('#phonesdiv').removeClass('hide');
	   $('#mobilenos').append(','+$('#tel1').val());
	   $('#phonesdiv').append('<div id="chip" class="chip cyan white-text">'+$('#tel1').val()+'<i class="material-icons close">close</i></div>');
		telInput1.val('');
		return false;  
	  }
    }
  }
});
    $('#contactgroupbtn').click(function(e) {
		e.preventDefault();
			if ($("#phonesdiv").hasClass("hide")) {
				var phone = telInput1.val();
			}else{
				var phone = $("#mobilenos").text();
			}
			var btn = $(this);
			var formdata = $('#contactgroupform').serializeArray();
			formdata.push({name: "phone",
			value: phone});
			
            $.ajax({
            type: "POST",
            url:  $('#contactgroupform').attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> adding');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="material-icons left">add</i>  Add Group'); 
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
					text:  'Contact group added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});
				   window.location.reload(true);
				

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="material-icons left">add</i>  Add Group');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when adding.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    

});
  $('#sent_to_group').click(function(e) {
	  $('#mobile_numbers_div').addClass('hide');
	  $('#contactdiv').removeClass('hide');
	  e.preventDefault();
  });
  $('#tel').keypress(function (e) {
    if ($.trim(telInput.val())) {
	 telInput.val(telInput.intlTelInput("getNumber"));
    if (telInput.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
	   $('#phonesdiv1').removeClass('hide');
	   $('#mobilenos1').append(','+$('#tel').val());
	   $('#phonesdiv1').append('<div  class="chip cyan white-text">'+$('#tel').val()+'<i class="material-icons close">close</i></div>');
		telInput.val('');
		return false;  
	  }
    }
  }
});

$(document).on('click', ".chip", function(e) {
	e.preventDefault();
	var str = $('#phonesdiv1').text();
	var res = str.replace(/close/g, ',');
	$('#mobilenos1').html(res);
    
});
$(document).on('click', "#chip", function(e) {
	e.preventDefault();
	var str = $('#phonesdiv').text();
	var res = str.replace(/close/g, ',');
	$('#mobilenos').html(res);
});
 function editgroup(id, name, phones){
$('#mobilenos').html(' ');
$('#phonesdiv').html(' ');
$('#contact_name').val(name);
$('#id').val(id);
var stringValue = phones.toString();
var edited = stringValue.replace(/^,|,$/g,'');

$('#phonesdiv').removeClass('hide');
$.each(edited.split(","), function(i, val) {
  val = $.trim(val);
	   $('#mobilenos').append(','+val);
	   $('#phonesdiv').append('<div id="chip1" class="chip cyan white-text">'+val+'<i class="material-icons close">close</i></div>');
});
 }
 $('.delete').click(function(){
 	console.log("this");
	 let id=$(this).prop('id');
	 //console.log(id);
	 var delId= id.substring(3, 5);
	 console.log("delId",delId);

	 var rowId= "#tr" + delId;
	 console.log("rowId", rowId);
     var rows;
	 // for(num= 0; num<10; num++){
	 //     console.log(num);
	    // rows += createRow;
    // }
	 //$('#msg-history').html(rows);


	 
     $.ajax({
         type: 'post',
         url: '/delete',
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data:{
             delId:delId
	 
         },
         success:function(data){
             console.log("data", data);
             console.log("item", rowId);
             
             if(data.status=="success"){
             	console.log("statusOk", rowId);
             	 $( rowId ).remove();
	 
             }
	 
         },
         error:function(xhr, errmsg, err){
	 
             console.log("mistake ajax");
             //alert("something went wrong");
             console.log("error", xhr);
             console.log("register", errmsg);
             console.log("wrong", err)
	 
         }
     });

 });

 function createRow(){

    var row=  '<tr>'  +
		'<td>New Group</td>'  +
		'<td>+254713060941</td>'  +
		'<td> <a href="#modal" data-toggle="modal" class="btn tooltipped modal-trigger" data-position="top" data-delay="50" data-tooltip="Edit" style="margin-right:3px;" ><i class="fa fa-pencil" aria-hidden="true"></i></a> </td> ' +
		'<td><button id="15" class="delete"><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i></button> </td>  '  +
		'  </tr>  ' ;

	 return row;


 }

 $(document).on('click', "#chip1", function(e) {
	e.preventDefault();
	var str = $('#phonesdiv').text();
	var res = str.replace(/close/g, ',');
	$('#mobilenos').html(res);
});
  $('#tel2').keypress(function (e) {
    if ($.trim($('#tel2').val())) {
	 $('#tel2').val($('#tel2').intlTelInput("getNumber"));
    if ($('#tel2').intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
	   $('#phonesdiv').removeClass('hide');
	   $('#mobilenos').append(','+$('#tel2').val());
	   $('#phonesdiv').append('<div id="chip1" class="chip cyan white-text">'+$('#tel2').val()+'<i class="material-icons close">close</i></div>');
		$('#tel2').val('');
		return false;  
	  }
    }
  }
});
    $('#editcontactgroupbtn').click(function(e) {
		e.preventDefault();

			if ($("#phonesdiv").hasClass("hide")) {
				var phone = $('#tel2').val();
			}else{
				var phone = $("#mobilenos").text();
			}
			var btn = $(this);
			var formdata = $('#editcontactgroupform').serializeArray();
			formdata.push({name: "phone",
			value: phone});
			
            $.ajax({
            type: "POST",
            url:  $('#editcontactgroupform').attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> editing');        
            },
            cache: false,
            success: function(data) {
            	console.log("contacts", data);
            	var id=data.contact['id'];
            	console.log("this", id); 
            	var nametd= "#nm" + id;
            	console.log("nametd", nametd);
            	var phonetd= "#ph" + id;
            	console.log("phonetd", phonetd);
                 btn.prop("disabled", false).html('<i class="material-icons left">edit</i>  Edit Group'); 
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
					text:  'Contact group edited successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'


				});
					 $('#modal').modal('close');
					$(nametd).html(data.contact['name']);
					$(phonetd).html(data.contact['phones']);

				

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="material-icons left">edit</i>  Edit Group');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when editing.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    

});