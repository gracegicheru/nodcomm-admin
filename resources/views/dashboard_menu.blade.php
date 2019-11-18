
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
				<li><a href="{{ url('/dashboard') }}"><img src="{{ url('/images/Dashboard.png') }}" width="40%"></a><span class="navbarspan text-center">{{trans('menu.dashboard')}}</span></li>
				@if (Auth::user()->admin)
				<li><a href="{{ url('/email') }}"><img src="{{ url('/images/email.png') }}" width="40%"></a><span class="navbarspan text-center">{{trans('menu.email')}}</span></li>
				<li><a href="{{ url('/sms') }}"><img src="{{ url('/images/sms.png') }}" width="40%"></a><span class="navbarspan text-center">{{trans('menu.sms')}}</span></li>
				@endif
				<li><a href="{{ url('/chats') }}"><img src="{{ url('/images/chat.png') }}" width="40%"></a><span class="navbarspan text-center">{{trans('menu.chats')}} </span></li>
				<li><a href="{{ url('/push-sites') }}"><img src="{{ url('/images/push-notification.png') }}" width="40%"></i></a><span class="navbarspan text-center">{{trans('menu.push')}}</span></li>
				<li><a href="#"><img src="{{ url('/images/campaign.png') }}" width="40%"></a><span class="navbarspan text-center">{{trans('menu.campaigns')}}</span></li>
				@if (Auth::user()->admin)
				<li><a href="{{ url('/billing') }}"><img src="{{ url('/images/billing.png') }}" width="40%"></a><span class="navbarspan text-center">{{trans('menu.billing')}}</span></li>
				@endif
				<li><a href="{{ url('/profile') }}"><img src="{{ url('/images/profile.png') }}" width="40%"></i></a><span class="navbarspan text-center">{{trans('menu.profile')}}</span></li>
				@if (Auth::user()->admin)
				<li><a href="{{ url('/setting/prechat') }}"><img src="{{ url('/images/setting.png') }}" width="40%"></a><span class="navbarspan text-center">{{trans('menu.settings')}} </span></li>
				@endif
				<li><a href="{{ url('/users') }}"><img src="{{ url('/images/users.png') }}" width="40%"></i></a><span class="navbarspan text-center">{{trans('menu.users')}}</span></li>

			</ul>
			

			</div>
		</div>

		 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	</body>
</html>