<html>
  <head>
    <meta charset="utf-8"/>
    <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
	<title>Firebase example</title>
  </head>
  <body>
    <h1>Firebase example</h1>
    <pre id='object'></pre>
	<script>

	var array = '{{ $array }}';
	var server = '{{ url('/') }}';
	
	//console.log(JSON.parse(array));
	var object = JSON.parse(JSON.stringify(array)); 
	//var object = $.parseJSON(array);
	alert('o');

	</script>
	<script src="{{ url('/assets/firebase/chat.js') }}"></script>
  </body>
</html>