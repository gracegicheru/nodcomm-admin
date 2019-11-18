$(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(".addfilter").click(function(){
		$(".filter-wrapper").slideToggle("slow");
		$(this).addClass("hide");
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
		$("#gateways-filter").material_select();
		$("#sites-filter").material_select();
		$("#status-filter").material_select();
		apply_filters("all", "all", "all");
	});

	function get_filters(){
		$.ajax({
			type: "get",
			url: URL+"/messages/filters/get",
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
					$("#gateways-filter").material_select();
				}else{
					$("#gateways-filter").prop("disabled", true);
				}

				if(Object.keys(res.sites).length > 0){
					$.each(res.sites, function(key, site){
						sites += '<option value="'+site.id+'">'+site.name+'</option>';
					});
					$("#sites-filter").html(sites);
					$("#sites-filter").material_select();
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
			url: URL+"/messages/filters/apply",
			data: {_token:csrf,gateways_filter: gateways_filter, sites_filter: sites_filter, status_filter: status_filter},
			dataType: "json",
			beforeSend: function(){
				$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;"><i class="fa fa-spinner fa-pulse"></i></div></td></tr>');
				$(".apply-filter").prop("disabled", true);
			},
			success: function(res){
			if(res.status == 'no_data'){
				$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
			}else{
				var tr = '';
				$.each(res.data, function(key, value) {
					if(value.status=='success'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.msisdn+'</td><td>'+value.smsgateway.name+'</td><td>'+value.site.name+'</td><td>'+span+'</td></tr>';
				});
				$("#msg-history").html(tr);
				$(".apply-filter").prop("disabled", false);
				$("#load-more").addClass('hide');
				$("#load-more2").removeClass('hide');
				$("#load-more1").addClass('hide');
			}
			},
			error: function(err){
				$(".apply-filter").prop("disabled", false);
			}
		});
	}
});


$('#apply-filter').click(function(event){
	event.preventDefault();


	console.log("this");
	let formdata = $('#ApplyCompanyfilterform').serializeArray();


	$.ajax({
		type: "POST",
		url: "/company/messages/filters/apply",
		data:formdata,
		dataType:"json",
		success: function(data){
			console.log("thisdata", data);
			if(data.status=="ok"){
				// console.log("new");
				let rows="";

				let tableBody = $('#msg-history');
				tableBody.html('');
				$.each(data.collection, function(key, val){
					// console.log("hello",val.created_at);

				rows+='<tr>' +
					'<td>' + val.created_at + '</td>' +
					'<td>' + val.message + '</td>' +
					'<td>' + val.phone + '</td>' +
					'<td>' + val.status + '</td>' +
					'</tr>' ;

				});
				$("#msg-history").html(rows);

				}


		},
		error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
// 					$("#apply-filter").prop("disabled", false);

		}


		});

});

$("#load-more").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  URL+"/sms/load-more",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more sms');
				$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='success'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.msisdn+'</td><td>'+value.smsgateway.name+'</td><td>'+value.site.name+'</td><td>'+span+'</td></tr>';
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
$("#load-more1").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  URL+"/sms/load_search_more",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more sms');
				$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='success'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.msisdn+'</td><td>'+value.smsgateway.name+'</td><td>'+value.site.name+'</td><td>'+span+'</td></tr>';
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
$("#load-more3").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  URL+"/sms/load-more",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more sms');
				$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='success'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.msisdn+'</td><td>'+span+'</td></tr>';
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
$("#load-more2").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  URL+"/sms/load_more_apply_filters",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more sms');
				$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='success'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.msisdn+'</td><td>'+value.smsgateway.name+'</td><td>'+value.site.name+'</td><td>'+span+'</td></tr>';
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
$("#load-more4").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  URL+"/sms/load_search_more",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more sms');
				$("#msg-history").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='success'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.msisdn+'</td><td>'+span+'</td></tr>';
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
$("#load-more5").click(function(){
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  URL+"/sms/load_more_apply_company_filters",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more sms');
				$("#msg-history").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;">No more sms</div></td></tr>');
			}else{
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='success'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.msisdn+'</td><td>'+span+'</td></tr>';
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
$("#sms-search-term").keyup(global_sms_search);
$("#searchSMSForm").submit(function(evt){
	evt.preventDefault();
	global_sms_search;
});
//
// $("#sms-search-term1").keyup(global_sms_search1);
// console.log("Hey");
// $("#searchSMSForm1").submit(function(evt){
// 	evt.preventDefault();
// 	global_sms_search1;
// 	console.log("this");
//
// });
	//search function
function global_sms_search(){
	var search_term = $("#sms-search-term").val(),
		form = $("#searchSMSForm"); 
		$.ajax({
			type: "post",
			data: form.serialize(),
			url:  form.attr("action"),
			dataType: "json",
			beforeSend: function(){
				$("#msg-history").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;"><i class="fa fa-spinner fa-pulse"></i></div></td></tr>');
			},
			success: function(res){
			if(res.status == 'no_data'){
				$("#msg-history").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;">No sms is found</div></td></tr>');
			}else{
				$("#msg-history").html('');
				var tr = '';
				$.each(res.messages, function(key, value) {
					if(value.status=='success'){
						var span ='<span class=" badge green">Sent</span>';
					}else{
						var span ='<span class=" badge red">Failed</span>';
					}
					if((value.message).length > 40){
					var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
				   }else{
					var message = value.message;    
					}
					tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.msisdn+'</td><td>'+value.smsgateway.name+'</td><td>'+value.site.name+'</td><td>'+span+'</td></tr>';
				});
				$("#msg-history").append(tr);
				$("#load-more").addClass('hide');
				$("#load-more1").removeClass('hide');
				$("#load-more2").addClass('hide');
			}
			},
			error: function(err){
				$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;">No sms is found</div></td></tr>');
			}
		});

}


$('#sms-search-term1').click(function(event) {
	event.preventDefault();

	console.log("this");

	let formInformation = $('#searchSMSForm1').serializeArray();

	$.ajax({
		type: "POST",
		url: '/messages/search',
		data: formInformation,
		dataType: "json",
		success: function (data) {
			 console.log("thisdata", data);
			if (data.status == "ok") {
				// console.log("new");
				let rows = "";

				let tableBody = $('#msg-history');
				tableBody.html('');
				$.each(data.collection, function (key, val) {
					// console.log("hello",val.created_at);

					rows += '<tr>' +
						'<td>' + val.created_at + '</td>' +
						'<td>' + val.message + '</td>' +
						'<td>' + val.phone + '</td>' +
						'<td>' + val.status + '</td>' +
						'</tr>';

				});
				$("#msg-history").html(rows);

			} else {
				$("#msg-history").html('<tr><td colspan="4"><div class="text-center" style="padding: 10px 0px;">No sms Found</div></td></tr>');

			}


		}


	});
});


function global_sms_search1(){

	// var search_term = $("#sms-search-term1").val(),
	// 	form = $("#searchSMSForm1");
	// 	$.ajax({
	// 		type: "post",
	// 		data: form.serialize(),
	// 		url:  form.attr("action"),
	// 		dataType: "json",
	// 		beforeSend: function(){
	// 			$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;"><i class="fa fa-spinner fa-pulse"></i></div></td></tr>');
	// 		},
	// 		success: function(res){
	// 		if(res.status == 'no_data'){
	// 			$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;">No sms is found</div></td></tr>');
	// 		}else{
	// 			$("#msg-history").html('');
	// 			var tr = '';
	// 			$.each(res.messages, function(key, value) {
	// 				if(value.status=='success'){
	// 					var span ='<span class=" badge green">Sent</span>';
	// 				}else{
	// 					var span ='<span class=" badge red">Failed</span>';
	// 				}
	// 				if((value.message).length > 40){
	// 				var message = '<p>'+(value.message).substr(0, 40)+'<a class="read-more-show" href="#"> Read More</a> <span class="read-more-content hide">'+(value.message).substr(40, (value.message).length)+'<a class="read-more-hide " href="#"> Read Less</a></span></p>';
	// 			   }else{
	// 				var message = value.message;
	// 				}
	// 				tr +='<tr><td>'+value.created_at+'</td><td>'+message+'</td><td>'+value.msisdn+'</td><td>'+span+'</td></tr>';
	// 			});
	// 			$("#msg-history").append(tr);
	// 			$("#load-more3").addClass('hide');
	// 			$("#load-more4").removeClass('hide');
	// 			$("#load-more5").addClass('hide');
	// 		}
	// 		},
	// 		error: function(err){
	// 			$("#msg-history").html('<tr><td colspan="6"><div class="text-center" style="padding: 10px 0px;">No sms is found</div></td></tr>');
	// 		}
	// 	});

}
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
$('#paybtn').click(function(e) {
			var btn = $(this);
			$.ajax({
            type: "POST",
            url: $('#paymentamountform').attr("action"),
            data: $('#paymentamountform').serialize(),
			dataType:"json",
            beforeSend: function() {
				btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Paying'); 
			 },
            cache: false,
            success: function(res) {
				btn.prop("disabled", false).html('Continue'); 
				if(res.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  res.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{  
				/*var paymentscript = document.getElementById('paymentscript');
				var amount = paymentscript.setAttribute('data-amount',res.amount_payed);
				//alert(amount);
				$('.payment-option-btn').attr('data-amount', res.amount_payed);

				$("#paybtn").addClass('hide');
				$(".payment-option-btn").removeClass('hide');*/
				window.location.replace(res.details);

		}
				},
					error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..
					btn.prop("disabled", false).html('Continue'); 
						
					}
				});
	e.preventDefault();
});
//console.log(loadmambojsfile("https://api.mambowallet.com/static/js/wallet.checkout.1.0.js", "js", 100));
/*function loadjscssfile(filename, filetype){
    if (filetype=="js"){ //if filename is a external JavaScript file
        var fileref=document.createElement('script')
        fileref.setAttribute("type","text/javascript")
        fileref.setAttribute("src", filename)
    }
    else if (filetype=="css"){ //if filename is an external CSS file
        var fileref=document.createElement("link")
        fileref.setAttribute("rel", "stylesheet")
        fileref.setAttribute("type", "text/css")
        fileref.setAttribute("href", filename)
    }
    if (typeof fileref!="undefined")
        document.getElementsByTagName("head")[0].appendChild(fileref)
}*/

function loadmambojsfile(filename, filetype, amount){
    if (filetype=="js"){ //if filename is a external JavaScript file
        var fileref=document.createElement('script')
        fileref.setAttribute("type","text/javascript")
        fileref.setAttribute("src", filename)
		fileref.setAttribute("id", "paymentscript")
		fileref.setAttribute("data-class","wallet-button")
        fileref.setAttribute("data-key", "wallet_Os07qIC8uafJdgKqOs07qIC8uafJdgKq")
		fileref.setAttribute("data-amount", amount)
		fileref.setAttribute("data-name","SMS Credit")
        fileref.setAttribute("data-description", "Sms credit top up")
		fileref.setAttribute("data-image", URL+"/images/Nodcomm.png")
		fileref.setAttribute("data-locale","auto")
        fileref.setAttribute("data-mobile", "")
		fileref.setAttribute("data-currency", "KES")
		fileref.setAttribute("data-email",paymentemail)
        fileref.setAttribute("data-label", "Pay With Card")
		fileref.setAttribute("data-zip", "true")
    }
    //if (typeof fileref!="undefined")
     document.getElementsByTagName("head")[0].appendChild(fileref)
	//$(".payment-option-btn").appendChild(fileref)
}