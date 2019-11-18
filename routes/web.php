<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('/curl', ['uses'=>'Proxy@curl'])->name('curl');

Route::get('/', 'HomeController@dashboard');
//Route::get('/dashboard', ['uses'=>'HomeController@dashboard', 'as'=>'dashboard']);
Route::get('/admin_data', ['uses'=>'HomeController@admin_data']);
Route::get('/super_admin_data', ['uses'=>'HomeController@super_admin_data']);
Route::get('/dashboard/online', ['uses'=>'HomeController@online']);
//Route::get('/main-dashboard', ['uses'=>'HomeController@index', 'as'=>'main-dashboard']);
Route::get('/dashboard', ['uses'=>'HomeController@index', 'as'=>'main-dashboard']);
Route::get('/dashboard/analytics', ['uses'=>'AnalyticsController@analytics', 'as'=>'analytic-dashboard']);
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login/custom',
[ 
	'uses'=>'LoginController@login',
	'as'=>'login.custom'
]
);
Route::get('/login/verification', ['uses'=>'LoginController@verification', 'as'=>'verification']);
Route::post('/login/verification-code', ['uses'=>'LoginController@verify_code', 'as'=>'verification-code']);
Route::get('/login/resend-code', ['uses'=>'LoginController@resend_code', 'as'=>'resend_verification_code']);
//login routes

//logout route
Route::get('/logout', 'LoginController@logout');
//logout route



//forgot password routes
Route::get('/forgotpassword', 'ForgotpasswordController@forgotpassword');
Route::post('/resetemail', ['uses'=>'ForgotpasswordController@resetemail', 'as'=>'resetemail']);
Route::get('/resetpassword/{token}', ['uses'=>'ForgotpasswordController@resetpassword', 'as'=>'resetpassword']);
Route::post('/updatepassword', ['uses'=>'ForgotpasswordController@updatepassword', 'as'=>'updatepassword']);
//forgot password routes


Route::get('/sites', ['uses'=>'SitesController@index', 'as'=>'sites']);
Route::get('/sites/{id}', ['uses'=>'SitesController@view_site']);
Route::post('/sites/new', ['uses'=>'SitesController@addsite', 'as'=>'addsite']);
Route::post('/sites/edit', ['uses'=>'SitesController@edit_site', 'as'=>'editsite']);
Route::get('/company/websites/{id}', ['uses'=>'SitesController@companysites'])->middleware('super-admin');

//Client chat routes
Route::get('/chat', ['uses'=>'ChatController@index'])->name('chat');
Route::get('/chat/init', ['uses'=>'ChatController@chat_init'])->name('chat');
Route::post('/chat/user-info', ['uses'=>'ChatController@visitor_init'])->name('userinfo');
Route::post('/chat/start', ['uses'=>'ChatController@start_chat'])->name('startchat');
Route::post('/chat/user/lastactivity', ['uses'=>'ChatController@last_activity'])->name('userlastactivity');
Route::post('/chat/status', ['uses'=>'ChatController@agent_status'])->name('agentstatus');
Route::post('/chat/user/message', ['uses'=>'ChatController@message_status'])->name('messagestatus');
Route::post('/chat/send', ['uses'=>'ChatController@send_message'])->name('sendmessage');
Route::post('/chat/messages/load', ['uses'=>'ChatController@load_messages'])->name('loadmessages');

//Client chat routes

//Admin chat routes
Route::get('/chats', ['uses'=>'AdminChatController@index'])->name('chats');
Route::get('/visitors/online', ['uses'=>'AdminChatController@online_visitors'])->name('onlinevisitors');
Route::get('/chats/active', ['uses'=>'AdminChatController@active_chats'])->name('activechats');
Route::post('/chats/accept', ['uses'=>'AdminChatController@accept_chat'])->name('acceptchat');
Route::get('/chats/status', ['uses'=>'AdminChatController@check_messages'])->name('checkmessages');
Route::post('/chats/reply', ['uses'=>'AdminChatController@send_message']);
Route::post('/chats/chat', ['uses'=>'AdminChatController@get_chat_messages']);
Route::post('/visitor/navigation', ['uses'=>'AdminChatController@user_navigation']);
Route::post('/visitor/chat-history', ['uses'=>'AdminChatController@chat_history']);
Route::post('/visitor/archived-messages', ['uses'=>'AdminChatController@archived_chat_messages']);
Route::get('/visitors/queue', ['uses'=>'AdminChatController@view_onqueue_visitors']);
Route::post('/visitor/asign-agent', ['uses'=>'AdminChatController@assignagent', 'as'=>'assignagent']);
Route::get('/company/visitors/{id}', ['uses'=>'AdminChatController@companyvisitors'])->middleware('super-admin');
Route::get('/visitors/all', ['uses'=>'AdminChatController@all_visitors'])->middleware('super-admin');

//Admin chat routes

//Docs routes
Route::get('/docs/sms', ['uses'=>'SMSDocs@introduction'])->name('sms_docs_main_intro');
Route::get('/docs/sms/introduction', ['uses'=>'SMSDocs@introduction'])->name('sms_docs_intro');
Route::get('/docs/sms/send-sms', ['uses'=>'SMSDocs@send_sms'])->name('sms_docs_send');

//Docs routes

//Message history routes
Route::get('/sms', ['uses'=>'MessageController@index'])->name('messages_history');
Route::get('/sms/load-more', ['uses'=>'MessageController@load_more']);
Route::get('/messages/filters/get', ['uses'=>'MessageController@get_filters'])->name('get_filters');
Route::post('/messages/filters/apply', ['uses'=>'MessageController@apply_filters'])->name('apply_filters');
Route::post('/company/messages/filters/apply', ['uses'=>'MessageController@apply_company_filters'])->name('apply_company_filters');
Route::get('/company/messages/{id}', ['uses'=>'MessageController@companymessages'])->middleware('super-admin');
Route::post('/messages/search', ['uses'=>'MessageController@search_sms'])->name('search_sms');
Route::get('/sms/load_search_more', ['uses'=>'MessageController@load_search_more']);
Route::get('/sms/load_more_apply_filters', ['uses'=>'MessageController@load_more_apply_filters']);
Route::get('/sms/load_more_apply_company_filters', ['uses'=>'MessageController@load_more_apply_company_filters']);
//Message history routes

// Registering users routes

Route::get('/users', ['uses'=>'RegisterController@index', 'as'=>'users']);
Route::post('/agents/new', ['uses'=>'RegisterController@addagent', 'as'=>'addagent']);
Route::post('/agents/edit', ['uses'=>'RegisterController@editagent', 'as'=>'editagent']);
Route::post('/agents/disable', ['uses'=>'RegisterController@disableagent', 'as'=>'disableagent']);
Route::post('/agents/enable', ['uses'=>'RegisterController@enableagent', 'as'=>'enableagent']);

Route::post('/user/new', ['uses'=>'RegisterController@superadduser', 'as'=>'superadduser']);
Route::post('/user/edit', ['uses'=>'RegisterController@superedituser', 'as'=>'superedituser']);
Route::post('/user/disable', ['uses'=>'RegisterController@superdisableuser', 'as'=>'superdisableuser']);
Route::post('/user/enable', ['uses'=>'RegisterController@superenableuser', 'as'=>'superenableuser']);
Route::get('/company/users/{id}', ['uses'=>'RegisterController@companyusers'])->middleware('super-admin');
Route::get('/changepassword', 'RegisterController@changepassword');
Route::post('/user/updatepassword', ['uses'=>'RegisterController@updatepassword', 'as'=>'changepassword']);
Route::post('/user/confirmcode', ['uses'=>'RegisterController@confirmcode', 'as'=>'confirmcode']);

Route::get('/super-admins', ['uses'=>'RegisterController@superadmins', 'as'=>'super-admins']);
Route::post('/super-admins/new', ['uses'=>'RegisterController@addsuperadmin', 'as'=>'add-super-admins']);
Route::post('/super-admins/edit', ['uses'=>'RegisterController@editsuperadmin', 'as'=>'edit-super-admins']);
Route::post('/super-admins/disable', ['uses'=>'RegisterController@disablesuperadmin', 'as'=>'disablesuperadmin']);
Route::post('/super-admins/enable', ['uses'=>'RegisterController@enablesuperadmin', 'as'=>'enablesuperadmin']);
// Registering users routes

//profile route
Route::get('/profile', ['uses'=>'RegisterController@profile', 'as'=>'profile']);
Route::post('/profile/edit', ['uses'=>'RegisterController@editprofile', 'as'=>'editprofile']);
Route::get('/company/profile', ['uses'=>'RegisterController@company_profile', 'as'=>'company_profile']);
Route::post('/company/profile/edit', ['uses'=>'RegisterController@update_company_profile', 'as'=>'update_company_profile']);
//profile route
// Registering websites routes
Route::get('/admin/companies', ['uses'=>'WebsitesController@index', 'as'=>'companies']);
Route::post('/admin/company/new', ['uses'=>'WebsitesController@addcompany', 'as'=>'registercompany']);
Route::post('/admin/company/edit', ['uses'=>'WebsitesController@editcompany', 'as'=>'editcompany']);
Route::post('/admin/company/disable', ['uses'=>'WebsitesController@disablecompany', 'as'=>'disablecompany']);
Route::post('/admin/company/enable', ['uses'=>'WebsitesController@enablecompany', 'as'=>'enablecompany']);
Route::get('/website/{id}', ['uses'=>'SitesController@view_site_visitors']);
// Registering websites routes

// Setting routes
Route::get('/setting/prechat', ['uses'=>'PrechatController@index', 'as'=>'prechatsetting']);
Route::post('/setting/prechat/new', ['uses'=>'PrechatController@addprechatsetting', 'as'=>'addprechatsetting']);
Route::post('/setting/prechat/edit', ['uses'=>'PrechatController@updateprechatsetting', 'as'=>'updateprechatsetting']);
Route::post('/setting/prechatfield/new', ['uses'=>'PrechatController@addprechatfield', 'as'=>'addprechatfield']);
Route::post('/setting/prechatfield/edit', ['uses'=>'PrechatController@editprechatfield', 'as'=>'editprechatfield']);


Route::get('/setting/postchat', ['uses'=>'PostchatController@index', 'as'=>'postchatsetting']);
Route::post('/setting/postchat/new', ['uses'=>'PostchatController@addpostchatsetting', 'as'=>'addpostchatsetting']);
Route::post('/setting/postchat/edit', ['uses'=>'PostchatController@updatepostchatsetting', 'as'=>'updatepostchatsetting']);
Route::post('/setting/postchatfield/new', ['uses'=>'PostchatController@addpostchatfield', 'as'=>'addpostchatfield']);
Route::post('/setting/postchatfield/edit', ['uses'=>'PostchatController@editpostchatfield', 'as'=>'editpostchatfield']);
Route::get('/setting/department', ['uses'=>'DepartmentController@index', 'as'=>'departmenttsetting']);
Route::post('/setting/department/new', ['uses'=>'DepartmentController@adddepartment', 'as'=>'adddepartment']);
Route::post('/setting/department/edit', ['uses'=>'DepartmentController@updatedepartment', 'as'=>'updatedepartment']);
Route::get('/department/{id}', ['uses'=>'DepartmentController@view_department']);
Route::get('/agent/{id}', ['uses'=>'DepartmentController@view_agent']);
// Setting routes

// online agents
Route::get('/savelastactivity', ['uses'=>'AgentController@savelastactivity', 'as'=>'savelastactivity']);
Route::get('/agents/online', ['uses'=>'AgentController@onlineagents', 'as'=>'onlineagents']);
Route::get('/agents/all/online', ['uses'=>'AgentController@getonlineagents', 'as'=>'allonlineagents']);
Route::get('/agents/visitors', ['uses'=>'AgentController@view_agents_visitors', 'as'=>'agentsvisitors']);
Route::get('/agent/visitors/{id}', ['uses'=>'AgentController@view_agent']);
// online agents

// Company Reggistration  routes

Route::get('/register/step1', ['uses'=>'CompanyController@index', 'as'=>'step_1']);
Route::get('/register/step2', ['uses'=>'CompanyController@step2', 'as'=>'step_2']);
Route::get('/register/step3', ['uses'=>'CompanyController@step3', 'as'=>'step_3']);
Route::get('/register/step4', ['uses'=>'CompanyController@step4', 'as'=>'step_4']);
Route::post('/register/stepone', ['uses'=>'CompanyController@registercompany', 'as'=>'step1']);
Route::post('/register/steptwo', ['uses'=>'CompanyController@verify_code', 'as'=>'step2']);
Route::post('/register/stepthree', ['uses'=>'CompanyController@addcompany', 'as'=>'step3']);
Route::post('/register/stepfour', ['uses'=>'CompanyController@verify_email_code', 'as'=>'step4']);
Route::post('/register/resend-code', ['uses'=>'CompanyController@resend_code', 'as'=>'resend_code']);
Route::post('/register/edit-mobile-no', ['uses'=>'CompanyController@editmobileno', 'as'=>'edit-mobile-no']);
Route::post('/register/edit-email', ['uses'=>'CompanyController@editemail', 'as'=>'edit-email']);
//Route::get('/company/{code}', ['uses'=>'CompanyController@confirmemail']);
//Route::post('/company/confirmemail', ['uses'=>'CompanyController@confirmemail', 'as'=>'confirmemail']);

//super admin login to a company page
Route::get('/admin/login/{id}', ['uses'=>'CompanyController@login']);
Route::get('/back', ['uses'=>'CompanyController@back', 'as'=>'back']);
//company admin login to an agent page
Route::get('/login/{id}', ['uses'=>'AgentController@login']);


//super admin setting routes
Route::get('/setting/general', ['uses'=>'SettingsController@index', 'as'=>'general-settings'])->middleware('super-admin');
Route::post('/setting/general/edit', ['uses'=>'SettingsController@editsetting', 'as'=>'editsetting']);
Route::post('/setting/general/update', ['uses'=>'SettingsController@updatesetting', 'as'=>'updatesetting']);
//super admin setting routes

//api center
Route::get('/api', ['uses'=>'ApiController@index', 'as'=>'api']);
//api center

// Test Messages  routes
Route::get('/send/sms', ['uses'=>'TestMessageController@index', 'as'=>'test-messages']);
Route::post('/send-test-sms', ['uses'=>'TestMessageController@send_test_sms', 'as'=>'send-test-sms']);

//login as a user
Route::get('/impersonateIn/{user}', 'ImpersonateController@impersonateIn');
Route::get('/impersonateOut', 'ImpersonateController@impersonateOut');

//advertisements
Route::get('/advertisements', ['uses'=>'AdvertsController@index', 'as'=>'advertisements']);
Route::post('/advertisements/new', ['uses'=>'AdvertsController@addadvert', 'as'=>'addadvert']);
Route::post('/advertisements/edit', ['uses'=>'AdvertsController@editadvert', 'as'=>'editadvert']);
Route::post('/advertisements/disable', ['uses'=>'AdvertsController@disableadvert', 'as'=>'disableadvert']);
Route::post('/advertisements/enable', ['uses'=>'AdvertsController@enableadvert', 'as'=>'enableadvert']);

//email setting
Route::get('/setting/email', ['uses'=>'EmailSetting@index', 'as'=>'email-setting']);
Route::post('/setting/email/new', ['uses'=>'EmailSetting@addemailsetting', 'as'=>'addemailsetting']);
Route::post('/setting/email/edit', ['uses'=>'EmailSetting@editemailsetting', 'as'=>'editemailsetting']);

//company trial days
Route::post('/extend-trial-days', ['uses'=>'TrialDaysController@extend_trial_days', 'as'=>'extend_trial_days']);
//email cron
Route::get('/send-reminder-email', ['uses'=>'EmailCronController@send_reminder_email', 'as'=>'send_reminder_email']);
Route::get('/extended-reminder-email', ['uses'=>'EmailCronController@send_reminder_email_for_extended_trial_days', 'as'=>'extended_reminder_email']);

//billing
Route::get('/billing', ['uses'=>'BillingController@index', 'as'=>'billing']);



//push notifications
Route::get('/push-close', ['uses'=>'Pushnotifications@push_close', 'as'=>'push_close']);
Route::post('/push/add', ['uses'=>'Pushnotifications@add_subscription', 'as'=>'add_subscription']);
Route::get('/push/init', ['uses'=>'Pushnotifications@push_init'])->name('push');
//Route::get('/push/send', ['uses'=>'Pushnotifications@send_notification'])->name('push_send');

Route::get('/push', ['uses'=>'PushSitesController@index', 'as'=>'push_sites']);
Route::get('/push/{id}', ['uses'=>'PushSitesController@view_site']);
Route::post('/push-sites/new', ['uses'=>'PushSitesController@addsite', 'as'=>'addpushsite']);
Route::post('/push-sites/edit', ['uses'=>'PushSitesController@edit_site', 'as'=>'editpushsite']);

Route::get('/push/campaigns', ['uses'=>'PushCampaignsController@index', 'as'=>'push_campaigns']);
Route::post('/push-campaign/send', ['uses'=>'PushCampaignsController@send_notification', 'as'=>'send_push_campaigns']);

Route::get('/support', ['uses'=>'SupportController@index', 'as'=>'support']);
Route::post('/support/send', ['uses'=>'SupportController@sendmessage', 'as'=>'sendmessage']);
Route::post('/support/mark-solved', ['uses'=>'SupportController@marksolved', 'as'=>'marksolved']);
Route::post('/support/mark-unsolved', ['uses'=>'SupportController@markunsolved', 'as'=>'markunsolved']);

Route::get('/support/reply/{id}', ['uses'=>'SupportMessageController@supportmessage']);
Route::post('/support/reply/send', ['uses'=>'SupportMessageController@sendmessage', 'as'=>'replymessage']);

//Email history routes
Route::get('/email', ['uses'=>'EmailController@index'])->name('emails_history');
Route::get('/emails/filters/get', ['uses'=>'EmailController@get_filters'])->name('get_email_filters');
Route::post('/emails/filters/apply', ['uses'=>'EmailController@apply_filters'])->name('apply_email_filters');
Route::post('/company/emails/filters/apply', ['uses'=>'EmailController@apply_company_filters'])->name('apply_company_email_filters');
Route::get('/company/emails/{id}', ['uses'=>'EmailController@companyemails'])->middleware('super-admin');
//Email history routes

Route::get('/translation', 'TranslatorController@index')->name('translation');
Route::post('/translation/lang', ['uses'=>'TranslatorController@changelocale', 'as'=>'translatelang']);
Route::post('/translation/new', ['uses'=>'TranslatorController@create_lang_folder', 'as'=>'translate']);
Route::post('/translation/step2', ['uses'=>'TranslatorController@create_lang_file', 'as'=>'create_lang_file']);
Route::post('/translation/step3', ['uses'=>'TranslatorController@save_translated_lang', 'as'=>'save_translated_lang']);
Route::get('/translation/view-file/{id}', ['uses'=>'TranslatorController@view_file', 'as'=>'view_file']);
Route::post('/translation/save-file', ['uses'=>'TranslatorController@save_file', 'as'=>'save_file']);
Route::post('/translation/retrieve-file', ['uses'=>'TranslatorController@retrieve_file', 'as'=>'retrieve_file']);

Route::get('/firebase', 'FirebaseChatController@index')->name('firebase');
Route::get('/firebase1', 'FirebaseChatController@index1')->name('firebase1');
Route::get('/firebase/users', 'RegisterController@firebase_users')->name('firebase_users');
Route::get('/firebase/companies', 'RegisterController@firebase_companies')->name('firebase_companies');
Route::get('/firebase/sites', 'SitesController@firebase_sites')->name('firebase_sites');

Route::get('/firebase/token', 'TokenController@create_custom_token');
Route::get('/test', 'HomeController@html');
Route::get('/test1', function () {
   // return view('notifications');
   return view('send_sms');
});
Route::get('/index','UserDetailController@index');

Route::post('submitForm','UserDetailController@store');
Route::get('/downloadPDF/{id}','UserDetailController@downloadPDF');

//payment
Route::post('/payment', ['uses'=>'PaymentController@pay', 'as'=>'payment']);
//Route::post('/paypalcheckout', ['uses'=>'PaymentController@createPayment', 'as'=>'paypalcheckout']);
//Route::post('/completepayment', ['uses'=>'PaymentController@completePayment', 'as'=>'completePayment']);
Route::post('/paypalcheckout', ['uses'=>'PaymentController@createSenderIDPayment', 'as'=>'paypalcheckout']);
Route::post('/completepayment', ['uses'=>'PaymentController@completeSenderIDPayment', 'as'=>'completepayment']);
Route::post('/paypalcheckout1', ['uses'=>'PaymentController@createSenderIDPayment1', 'as'=>'paypalcheckout1']);
Route::post('/completepayment1', ['uses'=>'PaymentController@completeSenderIDPayment1', 'as'=>'completepayment1']);
Route::post('/createSMSCreditPayment', ['uses'=>'PaymentController@createSMSCreditPayment', 'as'=>'createSMSCreditPayment']);
Route::post('/completeSMSCreditPayment', ['uses'=>'PaymentController@completeSMSCreditPayment', 'as'=>'completeSMSCreditPayment']);
Route::post('/smspayment', ['uses'=>'PaymentController@smspayment', 'as'=>'smspayment']);
Route::post('/smspayment1', ['uses'=>'PaymentController@smspayment1', 'as'=>'smspayment1']);
Route::post('/smspayment2', ['uses'=>'PaymentController@smspayment2', 'as'=>'smspayment2']);
Route::post('/paymentamount', ['uses'=>'PaymentController@paymentamount', 'as'=>'paymentamount']);
Route::post('/paymentamount1', ['uses'=>'PaymentController@paymentamount1', 'as'=>'paymentamount1']);
Route::get('/sms/senderID', ['uses'=>'PaymentController@sender_id', 'as'=>'sender_id']);
Route::get('/sms/senderID/{id}', ['uses'=>'PaymentController@complete_sender_id', 'as'=>'complete_sender_id']);
Route::get('/sms/senderID1', ['uses'=>'PaymentController@sender_id1', 'as'=>'sender_id1']);
Route::post('/sender-id-payment', ['uses'=>'PaymentController@sender_id_payment', 'as'=>'sender_id_payment']);
Route::post('/sender-id-form', ['uses'=>'PaymentController@sender_id_form', 'as'=>'sender_id_form']);
Route::post('/sender-id-file', ['uses'=>'PaymentController@sender_id_file', 'as'=>'sender_id_file']);
Route::get('/credits', ['uses'=>'PaymentController@sms_credits', 'as'=>'credit_history'])->middleware('super-admin');
Route::get('/credit/{id}', ['uses'=>'PaymentController@user_sms_credits']);
Route::get('/senderIDs', ['uses'=>'PaymentController@sender_ids', 'as'=>'sender_ids'])->middleware('super-admin');
Route::get('/sms/senderIDs', ['uses'=>'PaymentController@company_sender_ids', 'as'=>'company_sender_ids']);
Route::get('/senderID/download','PaymentController@downloadPDF');
Route::get('/purchase/credits', ['uses'=>'PaymentController@buy_credit', 'as'=>'buy_credit']);
Route::get('/purchase/credit', ['uses'=>'PaymentController@buy_credit1', 'as'=>'buy_credit1']);
Route::get('/graphs/visitors','HomeController@visitors_graph');
Route::get('/graph/analytics/visitors','AnalyticsController@visitors_graph');
Route::get('/graphs/companies','HomeController@companies_graph');
Route::get('/graphs/credit-buying','HomeController@sms_credit_buying');
Route::get('/graphs/credit-amount','HomeController@sms_credit_amount');
Route::get('/graphs/sent-sms','HomeController@sent_sms');
Route::get('/graphs/sms-sales','HomeController@sms_sales');
Route::get('/graphs/sales-amount','HomeController@sms_sales_amount');
Route::get('/graphs/sender-id-amount','HomeController@sender_id_amount');

Route::get('/super_admin_analytics_data', ['uses'=>'AnalyticsController@super_admin_analytics_data']);
Route::get('/analytics/visitors', ['uses'=>'AnalyticsController@visitors']);
Route::get('/maps/companies', ['uses'=>'HomeController@companies']);
Route::get('/analytics/sms-revenue','AnalyticsController@sms_revenue');
Route::get('/analytics/sms-profit','AnalyticsController@sms_profit');
Route::post('/sms-summary', ['uses'=>'HomeController@search_time_sms', 'as'=>'sms_summary']);
Route::get('/analytics/sender-id-revenue','AnalyticsController@sender_id_revenue');
Route::get('/analytics/sent-sms','AnalyticsController@sent_sms');
Route::get('/admin_analytics_data', ['uses'=>'AnalyticsController@admin_analytics_data']);
Route::get('/SMSs', ['uses'=>'AnalyticsController@SMSs']);
Route::get('/analytics/companies','AnalyticsController@companies_graph');
Route::post('/analytics/search_sms', ['uses'=>'AnalyticsController@search_sms', 'as'=>'analytics_search_sms']);
Route::get('/analytics/load_search_more', ['uses'=>'AnalyticsController@load_search_more']);
Route::post('/sender-id/unverify', ['uses'=>'PaymentController@unverifysenderid', 'as'=>'unverifysenderid']);
Route::post('/sender-id/verify', ['uses'=>'PaymentController@verifysenderid', 'as'=>'verifysenderid']);
Route::post('/analytics/search_time_sms', ['uses'=>'AnalyticsController@search_time_sms', 'as'=>'analytics_search_time_sms']);
Route::get('/analytics/load_time_search_more', ['uses'=>'AnalyticsController@load_time_search_more']);
Route::post('/analytics/analytics_search_sender_time_sms', ['uses'=>'AnalyticsController@analytics_search_sender_time_sms', 'as'=>'analytics_search_sender_time_sms']);
Route::get('/analytics/load_senderid_search_more', ['uses'=>'AnalyticsController@load_senderid_search_more']);
Route::post('/analytics/search_senderid_by_name', ['uses'=>'AnalyticsController@search_senderid_by_name', 'as'=>'search_senderid_by_name']);
Route::get('/analytics/load_sendderid_by_name_search_more', ['uses'=>'AnalyticsController@load_sendderid_by_name_search_more']);
Route::post('/search_company_by_name', ['uses'=>'HomeController@search_company_by_name', 'as'=>'search_company_by_name']);
Route::get('/load_company_by_name_search_more', ['uses'=>'HomeController@load_company_by_name_search_more']);
Route::post('/search_sms_by_phone', ['uses'=>'HomeController@search_sms_by_phone', 'as'=>'search_sms_by_phone']);
Route::get('/search_more_sms_by_phone', ['uses'=>'HomeController@search_more_sms_by_phone']);
Route::get('/credit_receipt', ['uses'=>'PaymentController@credit_receipt']);
Route::get('/load_more_company_senderids', ['uses'=>'PaymentController@load_more_company_senderids']);
Route::get('/load_more_senderids', ['uses'=>'PaymentController@load_more_senderids']);
Route::post('/pay_senderid_with_credits', ['uses'=>'PaymentController@pay_senderid_with_credits', 'as'=>'pay_senderid_with_credits']);
Route::get('/senderID/preview', ['uses'=>'PaymentController@previewPDF', 'as'=>'previewPDF']);
Route::post('/senderidcompany', ['uses'=>'PaymentController@senderidcompany', 'as'=>'senderidcompany']);
Route::get('/get_sender_id', ['uses'=>'PaymentController@get_sender_id', 'as'=>'get_sender_id']);
Route::post('/editsenderid', ['uses'=>'PaymentController@editsenderid', 'as'=>'editsenderid']);
Route::post('/addcontactgroup', ['uses'=>'TestMessageController@addcontactgroup', 'as'=>'addcontactgroup']);
Route::get('/sms/contacts', ['uses'=>'TestMessageController@contact_groups', 'as'=>'contact_groups']);
Route::post('/editcontactgroup', ['uses'=>'TestMessageController@editcontactgroup', 'as'=>'editcontactgroup']);
Route::get('/deliveredandfailedmessages', ['uses'=>'HomeController@deliveredandfailedmessages', 'as'=>'deliveredandfailedmessages']);
Route::post('/delete',['uses'=>'TestMessageController@deletecontactgroup', 'as'=>'deletecontactgroup']);
Route::get('/calendar', 'calendarController@calendar');
Route::get('/verify', 'verifyController@verify');
Route::get('/loginUser', 'verifyController@loginUser');
Route::get('/report', 'ReportController@getReports');
Route::get('/register1', 'verifyController@Register1');
Route::get('/register2', 'verifyController@Register2');
Route::get('/register3', 'verifyController@Register3');

Route::get('/sales', 'HelpController@SalesSupport');
Route::get('/api', 'HelpController@ApiSupport');
Route::get('/technical', 'HelpController@TechnicalSupport');
Route::post('/salesSupport', 'HelpController@SupportSale');
Route::get('/showDetails/{id}','MessageController@showDetails');
Route::get('/table', 'ReportController@table');

Route::get('/master', 'verifyController@master');
Route::post('/technicalsupport','HelpController@supportTechnical');
