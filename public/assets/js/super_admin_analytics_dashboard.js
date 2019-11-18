
super_admin_data();
SMSs();
function super_admin_data(){
	           
				$.ajax({
				url: server+"/super_admin_analytics_data",
				type: "GET",
				dataType:"json",
				success: function(data){ 
					$("#agents").html(data.agents);
				    $("#sender_id_cost").html(data.sender_id_cost);
					$("#deliveredsms").html(data.deliveredsms);
					if(data.deliveredsmspercentage > 0){
						var deliveredsmspercentage = '<i class="material-icons">keyboard_arrow_up</i> '+data.deliveredsmspercentage+'% <span class="cyan text text-lighten-5">from last month</span>';
					}else{
						var deliveredsmspercentage = '<i class="material-icons">keyboard_arrow_down</i> '+data.deliveredsmspercentage+'% <span class="cyan text text-lighten-5">from last month</span>';
					}
				   $("#deliveredsmspercentage").html(deliveredsmspercentage);
				   $("#undeliveredsms").html(data.undeliveredsms);
					if(data.undeliveredsmspercentage > 0){
						var undeliveredsmspercentage = '<i class="material-icons">keyboard_arrow_up</i> '+data.undeliveredsmspercentage+'% <span class="red-text text-lighten-5">from last month</span>';
					}else{
						var undeliveredsmspercentage = '<i class="material-icons">keyboard_arrow_down</i> '+data.undeliveredsmspercentage+'% <span class="red-text text-lighten-5">from last month</span>';
					}
				   $("#undeliveredsmspercentage").html(undeliveredsmspercentage);
					$("#new_companies").html(data.newcompanies);
					if(data.companiespercentage > 0){
						var percentage = '<i class="material-icons">keyboard_arrow_up</i> '+data.companiespercentage+'% <span class="cyan text text-lighten-5">from last month</span>';
					}else{
						var percentage = '<i class="material-icons">keyboard_arrow_down</i> '+data.companiespercentage+'% <span class="cyan text text-lighten-5">from last month</span>';
					}
					$("#company_percentage").html(percentage);
					$("#newsmssales").html(data.newsmssales);
					if(data.smssalespercentage > 0){
						var smssalespercentage = '<i class="material-icons">keyboard_arrow_up</i> '+data.smssalespercentage+'% <span class="red-text text-lighten-5">from last month</span>';
					}else{
						var smssalespercentage = '<i class="material-icons">keyboard_arrow_down</i> '+data.smssalespercentage+'% <span class="red-text text-lighten-5">from last month</span>';
					}
					$("#smssalespercentage").html(smssalespercentage);
					$("#newsenderidsales").html(data.newsenderidsales);
					if(data.senderidsalespercentage > 0){
						var senderidsalespercentage = '<i class="material-icons">keyboard_arrow_up</i> '+data.senderidsalespercentage+'% <span class="teal-text text-lighten-5">from last month</span>';
					}else{
						var senderidsalespercentage = '<i class="material-icons">keyboard_arrow_down</i> '+data.senderidsalespercentage+'% <span class="teal-text text-lighten-5">from last month</span>';
					}
					$("#senderidsalespercentage").html(senderidsalespercentage);
					$("#newvisitors").html(data.newvisitors);
					if(data.visitorssalespercentage > 0){
						var visitorssalespercentage = '<i class="material-icons">keyboard_arrow_up</i> '+data.visitorssalespercentage+'% <span class="deep-orange-text text-lighten-5">from last month</span>';
					}else{
						var visitorssalespercentage = '<i class="material-icons">keyboard_arrow_down</i> '+data.visitorssalespercentage+'% <span class="deep-orange-text text-lighten-5">from last month</span>';
					}
					$("#visitorssalespercentage").html(visitorssalespercentage);
				}
			})
}
function SMSs(){
				$.ajax({
				url: server+"/SMSs",
				type: "GET",
				dataType:"json",
				success: function(data){ 
				var oTableToUpdate =  $('#data-table-simple').dataTable( { bRetrieve : true } );
				 oTableToUpdate .fnDraw();
				$('#data-table-simple').dataTable().fnClearTable();

							    var i=1;
								$.each(data.companies, function(key, value) {
		
									 $('#data-table-simple').dataTable().fnAddData([
									  ''!=null ? i : "",
									  ''!=null ? value.company : "",
									  ''!=null ? value.sms_count  : "",
									  ''!=null ? value.credit  : "",
									  ''!=null ? value.total_credit  : "",
									  ''!=null ? "Kshs. "+value.credit_amount  : ""	
											]);
									i++;
								}); 
				}
			})
}

$('#apply-filter').click(function(e) {
			$.ajax({
            type: "POST",
            url: $('#ApplySMSfilterform').attr("action"),
            data: $('#ApplySMSfilterform').serialize(),
			dataType:"json",
            beforeSend: function() {
				$("#apply-filter").prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i>  Searching'); 
			 },
            cache: false,
            success: function(res) {
			$("#apply-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');		
			if(res.status == 'no_data'){
				$("#msg-history").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
				$("#load-more").addClass('hide');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='sent'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.phone+'</td><td>'+span+'</td></tr>';});
				$("#msg-history").html(tr);
				$("#apply-filter").prop("disabled", false);
				
				//$(".smsform").addClass('hide');
				$("#load-more").removeClass('hide');

			}
			$(".smstable").removeClass('hide');
				},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					$("#apply-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');	
						
					}
				});
	e.preventDefault();
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
$("#load-more").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  server+"/analytics/load_search_more",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more sms');
				//$("#msg-history").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='sent'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.phone+'</td><td>'+span+'</td></tr>';
				});
				$("#msg-history").append(tr);
				btn.prop("disabled", false).html('Load more');
			}
		},
		error:  function(err){
			btn.prop("disabled", false).html('Load more');
			$.gritter.add({
				title: '<strong>Oops!</strong>',
				text: 'More sms failed to load',
				sticky: false,
				time: '',
				class_name: 'gritter-danger'
			});
		}
	});
});
$('#apply-time-filter').click(function(e) {
	
			$.ajax({
            type: "POST",
            url: $('#ApplySMStimefilterform').attr("action"),
            data: $('#ApplySMStimefilterform').serialize(),
			dataType:"json",
            beforeSend: function() {
				$("#apply-time-filter").prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i>  Searching'); 
			 },
            cache: false,
            success: function(res) {
			$("#apply-time-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');	
			if(res.status == 'no_data'){
				
				$("#msg-history1").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
				$("#load-more1").addClass('hide');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='sent'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.phone+'</td><td>'+span+'</td></tr>';});
				$("#msg-history1").html(tr);
				$("#apply-time-filter").prop("disabled", false);
				$("#load-more1").removeClass('hide');
				//$(".timesmsform").addClass('hide');

			}
			$(".Timesmstable").removeClass('hide');
				},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					$("#apply-time-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');	
						
					}
				});
	e.preventDefault();
});
$("#load-more1").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  server+"/analytics/load_time_search_more",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more sms');
				//$("#msg-history").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='sent'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.phone+'</td><td>'+span+'</td></tr>';
				});
				$("#msg-history1").append(tr);
				btn.prop("disabled", false).html('Load more');
			}
		},
		error:  function(err){
			btn.prop("disabled", false).html('Load more');
			$.gritter.add({
				title: '<strong>Oops!</strong>',
				text: 'More sms failed to load',
				sticky: false,
				time: '',
				class_name: 'gritter-danger'
			});
		}
	});
});
$('#apply-senderID-time-filter').click(function(e) {
	
			$.ajax({
            type: "POST",
            url: $('#ApplySMSsenderidtimefilterform').attr("action"),
            data: $('#ApplySMSsenderidtimefilterform').serialize(),
			dataType:"json",
            beforeSend: function() {
				$("#apply-senderID-time-filter").prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i>  Searching'); 
			 },
            cache: false,
            success: function(res) {
			$("#apply-senderID-time-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');	
			if(res.status == 'no_data'){
				
				$("#msg-history2").html('<tr><td colspan="7"><div class="text-center" style="padding: 10px 0px;">No Sender ID found</div></td></tr>');
				$("#load-more2").addClass('hide');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {

					var url =server+"/authoriation_documents/"+value.authoriation_document;
					authoriation_documents = '<a target="_blank" class="btn btn-xs btn-default" href="'+url+'" style="margin-bottom: 30px;"><i class="fa fa-file-word-o fa-lg"></i> My Document</a>';
					if(value.verified == 1){
					 status = 'Verified';
					}else{
					 status = 'Unverified';
					}
					tr +='<tr><td>'+value.sender_id+'</td><td>'+value.user.name+'</td><td>'+value.company+'</td><td>'+value.currency+" "+value. amount+'</td><td>'+authoriation_documents+'</td><td>'+value.created_at+'</td><td>'+status+'</td></tr>';});
				$("#msg-history2").html(tr);
				$("#apply-senderID-time-filter").prop("disabled", false);
				$("#load-more2").removeClass('hide');
				//$(".timesmsform").addClass('hide');

			}
			$(".SenderidTimesmstable").removeClass('hide');
				},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					$("#apply-senderID-time-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');	
						
					}
				});
	e.preventDefault();
});
$("#load-more2").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  server+"/analytics/load_senderid_search_more",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more Sender IDs');
				//$("#msg-history").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					var url =server+"/authoriation_documents/"+value.authoriation_document;
					authoriation_documents = '<a target="_blank" class="btn btn-xs btn-default" href="'+url+'" style="margin-bottom: 30px;"><i class="fa fa-file-word-o fa-lg"></i> My Document</a>';
					if(value.verified == 1){
					 status = 'Verified';
					}else{
					 status = 'Unverified';
					}
					tr +='<tr><td>'+value.sender_id+'</td><td>'+value.user.name+'</td><td>'+value.company+'</td><td>'+value.currency+" "+value. amount+'</td><td>'+authoriation_documents+'</td><td>'+value.created_at+'</td><td>'+status+'</td></tr>';});
				$("#msg-history2").html(tr);
				btn.prop("disabled", false).html('Load more');
			}
		},
		error:  function(err){
			btn.prop("disabled", false).html('Load more');
			$.gritter.add({
				title: '<strong>Oops!</strong>',
				text: 'Sender IDs failed to load',
				sticky: false,
				time: '',
				class_name: 'gritter-danger'
			});
		}
	});
});

$("#senderid-search-term").keyup(global_senderid_search);
$("#ApplySMSsenderidnamefilterform").submit(function(evt){
	evt.preventDefault();
	global_senderid_search;
});
function global_senderid_search(){
	var search_term = $("#senderid-search-term").val(),
		form = $("#ApplySMSsenderidnamefilterform"); 
		$.ajax({
			type: "post",
			data: form.serialize(),
			url:  form.attr("action"),
			dataType: "json",
			beforeSend: function(){
				$("#apply-senderID-name-filter").prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i>  Searching'); 
			},
			success: function(res){
			$("#apply-senderID-name-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');	
			if(res.status == 'no_data'){
				
				$("#msg-history3").html('<tr><td colspan="7"><div class="text-center" style="padding: 10px 0px;">No Sender ID found</div></td></tr>');
				$("#load-more3").addClass('hide');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {

					var url =server+"/authoriation_documents/"+value.authoriation_document;
					authoriation_documents = '<a target="_blank" class="btn btn-xs btn-default" href="'+url+'" style="margin-bottom: 30px;"><i class="fa fa-file-word-o fa-lg"></i> My Document</a>';
					if(value.verified == 1){
					 status = 'Verified';
					}else{
					 status = 'Unverified';
					}
					tr +='<tr><td>'+value.sender_id+'</td><td>'+value.user.name+'</td><td>'+value.company+'</td><td>'+value.currency+" "+value. amount+'</td><td>'+authoriation_documents+'</td><td>'+value.created_at+'</td><td>'+status+'</td></tr>';});
				$("#msg-history3").html(tr);
				$("#apply-senderID-name-filter").prop("disabled", false);
				$("#load-more3").removeClass('hide');
				//$(".timesmsform").addClass('hide');

			}
			$(".SenderidNamesmstable").removeClass('hide');
			},
			error: function(err){
			$("#apply-senderID-name-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');
			}
		});

}
$("#load-more3").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  server+"/analytics/load_sendderid_by_name_search_more",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more Sender IDs');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					var url =server+"/authoriation_documents/"+value.authoriation_document;
					authoriation_documents = '<a target="_blank" class="btn btn-xs btn-default" href="'+url+'" style="margin-bottom: 30px;"><i class="fa fa-file-word-o fa-lg"></i> My Document</a>';
					if(value.verified == 1){
					 status = 'Verified';
					}else{
					 status = 'Unverified';
					}
					tr +='<tr><td>'+value.sender_id+'</td><td>'+value.user.name+'</td><td>'+value.company+'</td><td>'+value.currency+" "+value. amount+'</td><td>'+authoriation_documents+'</td><td>'+value.created_at+'</td><td>'+status+'</td></tr>';});
				$("#msg-history3").html(tr);
				btn.prop("disabled", false).html('Load more');
			}
		},
		error:  function(err){
			btn.prop("disabled", false).html('Load more');
			$.gritter.add({
				title: '<strong>Oops!</strong>',
				text: 'Sender IDs failed to load',
				sticky: false,
				time: '',
				class_name: 'gritter-danger'
			});
		}
	});
});


	$(window).on('load', function() {	

	 			$.ajax({
				url: server+'/analytics/sms-revenue',
				type: "GET",
				dataType:"json",
				success: function(json){ 
				var data = {
					labels: json.labels,
					datasets: [{
							label: "First dataset",
							fillColor: "rgba(128, 222, 234, 0.6)",
							strokeColor: "#ffffff",
							pointColor: "#00bcd4",
							pointStrokeColor: "#ffffff",
							pointHighlightFill: "#ffffff",
							pointHighlightStroke: "#ffffff",
							data: json.data
						}
					]
				};					
						/*
	 * Reventu card
	 */
	// Trending Line chart  - use var = data  
	var trendingLineChart = document.getElementById("sms_revenue_graph").getContext("2d");
	window.trendingLineChart = new Chart(trendingLineChart).Line(data, {
		scaleShowGridLines: true,
		scaleGridLineColor: "rgba(255,255,255,0.4)",
		scaleGridLineWidth: 1,
		scaleShowHorizontalLines: true,
		scaleShowVerticalLines: false,
		bezierCurve: true,
		bezierCurveTension: 0.4,
		pointDot: true,
		pointDotRadius: 5,
		pointDotStrokeWidth: 2,
		pointHitDetectionRadius: 20,
		datasetStroke: true,
		datasetStrokeWidth: 3,
		datasetFill: true,
		animationSteps: 15,
		animationEasing: "easeOutQuart",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		scaleFontSize: 12,
		scaleFontStyle: "normal",
		scaleFontColor: "#fff",
		tooltipEvents: ["mousemove", "touchstart", "touchmove"],
		tooltipFillColor: "rgba(255,255,255,0.8)",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipFontSize: 12,
		tooltipFontColor: "#000",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipTitleFontSize: 14,
		tooltipTitleFontStyle: "bold",
		tooltipTitleFontColor: "#000",
		tooltipYPadding: 8,
		tooltipXPadding: 16,
		tooltipCaretSize: 10,
		tooltipCornerRadius: 6,
		tooltipXOffset: 10,
		responsive: true
	});
				
				}
				})


	 			$.ajax({
				url: server+'/analytics/sender-id-revenue',
				type: "GET",
				dataType:"json",
				success: function(json){ 
				var data = {
					labels: json.labels,
					datasets: [{
							label: "First dataset",
							fillColor: "rgba(128, 222, 234, 0.6)",
							strokeColor: "#ffffff",
							pointColor: "#00bcd4",
							pointStrokeColor: "#ffffff",
							pointHighlightFill: "#ffffff",
							pointHighlightStroke: "#ffffff",
							data: json.data
						}
					]
				};					
						/*
	 * Reventu card
	 */
	// Trending Line chart  - use var = data  
	var SenderIDLineChart = document.getElementById("sender_id_revenue_graph").getContext("2d");
	window.SenderIDLineChart = new Chart(SenderIDLineChart).Line(data, {
		scaleShowGridLines: true,
		scaleGridLineColor: "rgba(255,255,255,0.4)",
		scaleGridLineWidth: 1,
		scaleShowHorizontalLines: true,
		scaleShowVerticalLines: false,
		bezierCurve: true,
		bezierCurveTension: 0.4,
		pointDot: true,
		pointDotRadius: 5,
		pointDotStrokeWidth: 2,
		pointHitDetectionRadius: 20,
		datasetStroke: true,
		datasetStrokeWidth: 3,
		datasetFill: true,
		animationSteps: 15,
		animationEasing: "easeOutQuart",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		scaleFontSize: 12,
		scaleFontStyle: "normal",
		scaleFontColor: "#fff",
		tooltipEvents: ["mousemove", "touchstart", "touchmove"],
		tooltipFillColor: "rgba(255,255,255,0.8)",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipFontSize: 12,
		tooltipFontColor: "#000",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipTitleFontSize: 14,
		tooltipTitleFontStyle: "bold",
		tooltipTitleFontColor: "#000",
		tooltipYPadding: 8,
		tooltipXPadding: 16,
		tooltipCaretSize: 10,
		tooltipCornerRadius: 6,
		tooltipXOffset: 10,
		responsive: true
	});
				
				}
				})		

	 			$.ajax({
				url: server+'/analytics/sent-sms',
				type: "GET",
				dataType:"json",
				success: function(json){ 
				var data = {
					labels: json.labels,
					datasets: [{
							label: "First dataset",
							fillColor: "rgba(128, 222, 234, 0.6)",
							strokeColor: "#ffffff",
							pointColor: "#00bcd4",
							pointStrokeColor: "#ffffff",
							pointHighlightFill: "#ffffff",
							pointHighlightStroke: "#ffffff",
							data: json.data
						}
					]
				};					
						/*
	 * Reventu card
	 */
	// Trending Line chart  - use var = data  
	var sentsmsLineChart = document.getElementById("sent_sms_graph").getContext("2d");
	window.sentsmsLineChart = new Chart(sentsmsLineChart).Line(data, {
		scaleShowGridLines: true,
		scaleGridLineColor: "rgba(255,255,255,0.4)",
		scaleGridLineWidth: 1,
		scaleShowHorizontalLines: true,
		scaleShowVerticalLines: false,
		bezierCurve: true,
		bezierCurveTension: 0.4,
		pointDot: true,
		pointDotRadius: 5,
		pointDotStrokeWidth: 2,
		pointHitDetectionRadius: 20,
		datasetStroke: true,
		datasetStrokeWidth: 3,
		datasetFill: true,
		animationSteps: 15,
		animationEasing: "easeOutQuart",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		scaleFontSize: 12,
		scaleFontStyle: "normal",
		scaleFontColor: "#fff",
		tooltipEvents: ["mousemove", "touchstart", "touchmove"],
		tooltipFillColor: "rgba(255,255,255,0.8)",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipFontSize: 12,
		tooltipFontColor: "#000",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipTitleFontSize: 14,
		tooltipTitleFontStyle: "bold",
		tooltipTitleFontColor: "#000",
		tooltipYPadding: 8,
		tooltipXPadding: 16,
		tooltipCaretSize: 10,
		tooltipCornerRadius: 6,
		tooltipXOffset: 10,
		responsive: true
	});
				
				}
				})		


	 			$.ajax({
				url: server+'/analytics/companies',
				type: "GET",
				dataType:"json",
				success: function(json){ 
				var data = {
					labels: json.labels,
					datasets: [{
							label: "First dataset",
							fillColor: "rgba(128, 222, 234, 0.6)",
							strokeColor: "#ffffff",
							pointColor: "#00bcd4",
							pointStrokeColor: "#ffffff",
							pointHighlightFill: "#ffffff",
							pointHighlightStroke: "#ffffff",
							data: json.data
						}
					]
				};					
						/*
	 * Reventu card
	 */
	// Trending Line chart  - use var = data  
	var CompanyLineChart = document.getElementById("analytics_companies_graph").getContext("2d");
	window.CompanyLineChart = new Chart(CompanyLineChart).Line(data, {
		scaleShowGridLines: true,
		scaleGridLineColor: "rgba(255,255,255,0.4)",
		scaleGridLineWidth: 1,
		scaleShowHorizontalLines: true,
		scaleShowVerticalLines: false,
		bezierCurve: true,
		bezierCurveTension: 0.4,
		pointDot: true,
		pointDotRadius: 5,
		pointDotStrokeWidth: 2,
		pointHitDetectionRadius: 20,
		datasetStroke: true,
		datasetStrokeWidth: 3,
		datasetFill: true,
		animationSteps: 15,
		animationEasing: "easeOutQuart",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		scaleFontSize: 12,
		scaleFontStyle: "normal",
		scaleFontColor: "#fff",
		tooltipEvents: ["mousemove", "touchstart", "touchmove"],
		tooltipFillColor: "rgba(255,255,255,0.8)",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipFontSize: 12,
		tooltipFontColor: "#000",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipTitleFontSize: 14,
		tooltipTitleFontStyle: "bold",
		tooltipTitleFontColor: "#000",
		tooltipYPadding: 8,
		tooltipXPadding: 16,
		tooltipCaretSize: 10,
		tooltipCornerRadius: 6,
		tooltipXOffset: 10,
		responsive: true
	});
				
				}
				})	
		$.ajax({
				url: server+'/graph/analytics/visitors',
				type: "GET",
				dataType:"json",
				success: function(json){ 
				var data = {
					labels: json.labels,
					datasets: [{
							label: "First dataset",
							fillColor: "rgba(128, 222, 234, 0.6)",
							strokeColor: "#ffffff",
							pointColor: "#00bcd4",
							pointStrokeColor: "#ffffff",
							pointHighlightFill: "#ffffff",
							pointHighlightStroke: "#ffffff",
							data: json.data
						}
					]
				};					
						/*
	 * Reventu card
	 */
	// Trending Line chart  - use var = data  
	var visitorsLineChart = document.getElementById("visitors_graph").getContext("2d");
	window.visitorsLineChart = new Chart(visitorsLineChart).Line(data, {
		scaleShowGridLines: true,
		scaleGridLineColor: "rgba(255,255,255,0.4)",
		scaleGridLineWidth: 1,
		scaleShowHorizontalLines: true,
		scaleShowVerticalLines: false,
		bezierCurve: true,
		bezierCurveTension: 0.4,
		pointDot: true,
		pointDotRadius: 5,
		pointDotStrokeWidth: 2,
		pointHitDetectionRadius: 20,
		datasetStroke: true,
		datasetStrokeWidth: 3,
		datasetFill: true,
		animationSteps: 15,
		animationEasing: "easeOutQuart",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		scaleFontSize: 12,
		scaleFontStyle: "normal",
		scaleFontColor: "#fff",
		tooltipEvents: ["mousemove", "touchstart", "touchmove"],
		tooltipFillColor: "rgba(255,255,255,0.8)",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipFontSize: 12,
		tooltipFontColor: "#000",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipTitleFontSize: 14,
		tooltipTitleFontStyle: "bold",
		tooltipTitleFontColor: "#000",
		tooltipYPadding: 8,
		tooltipXPadding: 16,
		tooltipCaretSize: 10,
		tooltipCornerRadius: 6,
		tooltipXOffset: 10,
		responsive: true
	});
				
				}
				})		
		$.ajax({
				url: server+'/analytics/sms-profit',
				type: "GET",
				dataType:"json",
				success: function(json){ 
				var data = {
					labels: json.labels,
					datasets: [{
							label: "First dataset",
							fillColor: "rgba(128, 222, 234, 0.6)",
							strokeColor: "#ffffff",
							pointColor: "#00bcd4",
							pointStrokeColor: "#ffffff",
							pointHighlightFill: "#ffffff",
							pointHighlightStroke: "#ffffff",
							data: json.data
						}
					]
				};					
						/*
	 * Reventu card
	 */
	// Trending Line chart  - use var = data  
	var profitLineChart = document.getElementById("sms_profit_graph").getContext("2d");
	window.profitLineChart = new Chart(profitLineChart).Line(data, {
		scaleShowGridLines: true,
		scaleGridLineColor: "rgba(255,255,255,0.4)",
		scaleGridLineWidth: 1,
		scaleShowHorizontalLines: true,
		scaleShowVerticalLines: false,
		bezierCurve: true,
		bezierCurveTension: 0.4,
		pointDot: true,
		pointDotRadius: 5,
		pointDotStrokeWidth: 2,
		pointHitDetectionRadius: 20,
		datasetStroke: true,
		datasetStrokeWidth: 3,
		datasetFill: true,
		animationSteps: 15,
		animationEasing: "easeOutQuart",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		scaleFontSize: 12,
		scaleFontStyle: "normal",
		scaleFontColor: "#fff",
		tooltipEvents: ["mousemove", "touchstart", "touchmove"],
		tooltipFillColor: "rgba(255,255,255,0.8)",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipFontSize: 12,
		tooltipFontColor: "#000",
		tooltipTitleFontFamily: "'Roboto','Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
		tooltipTitleFontSize: 14,
		tooltipTitleFontStyle: "bold",
		tooltipTitleFontColor: "#000",
		tooltipYPadding: 8,
		tooltipXPadding: 16,
		tooltipCaretSize: 10,
		tooltipCornerRadius: 6,
		tooltipXOffset: 10,
		responsive: true
	});
				
				}
				})					
});
