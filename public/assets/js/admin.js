$(document).ready(function() {
   //$("body").tooltip({ selector: '[data-toggle=tooltip]' });	
//$('.tooltipped').tooltip({selector: '[data-toggle=tooltip]' });
var loading = false;
window.setInterval(goActive, 3000);

function goActive(){
	if(loading){
		return;
	}else{
		$.ajax({
			url:server+'/savelastactivity',
			type: "GET",
			beforeSend: function(){
				loading = true;
			},
			success: function(data){
				loading = false;
			},
			error: function(err){
				loading = false;
			}
		});
	}
}

});