
var telInput = $("#tel"),
  errorMsg = $("#error-msg"),
  telInput1 = $("#tel1"),
  errorMsg1 = $("#error-msg1"),
  validMsg1 = $("#valid-msg1");
  validMsg = $("#valid-msg");


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
	$('#submitRequest').click(function(e) {
	var btn = $(this);
	$.confirm({
	boxWidth: '30%',
    useBootstrap: false,
    title: 'Confirm!',
    content: 'Do you want to continue buying the sender ID',
    buttons: {
        confirm: function () {
			var	_file = document.getElementById('file'); 

			if(_file.files.length === 0){
				
			var formdata= new FormData($('#sender_id_file_form')[0]);

			}else{
				 var formdata= new FormData($('#sender_id_file_form')[0]);
				
				formdata.append('file', _file.files[0]);
			
			}
		   
        	$.ajax({
            type: "POST",
            url: $('#sender_id_file_form').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {
				btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Paying'); 
			 },
            contentType: false,
            processData: false,
            cache: false,
            success: function(res) {
				btn.prop("disabled", false).html('Request'); 
				if(res.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  res.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
				$("#submitRequest").addClass('hide');
				$(".payment-option-btn").removeClass('hide');
			   }
				},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('Request'); 
						
					}
				});
		
		
		
		},
        cancel: function () {
           
        }
    }
});
e.preventDefault();
});

    $('#sender_id_form_btn').click(function(e) {
			e.preventDefault();
			var btn = $(this);
			var	_file = document.getElementById('file2'); 

			if(_file.files.length === 0){
				
			var formdata= new FormData($('#sender_id_form')[0]);

			}else{
				 var formdata= new FormData($('#sender_id_form')[0]);
				
				formdata.append('file', _file.files[0]);
			
			}
            $.ajax({
            type: "POST",
            url: $('#sender_id_form').attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Please wait...');        
            },
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="material-icons left">send</i>  Request'); 
             
			if(data.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  data.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
		
					 //window.setTimeout(function () {
                           window.location.replace(data.details);
                     //   }, 4000);
				   }
				   
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                   btn.prop("disabled", false).html('<i class="material-icons left">send</i>  Request'); 
                   $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
	
    

});
$("#image1").click(function(e) {
$("#file").click(); 
 e.preventDefault();
});
$("#file").change(function(){
  $("#file-name").text(this.files[0].name);
});
$("#image2").click(function(e) {
$("#file2").click(); 
 e.preventDefault();
});
$("#file2").change(function(){
  $("#file-name2").text(this.files[0].name);
});
    $('#rq-step-1-next').click(function(e) {
			e.preventDefault();
			var btn = $(this);

            $.ajax({
            type: "POST",
            url: $('#sender_id_form').attr("action"),
            data: $('#sender_id_form').serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Please wait...');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('Next'); 
             
			if(data.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  data.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
						$("#company_senderid").html(data.sender_id);
						$("#company_senderiddesc").html(data.usage);
						$("#rq-step-3-body").removeClass("active").addClass("hide");
						$("#rq-step-1-body").removeClass("active").addClass("hide");
						$("#rq-step-2-body").removeClass("hide").addClass("active");
						$("#rq-step-5-body").removeClass("active").addClass("hide");
						$("#rq-step-4-body").removeClass("active").addClass("hide");
				   		
						$("#rq-step-1").removeClass("active").addClass("");
						$("#rq-step-2").removeClass("").addClass("active");
						$("#rq-step-3").removeClass("active").addClass("");
						$("#rq-step-4").removeClass("active").addClass("");
						$("#rq-step-5").removeClass("active").addClass("");
				   		
						$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-2-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
						$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
				   
				   }
				   
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                   btn.prop("disabled", false).html('Next'); 
                   $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
	
    

});
    $('#rq-step-2-next').click(function(e) {
			e.preventDefault();
						$("#rq-step-3-body").removeClass("hide").addClass("active");
						$("#rq-step-1-body").removeClass("active").addClass("hide");
						$("#rq-step-2-body").removeClass("active").addClass("hide");
						$("#rq-step-5-body").removeClass("active").addClass("hide");
						$("#rq-step-4-body").removeClass("active").addClass("hide");
						
						$("#rq-step-1").removeClass("active").addClass("");
						$("#rq-step-2").removeClass("active").addClass("");
						$("#rq-step-3").removeClass("").addClass("active");
						$("#rq-step-4").removeClass("active").addClass("");
						$("#rq-step-5").removeClass("active").addClass("");
				   		
						$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-3-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
						$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
	});
	(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);
;( function( $, window, document, undefined )
{
	// feature detection for drag&drop upload

	var isAdvancedUpload = function()
		{
			var div = document.createElement( 'div' );
			return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
		}();


	// applying the effect for every form

	$( '.box' ).each( function()
	{

		var $form		 = $( this ),
			$input		 = $form.find( 'input[type="file"]' ),
			$label		 = $form.find( 'label' ),
			$errorMsg	 = $form.find( '.box__error span' ),
			$restart	 = $form.find( '.box__restart' ),
			droppedFiles = false,
			showFiles	 = function( files )
			{
				$label.text( files.length > 1 ? ( $input.attr( 'data-multiple-caption' ) || '' ).replace( '{count}', files.length ) : files[ 0 ].name );
			};

		// letting the server side to know we are going to make an Ajax request
		$form.append( '<input type="hidden" name="ajax" value="1" />' );

		// automatically submit the form on file select
		$input.on( 'change', function( e )
		{
			showFiles( e.target.files );
		});


			// drag&drop files if the feature is available
			if( isAdvancedUpload )
			{
				$form
				.addClass( 'has-advanced-upload' ) // letting the CSS part to know drag&drop is supported by the browser
				.on( 'drag dragstart dragend dragover dragenter dragleave drop', function( e )
				{
					// preventing the unwanted behaviours
					e.preventDefault();
					e.stopPropagation();
				})
				.on( 'dragover dragenter', function() //
				{
					$form.addClass( 'is-dragover' );
				})
				.on( 'dragleave dragend drop', function()
				{
					$form.removeClass( 'is-dragover' );
				})
				.on( 'drop', function( e )
				{
					droppedFiles = e.originalEvent.dataTransfer.files; // the files that were dropped
					showFiles( droppedFiles );
				});
			}

	$('#rq-step-3-next').click(function(e) {

				var btn = $(this);
				var	_file = document.getElementById('file'); 
				if( droppedFiles )
				{
					
					var formdata= new FormData($('#sender_id_file_form')[0]);
					$.each( droppedFiles, function( i, file )
					{
						formdata.append('file',file);
					});
					
					
				}else{
					if(_file.files.length === 0){
						
					var formdata= new FormData($('#sender_id_file_form')[0]);

					}else{
						 var formdata= new FormData($('#sender_id_file_form')[0]);
						
						formdata.append('file', _file.files[0]);
					
					}
			}
        	$.ajax({
            type: "POST",
            url: $('#sender_id_file_form').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {
				btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Uploading'); 
			 },
            contentType: false,
            processData: false,
            cache: false,
            success: function(res) {
				btn.prop("disabled", false).html('Request'); 
				if(res.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  res.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
						$("#rq-step-1-body").removeClass("active").addClass("hide");
						$("#rq-step-2-body").removeClass("active").addClass("hide");
						$("#rq-step-3-body").removeClass("active").addClass("hide");
						$("#rq-step-5-body").removeClass("active").addClass("hide");
						$("#rq-step-4-body").removeClass("hide").addClass("active");
						
						$("#rq-step-1").removeClass("active").addClass("");
						$("#rq-step-2").removeClass("active").addClass("");
						$("#rq-step-3").removeClass("active").addClass("");
						$("#rq-step-4").removeClass("").addClass("active");
						$("#rq-step-5").removeClass("active").addClass("");
				   		
						$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-4-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
						$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});		  

			  }
				},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('Request'); 
						
					}
				});

e.preventDefault();
});
		// restart the form if has a state of error/success

		$restart.on( 'click', function( e )
		{
			e.preventDefault();
			$form.removeClass( 'is-error is-success is-uploading' );
			//$input.trigger( 'click' );
			$label.html('<strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.');
		});

		// Firefox focus bug fix for file input
		$input
		.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
		.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
	});

})( jQuery, window, document );
	/*$('#rq-step-3-next').click(function(e) {
				alert(droppedFiles);
				var btn = $(this);
				var	_file = document.getElementById('file'); 
				if( droppedFiles )
				{
					$.each( droppedFiles, function( i, file )
					{
						alert('pp');
						console.log(file);
						var formdata = new FormData( $form.get( 0 ) );
						//formdata.append( $input.attr('name' ), file );
						//formdata.append('file', _file.files[0]);
					});
				}else{
					if(_file.files.length === 0){
						
					var formdata= new FormData($('#sender_id_file_form')[0]);

					}else{
						 var formdata= new FormData($('#sender_id_file_form')[0]);
						
						formdata.append('file', _file.files[0]);
					
					}
			}
        	$.ajax({
            type: "POST",
            url: $('#sender_id_file_form').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {
				btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Uploading'); 
			 },
            contentType: false,
            processData: false,
            cache: false,
            success: function(res) {
				btn.prop("disabled", false).html('Request'); 
				if(res.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  res.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
						$("#rq-step-1-body").removeClass("active").addClass("hide");
						$("#rq-step-2-body").removeClass("active").addClass("hide");
						$("#rq-step-3-body").removeClass("active").addClass("hide");
						$("#rq-step-5-body").removeClass("active").addClass("hide");
						$("#rq-step-4-body").removeClass("hide").addClass("active");
						
						$("#rq-step-1").removeClass("active").addClass("");
						$("#rq-step-2").removeClass("active").addClass("");
						$("#rq-step-3").removeClass("active").addClass("");
						$("#rq-step-4").removeClass("").addClass("active");
						$("#rq-step-5").removeClass("active").addClass("");
				   		
						$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-4-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
						$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});		  

			  }
				},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('Request'); 
						
					}
				});

e.preventDefault();
});*/
    $('#rq-step-2-previous').click(function(e) {
			e.preventDefault();
			$("#rq-step-3-body").removeClass("active").addClass("hide");
			$("#rq-step-1-body").removeClass("hide").addClass("active");
			$("#rq-step-2-body").removeClass("active").addClass("hide");
			$("#rq-step-5-body").removeClass("active").addClass("hide");
			$("#rq-step-4-body").removeClass("active").addClass("hide");
			
			$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
			$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
			$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
			$("#rq-step-1-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
			$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});	
	
			$("#rq-step-4").removeClass("active").addClass("");
			$("#rq-step-2").removeClass("active").addClass("");
		    $("#rq-step-3").removeClass("active").addClass("");
			$("#rq-step-1").removeClass("").addClass("active");
			$("#rq-step-5").removeClass("active").addClass("");
	});
	$('#rq-step-3-previous').click(function(e) {
			e.preventDefault();
			$("#rq-step-3-body").removeClass("active").addClass("hide");
			$("#rq-step-1-body").removeClass("active").addClass("hide");
			$("#rq-step-2-body").removeClass("hide").addClass("active");
			$("#rq-step-5-body").removeClass("active").addClass("hide");
			$("#rq-step-4-body").removeClass("active").addClass("hide");
			
			$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
			$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
			$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
			$("#rq-step-2-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
			$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});	
	
			$("#rq-step-4").removeClass("active").addClass("");
			$("#rq-step-1").removeClass("active").addClass("");
		    $("#rq-step-3").removeClass("active").addClass("");
			$("#rq-step-2").removeClass("").addClass("active");
			$("#rq-step-5").removeClass("active").addClass("");
			});
	$('#rq-step-4-previous').click(function(e) {
			e.preventDefault();
			$("#rq-step-3-body").removeClass("hide").addClass("active");
			$("#rq-step-1-body").removeClass("active").addClass("hide");
			$("#rq-step-2-body").removeClass("active").addClass("hide");
			$("#rq-step-5-body").removeClass("active").addClass("hide");
			$("#rq-step-4-body").removeClass("active").addClass("hide");
	
			$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
			$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
			$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
			$("#rq-step-3-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
			$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});	
	
			$("#rq-step-4").removeClass("active").addClass("");
			$("#rq-step-2").removeClass("active").addClass("");
		    $("#rq-step-1").removeClass("active").addClass("");
			$("#rq-step-3").removeClass("").addClass("active");
			$("#rq-step-5").removeClass("active").addClass("");
	
	});
    $('#pay_with_credits').click(function(e) {
			e.preventDefault();
			var btn = $(this);

            $.ajax({
            type: "POST",
            url: $('#pay_senderid_with_creditsform').attr("action"),
            data: $('#pay_senderid_with_creditsform').serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i> Please wait...');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('Pay Now'); 
             
			if(data.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
						$(":input").val("");
						$("#rq-step-3-body").removeClass("active").addClass("hide");
						$("#rq-step-1-body").removeClass("active").addClass("hide");
						$("#rq-step-2-body").removeClass("active").addClass("hide");
						$("#rq-step-5-body").removeClass("hide").addClass("active");
						$("#rq-step-4-body").removeClass("active").addClass("hide");
				   		
						$("#rq-step-1").removeClass("active").addClass("");
						$("#rq-step-2").removeClass("active").addClass("");
						$("#rq-step-3").removeClass("active").addClass("");
						$("#rq-step-4").removeClass("active").addClass("");
						$("#rq-step-5").removeClass("").addClass("active");
				   		
						$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
						$("#rq-step-5-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
				   
				   }
				   
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                   btn.prop("disabled", false).html('Pay Now'); 
                   $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
	
    

});	

$('#paybtn').click(function(e) {
			var btn = $(this);
			$.ajax({
            type: "POST",
            url: $('#paymentamountform').attr("action"),
            data: $('#paymentamountform').serialize(),
			dataType:"json",
            beforeSend: function() {
				btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Paying'); 
			 },
            cache: false,
            success: function(res) {
				btn.prop("disabled", false).html('Continue'); 
				if(res.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  res.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{  

				window.location.replace(res.details);
				//$("#paymentdiv").addClass('hide');
				//$("#paymentdiv1").removeClass('hide');
		}
				},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('Continue'); 
						
					}
				});
	e.preventDefault();
});
     $('#new_company_btn').click(function(e) {

			e.preventDefault();
			var btn = $(this);

			//var	_file = document.getElementById('file2'); 
			var	_file = document.getElementById('doc_upload_input'); 

			if(_file.files.length === 0){
				
			var formdata= new FormData($('#companyform')[0]);

			}else{
				 var formdata= new FormData($('#companyform')[0]);
				
				formdata.append('file', _file.files[0]);
			
			}
				var phone =telInput.intlTelInput("getNumber");
			
			formdata.append('phone',phone);
            $.ajax({
            type: "POST",
            url: $("#companyform").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('adding <i class="fa fa-spinner fa-spin"></i>');        
            },
		    contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
			
				
                 btn.prop("disabled", false).html('<i class="material-icons left">add</i>  Add Company'); 
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
					text:  'Company added successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
						$("#company_logo").html('<img src="'+server+'/logos/'+data.details.logo+'"  alt="Company Logo" width="35%" style="position:relative;"/>');
						$("#company_name").html(data.details.company_name);
						$("#company_email").html(data.details.email);
						$("#company_no").html(data.details.phone);
						$("#company_address").html(data.details.address);
						$("#company_senderid").html(data.details.sender_id);
						$("#company_senderiddesc").html(data.details.usage);
						$("#company_senderidname").html(data.details.company_name);
						 $('#modal2').modal('close');
				}
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="material-icons left">add</i>  Add Company');
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
$("#image2").click(function(e) {
$("#file2").click(); 
 e.preventDefault();
});
$("#file2").change(function(){
  $("#file-name2").text(this.files[0].name);
});
$(document).on("change", "#doc_upload_input", function(){
	if($(this).val() != ''){
		$("#upload_doc_clear").show();
		$("#upload_doc_file_name").val($(this)[0].files[0].name);
		//$("#upload_doc_btn").prop("disabled", false);
	}else{
		$("#upload_doc_clear").hide();
		$("#upload_doc_file_name").val('');
		//$("#upload_doc_btn").prop("disabled", true);
	}
});
$("#upload_doc_clear").click(function(){
	ctrl = document.getElementById("doc_upload_input");
	try {
		ctrl.value = null;
	} catch(ex) { }
	if (ctrl.value) {
		ctrl.parentNode.replaceChild(ctrl.cloneNode(true), ctrl);
	}
	$(this).hide();
	$("#upload_doc_file_name").val('');
	//$("#upload_doc_btn").prop("disabled", true);
});
    $('#edit_company').click(function(e) {
			e.preventDefault();
		 $.ajax({
            type: "GET",
            url: server+'/get_sender_id',
            dataType:"json",
            beforeSend: function() {

            },
            cache: false,
            success: function(data) {
				if(data.details.company_name !=null){
					$('#username').val(data.details.company_name);
					$('#email').val(data.details.email);
					$('#tel1').val(data.details.phone);
					$('#address').val(data.details.address);
					$('#company_senderidname').html(data.details.company_name);
				}
					$('#sender_id_input').val(data.details.sender_id);
					$('#sender_id_desc').val(data.details.usage);
					$('.usernamep').removeClass('hide');
					$('.emailp').removeClass('hide');
					$('.phonep').removeClass('hide');
					$('.addressp').removeClass('hide');
					$('.sender_id_input').removeClass('hide');
					$('.sender_id_desc').removeClass('hide');
					$('.logorow').removeClass('hide');
					
					$('#company_name').addClass('hide');
					$('#company_email').addClass('hide');
					$('#company_no').addClass('hide');
					$('#company_address').addClass('hide');
					$('#company_senderid').addClass('hide');
					$('#company_senderiddesc').addClass('hide');
					
					$('#edit_company').addClass('hide');
				    $('#save_company').removeClass('hide');
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

               
					}
                });		
	});
	
$(document).on("change", "#doc_upload_input1", function(){
	if($(this).val() != ''){
		$("#upload_doc_clear1").show();
		$("#upload_doc_file_name1").val($(this)[0].files[0].name);
	}else{
		$("#upload_doc_clear1").hide();
		$("#upload_doc_file_name1").val('');
	}
});
$("#upload_doc_clear1").click(function(){
	ctrl = document.getElementById("doc_upload_input1");
	try {
		ctrl.value = null;
	} catch(ex) { }
	if (ctrl.value) {
		ctrl.parentNode.replaceChild(ctrl.cloneNode(true), ctrl);
	}
	$(this).hide();
	$("#upload_doc_file_name1").val('');
});
     $('#save_company').click(function(e) {

			e.preventDefault();
			var btn = $(this);

			var	_file = document.getElementById('doc_upload_input1'); 

			if(_file.files.length === 0){
				
			var formdata= new FormData($('#companyform1')[0]);

			}else{
				 var formdata= new FormData($('#companyform1')[0]);
				
				formdata.append('file', _file.files[0]);
			
			}
				var phone =telInput1.intlTelInput("getNumber");
			
			formdata.append('phone',phone);
            $.ajax({
            type: "POST",
            url: $("#companyform1").attr("action"),
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('adding <i class="fa fa-spinner fa-spin"></i>');        
            },
		    contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
			
				
                 btn.prop("disabled", false).html('<i class="material-icons left">save</i> Update'); 
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
						$("#company_logo").html('<img src="'+server+'/logos/'+data.details.logo+'"  alt="Company Logo" width="35%" style="position:relative;"/>');
						$("#company_name").html(data.details.company_name);
						$("#company_email").html(data.details.email);
						$("#company_no").html(data.details.phone);
						$("#company_address").html(data.details.address);
						$("#company_senderid").html(data.details.sender_id);
						$("#company_senderiddesc").html(data.details.usage);
						$("#company_senderidname").html(data.details.company_name);
						
						$('.usernamep').addClass('hide');
						$('.emailp').addClass('hide');
						$('.phonep').addClass('hide');
						$('.addressp').addClass('hide');
						$('.sender_id_input').addClass('hide');
						$('.sender_id_desc').addClass('hide');
						
						$('#company_name').removeClass('hide');
						$('#company_email').removeClass('hide');
						$('#company_no').removeClass('hide');
						$('#company_address').removeClass('hide');
						$('#company_senderid').removeClass('hide');
						$('#company_senderiddesc').removeClass('hide');

						$('#username').val(data.details.company_name);
						$('#email').val(data.details.email);
						$('#tel1').val(data.details.phone);
						$('#address').val(data.details.address);
						$('#company_senderidname').html(data.details.company_name);
					
						$('#sender_id_input').val(data.details.sender_id);
						$('#sender_id_desc').val(data.details.usage);
						$('#edit_company').removeClass('hide');
						$('#save_company').addClass('hide');
						$('.logorow').addClass('hide');
				
				}
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="material-icons left">save</i>  Update');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when saving.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
    

});