   paypal.Button.render({
           locale: 'en_US',
           env: 'sandbox',
	client: {
		sandbox:'Abeif96sEFOLYyggw3dCdDf-bnhQTsj2bxS4a--dQGpNnZ8Wl61B_fBKNe-pt4cs261VcGq2IQPuGaUg'
	},
           style: {
       color: 'blue',
       shape: 'rect',
       label: 'checkout'
           },

           payment: function(resolve, reject) {
           return paypal.request.post(server+'/createSMSCreditPayment',{'amount':paypalamount,'_token':csrf_token})
			 .then(function(res) {
               
               	return res.TOKEN;
           	});
           },

           onAuthorize: function(data, actions) {
                return paypal.request.post(server+'/completeSMSCreditPayment', {
               paymentToken: data.paymentToken,
               payerId: data.payerID,
			   _token:csrf_token
           }).then(function (res) {
           console.log(JSON.stringify(res));
           

               location.href=res.redirect;
               
           });
           }
           
       }, '#paypal-button1');

	 