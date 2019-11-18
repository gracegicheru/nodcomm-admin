<!DOCTYPE html>

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>

  <div id="paypal-button"></div>

<script>
var server = '{{ url('/') }}';
var paypalamount="<?php echo $amount; ?>";
var env= "<?php echo $paypal_mode; ?>";
var paypal_client_ID="<?php echo $paypal_client_ID; ?>";
var csrf_token = '{{ csrf_token() }}';
</script>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script src="{{ url('/assets/js/paypal.js') }}"></script>

</body>