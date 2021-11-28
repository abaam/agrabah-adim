<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

// GLOBAL ROUTES START
Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin-generate-permissions', function () {
    echo "Generating Spot Market Permission<br>";
    Artisan::call('permission:spot_market');
    return 'Done';
});

Route::get('/registration', 'Controller@registration');

Route::get('qr-reader', 'PublicController@qrReader')->name('qr-reader');
Route::get('sms-test', 'PublicController@smsTest')->name('sms-test');
Route::get('test', 'PublicController@test')->name('test');
Route::get('export', 'PublicController@export')->name('export');


//Auth::routes();
Auth::routes(['verify' => true]);
Route::get('logout', 'UserController@logout')->name('logout');
Route::get('loan-update-status', 'LoanProviderController@loanUpdateStatus')->name('loan-update-status');

Route::middleware(['auth', 'verified', 'has_profile'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('activation', 'PublicController@activation')->name('activation');

    Route::resource('farmer', 'FarmerController');
    Route::resource('community-leader', 'CommunityLeaderController', ['except' => ['destroy']]);
    Route::get('community-leader-destroy/{id}', 'CommunityLeaderController@destroy')->name('community-leader-destroy');
    Route::resource('loan-provider', 'LoanProviderController');

    Route::resource('profile', 'ProfileController');
    Route::get('my-profile', 'ProfileController@myProfile')->name('my-profile');
    Route::get('select-profile', 'ProfileController@selectProfile')->name('select-profile');
    Route::get('get-my-profile', 'ProfileController@getMyProfile')->name('get-my-profile');

    Route::resource('product', 'ProductController');
    Route::get('product-list', 'ProductController@productList')->name('product-list');
    Route::get('product-unit-list', 'ProductController@productUnitList')->name('product-unit-list');
    Route::post('product-store', 'ProductController@productStore')->name('product-store');

    Route::resource('user', 'UserController');
    // Route::get('user-list', 'UserController@userList')->name('user-list');
    Route::get('user-list', 'UserController@userList')->name('user-list');
    Route::get('personnel-info', 'UserController@personnelInfo')->name('personnel-info');
    Route::post('create-user', 'UserController@createUser')->name('create-user');

    Route::get('role', 'RoleController@index')->name('role');
    Route::get('role-show/{id}', 'RoleController@show')->name('role-show');
    Route::post('role-update/{id}', 'RoleController@update')->name('role-update');
    Route::post('add-role', 'RoleController@addRole')->name('add-role');

    Route::post('save_registrant', 'RoleController@saveRegistrant')->name('save-registrant');

    Route::resource('settings', 'SettingController');

//    Route::get('trace-report', 'ReportController@traceReport')->name('trace-report');

    Route::get('trace-report', 'ReportController@traceReport')->name('trace-report');
    Route::get('trace-table-report', 'ReportController@traceTableReport')->name('trace-table-report');

    Route::post('print-report', 'ReportController@printReport')->name('print-report');
    Route::post('print-report-data', 'ReportController@printReportData')->name('print-report-data');

    Route::get('loan/proof/{id}/{filename}', 'LoanController@proofPhoto')->name('loan-proof');
    Route::get('loan/applicants', 'LoanProviderController@loanApplicant')->name('loan-applicant');

    Route::get('loan-update-status', 'LoanProviderController@loanUpdateStatus')->name('loan-update-status');

    Route::get('bfar/settings', 'BfarController@bfarIndex')->name('bfar-settings');
    Route::get('store-user', 'BfarController@storeUser')->name('store-user');
    Route::get('bfar-user-list', 'BfarController@getUser')->name('bfar-user-list');
    Route::get('bfar-get-info', 'BfarController@getBfarInfo')->name('bfar-get-info');
    Route::get('bfar-update-info', 'BfarController@updateBfarInfo')->name('bfar-update-info');


    Route::get('marketplace-categories', 'MarketplaceCategoriesController@index')->name('marketplace-categories.index');
    Route::get('marketplace-categories-list', 'MarketplaceCategoriesController@list')->name('marketplace-categories-list');
    Route::post('marketplace-categories-store', 'MarketplaceCategoriesController@store')->name('marketplace-categories-store');
    Route::post('marketplace-categories-edit', 'MarketplaceCategoriesController@edit')->name('marketplace-categories-edit');
    Route::get('marketplace-categories-delete', 'MarketplaceCategoriesController@delete')->name('marketplace-categories-delete');

    Route::get('market-place/orders', 'MarketplaceController@orders')->name('market-place.orders');
    Route::post('market-place/approve', 'MarketplaceController@approve')->name('market-place.approve');
    Route::post('market-place/deliver', 'MarketplaceController@deliver')->name('market-place.deliver');
    Route::post('market-place/delivered', 'MarketplaceController@delivered')->name('market-place.delivered');
    Route::get('market-place-show/{id}', 'MarketplaceController@show')->name('market-place-show');


    Route::get('reports', 'ReportController@index')->name('reports');

});
// GLOBAL ROUTES END



// ROUTES FOR WHARF

Route::post('wharf-user-registration-store', 'PublicController@wharfUserRegistrationStore')->name('wharf-user-registration-store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('purchase-order', 'PurchaseOrderController');
    Route::resource('spot-market', 'SpotMarketController');
    Route::get('spot-market-cart', 'SpotMarketController@cart')->name('spot-market.cart');
    Route::get('spot-market-my-orders', 'SpotMarketController@myOrders')->name('spot-market.my_orders');
    Route::post('spot-market-add-to-cart', 'SpotMarketController@addToCart')->name('spot-market.add_cart');
    Route::post('spot-market-lock-in-order', 'SpotMarketController@lockInOrder')->name('spot-market.lock_in_order');
    Route::post('spot-market-verify-payment', 'SpotMarketController@verifyPayment')->name('spot-market.verify_payment');

    Route::post('spot-market-post-bid', 'SpotMarketController@postBid')->name('spot-market.post_bid');
    Route::post('spot-market-refresh-bid', 'SpotMarketController@refreshBid')->name('spot-market.refresh_bid');

    Route::get('spot-market-my-bids', 'SpotMarketController@myBids')->name('spot-market.my_bids');
    Route::post('spot-market-make-winner', 'SpotMarketController@makeWinner')->name('spot-market.make_winner');
    Route::get('spot-market-winning-bids', 'SpotMarketController@winningBids')->name('spot-market.winning_bids');
    Route::post('spot-market-complete-bid', 'SpotMarketController@completeBid')->name('spot-market.complete_bid');
});

// ROUTES FOR LOAN


//        Route::get('loan/applicants', 'LoanProviderController@loanApplicant')->name('loan-applicant');
//        Route::get('loan-update-status', 'LoanProviderController@loanUpdateStatus')->name('loan-update-status');

Route::get('loan-registration', 'PublicController@loanRegistration')->name('loan-registration');
Route::post('loan-user-registration-store', 'PublicController@loanUserRegistrationStore')->name('loan-user-registration-store');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('loan-provider/profile/create', 'PublicController@loneProviderProfileCreate')->name('loan-provider-profile-create');
    Route::post('loan-provider/profile/store', 'LoanProviderController@profileStore')->name('loan-provider-profile-store');

    Route::get('farmer/profile/create', 'PublicController@farmerProfileCreate')->name('farmer-profile-create');
    Route::post('farmer/profile/store', 'FarmerController@profileStore')->name('farmer-profile-store');


    Route::post('user-profile-store', 'ProfileController@profileStore')->name('user-profile-store');


});

Route::middleware(['auth', 'verified', 'has_profile'])->group(function () {

    Route::get('loan-provider-dashboard', 'HomeController@loanProviderDashboard')->name('loan-provider-dashboard');
    Route::get('verify-disbursement', 'LoanController@verifyDisbursement')->name('verify-disbursement');

    Route::resource('products', 'LoanProductController');

//        Route::get('loan/product/show', 'FarmerController@loanProductShow')->name('loan-product-show');
    Route::get('loan/product/list', 'FarmerController@loanProductList')->name('loan-product-list');
    Route::get('loan-product-list-get', 'FarmerController@loanProductListGet')->name('loan-product-list-get');
    Route::get('loan-apply', 'FarmerController@loanApply')->name('loan-apply');
    Route::post('loan-submit-form', 'FarmerController@submitLoanApplication')->name('loan-submit-form');

    Route::get('my-loans/', 'LoanController@index')->name('my-loans');
    Route::post('verify-loan', 'LoanController@verify')->name('verify-loan');
    Route::get('generateSchedule', 'LoanController@getPaymentSchedule')->name('generate-schedule');

//        Route::get('loan/applicants', 'LoanProviderController@loanApplicant')->name('loan-applicant');

    Route::get('custom-forms', 'LoanProviderController@customForms')->name('custom-forms');

    Route::get('check-disbursement', 'LoanDisbursementController@getList')->name('check-disbursement');
    Route::post('store-disbursement', 'LoanDisbursementController@storeDisbursement')->name('store-disbursement');


    Route::get('reports/loan', 'ReportController@loanReportIndex')->name('loan-report');
    Route::get('get-loan-report', 'ReportController@loanReportList')->name('get-loan-report');

});


// ROUTES FOR TRACE
Route::get('farmer-check', 'FarmerController@farmerCheck')->name('farmer-check');

Route::get('trace-registration', 'PublicController@traceRegistration')->name('trace-registration');
Route::post('trace-user-registration-store', 'PublicController@traceUserRegistrationStore')->name('trace-user-registration-store');

Route::get('farmer-qr', 'PublicController@farmerQr')->name('farmer-qr');
Route::get('trace-shipped', 'PublicController@traceShipped')->name('trace-shipped');
Route::get('trace-tracking/{code}', 'PublicController@traceTracking')->name('trace-tracking');
Route::get('trace-update-status', 'PublicController@traceUpdate')->name('trace-update-status');
Route::get('trace-info/{code}', 'PublicController@traceInfo')->name('trace-info');


Route::middleware(['auth', 'verified'])->group(function () {

    // FARMER START
    Route::get('farmer-qr-print/{account}', 'FarmerController@farmerQrPrint')->name('farmer-qr-print');
    Route::get('farmers/login', 'FarmerController@farmerLogin')->name('farmer-login');
    Route::post('farmers/login-form', 'FarmerController@farmerLoginForm')->name('farmer-login-form');
    Route::get('farmers-info/{account}', 'FarmerController@farmerInfo')->name('farmers-info');
    Route::get('farmers/inventory-listing/{account}', 'FarmerController@farmerInventory')->name('farmer-inventory-listing');
    Route::get('farmers/inventory/{account}', 'FarmerController@farmerInventory')->name('farmer-inventory');
    // FARMER END

    // FARMER START
    Route::resource('inventory', 'InventoryController');
    Route::get('farmer-inventory-list', 'InventoryController@farmerInventoryList')->name('farmer-inventory-list');
    Route::get('farmer-inventory-list-item', 'InventoryController@farmerInventoryListItem')->name('farmer-inventory-list-item');
    Route::get('inv-listing/{account}', 'InventoryController@farmerInventoryListing')->name('inv-listing');
    Route::post('inv-listing-store', 'InventoryController@inventoryListingStore')->name('inv-listing-store');
    Route::get('inv-listing-delete', 'InventoryController@inventoryListingDelete')->name('inv-listing-delete');
    // FARMER START

    // FARMER START
    Route::resource('trace', 'Trace\TraceController');
    Route::post('trace-store', 'Trace\TraceController@traceStore')->name('trace-store');
    Route::get('trace-qr-print/{reference}', 'Trace\TraceController@traceQrPrint')->name('trace-qr-print');
    // Route::get('trace-shipped/{reference}', 'TraceController@traceShipped')->name('trace-shipped');
    // FARMER START

});





