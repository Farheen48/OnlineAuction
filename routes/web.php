<?php

use App\Http\Controllers\DashboardController\AdminCrontroller;
use App\Http\Controllers\DashboardController\SellerController;
use App\Http\Controllers\DashboardController\UserController;
use App\Http\Controllers\GeneralController\SiteController;
use App\Http\Controllers\LoginController\AdminLoginController;
use App\Http\Controllers\Signup\SellerSingup;
use App\Http\Controllers\Signup\UserSignup;
use App\Http\Middleware\ActiveItemForBid;
use App\Http\Middleware\AdminDashboardAccessVerify;
use App\Http\Middleware\AdminDashboardTokenVerify;
use App\Http\Middleware\LoginRerouteIfExistsAcces;
use App\Http\Middleware\SellerDahboardAccessverify;
use App\Http\Middleware\VerifyUserIPAndLocation;
use Illuminate\Support\Facades\Route;

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

/* Site controller */
Route::get('/',[SiteController::class,'Index'])->name('welcome');
Route::get('/running-bids',[SiteController::class, 'RunningBidlist'])->name('running.bids');
Route::prefix('login')->group(function(){
    Route::middleware([LoginRerouteIfExistsAcces::class])->group(function(){
        Route::get('/', [SiteController::class, 'Login'])->name('login');
        Route::post('/verify', [SiteController::class, 'LoginVerify'])->name('login.verify');
    });
    Route::middleware([AdminDashboardTokenVerify::class])->group(function(){
        Route::prefix('admin')->group(function () {
            Route::get('/', [SiteController::class, 'AdminLogin'])->name('admin.login');
            Route::get('/verify', [AdminLoginController::class, 'VerifyAdmin'])->name('verify');
            Route::get('/verify/otp', [AdminLoginController::class, 'VerifyAdminOTP'])->name('verify.OTP');
            Route::get('/otp/submit', [AdminLoginController::class, 'ValidateOTP'])->name('submit.OTP');
        });
    });
});
Route::prefix('singup')->group(function(){
    Route::get('on/system',[SiteController::class,'SignUpFormView'])->name('signup.form');
    Route::post('on/system/seller/register', [SellerSingup::class, 'SingupFormSellerRegistration'])->name('signup.form_seller');
    Route::post('on/system/user/register', [UserSignup::class, 'SingupFormUserRegistration'])->name('signup.form_user');
});
Route::middleware([AdminDashboardAccessVerify::class])->group(function(){
    Route::prefix('admin/dashboard')->group(function(){
        Route::get('/', [AdminCrontroller::class, 'ViewDashboard'])->name('admin.dashboard');
        Route::post('/post', [AdminCrontroller::class, 'UpdateMockLocation'])->name('update.mocklocation');
        Route::prefix('seller/list')->group(function () {
            Route::get('/', [AdminCrontroller::class, 'SellerList'])->name('seller.list');
            Route::get('/update/status', [AdminCrontroller::class, 'SellerListStatusUpdate'])->name('update.status');
        });
        Route::prefix('category/list')->group(function () {
            Route::get('/', [AdminCrontroller::class, 'CategoryList'])->name('view.category_list');
            Route::post('/insert', [AdminCrontroller::class, 'CategoryListInsert'])->name('insert.category_list');
            Route::get('/status', [AdminCrontroller::class, 'CategoryListStaus'])->name('status.category_list');
        });
        Route::prefix('bid-request')->group(function(){
            Route::get('/', [AdminCrontroller::class, 'BidReqSeller'])->name('bid.req');
            Route::get('/view', [AdminCrontroller::class, 'ViewBidReq'])->name('bid.view-req');
            Route::post('/submit-biding-permit', [AdminCrontroller::class, 'SetItemPermitedForBidding'])->name('bid.view-req-submit');
            Route::get('/update-biding-permit', [AdminCrontroller::class, 'UpdateBiding'])->name('update.bid-status');
        });
        Route::get('/bid-close', [AdminCrontroller::class, 'MakeBidClosed'])->name('make.bid_closed');
    });
});
Route::middleware([SellerDahboardAccessverify::class])->group(function(){
    Route::prefix('seller/dashboard')->group(function(){
        Route::get('/', [SellerController::class, 'SellerDashbaord'])->name('seller.dashboard');
            Route::prefix('register/product')->group(function () {
                Route::get('/', [SellerController::class, 'RegisterProductList'])->name('product_reg.lit_seller');
                Route::post('/submit', [SellerController::class, 'SubmitRegisterProductList'])->name('submit_product_reg.lit_seller');
            });
            Route::prefix('registered-product')->group(function(){
                Route::get('/',[SellerController::class,'ViewRegisteredProduct'])->name('registered.product');
                Route::prefix('request-for-auction')->group(function(){
                    Route::get('/', [SellerController::class, 'ViewRequestForAuctionForm'])->name('request.for_auction');
                    Route::post('/store', [SellerController::class, 'PostRequestForAuctionForm'])->name('post.for_auction');
                });
            });
    });
    Route::prefix('user/dashboard')->group(function () {
        Route::get('/', [UserController::class, 'UserDashbaord'])->name('user.dashboard');
        Route::prefix('add/balance')->group(function(){
            Route::get('/', [UserController::class, 'AddBalance'])->name('add.balance');
            Route::post('/', [UserController::class, 'RechargeBalance'])->name('recharge.balance');
        });
    });
});

Route::prefix('payment')->group(function(){
    Route::get('/seller/reg',[SellerSingup::class,'RegistrationFee'])->name('seller.registration_payment');
    Route::post('/seller/reg',[SellerSingup::class,'PayRegistrationFee'])->name('pay.reg_bill_seller');
});
Route::middleware([VerifyUserIPAndLocation::class])->group(function(){
    Route::prefix('public-bidding-item')->group(function(){
        Route::middleware([ActiveItemForBid::class])->group(function(){
            Route::get('/details', [SiteController::class, 'BiddingitemDetails'])->name('public_bidding.item_details');
        });
        Route::post('/submit-a-bid-for-item', [UserController::class, 'SubmitABidForItem'])->name('submit_a.bid_item');
    });
});
Route::get('/log/out',[SiteController::class,'LogOut'])->name('logout');

Route::get('/auto-update-bid-to-close',[SiteController::class,'AutoUpdateBidToClosed'])->name('auto.updet_to_close_bid');
