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

Auth::routes();

Route::get('/installation_form', function()
{
    return view('Installer.index');
})->name('installation_form');

//instaltion
Route::post('/installation', ['as'=>'/instaltion','uses'=>'instaltionController@index']);

// password
Route::post('/password/forgot','PasswordResetController@forgotpassword');
Route::get('passwords/reset/{token}/{email}','PasswordResetController@geturl');
Route::post('/passwordchange', 'PasswordResetController@passwordnew');



//Dashboard
Route::get('/', ['uses'=>'HomeController@dashboard'])->middleware('can:dashboard_view');

Route::get('/dashboard/openservice', ['as'=>'/dashboard/openservice','uses'=>'HomeController@openservice']);
Route::get('/dashboard/closeservice', ['as'=>'/dashboard/closeservice','uses'=>'HomeController@closeservice']);
Route::get('/dashboard/upservice', ['as'=>'/dashboard/upservice','uses'=>'HomeController@upservice']);
Route::get('/dashboard/open-modal', ['as'=>'/dashboard/open-modal','uses'=>'HomeController@openmodel']);
Route::get('/dashboard/view/com-modal', ['as'=>'/dashboard/view/com-modal','uses'=>'HomeController@closemodel']);
Route::get('/dashboard/view/up-modal', ['as'=>'/dashboard/view/up-modal','uses'=>'HomeController@upmodel']);

Route::auth();

//profile
Route::get('setting/profile','Profilecontroller@index');	
Route::post('/setting/profile/update/{id}','Profilecontroller@update');	

//Purchase
Route::group(['prefix'=>'purchase'],function()
{
	Route::get('/add',['as'=>'purchase/add','uses'=>'Purchasecontroller@index'])->middleware('can:purchase_add');	
	Route::post('/store',['as'=>'purchase/store','uses'=>'Purchasecontroller@store'])->middleware('can:purchase_add');
	Route::get('/list',['as'=>'purchase/list','uses'=>'Purchasecontroller@listview'])->middleware('can:purchase_view');
	Route::get('/list/pview/{id}',['as'=>'purchase/list','uses'=>'Purchasecontroller@listview1'])->middleware('can:purchase_view');
	Route::get('/list/edit/{id}',['as'=>'purchase/list/edit','uses'=>'Purchasecontroller@editview'])->middleware('can:purchase_edit');
	Route::post('/list/edit/update/{id}',['as'=>'list/edit/update/{id}','uses'=>'Purchasecontroller@update'])->middleware('can:purchase_edit');

	Route::get('/list/delete/{id}',['as'=>'purchase/list/edit','uses'=>'Purchasecontroller@destory'])->middleware('can:purchase_delete');
	Route::get('/list/modalview',['as'=>'/purchase/list/modalview','uses'=>'Purchasecontroller@purchaseview'])->middleware('can:purchase_view');

	Route::get('/add/getrecord',['as'=>'purchase/list/edit','uses'=>'Purchasecontroller@getrecord']);
	/*For purchase product time*/
	Route::get('/producttype/name',['as'=>'purchase/producttype/name','uses'=>'Purchasecontroller@productitem']);

	/*For add salespart time*/
	Route::get('/producttype/names',['as'=>'purchase/producttype/names','uses'=>'Purchasecontroller@productitems']);

	Route::get('/add/getproduct',['as'=>'purchase/list/edit','uses'=>'Purchasecontroller@getproduct']);
	Route::get('/add/getqty',['as'=>'purchase/list/edit','uses'=>'Purchasecontroller@getqty']);
	
	Route::get('/add/getproductname',['as'=>'add/getproductname','uses'=>'Purchasecontroller@getproductname']);
	Route::get('deleteproduct',['as'=>'purchase/deleteproduct','uses'=>'Purchasecontroller@deleteproduct']);
	Route::get('sale_part/deleteproduct','Purchasecontroller@sale_part_destroy');	

	/*New route for get first product data of selected product type*/
	Route::get('/getfirstproductdata','Purchasecontroller@getFirstProductData');	
	
});

//Stock
Route::group(['prefix'=>'stoke'],function()
{	
	Route::get('/list',['as'=>'stoke/list','uses'=>'Stockcontroller@index'])->middleware('can:stock_view');
	
	Route::get('/list/edit/{id}',['as'=>'stoke/list/edit','uses'=>'Stockcontroller@edit']);
	Route::post('/list/edit/update/{id}',['as'=>'stoke/list/edit/update/{id}','uses'=>'Stockcontroller@update']);
	Route::get('/list/stockview',['as'=>'stoke/list/stockview','uses'=>'Stockcontroller@stockview'])->middleware('can:stock_view');
});

// Customer 
Route::group(['prefix'=>'customer'],function()
{
	Route::get('/add',['as'=>'customer/add','uses'=>'Customercontroller@customeradd'])->middleware('can:customer_add');
	Route::post('/store',['as'=>'customer/store','uses'=>'Customercontroller@storecustomer'])->middleware('can:customer_add');
	Route::get('/list',['as'=>'customer/list','uses'=>'Customercontroller@index'])->middleware('can:customer_view');
	Route::get('/list/{id}',['as'=>'customer/list/{id}','uses'=>'Customercontroller@customershow'])->middleware('can:customer_view');
	Route::get('/list/delete/{id}',['as'=>'customer/list/delete/{id}','uses'=>'Customercontroller@destroy'])->middleware('can:customer_delete');

	Route::get('/list/edit/{id}',['as'=>'customer/list/edit/{id}','uses'=>'Customercontroller@customeredit']);	
	Route::post('/list/edit/update/{id}',['as'=>'customer/list/edit/update/{id}','uses'=>'Customercontroller@customerupdate']);

	Route::get('/free-open',['as'=>'customer/free-open','uses'=>'Customercontroller@free_open_model']);
	Route::get('/paid-open',['as'=>'/customer/paid-open','uses'=>'Customercontroller@paid_open_model']);
	Route::get('/Repeatjob-modal',['as'=>'/customer/Repeatjob-modal','uses'=>'Customercontroller@repeat_job_model']);
});


//Accountant
Route::group(['prefix'=>'accountant'],function()
{
	Route::get('/list',['as'=>'accountant/list','uses'=>'Accountantcontroller@index'])->middleware('can:accountant_view');
	Route::get('/list/{id}',['as'=>'accountant/list/{id}','uses'=>'Accountantcontroller@accountantshow'])->middleware('can:accountant_view');
	Route::get('/add',['as'=>'accountant/add','uses'=>'Accountantcontroller@accountantadd'])->middleware('can:accountant_add');
	Route::post('/store',['as'=>'accountant/store','uses'=>'Accountantcontroller@storeaccountant'])->middleware('can:accountant_add');
	Route::get('/list/delete/{id}',['as'=>'accountant/list/delete/{id}','uses'=>'Accountantcontroller@destory'])->middleware('can:accountant_delete');

	Route::get('/list/edit/{id}',['as'=>'accountant/list/edit/{id}','uses'=>'Accountantcontroller@accountantedit']);
	Route::post('/list/edit/update/{id}',['as'=>'accountant/list/edit/update/{id}','uses'=>'Accountantcontroller@accountantupdate']);
});


//Vehicle
Route::group(['prefix'=>'vehicle'],function()
{
	Route::get('/decription',['as'=>'vehical/decription','uses'=>'VehicalControler@decription']);

	Route::get('/add',['as'=>'vehicle/add','uses'=>'VehicalControler@index'])->middleware('can:vehicle_add');
	Route::post('/store',['as'=>'vehical/store','uses'=>'VehicalControler@vehicalstore'])->middleware('can:vehicle_add');
	Route::get('/list',['as'=>'vehicle/list','uses'=>'VehicalControler@vehicallist'])->middleware('can:vehicle_view');
	Route::get('/list/view/{id}',['as'=>'vehical/list/view/{id}','uses'=>'VehicalControler@vehicalshow'])->middleware('can:vehicle_view');
	Route::get('/list/delete/{id}',['as'=>'vehical/list/delete/{id}','uses'=>'VehicalControler@destory'])->middleware('can:vehicle_delete');
	Route::get('list/edit/{id}',['as'=>'vehical/list/edit/{id}','uses'=>'VehicalControler@editvehical'])->middleware('can:vehicle_edit');
    Route::post('list/edit/update/{id}',['as'=>'/vehical/list/edit/update/{id}','uses'=>'VehicalControler@updatevehical'])->middleware('can:vehicle_edit');

    Route::get('/vehicaltypefrombrand','VehicalControler@vehicaltype');
    
   //vihical type,brand,fuel,model
	Route::get('vehicle_type_add',['as'=>'vehical/vehicle_type_add','uses'=>'VehicalControler@vehicaltypeadd']);
	Route::get('/vehicaltypedelete',['as'=>'vehical/vehicaltypedelete','uses'=>'VehicalControler@deletevehicaltype']);
	
	
	Route::get('vehicle_brand_add',['as'=>'vehical/vehicle_brand_add','uses'=>'VehicalControler@vehicalbrandadd']);
	Route::get('/vehicalbranddelete',['as'=>'/vehical/vehicalbranddelete','uses'=>'VehicalControler@deletevehicalbrand']);
	
	
	Route::get('vehicle_fuel_add',['as'=>'vehical/vehicle_fuel_add','uses'=>'VehicalControler@fueladd']);
	Route::get('fueltypedelete',['as'=>'vehical/fueltypedelete','uses'=>'VehicalControler@fueltypedelete']);
 
   
	Route::get('add/getDescription','VehicalControler@getDescription');
	Route::get('delete/getDescription','VehicalControler@deleteDescription');
	Route::get('add/getImages','VehicalControler@getImages');
	Route::get('delete/getImages','VehicalControler@deleteImages');
	Route::get('add/getcolor','VehicalControler@getcolor');
	Route::get('delete/getcolor','VehicalControler@deletecolor');
	
	Route::get('vehicle_model_add','VehicalControler@add_vehicle_model');
	Route::get('vehicle_model_delete','VehicalControler@delete_vehi_model');	
});


/*vehical type*/
 Route::group(['prefix'=>'vehicletype'],function()
 {
 	Route::get('/list',['as'=>'/vehical/list' ,'uses'=>'VehicaltypesControler@vehicaltypelist'])->middleware('can:vehicletype_view');
    Route::get('/vehicletypeadd',['as'=>'/vehicletype/add' ,'uses'=>'VehicaltypesControler@index'])->middleware('can:vehicletype_add');
    Route::post('/vehicaltystore',['as'=>'/vehicletype/vehicletystore' ,'uses'=>'VehicaltypesControler@storevehicaltypes'])->middleware('can:vehicletype_add');
    Route::get('/list/delete/{id}',['as'=>'/vehical/list/delete/{id}' ,'uses'=>'VehicaltypesControler@destory'])->middleware('can:vehicletype_delete');
    Route::get('/list/edit/{id}',['as'=>'/vehical/list/edit/{id}' ,'uses'=>'VehicaltypesControler@editvehicaltype'])->middleware('can:vehicletype_edit');
    Route::post('/list/edit/update/{id}',['as'=>'/vehical/list/edit/update/{id}' ,'uses'=>'VehicaltypesControler@updatevehicaltype'])->middleware('can:vehicletype_edit');
});

/*vehical brand*/
Route::group(['prefix'=>'vehiclebrand'],function()
{
	Route::get('/list',['as'=>'/vehicalbrand/list','uses'=>'VehicalbransControler@listvehicalbrand'])->middleware('can:vehiclebrand_view');
	Route::get('/add',['as'=>'/vehicalbrand/list','uses'=>'VehicalbransControler@index'])->middleware('can:vehiclebrand_add');
	Route::post('/store',['as'=>'/vehicalbrand/store','uses'=>'VehicalbransControler@store'])->middleware('can:vehiclebrand_add');
	Route::get('/list/delete/{id}',['as'=>'/vehicalbrand/list/delete','uses'=>'VehicalbransControler@destory'])->middleware('can:vehiclebrand_delete');
	Route::get('/list/edit/{id}',['as'=>'/vehicalbrand/list/edit/{id}','uses'=>'VehicalbransControler@editbrand'])->middleware('can:vehiclebrand_edit');
	Route::post('/list/edit/update/{id}',['as'=>'/vehicalbrand/list/edit/update{id}','uses'=>'VehicalbransControler@brandupdate'])->middleware('can:vehiclebrand_edit');
});


/*Vehical Discriptions*/
Route::group(['prefix'=>'vehicaldiscriptions','middleware'=>'auth'],function()
{
	Route::get('/add',['as'=>'/vehicaldiscriptions/list','uses'=>'VehicalDiscriptionsControler@index']);
  	Route::post('/store',['as'=>'/vehicaldiscriptions/list','uses'=>'VehicalDiscriptionsControler@vehicalstore']);
  	Route::get('/list',['as'=>'/vehicaldiscriptions/list','uses'=>'VehicalDiscriptionsControler@vehicaldeslist']);
  	Route::get('/list/delete/{id}',['as'=>'/vehicaldiscriptions/list/delete/{id}','uses'=>'VehicalDiscriptionsControler@destory']);
   	Route::get('/list/edit/{id}',['as'=>'/vehicaldiscriptions/list/edit/{id}','uses'=>'VehicalDiscriptionsControler@editdescription']);
  	Route::post('/list/edit/update/{id}',['as'=>'/vehicaldiscriptions/list/edit/update/{id}','uses'=>'VehicalDiscriptionsControler@updatedescription']);
});


// Payment type
Route::group(['prefix'=>'payment'],function()
{
	Route::get('list',['as'=>'/payment/list','uses'=>'PaymentControler@paymentlist'])->middleware('can:paymentmethod_view');
	Route::get('add',['as'=>'/payment/add','uses'=>'PaymentControler@index'])->middleware('can:paymentmethod_add');
 	Route::post('store',['as'=>'/payment/store','uses'=>'PaymentControler@paymentstore'])->middleware('can:paymentmethod_add');
 	Route::get('list/delete/{id}',['as'=>'/payment/list/delete/{id}','uses'=>'PaymentControler@destory'])->middleware('can:paymentmethod_delete');
 	Route::get('list/edit/{id}',['as'=>'/payment/list/edit/{id}','uses'=>'PaymentControler@editpayment'])->middleware('can:paymentmethod_edit');
 	Route::post('list/edit/update/{id}',['as'=>'/payment/list/edit/update/{id}','uses'=>'PaymentControler@updatepayment'])->middleware('can:paymentmethod_edit');
});


//Tax Rates
Route::group(['prefix'=>'taxrates'],function()
{
	Route::get('list',['as'=>'taxrates/list','uses'=>'AccounttaxControler@taxlist'])->middleware('can:taxrate_view');
   	Route::get('add',['as'=>'taxrates/add','uses'=>'AccounttaxControler@index'])->middleware('can:taxrate_add');
   	Route::post('store',['as'=>'taxrates/store','uses'=>'AccounttaxControler@store'])->middleware('can:taxrate_add');
   	Route::get('list/delete/{id}',['as'=>'taxrates/list/delete/{id}','uses'=>'AccounttaxControler@destory'])->middleware('can:taxrate_delete');
   	Route::get('list/edit/{id}',['as'=>'taxrates/list/edit/{id}','uses'=>'AccounttaxControler@accountedit'])->middleware('can:taxrate_edit');
   	Route::post('list/edit/update/{id}',['as'=>'taxrates/list/edit/update/{id}','uses'=>'AccounttaxControler@updateaccount'])->middleware('can:taxrate_edit');
});


/*Services*/
Route::group(['prefix'=>'service'],function()
{
  	Route::get('list',['as'=>'service/list','uses'=>'ServicesControler@servicelist'])->middleware('can:service_view');
  	Route::get('add',['as'=>'service/add','uses'=>'ServicesControler@index'])->middleware('can:service_add');
  	Route::post('store',['as'=>'service/store','uses'=>'ServicesControler@store'])->middleware('can:service_add');
  	Route::get('list/delete/{id}',['as'=>'service/list/delete/{id}','uses'=>'ServicesControler@destory'])->middleware('can:service_delete');
  	Route::get('list/edit/{id}',['as'=>'service/list/edit/{id}','uses'=>'ServicesControler@serviceedit'])->middleware('can:service_edit');
  	Route::post('list/edit/update/{id}',['as'=>'service/list/edit/update/{id}','uses'=>'ServicesControler@serviceupdate'])->middleware('can:service_edit');

  	Route::post('add_jobcard','ServicesControler@add_jobcard')->middleware('can:service_add');

  	Route::get('list/view',['as'=>'service/list/view','uses'=>'ServicesControler@serviceview']);
  	Route::get('get_vehi_name',['as'=>'service/add','uses'=>'ServicesControler@get_vehicle_name']);
  	Route::get('select_checkpt','ServicesControler@select_checkpt');
  	Route::get('get_obs','ServicesControler@Get_Observation_Pts');
  	Route::get('used_coupon_data','ServicesControler@Used_Coupon_Data');
  	Route::get('getregistrationno','ServicesControler@getregistrationno');
  
  	Route::POST('/customeradd','ServicesControler@customeradd');
  	Route::get('/vehicleadd','ServicesControler@vehicleadd');

  	/*New route for auto searchable dropdown*/
  	Route::get('/customer_autocomplete_search','ServicesControler@get_customer_name');
});


/*Quotation Module Add by Mukesh*/
Route::group(['prefix'=>'quotation'],function()
{
	Route::get('list',['as'=>'quotation/list','uses'=>'QuotationController@list'])->middleware('can:quotation_view');
	Route::get('list/view',['as'=>'quotation/list/view','uses'=>'QuotationController@quotationView'])->middleware('can:quotation_view');

	Route::get('add',['as'=>'quotation/add','uses'=>'QuotationController@index'])->middleware('can:quotation_add');
	Route::post('store',['as'=>'quotation/store','uses'=>'QuotationController@store'])->middleware('can:quotation_add');
	
	Route::get('list/edit/{id}',['as'=>'quotation/list/edit/{id}','uses'=>'QuotationController@quotationEdit'])->middleware('can:quotation_edit');
	Route::post('list/edit/update/{id}',['as'=>'quotation/list/edit/update/{id}','uses'=>'QuotationController@quotationUpdate'])->middleware('can:quotation_edit');

	Route::get('list/modify/{id}',['as'=>'quotation_modify','uses'=>'QuotationController@quotationModify'])->middleware('can:quotation_edit');
	Route::post('/add_modify_quotation',['as'=>'quotation/add_modify_quotation','uses'=>'QuotationController@add_modify_quotation'])->middleware('can:quotation_edit');

	Route::get('list/delete/{id}',['as'=>'quotation/list/delete/{id}','uses'=>'QuotationController@destroy'])->middleware('can:quotation_delete');
	Route::post('/add_jobcard','QuotationController@add_jobcard');
});


//Invoice
Route::group(['prefix'=>'invoice'],function()
{
	Route::get('/list','InvoiceController@showall')->middleware('can:invoice_view');
	Route::get('/add','InvoiceController@index')->middleware('can:invoice_add');
	Route::get('/add/{id}','InvoiceController@index')->middleware('can:invoice_add');
	Route::get('/sale_part_invoice/add','InvoiceController@sale_part_index')->middleware('can:invoice_add');
	Route::get('/sale_part_invoice/add/{id}','InvoiceController@sale_part_index')->middleware('can:invoice_add');
	Route::post('/store','InvoiceController@store')->middleware('can:invoice_add');
	Route::post('/sale_part_invoice/store','InvoiceController@store')->middleware('can:invoice_add');
	Route::get('/get_jobcard_no','InvoiceController@get_jobcard_no');
	Route::get('/get_service_no','InvoiceController@get_service_no');
	Route::get('/get_invoice','InvoiceController@get_invoice');
	Route::get('/list/edit/{id}','InvoiceController@edit')->middleware('can:invoice_edit');
	Route::post('/list/edit/update/{id}','InvoiceController@update')->middleware('can:invoice_edit');
	Route::get('/list/delete/{id}','InvoiceController@destroy')->middleware('can:invoice_delete');
	Route::get('/sales_customer','InvoiceController@sales_customer');
	Route::get('/get_vehicle','InvoiceController@get_vehicle');
	Route::get('/get_part','InvoiceController@get_part');
	Route::get('/get_vehicle_total','InvoiceController@get_vehicle_total');
	Route::get('/pay/{id}','InvoiceController@pay');
	Route::post('/pay/update/{id}','InvoiceController@payupdate');
	Route::get('/payment/paymentview','InvoiceController@paymentview');
	Route::get('/sale_part','InvoiceController@viewSalePart');
});

Route::get('/invoice/servicepdf/{id}','InvoiceController@servicepdf');
Route::get('/invoice/salespdf/{id}','InvoiceController@salespdf');
//Route created by Mukesh (For generate salesPart pdf)
Route::get('/invoice/salespartpdf/{id}','InvoiceController@salespartpdf');
// Route::post('/invoice/stripe','InvoicePaymentController@stripe');
Route::post('/invoice/stripe','InvoicePaymentController@stripe');

//Supllier
Route::group(['prefix'=>'supplier'],function()
{	
	Route::get('/list','Suppliercontroller@supplierlist')->middleware('can:supplier_view');
	Route::get('/add','Suppliercontroller@supplieradd')->middleware('can:supplier_add');
	Route::post('/store','Suppliercontroller@storesupplier')->middleware('can:supplier_add');
	Route::get('/list/{id}','Suppliercontroller@showsupplier')->middleware('can:supplier_view');
	Route::get('/list/delete/{id}','Suppliercontroller@destroy')->middleware('can:supplier_delete');
	Route::get('/list/edit/{id}','Suppliercontroller@edit')->middleware('can:supplier_edit');
	Route::post('/list/edit/update/{id}','Suppliercontroller@update')->middleware('can:supplier_edit');
	Route::get('/add_data','Suppliercontroller@adddata');
});


//Change language and timezone and language direction
Route::group(['prefix'=>'setting'],function()
{
	//For Language
	Route::get('/list',['as'=>'listlanguage','uses'=>'Languagecontroller@index'])->middleware('can:timezone_view');
	Route::post('/language/store',['as'=>'storelanguage','uses'=>'Languagecontroller@store'])->middleware('can:timezone_edit');

	//For Timezone
	Route::get('/timezone/list',['as'=>'timezonelist','uses'=>'Timezonecontroller@index']);
	Route::post('/timezone/store',['as'=>'storetimezone','uses'=>'Timezonecontroller@store']);

	//stripe setting routes
	Route::get('/stripe/list',['as'=>'timezonelist','uses'=>'Timezonecontroller@stripeList'])->middleware('can:stripesetting_view');
	Route::post('/stripe/store',['as'=>'storetimezone','uses'=>'Timezonecontroller@stripeStore'])->middleware('can:stripesetting_edit');

	// stripe setting routes
	Route::post('/date/store',['as'=>'storetimezone','uses'=>'Timezonecontroller@datestore']);
	
	//language
	Route::get('language/direction/list',['as'=>'listlanguagedirection','uses'=>'Languagecontroller@index1']);
	Route::post('language/direction/store',['as'=>'storelanguagedirection','uses'=>'Languagecontroller@store1']);

	//accessrights
	Route::get('accessrights/list',['as'=>'accessrights/list','uses'=>'Accessrightscontroller@index']);
	Route::GET('/accessrights/store',['as'=>'/accessrights/store','uses'=>'Accessrightscontroller@store']);
	Route::GET('/accessrights/Employeestore',['as'=>'/accessrights/Employeestore','uses'=>'Accessrightscontroller@Employeestore']);
	Route::GET('/accessrights/staffstore',['as'=>'/accessrights/staffstore','uses'=>'Accessrightscontroller@staffstore']);
	Route::GET('/accessrights/Accountantstore',['as'=>'/accessrights/Accountantstore','uses'=>'Accessrightscontroller@Accountantstore']);

	//New Accessrights Adding by Me
	Route::get('accessrights/show',['as'=>'accessrights/show','uses'=>'Accessrightscontroller@shows'])->middleware('can:accessrights_view');
	Route::post('accessrights/access_store/{id}',['as'=>'/accessrights/access_store/{id}','uses'=>'Accessrightscontroller@storeAccessRights'])->middleware('can:accessrights_edit');


	//general_setting
	Route::get('general_setting/list','GeneralController@index');
	Route::post('general_setting/store','GeneralController@store');

	//hours
	Route::get('hours/list','HoursController@index')->middleware('can:businesshours_view');
	Route::post('hours/store','HoursController@hours')->middleware('can:businesshours_add');
	Route::post('holiday/store','HoursController@holiday')->middleware('can:businesshours_add');
	Route::get('deleteholiday/{id}','HoursController@deleteholiday')->middleware('can:businesshours_delete');
	Route::get('/deletehours/{id}','HoursController@deletehours')->middleware('can:businesshours_delete');
	
	//currancy
	Route::post('currancy/store','Timezonecontroller@currancy');

	//custom field
	Route::get('/custom/list','Customcontroller@index')->middleware('can:customfield_view');
	Route::get('custom/add','Customcontroller@add')->middleware('can:customfield_add');
	Route::post('custom/store','Customcontroller@store')->middleware('can:customfield_add');
	Route::get('custom/list/edit/{id}','Customcontroller@edit')->middleware('can:customfield_edit');
	Route::post('custom/list/edit/update/{id}','Customcontroller@update')->middleware('can:customfield_edit');
	Route::get('custom/list/delete/{id}','Customcontroller@delete')->middleware('can:customfield_delete');
});

/**** Add and delete radio and checkbox *****/
Route::get('custom_field/add_radio_label_data','Customcontroller@add_radio_label_data');
Route::get('custom_field/delete_radio_label_data','Customcontroller@radio_label_delete');
Route::get('custom_field/add_checkbox_label_data','Customcontroller@add_checkbox_label_data');
Route::get('custom_field/delete_checkbox_label_data','Customcontroller@checkbox_label_delete');

//Country City State ajax
Route::get('/getstatefromcountry','CountryAjaxcontroller@getstate');
Route::get('/getcityfromstate','CountryAjaxcontroller@getcity');

//employee module
Route::group(['prefix'=>'employee'],function()
{
	Route::get('/list',['as'=>'listemployeee','uses'=>'employeecontroller@employeelist'])->middleware('can:employee_view');
	Route::get('/view/{id}','employeecontroller@showemployer')->middleware('can:employee_view');
	Route::get('/add',['as'=>'addemployeee','uses'=>'employeecontroller@addemployee'])->middleware('can:employee_add');
	Route::post('/store',['as'=>'storeemployeee','uses'=>'employeecontroller@store'])->middleware('can:employee_add');

	Route::get('/edit/{id}',['as'=>'editemployeee','uses'=>'employeecontroller@edit']);
	Route::patch('/edit/update/{id}','employeecontroller@update');

	Route::get('/list/delete/{id}',['as'=>'/employee/list/delete/{id}','uses'=>'employeecontroller@destory'])->middleware('can:employee_delete');
	
	Route::get('/free_service',['as'=>'/employee/free_service','uses'=>'employeecontroller@free_service']);
	Route::get('/paid_service',['as'=>'/employee/paid_service','uses'=>'employeecontroller@paid_service']);
	Route::get('/repeat_service',['as'=>'/employee/repeat_service','uses'=>'employeecontroller@repeat_service']);
});

//Support Staff Module
Route::group(['prefix'=>'supportstaff'],function()
{
	Route::get('/list',['as'=>'listsupportstaff','uses'=>'Supportstaffcontroller@index'])->middleware('can:supportstaff_view');
	Route::get('/list/{id}',['as'=>'supportstaff/list/{id}','uses'=>'Supportstaffcontroller@supportstaff_show'])->middleware('can:supportstaff_view');
	Route::get('/add',['as'=>'supportstaff','uses'=>'Supportstaffcontroller@supportstaffadd'])->middleware('can:supportstaff_add');
	Route::post('/store',['as'=>'supportstaff','uses'=>'Supportstaffcontroller@store_supportstaff'])->middleware('can:supportstaff_add');

	/*Route::get('list/edit/{id}',['as'=>'supportstaff','uses'=>'Supportstaffcontroller@edit'])->middleware('canany:supportstaff_edit');
	Route::post('/list/edit/update/{id}',['as'=>'supportstaff/list/edit/update/{id}','uses'=>'Supportstaffcontroller@update'])->middleware('can:supportstaff_edit');*/

	Route::get('list/edit/{id}',['as'=>'supportstaff','uses'=>'Supportstaffcontroller@edit']);
	Route::post('/list/edit/update/{id}',['as'=>'supportstaff/list/edit/update/{id}','uses'=>'Supportstaffcontroller@update']);

	Route::get('/list/delete/{id}',['as'=>'/supportstaff/list/delete/{id}','uses'=>'Supportstaffcontroller@destory'])->middleware('can:supportstaff_delete');
});


//Product List Module
Route::group(['prefix'=>'product'],function()
{
	Route::get('/list',['as'=>'listproduct','uses'=>'Productcontroller@index'])->middleware('can:product_view');
	Route::get('/list/{id}',['as'=>'listproduct','uses'=>'Productcontroller@indexid'])->middleware('can:product_view');
	Route::get('/add',['as'=>'addproduct','uses'=>'Productcontroller@addproduct'])->middleware('can:product_add');
	Route::post('/store',['as'=>'storeproduct','uses'=>'Productcontroller@store'])->middleware('can:product_add');
	Route::get('/list/edit/{id}',['as'=>'editproduct','uses'=>'Productcontroller@edit'])->middleware('can:product_edit');
	Route::post('/list/edit/update/{id}',['as'=>'updateproduct','uses'=>'Productcontroller@update'])->middleware('can:product_edit');
	Route::get('/list/delete/{id}',['as'=>'deleteproduct','uses'=>'Productcontroller@destroy'])->middleware('can:product_delete');
	
	Route::get('/unit',['as'=>'product/unit','uses'=>'Productcontroller@unitadd']);
	Route::get('/unitdelete',['as'=>'product/unitdelete','uses'=>'Productcontroller@unitdelete']);

	/*New route for Supplier auto searchable dropdown*/
  	Route::get('/supplier_autocomplete_search','Productcontroller@get_supplier_company_name');
});

Route::get('/product_type_add','Productcontroller@addproducttype');
Route::get('/prodcttypedelete','Productcontroller@deleteproducttype');
Route::get('/color_name_add','Productcontroller@coloradd');
Route::get('/colortypedelete','Productcontroller@colordelete');
Route::get('/supplier/product/{id}', ['middleware'=>'auth','uses'=>'Suppliercontroller@data']);


//Color List Module
Route::group(['prefix'=>'color'],function()
{
	Route::get('/list',['as'=>'listcolor','uses'=>'Colorcontroller@index'])->middleware('can:colors_view');
	Route::get('/add',['as'=>'addcolor','uses'=>'Colorcontroller@addcolor'])->middleware('can:colors_add');
	Route::post('/store',['as'=>'storecolor','uses'=>'Colorcontroller@store'])->middleware('can:colors_add');
	Route::get('/list/delete/{id}','Colorcontroller@destroy')->middleware('can:colors_delete');
	Route::get('/list/edit/{id}','Colorcontroller@edit')->middleware('can:colors_edit');
	Route::post('/list/edit/update/{id}','Colorcontroller@update')->middleware('can:colors_delete');
});

//RTO List Module
Route::group(['prefix'=>'rto'],function()
{
	Route::get('/list',['as'=>'listrto','uses'=>'Rtocontroller@index'])->middleware('can:rto_view');
	Route::get('/add',['as'=>'addrto','uses'=>'Rtocontroller@addrto'])->middleware('can:rto_add');
	Route::post('/store',['as'=>'storerto','uses'=>'Rtocontroller@store'])->middleware('can:rto_add');
	Route::get('/list/delete/{id}','Rtocontroller@destroy')->middleware('can:rto_delete');
	Route::get('/list/edit/{id}','Rtocontroller@edit')->middleware('can:rto_edit');
	Route::post('/list/edit/update/{id}','Rtocontroller@update')->middleware('can:rto_edit');
});

//Mail Formate Module
Route::group(['prefix'=>'mail'],function()
{
	Route::get('/mail',['as'=>'usermail','uses'=>'Mailcontroller@index'])->middleware('can:emailtemplate_view');
	Route::post('/mail/emailformat/{id}',['as'=>'/emailformat/{id}','uses'=>'Mailcontroller@emailupadte'])->middleware('can:emailtemplate_edit');

	Route::get('/user',['as'=>'usermail','uses'=>'Mailcontroller@user']);
	Route::get('/sales',['as'=>'salesmail','uses'=>'Mailcontroller@sales']);
	Route::get('/services',['as'=>'servicessmail','uses'=>'Mailcontroller@services']);
});

//Sales formate module
Route::group(['prefix'=>'sales'],function()
{
	Route::get('/list',['as'=>'listsales','uses'=>'Salescontroller@index'])->middleware('can:sales_view');
	Route::get('/add',['as'=>'addsales','uses'=>'Salescontroller@addsales'])->middleware('can:sales_add');
	Route::post('/store',['as'=>'storesales','uses'=>'Salescontroller@store'])->middleware('can:sales_add');
	Route::get('/list/modal',['as'=>'salesview','uses'=>'Salescontroller@view'])->middleware('can:sales_view');
	Route::get('/list/delete/{id}','Salescontroller@destroy')->middleware('can:sales_delete');
	Route::get('/list/edit/{id}','Salescontroller@edit')->middleware('can:sales_edit');
	Route::post('/list/edit/update/{id}','Salescontroller@update')->middleware('can:sales_edit');
	Route::get('/add/getrecord','Salescontroller@getrecord');


	Route::get('/add/getchasis','Salescontroller@getchasis');
	Route::get('/add/getmodel_name','Salescontroller@getmodel_name');

	Route::get('/edit/getrecord','Salescontroller@getrecord');
	Route::get('/edit/getchasis','Salescontroller@getchasis');
	Route::get('/edit/getmodel_name','Salescontroller@getmodel_name');

	Route::get('/add/getqty','Salescontroller@getqty');
	Route::get('/add/getservices','Salescontroller@getservices');
	Route::get('/add/gettaxes','Salescontroller@gettaxes');
	Route::get('/add/gettaxespercentage','Salescontroller@gettaxespercentage');

	Route::get('/color_name_add','Salescontroller@coloradd');
	Route::get('/colortypedelete','Salescontroller@colordelete');
});


//Job Card Module
Route::group(['prefix'=>'jobcard'],function()
{
	Route::get('/list',['as'=>'list/jobcard','uses'=>'JobCardcontroller@index'])->middleware('can:jobcard_view');/*Get Jobcard Listing Page*/
	Route::get('/list/jview/{id}',['as'=>'list/jview','uses'=>'JobCardcontroller@indexid']);
	
	/*Display ProcessJob Form and Store data of this form*/
	Route::get('/list/{id}',['as'=>'viewjobcard','uses'=>'JobCardcontroller@view'])->middleware('can:jobcard_edit');/*Display ProcessJob Form(If click on ProcessJob Button on Listing Page)*/
	Route::post('/store',['as'=>'jobcard/store','uses'=>'JobCardcontroller@store'])->middleware('can:jobcard_edit');/*Store ProcessJob data*/

	/*This is redirect from Jobcard page to Service Module*/
	Route::get('/add',['as'=>'addjobcard','uses'=>'JobCardcontroller@jobcard_add'])->middleware('can:jobcard_add');

	Route::get('/gatepass',['as'=>'jobcard/gatepass','uses'=>'JobCardcontroller@gatepass']);
	/*Store Gatepass Data*/
	Route::post('/insert_gatedata',['as'=>'jobcard/insert','uses'=>'JobCardcontroller@insert_gatepass_data'])->middleware('can:jobcard_edit');
	Route::get('/list/add_invoice/{id}','JobCardcontroller@add_invoice');
});


Route::get('/observation','JobCardcontroller@addobservation');
Route::get('/jobcard/addproducts','JobCardcontroller@addproducts');
Route::get('/jobcard/getprice','JobCardcontroller@getprice');
Route::get('/jobcard/gettotalprice','JobCardcontroller@gettotalprice');

/*Invoice View button inside listing page action row View Invoice*/
Route::get('/jobcard/modalview','JobCardcontroller@modalview')->middleware('can:jobcard_view'); 

Route::get('/jobcard/gatepass/autofill_data','JobCardcontroller@getrecord');

/*gatepass button*/
Route::get('/jobcard/gatepass/{id}','JobCardcontroller@gatedata')->middleware('can:jobcard_edit');

Route::get('/jobcard/add/getrecord','JobCardcontroller@getpoint');

Route::get('/jobcard/addcheckpoint','JobCardcontroller@pointadd');
Route::get('/jobcard/addcheckresult','JobCardcontroller@addcheckresult');
Route::get('/jobcard/commentpoint','JobCardcontroller@commentpoint');
Route::get('/jobcard/list/modalget','JobCardcontroller@getview');
Route::get('/getpassdetail','JobCardcontroller@getpassinvoice');

//Route::get('/jobcard/select_checkpt','JobCardcontroller@select_checkpt');
//Route::get('/jobcard/get_obs','JobCardcontroller@Get_Observation_Pts');
//Route::get('/jobcard/delete_on_reprocess','JobCardcontroller@delete_on_reprocess');

Route::post('/jobcard/select_checkpt','JobCardcontroller@select_checkpt');
Route::post('/jobcard/get_obs','JobCardcontroller@Get_Observation_Pts');
Route::post('/jobcard/delete_on_reprocess','JobCardcontroller@delete_on_reprocess');

Route::get('/jobcard/oth_pro_delete','JobCardcontroller@oth_pro_delete');
Route::get('//jobcard/stocktotal','JobCardcontroller@stocktotal');

//getpass
Route::group(['prefix'=>'gatepass'],function()
{
	Route::get('/list',['as'=>'gatepass/list','uses'=>'Getpasscontroller@index'])->middleware('can:gatepass_view'); 
	Route::get('/add',['as'=>'gatepass/list','uses'=>'Getpasscontroller@addgatepass'])->middleware('can:gatepass_add');
	Route::post('/store',['as'=>'gatepass/list','uses'=>'Getpasscontroller@store'])->middleware('can:gatepass_add');
	Route::get('/list/delete/{id}',['as'=>'/gatepass/list/delete/{id}','uses'=>'Getpasscontroller@delete'])->middleware('can:gatepass_delete');
	Route::get('/list/edit/{id}',['as'=>'/gatepass/list/edit/','uses'=>'Getpasscontroller@edit'])->middleware('can:gatepass_edit');
	Route::post('/list/edit/upadte/{id}',['as'=>'/gatepass/list/edit/update','uses'=>'Getpasscontroller@upadte'])->middleware('can:gatepass_edit');
	Route::get('/gatepassview',['as'=>'/gatepass//gatepassview','uses'=>'Getpasscontroller@gatepassview'])->middleware('can:gatepass_view');
	Route::get('/gatedata',['as'=>'/gatepass/gatedata','uses'=>'Getpasscontroller@gatedata']);
});

//Observation Type  Module
Route::group(['prefix'=>'observation_type'],function()
{
	Route::get('/list',['as'=>'listobservationtype','uses'=>'ObservationTypecontroller@index']);
	Route::get('/add',['as'=>'addobservationtype','uses'=>'ObservationTypecontroller@addobservation']);
	Route::post('/store',['as'=>'storerto','uses'=>'ObservationTypecontroller@store']);
	Route::get('/list/delete/{id}','ObservationTypecontroller@destroy');
	Route::get('/list/edit/{id}','ObservationTypecontroller@edit');
	Route::post('/list/edit/update/{id}','ObservationTypecontroller@update');
});

//Observation Point  Module
Route::group(['prefix'=>'observation_point'],function()
{
	Route::get('/list',['as'=>'listobservation','uses'=>'ObservationPointcontroller@index']);
	Route::get('/add',['as'=>'addobservation','uses'=>'ObservationPointcontroller@addobservation']);
	Route::post('/store',['as'=>'storerto','uses'=>'ObservationPointcontroller@store']);
	Route::get('/list/delete/{id}','ObservationPointcontroller@destroy');
	Route::get('/list/edit/{id}','ObservationPointcontroller@edit');
	Route::post('/list/edit/update/{id}','ObservationPointcontroller@update');
});

//Checkpoint Module (Observation Library)
Route::get('/observation/list','CheckpointController@showall')->middleware('can:observationlibrary_view');
Route::get('/observation/add','CheckpointController@index')->middleware('can:observationlibrary_add');
Route::post('/observation/store','CheckpointController@store')->middleware('can:observationlibrary_add');
Route::get("/deleteuser","CheckpointController@destroy")->middleware('can:observationlibrary_delete');
Route::get("/editcheckpoin","CheckpointController@edit")->middleware('can:observationlibrary_edit');
Route::get("/submitnewname","CheckpointController@updatedata")->middleware('can:observationlibrary_edit');
Route::get("/newcategory","CheckpointController@add_category");


//Income Module
Route::group(['prefix'=>'income'],function()
{
	Route::get('/list','IncomeController@showall')->middleware('can:income_view');
	Route::get('/add','IncomeController@index')->middleware('can:income_add');
	Route::post('/store','IncomeController@store')->middleware('can:income_add');
	Route::get('/edit/{id}','IncomeController@edit')->middleware('can:income_edit');
	Route::post('/update/{id}','IncomeController@update')->middleware('can:income_edit');
	Route::get('/delete/{id}','IncomeController@destroy')->middleware('can:income_delete');
	Route::get('/month_income','IncomeController@monthly_income')->middleware('can:income_view');
	Route::post('/income_report','IncomeController@get_month_income')->middleware('can:income_view');
});

//Expenses Module
Route::group(['prefix'=>'expense'],function()
{
	Route::get('/list','ExpenseController@showall')->middleware('can:expense_view');
	Route::get('/add','ExpenseController@index')->middleware('can:expense_add');
	Route::post('/store','ExpenseController@store')->middleware('can:expense_add');
	Route::get('/edit/{id}','ExpenseController@edit')->middleware('can:expense_edit');
	Route::post('/update/{id}','ExpenseController@update')->middleware('can:expense_edit');
	Route::get('/delete/{id}','ExpenseController@destroy')->middleware('can:expense_delete');
	Route::get('/month_expense','ExpenseController@monthly_expense')->middleware('can:expense_view');
	Route::post('/expense_report','ExpenseController@get_month_expense')->middleware('can:expense_view');
});

//Report Module
Route::group(['prefix'=>'report'],function()
{
	Route::get('/salesreport','Reportcontroller@sales')->middleware('can:report_view');
	Route::post('/record_sales','Reportcontroller@record_sales')->middleware('can:report_view');
	Route::get('/servicereport','Reportcontroller@service')->middleware('can:report_view');
	Route::post('/record_service','Reportcontroller@record_service')->middleware('can:report_view');
	Route::get('/productreport','Reportcontroller@product')->middleware('can:report_view');
	Route::get('/producttype/name','Reportcontroller@producttype');
	Route::post('/record_product','Reportcontroller@record_product')->middleware('can:report_view');
	Route::get('/productuses','Reportcontroller@productuses')->middleware('can:report_view');
	Route::post('/uses_product','Reportcontroller@uses_product')->middleware('can:report_view');
	Route::get('/stock/modalview','Reportcontroller@modalview');
	Route::get('/stock/modalviewPart','Reportcontroller@modalviewPart');
	Route::get('/servicebyemployee','Reportcontroller@servicebyemployee')->middleware('can:report_view');
	Route::post('/employeeservice','Reportcontroller@employeeservice')->middleware('can:report_view');
});


//Sales Part
Route::get('/sales_part/list','SalesPartcontroller@index')->middleware('can:salespart_view');
Route::get('/sales_part/add','SalesPartcontroller@addsales')->middleware('can:salespart_add');
Route::post('/sales_part/store','SalesPartcontroller@store')->middleware('can:salespart_add');
Route::get('/sales_part/edit/{id}','SalesPartcontroller@edit')->middleware('can:salespart_edit');
Route::post('/sales_part/edit/update/{id}','SalesPartcontroller@update')->middleware('can:salespart_edit');
Route::get('/sales_part/delete/{id}','SalesPartcontroller@destroy')->middleware('can:salespart_delete');

Route::get('/sales_part/list/modal','SalesPartcontroller@view')->middleware('can:salespart_view');
Route::get('/sales_part/getprice','SalesPartcontroller@getmodel_name');
Route::get('/sales_part/add/getproductname','SalesPartcontroller@getproductname');
Route::get('/sale_part/deleteproduct','SalesPartcontroller@sale_part_destroy');

//New route add by mukesh for get product quantity availability
Route::get('/sale_part/get_available_product','SalesPartcontroller@getAvailableProduct');

Route::get('/clear-cache', function() 
{
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Clear Route cache:
Route::get('/route-cache', function() 
{
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() 
{
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() 
{
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});