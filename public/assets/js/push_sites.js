$(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$(".close-site").click(function(){
		$(".addsitewrapper").slideToggle("slow");
		$(".showaddsite").removeClass("hide");
	});
	$(".showaddsite").click(function(){
		$(".addsitewrapper").slideToggle("slow");
		$(this).addClass("hide");
	});
		$("#canceladdsite").click(function(){
		$(".addsitewrapper").slideToggle("slow");
	});
	$("#addsitebtn").click(function(){

		var form = $("#addsitefrm"),
			btn = $(this),
			msgbox = $(".msgbox");

		$.ajax({
			type: "post",
			url: form.attr("action"),
			data: form.serialize(),
			dataType: "json",
			beforeSend: function(){
				btn.prop("disabled", true).html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Adding');
			},
			success: function(res){
				if(res.status == "success"){
					
					$.gritter.add({
						title: "<strong style='color:#3ec291'>Success!</strong>",
						text:  'Site added successfully',
						sticky: false,
						time: '',
						class_name: 'gritter-success'
					});
					$(".addsitewrapper").slideToggle("slow");
					$(".code textarea").val(res.code);
					$(".code").removeClass("hide");
					btn.prop("disabled", false).html('<i class="fa fa-plus"></i> Add Site');
					form[0].reset();

					var html = '';
					var i = 1;
					$.each(res.sites, function(key, site){
						html += '<tr>'+
                                    '<td>'+i+'</td>'+
                                    '<td>'+site.name+'</td>'+
                                    '<td>'+site.url+'</td>'+
                                    '<td>'+site.site_id+'</td>'+
                                    '<td>'+site.created_at+'</td>'+
                                    '<td><a class="btn btn-primary btn-xs" href="'+URL+'/sites/'+site.id+'"><i class="fa fa-eye"></i></a></td>'+
                                  '</tr>';
                        i++;
					});

					$("#allsitestbl").html(html);
				}else{
					btn.prop("disabled", false).html('<i class="fa fa-plus"></i> Add Site');
					$.gritter.add({
						title: "<strong style='color:#fb5a43'>Oops!</strong>",
						text:  res.details,
						sticky: false,
						time: '',
						class_name: 'gritter-danger'
					});
				}
			},
			error: function(err){
				btn.prop("disabled", false).html('<i class="fa fa-plus"></i> Add Site');
				$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  'An error occurred when adding the website. Please try again',
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
			}
		});
	});

	$(".showaddanalytics").click(function(e){
		$(".showaddanalytics").addClass('hidden');
		$("#gcodelabel").removeClass('hidden');
		$("#gcode").removeClass('hidden');
		e.preventDefault();
	});
	$(".code textarea").focus(function() {
	    var $this = $(this);
	    $this.select();

	    // Work around Chrome's little problem
	    $this.mouseup(function() {
	        // Prevent further mouseup intervention
	        $this.unbind("mouseup");
	        return false;
	    });
	});

	$(".code-view-textarea").focus(function() {
	    var $this = $(this);
	    $this.select();

	    // Work around Chrome's little problem
	    $this.mouseup(function() {
	        // Prevent further mouseup intervention
	        $this.unbind("mouseup");
	        return false;
	    });
	});

	$(".btn-edit-site").click(function(){
		$(this).addClass("hide");
		$(".btn-edit-site-save").removeClass("hide");

		//$("#editsitefrm input[type=text]").removeClass("hide");
		$.each($("#editsitefrm input[type=text]"), function(key, elem){
			$(elem).parent().prev().addClass("hide");
			$(elem).removeClass("hide");
		});
	});

	$(".btn-edit-site-save").click(function(){
		var form = $("#editsitefrm"),
			btn = $(this);

		$.ajax({
			type: "post",
			url: URL+'/push-sites/edit',
			data: form.serialize(),
			dataType: "json",
			beforeSend: function(){
				btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Saving');
			},
			success: function(res){
				if(res.status == "success"){
					$.each($("#editsitefrm input[type=text]"), function(key, elem){
						$(elem).parent().prev().html($(elem).val()).removeClass("hide");
						$(elem).addClass("hide");
					});

					btn.addClass("hide");
					$(".btn-edit-site").removeClass("hide");
					btn.prop("disabled", false).html('<i class="fa fa-save"></i> Save');

					$.gritter.add({
						title: "<strong style='color:#3ec291'>Success!</strong>",
						text:  res.details,
						sticky: false,
						time: '',
						class_name: 'gritter-success'
					});
				}else{
					btn.prop("disabled", false).html('<i class="fa fa-save"></i> Save');

					$.gritter.add({
						title: "<strong style='color:#fb5a43'>Oops!</strong>",
						text:  res.details,
						sticky: false,
						time: '',
						class_name: 'gritter-danger'
					});
				}
			},
			error(err){
				btn.prop("disabled", false).html('<i class="fa fa-save"></i> Save');

				$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  'An error occurred when updating the website. Please try again',
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
			}
		});
	});

});