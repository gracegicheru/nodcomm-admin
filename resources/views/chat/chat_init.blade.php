var site_id = '{{ $site_id }}';
var site_url = '{{ url('/') }}';

var ifrm = document.createElement("iframe");
	ifrm.setAttribute("id", "nodcomm-iframe");
	ifrm.setAttribute("name", "nodcommchatIframe");
    ifrm.setAttribute("src", site_url + "/chat/?siteId="+site_id);
    ifrm.setAttribute("style", "position: fixed;border: 0px;z-index: 2147483646;bottom: 0px;right: 0px;width:90px;height: 120px;");
    ifrm.setAttribute("onload", "nc_visitor_info(this)");
    document.body.appendChild(ifrm);

var nodchat_cont = document.createElement('script');
	nodchat_cont.type = 'text/javascript';
	nodchat_cont.async = true;
	nodchat_cont.src = site_url + '/assets/js/client_controller.js';
	document.body.appendChild(nodchat_cont);