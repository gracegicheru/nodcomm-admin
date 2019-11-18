$(document).ready(function() {
	setInterval(online,3000);
});

function online(){
	           
				$.ajax({
				url: server+"/dashboard/online",
				type: "GET",
				dataType:"json",
				success: function(data){ 
					$("#agents_onchat_count").html(data.agents_onchat_count);
					$("#queue_visitors_count").html(data.queue_visitors_count);
					$("#online_visitors_count").html(data.online_visitors_count);

				}
			})
}