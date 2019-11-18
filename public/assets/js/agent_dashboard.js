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