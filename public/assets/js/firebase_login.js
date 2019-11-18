 //$(function() {
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
	const txtemail =  document.getElementById("email");
	const txtpassword =  document.getElementById("password");
	const loginbtn =  document.getElementById("loginbtn");
	const registerbtn =  document.getElementById("registerbtn");
	const logoutbtn =  document.getElementById("logoutbtn");
	loginbtn.addEventListener("click", function(){
		const email = txtemail.value;
		const pass = txtpassword.value;
		const auth = firebase.auth();
		
		const promise = auth.signInWithEmailAndPassword(email, pass);
		promise.catch(e=>console.log(e.message));
	});
	
		registerbtn.addEventListener("click", function(){
		const email = txtemail.value;
		const pass = txtpassword.value;
		const auth = firebase.auth();
		
		const promise = auth.createUserWithEmailAndPassword(email, pass);
		promise.catch(e=>console.log(e.message));
	});
	
	firebase.auth().onAuthStateChanged(function(user) {
		
  if (user) {
	  alert('logged in');
	  console.log(user);
    // User is signed in.
    /*var displayName = user.displayName;
    var email = user.email;
    var emailVerified = user.emailVerified;
    var photoURL = user.photoURL;
    var isAnonymous = user.isAnonymous;
    var uid = user.uid;
    var providerData = user.providerData;*/
    // ...
	logoutbtn.classList.remove('hide');
  } else {
    // User is signed out.
    // ...
	console.log('not logged in');
	alert('not logged in');
	logoutbtn.classList.add('hide');
  }
});
logoutbtn.addEventListener("click", function(){
	firebase.auth().signOut();
});
//});