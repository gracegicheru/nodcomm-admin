
var site_id = '{{ $site_id }}';
var company_id = '{{ $company_id }}';
var site_url = '{{ url('/') }}';
var z;

var nodchat_cont = document.createElement('script');
	nodchat_cont.type = 'text/javascript';
	nodchat_cont.async = true;
	nodchat_cont.src = site_url + '/assets/js/push_ui.js';
	nodchat_cont.setAttribute("data-x", site_id);
	nodchat_cont.setAttribute("data-y", company_id);
	document.body.appendChild(nodchat_cont);
	

