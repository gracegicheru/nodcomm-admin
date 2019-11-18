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
    <title>Page Blank | Materialize - Material Design Admin Template</title>
    <!-- Favicons-->
    <link rel="icon" href="../../images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="../../images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->
    <!-- CORE CSS-->
    <link href="../../css/themes/fixed-menu/materialize.css" type="text/css" rel="stylesheet">
    <link href="../../css/themes/fixed-menu/style.css" type="text/css" rel="stylesheet">
    <!-- Custome CSS-->
    <link href="../../css/custom/custom.css" type="text/css" rel="stylesheet">
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="../../vendors/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet">
    <link href="../../vendors/flag-icon/css/flag-icon.min.css" type="text/css" rel="stylesheet">
    <link href="../../vendors/sweetalert/dist/sweetalert.css" type="text/css" rel="stylesheet">

    <style>
      .notifs .alert {
  font-weight: 700;
  letter-spacing: 5px;
}

.notifs p {
  margin-top: -5px;
  font-size: 0.5em;
  font-weight: 100;
  color: #5e5e5e;
  letter-spacing: 1px;
}

.notifs button {
  cursor: pointer;
}

#success-box {
  position: relative;
  height: 100%;
  border-radius: 20px;
  perspective: 40px;
}

#error-box {
  position: relative;
  height: 100%;
  border-radius: 20px;
  perspective: 40px;
}

.notifs h1, .notifs h1 {
  font-size: 0.9em;
  font-weight: 100;
  letter-spacing: 3px;
  padding-top: 5px;
  color: #FCFCFC;
  padding-bottom: 5px;
  text-transform: uppercase;
}

.dot {
  width: 8px;
  height: 8px;
  background: #FCFCFC;
  border-radius: 50%;
  position: absolute;
  top: 4%;
  right: 6%;
}
.dot:hover {
  background: #c9c9c9;
}

.two {
  right: 12%;
  opacity: .5;
}

.face {
    position: absolute;
    width: 25%;
    height: 61%;
    border-radius: 50%;
    top: 21%;
    left: 37.5%;
    z-index: 2;
    animation: bounce 1s ease-in infinite;
    background: linear-gradient(to bottom right, #B0DB7D 40%, #99DBB4 100%);
}

.face2 {
  position: absolute;
  width: 25%;
  height: 61%;
  border-radius: 50%;
  top: 21%;
  left: 37.5%;
  z-index: 2;
  animation: roll 3s ease-in-out infinite;
  background: linear-gradient(to bottom left, #EF8D9C 40%, #FFC39E 100%);
}

.eye {
      position: absolute;
    width: 10px;
    height: 10px;
    background: #777777;
    border-radius: 50%;
    top: 36%;
    left: 20%;
}

.right {
  left: 71%;
}

.mouth {
      position: absolute;
    top: 61%;
    left: 44%;
    width: 16px;
    height: 16px;
    border-radius: 50%;
}

.happy {
  border: 2px solid;
  border-color: transparent #777777 #777777 transparent;
  transform: rotate(45deg);
}

.sad {
  top: 49%;
  border: 2px solid;
  border-color: #777777 transparent transparent #777777;
  transform: rotate(45deg);
}

.shadow {
  position: absolute;
  width: 17%;
  height: 3%;
  opacity: .5;
  background: #777777;
  left: 41.9%;
  top: 85%;
  border-radius: 50%;
  z-index: 1;
}

.scale {
  animation: scale 1s ease-in infinite;
}

.move {
  animation: move 3s ease-in-out infinite;
}

.notifs .message {
  position: relative;
  width: 100%;
  text-align: center;
  font-size: 20px;
}

.button-box {
  position: absolute;
  background: #FCFCFC;
  width: 50%;
  height: 15%;
  border-radius: 20px;
  top: 73%;
  left: 25%;
  outline: 0;
  border: none;
  box-shadow: 2px 2px 10px rgba(119, 119, 119, 0.5);
  transition: all .5s ease-in-out;
}
.button-box:hover {
  background: #efefef;
  transform: scale(1.05);
  transition: all .3s ease-in-out;
}
#canvas-notif{
    position: absolute;
  left: -5%;
  top: -109px;
  width: 110%;
}

@keyframes bounce {
  50% {
    transform: translateY(-10px);
  }
}
@keyframes scale {
  50% {
    transform: scale(0.9);
  }
}
@keyframes roll {
  0% {
    transform: rotate(0deg);
    left: 25%;
  }
  50% {
    left: 60%;
    transform: rotate(168deg);
  }
  100% {
    transform: rotate(0deg);
    left: 25%;
  }
}
@keyframes move {
  0% {
    left: 25%;
  }
  50% {
    left: 60%;
  }
  100% {
    left: 25%;
  }
}
#success-box footer, #error-box footer {
  position: absolute;
  bottom: 0;
  right: 0;
  text-align: center;
  font-size: 1em;
  text-transform: uppercase;
  padding: 10px;
  font-family: "Lato", sans-serif;
}
#success-box footer p, #error-box footer p{
  color: #EF8D9C;
  letter-spacing: 2px;
}
#success-box footer a, #error-box footer a{
  color: #B0DB7D;
  text-decoration: none;
}
#success-box footer a:hover, #error-box footer a:hover{
  color: #FFC39E;
}
#container {
  position: relative;
  margin: auto;
  overflow: hidden;
  width: 100%;
  height: 180px;
}
    </style>
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
                  <a href="index.html" class="brand-logo darken-1">
                    <img src="../../images/logo/materialize-logo.png" alt="materialize logo">
                    <span class="logo-text hide-on-med-and-down">Materialize</span>
                  </a>
                </h1>
              </li>
            </ul>
            <div class="header-search-wrapper hide-on-med-and-down">
              <i class="material-icons">search</i>
              <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize" />
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
                    <img src="../../images/avatar/avatar-7.png" alt="avatar">
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
                <a href="#" class="grey-text text-darken-1">
                  <i class="material-icons">face</i> Profile</a>
              </li>
              <li>
                <a href="#" class="grey-text text-darken-1">
                  <i class="material-icons">settings</i> Settings</a>
              </li>
              <li>
                <a href="#" class="grey-text text-darken-1">
                  <i class="material-icons">live_help</i> Help</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="#" class="grey-text text-darken-1">
                  <i class="material-icons">lock_outline</i> Lock</a>
              </li>
              <li>
                <a href="#" class="grey-text text-darken-1">
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
                  <img src="../../images/avatar/avatar-7.png" alt="" class="circle responsive-img valign profile-image cyan">
                </div>
                <div class="col col s8 m8 l8">
                  <ul id="profile-dropdown-nav" class="dropdown-content">
                    <li>
                      <a href="#" class="grey-text text-darken-1">
                        <i class="material-icons">face</i> Profile</a>
                    </li>
                    <li>
                      <a href="#" class="grey-text text-darken-1">
                        <i class="material-icons">settings</i> Settings</a>
                    </li>
                    <li>
                      <a href="#" class="grey-text text-darken-1">
                        <i class="material-icons">live_help</i> Help</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <a href="#" class="grey-text text-darken-1">
                        <i class="material-icons">lock_outline</i> Lock</a>
                    </li>
                    <li>
                      <a href="#" class="grey-text text-darken-1">
                        <i class="material-icons">keyboard_tab</i> Logout</a>
                    </li>
                  </ul>
                  <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown-nav">John Doe<i class="mdi-navigation-arrow-drop-down right"></i></a>
                  <p class="user-roal">Administrator</p>
                </div>
              </div>
            </li>
            <li class="no-padding">
              <ul class="collapsible" data-collapsible="accordion">
                <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dashboard</i>
                    <span class="nav-text">Dashboard</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="dashboard-ecommerce.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>eCommerce</span>
                        </a>
                      </li>
                      <li>
                        <a href="index.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Analytics</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">dvr</i>
                    <span class="nav-text">Templates</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="../collapsible-menu/">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> Collapsible Menu</span>
                        </a>
                      </li>
                      <li>
                        <a href="../semi-dark-menu/">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> Semi Dark Menu</span>
                        </a>
                      </li>
                      <li>
                        <a href="../fixed-menu/">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> Fixed Menu</span>
                        </a>
                      </li>
                      <li>
                        <a href="../overlay-menu/">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> Overlay Menu</span>
                        </a>
                      </li>
                      <li>
                        <a href="../horizontal-menu/">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Horizontal Menu</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">web</i>
                    <span class="nav-text">Layouts</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="layout-light.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Light Layout</span>
                        </a>
                      </li>
                      <li>
                        <a href="layout-dark.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Dark Layout</span>
                        </a>
                      </li>
                      <li>
                        <a href="layout-semi-dark.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Semi Dark Layout</span>
                        </a>
                      </li>
                      <li>
                        <a href="layout-fixed-footer.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Fixed Footer</span>
                        </a>
                      </li>
                      <li>
                        <a href="layout-menu-native-scroll.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Menu Native Scroll</span>
                        </a>
                      </li>
                      <li>
                        <a href="layout-menu-collapsed.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Menu Collapsed</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">cast</i>
                    <span class="nav-text">Cards</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="cards-basic.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span> Basic</span>
                        </a>
                      </li>
                      <li>
                        <a href="cards-advance.html" class="waves-effect waves-cyan">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span class="nav-text">Advance</span>
                        </a>
                      </li>
                      <li>
                        <a href="cards-extended.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Extended</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a href="app-email.html" class="waves-effect waves-cyan">
                    <i class="material-icons">mail_outline</i>
                    <span class="nav-text">Mailbox</span>
                  </a>
                </li>
                <li class="bold">
                  <a href="app-calendar.html" class="waves-effect waves-cyan">
                    <i class="material-icons">today</i>
                    <span class="nav-text">Calender</span>
                  </a>
                </li>
                <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">invert_colors</i>
                    <span class="nav-text">CSS</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="css-typography.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Typography</span>
                        </a>
                      </li>
                      <li>
                        <a href="css-color.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span class="nav-text">Color</span>
                        </a>
                      </li>
                      <li>
                        <a href="css-grid.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span class="nav-text">Grid</span>
                        </a>
                      </li>
                      <li>
                        <a href="css-helpers.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span class="nav-text">Helpers</span>
                        </a>
                      </li>
                      <li>
                        <a href="css-media.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Media</span>
                        </a>
                      </li>
                      <li>
                        <a href="css-pulse.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Pulse</span>
                        </a>
                      </li>
                      <li>
                        <a href="css-sass.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Sass</span>
                        </a>
                      </li>
                      <li>
                        <a href="css-shadow.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Shadow</span>
                        </a>
                      </li>
                      <li>
                        <a href="css-animations.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Animations</span>
                        </a>
                      </li>
                      <li>
                        <a href="css-transitions.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Transition</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header  waves-effect waves-cyan">
                    <i class="material-icons">photo_filter</i>
                    <span class="nav-text">Basic UI</span>
                  </a>
                  <div class="collapsible-body">
                    <ul class="collapsible" data-collapsible="accordion">
                      <li class="bold">
                        <a class="collapsible-header  waves-effect waves-cyan">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span class="nav-text">Buttons</span>
                        </a>
                        <div class="collapsible-body">
                          <ul class="collapsible" data-collapsible="accordion">
                            <li>
                              <a href="ui-basic-buttons.html">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Basic</span>
                              </a>
                            </li>
                            <li>
                              <a href="ui-extended-buttons.html">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Extended</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <li>
                        <a href="ui-icons.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Icons</span>
                        </a>
                      </li>
                      <li>
                        <a href="ui-alerts.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Alerts</span>
                        </a>
                      </li>
                      <li>
                        <a href="ui-badges.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Badges</span>
                        </a>
                      </li>
                      <li>
                        <a href="ui-breadcrumbs.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Breadcrumbs</span>
                        </a>
                      </li>
                      <li>
                        <a href="ui-chips.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Chips</span>
                        </a>
                      </li>
                      <li>
                        <a href="ui-collections.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Collections</span>
                        </a>
                      </li>
                      <li>
                        <a href="ui-navbar.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Navbar</span>
                        </a>
                      </li>
                      <li>
                        <a href="ui-pagination.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Pagination</span>
                        </a>
                      </li>
                      <li>
                        <a href="ui-preloader.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Preloader</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">library_add</i>
                    <span class="nav-text">Advanced UI</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="advance-ui-carousel.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Carousel</span>
                        </a>
                      </li>
                      <li>
                        <a href="advance-ui-collapsibles.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Collapsible</span>
                        </a>
                      </li>
                      <li>
                        <a href="advance-ui-toasts.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Toasts</span>
                        </a>
                      </li>
                      <li>
                        <a href="advance-ui-tooltip.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Tooltip</span>
                        </a>
                      </li>
                      <li>
                        <a href="advance-ui-dropdown.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Dropdown</span>
                        </a>
                      </li>
                      <li>
                        <a href="advance-ui-feature-discovery.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Feature Discovery</span>
                        </a>
                      </li>
                      <li>
                        <a href="advanced-ui-media.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Media</span>
                        </a>
                      </li>
                      <li>
                        <a href="advanced-ui-modals.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Modals</span>
                        </a>
                      </li>
                      <li>
                        <a href="advance-ui-scrollfire.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>ScrollFire</span>
                        </a>
                      </li>
                      <li>
                        <a href="advance-ui-scrollspy.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Scrollspy</span>
                        </a>
                      </li>
                      <li>
                        <a href="advance-ui-tabs.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Tabs</span>
                        </a>
                      </li>
                      <li>
                        <a href="advance-ui-transitions.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Transitions</span>
                        </a>
                      </li>
                      <li>
                        <a href="advance-ui-waves.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Waves</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">add_to_queue</i>
                    <span class="nav-text">Extra Components</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="extra-components-range-slider.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Range Slider</span>
                        </a>
                      </li>
                      <li>
                        <a href="extra-components-sweetalert.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>SweetAlert</span>
                        </a>
                      </li>
                      <li>
                        <a href="extra-components-nestable.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Shortable & Nestable</span>
                        </a>
                      </li>
                      <li>
                        <a href="extra-components-translation.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Language Translation</span>
                        </a>
                      </li>
                      <li>
                        <a href="extra-components-highlight.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Highlight</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header  waves-effect waves-cyan">
                    <i class="material-icons">border_all</i>
                    <span class="nav-text">Tables</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="table-basic.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Basic Tables</span>
                        </a>
                      </li>
                      <li>
                        <a href="table-data.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Data Tables</span>
                        </a>
                      </li>
                      <li>
                        <a href="table-jsgrid.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>jsGrid</span>
                        </a>
                      </li>
                      <li>
                        <a href="table-editable.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Editable Table</span>
                        </a>
                      </li>
                      <li>
                        <a href="table-floatThead.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>FloatThead</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header  waves-effect waves-cyan">
                    <i class="material-icons">chrome_reader_mode</i>
                    <span class="nav-text">Forms</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="form-elements.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Form Elements</span>
                        </a>
                      </li>
                      <li>
                        <a href="form-layouts.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Form Layouts</span>
                        </a>
                      </li>
                      <li>
                        <a href="form-validation.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Form Validations</span>
                        </a>
                      </li>
                      <li>
                        <a href="form-masks.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Form Masks</span>
                        </a>
                      </li>
                      <li>
                        <a href="form-file-uploads.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>File Uploads</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header  waves-effect waves-cyan active">
                    <i class="material-icons">pages</i>
                    <span class="nav-text">Pages</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="page-contact.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Contact Page</span>
                        </a>
                      </li>
                      <li>
                        <a href="page-todo.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>ToDos</span>
                        </a>
                      </li>
                      <li>
                        <a href="page-blog-1.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Blog Type 1</span>
                        </a>
                      </li>
                      <li>
                        <a href="page-blog-2.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Blog Type 2</span>
                        </a>
                      </li>
                      <li>
                        <a href="page-404.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>404</span>
                        </a>
                      </li>
                      <li>
                        <a href="page-500.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>500</span>
                        </a>
                      </li>
                      <li class="active">
                        <a href="page-blank.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Blank</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header  waves-effect waves-cyan">
                    <i class="material-icons">add_shopping_cart</i>
                    <span class="nav-text">eCommers</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="eCommerce-products-page.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Products Page</span>
                        </a>
                      </li>
                      <li>
                        <a href="eCommerce-pricing.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Pricing Table</span>
                        </a>
                      </li>
                      <li>
                        <a href="eCommerce-invoice.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Invoice</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header  waves-effect waves-cyan">
                    <i class="material-icons">perm_media</i>
                    <span class="nav-text">Medias</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="media-gallary-page.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Gallery Page</span>
                        </a>
                      </li>
                      <li>
                        <a href="media-hover-effects.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Image Hover Effects</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header  waves-effect waves-cyan">
                    <i class="material-icons">account_circle</i>
                    <span class="nav-text">User</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="user-profile-page.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>User Profile</span>
                        </a>
                      </li>
                      <li>
                        <a href="user-login.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Login</span>
                        </a>
                      </li>
                      <li>
                        <a href="user-register.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Register</span>
                        </a>
                      </li>
                      <li>
                        <a href="user-forgot-password.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Forgot Password</span>
                        </a>
                      </li>
                      <li>
                        <a href="user-lock-screen.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Lock Screen</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="bold">
                  <a class="collapsible-header waves-effect waves-cyan">
                    <i class="material-icons">pie_chart_outlined</i>
                    <span class="nav-text">Charts</span>
                  </a>
                  <div class="collapsible-body">
                    <ul>
                      <li>
                        <a href="charts-chartjs.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Chart JS</span>
                        </a>
                      </li>
                      <li>
                        <a href="charts-chartist.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Chartist</span>
                        </a>
                      </li>
                      <li>
                        <a href="charts-morris.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Morris Charts</span>
                        </a>
                      </li>
                      <li>
                        <a href="charts-xcharts.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>xCharts</span>
                        </a>
                      </li>
                      <li>
                        <a href="charts-flotcharts.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Flot Charts</span>
                        </a>
                      </li>
                      <li>
                        <a href="charts-sparklines.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Sparkline Charts</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </li>
            <li class="li-hover">
              <p class="ultra-small margin more-text">MORE</p>
            </li>
            <li>
              <a href="angular-ui.html">
                <i class="material-icons">verified_user</i>
                <span class="nav-text">Angular UI</span>
              </a>
            </li>
            <li class="no-padding">
              <ul class="collapsible" data-collapsible="accordion">
                <li class="bold">
                  <a class="collapsible-header  waves-effect waves-cyan">
                    <i class="material-icons">photo_filter</i>
                    <span class="nav-text">Menu Levels</span>
                  </a>
                  <div class="collapsible-body">
                    <ul class="collapsible" data-collapsible="accordion">
                      <li>
                        <a href="ui-basic-buttons.html">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span>Second level</span>
                        </a>
                      </li>
                      <li class="bold">
                        <a class="collapsible-header  waves-effect waves-cyan">
                          <i class="material-icons">keyboard_arrow_right</i>
                          <span class="nav-text">Second level child</span>
                        </a>
                        <div class="collapsible-body">
                          <ul class="collapsible" data-collapsible="accordion">
                            <li>
                              <a href="ui-basic-buttons.html">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span>Third level</span>
                              </a>
                            </li>
                            <li class="bold">
                              <a class="collapsible-header  waves-effect waves-cyan">
                                <i class="material-icons">keyboard_arrow_right</i>
                                <span class="nav-text">Third level child</span>
                              </a>
                              <div class="collapsible-body">
                                <ul class="collapsible" data-collapsible="accordion">
                                  <li>
                                    <a href="ui-basic-buttons.html">
                                      <i class="material-icons">keyboard_arrow_right</i>
                                      <span>Forth level</span>
                                    </a>
                                  </li>
                                  <li>
                                    <a href="ui-extended-buttons.html">
                                      <i class="material-icons">keyboard_arrow_right</i>
                                      <span>Forth level</span>
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </li>
            <li>
              <a href="changelogs.html">
                <i class="material-icons">track_changes</i>
                <span class="nav-text">Changelogs</span>
              </a>
            </li>
            <li>
              <a href="../documentation" target="_blank">
                <i class="material-icons">import_contacts</i>
                <span class="nav-text">Documentation</span>
              </a>
            </li>
            <li>
              <a href="https://pixinvent.ticksy.com" target="_blank">
                <i class="material-icons">help_outline</i>
                <span class="nav-text">Support</span>
              </a>
            </li>
          </ul>
          <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only">
            <i class="material-icons">menu</i>
          </a>
        </aside>
        <!-- END LEFT SIDEBAR NAV-->
        <!-- //////////////////////////////////////////////////////////////////////////// -->
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
                  <h5 class="breadcrumbs-title">Notifications</h5>
                  <ol class="breadcrumbs">
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="#">Notifications</a></li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div class="section">
              <p class="caption">An example of notifications to be used on the send SMS page to replace gritter notifications.</p>
              <div class="divider"></div>
            </div>
            <div class="row">
              <div class="col m6">
                <a class="btn green" id="success-notif">Success Notification</a>
                <a class="btn red" id="error-notif">Error Notification</a>
              </div>
            </div>
          </div>
          <!--end container-->
        </section>
        <!-- END CONTENT -->
        <!-- //////////////////////////////////////////////////////////////////////////// -->
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
            </script> <a class="grey-text text-lighten-2" href="http://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" target="_blank">PIXINVENT</a> All rights reserved.</span>
          <span class="right hide-on-small-only"> Design and Developed by <a class="grey-text text-lighten-2" href="https://pixinvent.com/">PIXINVENT</a></span>
        </div>
      </div>
    </footer>
    <!-- END FOOTER -->
    <!-- ================================================
        Scripts
  ================================================ -->
    <!-- jQuery Library -->
    <script type="text/javascript" src="../../vendors/jquery-3.2.1.min.js"></script>
    <!--materialize js-->
    <script type="text/javascript" src="../../js/materialize.min.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="../../vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="../../js/plugins.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="../../js/custom-script.js"></script>
    <script type="text/javascript" src="../../vendors/sweetalert/dist/sweetalert.min.js"></script>

    <script>
      var success_html = '<div class="notifs">'+
                    '<canvas id="canvas-notif"></canvas>'+
                    '<div id="container">'+
                      '<div id="success-box">'+
                          '<div class="face">'+
                            '<div class="eye"></div>'+
                            '<div class="eye right"></div>'+
                            '<div class="mouth happy"></div>'+
                          '</div>'+
                          '<div class="shadow scale"></div>'+
                        '</div>'+
                      '</div>'+
                    '<div class="message">Your message is on it\'s way</div>'+
                  '</div>';

      var error_html = '<div class="notifs">'+
                    '<div id="container">'+
                      '<div id="error-box">'+
                          '<div class="face2">'+
                            '<div class="eye"></div>'+
                            '<div class="eye right"></div>'+
                            '<div class="mouth sad"></div>'+
                          '</div>'+
                          '<div class="shadow move"></div>'+
                        '</div>'+
                      '</div>'+
                    '<div class="message">Oh no, something went wrong</div>'+
                  '</div>';

      $('#success-notif').click(function() {
        swal({
          title: "<span class='green-text'>Yay!</span>",
          text: success_html,
          html: true
        });


      // const canvas = document.getElementById("canvas-notif");
      const canvas = $("#canvas-notif");
      const context = canvas[0].getContext("2d");
      const maxConfettis = 150;
      const particles = [];

      let p = $(canvas.parent().parent().parent());
      let W = p.width();
      let H = p.height();

      const possibleColors = [
        "DodgerBlue",
        "OliveDrab",
        "Gold",
        "Pink",
        "SlateBlue",
        "LightBlue",
        "Gold",
        "Violet",
        "PaleGreen",
        "SteelBlue",
        "SandyBrown",
        "Chocolate",
        "Crimson"
      ];

      function randomFromTo(from, to) {
        return Math.floor(Math.random() * (to - from + 1) + from);
      }

      function confettiParticle() {
        this.x = Math.random() * W; // x
        this.y = Math.random() * H - H; // y
        this.r = randomFromTo(11, 13); // radius
        this.d = Math.random() * maxConfettis + 11;
        this.color =
          possibleColors[Math.floor(Math.random() * possibleColors.length)];
        this.tilt = Math.floor(Math.random() * 33) - 11;
        this.tiltAngleIncremental = Math.random() * 0.07 + 0.05;
        this.tiltAngle = 0;

        this.draw = function() {
          context.beginPath();
          context.lineWidth = this.r / 2;
          context.strokeStyle = this.color;
          context.moveTo(this.x + this.tilt + this.r / 3, this.y);
          context.lineTo(this.x + this.tilt, this.y + this.tilt + this.r / 5);
          return context.stroke();
        };
      }

      function Draw() {
        const results = [];

        // Magical recursive functional love
        requestAnimationFrame(Draw);

        context.clearRect(0, 0, W, window.innerHeight);

        for (var i = 0; i < maxConfettis; i++) {
          results.push(particles[i].draw());
        }

        let particle = {};
        let remainingFlakes = 0;
        for (var i = 0; i < maxConfettis; i++) {
          particle = particles[i];

          particle.tiltAngle += particle.tiltAngleIncremental;
          particle.y += (Math.cos(particle.d) + 3 + particle.r / 2) / 2;
          particle.tilt = Math.sin(particle.tiltAngle - i / 3) * 15;

          if (particle.y <= H) remainingFlakes++;

          // If a confetti has fluttered out of view,
          // bring it back to above the viewport and let if re-fall.
          if (particle.x > W + 30 || particle.x < -30 || particle.y > H) {
            particle.x = Math.random() * W;
            particle.y = -30;
            particle.tilt = Math.floor(Math.random() * 10) - 20;
          }
        }

        return results;
      }

      // window.addEventListener(
      //   "resize",
      //   function() {
      //     W = p.width();
      //     H = p.height();

      //     canvas.width = p.width();
      //     canvas.height = p.height();
      //   },
      //   false
      // );

      // Push new confetti objects to `particles[]`
      for (var i = 0; i < maxConfettis; i++) {
        particles.push(new confettiParticle());
      }

      // Initialize
      canvas[0].width = W;
      canvas[0].height = H;
      Draw();
      });

      $('#error-notif').click(function() {
        swal({
          title: "<span class='red-text'>Uh oh...</span>",
          text: error_html,
          html: true
        });
      });
    </script>
  </body>
</html>