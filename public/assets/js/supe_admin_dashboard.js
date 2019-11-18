$(document).ready(function() {
	setInterval(online,3000);
});
			$.ajax({
				url: server+"/maps/companies",
				type: "GET",
				dataType:"json",
				success: function(data){
					
				var markers_array = [];
				$.each(data.countries, function(key, value) {
					
						var countries = {};
						countries.latLng=[value.latitude, value.longitude];
						countries.name=value.country +':'+ value.count;
						countries.style={fill: '#26c6da'};
						markers_array.push(countries);
				});
				map(markers_array);
				}
			})	
					function map(markers_array){
			
   jQuery('#world-map-markers').vectorMap({
        map: 'world_mill_en'
        , backgroundColor: '#383f47'
        , borderColor: '#ccc'
        , borderOpacity: 0.9
        , borderWidth: 1
        , zoomOnScroll : false
        , color: '#ddd'
        , regionStyle: {
            initial: {
                fill: '#fff' 
            }
        }
        , markerStyle: {
            initial: {
            /*    r: 8
                , 'fill': '#26c6da'
                , 'fill-opacity': 1
                , 'stroke': '#000'
                , 'stroke-width': 0
                , 'stroke-opacity': 1*/

				 image: server+'/images/location.jpg',
            }
        , }
        , enableZoom: true
        , hoverColor: false
        , markers:markers_array
        , hoverOpacity: null
        , normalizeFunction: 'linear'
        , selectedRegions: []
        , showTooltip: true
        , onRegionClick: function (element, code, region) {
            //var message = 'You clicked "' + region + '" which has the code: ' + code.toUpperCase();
            //alert(message);
        }
    });	
}
super_admin_data();
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
function super_admin_data(){
	           
				$.ajax({
				url: server+"/super_admin_data",
				type: "GET",
				dataType:"json",
				success: function(data){ 
					$("#messages").html(data.messages);
					$("#users").html(data.users);
					$("#visitors").html(data.visitors);
					$("#companies").html(data.companies);
					$("#newcompanies").html(data.newcompanies);
					$("#newmessages").html(data.newmessages);
					$("#newusers").html(data.newusers);
					$("#newvisitors").html(data.newvisitors);
					$("#week").html('Mon '+data.earning_array.monday+'- Sun '+data.earning_array.sunday);
					$("#week1").html('Mon '+data.earning_array.monday+'- Sun '+data.earning_array.sunday);
					$("#week2").html('Mon '+data.earning_array.monday1+'- Sun '+data.earning_array.sunday1);
					$("#week3").html('Mon '+data.earning_array.monday2+'- Sun '+data.earning_array.sunday2);
					$("#week4").html('Mon '+data.earning_array.monday3+'- Sun '+data.earning_array.sunday2);
					$("#earning").html(data.earning_array.earning);
					$("#earning1").html(data.earning_array.earning1);
					$("#earning2").html(data.earning_array.earning2);
					$("#earning3").html(data.earning_array.earning3);
					$("#total_traffic").html(data.total_traffic+' Messages');
					$("#total_cost").html('KES '+data.total_traffic);
				}
			})
}

$("#company-search-term").keyup(global_company_search);
$("#ApplyCompanynamefilterform").submit(function(evt){
	evt.preventDefault();
	global_company_search;
});
function global_company_search(){
	var search_term = $("#company-search-term").val(),
		form = $("#ApplyCompanynamefilterform"); 
		$.ajax({
			type: "post",
			data: form.serialize(),
			url:  form.attr("action"),
			dataType: "json",
			beforeSend: function(){
				$("#apply-company-name-filter").prop("disabled", true).html(' <i class="fa fa-spinner fa-spin"></i>  Searching'); 
			},
			success: function(res){

			$("#apply-company-name-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');	
			if(res.status == 'no_data'){
				
				$("#msg-history3").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;">No Company found</div></td></tr>');
				$("#load-more3").addClass('hide');
			}else{
				var tr = '';
				$.each(res.companies, function(key, value) {

				if(value.active == 1){
					status = 'Active';
				}else{
					status = 'Inactive';
				}
					tr +='<tr><td>'+value.name+'</td><td>'+value.website+'</td><td>'+status+'</td><td><a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Login as Company" href="'+server+'/admin/login/'+value.id+'"  target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a></td></tr>';
					});
				$("#msg-history3").html(tr);
				$("#apply-company-name-filter").prop("disabled", false);
				$("#load-more3").removeClass('hide');


			}
			$(".CompanyNametable").removeClass('hide');
			},
			error: function(err){
			$("#apply-company-name-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');
			}
		});

}
$("#load-more3").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  server+"/load_company_by_name_search_more",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more companies');
			}else{
				var tr = '';
				$.each(res.companies, function(key, value) {

				if(value.active == 1){
					status = 'Active';
				}else{
					status = 'Inactive';
				}
					tr +='<tr><td>'+value.name+'</td><td>'+value.website+'</td><td>'+status+'</td><td><a class="btn tooltipped" data-position="top" data-delay="50"  data-tooltip="Login as Company" href="'+server+'/admin/login/'+value.id+'"  target="_blank"> <i class="fa fa-sign-in" aria-hidden="true"></i></a></td></tr>';
			 });
				$("#msg-history3").html(tr);
				btn.prop("disabled", false).html('Load more');
			}
		},
		error:  function(err){
			btn.prop("disabled", false).html('Load more');
			$.gritter.add({
				title: '<strong>Oops!</strong>',
				text: 'Companies failed to load',
				sticky: false,
				time: '',
				class_name: 'gritter-danger'
			});
		}
	});
});

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
            success: function(json) {
				$("#apply-time-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');	
				  $("#morris-donut").html('');
				  
				  if(json.status != 'no_data'){
				  //Donut Chart
				  Morris.Donut({
					element: 'morris-donut',
					data: [{
					  label: 'Delivered',
					  value: json.sentpercentage
					}, {
					  label: 'Failed',
					  value: json.failedpercentage
					}],
					formatter: function(y) {
					  return y + "%"
					}
				  });
				  	$("#total_traffic").html(json.messages+' Messages');
					$("#total_cost").html('KES '+json.messages);				
					$("#filter_title").html(json.date_range);
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
			var profitLineChart = document.getElementById("trending-line-chart").getContext("2d");
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
					
					}else{
				    $("#total_traffic").html('0 Messages');
					$("#total_cost").html('KES 0');
					//Donut Chart
				  Morris.Donut({
					element: 'morris-donut',
					data: [{
					  label: 'Delivered',
					  value: 0
					}, {
					  label: 'Failed',
					  value:0
					}],
					formatter: function(y) {
					  return y + "%"
					}
				  });
					}

				},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					$("#apply-time-filter").prop("disabled", false).html('<i class="fa fa-check"></i> Search');	
					}
				});
	e.preventDefault();
});
$(function() {
				$.ajax({
				url: server+"/deliveredandfailedmessages",
				type: "GET",
				dataType:"json",
				success: function(data){ 
				  //Donut Chart
				  Morris.Donut({
					element: 'morris-donut',
					data: [{
					  label: 'Delivered',
					  value: data.sentpercentage
					}, {
					  label: 'Failed',
					  value: data.failedpercentage
					}],
					formatter: function(y) {
					  return y + "%"
					}
				  });
				}
			})


});