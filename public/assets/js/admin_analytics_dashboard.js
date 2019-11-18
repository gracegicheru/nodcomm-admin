
admin_data();
function admin_data(){
	           
				$.ajax({
				url: server+"/admin_analytics_data",
				type: "GET",
				dataType:"json",
				success: function(data){ 
					$("#agents").html(data.agents);
					$("#deliveredsms").html(data.deliveredsms);
					$("#sender_id_cost").html(data.sender_id_cost);
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
				   
				   $("#newsmssent").html(data.newsmssent);
					if(data.smssentpercentage > 0){
						var percentage = '<i class="material-icons">keyboard_arrow_up</i> '+data.smssentpercentage+'% <span class="cyan text text-lighten-5">from last month</span>';
					}else{
						var percentage = '<i class="material-icons">keyboard_arrow_down</i> '+data.smssentpercentage+'% <span class="cyan text text-lighten-5">from last month</span>';
					}
					$("#smssentpercentage").html(percentage);

					$("#newvisitors").html(data.newvisitors);
					if(data.visitorssalespercentage > 0){
						var visitorssalespercentage = '<i class="material-icons">keyboard_arrow_up</i> '+data.visitorssalespercentage+'% <span class="deep-orange-text text-lighten-5">from last month</span>';
					}else{
						var visitorssalespercentage = '<i class="material-icons">keyboard_arrow_down</i> '+data.visitorssalespercentage+'% <span class="deep-orange-text text-lighten-5">from last month</span>';
					}
					$("#visitorssalespercentage").html(visitorssalespercentage);
					$("#newcredit").html(data.newcredit);
					if(data.creditpercentage > 0){
						var creditpercentage = '<i class="material-icons">keyboard_arrow_up</i> '+data.creditpercentage+'% <span class="deep-orange-text text-lighten-5">from last month</span>';
					}else{
						var creditpercentage = '<i class="material-icons">keyboard_arrow_down</i> '+data.creditpercentage+'% <span class="deep-orange-text text-lighten-5">from last month</span>';
					}
					$("#creditpercentage").html(creditpercentage);
					$("#newamount").html('Kshs '+data.newamount);
					if(data.amountpercentage > 0){
						var amountpercentage = '<i class="material-icons">keyboard_arrow_up</i> '+data.amountpercentage+'% <span class="deep-orange-text text-lighten-5">from last month</span>';
					}else{
						var amountpercentage = '<i class="material-icons">keyboard_arrow_down</i> '+data.amountpercentage+'% <span class="deep-orange-text text-lighten-5">from last month</span>';
					}
					$("#amountpercentage").html(amountpercentage);
				}
			})
}
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
$(window).on('load', function() {
	 			$.ajax({
				url: server+'/analytics/sent-sms',
				type: "GET",
				dataType:"json",
				success: function(json){ 
						// Line Chart Data	
					var lineChartData = {
						labels: json.labels,
						datasets: [{
							label: "My dataset",
							fillColor: "rgba(255,255,255,0)",
							strokeColor: "#fff",
							pointColor: "#00796b ",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(220,220,220,1)",
							data: json.data
						}]

					}				
					// Line Chart = use data var lineChartData
					var lineChart = document.getElementById("sent_sms_graph").getContext("2d");
					window.lineChart = new Chart(lineChart).Line(lineChartData, {
						scaleShowGridLines: false,
						bezierCurve: false,
						scaleFontSize: 12,
						scaleFontStyle: "normal",
						scaleFontColor: "#fff",
						responsive: true,
					});
				
				}
				})
	 		
});