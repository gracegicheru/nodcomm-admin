$(document).ready(function() {
	setInterval(online_agents,3000);
});
function online_agents(){
	           
				$.ajax({
				url: server+"/agents/all/online",
				type: "GET",
				dataType:"json",
				success: function(data){ 
					var li='';
					$("#online_agents_count").html(data.length);
					if(data!='' && data!=null){
					
					$.each(data, function(key, value) {
					li +='<li class="list-group-item clearfix"><div class=" " style="width:42px;height:42px;font-size:20px;float:left;line-height: 38px"><i class="fa fa-user-o"></i></div>';
					li +='<div class="pull-left" style="margin-left: 10px;"><span> '+value.name+' </span><br/><small class="text-muted" style="color:#65cea7" ><i class="fa fa-clock-o"></i>  online </small></div></li>';

					$("#online_agents").html(li);
					
					}); 
					}else{
					li +='<li class="list-group-item clearfix"> No online agents</li>';	
					$("#online_agents").html(li);
					}

				}
			})
}