//alert(userip);
$(function(){
	// Create IE + others compatible event handler
	var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
	var eventer = window[eventMethod];
	var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

	$(".nodchat_btn").click(function(){
		//var parentBody = window.parent.document.body;
		//$("#nodcomm-iframe", parentBody).attr("style", "position: fixed; border: 0px; z-index: 2147483646; bottom: 0px; right: 0px; width: 420px; height: 610px;");
		parent.postMessage("show","*");
		$(this).hide();
		$(".embedded-window").show();
	});

	//parent.postMessage("show","*");

	$(".icon-minimize").click(function(){
		//var parentBody = window.parent.document.body;
		//$("#nodcomm-iframe", parentBody).attr("style", "position: fixed;border: 0px;z-index: 2147483646;bottom: 0px;right: 0px;width: 90px;height: 120px;");
		parent.postMessage("hide","*");
		$(".embedded-window").hide();
		$(".nodchat_btn").show();
	});

	$(".icon-close").click(function(){
		//var parentBody = window.parent.document.body;
		//$("#nodcomm-iframe", parentBody).attr("style", "position: fixed;border: 0px;z-index: 2147483646;bottom: 0px;right: 0px;width: 90px;height: 120px;");
		parent.postMessage("hide","*");
		$(".embedded-window").hide();
	});

	$("#chat-input-control").keypress(function(evt){
		var txt = $(this).val();

		if(txt != ""){
			$(".footer__operation").addClass("hide");
		}else{
			$(".footer__operation").removeClass("hide");
		}

		if(evt.which == 13) {
			$(this).val('');
	        v_send_message(txt);
	    }
	});

	$("#chat-input-control").blur(function(){
		var txt = $(this).val();

		if(txt != ""){
			$(".footer__operation").addClass("hide");
		}else{
			$(".footer__operation").removeClass("hide");
		}
	});

	var parser = new UAParser();
	var result = parser.getResult();
	var browsername = result.browser.name; 
	var browserversion = result.browser.version
	var devicename = result.os.name;
	var deviceversion = result.os.version;
	var enginename = result.engine.name; 
	var devicearchitecture = result.cpu.architecture;
	var current_page = "";
	var page_title = "";
	var referrer = "";

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	var user_cookie = Cookies.get("nodcommChat_guid_" + site_id);
	var user_info = Cookies.get("nodcommChat_info_" + site_id);
	var user_session = Cookies.get("nodcommChat_visitor_" + site_id);

	var last_activity = null;
	var agent_status = null;
	var message_status = null;
	var last_activity_loading = false;
	var agent_status_loading = false;
	var message_status_loading = false;
	var reload_messages_loading = false;

	if(user_cookie == undefined){
		user_cookie = "not_set";
	}

	// Listen to message from parent window
	eventer(messageEvent, function(e) {
		console.log(e.data);

		if(e.data != ""){
			var parsedData = JSON.parse(e.data);

			current_page = parsedData.pageurl;
			page_title = parsedData.pagetitle;
			referrer = parsedData.referrer;
		}else{
			referrer = "";
			page_title = document.title;
			current_page = document.referrer;
		}
		
		if(user_info == undefined){
			$.ajax({
				type: "post",
				url:  URL+'/chat/user-info',
				data: {site_id:site_id,device_info: result, ip:userip, url: current_page, user_cookie: user_cookie, referrer: referrer},
				dataType: "json",
				success: function(res){
					if(res.status == "success"){
						Cookies.set("nodcommChat_guid_" + site_id, res.identifier, {expires: 29565});
						Cookies.set("nodcommChat_info_" + site_id, 1);

						user_cookie = Cookies.get("nodcommChat_guid_" + site_id);
						update_last_activity("");
						last_activity = window.setInterval(update_last_activity, 3000);
					
					
					
					}
				},
				error: function(){

				}
			});
		}else if(user_session != undefined){
			v_load_messages(user_session);
		}else{
			update_last_activity("init");
			last_activity = window.setInterval(update_last_activity, 3000);
		}
	},false);

		

	$(".btn-start-chat").click(function(){
		var formdata = {},
			elems = $(".chat-start-fields input[type=text], .chat-start-fields input[type=email], .chat-start-fields textarea"),
			btn = $(this),
			valid = true;

		$.each(elems, function(key, value){
			console.log($(value));
			var val = $(value).val();
			if(val == ""){
				$(value).addClass("error");
				valid = false;
			}else{
				var name = $(value).attr('name');
				//formdata.push({name: val});
				formdata[name] = val;
			}
		});

		//formdata.push({'identifier': Cookies.get("nodcommChat_guid_" + site_id)});
		formdata['identifier'] = Cookies.get("nodcommChat_guid_" + site_id);

		if(valid){
			$.ajax({
				type: "post",
				url:  URL+'/chat/start',
				data: formdata,
				dataType: "json",
				beforeSend: function(){
					console.log(formdata);
					btn.prop("disabled", true).html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Please wait');
				},
				success: function(res){
					if(res.status == "success"){
						$("#offline-window").addClass("hide");
						$("#chat-box-window").removeClass("hide");
						Cookies.set("nodcommChat_visitor_" + site_id, res.session);

						clearInterval(last_activity);
						v_agent_status();
						agent_status = window.setInterval(v_agent_status, 3000);
					}
				},
				error: function(err){
					console.log(err);
				}
			});
		}
	});

	function update_last_activity(init){
		if(last_activity_loading){
			return;
		}
		$.ajax({
			type: "post",
			url: URL+'/chat/user/lastactivity',
			data: {user_identifier: user_cookie, current_page: current_page, page_title: page_title, init: init, referrer: referrer},
			dataType: "json",
			beforeSend: function(){
				last_activity_loading = true;
			},
			success: function(res){
				//success
				last_activity_loading = false;
				console.log(res.status);	
			},
			error: function(err){
				//error
				last_activity_loading = false;
			}
		});
	}

	function v_agent_status(){
		var wrapper = $("#chat-box-window");
		var messages = '';

		if(agent_status_loading){
			return;
		}
		$.ajax({
			type: "post",
			url: URL+'/chat/status',
			data: {user_identifier: user_cookie, current_page: current_page, page_title: page_title},
			dataType: "json",
			beforeSend: function(){
				agent_status_loading = true;
			},
			success: function(res){
				//success
				if(res.status == "success"){
					wrapper.find(".greeting-message-wrapper").html('<div class="chat-system-message window__chatSystemMessage">Agent '+res.data[0].agent[0].name+' has joined the chat.</div>');

					$.each(res.data[0].visitor_chats, function(key, value){
						var name = '';

						if(value.from == "V"){
							messages += '<div class="chat-visitor window__chatVisitor clearfix" data-msgid="'+value.id+'">'+
											'<div class="chat-visitor-message window__chatVisitorMessage">'+value.message+'</div>'+
											'<div class="chat-time chat__time" style="">'+value.created_at+'</div>'+
									 	'</div>';
						}else{
							messages += '<div class="window__chatAgent clearfix" data-msgid="'+value.id+'">'+
											'<div class="chat-operator-message window__chatAgentMessage window__chatMessageNoAvatar">'+value.message+'</div>'+
											'<div class="chat-time chat__time" style="">'+value.created_at+'</div>'+
									 	'</div>';
						}
					});

					wrapper.find(".chat-box").html(messages);
					$("#chat-input").removeClass("hide");

					clearInterval(agent_status);
					v_message_status();
					message_status = window.setInterval(v_message_status, 3000);
				}
				agent_status_loading = false;
				console.log(res);	
			},
			error: function(err){
				//error
				agent_status_loading = false;
			}
		});
	}

	function v_message_status(){
		var wrapper = $("#chat-box-window");
		var messages = '';

		if(message_status_loading){
			return;
		}
		$.ajax({
			type: "post",
			url: URL+'/chat/user/message',
			data: {user_identifier: user_cookie, current_page: current_page, page_title: page_title},
			dataType: "json",
			beforeSend: function(){
				message_status_loading = true;
			},
			success: function(res){
				//success
				if(res.status == "success"){
					$.each(res.data[0].visitor_chats, function(key, value){
						var name = '';
						var msg_cont = $(".chat-box [data-msgid='"+value.id+"']");

						if(msg_cont.length == 0){
							if(value.from == "V"){
								messages += '<div class="chat-visitor window__chatVisitor clearfix" data-msgid="'+value.id+'">'+
												'<div class="chat-visitor-message window__chatVisitorMessage">'+value.message+'</div>'+
												'<div class="chat-time chat__time" style="">'+value.created_at+'</div>'+
										 	'</div>';
							}else{
								messages += '<div class="window__chatAgent clearfix" data-msgid="'+value.id+'">'+
												'<div class="chat-operator-message window__chatAgentMessage window__chatMessageNoAvatar">'+value.message+'</div>'+
												'<div class="chat-time chat__time" style="">'+value.created_at+'</div>'+
										 	'</div>';
							}
						}
					});

					if(messages != ""){
						wrapper.find(".chat-box").append(messages);
						scroll_to_latest_message();
					}
				}
				message_status_loading = false;
				console.log(res);	
			},
			error: function(err){
				//error
				message_status_loading = false;
			}
		});
	}

	function v_send_message(message){
		var wrapper = $("#chat-box-window")

		if(message == ""){
			//
		}else{
			var date = moment().format('YYYY-MM-DD hh:mm:ss');
			var rand_num = number = 1 + Math.floor(Math.random() * 100);

			$.ajax({
				type: "post",
				url: URL+'/chat/send',
				data: {user_identifier: user_cookie, message: message},
				dataType: "json",
				beforeSend: function(){
					clearInterval(message_status);
					wrapper.find(".chat-box").append('<div class="chat-visitor window__chatVisitor clearfix msg-idt-'+rand_num+'">'+
														'<div class="chat-visitor-message window__chatVisitorMessage">'+message+'<span class="chat-message--loading></span></div>'+
														'<div class="chat-time chat__time" style="">'+''+'</div>'+
												 	'</div>');
				},
				success: function(res){
					//success
					if(res.status == "success"){
						wrapper.find(".chat-message--loading").remove();

						// wrapper.find(".chat-box").html(messages);
						// wrapper.find("#chat-input").removeClass("hide");
						$(".msg-idt-"+rand_num).attr("data-msgid", res.data.id);
						scroll_to_latest_message();

						v_message_status();
						message_status = window.setInterval(v_message_status, 3000);
					}
					console.log(res);	
				},
				error: function(err){
					//error
				}
			});
		}
	}

	function v_load_messages(session_id){
		var wrapper = $("#chat-box-window");
		var messages = '';

		if(reload_messages_loading){
			return;
		}
		$.ajax({
			type: "post",
			url: URL+'/chat/messages/load',
			data: {user_identifier: user_cookie, session_identifier: user_session},
			dataType: "json",
			beforeSend: function(){
				reload_messages_loading = true;
			},
			success: function(res){
				//success
				if(res.status == "success"){
					wrapper.find(".greeting-message-wrapper").html('<div class="chat-system-message window__chatSystemMessage">Agent '+res.data[0].agent[0].name+' has joined the chat.</div>');
					$.each(res.data[0].visitor_chats, function(key, value){
						var name = '';

						if(value.from == "V"){
							messages += '<div class="chat-visitor window__chatVisitor clearfix" data-msgid="'+value.id+'">'+
											'<div class="chat-visitor-message window__chatVisitorMessage">'+value.message+'</div>'+
											'<div class="chat-time chat__time" style="">'+value.created_at+'</div>'+
									 	'</div>';
						}else{
							messages += '<div class="window__chatAgent clearfix" data-msgid="'+value.id+'">'+
											'<div class="chat-operator-message window__chatAgentMessage window__chatMessageNoAvatar">'+value.message+'</div>'+
											'<div class="chat-time chat__time" style="">'+value.created_at+'</div>'+
									 	'</div>';
						}
					});

					wrapper.find(".chat-box").html(messages);
					$("#offline-window").addClass("hide");
					$("#chat-box-window").removeClass("hide");
					$("#chat-input").removeClass("hide");

					//var parentBody = window.parent.document.body;
					//$("#nodcomm-iframe", parentBody).attr("style", "position: fixed; border: 0px; z-index: 2147483646; bottom: 0px; right: 0px; width: 420px; height: 610px;");
					parent.postMessage("show","*");
					$(".nodchat_btn").hide();
					$(".embedded-window").show();

					scroll_to_latest_message();
				}
				reload_messages_loading = false;
				v_message_status();
				message_status = window.setInterval(v_message_status, 3000);
				console.log(res);
			},
			error: function(err){
				//error
				reload_messages_loading = false;
			}
		});
	}

	function scroll_to_latest_message(){
		$('#chat-box-window').animate({
               scrollTop: $('#chat-box-window')[0].scrollHeight}, "slow");
	}	
});