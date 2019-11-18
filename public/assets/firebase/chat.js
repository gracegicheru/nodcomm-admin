
	 
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyDitTJQdOz2nSprnMPZZA00D3_cxEd467E",
    authDomain: "fir-f4d5c.firebaseapp.com",
    databaseURL: "https://fir-f4d5c.firebaseio.com",
    projectId: "fir-f4d5c",
    storageBucket: "fir-f4d5c.appspot.com",
    messagingSenderId: "662814691860"
  };
  firebase.initializeApp(config);
    // Get a reference to the database service
var postsRef = firebase.database().ref().child("file");
var newPostRef = postsRef.push();
/*$.ajax({
    type: "GET",
    url: server+"/firebase1",
    dataType: "json",
	 cache: false,
    success: function (data) {
		newPostRef.set({
		'en':data.details
		});
    }

});*/
var ref = firebase.database().ref("file");
ref.orderByChild("code").equalTo('en').once("value", function(snapshot) {
  
    snapshot.forEach(function(childsnapshot) {
    console.log(childsnapshot.val().content.dashboard);
  });
  //console.log(snapshot.key.child("file/code").key);
});

      $.ajax({
            type: "GET",
            url: server+'/firebase/users',
            dataType:"json",
            beforeSend: function() {

            },
            cache: false,
            success: function(res) {
								var userref = firebase.database().ref("users");
								$.each(res.details, function(key, data) {
								var newUserRef = userref.push();									
								newUserRef.set({
									'company_id':data.company_id,
									'user_id':data.id,
									'email':data.email,
									'admin':data.admin,
									'password':data.password,
									'active':data.active,
									'created_at':data.created_at,
									'updated_at':data.updated_at,
									'code':data.code,
									'confirmed':data.confirmed,
									'name':data.name,
									'address':data.address,
									'phone':data.phone,
									'photo':data.photo,
									'code_expiry_time':data.code_expiry_time,
									'last_activity':data.last_activity,
									'about':data.about	
								});	

								});
			
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

					}
                });
				
            $.ajax({
            type: "GET",
            url: server+'/firebase/companies',
            dataType:"json",
            beforeSend: function() {

            },
            cache: false,
            success: function(res) {
			    var ref = firebase.database().ref("companies");
				$.each(res.details, function(key, data) {
									var newCompanyRef = ref.push();
									newCompanyRef.set({
									'company_id':data.id,
									'name':data.name,
									'email':data.email,
									'api_id':data.api_id,
									'api_key':data.api_key,
									'active':data.active,
									'created_at':data.created_at,
									'updated_at':data.updated_at,
									'code':data.code,
									'confirmed':data.confirmed,
									'fname':data.fname,
									'country':data.country,
									'lname':data.lname,
									'address':data.address,
									'website':data.website,
									'company_size':data.company_size,
									'phone':data.phone,
									'logo':data.logo,
									'step':data.step,
									'paid':data.paid,
									'code_expiry_time':data.code_expiry_time,
									'extended_trial_date':data.extende_trial_date	
									});	
			});
			
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

					}
                });
        $.ajax({
            type: "GET",
            url: server+'/firebase/sites',
            dataType:"json",
            beforeSend: function() {

            },
            cache: false,
            success: function(res) {
								var ref = firebase.database().ref("sites");
								$.each(res.details, function(key, res) {
								var newSiteRef = ref.push();
									newSiteRef.set({
									'company_id':res.company_id,
									'site_id':res.site_id,
									'gcode':res.gcode,
									'name':res.name,
									'url':res.url,
									'created_at':res.created_at,
									'updated_at':res.updated_at,
									'code':res.code	
									});

								});
			
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

					}
                });