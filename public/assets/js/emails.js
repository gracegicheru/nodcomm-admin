$(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(".addfilter").click(function(){
		$(".filter-wrapper").slideToggle("slow");
		$(this).addClass("hide");
		get_filters();
	});

	$(".close-filters").click(function(){
		$(".filter-wrapper").slideToggle("slow");
		$(".addfilter").removeClass("hide");
	});

	$(".apply-filter").click(function(){
		var gateways_filter = $("#gateways-filter").val();
		var sites_filter = $("#sites-filter").val();
		var status_filter = $("#status-filter").val();

		apply_filters(gateways_filter, sites_filter, status_filter);
	});

	$(".clear-filter").click(function(){
		$("#gateways-filter option[value='all']").prop("selected", true);
		$("#sites-filter option[value='all']").prop("selected", true);
		$("#status-filter option[value='all']").prop("selected", true);

		apply_filters("all", "all", "all");
	});

	function get_filters(){
		$.ajax({
			type: "get",
			url: URL+"/emails/filters/get",
			dataType: "json",
			beforeSend: function(){
				$(".loading-filters").addClass('loading-overlay').html('<i class="fa fa-spinner fa-pulse"></i>');
			},
			success: function(res){
			
				var gateways = '<option value="all">All Gateways</option>';
				var sites = '<option value="all">All Companies</option>';

				if(Object.keys(res.gateways).length > 0){
					$.each(res.gateways, function(key, gateway){
						gateways += '<option value="'+gateway.id+'">'+gateway.name+'</option>';
					});
					$("#gateways-filter").html(gateways);
				}else{
					$("#gateways-filter").prop("disabled", true);
				}

				if(Object.keys(res.sites).length > 0){
					$.each(res.sites, function(key, site){
						sites += '<option value="'+site.id+'">'+site.name+'</option>';
					});
					$("#sites-filter").html(sites);
				}else{
					$("#sites-filter").prop("disabled", true);
				}

				$(".loading-overlay").removeClass('loading-overlay').html('');
			}
		});
	}

	function apply_filters(gateways_filter, sites_filter, status_filter){
		$.ajax({
			type: "post",
			url: URL+"/emails/filters/apply",
			data: {gateways_filter: gateways_filter, sites_filter: sites_filter, status_filter: status_filter},
			dataType: "json",
			beforeSend: function(){
				$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;"><i class="fa fa-spinner fa-pulse"></i></div></td></tr>');
				$(".apply-filter").prop("disabled", true);
			},
			success: function(res){

				var oTableToUpdate =  $('#dataTable7').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#dataTable7').dataTable().fnClearTable();

							    var i=1;

								$.each(res.data, function(key, message) {
								var status = '';

								if(message.status == "success"){
									status = '<span class="label label-success">Sent</span>';
								}else{
									status = '<span class="label label-danger">Failed</span>';
								}
									 $('#dataTable7').dataTable().fnAddData([
									  ''!=null ? message.created_at  : "",
									  ''!=null ? message.message  : "",
									  ''!=null ? message.email  : "",
									  ''!=null ? message.emailgateway.name : "",
									  ''!=null ? message.site.name : "",
									  ''!=null ? status  : "",
											]);
									i++;
								}); 

				$(".apply-filter").prop("disabled", false);
			},
			error: function(err){
				$(".apply-filter").prop("disabled", false);
			}
		});
	}
});

$('#apply-filter').click(function(e) {

			var startdate=$('#datepicker').val();
		
			var enddate=$('#datepicker1').val();
		
			var formdata = $('#ApplyCompanyfilterform').serializeArray();

				formdata.push({
					name: "startdate",
					value: startdate
				});
				formdata.push({
					name: "enddate",
					value: enddate
				});

			$.ajax({
            type: "POST",
            url: $('#ApplyCompanyfilterform').attr("action"),
            data: formdata,
			dataType:"json",
            beforeSend: function() {
				$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;"><i class="fa fa-spinner fa-pulse"></i></div></td></tr>');
				$("#apply-filter").prop("disabled", true);
			 },
            cache: false,
            success: function(res) {


				 var oTableToUpdate =  $('#dataTable7').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#dataTable7').dataTable().fnClearTable();

							    var i=1;

								$.each(res.data, function(key, message) {
								var status = '';

								if(message.status == "success"){
									status = '<span class="label label-success">Sent</span>';
								}else{
									status = '<span class="label label-danger">Failed</span>';
								}
									 $('#dataTable7').dataTable().fnAddData([
									  ''!=null ? message.created_at  : "",
									  ''!=null ? message.message  : "",
									  ''!=null ? message.email  : "",
									  ''!=null ? status  : "",
											]);
									i++;
								}); 


				$("#apply-filter").prop("disabled", false);
				},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					$("#apply-filter").prop("disabled", false);
						
					}
				});
	e.preventDefault();
});