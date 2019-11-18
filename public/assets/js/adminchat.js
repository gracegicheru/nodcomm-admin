$(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(".code textarea").focus(function() {
	    var $this = $(this);
	    $this.select();

	    // Work around Chrome's little problem
	    $this.mouseup(function() {
	        // Prevent further mouseup intervention
	        $this.unbind("mouseup");
	        return false;
	    });
	});

	$(".visitor-menu li").click(function(){
		$(".visitor-menu li").removeClass("selected");
		$(this).addClass("selected");

		if($(this).attr("id") == "visitors-lnk"){
			$(".chats-tbl").addClass("hide");
			$(".all-visitors-tbl").addClass("hide");
			$(".visitors-tbl").removeClass("hide");
			$('.box-title').html("Visitors");
		}else if($(this).attr("id") == "allvisitors-lnk"){
			$(".chats-tbl").addClass("hide");
			$(".visitors-tbl").addClass("hide");
			$(".all-visitors-tbl").removeClass("hide");
			$('.box-title').html("All Visitors");
		}else{
			$(".visitors-tbl").addClass("hide");
			$(".all-visitors-tbl").addClass("hide");
			$(".chats-tbl").removeClass("hide");
			$('.box-title').html("Chats");
		}
	});

	$(document).on("click", ".v-dets", function(){
		var data = $(this).data("visitor");
		var location = "";
		var visits = "";
		var chats = "";

		if(data.city != "" && data.region != "" && data.country != ""){
			location = data.city + "," + data.region + "," + data.country;
		}else if(data.city == "" && data.region != "" && data.country != ""){
			location = data.region + "," + data.country;
		}else if(data.city != "" && data.region == "" && data.country != ""){
			location = data.city + "," + data.country;
		}else if(data.city == "" && data.region == "" && data.country != ""){
			location = data.country;
		}else{
			location = data.city + "," + data.region + "," + data.country;
		}

		if(data.chats == 0){
			chats = "0 chats";
		}else if(data.chats == 1){
			chat = "1 chat";
		}else{
			chat = data.chats + " chats";
		}

		if(data.visits == 0){
			visits = "0 visits";
		}else if(data.visits == 1){
			visits = "1 visit";
		}else{
			visits = data.visits + " visits";
		}

		$("#visitor-ip").html(data.ip);
		$("#visitor-location").html(location);
		$("#visitor-where-from").html(data.current_page);
		$("#visitor-visits").html(visits);
		$("#visitor-chats").html(chats);
		$("#visitor-browser").html(data.browser);
		$("#visitor-os").html(data.os);
		//$("#").html(data.);

		$(".visitor-details-container").show();
	});

	$(document).on("click", ".online-v-dets", function(){
		var data = JSON.parse(decodeURIComponent($(this).data("visitor")));
		var location = "";
		var visits = "";
		var chats = "";

		if(data.city != "" && data.region != "" && data.country != ""){
			location = data.city + "," + data.region + "," + data.country;
		}else if(data.city == "" && data.region != "" && data.country != ""){
			location = data.region + "," + data.country;
		}else if(data.city != "" && data.region == "" && data.country != ""){
			location = data.city + "," + data.country;
		}else if(data.city == "" && data.region == "" && data.country != ""){
			location = data.country;
		}else{
			location = data.city + "," + data.region + "," + data.country;
		}

		if(data.chats == 0){
			chats = "0 chats";
		}else if(data.chats == 1){
			chat = "1 chat";
		}else{
			chat = data.chats + " chats";
		}

		if(data.visits == 0){
			visits = "0 visits";
		}else if(data.visits == 1){
			visits = "1 visit";
		}else{
			visits = data.visits + " visits";
		}

		$("#visitor-ip").html(data.ip);
		$("#visitor-location").html(location);
		$("#visitor-where-from").html(data.current_page);
		$("#visitor-visits").html(visits);
		$("#visitor-chats").html(chats);
		$("#visitor-browser").html(data.browser);
		$("#visitor-os").html(data.os);
		//$("#").html(data.);

		$(".visitor-details-container").show();
	});

	$(document).on("click", ".accept-chat-btn", function(){
		var token = $(this).data('row');
		accept_chat(token);
	});

	$(".chat-reply-send").click(function(){
		var txt = $(".chat-reply-input").val();
		var _class = $(".chat-content-container").attr("class").split(' ');
		var sess = _class[1].split('-')[3];

		if(txt != ""){
			$(".chat-reply-input").val('');
			send_message(txt, sess);
		}
	});

	$(".ban-visitor").click(function(){
		var btn = $(this),
			id = btn.data("vid");

		$.ajax({
			type: "post",
			url: URL+'/visitors/ban',
			data: {visitor_identifier: id},
			dataType: "json",
			beforeSend: function(){
				btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Please wait');
			},
			success: function(res){
				//success
				if(res.status == "success"){
					btn.prop("disabled", true).html('<i class="fa fa-check"></i> Banned');
					$.gritter.add({
						title: "<strong style='color:#3ec291'>Success!</strong>",
						text:  'Visitor banned',
						sticky: false,
						time: '',
						class_name: 'gritter-success'
					});
				}
				console.log(res);	
			},
			error: function(err){
				//error
			}
		});		
	});

	$(".chat-item-select").click(function(){
		var token = $(this).data("chatitemvsess");
		$(".chat-item-select").removeClass("active");
		$(this).addClass("active");

		switch_chat_display(token);
	});

	$(".nc-tab-item").click(function(){
		$(".nc-tab-item").removeClass("active");
		$(".nc-tab-title").removeClass("active");
		$(this).addClass("active").find('.nc-tab-title').addClass("active");

		if($(this).hasClass("nc-tab-item-info")){
			$(".nc-tab-content").removeClass("active");
			$(".nc-tab-info").addClass("active");
		}else if($(this).hasClass("nc-tab-item-nav")){
			$(".nc-tab-content").removeClass("active");
			$(".nc-tab-nav").addClass("active");
			fetch_navigation();
		}else if($(this).hasClass("nc-tab-item-history")){
			$(".nc-tab-content").removeClass("active");
			$(".nc-tab-history").addClass("active");
			fetch_history();
		}
	});

	$(document).on("click", ".arch-chat", function(){
		var token = $(this).data("sess"),
			elem = $(this);

		if(elem.next().hasClass("arch-chat-wrapper")){
			elem.next().remove();
		}else{
			$.ajax({
				type: "post",
				url:  URL+"/visitor/archived-messages",
				data: {session: token},
				dataType: "json",
				beforeSend: function(){
					elem.after('<div class="arch-chat-wrapper">'+
							'<i class="fa fa-pulse fa-spinner fa-fw"></i>'+
						  '</div>');
				},
				success: function(res){
					if(res.status == "success"){
						var html = '<div>'+
							'<div>'+
								'<span class="title-label">Name:</span>'+
								'<span>'+res.data[0].name+'</span>'+
							'</div>'+
							'<div>'+
								'<span class="title-label">Email:</span>'+
								'<span>'+res.data[0].email+'</span>'+
							'</div>'+
					    '</div>'+
					    '<hr>';

					    $.each(res.data[0].messages, function(key, row){ 
							if(row.from == "V"){
								html += '<div>'+
											'<div>'+
												'<div>'+
													'<span>['+row.created_at+']</span> <span style="color:#f3931c;font-weight: 600;">'+res.data[0].name+'</span>'+
												'</div>'+
												'<div>'+
													'<div>'+row.message+'</div>'+
												'</div>'+
											'</div>'+
										'</div>';
							}else{
								html += '<div>'+
											'<div>'+
												'<div>'+
													'<span>['+row.created_at+']</span> <span style="color:#000;font-weight: 600;">'+res.data[0].agent.name+'</span>'+
												'</div>'+
												'<div>'+
													'<div>'+row.message+'</div>'+
												'</div>'+
											'</div>'+
										'</div>';
							}
						});
						$(".arch-chat-wrapper").html(html);
					}
				}
			});
		}

		
	});

	var online_visitors_loading = false;
	var chat_status_loading = false;
	var chat_status_v = null;

	online_visitors("init");
	window.setTimeout(function(){
		chat_status_v = window.setInterval(chat_status, 3000);
	}, 2000);

	function online_visitors(init){
		var tbl = $("#visitors-tbl-body");
		if(online_visitors_loading){
			return;
		}
		$.ajax({
			type: "get",
			url: URL+'/visitors/online',
			dataType: "json",
			beforeSend: function(){
				online_visitors_loading = true;
			},
			success: function(res){
				if(res.status == "success"){
					var chats_pending = false;
					$.each(res.data, function(key, value){
						var accept_elem = "";
						var chat_waiting_class = "";
						if(value.chat_waiting == 1){
							accept_elem = '<div><a class="btn btn-primary btn-xs accept-chat-btn" data-row="'+value.id+'">Accept</a></div>';
							chat_waiting_class = "chat-request-row";
							chats_pending = true;
						}
						tbl.html('<tr class="'+chat_waiting_class+'">'+
								'<td><i class="fa fa-user" style="color:green;"></i></td>'+
								'<td>'+
									'<div>'+
										'<span style="padding-right: 5px;"><img style="width:20px;height:20px;" src="'+value.flag+'" /></span>'+
										'<span>'+value.ip+'</span>'+
										'<span><a class="online-v-dets" data-visitor="'+encodeURIComponent(JSON.stringify(value))+'">Details</a></span>'+
									'</div>'+
									accept_elem +
								'</td>'+
								'<td>'+value.agent.name+'('+value.agent.email+')</td>'+
								'<td>'+value.current_page+'</td>'+
								'<td>'+value.name+'('+value.url+')</td>'+
								'<td>'+value.visits+'</td>'+
								'<td>'+value.chats+'</td>'+
							'</tr>');
					});

					if(init == "init"){
						window.setInterval(online_visitors, 5000);
					}

					if(chats_pending == true){
						$.playSound(URL+"/sounds/elevator_ding685385892.mp3");
					}
					
				}else if(res.status == "no_visitors"){
					if(init == "init"){
						window.setInterval(online_visitors, 5000);
					}

					tbl.html('<tr>'+
								'<td class="text-center" colspan="7">'+
									'<div style="padding:20px;">You have no visitors</div>'+
								'</td>'+
							'</tr>');
				}
				online_visitors_loading = false;	
			},
			error: function(err){
				//error
				online_visitors_loading = false;
			}
		});
	}

	function accept_chat(token){
		var wrapper = $(".chats-present-wrapper");

		$.ajax({
			type: "post",
			url: URL+'/chats/accept',
			data: {id: token},
			dataType: "json",
			beforeSend: function(){
				$(".visitors-tbl").addClass("hide");
				$(".all-visitors-tbl").addClass("hide");
				$(".chats-tbl").removeClass("hide");
				$('.box-title').html("Chats");

				$(".visitor-menu li").removeClass("selected");
				$("#chats-lnk").addClass("selected");

				$(".no-chats-wrapper").addClass("hide");
				$(".chats-present-wrapper").addClass("hide");
				$(".chats-loading").removeClass("hide");
			},
			success: function(res){
				if(res.status == "success"){
					var device_info = $.parseJSON(res.data.device_info);
					var location = '';
					var chats = '';
					var visits = '';
					messages_html = '';

					console.log(res);

					wrapper.find(".chat-item-select-wrapper").html('<div class="chat-item-select active" data-chatitemvsess="'+res.active_chat.session+'">'+
                                              							'<div>'+res.active_chat.visitor.name+'</div>'+
                                              						'</div>');

					$.each(res.chats, function(key, chat){
						if(chat.session != res.active_chat.session){
							wrapper.find(".chat-item-select-wrapper").append('<div class="chat-item-select" data-chatitemvsess="'+chat.session+'">'+
                                              							'<div>'+chat.visitor.name+'</div>'+
                                              						'</div>');
						}
					});
					
					wrapper.find(".chat-content-container").removeClass().addClass("chat-content-container chat-cont-vsess-"+res.active_chat.session);
					wrapper.find("#chat-visitor-name").html(res.data.name);
					wrapper.find("#chat-visitor-flag").attr("src", res.data.flag);
					wrapper.find("#chat-visitor-referrer").html('-');
					wrapper.find("#chat-visitor-ip").html(res.data.ip);
					wrapper.find(".ban-visitor").attr("data-vid", res.data.identifier);

					if(res.data.city != "" && res.data.region != "" && res.data.country != ""){
						location = res.data.city + "," + res.data.region + "," + res.data.country;
					}else if(res.data.city == "" && res.data.region != "" && res.data.country != ""){
						location = res.data.region + "," + res.data.country;
					}else if(res.data.city != "" && res.data.region == "" && res.data.country != ""){
						location = res.data.city + "," + res.data.country;
					}else if(res.data.city == "" && res.data.region == "" && res.data.country != ""){
						location = res.data.country;
					}else{
						location = res.data.city + "," + res.data.region + "," + res.data.country;
					}

					if(res.data.chats == 0){
						chats = "0 chats";
					}else if(res.data.chats == 1){
						chat = "1 chat";
					}else{
						chat = res.data.chats + " chats";
					}

					if(res.data.visits == 0){
						visits = "0 visits";
					}else if(res.data.visits == 1){
						visits = "1 visit";
					}else{
						visits = res.data.visits + " visits";
					}

					$.each(res.active_chat.messages, function(key, message){
						if(message.from == "V"){
							messages_html += '<div class="single-message-wrapper chat-visitor" data-msgid="'+message.id+'">'+
												'<div class="chat-sender-name">'+res.active_chat.visitor.name+'</div>'+
												'<div class="chat-message">'+message.message+'</div>'+
												'<div class="chat-message-time">'+message.created_at+'</div>'+
											 '</div>';
						}else{
							messages_html += '<div class="single-message-wrapper chat-agent" data-msgid="'+message.id+'">'+
												'<div class="chat-sender-name">'+res.active_chat.visitor.agent[0].name+'</div>'+
												'<div class="chat-message">'+message.message+'</div>'+
												'<div class="chat-message-time">'+message.created_at+'</div>'+
											 '</div>';
						}
					});

					wrapper.find(".chat-content").html(messages_html);
					wrapper.find(".chat-content-container").removeClass().addClass("chat-content-container chat-cont-vsess-"+res.active_chat.session);

					wrapper.find("#chat-visitor-location").html(location);
					wrapper.find("#chat-visitor-chats").html(chat);
					wrapper.find("#chat-visitor-visits").html(visits);
					wrapper.find("#chat-visitor-browser").html(device_info.browser.name + " ver" + device_info.browser.major);
					wrapper.find("#chat-visitor-os").html(device_info.os.name + device_info.os.version);
					
					$(".chats-loading").addClass("hide");
					wrapper.removeClass("hide");

					//wrapper.find(".").html(res.data[0].);
				}else if(res.status == "no_active_chats"){
					$(".chats-loading").addClass("hide");
					$(".no-chats-wrapper").removeClass("hide");
				}	
			},
			error: function(err){
				//error
			}
		});
	}

	function chat_status(){
		var tbl = $("#visitors-tbl-body");
		if(chat_status_loading){
			return;
		}
		$.ajax({
			type: "get",
			url: URL+'/chats/status',
			dataType: "json",
			beforeSend: function(){
				chat_status_loading = true;
			},
			success: function(res){
				if(res.status == "success"){
					messages_html = '';
					$.each(res.data, function(key, value){
						var elem = $(".chat-item-select-wrapper [data-chatitemvsess='"+value.session+"']");
						if(elem.length == 0){
							$(".chat-item-select-wrapper").append('<div class="chat-item-select" data-chatitemvsess="'+value.session+'">'+
                        											'<div>'+value.visitor.name+'</div>'+
                      											  '</div>');
							
						}else{
							elem.html('<div>'+value.visitor.name+'</div>');
						}

						var cont = $(".chat-cont-vsess-"+value.session);
						if(cont.length > 0){
							$.each(value.messages, function(_key, _value){
								var msg_cont = $(".chat-content [data-msgid='"+_value.id+"']");

								if(msg_cont.length == 0){
									if(_value.from == "V"){
										messages_html += '<div class="single-message-wrapper chat-visitor" data-msgid="'+_value.id+'">'+
															'<div class="chat-sender-name">'+value.visitor.name+'</div>'+
															'<div class="chat-message">'+_value.message+'</div>'+
															'<div class="chat-message-time">'+_value.created_at+'</div>'+
														 '</div>';
									}else{
										messages_html += '<div class="single-message-wrapper chat-agent" data-msgid="'+_value.id+'">'+
															'<div class="chat-sender-name">'+value.visitor.agent[0].name+'</div>'+
															'<div class="chat-message">'+_value.message+'</div>'+
															'<div class="chat-message-time">'+_value.created_at+'</div>'+
														 '</div>';
									}
								}
								
							});
						}
					});

					if(messages_html != ""){
						$(".chat-content").append(messages_html);

						scroll_to_latest_message();
					}
					
				}else if(res.status == "no_chats"){
					//
				}
				chat_status_loading = false;	
			},
			error: function(err){
				//error
				chat_status_loading = false;
			}
		});
	}

	function send_message(message, sess){
		var wrapper = $(".chat-content");
		var date = moment().format('YYYY-MM-DD hh:mm:ss');
		var rand_num = number = 1 + Math.floor(Math.random() * 100);

		$.ajax({
			type: "post",
			url: URL+'/chats/reply',
			data: {session: sess, message: message, rand_num: rand_num},
			dataType: "json",
			beforeSend: function(){
				wrapper.append('<div class="single-message-wrapper chat-agent msg-idt-'+rand_num+'">'+
									'<div class="chat-sender-name">'+agent+'</div>'+
									'<div class="chat-message">'+message+'</div>'+
									'<div class="chat-message-time">'+date+'</div>'+
								'</div>');
				scroll_to_latest_message();
			},
			success: function(res){
				//success
				if(res.status == "success"){
					$(".msg-idt-"+rand_num).attr("data-msgid", res.data.id);
				}
				console.log(res);	
			},
			error: function(err){
				//error
			}
		});
	}

	function switch_chat_display(token){
		$.ajax({
			type: "post",
			url: URL+'/chats/chat',
			data: {session: token},
			dataType: "json",
			beforeSend: function(){
				$(".chat-section-wrapper").addClass("hide");
				$(".chat-box-info").addClass("hide");
				$(".chat-section-loading").removeClass("hide");

				clearInterval(chat_status_v);
			},
			success: function(res){
				if(res.status == "success"){
					messages_html = '';

					$.each(res.data, function(_key, _value){
						var msg_cont = $(".chat-content [data-msgid='"+_value.id+"']");

						if(msg_cont.length == 0){
							if(_value.from == "V"){
								messages_html += '<div class="single-message-wrapper chat-visitor" data-msgid="'+_value.id+'">'+
													'<div class="chat-sender-name">'+_value.visitor.name+'</div>'+
													'<div class="chat-message">'+_value.message+'</div>'+
													'<div class="chat-message-time">'+_value.created_at+'</div>'+
												 '</div>';
							}else{
								messages_html += '<div class="single-message-wrapper chat-agent" data-msgid="'+_value.id+'">'+
													'<div class="chat-sender-name">'+_value.visitor.agent[0].name+'</div>'+
													'<div class="chat-message">'+_value.message+'</div>'+
													'<div class="chat-message-time">'+_value.created_at+'</div>'+
												 '</div>';
							}
						}
						
					});
				$(".chat-content-container").removeClass().addClass("chat-content-container chat-cont-vsess-"+res.data[0].session);
				$("#cw-visitor-name").html(res.data[0].visitor.name);
				$("#cw-visitor-flag").attr("src", res.data[0].visitor.flag);
				$(".chat-content").html(messages_html);

				var data = JSON.parse(res.data[0].visitor.device_info);
				var location = "";
				var visits = "";
				var chats = "";

				if(data.city != "" && data.region != "" && data.country != ""){
					location = data.city + "," + data.region + "," + data.country;
				}else if(data.city == "" && data.region != "" && data.country != ""){
					location = data.region + "," + data.country;
				}else if(data.city != "" && data.region == "" && data.country != ""){
					location = data.city + "," + data.country;
				}else if(data.city == "" && data.region == "" && data.country != ""){
					location = data.country;
				}else{
					location = data.city + "," + data.region + "," + data.country;
				}

				if(data.chats == 0){
					chats = "0 chats";
				}else if(data.chats == 1){
					chat = "1 chat";
				}else{
					chat = data.chats + " chats";
				}

				if(data.visits == 0){
					visits = "0 visits";
				}else if(data.visits == 1){
					visits = "1 visit";
				}else{
					visits = data.visits + " visits";
				}

				$("#visitor-ip").html(data.ip);
				$("#visitor-location").html(location);
				$("#visitor-where-from").html(data.current_page);
				$("#visitor-visits").html(visits);
				$("#visitor-chats").html(chats);
				$("#visitor-browser").html(data.browser);
				$("#visitor-os").html(data.os);

				$(".chat-section-wrapper").removeClass("hide");
				$(".chat-box-info").removeClass("hide");
				$(".chat-section-loading").addClass("hide");

				chat_status_v = window.setInterval(chat_status, 3000);
					
				}else if(res.status == "no_chats"){
					//
				}	
			},
			error: function(err){
				//error
			}
		});
	}

	function scroll_to_latest_message(){
		$('.chat-content').animate({
               scrollTop: $('.chat-content')[0].scrollHeight}, "slow");
	}

	function fetch_navigation(){
		var _class = $(".chat-content-container").attr("class");
		var _class2 = _class.split(' ');
		var _class3 = _class2[1].split('-');

		$.ajax({
			type: "post",
			url:  URL+"/visitor/navigation",
			data: {identifier: _class3[3]},
			dataType: "json",
			beforeSend: function(){
				$(".nc-tab-nav").html('<div class="text-center" style="padding:20px;"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>');
			},
			success: function(res){
				if(res.status == "success"){
					if(res.data.length > 0){
						var html = '';

						$.each(res.data, function(key, row){
							html += '<div>'+
										'<div style="padding: 10px 10px;">'+
											'<div class="info-title clearfix">'+
												'<div class="pull-left nc-tab-nav-item">'+row.page_title+'</div>'+
												'<div class="pull-right">'+row.time+'</div>'+
											'</div>'+
										'</div>'+
									'</div>';
						});

						$(".nc-tab-nav").html(html);
					}else{
						$(".nc-tab-nav").html('The visitor has no navigation records yet');
					}
					
					console.log(res.data);
				}
			}
		});
	}

	function fetch_history(){
		var _class = $(".chat-content-container").attr("class");
		var _class2 = _class.split(' ');
		var _class3 = _class2[1].split('-');

		$.ajax({
			type: "post",
			url:  URL+"/visitor/chat-history",
			data: {session: _class3[3]},
			dataType: "json",
			beforeSend: function(){
				$(".nc-tab-history").html('<div class="text-center" style="padding:20px;"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>');
			},
			success: function(res){
				if(res.status == "success"){
					if(res.data.length > 0){
						var html = '';

						$.each(res.data, function(key, row){
							html += '<div>'+
										'<div style="padding: 10px 10px;">'+
											'<div class="info-title clearfix arch-chat" data-sess="'+row.session_id+'">'+
												'<div class="pull-left nc-tab-hist-item-1">'+row.messages[0].message_time+'</div>'+
												'<div class="pull-left nc-tab-hist-item-2">'+row.name+'</div>'+
											'</div>'+
										'</div>'+
									'</div>';
						});

						$(".nc-tab-history").html(html);
					}else{
						$(".nc-tab-history").html('The visitor has no previous chats');
					}
				}
			}
		});
	}

	function fetch_archived_chat(token){
		var response = null;
	}
});