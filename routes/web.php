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

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


Route::any('/', array(
    "as" => "user.login",
    "uses" => "UserController@home"
));


Route::get('changepassword', function() {
    $user = User::where('username', 'administrator')->first();
    $user->password = Hash::make('123456');
    $user->save();

    echo 'Password changed successfully.';
});

Auth::routes();
/* Routes accessible AFTER logging in */
Route::middleware('auth')->group(function()
{
    Route::any('/home', array(
        "as" => "user.home",
        "uses" => "UserController@homeAction"
    ));

    Route::any('/settings', array(
        "as" => "facility.settings",
        "uses" => "UserController@configureFacilitySettings"
    ));

    Route::get('/connection', array(
        "as" => "facility.connection",
        "uses" => "UserController@testConnection"
    ));

    Route::group(["middleware" => "can:manage_users"], function() {
        Route::resource('user', 'UserController');
        Route::get("/user/{id}/delete", array(
            "as"   => "user.delete",
            "uses" => "UserController@delete"
        ));
    });

    Route::any("/logout", array(
        "as"   => "user.logout",
        "uses" => "UserController@logoutAction"
    ));
    Route::any('/user/{id}/updateown', array(
        "as" => "user.updateOwnPassword",
        "uses" => "UserController@updateOwnPassword"
    ));

    Route::resource('house', 'HouseController');
    Route::resource('housetype', 'HouseTypeController');
    Route::resource('payment', 'PaymentController');
    Route::resource('paymentmethod', 'PaymentMethodController');
    Route::resource('tenant', 'TenantController');
    Route::resource('site', 'SiteController');
    Route::resource('maintenance', 'MaintenanceController');

    Route::any("/summary", array(
        "as"   => "tenant.summary",
        "uses" => "PaymentController@summary"
    ));

    Route::any("/tenant_detail/{id}", array(
        "as"   => "tenant.detail",
        "uses" => "PaymentController@viewTenantDetails"
         ));

    Route::post("/payment/update/{id}", array(
            "as"   => "payment.update",
            "uses" => "PaymentController@updateAmountPaid"
        ));

    Route::get("/payment/{id}/show", array(
        "as"   => "payment.show",
        "uses" => "PaymentController@show"
    ));

    // client Receipt small
        Route::any("/tenantReceipt/{id}/{visit}", array(
            "as" => "tenant.receipt",
            "uses" => "PaymentController@printPaymentReceipt"
        ));

        Route::any("/sendReceipt/{id}/{visit}", array(
            "as" => "tenant.mail",
            "uses" => "PaymentController@sendPaymentReceipt"
        ));


        Route::get('my-demo-mail','PaymentController@myDemoMail');

    //Unhls patient routes end

    Route::any("/instrument/getresult", array(
        "as"   => "instrument.getResult",
        "uses" => "InstrumentController@getTestResult"
    ));

    Route::group(["middleware" => "can:manage_users"], function()
    {
        Route::resource("permission", "PermissionController");
        Route::get("role/assign", array(
            "as"   => "role.assign",
            "uses" => "RoleController@assign"
        ));
        Route::post("role/assign", array(
            "as"   => "role.assign",
            "uses" => "RoleController@saveUserRoleAssignment"
        ));
        Route::resource("role", "RoleController");
        Route::get("/role/{id}/delete", array(
            "as"   => "role.delete",
            "uses" => "RoleController@delete"
        ));
    });
 
        
    });



   

