<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
	</head>
  <body>
    <table class="table table-bordered" style="border-spacing: 20px;">
	  <tr>
        <td align="center" colspan="2">
         <img src="{{ url('logos/'.$payment->logo) }}"  alt="Company Logo" width="35%" style="position:relative;"/>
        </td>
	  </tr>
      <tr>
        <td colspan="2">
          {{ $payment->company->name }}
        </td>
	  </tr>
	  <tr>
        <td colspan="2">
          {{ $payment->company->address	 }}
        </td>
	  </tr>
	  <tr>
		 <td colspan="2">
           {{ $payment->company->email }}
        </td>
	  </tr>
	  <tr>
        <td colspan="2">
           {{ $payment->company->phone }}
        </td>
      </tr>
	  <tr>
        <td>
          {{ date('Y-m-d H:i:s', time()) }}
        </td>
      </tr>
	  <tr>
        <td colspan="2" align="center" style="text-decoration: underline;">
          <b>Non Objection Certificate</b>
        </td>
      </tr>
	  <tr>
        <td colspan="2">
         With Respect,
        </td>
      </tr>
	  <tr>
        <td colspan="2">
         In order to improve the service that will bring  added value to our customers, <b>{{ $payment->company->name }}</b> appoints  <b>Nodcomm Ltd</b> to provide the needed support and carry on the activities that are neccessary for sustainable SMS service and registration of sender id: "<b>{{ $payment->sender_id }}</b>".
        </td>
      </tr>
	  <tr>
        <td colspan="2">
         The sender ID description (What the sender ID will be used for): {{ $payment->usage }}
        </td>
      </tr>
	  <tr>
        <td colspan="2">
         For and behalf of:
        </td>
      </tr>
	  <tr>
        <td>
         Company representative name
        </td>
		<td>
		Print Name
		</td>
      </tr>
	  <tr>
        <td>
		   <hr align="left" width="50%">
        </td>
		 <td>
		   <hr align="left" width="50%">
        </td>
      </tr>
	  <tr >
        <td>
         Signature
        </td>
		<td>
         Title
        </td>
      </tr>
	  <tr >
        <td>
         <hr align="left" width="50%">
        </td>
	    <td>
         <hr align="left" width="50%">
        </td>
      </tr>

    </table>
  </body>
</html>