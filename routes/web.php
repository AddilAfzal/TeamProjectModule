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

Route::get('/restore', 'RestoreController@index');
Route::post('/restore', 'RestoreController@performRestore');

//Login Page
Route::get('/login', 'SessionsController@create');
Route::post('/login', 'SessionsController@store');

//Logout
Route::get('/logout', array('as' => 'logout', 'uses' => 'SessionsController@destroy'));

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('/home', function () {
    return redirect('/');
});

Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/', 'AdminController@index');
    Route::get('/admin/home', 'AdminController@index');

    Route::get('/admin/blanks/', 'BlanksController@index');
    Route::get('/admin/blanks/create', 'BlanksController@create');
    Route::post('/admin/blanks', 'BlanksController@store');
    Route::get('/admin/blanks/{blank}/', 'BlanksController@show');
    Route::post('/admin/blanks/assign/', 'BlanksController@assign');
    Route::post('/admin/blanks/delete/', 'BlanksController@destroy');
    Route::post('/admin/blanks/search/', 'BlanksController@search');

    Route::get('/admin/blanktypes/', 'BlankTypesController@index');
    Route::get('/admin/blanktypes/create', 'BlankTypesController@create');
    Route::get('/admin/blanktypes/{id}', 'BlankTypesController@show');
    Route::post('/admin/blanktypes/', 'BlankTypesController@store');

    Route::get('/admin/users', 'UsersController@index');
    Route::get('/admin/users/create', 'UsersController@create');
    Route::get('/admin/users/{id}', 'UsersController@show');

    Route::post('/admin/users/', 'UsersController@store');
    Route::post('/admin/users/resetpassword', 'UsersController@resetPassword');
    Route::post('/admin/users/suspend', 'UsersController@suspend');
    Route::post('/admin/users/activate', 'UsersController@activate');
    Route::post('/admin/users/delete', 'UsersController@destroy');
    Route::post('/admin/users/search', 'UsersController@search');

    Route::get('/admin/travelagent/', 'TravelAgentController@index');
    Route::get('/admin/travelagent/edit', 'TravelAgentController@edit');
    Route::post('/admin/travelagent/', 'TravelAgentController@update');

    Route::get('/admin/currencies/', 'CurrenciesController@index');
    Route::get('/admin/currencies/create', 'CurrenciesController@create');
    Route::post('/admin/currencies/store', 'CurrenciesController@store');
    Route::post('/admin/currencies/delete', 'CurrenciesController@destroy');
    Route::get('/admin/currencies/{id}', 'CurrenciesController@show');

    Route::get('/admin/reports/ticket-stock-turnover/', 'ReportsController@ticketStockTurnoverIndex');
    Route::post('/admin/reports/ticket-stock-turnover/', 'ReportsController@ticketStockTurnoverGenerate');

    Route::get('/admin/backups/', 'BackupController@index');
    Route::post('/admin/backups/', 'BackupController@generateBackup');
    Route::post('/admin/backups/download', 'BackupController@download');
    Route::post('/admin/backups/delete', 'BackupController@delete');

    Route::get('/admin/test/', 'ReportsController@test');
});

Route::group(['middleware' => 'manager'], function () {
    Route::get('/manager/', 'ManagerController@index');
    Route::get('/manager/home', 'ManagerController@index');

    Route::get('/manager/currencies/', 'CurrenciesController@index');
    Route::get('/manager/currencies/create', 'CurrenciesController@create');
    Route::post('/manager/currencies/store', 'CurrenciesController@store');
    Route::post('/manager/currencies/delete', 'CurrenciesController@destroy');
    Route::post('/manager/currencies/update/rate', 'CurrenciesController@updateRate');
    Route::get('/manager/currencies/{id}', 'CurrenciesController@show');

    Route::get('/manager/blanks/', 'BlanksController@index');
    Route::post('/manager/blanks/search/', 'BlanksController@search');
    Route::post('/manager/blanks/assign/', 'BlanksController@assign');
    Route::get('/manager/blanks/{blank}', 'BlanksController@show');

    Route::get('/manager/blanktypes/', 'BlankTypesController@index');
    Route::get('/manager/blanktypes/create', 'BlankTypesController@create');
    Route::get('/manager/blanktypes/{id}', 'BlankTypesController@show');
    Route::post('/manager/blanktypes/update/rate', 'BlankTypesController@updateRate');


    Route::get('/manager/customers/', 'CustomersController@index');
    Route::get('/manager/customers/create', 'CustomersController@create');
    Route::get('/manager/customers/{id}', 'CustomersController@show');
    Route::get('/manager/customers/{customer}/payment-letter', 'CustomersController@paymentLetterIndex');
    Route::get('/manager/customers/{customer}/payment-letter-get', 'CustomersController@paymentLetterGet');
    Route::post('/manager/customers/', 'CustomersController@store');
    Route::post('/manager/customers/update/type/', 'CustomersController@updateAccountType');
    Route::post('/manager/customers/update/contact', 'CustomersController@updateContact');
    Route::post('/manager/customers/delete/', 'CustomersController@destroy');
    Route::post('/manager/customers/search/', 'CustomersController@search');
    Route::post('/manager/customers/print/reminder-letter/', 'CustomersController@search');
    Route::post('/manager/customers/log/payment-reminder', 'CustomersController@logPaymentReminder');


    Route::get('/manager/discounts/', 'DiscountsController@index');
    Route::get('/manager/discounts/create', 'DiscountsController@create');
    Route::get('/manager/discounts/{discount}', 'DiscountsController@show');
    Route::post('/manager/discounts/', 'DiscountsController@store');
    Route::post('/manager/discounts/delete', 'DiscountsController@destroy');
    Route::post('/manager/discounts/assign-customer/', 'DiscountsController@assignCustomer');

    Route::get('/manager/refunds/', 'RefundsController@index');
    Route::get('/manager/refunds/create', 'RefundsController@create');
    Route::get('/manager/refunds/{refund}', 'RefundsController@show');
    Route::post('/manager/refunds/', 'RefundsController@store');

    Route::get('/manager/sales/create', 'SalesController@create');
    Route::get('/manager/sales/', 'SalesController@index');
    Route::get('/manager/sales/overdue', 'SalesController@overdueIndex');
    Route::get('/manager/sales/search', 'SalesController@search');
    Route::get('/manager/sales/{id}', 'SalesController@show');
    Route::post('/manager/sales/find-customer/', 'SalesController@find');
    Route::post('/manager/sales/', 'SalesController@store');
    Route::post('/manager/sales/update/payment', 'SalesController@updatePaymentStatus');


    Route::get('/manager/reports/', 'ReportsController@index');
    Route::get('/manager/reports/create', 'ReportsController@create');
    Route::get('/manager/reports/individual-sales/create', 'ReportsController@individualSalesReportCreate');
    Route::get('/manager/reports/individual-sales/show', 'ReportsController@individualSalesReportShow');
    Route::get('/manager/reports/individual-sales/pdf', 'ReportsController@individualSalesReportGenerate');
    Route::get('/manager/reports/global-sales/create', 'ReportsController@globalSalesReportCreate');
    Route::get('/manager/reports/global-sales/show', 'ReportsController@globalSalesReportShow');
    Route::get('/manager/reports/global-sales/pdf', 'ReportsController@globalSalesReportGenerate');
    

});

Route::group(['middleware' => 'advisor'], function () {
    Route::get('/advisor/', 'AdvisorController@index');
    Route::get('/advisor/home', 'AdvisorController@index');

    Route::get('/advisor/sales/create', 'SalesController@create');
    Route::get('/advisor/sales/', 'SalesController@index');
    Route::post('/advisor/sales/find-customer/', 'SalesController@find');
    Route::post('/advisor/sales/', 'SalesController@store');
    Route::post('/advisor/sales/update/payment', 'SalesController@updatePaymentStatus');

    Route::get('/advisor/sales/{id}', 'SalesController@show');
    Route::get('/advisor/sales/{id}/edit', 'SalesController@edit');

    Route::get('/advisor/customers/', 'CustomersController@index');
    Route::get('/advisor/customers/create', 'CustomersController@create');
    Route::get('/advisor/customers/{id}', 'CustomersController@show');
    Route::get('/advisor/customers/{customer}/payment-letter', 'CustomersController@paymentLetterIndex');
    Route::get('/advisor/customers/{customer}/payment-letter-get', 'CustomersController@paymentLetterGet');
    Route::post('/advisor/customers/', 'CustomersController@store');
    Route::post('/advisor/customers/update/contact', 'CustomersController@updateContact');
    Route::post('/advisor/customers/search/', 'CustomersController@search');

    Route::get('/advisor/reports/', 'ReportsController@index');
    Route::get('/advisor/reports/create', 'ReportsController@create');
    Route::get('/advisor/reports/individual-sales/create', 'ReportsController@individualSalesReportCreate');
    Route::get('/advisor/reports/individual-sales/show', 'ReportsController@individualSalesReportShow');
    Route::get('/advisor/reports/individual-sales/pdf', 'ReportsController@individualSalesReportGenerate');

    Route::get('/advisor/refunds/', 'RefundsController@index');
    Route::get('/advisor/refunds/create', 'RefundsController@create');
    Route::get('/advisor/refunds/{refund}', 'RefundsController@show');
    Route::post('/advisor/refunds/', 'RefundsController@store');

});
