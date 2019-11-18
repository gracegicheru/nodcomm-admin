// Create IE + others compatible event handler
var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

// Listen to message from child window
eventer(messageEvent,function(e) {
  if(e.data == "show"){
  	$("#nodcomm-iframe").attr("style", "position: fixed; border: 0px; z-index: 2147483646; bottom: 0px; right: 0px; width: 420px; height: 610px;");
  }else if(e.data == "hide"){
	$("#nodcomm-iframe").attr("style", "position: fixed;border: 0px;z-index: 2147483646;bottom: 0px;right: 0px;width: 90px;height: 120px;");
  }
},false);

function nc_visitor_info(elem){
	var nodcommObj = {};
	nodcommObj['referrer'] = document.referrer;
	nodcommObj['pagetitle'] = document.title;
	nodcommObj['pageurl'] = document.location.href;
	nodcommchat_iframe = window.frames.nodcommchatIframe;
	nodcommchat_iframe.postMessage(JSON.stringify(nodcommObj), "*");
	elem.postMessage(JSON.stringify(nodcommObj), "*");
}

// window.frames.nodcommchatIframe.onload = function(){
// 	var nodcommObj = {};
// 	nodcommObj['referrer'] = document.referrer;
// 	nodcommObj['pagetitle'] = document.title;
// 	nodcommObj['pageurl'] = document.location.href;
// 	nodcommchat_iframe = window.frames.nodcommchatIframe;
// 	nodcommchat_iframe.postMessage(JSON.stringify(nodcommObj), "*");
// }

//console.log(document.title);
//console.log(document.location.href);
//console.log(document.referrer);