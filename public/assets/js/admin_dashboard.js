$(document).ready(function() {
	setInterval(online,3000);
	
});

admin_data();
function online(){
	           
				$.ajax({
				url: server+"/dashboard/online",
				type: "GET",
				dataType:"json",
				success: function(data){ 
					$("#companies_count").html(data.companies_count);
					$("#users_count").html(data.users_count);
					$("#visitors_count").html(data.visitors_count);
					$("#messages_count").html(data.messages_count);

				}
			})
}
function admin_data(){
	           
				$.ajax({
				url: server+"/admin_data",
				type: "GET",
				dataType:"json",
				success: function(data){ 
				    $("#departments").html(data.departments);
					$("#push_sites").html(data.push_sites);
					$("#chat_sites").html(data.chat_sites);
					$("#Pushnotification").html(data.Pushnotification);
					$("#messages").html(data.messages);
					$("#users").html(data.users);
					$("#visitors").html(data.visitors);
					$("#total_visitors").html(data.visitors);
					$("#newmessages").html(data.newmessages);
					$("#newusers").html(data.newusers);
					$("#newvisitors").html(data.newvisitors);
					$("#sms_credit").html("Credit# "+data.credit.credit);
				}
			})
}	
$("#phone-search-term").keyup(global_phonesms_search);
$("#ApplySMSphonefilterform").submit(function(evt){
	evt.preventDefault();
	global_phonesms_search;
});
function global_phonesms_search(){
	var search_term = $("#phone-search-term").val(),
		form = $("#ApplySMSphonefilterform"); 
		$.ajax({
			type: "post",
			data: form.serialize(),
			url:  form.attr("action"),
			dataType: "json",
			beforeSend: function(){
				$("#apply-phone-filter").prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i>  Searching'); 
			},
			success: function(res){

			$("#apply-phone-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');	
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
				$("#apply-phone-filter").prop("disabled", false);
				$("#load-more1").removeClass('hide');
				//$(".timesmsform").addClass('hide');

			}
			$(".phonesmstable").removeClass('hide');
			},
			error: function(err){
			$("#apply-phone-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');
			}
		});

}
$("#load-more1").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  server+"/search_more_sms_by_phone",
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
				url: server+'/graphs/visitors',
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
					var lineChart = document.getElementById("visitors_graph").getContext("2d");
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
				
				$.ajax({
				url: server+'/graphs/credit-buying',
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
					var lineChart = document.getElementById("line-chart").getContext("2d");
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

			  $.ajax({
				url: server+'/graphs/credit-amount',
				type: "GET",
				dataType:"json",
				success: function(json){
					var polarData = [];		
					var i = 0;
					var colors=["#f44336","#9c27b0", "#3f51b5","#2196f3 ","#ff9800","#009688"];
					var highlight=["#FF5A5E","#ce93d8","#7986cb","#90caf9","#ffb74d", "#80cbc4"];
				$.each(json.final , function(key, value) {
					var credits = {};
					credits.value=value;
					credits.color=colors[i];
					credits.highlight=highlight[i];
					credits.label=key;
					polarData.push(credits);

				 i++;	
				});
				
					var polarChartCountry = document.getElementById("polar-chart-country").getContext("2d");
					window.polarChartCountry = new Chart(polarChartCountry).PolarArea(polarData, {
						segmentStrokeWidth: 1,
						responsive: true
					});
				}
				})
				
			  $.ajax({
				url: server+'/graphs/sent-sms',
				type: "GET",
				dataType:"json",
				success: function(json){
					var polarData = [];		
					var i = 0;
					var colors=["#f44336","#9c27b0", "#3f51b5","#2196f3 ","#ff9800","#009688"];
					var highlight=["#FF5A5E","#ce93d8","#7986cb","#90caf9","#ffb74d", "#80cbc4"];
				$.each(json.final , function(key, value) {
					var credits = {};
					credits.value=value;
					credits.color=colors[i];
					credits.highlight=highlight[i];
					credits.label=key;
					polarData.push(credits);
				 i++;	
				});
				
				var polarChartCountry = document.getElementById("polar-chart-credit").getContext("2d");
				window.polarChartCountry = new Chart(polarChartCountry).PolarArea(polarData, {
					segmentStrokeWidth: 1,
					responsive: true
				});
				}
				})
 });
 /*var ref = firebase.database().ref("chats");
ref.orderByChild("company_id").equalTo(parseInt(company_id)).once("value", function(snapshot) {
  console.log(snapshot.val());
   snapshot.forEach(function(childsnapshot) {
    console.log(childsnapshot.val().content.dashboard);
  });
});*/