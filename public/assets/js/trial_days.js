
    $('#extend_trial_days').click(function(e) {

			var btn = $(this);

            $.ajax({
            type: "POST",
            url: $("#extend_trial_daysform").attr("action"),
            data: $("#extend_trial_daysform").serialize(),
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('Extending <i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('Extend Your Trial'); 
               if(data.status=='error'){
				
				$("#errors").addClass('alert alert-danger').html(data.details);
				window.setTimeout(function () {
					$("#errors").removeClass('alert alert-danger alert-success').html(' ');
				}, 1000);
			  }else{	
				$("#errors").addClass('alert alert-success').html('Trial Period extended successfully.');
                     window.setTimeout(function () {
                           window.location.replace(data.details);
                      }, 1000);
				 }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('Extend Your Trial');
					$("#errors").addClass('alert alert-danger').html('An error occurred.Please try again');
				window.setTimeout(function () {
					$("#errors").removeClass('alert alert-danger alert-success').html(' ');
				}, 1000);
					}
                });
    
e.preventDefault();
});
		