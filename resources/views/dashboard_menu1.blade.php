
<!DOCTYPE html>

<html lang="en">
    <head> 
		<meta name="viewport" content="width=device-width, initial-scale=1">


		<!-- Website CSS style -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Website Font style -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ url('/assets/css/style.css') }}">
		<!-- Google Fonts -->
		<link href='https://fonts.googleapis.com/css?family=Passion+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="{{ url('/assets/css/dashboard.css') }}">

		<title>Nodcomm</title>
	</head>
	<body>



		<div class="container">

			<div class="row " style="display: inline-block;margin-top:15%;">
			<ul class="navbar ">
				<li><a href="{{ url('/main-dashboard') }}"><img src="{{ url('/images/png/home.png') }}" width="40%"></a><span class="navbarspan text-center">Home</span></li>
				<li><a href="{{ url('/profile') }}"><img src="{{ url('/images/png/user.png') }}" width="40%"></a><span class="navbarspan text-center">My Profile</span></li>
				@if (Auth::user()->admin)
				<li class="drpdown"><a href="#"><img src="{{ url('/images/png/setting.png') }}" width="40%"></a><span  class="navbarspan text-center">Settings</span>
					<ul class="drpcontent" id="themeselect">
						<li><a href="{{ url('/setting/prechat') }}" data-color="color1">Chat Window</a></li>
						<li><a href="{{ url('/setting/postchat') }}" data-color="color2">Feedback Window</a></li>
						<li><a href="{{ url('/setting/department') }}" data-color="color3">Departments</a></li>
						@if (Auth::user()->admin && Auth::user()->company_id==0)
						<li><a href="{{ url('/setting/general') }}" data-color="color4">General Settings</a></li>
						<li><a href="{{ url('/setting/email') }}" data-color="color5">Email Settings</a></li>
						@endif
					</ul>
				</li>
				<li><a href="{{ url('/users') }}"><img src="{{ url('/images/png/users.png') }}" width="40%"></a><span class="navbarspan text-center">Users</span></li>
				@if (Auth::user()->admin && Auth::user()->company_id==0)
				<li><a href="{{ url('/super-admins') }}"><img src="{{ url('/images/png/users.png') }}" width="40%"></a><span class="navbarspan text-center">Super Administrators</span></li>
				@endif
				<li><a href="{{ url('/messages/history') }}"><img src="{{ url('/images/png/sms.png') }}" width="40%"></a><span class="navbarspan text-center">Messages History</span></li>
				<li><a href="{{ url('/sites') }}"><img src="{{ url('/images/png/globe.png') }}" width="40%"></a><span class="navbarspan text-center">Linked Websites</span></li>
				@endif
				@if (Auth::user()->admin && Auth::user()->company_id==0)
			    <li><a href="{{ url('/admin/companies') }}"><img src="{{ url('/images/png/globe.png') }}" width="40%"></a><span class="navbarspan text-center">Registered Companies</span></li>
				<li><a href="{{ url('/advertisements') }}"><img src="{{ url('/images/png/advert.png') }}" width="40%"></a><span class="navbarspan text-center">Advertisements</span></li>
				@endif
				@if (Auth::user()->admin)
				<li><a href="{{ url('/api') }}"><img src="{{ url('/images/png/home.png') }}" width="40%"></a><span class="navbarspan text-center">API Center</span ></li>
				@endif
				<li><a href="{{ url('/chats') }}"><img src="{{ url('/images/png/chat.png') }}" width="40%"></a><span class="navbarspan text-center">Chats & Visitors</span></li>
			
				<li><a href="{{ url('/test-messages') }}"><img src="{{ url('/images/png/email.png') }}" width="40%"></i></a><span class="navbarspan text-center">Test Messages</span></li>
				
				<li><a href="{{ url('/docs/sms/') }}"><img src="{{ url('/images/png/email.png') }}" width="40%"></a><span class="navbarspan text-center">Documentation</span></li>

			</ul>
			

			</div>
		</div>

		 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	</body>
</html>