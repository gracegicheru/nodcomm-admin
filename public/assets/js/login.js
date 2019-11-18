     frmVerify = $("#verifyform"),
	 btnVerify = $('#verifybtn'),

   $('#loginbtn').click(function(e) {

			var btn = $(this);

            var form = $("#loginform");

            $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Please Wait...');        
            },
            cache: false,
            success: function(data) {
                console.log("data", data);

                 btn.prop("disabled", false).html('<i class="fa fa-sign-in" aria-hidden="true"></i> Sign In'); 
               if(data.status=='error'){
                    $('#errors').addClass("alert alert-danger").html(data.details);
               }else{
				   // $('#logindiv').hide();
				   // $('#loginsuccessdiv').show();
					
                        window.setTimeout(function () {
                           window.location.replace(data.details);
                        }, 1000);
                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
				  if(XMLHttpRequest.status==423){
					 $('#errors').addClass("alert alert-danger").html(XMLHttpRequest.responseJSON.email);
				  }else{
                     $('#errors').addClass("alert alert-danger").html('An error occurred when logging.Please try again');
				  }

					btn.prop("disabled", false).html('<i class="fa fa-sign-in" aria-hidden="true"></i> Sign In'); 

                    }
                });
    
e.preventDefault();
});

    $('#resetemailbtn').click(function(e) {

			var btn = $(this);

            var form = $("#resetemailform");

            $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Please Wait...');        
            },
            cache: false,
            success: function(data) {

                 btn.prop("disabled", false).html('<i class="fa fa-sign-in" aria-hidden="true"></i> Send Reset Password Email'); 
               if(data.status=='error'){
                    $('#errors').addClass("alert alert-danger").html(data.details);
               }else{
				$('#errors').addClass("alert alert-success").html(data.details);
				$('#submitdiv').addClass("hidden");
				$('#emaildiv').addClass("hidden");
				$('.login-box-msg').html("");
                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('<i class="fa fa-sign-in" aria-hidden="true"></i> Send Reset Password Email'); 
                     $('#errors').addClass("alert alert-danger").html('An error occurred while sending the email.Please try again');
                    }
                });
    
e.preventDefault();
});
    $('#updatepasswordbtn').click(function(e) {

			var btn = $(this);

            var form = $("#updatepasswordform");

            $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Please Wait...');        
            },
            cache: false,
            success: function(data) {

                 btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Password'); 
               if(data.status=='error'){
                    $('#errors').addClass("alert alert-danger").html(data.details);
               }else{
				  
					$('#errors').addClass("alert alert-success").html(data.details);
					$('#loginsuccessdiv').removeClass("hidden");
					$('#logindiv').addClass("hidden");
					setTimeout(function(){ 

					window.location.replace("/"); 
					},
					1000);
                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
                  
					btn.prop("disabled", false).html('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update Password'); 
                     $('#errors').addClass("alert alert-danger").html('An error occurred when updating the password.Please try again');
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
var login_verify_resend_code = false;
$("#login-verify-resend-code").click(function(e){
    var elem = $("#login-verify-resend-code-dets");
    if(login_verify_resend_code == true){
        return;
    }
    $.ajax({
        type: 'get',
        url: server+"/login/resend-code",
        dataType: "json",
        beforeSend: function(){
            elem.html('<i class="fa fa-spin fa-spinner"></i>');
            $("#errors").removeClass("alert alert-danger alert-success");
            login_verify_resend_code = true;
        },
        success: function(res){
            if(res.status == "success"){
				
                $("#errors").addClass("alert alert-success text-center").html('A new authorization code has been sent');
                window.setTimeout(function(){
                    $("#errors").removeClass("alert alert-success").html('');
                }, 4000);
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