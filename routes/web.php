<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\SolutionController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::post('/send_inquiry', [PageController::class, 'sendInquiry'])->name('send_inquiry');
Route::get('/terms-of-use', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/about-monotech-systems-limited', [PageController::class, 'monotech'])->name('monotech');
Route::get('/cancellation-or-refund-policy', [PageController::class, 'cancellation'])->name('cancellation');
Route::post('/subscribe', [PageController::class, 'addSubscriber'])->name('subscribe');

Route::get('/generate-invoices', [CronController::class, 'generateInvoices'])->name('generateInvoices');

// Demo Scheduling
Route::get('/demo-scheduling', [DemoController::class, 'create'])->name('demo-schedule-create');
Route::post('/demo-schedule-details/store', [App\Http\Controllers\DemoController::class, 'store'])->name('demo-schedule-store');

// products organisation 
Route::get('/product/razor6',[PageController::class,'razor6'])->name('product-razor6');

// Solutions
Route::get('/solutions/cloud',[SolutionController::class,'cloud'])->name('cloud-solution');




//Scan codes
Route::get('/p/{code}', [ScanController::class, 'show']);

Route::middleware('loggedin')->group(function () {
    Route::get('login', [AuthController::class, 'loginView'])->name('login-view');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('register', [AuthController::class, 'registerView'])->name('register-view');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('register/company-informations', [AuthController::class, 'companyView'])->name('company-view');
    Route::post('register/company-informations', [AuthController::class, 'company'])->name('company');
    Route::post('register/otp', [AuthController::class, 'otp'])->name('otp');
    Route::get('register/otp', [AuthController::class, 'otpView'])->name('otp-view');
    Route::get('register/success', [AuthController::class, 'success'])->name('register-success');
    Route::get('forgot-password', [AuthController::class, 'forgotPasswordView']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
});


Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('vendor/getrecords/credits', [App\Http\Controllers\Vendor\RecordController::class, 'credits']);
});

Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth']], function () {

    Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');

    //Admin Profile
    Route::get('/profile', [App\Http\Controllers\Admin\HomeController::class, 'profile'])->name('admin-profile');
    Route::post('/profile', [App\Http\Controllers\Admin\HomeController::class, 'updateProfile'])->name('admin-update-profile');

    Route::get('/change-password', [App\Http\Controllers\Admin\HomeController::class, 'changePassword'])->name('admin-password');
    Route::post('/change-password', [App\Http\Controllers\Admin\HomeController::class, 'updatePassword'])->name('admin-update-password');
    //End Admin Profile

    //User routes
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin-users');
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin-create-users');
    Route::post('/users/create', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin-store-users');
    Route::get('/users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin-edit-users');
    Route::post('/users/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin-update-user');
    //End user routes

    //Manufacturer routes
    Route::get('/registrations', [App\Http\Controllers\Admin\RegistrationController::class, 'index'])->name('admin-registrations');
    Route::get('/registrations/create', [App\Http\Controllers\Admin\RegistrationController::class, 'create'])->name('admin-create-registrations');
    Route::post('/registrations/create', [App\Http\Controllers\Admin\RegistrationController::class, 'store'])->name('admin-store-registrations');
    Route::get('/registrations/{id}/edit', [App\Http\Controllers\Admin\RegistrationController::class, 'edit'])->name('admin-edit-registrations');
    Route::post('/registrations/{id}/edit', [App\Http\Controllers\Admin\RegistrationController::class, 'update'])->name('admin-update-registrations');
    //End Manufacturer routes

    //Plan routes
    Route::get('/plans', [App\Http\Controllers\Admin\PlanController::class, 'index'])->name('admin-plans');
    Route::get('/plans/create', [App\Http\Controllers\Admin\PlanController::class, 'create'])->name('admin-create-plans');
    Route::post('/plans/create', [App\Http\Controllers\Admin\PlanController::class, 'store'])->name('admin-store-plans');
    Route::get('/plans/{id}/edit', [App\Http\Controllers\Admin\PlanController::class, 'edit'])->name('admin-edit-plans');
    Route::post('/plans/{id}/edit', [App\Http\Controllers\Admin\PlanController::class, 'update'])->name('admin-update-plans');
    Route::post('/plans/{id}/destroy', [App\Http\Controllers\Admin\PlanController::class, 'destroy'])->name('admin-destroy-plans');
    //End Plan routes

    //Offer routes
    Route::get('/offers', [App\Http\Controllers\Admin\OfferController::class, 'index'])->name('admin-offers');
    Route::get('/offers/create', [App\Http\Controllers\Admin\OfferController::class, 'create'])->name('admin-create-offers');
    Route::post('/offers/create', [App\Http\Controllers\Admin\OfferController::class, 'store'])->name('admin-store-offers');
    Route::get('/offers/{id}/edit', [App\Http\Controllers\Admin\OfferController::class, 'edit'])->name('admin-edit-offers');
    Route::post('/offers/{id}/edit', [App\Http\Controllers\Admin\OfferController::class, 'update'])->name('admin-update-offers');
    Route::post('/offers/{id}/destroy', [App\Http\Controllers\Admin\OfferController::class, 'destroy'])->name('admin-destroy-offers');
    //End Offer routes

    //Topup routes
    Route::get('/topups', [App\Http\Controllers\Admin\TopupController::class, 'index'])->name('admin-topups');
    Route::get('/topups/create', [App\Http\Controllers\Admin\TopupController::class, 'create'])->name('admin-create-topups');
    Route::post('/topups/create', [App\Http\Controllers\Admin\TopupController::class, 'store'])->name('admin-store-topups');
    Route::get('/topups/{id}/edit', [App\Http\Controllers\Admin\TopupController::class, 'edit'])->name('admin-edit-topups');
    Route::post('/topups/{id}/edit', [App\Http\Controllers\Admin\TopupController::class, 'update'])->name('admin-update-topups');
    Route::post('/topups/{id}/destroy', [App\Http\Controllers\Admin\TopupController::class, 'destroy'])->name('admin-destroy-topups');
    //End Topup routes

    //Scan History Routes
    Route::get('/scanhistory', [App\Http\Controllers\Admin\ScanController::class, 'index'])->name('admin-scan-history');
    Route::get('/viewscan/{id}', [App\Http\Controllers\Admin\ScanController::class, 'show'])->name('admin-show-scanhistory');

    //Product routes
    Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin-products');
    Route::get('/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin-create-products');
    Route::post('/products/create', [App\Http\Controllers\Admin\ProductController::class, 'store']);
    Route::get('/products/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin-edit-products');
    Route::post('/products/{id}/edit', [App\Http\Controllers\Admin\ProductController::class, 'update']);
    Route::post('/products/{id}/destroy', [App\Http\Controllers\Admin\ProductController::class, 'destroy']);
    //End product routes



    //Code routes
    Route::get('/codes', [App\Http\Controllers\Admin\CodeController::class, 'index'])->name('admin-codes');
    Route::get('/codes/create', [App\Http\Controllers\Admin\CodeController::class, 'create'])->name('admin-create-codes');
    Route::post('/codes/{id}/deactivate', [App\Http\Controllers\Admin\CodeController::class, 'deactivate']);
    Route::post('/codes/create', [App\Http\Controllers\Admin\CodeController::class, 'generate']);
    Route::get('/codes/export', [App\Http\Controllers\Admin\CodeController::class, 'export']);
    Route::get('/codes/mark-exported', [App\Http\Controllers\Admin\CodeController::class, 'markExported']);

    //End code routes

    //Invoice routes
    Route::get('/invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('admin-invoices');
    Route::get('/invoices/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('admin-show-invoices');
    Route::post('/invoice-transaction', [App\Http\Controllers\Admin\InvoiceController::class, 'transaction'])->name('admin-invoice-transaction');
    Route::post('/invoice-remove', [App\Http\Controllers\Admin\InvoiceController::class, 'remove'])->name('admin-invoice-remove');
    Route::get('/download-invoice/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'downloadInvoice'])->name('admin-download-invoice');
    //End Invoice routes

    //Email template routes
    Route::get('/emails', [App\Http\Controllers\Admin\EmailController::class, 'index'])->name('admin-emails');
    //End Email template routes

    //App Reports Routes
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin-reports');
    Route::get('/actreports/{id}', [App\Http\Controllers\Admin\ReportController::class, 'show'])->name('admin-show-reports');
    Route::post('/reports/assign/{id}', [App\Http\Controllers\Admin\ReportController::class, 'assign'])->name('admin-reports-assign');
    //App Reports end

    //Lost Damage Routes
    Route::get('/lost-damage', [App\Http\Controllers\Admin\DamageController::class, 'index'])->name('admin-lost-damage');
    Route::get('/lost-damage/{id}', [App\Http\Controllers\Admin\DamageController::class, 'show'])->name('admin-lost-damage-show');
    //End Lost Damage Routes

    //Alert routes
    Route::get('/alerts', [App\Http\Controllers\Admin\AlertController::class, 'index'])->name('admin-alerts');
    Route::get('/viewalerts/{id}', [App\Http\Controllers\Admin\AlertController::class, 'show'])->name('admin-show-alerts');
    Route::get('/actalerts/{id}', [App\Http\Controllers\Admin\AlertController::class, 'show'])->name('admin-act-alerts');
    Route::post('/alerts/assign/{id}', [App\Http\Controllers\Admin\AlertController::class, 'assign'])->name('admin-alerts-assign');
    //end alert routes

    //Support routes
    Route::get('/support', [App\Http\Controllers\Admin\SupportController::class, 'index'])->name('admin-support');
    Route::get('/support/create', [App\Http\Controllers\Admin\SupportController::class, 'create'])->name('admin-create-support');
    Route::post('/support/create', [App\Http\Controllers\Admin\SupportController::class, 'store'])->name('admin-store-support');
    Route::get('/support/{id}/edit', [App\Http\Controllers\Admin\SupportController::class, 'edit'])->name('admin-edit-support');
    Route::post('/support/{id}/edit', [App\Http\Controllers\Admin\SupportController::class, 'update'])->name('admin-update-support');
    //End Support routes


    //Label Size routes
    Route::get('/label-sizes', [App\Http\Controllers\Admin\LabelSizeController::class, 'index'])->name('admin-label-sizes');
    Route::get('/label-sizes/create', [App\Http\Controllers\Admin\LabelSizeController::class, 'create'])->name('admin-create-label-sizes');
    Route::post('/label-sizes/create', [App\Http\Controllers\Admin\LabelSizeController::class, 'store'])->name('admin-store-label-sizes');
    Route::get('/label-sizes/{id}/edit', [App\Http\Controllers\Admin\LabelSizeController::class, 'edit'])->name('admin-edit-label-sizes');
    Route::post('/label-sizes/{id}/edit', [App\Http\Controllers\Admin\LabelSizeController::class, 'update'])->name('admin-update-label-sizes');
    Route::post('/label-sizes/{id}/destroy', [App\Http\Controllers\Admin\LabelSizeController::class, 'destroy'])->name('admin-destroy-label-sizes');
    //End Label Size routes

    //Material Type routes
    Route::get('/material-types', [App\Http\Controllers\Admin\MaterialTypeController::class, 'index'])->name('admin-material-types');
    Route::get('/material-types/create', [App\Http\Controllers\Admin\MaterialTypeController::class, 'create'])->name('admin-create-material-types');
    Route::post('/material-types/create', [App\Http\Controllers\Admin\MaterialTypeController::class, 'store'])->name('admin-store-material-types');
    Route::get('/material-types/{id}/edit', [App\Http\Controllers\Admin\MaterialTypeController::class, 'edit'])->name('admin-edit-material-types');
    Route::post('/material-types/{id}/edit', [App\Http\Controllers\Admin\MaterialTypeController::class, 'update'])->name('admin-update-material-types');
    Route::post('/material-types/{id}/destroy', [App\Http\Controllers\Admin\MaterialTypeController::class, 'destroy'])->name('admin-destroy-material-types');
    //End Material Type routes

    //Printing cost routes
    Route::get('/printing-cost', [App\Http\Controllers\Admin\PrintingCostController::class, 'index'])->name('admin-printing-cost');
    Route::post('/printing-cost/create', [App\Http\Controllers\Admin\PrintingCostController::class, 'store'])->name('admin-store-printing-cost');
    //End Printing cost routes

    //Qr Label Orders routes
    Route::get('/qr-label-orders', [App\Http\Controllers\Admin\QrLabelController::class, 'index'])->name('admin-qr-label-orders');
    Route::post('/qr-label-orders/{id}/edit', [App\Http\Controllers\Admin\QrLabelController::class, 'update'])->name('admin-update-qr-label-orders');
    Route::get('/qr-label-orders/{id}/show', [App\Http\Controllers\Admin\QrLabelController::class, 'show'])->name('admin-show-qr-label-orders');
    //End QR Label Orders

    //Blog routes
    Route::get('/Blog', [App\Http\Controllers\Admin\BlogController::class, 'index'])->name('admin-blog');
    Route::get('/Blog/Create', [App\Http\Controllers\Admin\BlogController::class, 'create'])->name('admin-blogs-create');
    Route::post('/Blog/store', [App\Http\Controllers\Admin\BlogController::class, 'store'])->name('admin-blogs-store');
    Route::get('/Blogs/{id}/edit', [App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('admin-blogs-edit');
    Route::put('/Blogs/{id}/update', [App\Http\Controllers\Admin\BlogController::class, 'update'])->name('admin-blogs-update');
    //end Blog routes

    // Events routes
    Route::get('/Events', [App\Http\Controllers\Admin\EventController::class, 'index'])->name('admin-events');
    Route::get('/Events/create', [App\Http\Controllers\Admin\EventController::class, 'create'])->name('admin-events-create');
    Route::post('/Events/store', [App\Http\Controllers\Admin\EventController::class, 'store'])->name('admin-events-store');
    Route::get('/Events/{id}/edit', [App\Http\Controllers\Admin\EventController::class, 'edit'])->name('admin-events-edit');
    Route::put('/Events/{id}/update', [App\Http\Controllers\Admin\EventController::class, 'update'])->name('admin-events-update');

    //end Events routes

    //Demo routes
    Route::get('/demo-schedule-details', [App\Http\Controllers\DemoController::class, 'index'])->name('admin-demo-schedule');
});

Route::group(['prefix' => 'vendor', 'middleware' => ['vendor', 'auth']], function () {

    Route::get('/', [App\Http\Controllers\Vendor\HomeController::class, 'index'])->name('vendor');

    Route::get('/profile', [App\Http\Controllers\Vendor\HomeController::class, 'profile'])->name('vendor-profile');
    Route::post('/profile', [App\Http\Controllers\Vendor\HomeController::class, 'updateProfile'])->name('vendor-update-profile');

    Route::get('/change-password', [App\Http\Controllers\Vendor\HomeController::class, 'changePassword'])->name('vendor-password');
    Route::post('/change-password', [App\Http\Controllers\Vendor\HomeController::class, 'updatePassword'])->name('vendor-update-password');

    //Product routes

    Route::get('/products', [App\Http\Controllers\Vendor\ProductController::class, 'index'])->name('vendor-products');
    Route::get('/products/create', [App\Http\Controllers\Vendor\ProductController::class, 'create'])->name('vendor-create-products');
    Route::post('/products/create', [App\Http\Controllers\Vendor\ProductController::class, 'store'])->name('vendor-store-products');
    Route::get('/products/{id}/edit', [App\Http\Controllers\Vendor\ProductController::class, 'edit'])->name('vendor-edit-products');
    Route::post('/products/{id}/edit', [App\Http\Controllers\Vendor\ProductController::class, 'update'])->name('vendor-update-products');
    Route::post('/products/{id}/destroy', [App\Http\Controllers\Vendor\ProductController::class, 'destroy'])->name('vendor-destroy-products');

    //End product routes
    //Product Template routes
    Route::get('/products_template', [App\Http\Controllers\Vendor\ProductTemplateController::class, 'index'])->name('vendor-products-template');
    Route::get('/products_template/create', [App\Http\Controllers\Vendor\ProductTemplateController::class, 'create'])->name('vendor-create-products-template');
    Route::post('/products_template/create', [App\Http\Controllers\Vendor\ProductTemplateController::class, 'store']);
    Route::get('/products_template/{id}/edit', [App\Http\Controllers\Vendor\ProductTemplateController::class, 'edit'])->name('vendor-edit-products-template');
    Route::post('/products_template/{id}/edit', [App\Http\Controllers\Vendor\ProductTemplateController::class, 'update']);
    // Route::post('/products/{id}/destroy', [App\Http\Controllers\Vendor\ProductController::class, 'destroy']);
    //End Template product routes
    //Batch routes

    Route::get('/batches', [App\Http\Controllers\Vendor\BatchController::class, 'index'])->name('vendor-batches');
    Route::get('/batches/create', [App\Http\Controllers\Vendor\BatchController::class, 'create'])->name('vendor-create-batches');
    Route::post('/batches/create', [App\Http\Controllers\Vendor\BatchController::class, 'store'])->name('vendor-store-batches');
    Route::get('/batches/{id}/edit', [App\Http\Controllers\Vendor\BatchController::class, 'edit'])->name('vendor-edit-batches');
    Route::post('/batches/{id}/edit', [App\Http\Controllers\Vendor\BatchController::class, 'update'])->name('vendor-update-batches');
    Route::post('/batches/{id}/destroy', [App\Http\Controllers\Vendor\BatchController::class, 'destroy'])->name('vendor-destroy-batches');

    //End batch routes

    //Aggregation routes

    Route::get('/aggregations', [App\Http\Controllers\Vendor\AggregationController::class, 'index'])->name('vendor-aggregations');
    Route::get('/aggregations/create', [App\Http\Controllers\Vendor\AggregationController::class, 'create'])->name('vendor-create-aggregations');
    Route::post('/aggregations/create', [App\Http\Controllers\Vendor\AggregationController::class, 'store'])->name('vendor-store-aggregations');
    Route::get('/aggregations/{id}/edit', [App\Http\Controllers\Vendor\AggregationController::class, 'edit'])->name('vendor-edit-aggregations');
    Route::post('/aggregations/{id}/edit', [App\Http\Controllers\Vendor\AggregationController::class, 'update'])->name('vendor-update-aggregations');
    Route::post('/aggregations/{id}/destroy', [App\Http\Controllers\Vendor\BatchController::class, 'destroy'])->name('vendor-destroy-aggregations');
    Route::get('/aggregations/{id}', [App\Http\Controllers\Vendor\AggregationController::class, 'show'])->name('vendor-show-aggregations');
    Route::get('/aggregations/{id}/code-data', [App\Http\Controllers\Vendor\AggregationController::class, 'codeData'])->name('vendor-show-aggregations-code');

    //End aggregation routes

    //Code routes

    Route::get('/codes', [App\Http\Controllers\Vendor\CodeController::class, 'index'])->name('vendor-codes');
    Route::get('/codes/create', [App\Http\Controllers\Vendor\CodeController::class, 'create'])->name('vendor-create-codes');
    Route::post('/codes/{id}/deactivate', [App\Http\Controllers\Vendor\CodeController::class, 'deactivate']);
    Route::post('/codes/create', [App\Http\Controllers\Vendor\CodeController::class, 'generate']);
    Route::get('/codes/export', [App\Http\Controllers\Vendor\CodeController::class, 'export']);
    Route::get('/codes/mark-exported', [App\Http\Controllers\Vendor\CodeController::class, 'markExported']);
    Route::post('/codes/action', [App\Http\Controllers\Vendor\CodeController::class, 'action']);
    Route::get('/codes/bulkexport', [App\Http\Controllers\Vendor\CodeController::class, 'bulkexport']);
    Route::post('/getbatches', [App\Http\Controllers\Vendor\CodeController::class, 'getbatches'])->name('vendor-getbatches');
    Route::get('/bulk-upload', [App\Http\Controllers\Vendor\BulkController::class, 'index'])->name('vendor-bulk-upload');
    Route::post('/bulk-upload', [App\Http\Controllers\Vendor\BulkController::class, 'store'])->name('vendor-bulk-upload-store');
    Route::post('/bulk-upload-assign', [App\Http\Controllers\Vendor\BulkController::class, 'assign'])->name('vendor-bulk-upload-assign');
    //End code routes

    //Credit routes
    Route::get('/credits', [App\Http\Controllers\Vendor\CreditController::class, 'index'])->name('vendor-credits');
    Route::get('/credits/{id}', [App\Http\Controllers\Vendor\CreditController::class, 'show'])->name('vendor-show-credits');
    Route::get('/buy-credits', [App\Http\Controllers\Vendor\CreditController::class, 'buy'])->name('vendor-buy-credits');
    Route::get('/payment/{id}', [App\Http\Controllers\Vendor\CreditController::class, 'payment'])->name('vendor-make-payment');
    Route::post('/get-offer', [App\Http\Controllers\Vendor\CreditController::class, 'offer'])->name('vendor-get-offer');
    Route::post('/order', [App\Http\Controllers\Vendor\CreditController::class, 'order'])->name('vendor-order');
    Route::post('/transaction', [App\Http\Controllers\Vendor\CreditController::class, 'transaction'])->name('vendor-transaction');
    //End Credit routes

    //Invoice routes
    Route::get('/invoices', [App\Http\Controllers\Vendor\InvoiceController::class, 'index'])->name('vendor-invoices');
    Route::get('/invoices/{id}', [App\Http\Controllers\Vendor\InvoiceController::class, 'show'])->name('vendor-show-invoices');
    Route::post('/invoice-transaction', [App\Http\Controllers\Vendor\InvoiceController::class, 'transaction'])->name('vendor-invoice-transaction');
    Route::post('/invoice-remove', [App\Http\Controllers\Vendor\InvoiceController::class, 'remove'])->name('vendor-invoice-remove');
    Route::get('/download-invoice/{id}', [App\Http\Controllers\Vendor\InvoiceController::class, 'downloadInvoice'])->name('vendor-download-invoice');
    //End Invoice routes

    //Scan History Routes
    Route::get('/scanhistory', [App\Http\Controllers\Vendor\ScanController::class, 'index'])->name('vendor-scan-history');
    Route::get('/viewscan/{id}', [App\Http\Controllers\Vendor\ScanController::class, 'show'])->name('vendor-show-scanhistory');

    //User routes
    Route::get('/users', [App\Http\Controllers\Vendor\UserController::class, 'index'])->name('vendor-users');
    Route::get('/users/create', [App\Http\Controllers\Vendor\UserController::class, 'create'])->name('vendor-create-users');
    Route::post('/users/create', [App\Http\Controllers\Vendor\UserController::class, 'store']);
    Route::get('/users/{id}/edit', [App\Http\Controllers\Vendor\UserController::class, 'edit'])->name('vendor-edit-users');
    Route::post('/users/{id}/edit', [App\Http\Controllers\Vendor\UserController::class, 'update']);

    //App Reports Routes
    Route::get('/reports', [App\Http\Controllers\Vendor\ReportController::class, 'index'])->name('vendor-reports');
    Route::get('/viewreports/{id}', [App\Http\Controllers\Vendor\ReportController::class, 'show'])->name('vendor-show-reports');
    Route::post('/reports/assign/{id}', [App\Http\Controllers\Vendor\ReportController::class, 'assign'])->name('vendor-reports-assign');
    //App Reports end

    //Alert routes
    Route::get('/alerts', [App\Http\Controllers\Vendor\AlertController::class, 'index'])->name('vendor-alerts');
    Route::get('/viewalerts/{id}', [App\Http\Controllers\Vendor\AlertController::class, 'show'])->name('vendor-show-alerts');
    Route::get('/actalerts/{id}', [App\Http\Controllers\Vendor\AlertController::class, 'show'])->name('vendor-act-alerts');
    Route::post('/alerts/assign/{id}', [App\Http\Controllers\Vendor\AlertController::class, 'assign'])->name('vendor-alerts-assign');
    //end alert routes

    //Lost Damage Routes
    Route::get('/lost-damage', [App\Http\Controllers\Vendor\DamageController::class, 'index'])->name('lost-damage');
    Route::get('/lost-damage/create', [App\Http\Controllers\Vendor\DamageController::class, 'create'])->name('lost-damage-create');
    Route::post('/lost-damage/create', [App\Http\Controllers\Vendor\DamageController::class, 'store'])->name('lost-damage-store');
    Route::get('/lost-damage/{id}', [App\Http\Controllers\Vendor\DamageController::class, 'show'])->name('lost-damage-show');
    Route::post('/check-stamps', [App\Http\Controllers\Vendor\DamageController::class, 'checkStamps'])->name('lost-damage-check-stamps');
    //End Lost Damage Routes

    //Support routes
    Route::get('/support', [App\Http\Controllers\Vendor\SupportController::class, 'index'])->name('vendor-support');
    Route::get('/support/create', [App\Http\Controllers\Vendor\SupportController::class, 'create'])->name('vendor-create-support');
    Route::post('/support/create', [App\Http\Controllers\Vendor\SupportController::class, 'store'])->name('vendor-store-support');
    Route::get('/support/{id}/edit', [App\Http\Controllers\Vendor\SupportController::class, 'edit'])->name('vendor-edit-support');
    Route::post('/support/{id}/edit', [App\Http\Controllers\Vendor\SupportController::class, 'update'])->name('vendor-update-support');
    //End Support routes 

    //Supply Chain Roles routes

    Route::get('/supply-chain-roles', [App\Http\Controllers\Vendor\SupplyChain\RoleController::class, 'index'])->name('vendor-supply-chain-roles');
    Route::get('/supply-chain-roles/create', [App\Http\Controllers\Vendor\SupplyChain\RoleController::class, 'create'])->name('vendor-create-supply-chain-roles');
    Route::post('/supply-chain-roles/create', [App\Http\Controllers\Vendor\SupplyChain\RoleController::class, 'store'])->name('vendor-store-supply-chain-roles');
    Route::get('/supply-chain-roles/{id}/edit', [App\Http\Controllers\Vendor\SupplyChain\RoleController::class, 'edit'])->name('vendor-edit-supply-chain-roles');
    Route::post('/supply-chain-roles/{id}/edit', [App\Http\Controllers\Vendor\SupplyChain\RoleController::class, 'update'])->name('vendor-update-supply-chain-roles');
    Route::post('/supply-chain-roles/{id}/destroy', [App\Http\Controllers\Vendor\SupplyChain\RoleController::class, 'destroy'])->name('vendor-destroy-supply-chain-roles');

    //End Supply Chain Roles routes

    //Supply Chain Users routes

    Route::get('/supply-chain-users', [App\Http\Controllers\Vendor\SupplyChain\UserController::class, 'index'])->name('vendor-supply-chain-users');
    Route::get('/supply-chain-users/create', [App\Http\Controllers\Vendor\SupplyChain\UserController::class, 'create'])->name('vendor-create-supply-chain-users');
    Route::post('/supply-chain-users/create', [App\Http\Controllers\Vendor\SupplyChain\UserController::class, 'store'])->name('vendor-store-supply-chain-users');
    Route::get('/supply-chain-users/{id}/edit', [App\Http\Controllers\Vendor\SupplyChain\UserController::class, 'edit'])->name('vendor-edit-supply-chain-users');
    Route::post('/supply-chain-users/{id}/edit', [App\Http\Controllers\Vendor\SupplyChain\UserController::class, 'update'])->name('vendor-update-supply-chain-users');
    Route::post('/supply-chain-users/{id}/destroy', [App\Http\Controllers\Vendor\SupplyChain\UserController::class, 'destroy'])->name('vendor-destroy-supply-chain-users');
    Route::get('/get-supply-chain-users/{role}', [App\Http\Controllers\Vendor\SupplyChain\UserController::class, 'usersByRole'])->name('vendor-get-supply-chain-users');

    //End Supply Chain Users routes

    //Supply Chain Managements routes
    Route::get('/supply-chain-management', [App\Http\Controllers\Vendor\SupplyChain\ManagementController::class, 'index'])->name('vendor-supply-chain-management');
    Route::get('/supply-chain-management/create', [App\Http\Controllers\Vendor\SupplyChain\ManagementController::class, 'create'])->name('vendor-create-supply-chain-management');
    Route::post('/supply-chain-management/create', [App\Http\Controllers\Vendor\SupplyChain\ManagementController::class, 'store'])->name('vendor-store-supply-chain-management');
    Route::get('/supply-chain-management/{id}/edit', [App\Http\Controllers\Vendor\SupplyChain\ManagementController::class, 'edit'])->name('vendor-edit-supply-chain-management');
    Route::post('/supply-chain-management/{id}/edit', [App\Http\Controllers\Vendor\SupplyChain\ManagementController::class, 'update'])->name('vendor-update-supply-chain-management');
    Route::post('/supply-chain-management/{id}/destroy', [App\Http\Controllers\Vendor\SupplyChain\ManagementController::class, 'destroy'])->name('vendor-destroy-supply-chain-management');
    Route::get('/supply-chain-management/{role}/users', [App\Http\Controllers\Vendor\SupplyChain\ManagementController::class, 'users'])->name('vendor-get-supply-chain-management-users');
    Route::get('/supply-chain-management/{id}/user-data', [App\Http\Controllers\Vendor\SupplyChain\ManagementController::class, 'userData'])->name('vendor-get-supply-chain-management-user-data');
    Route::get('/supply-chain-management/{id}', [App\Http\Controllers\Vendor\SupplyChain\ManagementController::class, 'show'])->name('vendor-show-supply-chain-management');

    //End Supply Chain Managements routes

    //Supply Chain Users routes

    Route::get('/supply-chain-scan-history', [App\Http\Controllers\Vendor\SupplyChain\ScanController::class, 'index'])->name('vendor-supply-chain-scan-history');
    Route::get('/supply-chain-scan-history/{id}', [App\Http\Controllers\Vendor\SupplyChain\ScanController::class, 'show'])->name('vendor-show-supply-chain-scan-history');

    //End Supply Chain Users routes

    //Qr Labels routes

    Route::get('/qr-labels', [App\Http\Controllers\Vendor\QrLabelController::class, 'index'])->name('vendor-qr-labels');
    Route::get('/qr-labels/create', [App\Http\Controllers\Vendor\QrLabelController::class, 'create'])->name('vendor-create-qr-labels');
    Route::post('/qr-labels/create', [App\Http\Controllers\Vendor\QrLabelController::class, 'store'])->name('vendor-store-qr-labels');
    Route::get('/qr-labels/{id}/edit', [App\Http\Controllers\Vendor\QrLabelController::class, 'edit'])->name('vendor-edit-qr-labels');
    Route::post('/qr-labels/{id}/edit', [App\Http\Controllers\Vendor\QrLabelController::class, 'update'])->name('vendor-update-qr-labels');
    Route::post('/qr-labels/{id}/destroy', [App\Http\Controllers\Vendor\QrLabelController::class, 'destroy'])->name('vendor-destroy-qr-labels');
    Route::post('/qr-labels/resources', [App\Http\Controllers\Vendor\QrLabelController::class, 'resources'])->name('vendor-resources-qr-labels');
    Route::get('/qr-labels/{id}/show', [App\Http\Controllers\Vendor\QrLabelController::class, 'show'])->name('vendor-show-qr-labels');
    //End QR Labels

    //Schemes routes
    Route::get('/schemes', [App\Http\Controllers\Vendor\SchemeController::class, 'index'])->name('vendor-schemes');
    Route::get('/schemes/create', [App\Http\Controllers\Vendor\SchemeController::class, 'create'])->name('vendor-create-schemes');
    Route::post('/schemes/create', [App\Http\Controllers\Vendor\SchemeController::class, 'store'])->name('vendor-store-schemes');
    Route::get('/schemes/{id}/edit', [App\Http\Controllers\Vendor\SchemeController::class, 'edit'])->name('vendor-edit-schemes');
    Route::post('/schemes/{id}/edit', [App\Http\Controllers\Vendor\SchemeController::class, 'update'])->name('vendor-update-schemes');
    Route::get('/schemes/{id}/show', [App\Http\Controllers\Vendor\SchemeController::class, 'show'])->name('vendor-show-schemes');
    Route::get('/schemes/{id}/execute', [App\Http\Controllers\Vendor\SchemeController::class, 'execute'])->name('vendor-execute-schemes');
    Route::get('/schemes/{id}/finalize', [App\Http\Controllers\Vendor\SchemeController::class, 'finalize'])->name('vendor-finalize-schemes');

    Route::get('/cashbacks', [App\Http\Controllers\Vendor\CashbackController::class, 'index'])->name('vendor-cashbacks');
    Route::get('/cashbacks/create', [App\Http\Controllers\Vendor\CashbackController::class, 'create'])->name('vendor-create-cashbacks');
    Route::post('/cashbacks/create', [App\Http\Controllers\Vendor\CashbackController::class, 'store'])->name('vendor-store-cashbacks');
    Route::get('/cashbacks/{id}/edit', [App\Http\Controllers\Vendor\CashbackController::class, 'edit'])->name('vendor-edit-cashbacks');
    Route::post('/cashbacks/{id}/edit', [App\Http\Controllers\Vendor\CashbackController::class, 'update'])->name('vendor-update-cashbacks');
    Route::get('/cashbacks/{id}/show', [App\Http\Controllers\Vendor\CashbackController::class, 'show'])->name('vendor-show-cashbacks');
    Route::get('/cashbacks/{id}/execute', [App\Http\Controllers\Vendor\CashbackController::class, 'execute'])->name('vendor-execute-cashbacks');
    Route::get('/cashbacks/{id}/finalize', [App\Http\Controllers\Vendor\CashbackController::class, 'finalize'])->name('vendor-finalize-cashbacks');

    Route::get('/rewards', [App\Http\Controllers\Vendor\RewardController::class, 'index'])->name('vendor-rewards');
    Route::get('/rewards/create', [App\Http\Controllers\Vendor\RewardController::class, 'create'])->name('vendor-create-rewards');
    Route::post('/rewards/create', [App\Http\Controllers\Vendor\RewardController::class, 'store'])->name('vendor-store-rewards');
    Route::get('/rewards/{id}/edit', [App\Http\Controllers\Vendor\RewardController::class, 'edit'])->name('vendor-edit-rewards');
    Route::post('/rewards/{id}/edit', [App\Http\Controllers\Vendor\RewardController::class, 'update'])->name('vendor-update-rewards');
    Route::get('/rewards/{id}/show', [App\Http\Controllers\Vendor\RewardController::class, 'show'])->name('vendor-show-rewards');
    Route::get('/rewards/{id}/download', [App\Http\Controllers\Vendor\RewardController::class, 'download'])->name('vendor-download-rewards');

    Route::get('/reward-orders', [App\Http\Controllers\Vendor\RewardOrderController::class, 'index'])->name('vendor-reward-orders');
    Route::post('/reward-orders/{id}/edit', [App\Http\Controllers\Vendor\RewardOrderController::class, 'update'])->name('vendor-update-reward-orders');
    Route::get('/reward-orders/{id}/show', [App\Http\Controllers\Vendor\RewardOrderController::class, 'show'])->name('vendor-show-reward-orders');

    Route::get('/wallets', [App\Http\Controllers\Vendor\WalletController::class, 'index'])->name('vendor-wallets');
});
