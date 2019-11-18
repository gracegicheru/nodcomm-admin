 function transaction(sender_id, name, company, currency,amount, authoriation_document,created_at,reference,type,card,card_id,charge){
 $('#sender_id').html(sender_id);
$('#name').html(name);
$('#company').html(company);
$('#amount').html(currency+' '+amount);
$('#authoriation_document').html('<a target="_blank" class="btn btn-xs btn-default" href="'+server+'/authoriation_documents/'+authoriation_document+'" style="margin-bottom: 30px;"><i class="fa fa-file-word-o fa-lg"></i> Authorisation Document</a>');
$('#created_at').html(created_at);
$('#reference').html(reference);
$('#type').html(type);
$('#card').html(card);
$('#card_id').html(card_id);
$('#charge').html(currency+' '+charge);
 }
  function unverify(id){
var answer = confirm('Are you sure you want to unverify this sender ID?');
if (answer)
{
			var btn =$('#unverifybtn'+id);
			var formdata = $('#Verifysenderidform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/sender-id/unverify",
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>'); 
               if(data.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  data.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'Sender ID unverified successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	

				var tr = '';
				var authoriation_documents='';
				var status='';
				var action='';
				$.each(data.details, function(key, value) {
					if(value.authoriation_document !=null){
					var url =server+"/authoriation_documents/"+value.authoriation_document;
					authoriation_documents = '<a target="_blank" class="" href="'+url+'" style="margin-bottom: 30px;"><i class="material-icons">file_download</i> Authorisation Document</a>';
					}else{
					authoriation_documents ='-';	
					}
					
									if(value.verified == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Unverify" onclick="unverify('+value.id+')" id="unverifybtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Verified';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Verify" onclick="verify('+value.id+')"  id="verifybtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Unverified';
									}
					tr +='<tr><td>'+value.sender_id+'</td><td>'+value.company+'</td><td>'+value.credit+'</td><td>'+authoriation_documents+'</td><td>'+value.created_at+'</td><td>'+status+'</td><td><a style="margin-right:3px;" class="waves-effect waves-light btn tooltipped modal-trigger" href="#modal1" data-position="top" data-delay="50" data-tooltip="Payment Details" onclick="return transaction('+'\''+value.sender_id+'\''+',\''+value.user.name+'\''+',\''+value.company+'\''+',\''+ value.currency+'\''+',\''+value.amount+'\''+',\''+value.authoriation_document+'\''+',\''+value.created_at+'\''+',\''+value.reference+'\''+',\''+value.type+'\''+',\''+value.card+'\''+',\''+value.card_id+'\''+',\''+value.charge+'\')"><i class="fa fa-eye"></i></a>'+link+'</td></tr>';
				});
				$("#msg-history1").html(tr);

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-times" aria-hidden="true"></i>');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when unverifying.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
}
else
{
  return false;
}
 }
 
  function verify(id){
var answer = confirm('Are you sure you want to verify this sender ID?');
if (answer)
{
			var btn =$('#verifybtn'+id);
			var formdata = $('#Verifysenderidform').serializeArray();
			formdata.push({name: "id",
			value: id});
	        $.ajax({
            type: "POST",
            url: server+"/sender-id/verify",
            data: formdata,
            dataType:"json",
            beforeSend: function() {

            btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');        
            },
            cache: false,
            success: function(data) {
                 btn.prop("disabled", false).html('<i class="fa fa-check" aria-hidden="true"></i>'); 
               if(data.status=='error'){
					$.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  data.details,
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
               }else{
					$.gritter.add({
					title: "<strong style='color:#3ec291'>Success!</strong>",
					text:  'Sender ID verified successfully .',
					sticky: false,
					time: '',
					class_name: 'gritter-success'
				});	
				var tr = '';
				var authoriation_documents='';
				var status='';
				var action='';
				$.each(data.details, function(key, value) {
					if(value.authoriation_document !=null){
					var url =server+"/authoriation_documents/"+value.authoriation_document;
					authoriation_documents = '<a target="_blank" class="" href="'+url+'" style="margin-bottom: 30px;"><i class="material-icons">file_download</i> Authorisation Document</a>';
					}else{
					authoriation_documents ='-';	
					}
					
									if(value.verified == 1){
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Unverify" onclick="unverify('+value.id+')" id="unverifybtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-times" aria-hidden="true"></i></a>';
										status = 'Verified';
									}else{
										link ='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Verify" onclick="verify('+value.id+')"  id="verifybtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
										status = 'Unverified';
									}
					tr +='<tr><td>'+value.sender_id+'</td><td>'+value.company+'</td><td>'+value.credit+'</td><td>'+authoriation_documents+'</td><td>'+value.created_at+'</td><td>'+status+'</td><td><a style="margin-right:3px;" class="waves-effect waves-light btn tooltipped modal-trigger" href="#modal1" data-position="top" data-delay="50" data-tooltip="Payment Details" onclick="return transaction('+'\''+value.sender_id+'\''+',\''+value.user.name+'\''+',\''+value.company+'\''+',\''+ value.currency+'\''+',\''+value.amount+'\''+',\''+value.authoriation_document+'\''+',\''+value.created_at+'\''+',\''+value.reference+'\''+',\''+value.type+'\''+',\''+value.card+'\''+',\''+value.card_id+'\''+',\''+value.charge+'\')"><i class="fa fa-eye"></i></a>'+link+'</td></tr>';
				});
				$("#msg-history1").html(tr);

                    }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

                    btn.prop("disabled", false).html('<i class="fa fa-check" aria-hidden="true"></i>');
                    $.gritter.add({
					title: "<strong style='color:#fb5a43'>Oops!</strong>",
					text:  "An error occurred when verifying.Please try again",
					sticky: false,
					time: '',
					class_name: 'gritter-danger'
				});
					}
                });
}
else
{
  return false;
}
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
$("#load-more").click(function(){
	
	var btn = $(this);
		$.ajax({
		type: "get",
		url:  server+"/load_more_company_senderids",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more payments');
			}else{
				var tr = '';
				var authoriation_documents='';
				var status='';
				var action='';
				$.each(res.payments, function(key, value) {
					
					if(value.authoriation_document != null){
					var url =server+"/authoriation_documents/"+value.authoriation_document;
					authoriation_documents = '<a target="_blank" class="" href="'+url+'" style="margin-bottom: 30px;"><i class="material-icons">file_download</i> Authorisation Document</a>';
					}else{
					authoriation_documents ='-';	
					}
					if(value.step==4 &&  value.verified==0){
						status='Processing';
					}else{
						status='Pending';
					}
					if(value.step==4){
						action='-';
					}else{
						
						action='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Complete Payment" onclick="complete('+value.id+')"  id="completebtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
					}
					if((value.usage).length > 40){
					var usage = '<p>'+(value.usage).substr(0, 40)+'<a class="read-more-show" href="#">...</a> <span class="read-more-content hide">'+(value.usage).substr(40, (value.usage).length)+'<a class="read-more-hide " href="#"><i class="material-icons right">arrow_drop_down</i></a></span></p>';
				   }else{
					var usage = value.usage;    
					}
					tr +='<tr><td>'+value.sender_id+'</td><td>'+usage+'</td><td>'+value.credit+'</td><td>'+authoriation_documents+'</td><td>'+value.created_at+'</td><td>'+status+'</td><td>'+action+'</td></tr>';
				});
				$("#msg-history").append(tr);
				btn.prop("disabled", false).html('Load more');
			}
		},
		error:  function(err){
			btn.prop("disabled", false).html('Load more');
			$.gritter.add({
				title: '<strong>Oops!</strong>',
				text: 'More payments failed to load',
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
		url:  server+"/load_more_senderids",
		beforeSend:  function(){
			btn.prop("disabled", true).html('<i class="fa fa-spin fa-spinner"></i> Loading');
		},
		success:  function(res){
			if(res.status == 'no_data'){
				btn.prop("disabled", true).html('No more payments');
			}else{
				var tr = '';
				var authoriation_documents='';
				var status='';
				var action='';
				$.each(res.payments, function(key, value) {
					if(value.authoriation_document !=null){
					var url =server+"/authoriation_documents/"+value.authoriation_document;
					authoriation_documents = '<a target="_blank" class="" href="'+url+'" style="margin-bottom: 30px;"><i class="material-icons">file_download</i> Authorisation Document</a>';
					}else{
					authoriation_documents ='-';	
					}
					if(value.verified==0){
						status='Unverified';
						action='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Unverify" onclick="unverify('+value.id+')"  id="unverifybtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
					}else{
						status='Verified';
						action='<a class="btn tooltipped" data-position="top" data-delay="50" data-tooltip="Verify" onclick="verify('+value.id+')"  id="verifybtn'+value.id+'" style="margin-right:3px;"><i class="fa fa-check" aria-hidden="true"></i></a>';
					}
					tr +='<tr><td>'+value.sender_id+'</td><td>'+value.company+'</td><td>'+value.credit+'</td><td>'+authoriation_documents+'</td><td>'+value.created_at+'</td><td>'+status+'</td><td>'+action+'</td></tr>';
				});
				$("#msg-history1").append(tr);
				btn.prop("disabled", false).html('Load more');
			}
		},
		error:  function(err){
			btn.prop("disabled", false).html('Load more');
			$.gritter.add({
				title: '<strong>Oops!</strong>',
				text: 'More payments failed to load',
				sticky: false,
				time: '',
				class_name: 'gritter-danger'
			});
		}
	});
});