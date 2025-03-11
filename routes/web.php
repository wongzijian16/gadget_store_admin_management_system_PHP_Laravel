<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\XmlController;
use App\Services\GmailService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('userblade/adminlogin');
});

Route::get('/adminregisterpage', [UserController::class, 'adminregisterpage'])->middleware('adminLoggedChecking');
Route::post('/registernewAdmin', [UserController::class, 'registernewAdmin'])->name('registernewAdmin');
Route::get('/adminmainpage', [UserController::class, 'adminmainpage'])->middleware('adminAuthentication');
Route::get('/customerpage', [UserController::class, 'customerpage'])->middleware('adminAuthentication');
Route::get('/adminloginpage', [UserController::class, 'adminloginpage'])->middleware('adminLoggedChecking');
Route::post('/adminloginfunction', [UserController::class, 'adminloginfunction'])->name('adminloginfunction');
Route::post('/adminprofileupdate', [UserController::class, 'adminprofileupdate'])->name('adminprofileupdate');
Route::get('/editprofile', [UserController::class, 'editprofile'])->name('editprofile');
Route::get('/profile', [UserController::class, 'profile']);
Route::post('/updatepassword', [UserController::class, 'updatepassword']);
Route::get('/changepassword', [UserController::class, 'changepassword']);
Route::get('/editprofile1', [UserController::class, 'editprofile1'])->name('editprofile1');
Route::get('/profile1', [UserController::class, 'profile1']);
Route::get('/changepassword1', [UserController::class, 'changepassword1']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/readLog', [UserController::class, 'readLog'])->name('readLog');
Route::post('/renderUserLogRecords', [UserController::class, 'renderUserLogRecords'])->name('renderUserLogRecords');
Route::get('/adminmainpage1', [ProviderController::class, 'adminmainpage1']);
Route::get('/customerpage1', [ProviderController::class, 'customerpage1']);

Route::get('/readUser', [UserManagementController::class, 'readUser'])->middleware('adminAuthentication');
Route::get('/editUserForm/{id}', [UserManagementController::class, 'editUserForm']);
Route::post('/editUserDetail', [UserManagementController::class, 'editUserDetail'])->name('editUserDetail');
Route::get('/deleteuser/{id}', [UserManagementController::class, 'deleteuser']);

Route::get('/auth/{provider}/redirect',[ProviderController::class, 'redirect']);
Route::get('/auth/{provider}/callback',[ProviderController::class, 'callback']);

Route::get('/products/create', [ProductController::class, 'create'])->name('products.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::get('products/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products', [ProductController::class, 'update'])->name('products.update');
Route::get('/product-menu', [ProductController::class, 'productMenu'])->name('products.menu');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


Route::resource('products', ProductController::class);



Route::get('/auth/gmail', function (GmailService $gmailService) {
    return redirect($gmailService->getAuthUrl());
});

Route::get('/callback', function (GmailService $gmailService) {
    $code = request('code');
    $gmailService->authenticate($code);
    return redirect()->back();
});

Route::post('/purchaseHistory', [XmlController::class, 'transform'])->name('transform');

Route::get('/cart/goToCart', function () {return view('cartUI');});
Route::get('/product/{name}', [ProductController::class, 'getPrice']);

Route::get('/product', function () {return view('product');});
Route::get('/orderUI', function () {return view('orderUI');});
Route::get('/paymentUI', function () {return view('paymentUI');});
Route::get('/purchaseHistory', function () {return view('purchaseHistory');});
Route::get('/checkoutUI', function () {return view('checkoutUI');});

Route::post('/product', [ItemController::class, 'incrementItemQty'])->name('addItemToCart');

Route::post('/cartUI', [ItemController::class, 'heldOrder'])->name('heldOrder');
Route::post('/cart/increaseQty/{id}', [ItemController::class, 'incrementItemQty'])->name('increaseQty');
Route::post('/cartUI/decreaseQty', [ItemController::class, 'decrementItemQty'])->name('decreaseQty');
Route::post('/cartUI/removeItemFromCart', [ItemController::class, 'removeItemFromCart'])->name('removeItemFromCart');

Route::post('/orderUI', [ItemController::class, 'showOrder'])->name('showOrder');

Route::post('/paymentUI/select', [ItemController::class, 'selectPaymentMethod'])->name('selectPaymentMethod');
Route::post('/paymentUI/make', [ItemController::class, 'makePayment'])->name('makePayment');
Route::post('/paymentUI/toggleEmailSender', [ItemController::class, 'toggleButton'])->name('toggleButton');