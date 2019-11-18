	@extends('layouts.new_master')
	@section('styles')
	<link rel="stylesheet" href="{{ url('int-tel/css/intlTelInput.css')}}">
	<link rel="stylesheet" href="{{ url('assets/css/custom.css')}}">
   	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
   <style>
      .rq-step{
        transition: margin 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      }
      .rq-step.active{
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        width: 110%;
        margin-left: -10%;
      }
      .rq-step-header{
        border-bottom: 1px solid rgba(160, 160, 160, 0.2);
        padding: 10px 24px;
      }
      .rq-step-no {
        color: rgba(0, 0, 0, 0.7);
        font-size: 16px !important;
        line-height: 22px;
        font-weight: bold;
        text-shadow: 0px 1px 1px rgba(254,254,254,.7);
        border: 2px solid #000;
        width: 25px;
        height: 25px;
        display: inline-block;
        border-radius: 50%;
        text-align: center;
        box-shadow: 0px 1px 1px rgba(254,254,254,.7);
    }
    .box
        {
          font-size: 1.25rem; /* 20 */
          background-color: #c8dadf;
          position: relative;
          padding: 50px 20px;
        }
        .box.has-advanced-upload
        {
          outline: 2px dashed #92b0b3;
          outline-offset: -10px;

          -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
          transition: outline-offset .15s ease-in-out, background-color .15s linear;
        }
        .box.is-dragover
        {
          outline-offset: -20px;
          outline-color: #c8dadf;
          background-color: #fff;
        }
          .box__dragndrop,
          .box__icon
          {
            display: none;
          }
          .box.has-advanced-upload .box__dragndrop
          {
            display: inline;
          }
          .box.has-advanced-upload .box__icon
          {
            width: 100%;
            height: 80px;
            fill: #92b0b3;
            display: block;
            margin-bottom: 40px;
          }

          .box.is-uploading .box__input,
          .box.is-success .box__input,
          .box.is-error .box__input
          {
            visibility: hidden;
          }

          .box__uploading,
          .box__success,
          .box__error
          {
            display: none;
          }
          .box.is-uploading .box__uploading,
          .box.is-success .box__success,
          .box.is-error .box__error
          {
            display: block;
            position: absolute;
            top: 50%;
            right: 0;
            left: 0;

            -webkit-transform: translateY( -50% );
            transform: translateY( -50% );
          }
          .box__uploading
          {
            font-style: italic;
          }
          .box__success
          {
            -webkit-animation: appear-from-inside .25s ease-in-out;
            animation: appear-from-inside .25s ease-in-out;
          }
            @-webkit-keyframes appear-from-inside
            {
              from  { -webkit-transform: translateY( -50% ) scale( 0 ); }
              75%   { -webkit-transform: translateY( -50% ) scale( 1.1 ); }
              to    { -webkit-transform: translateY( -50% ) scale( 1 ); }
            }
            @keyframes appear-from-inside
            {
              from  { transform: translateY( -50% ) scale( 0 ); }
              75%   { transform: translateY( -50% ) scale( 1.1 ); }
              to    { transform: translateY( -50% ) scale( 1 ); }
            }

          .box__restart
          {
            font-weight: 700;
          }
          .box__restart:focus,
          .box__restart:hover
          {
            color: #39bfd3;
          }

          .js .box__file
          {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
          }
          .js .box__file + label
          {
            max-width: 80%;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            display: inline-block;
            overflow: hidden;
          }

          .js .box__file + label:hover strong,
          .box__file:focus + label strong,
          .box__file.has-focus + label strong
          {
            color: #39bfd3;
          }
          .js .box__file:focus + label,
          .js .box__file.has-focus + label
          {
            outline: 1px dotted #000;
            outline: -webkit-focus-ring-color auto 5px;
          }
            .js .box__file + label *
            {
              /* pointer-events: none; */ /* in case of FastClick lib use */
            }

          .no-js .box__file + label
          {
            display: none;
          }

          .no-js .box__button
          {
            display: block;
          }
          .box__button
          {
            font-weight: 700;
            color: #e5edf1;
            background-color: #39bfd3;
            display: none;
            padding: 8px 16px;
            margin: 40px auto 0;
          }
            .box__button:hover,
            .box__button:focus
            {
              background-color: #0f3c4b;
            }
          svg {
  width: 100px;
  display: block;
  margin: 0 auto 0;
}
.path {
  stroke-dasharray: 1000;
  stroke-dashoffset: 0;
}
.path.circle {
  -webkit-animation: dash 0.9s ease-in-out;
  animation: dash 0.9s ease-in-out;
}
.path.line {
  stroke-dashoffset: 1000;
  -webkit-animation: dash 0.9s 0.35s ease-in-out forwards;
  animation: dash 0.9s 0.35s ease-in-out forwards;
}
.path.check {
  stroke-dashoffset: -100;
  -webkit-animation: dash-check 0.9s 0.35s ease-in-out forwards;
  animation: dash-check 0.9s 0.35s ease-in-out forwards;
}
p {
  text-align: center;
  margin: 20px 0 60px;
  font-size: 1.25em;
}
p.success {
  color: #73AF55 !important;
}
p.error {
  color: #D06079;
}
@-webkit-keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}
@-webkit-keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}
@keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}
.js .box__file + label:hover strong, .box__file:focus + label strong, .box__file.has-focus + label strong {
    color: #39bfd3;
}
.file-preview-input {
    position: relative;
    overflow: hidden;
    margin: 0px;
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
.file-preview-input input[type=file] {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  padding: 0;
  font-size: 20px;
  cursor: pointer;
  opacity: 0;
  filter: alpha(opacity=0);
}
.file-preview-input-title {
    margin-left:2px;
}
.inputclass {
    width: 100% !important;
    position: relative;
    z-index: 2;
    float: left;
    margin-bottom: 0;
    cursor: not-allowed !important;
    background-color: #eee !important;
    opacity: 1;
    border: 1px solid #ccc !important;
}
.input-group-btn{
    position: relative;
    font-size: 0;
    /* white-space: nowrap; */
    width: 1%;
    white-space: nowrap;
    vertical-align: middle;
    display: table-cell;
}
.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
.file-preview-input {
    position: relative;
    overflow: hidden;
    margin: 0px;
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}

.btn.btn-primary {
    background: #424f63;
    border: 1px solid #2e3744;
	
}
.input-group-btn>.btn {
    position: relative;
}
.input-group .form-control {
    position: relative;
    z-index: 2;
    float: left;
    width: 100%;
    margin-bottom: 0;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    cursor: not-allowed;
    background-color: #eee;
    opacity: 1;
}
.form-control {
	margin-top: 20px !important;
	height: 35px !important;
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}

.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}

.input-group {
    position: relative;
    display: table;
    border-collapse: separate;
}
   border: 1px solid #2e3744;
}
.input-group-btn>.btn {
    position: relative;
}
.btnhover:hover { 
    background-color: #eee;
}
    </style>
	@endsection('styles')
	@section('content')
        <!-- START CONTENT -->
        <section id="content">
          <!--breadcrumbs start-->
          <div id="breadcrumbs-wrapper">
            <!-- Search for small screen -->
            <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
              <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
            </div>
            <div class="container">
              <div class="row">
                <div class="col s10 m6 l6">
                  <ol class="breadcrumbs">
                    <li><a href="/">Dashboard</a></li>
                    <li><a href="#">Request Sender ID</a></li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
              <div class="row">
			  
                <div class="col s4">
                  <h5>Request Sender ID</h5>
				  </div>
				  @if(empty($company->logo))
				  <div class="col s8">
				  <p style="color:red;">Please upload your company logo to proceed <a href="{{url('/company/profile')}}">upload</a></p>
				 </div>
				 @endif
              </div>
              <div class="row">
			  
                <div class="col m4">
                  <ul class="collapsible popout" data-collapsible="accordion">
                 @if($senderid->step ==0)
					 <li class="" id="rq-step-1">
					 <div class="collapsible-header active" id="rq-step-1-header"  style="background-color:#54b70a;border:none;color:#fff">
					 
				 @else
					 <li class="active" id="rq-step-1">
					<div class="collapsible-header " id="rq-step-1-header">
				 @endif
                        <i class="material-icons">dehaze</i> Sender ID Details
                      </div>
                    </li>
			    @if($senderid->step == 1 && empty($senderid->authoriation_document))
					 <li class="" id="rq-step-2">
					 <div class="collapsible-header truncate active" id="rq-step-2-header"  style="background-color:#54b70a;border:none;color:#fff">
				@else
					 <li class="active" id="rq-step-2">
					 <div class="collapsible-header truncate" id="rq-step-2-header">
				 @endif
                        <i class="material-icons">file_download</i> Download Authorization Document
                      </div>
                    </li>
			    @if($senderid->step == 1 && !empty($senderid->authoriation_document))
					 <li class="" id="rq-step-3">
					 <div class="collapsible-header  active" id="rq-step-3-header"  style="background-color:#54b70a;border:none;color:#fff">
				@else
					 <li class="active" id="rq-step-3">
					 <div class="collapsible-header" id="rq-step-3-header">
				 @endif
                        <i class="material-icons">file_upload</i> Upload Signed Document
                      </div>
                    </li>
				@if($senderid->step == 3)
					 <li class="active" id="rq-step-4">
				     <div class="collapsible-header active" id="rq-step-4-header" style="background-color:#54b70a;border:none;color:#fff">
				@else
					 <li class="" id="rq-step-4">
				    <div class="collapsible-header" id="rq-step-4-header">
				     
				 @endif
                    <!--<li class="" id="rq-step-4">
                      <div class="collapsible-header" id="rq-step-4-header" >-->
                        <i class="material-icons">payment</i> Pay Now
                      </div>
                    </li>
                   @if($senderid->step == 4)
					 <li class="active" id="rq-step-5">
				     <div class="collapsible-header active" id="rq-step-5-header" style="background-color:#54b70a;border:none;color:#fff">
				 @else
					 <li class="" id="rq-step-5">
				     <div class="collapsible-header" id="rq-step-5-header">
				 @endif
                   
                        <i class="material-icons">insert_emoticon</i> Complete
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="col m8">
				 @if($senderid->step ==0)
					 <div class="card rq-step active" id="rq-step-1-body">
				 @else
					 <div class="card rq-step hide" id="rq-step-1-body">
				 @endif
                  
                    <div class="rq-step-header">
                      <span class="rq-step-no">1</span> 
                      <span>Sender ID Details</span>
                    </div>
					<form role="form" method="post" action="<?php echo URL::route('sender_id_form') ?>" id="sender_id_form" enctype="multipart/form-data">
					{{ csrf_field() }}
                    <div class="card-content center-align">
                      <div class="row">
                        <div class="input-field col s12">
                          <i class="material-icons prefix">account_circle</i>
                          <input type="text" class="" name="sender_id">
                          <label for="sender_id" class="">Desired Sender ID</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <i class="material-icons prefix">message</i>
                         <textarea id="message" name="message" class="materialize-textarea" data-length="120"></textarea>
                          <label for="message" class="">Sender ID Usage(What the sender ID will be used for)</label>
                        <span class="character-counter" style="float: right; font-size: 12px; height: 1px;"></span></div>
                      </div>

                    </div>
				 
                    <div class="card-action right-align">
					  @if(!empty($company->logo))
                      <button class="btn green" id="rq-step-1-next">Next</button>
					  @else
					  <button class="btn green" id="rq-step-1-next" disabled>Next</button>
					  @endif
                    </div>
					</form>
                  </div>

                 @if($senderid->step == 1 && empty($senderid->authoriation_document))
					 <div class="card rq-step active" id="rq-step-2-body">
				 @else
					<div class="card rq-step hide" id="rq-step-2-body">
				 @endif
					<div class="rq-step-header">
                      <span class="rq-step-no">2</span> 
                      <span>Preview and Download Authorization Letter</span>
                    </div>
                    <div class="card-content center-align">
                      <div>This is an authorization letter indicating that you authorize us to issue you with a sender ID</div>
                      <div>You are required to sign and stamp it</div>
                     <div class="row">
						<div class="col s12">
							<form role="form" method="post" action="<?php echo URL::route('editsenderid') ?>" id="companyform1">
								{{ csrf_field() }}
							    <table class="table table-bordered" style="border-spacing: 20px;">
								  <tr>
									<td class="center-align"  colspan="2" id="company_logo">
									 <img src="{{ url('logos/'.$company->logo) }}"  alt="Company Logo" width="35%" style="position:relative;"/><br>
									 	<div class="logorow row hide">
				        					<label>Edit the company logo</label>
				        					<div class="input-group file-preview center-align"   width="100%">
												<input placeholder="" type="text" class="form-control inputclass file-preview-filename" disabled="disabled" id="upload_doc_file_name1">
												<!-- don't give a name === doesn't send on POST/GET --> 
												<span class="input-group-btn"> 
												<!-- file-preview-clear button -->
												<button type="button" class="btnhover btn btn-default file-preview-clear" style="display:none;" id="upload_doc_clear1"> <span class="glyphicon glyphicon-remove"></span> Clear </button>
												<!-- file-preview-input -->
												<div class="btnhover btn btn-default file-preview-input">  <i class="material-icons">folder_open</i> <span class="file-preview-input-title">Browse</span>
													<input type="file" accept="text/cfg" name="doc_upload" id="doc_upload_input1" />
													<!-- rename it --> 
												</div>
												<!--<button type="button" class="btn btn-labeled btn-primary" id="upload_doc_btn" disabled> <span class="btn-label"><i class="material-icons">file_upload</i> </span>Upload</button>-->
												</span>
											</div>
											<div class="help-block">
												Only upload .jpg, .png or jpeg files.
											</div>

				        				</div>
									</td>
								  </tr>
								  <tr>
									<td colspan="2">
									   <p class="left-align" id="company_name">{{$company->name}}</p>
									   <p class="hide usernamep"><input type="text" class="form-control" name="username" id="username" value="{{$company->name}}" placeholder="Edit company name"></p>
									</td>
								  </tr>
								  <tr>
									 <td colspan="2">
									  <p class="left-align" id="company_email">{{$company->email}}</p>
									  <p class="hide emailp"><input type="text" class="form-control" name="email" id="email" value="{{$company->email}}" placeholder="Edit company email"></p>
									</td>
								  </tr>
								  <tr>
									<td colspan="2">
									   
									   <p class="left-align" id="company_no">{{$company->phone}}</p>
									<div class="row hide phonep">
									  <div class="input-field col s10">
										<!--<i class="material-icons prefix">call</i>-->
										<input type="tel"  name="telno" id="tel1" class="form-control" placeholder="Enter your Mobile Number" value="{{$company->phone}}" >
										<div style="width:10px;position:absolute;right: 30px;bottom: 10px;" >
										<span id="valid-msg1" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
										<span id="error-msg1" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>	
										</div>
									 </div>
									  
									</div>
									</td>
								  </tr>
								  <tr>
									<td colspan="2">
									  <p class="left-align" id="company_address">{{$company->address}}</p>
									  <p class="hide addressp"><input type="text" class="form-control" name="address" id="address" value="{{$company->address}}" placeholder="Edit company address"></p>
									</td>
								  </tr>
								  <tr>
									<td>
									  <p class="left-align">{{ date('Y-m-d H:i:s', time()) }}</p>
									</td>
								  </tr>
								  <tr>
									<td colspan="2" class="center-align"  style="text-decoration: underline;">
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
									 In order to improve the service that will bring  added value to our customers, <b><p style='display: inline-block;' id="company_senderidname">{{$company->name}}</p></b> appoints  <b>Nodcomm Ltd</b> to provide the needed support and carry on the activities that are neccessary for sustainable SMS service and registration of sender id: "<b><p style='display: inline-block;' id="company_senderid">Sender ID </p></b>"<p class="sender_id_input hide"><input type="text" class="form-control" name="sender_id" id="sender_id_input" placeholder="Edit the sender ID"><p>.
									</td>
								  </tr>
								  <tr>
									<td colspan="2">
									 The sender ID description (What the sender ID will be used for): <p id="company_senderiddesc" style='display: inline-block;'>Usage</p><p class="sender_id_desc hide"><input type="text" class="form-control" name="sender_id_desc" id="sender_id_desc" placeholder="Edit sender ID Usage"></p>
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
								</form>
						</div>
					 </div>
					 <div class="row">
					 <div class="col s6" style="margin: 40px 0 30px;">
						<a class="btn blue waves-effect waves-light modal-trigger" href="#modal2" id="new_company"><i class="material-icons left">add</i> New Company</a>
						<a class="btn green waves-effect waves-light" id="edit_company"><i class="material-icons left">edit</i> Edit</a>
						<a class="btn green waves-effect waves-light hide" id="save_company"><i class="material-icons left">save</i> Update</a>
					 </div>
					  <div class="col s3" style="margin: 40px 0 30px;">
					  </div>
					 <div class="col s3" style="margin: 40px 0 30px;">
                        <a class="waves-effect waves-light btn" href="{{ url('/senderID/download') }}">
                          <i class="material-icons left">file_download</i> Download Authorization Letter
                        </a>
                      </div>
					 </div>
                    </div>
					<div class="card-action right-align">
					  @if(!empty($company->logo))
                      <button class="btn green" id="rq-step-2-next">Next</button>
					  <button class="btn grey lighten-4 black-text left" id="rq-step-2-previous">Previous</button>
					  @else
					  <button class="btn green" id="rq-step-2-next" disabled>Next</button>
				  <button class="btn grey lighten-4 black-text left" id="rq-step-2-previous" disabled>Previous</button>
					  @endif
                    </div>
                  </div>

                 @if($senderid->step == 1 && !empty($senderid->authoriation_document))
				     <div class="card rq-step active" id="rq-step-3-body">
				 @else
					 <div class="card rq-step hide" id="rq-step-3-body">
				 @endif
                    <div class="rq-step-header">
                      <span class="rq-step-no">3</span> 
                      <span>Upload Authorization Letter</span>
                    </div>

                    <div class="card-content center-align">
                      <div>Upload the signed and stamped Authorization Letter</div>
                      <div style="margin: 20px 0 0 0;">
                        <form class="box has-advanced-upload"  method="post" action="<?php echo URL::route('sender_id_file') ?>" id="sender_id_file_form"  class="box" >
						   {{ csrf_field() }}  
						  <div class="box__input">
                            <svg class="box__icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43"><path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z"></path></svg>
                            <input style="display: none;" type="file" name="files[]" id="file" class="box__file" data-multiple-caption="{count} files selected" multiple>
                            <label style="font-size: 16px;" for="file"><strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>
                            <button type="submit" class="box__button">Upload</button>
                          </div>
                          <div class="box__uploading">Uploading&hellip;</div>
                          <div class="box__success">Done!</div>
                          <div class="box__error">Error! <span></span>.</div>
                        </form>
                      </div>
                    </div>
                    <div class="card-action right-align">
					  @if(!empty($company->logo))
                      <button class="btn green" id="rq-step-3-next">Request</button>
					  <button class="btn grey lighten-4 black-text left" id="rq-step-3-previous">Previous</button>
					  @else
					  <button class="btn green" id="rq-step-3-next" disabled>Request</button>
					  <button class="btn grey lighten-4 black-text left" id="rq-step-3-previous" disabled>Previous</button>
					  @endif
                    </div>
					
                  </div>

				  @if($senderid->step == 3)
					 <div class="card rq-step active" id="rq-step-4-body">
				 @else
					 <div class="card rq-step hide" id="rq-step-4-body">
				 @endif
                    <div class="rq-step-header">
                      <span class="rq-step-no">4</span> 
                      <span>Pay Now</span>
                    </div>
					@if($use_credit=='yes')
					  <div class="card-content center-align">
                      <div><h4 style="margin-top:0;font-size: 1.8rem;">Pay with Credits</h4></div>
                      <div class="row">
					  <div class="col m6"><strong>Available Credits: </strong>{{$credits}}</div>
					  <div class="col m6"><strong>Credits Due: </strong>{{$cost}}</div>
					  </div>
                      <div style="margin: 20px 0;">
					  <form role="form" method="post" action="<?php echo URL::route('pay_senderid_with_credits') ?>" id="pay_senderid_with_creditsform">
                       {{ csrf_field() }}
                        <div class="row" style="">
                         <div class="col m12">
						 <input type="hidden" class="form-control" name="credits" value="{{$credits}}">
                         <input type="hidden" class="form-control" name="cost" value="{{$cost}}">
						  <div class="" style="
                         text-align: center;
                      ">
                         <button class="btn blue waves-effect waves-light" id="pay_with_credits">Pay Now</button>
                      </div>
                         </div>
                      </div>
					  </form>
                      </div>
                    </div>
					@else
				    <div class="card-content center-align">
                      <div><h4 style="margin-top:0;font-size: 1.8rem;">Pay Credits</h4></div>
                      <div class="row">
					  <div class="col m6"><strong>Available Credits: </strong>{{$credits}}</div>
					  <div class="col m6"><strong>Credits Due: </strong>{{$cost}}</div>
					  </div>
                      <div style="margin: 20px 0;">
					  <form role="form" method="post" action="<?php echo URL::route('pay_senderid_with_credits') ?>" id="pay_senderid_with_creditsform">
                       {{ csrf_field() }}
                        <div class="row" style="">
                         <div class="col m12">
						 <input type="hidden" class="form-control" name="credits" value="{{$credits}}">
                         <input type="hidden" class="form-control" name="cost" value="{{$cost}}">
						  <div class="" style="
                         text-align: center;
                      ">
					    <a class="btn blue waves-effect waves-light modal-trigger" href="#modal1" id="pay_credits">Buy Credits</a>

                      </div>
                         </div>
                      </div>
					  </form>
                      </div>
                    </div>

					@endif
					 <div class="card-action right-align">
					  @if(!empty($company->logo))
                      <button class="btn grey lighten-4 black-text left" id="rq-step-4-previous" style="margin-bottom: 15px;">Previous</button>
					  @else
					   <button class="btn grey lighten-4 black-text left" id="rq-step-4-previous" style="margin-bottom: 15px;"  disabled>Previous</button>
					  @endif
                    </div>
                  </div>
				 @if($senderid->step == 4)
					 <div class="card rq-step active" id="rq-step-5-body">
				 @else
					 <div class="card rq-step hide" id="rq-step-5-body">
				 @endif
                  
                    <div class="rq-step-header">
                      <span class="rq-step-no">5</span> 
                      <span>Complete</span>
                    </div>
                    <div class="card-content center-align">
                      <div>
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                          <circle class="path circle" fill="none" stroke="#73AF55" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                          <polyline class="path check" fill="none" stroke="#73AF55" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                        </svg>
                        <p class="success">Oh Yeah!</p>
                      </div>
                      <div style="margin: 20px 0;">
                        <h5>All done!</h5>
                        <h5>Time for us to get down to business preparing your Sender ID.</h5>
                      </div>
                      <div style="border: 1px solid #eee;border-radius: 4px;padding: 20px 10px;">
                        <div style="margin-bottom: 20px;">In the meanwhile, why not send a message?</div>
                        <div><a class="btn green" href="{{url('/send/sms')}}">Send a message</a></div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--end container-->
		  
        <!-- Modal Structure -->
        <div id="modal1" class="modal">
        <div class="modal-content">
              <div class="row">
                <div class="col s12" id="paymentdiv">
				    <div class="card-panel">
					<h4 class="header2 center-align">Minimum credits to buy : </strong> {{$mincredittopurchase}}</h4>
                    <div class="">
					<form role="form" method="post" action="<?php echo URL::route('paymentamount1') ?>" id="paymentamountform">
					{{ csrf_field() }}
					<div class="row2">
					   <div>Select the number of credits to purchase</div>
					  <div class="input-field col2 s122">
					<i class="material-icons prefix2" style="
					   display: none;
					">monetization_on</i>
					<div class="select-wrapper initialized">
					<span class="caret">▼</span>
					 <input type="text" class="select-dropdown" readonly="true" data-activates="select-options-ce007b51-1c8d-d92e-0960-df993d07a777" value="200 credits @KES  200"><ul id="select-options-ce007b51-1c8d-d92e-0960-df993d07a777" class="dropdown-content select-dropdown" style="width: 1023.81px; position: absolute; top: 0px; left: 0px; display: none; opacity: 1;"><li class=""><span>200 credits @KES  200</span></li><li class=""><span>500 credits @KES  500</span></li><li class=""><span>1000 credits @KES  1,000</span></li><li class="active"><span>3000 credits @KES  3,000</span></li><li class=""><span>5000credits @KES  5,000 </span></li><li class=""><span>10000 credits @KES  10,000</span></li><li class=""><span>20000 credits @KES  20,000</span></li></ul>
					 <select name="amount" data-select-id="ce007b51-1c8d-d92e-0960-df993d07a777" class="initialized">
					  <option value="200">200 credits @KES  200</option>
					  <option value="500">500 credits @KES  500</option>
					  <option value="1000">1000 credits @KES  1,000</option>
					  <option value="3000">3000 credits @KES  3,000</option>	
					  <option value="5000">5000credits @KES  5,000 </option>
					  <option value="10000">10000 credits @KES  10,000</option>	
					  <option value="20000">20000 credits @KES  20,000</option>
					</select>
					</div>
					 <label style="display: none;">Select Credits</label>
					 </div>
					</div>

						<div class="row">
                         <div class="row2">
                           <div class="input-field col s12">
						  <button id="paybtn" class="btn cyan waves-effect waves-light left" type="submit" style="">Continue</button>
                           </div>
                         </div>
                       </div>
                      </form>
                    </div>
                  </div>
                </div>
				 <div class="col s12 hide" id="paymentdiv1" >
                  <div class="card-content center-align">
                      <div><h4 style="margin-top:0;font-size: 1.8rem;">Choose a payment method</h4></div>
                      <div><strong>Credits Due: </strong>{{$cost}}</div>
                      <div style="margin: 20px 0;">
                        <div class="row" style="">
                         <div class="col m6">
                             <div class="card-panel" style="
                         text-align: center;
                      ">
                         <h5 style="
                         text-align: center;
                         margin-bottom: 40px;
                      ">Pay By Card or MPESA</h5>
                         						<div class="payment-option-btn">
											<form role="form" method="post" action="<?php echo URL::route('smspayment2') ?>" id="smspayment1form">
											
									      <script
											id="paymentscript"
									        src="https://api.mambowallet.com/static/js/wallet.pay.checkout.1.0.js?v=ht56"
									        data-class="wallet-button"
									        data-key="wallet_Os07qIC8uafJdgKqOs07qIC8uafJdgKq"
									        data-amount="{{Session::get('amount_payed')}}"
									        data-name="SMS Credit"
									        data-description="Sms credit top up"
									        data-image="{{ url('/images/Nodcomm.png') }}"
									        data-locale="auto"
									        data-mobile=""
									        data-currency="KES"
									        data-email='{{Auth::user()->email}}'
											data-ref='<?php echo time() ?>'
									        data-label='Pay Now'
									        data-zip="true">
									      </script>
									    </form>
						</div>
                      </div>
                         </div>
                         <div class="col m6">
                             <div class="card-panel" style="
                         text-align: center;
                      ">
                         <h5 style="
                         text-align: center;
                         margin-bottom: 40px;
                      ">Pay By Paypal</h5>
                         <div id="paypal-button"></div>
                      </div>
                         </div>
                      </div>
                      </div>
                    </div>
                </div>
				</div>
        </div>
        <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
        </div>
		        <!-- Modal Structure -->
        <div id="modal2" class="modal">
        <div class="modal-content">
              <div class="row">
                <div class="col s12">
				    <div class="card-panel">
                    <h4 class="header2">Add Company</h4>
                    <div class="row">
					<form role="form" method="post" action="<?php echo URL::route('senderidcompany') ?>" id="companyform">
					{{ csrf_field() }}
                     
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="username">
                            <label for="username">Company Name</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input type="email" class="form-control" name="email">
                            <label for="email">Company Email</label>
                          </div>
                        </div>
						<div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" class="form-control" name="address">
                            <label for="address">Company Address</label>
                          </div>
                        </div>
                        <div class="row">
                          <div class="input-field col s10">
                            <input type="tel"  name="telno" id="tel" class="form-control" placeholder="Enter your Mobile Number">
                         	<div style="width:10px;position:absolute;right: 30px;bottom: 10px;" >
							<span id="valid-msg" class="hide"> <i class="text-center fa fa-check" aria-hidden="true"></i> </span>
							<span id="error-msg" class="hide"><i class="fa fa-times" aria-hidden="true"></i> </span>	
							</div>
						 </div>
						  
                        </div>

				        				<div class="form-group">
				        					<label>Upload the company logo</label>
				        					<div class="input-group file-preview">
												<input placeholder="" type="text" class="form-control inputclass file-preview-filename" disabled="disabled" id="upload_doc_file_name">
												<!-- don't give a name === doesn't send on POST/GET --> 
												<span class="input-group-btn"> 
												<!-- file-preview-clear button -->
												<button type="button" class="btnhover btn btn-default file-preview-clear" style="display:none;" id="upload_doc_clear"> <span class="glyphicon glyphicon-remove"></span> Clear </button>
												<!-- file-preview-input -->
												<div class="btnhover btn btn-default file-preview-input">  <i class="material-icons">folder_open</i> <span class="file-preview-input-title">Browse</span>
													<input type="file" accept="text/cfg" name="doc_upload" id="doc_upload_input" />
													<!-- rename it --> 
												</div>
												<!--<button type="button" class="btn btn-labeled btn-primary" id="upload_doc_btn" disabled> <span class="btn-label"><i class="material-icons">file_upload</i> </span>Upload</button>-->
												</span>
											</div>
											<div class="help-block">
												Only upload .jpg, .png or jpeg files.
											</div>

				        				</div>

						<div class="row">
                          <div class="row">
                            <div class="input-field col s12">
                              <button id="new_company_btn" class="btn cyan waves-effect waves-light right" type="submit">
                                <i class="material-icons left">add</i>  Add Company
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

				</div>
        </div>
        <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
        </div>

        </section>
        <!-- END CONTENT -->
    @endsection
@section('scripts')
	<script>

      $("#rq-step-1").click(function(e){
							$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-1-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});	
					
							$("#rq-step-4").removeClass("active").addClass("");
							$("#rq-step-2").removeClass("active").addClass("");
							$("#rq-step-3").removeClass("active").addClass("");
							$("#rq-step-1").removeClass("").addClass("active");
							$("#rq-step-5").removeClass("active").addClass("");		
						
							$("#rq-step-3-body").removeClass("active").addClass("hide");
							$("#rq-step-2-body").removeClass("active").addClass("hide");
							$("#rq-step-1-body").removeClass("hide").addClass("active");
							$("#rq-step-5-body").removeClass("active").addClass("hide");
							$("#rq-step-4-body").removeClass("active").addClass("hide");
      });
      $("#rq-step-2").click(function(){
		    $.ajax({
            type: "GET",
            url: server+'/get_sender_id',
            dataType:"json",
            beforeSend: function() {

            },
            cache: false,
            success: function(data) {
		
					if(data.details !=null){
						if(data.details.step <= 1 || data.details.step <= 4){
							
							$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-2-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});	
					
							$("#rq-step-4").removeClass("active").addClass("");
							$("#rq-step-1").removeClass("active").addClass("");
							$("#rq-step-3").removeClass("active").addClass("");
							$("#rq-step-2").removeClass("").addClass("active");
							$("#rq-step-5").removeClass("active").addClass("");		
						
							$("#rq-step-3-body").removeClass("active").addClass("hide");
							$("#rq-step-1-body").removeClass("active").addClass("hide");
							$("#rq-step-2-body").removeClass("hide").addClass("active");
							$("#rq-step-5-body").removeClass("active").addClass("hide");
							$("#rq-step-4-body").removeClass("active").addClass("hide");
						}else{
							$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-4").removeClass("active").addClass("");	
							
							$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-2").removeClass("active").addClass("");	
							
							$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-3").removeClass("active").addClass("");	
							
							$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-1").removeClass("active").addClass("");	
							
							$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-5").removeClass("active").addClass("");	
							if(data.details.step==1 && data.details.authoriation_document==null){
							$("#rq-step-2").removeClass("").addClass("active");
							$("#rq-step-2-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							}else if(data.details.step==1 && data.details.authoriation_document!=null){
							$("#rq-step-3").removeClass("").addClass("active");
							$("#rq-step-3-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							}
						}
					}else{
							$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-2").removeClass("active").addClass("");	
						}
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

               
					}
                });

   });
      $("#rq-step-3").click(function(){
		    $.ajax({
            type: "GET",
            url: server+'/get_sender_id',
            dataType:"json",
            beforeSend: function() {

            },
            cache: false,
            success: function(data) {
		
					if(data.details !=null){
						if(data.details.step <= 1 || data.details.step <= 4){
							
							$("#rq-step-3-body").removeClass("hide").addClass("active");
							$("#rq-step-1-body").removeClass("active").addClass("hide");
							$("#rq-step-2-body").removeClass("active").addClass("hide");
							$("#rq-step-5-body").removeClass("active").addClass("hide");
							$("#rq-step-4-body").removeClass("active").addClass("hide");
					
							$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-3-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});	
					
							$("#rq-step-4").removeClass("active").addClass("");
							$("#rq-step-2").removeClass("active").addClass("");
							$("#rq-step-1").removeClass("active").addClass("");
							$("#rq-step-3").removeClass("").addClass("active");
							$("#rq-step-5").removeClass("active").addClass("");
						}else{
							$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-4").removeClass("active").addClass("");	
							
							$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-2").removeClass("active").addClass("");	
							
							$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-3").removeClass("active").addClass("");	
							
							$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-1").removeClass("active").addClass("");	
							
							$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-5").removeClass("active").addClass("");	
							if(data.details.step==1 && data.details.authoriation_document==null){
							$("#rq-step-2").removeClass("").addClass("active");
							$("#rq-step-2-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							}else if(data.details.step==1 && data.details.authoriation_document!=null){
							$("#rq-step-3").removeClass("").addClass("active");
							$("#rq-step-3-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							}
						}
					}else{
							$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-3").removeClass("active").addClass("");	
						}
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

               
					}
                });
	  
	  
	  });
      $("#rq-step-4").click(function(){
		    $.ajax({
            type: "GET",
            url: server+'/get_sender_id',
            dataType:"json",
            beforeSend: function() {

            },
            cache: false,
            success: function(data) {
		
					if(data.details !=null){
						if(data.details.step == 3 || data.details.step == 4 ){
							
							$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-4-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});	
					
							$("#rq-step-2").removeClass("active").addClass("");
							$("#rq-step-1").removeClass("active").addClass("");
							$("#rq-step-3").removeClass("active").addClass("");
							$("#rq-step-4").removeClass("").addClass("active");
							$("#rq-step-5").removeClass("active").addClass("");		
						
							$("#rq-step-3-body").removeClass("active").addClass("hide");
							$("#rq-step-1-body").removeClass("active").addClass("hide");
							$("#rq-step-4-body").removeClass("hide").addClass("active");
							$("#rq-step-5-body").removeClass("active").addClass("hide");
							$("#rq-step-2-body").removeClass("active").addClass("hide");
						}else{
							$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-4").removeClass("active").addClass("");	
							
							$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-2").removeClass("active").addClass("");	
							
							$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-3").removeClass("active").addClass("");	
							
							$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-1").removeClass("active").addClass("");	
							
							$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-5").removeClass("active").addClass("");	
							if(data.details.step==1 && data.details.authoriation_document==null){
							$("#rq-step-2").removeClass("").addClass("active");
							$("#rq-step-2-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							}else if(data.details.step==1 && data.details.authoriation_document!=null){
							$("#rq-step-3").removeClass("").addClass("active");
							$("#rq-step-3-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							}
						}
					}else{
							$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-4").removeClass("active").addClass("");	
						}
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

               
					}
                });
	});
      $("#rq-step-5").click(function(){
		    $.ajax({
            type: "GET",
            url: server+'/get_sender_id',
            dataType:"json",
            beforeSend: function() {

            },
            cache: false,
            success: function(data) {
		
					if(data.details !=null){
						if(data.details.step == 4){
							
							$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-5-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});	
					
							$("#rq-step-4").removeClass("active").addClass("");
							$("#rq-step-1").removeClass("active").addClass("");
							$("#rq-step-3").removeClass("active").addClass("");
							$("#rq-step-5").removeClass("").addClass("active");
							$("#rq-step-2").removeClass("active").addClass("");		
						
							$("#rq-step-3-body").removeClass("active").addClass("hide");
							$("#rq-step-1-body").removeClass("active").addClass("hide");
							$("#rq-step-5-body").removeClass("hide").addClass("active");
							$("#rq-step-2-body").removeClass("active").addClass("hide");
							$("#rq-step-4-body").removeClass("active").addClass("hide");
						}else{
							$("#rq-step-4-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-4").removeClass("active").addClass("");	
							
							$("#rq-step-2-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-2").removeClass("active").addClass("");	
							
							$("#rq-step-3-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-3").removeClass("active").addClass("");	
							
							$("#rq-step-1-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-1").removeClass("active").addClass("");	
							
							$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-5").removeClass("active").addClass("");	
							if(data.details.step==1 && data.details.authoriation_document==null){
							$("#rq-step-2").removeClass("").addClass("active");
							$("#rq-step-2-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							}else if(data.details.step==1 && data.details.authoriation_document!=null){
							$("#rq-step-3").removeClass("").addClass("active");
							$("#rq-step-3-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							}else if(data.details.step==3 && data.details.authoriation_document!=null){
							$("#rq-step-4").removeClass("").addClass("active");
							$("#rq-step-4-header").removeClass("").addClass("active").css({"background-color":"#54b70a","border":"none","color":"#fff"});
							}
						}
					}else{
							$("#rq-step-5-header").removeClass("active").addClass("").css({"background-color":"","border":"","color":""});
							$("#rq-step-5").removeClass("active").addClass("");	
						}
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

               
					}
                });
	 
	 });

    </script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
	<script src="{{ url('int-tel/js/intlTelInput.js') }}"></script>
	<script type="application/javascript">
	$("#tel").intlTelInput({
	  initialCountry: "auto",
	  geoIpLookup: function(callback) {
	  },
	  utilsScript: "/int-tel/js/utils.js" // just for formatting/placeholders etc
	});
	$("#tel1").intlTelInput({
	  initialCountry: "auto",
	  geoIpLookup: function(callback) {
	  },
	  utilsScript: "/int-tel/js/utils.js" // just for formatting/placeholders etc
	});

	var paypalamount="{{Session::get('amount_payed')/100}}";
	var env= "<?php echo $paypal_mode; ?>";
	var paypal_client_ID="<?php echo $paypal_client_ID; ?>";
	var csrf_token = "{{ csrf_token() }}";
	</script>
	
	<script src="{{ url('/assets/js/sender_id.js?v=101cc') }}"></script>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script src="{{ url('/assets/js/paypal2.js') }}"></script>
	@endsection