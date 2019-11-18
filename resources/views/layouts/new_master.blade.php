<!DOCTYPE html>
<html lang="en">
  <!--================================================================================
  Item Name: Materialize - Material Design Admin Template
  Version: 4.0
  Author: PIXINVENT
  Author URL: https://themeforest.net/user/pixinvent/portfolio
  ================================================================================ -->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <title>{{config('app.name', 'Nodcomm')}}</title>

    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="../../images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->
    <!-- CORE CSS-->
    <link href="{{ url('css/themes/fixed-menu/materialize.css')}}" type="text/css" rel="stylesheet">
    <link href="{{ url('css/themes/fixed-menu/style.css')}}" type="text/css" rel="stylesheet">
    <!-- Custome CSS-->
    <link href="{{ url('css/custom/custom.css')}}" type="text/css" rel="stylesheet">
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="{{ url('vendors/perfect-scrollbar/perfect-scrollbar.css')}}" type="text/css" rel="stylesheet">
    <link href="{{ url('vendors/jvectormap/jquery-jvectormap.css')}}" type="text/css" rel="stylesheet">
    <link href="{{ url('vendors/flag-icon/css/flag-icon.min.css')}}" type="text/css" rel="stylesheet">
  <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />-->
  <link href="{{ url('vendors/data-tables/css/jquery.dataTables.min.css')}}" type="text/css" rel="stylesheet">
   <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ url('/assets/css/gritter/jquery.gritter.css') }}">
      <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/data-tables/css/jquery.dataTables.min.css">
      <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
      <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/data-tables/css/select.dataTables.min.css">
      <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/data-tables.css">


  @yield('styles')
 </head>
  <body>
    <!-- Start Page Loading -->
    <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->
    <!-- //////////////////////////////////////////////////////////////////////////// -->
    <!-- START HEADER -->
    <header id="header" class="page-topbar">
      <!-- start header nav-->
      <div class="navbar-fixed">
        <nav class="navbar-color">
          <div class="nav-wrapper">
            <ul class="left">
              <li>
                <h1 class="logo-wrapper">
                  <a href="/" class="brand-logo darken-1">
                    
                    <span class="logo-text hide-on-med-and-down"><img src="{{ url('/images/Nodcomm.png') }}" alt="nodcomm logo"></span>
                  </a>
                </h1>
              </li>
            </ul>
            <div class="header-search-wrapper hide-on-med-and-down">
              <i class="material-icons">search</i>
              <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Nodcomm" />
            </div>
            <ul class="right hide-on-med-and-down">
              <li>
                <a href="javascript:void(0);" class="waves-effect waves-block waves-light translation-button" data-activates="translation-dropdown">
                  <span class="flag-icon flag-icon-gb"></span>
                </a>
              </li>
              <li>
                <a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen">
                  <i class="material-icons">settings_overscan</i>
                </a>
              </li>
              <li>
                <a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button" data-activates="notifications-dropdown">
                  <i class="material-icons">notifications_none
                    <small class="notification-badge pink accent-2">5</small>
                  </i>
                </a>
              </li>
              <li>
                <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                  <span class="avatar-status avatar-online">
          <?php if(empty(Auth::user()->photo)) {;?>
          <img src="{{ url('/dist/img/avatar21.png') }}" alt="" class="circle responsive-img valign profile-image cyan">
          <?php }else{ ?>
          <img src="{{ url('profile_photos/'.Auth::user()->photo) }}" alt="" class="circle responsive-img valign profile-image cyan">
          <?php } ?>
                    <i></i>
                  </span>
                </a>
              </li>
              <li>
                <a href="#" data-activates="chat-out" class="waves-effect waves-block waves-light chat-collapse">
                  <i class="material-icons">format_indent_increase</i>
                </a>
              </li>
            </ul>
            <!-- translation-button -->
            <ul id="translation-dropdown" class="dropdown-content">
              <li>
                <a href="#!" class="grey-text text-darken-1">
                  <i class="flag-icon flag-icon-gb"></i> English</a>
              </li>
              <li>
                <a href="#!" class="grey-text text-darken-1">
                  <i class="flag-icon flag-icon-fr"></i> French</a>
              </li>
              <li>
                <a href="#!" class="grey-text text-darken-1">
                  <i class="flag-icon flag-icon-cn"></i> Chinese</a>
              </li>
              <li>
                <a href="#!" class="grey-text text-darken-1">
                  <i class="flag-icon flag-icon-de"></i> German</a>
              </li>
            </ul>
            <!-- notifications-dropdown -->
            <ul id="notifications-dropdown" class="dropdown-content">
              <li>
                <h6>NOTIFICATIONS
                  <span class="new badge">5</span>
                </h6>
              </li>
              <li class="divider"></li>
              <li>
                <a href="#!" class="grey-text text-darken-2">
                  <span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> A new order has been placed!</a>
                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
              </li>
              <li>
                <a href="#!" class="grey-text text-darken-2">
                  <span class="material-icons icon-bg-circle red small">stars</span> Completed the task</a>
                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
              </li>
              <li>
                <a href="#!" class="grey-text text-darken-2">
                  <span class="material-icons icon-bg-circle teal small">settings</span> Settings updated</a>
                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
              </li>
              <li>
                <a href="#!" class="grey-text text-darken-2">
                  <span class="material-icons icon-bg-circle deep-orange small">today</span> Director meeting started</a>
                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
              </li>
              <li>
                <a href="#!" class="grey-text text-darken-2">
                  <span class="material-icons icon-bg-circle amber small">trending_up</span> Generate monthly report</a>
                <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
              </li>
            </ul>
            <!-- profile-dropdown -->
            <ul id="profile-dropdown" class="dropdown-content">
              <li>
                <a href="{{ url('/profile') }}" class="grey-text text-darken-1">
                  <i class="material-icons">face</i> Profile</a>
              </li>
              <li>
                <a href="{{ url('/setting/prechat') }}" class="grey-text text-darken-1">
                  <i class="material-icons">settings</i> Settings</a>
              </li>
              <li>
                <a href="{{ url('/support') }}" class="grey-text text-darken-1">
                  <i class="material-icons">live_help</i> Help</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="{{ url('/logout') }}" class="grey-text text-darken-1">
                  <i class="material-icons">keyboard_tab</i> Logout</a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
      <!-- end header nav-->
    </header>
    <!-- END HEADER -->
    <!-- //////////////////////////////////////////////////////////////////////////// -->
    <!-- START MAIN -->
    <div id="main">
      <!-- START WRAPPER -->
      <div class="wrapper">
        <!-- START LEFT SIDEBAR NAV-->
        <aside id="left-sidebar-nav">
          <ul id="slide-out" class="side-nav fixed leftside-navigation">
            <li class="user-details cyan darken-2">
              <div class="row">
                <div class="col col s4 m4 l4">
                 <?php if(empty(Auth::user()->photo)) {;?>
                <img src="{{ url('/dist/img/avatar21.png') }}" alt="" class="circle responsive-img valign profile-image cyan">
                <?php }else{ ?>
                <img src="{{ url('profile_photos/'.Auth::user()->photo) }}" alt="" class="circle responsive-img valign profile-image cyan">
                <?php } ?>
        </div>
                <div class="col col s8 m8 l8">
                  <ul id="profile-dropdown-nav" class="dropdown-content">
                    <li>
                      <a href="{{ url('/profile') }}" class="grey-text text-darken-1">
                        <i class="material-icons">face</i> Profile</a>
                    </li>
                    <li>
                      <a href="{{ url('/setting/prechat') }}" class="grey-text text-darken-1">
                        <i class="material-icons">settings</i> Settings</a>
                    </li>
                    <li>
                      <a href="{{ url('/support') }}" class="grey-text text-darken-1">
                        <i class="material-icons">live_help</i> Help</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="{{ url('/logout') }}" class="grey-text text-darken-1">
                        <i class="material-icons">keyboard_tab</i> Logout</a>
                    </li>
                  </ul>
                  <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown-nav">
          <?php 

          echo ucwords(Auth::user()->name);
          ?>

        <i class="mdi-navigation-arrow-drop-down right"></i></a>
                  <p class="user-roal">
          <?php
          if(Auth::user()->admin==1 && Auth::user()->company_id==0){
           echo ' Super Administrator'; 
          }elseif(Auth::user()->admin==1 && Auth::user()->company_id!=0){
            echo ' Administrator'; 
          }else{
            echo ' (Agent)'; 
          }
          ?>
          </p>
                </div>
              </div>
            </li>
            <li class="no-padding">
              <ul class="collapsible" data-collapsible="accordion">
                <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan active">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Dashboard</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li @if(Route::currentRouteName() == "main-dashboard") class="active"  @endif>
                        <a href="{{ url('/dashboard') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Main Dashboard</span>
                        </a>
                      </li>
                      <li @if(Route::currentRouteName() == "analytic-dashboard") class="active"  @endif>
                        <a href="{{ url('/dashboard/analytics') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Analytics</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
        <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan active">
                    <i class="material-icons">message</i>
                    <span class="nav-text">{{trans('menu.sms')}}</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li @if(Route::currentRouteName() == "messages_history") class="active" @endif>
                        <a href="{{ url('/sms') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>{{trans('menu.sms')}}</span>
                        </a>
                      </li>
            <li @if(Route::currentRouteName() == "buy_credit") class="active" @endif>
                        <a href="{{ url('/purchase/credits') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Purchase Credits</span>
                        </a>
                      </li>
            <li @if(Route::currentRouteName() == "test-messages") class="active" @endif>
                        <a href="{{ url('/send/sms') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Send SMS</span>
                        </a>
                      </li>
            <li @if(Route::currentRouteName() == "contact_groups") class="active" @endif>
                        <a href="{{ url('/sms/contacts') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Contact Groups</span>
                        </a>
                      </li>
            @if (Auth::user()->admin && Auth::user()->company_id==0)
                      <li @if(Route::currentRouteName() == "credit_history") class="active" @endif>
                        <a href="{{ url('/credits') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>SMS Credits</span>
                        </a>
                      </li>
             <li @if(Route::currentRouteName() == "sender_ids") class="active" @endif>
                        <a href="{{ url('/senderIDs') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Sender IDs</span>
                        </a>
                      </li>
            @endif
            @if (Auth::user()->admin && Auth::user()->company_id!=0)
             <li @if(Route::currentRouteName() == "sender_ids") class="active" @endif>
                        <a href="{{ url('/sms/senderIDs') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Request Sender ID</span>
                        </a>
                      </li>
            @endif
                    </ul>
                  </div>
                </li>
        <!--<li @if(Route::currentRouteName() == "chats") class="active" @else class="bold" @endif>
                  <a href="{{ url('/chats') }}" class="waves-effect waves-cyan">
                    <i class="material-icons">comment</i>
                    <span class="nav-text">{{trans('menu.chats')}}</span>
                  </a>
                </li>-->
        <li @if(Route::currentRouteName() == "chats") class="active" @else class="bold" @endif>
                  <a href="https://chat.nodcomm.com" class="waves-effect waves-cyan">
                    <i class="material-icons">comment</i>
                    <span class="nav-text">{{trans('menu.chats')}}</span>
                  </a>
                </li>
        <li @if(Route::currentRouteName() == "push_sites") class="active" @else class="bold" @endif>
                  <a href="{{ url('/push') }}" class="waves-effect waves-cyan">
                    <i class="material-icons">notifications</i>
                    <span class="nav-text">{{trans('menu.push')}}</span>
                  </a>
                </li>
        @if(Session::has('previouslogin'))
        <li @if(Route::currentRouteName() == "back") class="active" @else class="bold" @endif>
                  <a href="{{ url('/back') }}" class="waves-effect waves-cyan">
                    <i class="material-icons">person</i>
                    <span class="nav-text">Go back to your dashboard</span>
                  </a>
                </li>
        @endif
        
                <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">settings</i>
                    <span class="nav-text">{{trans('menu.settings')}}</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
           <li @if(Route::currentRouteName() == "profile") class="active" @endif>
                        <a href="{{ url('/profile') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> {{trans('menu.profile')}}</span>
                        </a>
                      </li>
            @if (Auth::user()->admin && Auth::user()->company_id!=0)
            <li @if(Route::currentRouteName() == "company_profile") class="active" @endif>
                        <a href="{{ url('/company/profile') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> Company Profile</span>
                        </a>
                      </li>
            @endif
            @if (Auth::user()->admin)
                      <li @if(Route::currentRouteName() == "prechatsetting") class="active" @endif>
                        <a href="{{ url('/setting/prechat') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> {{trans('menu.prechat')}}</span>
                        </a>
                      </li>
                      <li @if(Route::currentRouteName() == "postchatsetting") class="active" @endif>
                        <a href="{{ url('/setting/postchat') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> {{trans('menu.postchat')}}</span>
                        </a>
                      </li>
            <li @if(Route::currentRouteName() == "departmenttsetting") class="active" @endif>
                        <a href="{{ url('/setting/department') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> {{trans('menu.department')}}</span>
                        </a>
                      </li>
            <li @if(Route::currentRouteName() == "sites") class="active" @endif>
            <a href="{{ url('/sites') }}" class="waves-effect waves-cyan">
            <i class="material-icons">language</i>
            <span class="nav-text">{{trans('menu.sites')}}</span>
            </a>
            </li>
            @if (Auth::user()->admin && Auth::user()->company_id==0)
            <li @if(Route::currentRouteName() == "general-settings") class="active" @endif>
                        <a href="{{ url('/setting/general') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> {{trans('menu.general')}}</span>
                        </a>
                      </li>
            <li @if(Route::currentRouteName() == "advertisements") class="active" @endif>
                        <a href="{{ url('/advertisements') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> {{trans('menu.advertisements')}}</span>
                        </a>
                      </li>
            <li @if(Route::currentRouteName() == "translation") class="active" @endif>
                        <a href="{{ url('/translation') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> Languages</span>
                        </a>
                      </li>
            @endif
                    </ul>
                  </div>
                </li>
        @if (Auth::user()->company_id!=0)
        <li @if(Route::currentRouteName() == "agents") class="active" @endif>
                  <a href="{{ url('/users') }}" class="waves-effect waves-cyan">
                    <i class="material-icons">person</i>
                    <span class="nav-text">{{trans('menu.users')}}</span>
                  </a>
                </li>
        @endif
        @if (Auth::user()->admin && Auth::user()->company_id==0)
        <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan active">
                    <i class="material-icons">people</i>
                    <span class="nav-text">{{trans('menu.users')}}</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li @if(Route::currentRouteName() == "super-admins") class="active" @endif>
                        <a href="{{ url('/super-admins') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>{{trans('menu.admins')}}</span>
                        </a>
                      </li>
                      <li @if(Route::currentRouteName() == "users") class="active" @endif>
                        <a href="{{ url('/users') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Clients</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
        @endif


        <!--<li @if(Route::currentRouteName() == "emails_history") class="active" @else class="bold" @endif>
                  <a href="{{ url('/email') }}" class="waves-effect waves-cyan">
                    <i class="material-icons">mail_outline</i>
                    <span class="nav-text">{{trans('menu.email')}}</span>
                  </a>
                </li>-->
        @endif
        @if (Auth::user()->admin && Auth::user()->company_id==0)
        <li @if(Route::currentRouteName() == "companies") class="active" @else class="bold" @endif>
                  <a href="{{ url('/admin/companies') }}" class="waves-effect waves-cyan">
                    <i class="material-icons">web</i>
                    <span class="nav-text">{{trans('menu.companies')}}</span>
                  </a>
                </li>
        @endif
          </ul>


    <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan active">
                    <i class="material-icons">help_outline</i>
                    <span class="nav-text">Support</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li @if(Route::currentRouteName() == "support") class="active"  @endif>
                        <a href="{{ url('/support') }}">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Support</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>




      </li>
          <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only">
            <i class="material-icons">menu</i>
          </a>
          </ul>
        </aside>
        <!-- END LEFT SIDEBAR NAV-->
        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <!-- START CONTENT -->
  @yield('content')
  
         <!-- Floating Action Button -->
        <div class="fixed-action-btn " style="bottom: 50px; right: 19px;">
          <a class="btn-floating btn-large">
            <i class="material-icons">add</i>
          </a>
          <ul>
            <li>
              <a href="/help" class="btn-floating blue">
                <i class="material-icons">help_outline</i>
              </a>
            </li>
            <li>
              <a href="/dashboard" class="btn-floating green">
                <i class="material-icons">widgets</i>
              </a>
            </li>
            <li>
              <a href="app-calendar.html" class="btn-floating amber">
                <i class="material-icons">today</i>
              </a>
            </li>
            <li>
              <a href="/send/sms" class="btn-floating red">
                <i class="material-icons">mail_outline</i>
              </a>
            </li>
          </ul>
        </div>
        <!-- Floating Action Button -->
        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <!-- START RIGHT SIDEBAR NAV-->
        <aside id="right-sidebar-nav">
          <ul id="chat-out" class="side-nav rightside-navigation">
            <li class="li-hover">
              <div class="row">
                <div class="col s12 border-bottom-1 mt-5">
                  <ul class="tabs">
                    <li class="tab col s4">
                      <a href="#activity" class="active">
                        <span class="material-icons">graphic_eq</span>
                      </a>
                    </li>
                    <li class="tab col s4">
                      <a href="#chatapp">
                        <span class="material-icons">face</span>
                      </a>
                    </li>
                    <li class="tab col s4">
                      <a href="#settings">
                        <span class="material-icons">settings</span>
                      </a>
                    </li>
                  </ul>
                </div>
                <div id="settings" class="col s12">
                  <h6 class="mt-5 mb-3 ml-3">GENERAL SETTINGS</h6>
                  <ul class="collection border-none">
                    <li class="collection-item border-none">
                      <div class="m-0">
                        <span class="font-weight-600">Notifications</span>
                        <div class="switch right">
                          <label>
                            <input checked type="checkbox">
                            <span class="lever"></span>
                          </label>
                        </div>
                      </div>
                      <p>Use checkboxes when looking for yes or no answers.</p>
                    </li>
                    <li class="collection-item border-none">
                      <div class="m-0">
                        <span class="font-weight-600">Show recent activity</span>
                        <div class="switch right">
                          <label>
                            <input checked type="checkbox">
                            <span class="lever"></span>
                          </label>
                        </div>
                      </div>
                      <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                    </li>
                    <li class="collection-item border-none">
                      <div class="m-0">
                        <span class="font-weight-600">Notifications</span>
                        <div class="switch right">
                          <label>
                            <input type="checkbox">
                            <span class="lever"></span>
                          </label>
                        </div>
                      </div>
                      <p>Use checkboxes when looking for yes or no answers.</p>
                    </li>
                    <li class="collection-item border-none">
                      <div class="m-0">
                        <span class="font-weight-600">Show recent activity</span>
                        <div class="switch right">
                          <label>
                            <input type="checkbox">
                            <span class="lever"></span>
                          </label>
                        </div>
                      </div>
                      <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                    </li>
                    <li class="collection-item border-none">
                      <div class="m-0">
                        <span class="font-weight-600">Show your emails</span>
                        <div class="switch right">
                          <label>
                            <input type="checkbox">
                            <span class="lever"></span>
                          </label>
                        </div>
                      </div>
                      <p>Use checkboxes when looking for yes or no answers.</p>
                    </li>
                    <li class="collection-item border-none">
                      <div class="m-0">
                        <span class="font-weight-600">Show Task statistics</span>
                        <div class="switch right">
                          <label>
                            <input type="checkbox">
                            <span class="lever"></span>
                          </label>
                        </div>
                      </div>
                      <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                    </li>
                  </ul>
                </div>
                <div id="chatapp" class="col s12">
                  <div class="collection border-none">
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-1.png" alt="" class="circle cyan">
                      <span class="line-height-0">Elizabeth Elliott </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">5.00 AM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Thank you </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-2.png" alt="" class="circle deep-orange accent-2">
                      <span class="line-height-0">Mary Adams </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">4.14 AM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Hello Boo </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-3.png" alt="" class="circle teal accent-4">
                      <span class="line-height-0">Caleb Richards </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">9.00 PM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Keny ! </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-4.png" alt="" class="circle cyan">
                      <span class="line-height-0">June Lane </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">4.14 AM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Ohh God </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-5.png" alt="" class="circle red accent-2">
                      <span class="line-height-0">Edward Fletcher </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">5.15 PM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Love you </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-6.png" alt="" class="circle deep-orange accent-2">
                      <span class="line-height-0">Crystal Bates </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">8.00 AM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Can we </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-7.png" alt="" class="circle cyan">
                      <span class="line-height-0">Nathan Watts </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">9.53 PM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Great! </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-8.png" alt="" class="circle red accent-2">
                      <span class="line-height-0">Willard Wood </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">4.20 AM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Do it </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-9.png" alt="" class="circle teal accent-4">
                      <span class="line-height-0">Ronnie Ellis </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">5.30 PM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Got that </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-1.png" alt="" class="circle cyan">
                      <span class="line-height-0">Gwendolyn Wood </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">4.34 AM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Like you </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-2.png" alt="" class="circle red accent-2">
                      <span class="line-height-0">Daniel Russell </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">12.00 AM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Thank you </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-3.png" alt="" class="circle teal accent-4">
                      <span class="line-height-0">Sarah Graves </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">11.14 PM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Okay you </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-4.png" alt="" class="circle red accent-2">
                      <span class="line-height-0">Andrew Hoffman </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">7.30 PM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Can do </p>
                    </a>
                    <a href="#!" class="collection-item avatar border-none">
                      <img src="../../images/avatar/avatar-5.png" alt="" class="circle cyan">
                      <span class="line-height-0">Camila Lynch </span>
                      <span class="medium-small right blue-grey-text text-lighten-3">2.00 PM</span>
                      <p class="medium-small blue-grey-text text-lighten-3">Leave it </p>
                    </a>
                  </div>
                    @yield('content')

                </div>
                <div id="activity" class="col s12">
                  <h6 class="mt-5 mb-3 ml-3">RECENT ACTIVITY</h6>
                  <div class="activity">
                    <div class="col s3 mt-2 center-align recent-activity-list-icon">
                      <i class="material-icons white-text icon-bg-color deep-purple lighten-2">add_shopping_cart</i>
                    </div>
                    <div class="col s9 recent-activity-list-text">
                      <a href="#" class="deep-purple-text medium-small">just now</a>
                      <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Jim Doe Purchased new equipments for zonal office.</p>
                    </div>
                    <div class="recent-activity-list chat-out-list row mb-0">
                      <div class="col s3 mt-2 center-align recent-activity-list-icon">
                        <i class="material-icons white-text icon-bg-color cyan lighten-2">airplanemode_active</i>
                      </div>
                      <div class="col s9 recent-activity-list-text">
                        <a href="#" class="cyan-text medium-small">Yesterday</a>
                        <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Your Next flight for USA will be on 15th August 2015.</p>
                      </div>
                    </div>
                    <div class="recent-activity-list chat-out-list row mb-0">
                      <div class="col s3 mt-2 center-align recent-activity-list-icon medium-small">
                        <i class="material-icons white-text icon-bg-color green lighten-2">settings_voice</i>
                      </div>
                      <div class="col s9 recent-activity-list-text">
                        <a href="#" class="green-text medium-small">5 Days Ago</a>
                        <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Natalya Parker Send you a voice mail for next conference.</p>
                      </div>
                    </div>
                    <div class="recent-activity-list chat-out-list row mb-0">
                      <div class="col s3 mt-2 center-align recent-activity-list-icon">
                        <i class="material-icons white-text icon-bg-color amber lighten-2">store</i>
                      </div>
                      <div class="col s9 recent-activity-list-text">
                        <a href="#" class="amber-text medium-small">1 Week Ago</a>
                        <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Jessy Jay open a new store at S.G Road.</p>
                      </div>
                    </div>
                    <div class="recent-activity-list row">
                      <div class="col s3 mt-2 center-align recent-activity-list-icon">
                        <i class="material-icons white-text icon-bg-color deep-orange lighten-2">settings_voice</i>
                      </div>
                      <div class="col s9 recent-activity-list-text">
                        <a href="#" class="deep-orange-text medium-small">2 Week Ago</a>
                        <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">voice mail for conference.</p>
                      </div>
                    </div>
                    <div class="recent-activity-list chat-out-list row mb-0">
                      <div class="col s3 mt-2 center-align recent-activity-list-icon medium-small">
                        <i class="material-icons white-text icon-bg-color brown lighten-2">settings_voice</i>
                      </div>
                      <div class="col s9 recent-activity-list-text">
                        <a href="#" class="brown-text medium-small">1 Month Ago</a>
                        <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Natalya Parker Send you a voice mail for next conference.</p>
                      </div>
                    </div>
                    <div class="recent-activity-list chat-out-list row mb-0">
                      <div class="col s3 mt-2 center-align recent-activity-list-icon">
                        <i class="material-icons white-text icon-bg-color deep-purple lighten-2">store</i>
                      </div>
                      <div class="col s9 recent-activity-list-text">
                        <a href="#" class="deep-purple-text medium-small">3 Month Ago</a>
                        <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">Jessy Jay open a new store at S.G Road.</p>
                      </div>
                    </div>
                    <div class="recent-activity-list row">
                      <div class="col s3 mt-2 center-align recent-activity-list-icon">
                        <i class="material-icons white-text icon-bg-color grey lighten-2">settings_voice</i>
                      </div>
                      <div class="col s9 recent-activity-list-text">
                        <a href="#" class="grey-text medium-small">1 Year Ago</a>
                        <p class="mt-0 mb-2 fixed-line-height font-weight-300 medium-small">voice mail for conference.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </aside>
        <!-- END RIGHT SIDEBAR NAV-->
        </div>
        <!-- END WRAPPER -->
      </div>
      <!-- END MAIN -->
      <!-- //////////////////////////////////////////////////////////////////////////// -->
      <!-- START FOOTER -->
      <footer class="page-footer">
        <div class="footer-copyright">
          <div class="container">
            <span>Copyright ©
              <script type="text/javascript">
                document.write(new Date().getFullYear());
              </script> <a class="grey-text text-lighten-2" href="https://www.nodcomm.com/" target="_blank">NodComm</a> All rights reserved.</span>
            <!-- <span class="right hide-on-small-only"> Design and Developed by <a class="grey-text text-lighten-2" href="https://www.nodcomm.com/">NodComm</a></span> -->
          </div>
        </div>
      </footer>
      <!-- END FOOTER -->
      <!-- ================================================
    Scripts
    ================================================ -->
      <!-- jQuery Library -->
      <script type="text/javascript" src="{{ url('vendors/jquery-3.2.1.min.js')}}"></script>
      <!--materialize js-->
      <script type="text/javascript" src="{{ url('js/materialize.min.js')}}"></script>
      <!--prism-->
      <script type="text/javascript" src="{{ url('vendors/prism/prism.js')}}"></script>
      <!--scrollbar-->
      <script type="text/javascript" src="{{ url('vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
      <!-- chartjs -->
      <script type="text/javascript" src="{{ url('vendors/chartjs/chart.min.js')}}"></script>
      <!--plugins.js - Some Specific JS codes for Plugin Settings-->
      <script type="text/javascript" src="{{ url('js/plugins.js')}}"></script>
           <!-- data-tables -->
{{--    <script type="text/javascript" src="{{ url('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>--}}
    <!--data-tables.js - Page Specific JS codes -->

    <!-- END PAGE VENDOR JS-->

{{--    <script type="text/javascript" src="{{ url('js/scripts/data-tables.js') }}"></script>--}}

      <!--custom-script.js - Add your own theme custom JS-->
      <script type="text/javascript" src="{{ url('js/custom-script.js')}}"></script>
     <!-- <script type="text/javascript" src="{{ url('js/scripts/dashboard-ecommerce.js')}}"></script>-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
   <script src="https://www.gstatic.com/firebasejs/3.3.0/firebase.js"></script> 
   <script src="{{ url('/assets/js/jquery.ajaxq.js') }}"></script>  
      <!--advanced-ui-modals.js - Some Specific JS codes -->
    <script type="text/javascript" src="{{ url('/js/scripts/advanced-ui-modals.js') }}"></script>
  <script src="{{ url('/assets/js/jquery.gritter.min.js') }}"></script>
    <script src="../../../app-assets/vendors/data-tables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../../../app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="../../../app-assets/vendors/data-tables/js/dataTables.select.min.js" type="text/javascript"></script>
    <script src="../../../app-assets/js/scripts/data-tables.js" type="text/javascript"></script>

  <!-- jQuery UI 1.11.4 -->
  <!--<script src="{{ url('/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>-->
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <!--<script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>-->
  <script type="text/javascript">
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

    var server = '{{ url('/') }}';
    $('#agent_id').select2();
    $('#link').select2();
    var push_ui_close ='{{ Session::get("push_ui_close") }}';

      function selectlang(id){
        var btn =$('#langbtn');
        var formdata = $('#langform').serializeArray();
        formdata.push({name: "id",value: id});
       var ref = firebase.database().ref("file");
       ref.orderByChild("code").equalTo(id).on("child_changed", function(snapshot) {
        
        snapshot.forEach(function(childsnapshot) {
        
        var content =JSON.stringify( childsnapshot.val().content);
      
        formdata.push({name: "content",value: content});
        $.ajax({
        type: "POST",
        url: server+"/translation/lang",
        data: formdata,
        dataType:"json",
        beforeSend: function() {

        //btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i>');   
        },
        
        cache: false,
        success: function(data) {
          //console.log(data.details);
          window.location.replace(data.details);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { // on error..

            //btn.prop("disabled", false).html('<i class="fa fa-pencil" aria-hidden="true"></i>');
            $.gritter.add({
            title: "<strong style='color:#fb5a43'>Oops!</strong>",
            text:  "Unable to change the language. Please try again",
            sticky: false,
            time: '',
            class_name: 'gritter-danger'
          }); 
              
            }
          });
        });

      });

      

    

  return false;
   } 

</script>

<script src="{{ url('/assets/js/admin.js') }}"></script>
<!--Begin NodComm Push Notification Code--><script type='text/javascript'>var NodPush = {x: 39380, y: 113};var NodPush_lc = document.createElement('script');NodPush_lc.type = 'text/javascript';NodPush_lc.async = true;NodPush_lc.src = '{{ url("push/init?x=") }}' + NodPush.x+'&y='+NodPush.y;document.body.appendChild(NodPush_lc);</script><script type="text/javascript" src="{{ url('assets/js/userip1.js') }}"></script><script src="{{ url('/assets/js/ua-parser.min.js') }}"></script><!--End NodComm Push Notification  Code-->
  @yield('scripts')
  </body>
</html>