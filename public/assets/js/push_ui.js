		var currentScript = document.currentScript;

		var site_id = currentScript.getAttribute('data-x');
		var company_id = currentScript.getAttribute('data-y');
		
		if (('serviceWorker' in navigator) && ('PushManager' in window)) {
			if(Notification.permission !== "granted" && Notification.permission !== "denied"){
				window.setTimeout(function(){
					$(".push-ui-wrapper").removeClass("hide");
					registration = registerServiceWorker(); console.log(registration);
				}, 3000);
			}

			$(".push-close").click(function(){
				$(".push-ui-wrapper").addClass("hide");

				$.get(server+'push-close', function(data){});
			});

			$(".push-allow").click(function(){
				$(".push-ui-wrapper").addClass("hide");

				askPermission();
			});

			function registerServiceWorker() {
			  return navigator.serviceWorker.register(server+'/assets/js/nodcomm-service-worker.js')
			  .then(function(registration) {
			    console.log('Service worker successfully registered.');
			    return registration;
			  })
			  .catch(function(err) {
			    console.error('Unable to register service worker.', err);
			  });
			}

			function askPermission() {
			  return new Promise(function(resolve, reject) {
			    const permissionResult = Notification.requestPermission(function(result) {
			      resolve(result);
			    });

			    if (permissionResult) {
			      permissionResult.then(resolve, reject);
			    }
			  })
			  .then(function(permissionResult) {
			  	if(permissionResult == "granted"){
			  		subscribeUserToPush();
			  	}
			  });
			}

			function subscribeUserToPush() {
			  return navigator.serviceWorker.register(server+'/assets/js/nodcomm-service-worker.js')
			  .then(function(registration) {
			    const subscribeOptions = {
			      userVisibleOnly: true,
			      applicationServerKey: urlBase64ToUint8Array(
			        'BH5yhWUwomgwwXJdpS5xuzHLLDMcHyJT3rpNErsxA-xrZ6LTnUANvaxj6MrP94E_V-ov-LggGr4kWhxv14IaLIA'
			      )
			    };

			    return registration.pushManager.subscribe(subscribeOptions);
			  })
			  .then(function(pushSubscription) {
			    console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
			    sendSubscriptionToBackEnd(pushSubscription);
			    //return pushSubscription;
			  });
			}

			function urlBase64ToUint8Array(base64String) {
			  const padding = '='.repeat((4 - base64String.length % 4) % 4);
			  const base64 = (base64String + padding)
			    .replace(/\-/g, '+')
			    .replace(/_/g, '/')
			  ;
			  const rawData = window.atob(base64);
			  return Uint8Array.from([...rawData].map((char) => char.charCodeAt(0)));
			}

			function sendSubscriptionToBackEnd(subscription) {
				
				var parser = new UAParser();
				var result = parser.getResult();
				var browsername = result.browser.name; 
				var browserversion = result.browser.version
				var devicename = result.os.name;
				var deviceversion = result.os.version;
				var enginename = result.engine.name; 
				var devicearchitecture = result.cpu.architecture;
			var data= {'subscription': subscription,'company_id':company_id,'site_id':site_id,'ip':z,'device_info':JSON.stringify(result) }
			  $.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			  	type: "post",
			  	url: server+'/push/add',
			  	data: JSON.stringify(data),
				
			  	success: function(res){
			  		console.log("success");
			  	},
			  	error: function(err){
			  		console.log(err);
			  	}
			  });
			}

			function sendSubscriptionToBackEnd2(subscription) {
			  return fetch(server+'/push/add', {
			    method: 'post',
			    headers: {
			      'Content-Type': 'application/json'
			    },
			    body: JSON.stringify(subscription)
			  })
			  .then(function(response) { console.log(response);
			    if (!response.ok) {
			      throw new Error('Bad status code from server.');
			    }

			    return response.json();
			  })
			  .then(function(responseData) {
			    if (!(responseData.data && responseData.data.success)) {
			      throw new Error('Bad response from server.'); console.log(responseData);
			    }
			  });
			}
		}
		
