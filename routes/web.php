<?php

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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\PurchaseController;
use App\Http\Controllers\admin\SupplierController;
use App\Http\Controllers\admin\TaxController;
use App\Http\Controllers\admin\SaleController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;


Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
    Route::group(['middleware' => 'auth'], function () {
	Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');


    //category
    Route::resource('category', CategoryController::class);
    Route::post('/category-get-data', [CategoryController::class, 'getData'])->name('category.get-data');
    Route::get('/category/destroy/{categoryId}', [CategoryController::class, 'destroy'])->name('category.delete');

    //sub-category
    Route::get('/sub-category/index', [SubCategoryController::class, 'index'])->name('sub-category.index');
    Route::post('/sub-category-get-data', [SubCategoryController::class, 'getData'])->name('subCategory.get-data');
    Route::get('/sub-category/destroy/{category}', [SubCategoryController::class, 'destroy'])->name('sub-category.destroy');
    Route::get('/sub-category/create', [SubCategoryController::class, 'create'])->name('sub-category.create');
    Route::post('/sub-category/store', [CategoryController::class, 'store'])->name('sub-category.store');
    Route::get('/sub-category/edit/{categoryId}', [SubCategoryController::class, 'edit'])->name('sub-category.edit');
    Route::post('/sub-category/update', [SubCategoryController::class, 'update'])->name('sub-category.update');

    //customer
    Route::resource('customer', CustomerController::class);
    Route::post('/customer-get-data', [CustomerController::class, 'getData'])->name('customer.get-data');
    Route::get('/customer/destroy/{customer}', [CustomerController::class, 'destroy'])->name('customer.delete');

    //supplier
    Route::resource('supplier', SupplierController::class);
    Route::post('/supplier-get-data', [SupplierController::class, 'getData'])->name('supplier.get-data');
    Route::any('/supplier/del/{supplier}', [SupplierController::class, 'destroy'])->name('supplier.delete');

    //product
    Route::resource('product', ProductController::class);
    Route::post('/product-get-data', [ProductController::class, 'getData'])->name('product.get-data');
    Route::get('/product/destroy/{product}', [ProductController::class, 'destroy'])->name('product.delete');
    Route::get('/get-subcategories/{category}', [ProductController::class, 'getSubcategories'])->name('get-subcategories');

    //tax
    Route::resource('tax', TaxController::class);
    Route::post('/tax-get-data', [TaxController::class, 'getData'])->name('tax.get-data');
    Route::get('/tax/destroy/{tax}', [TaxController::class, 'destroy'])->name('tax.delete');
    Route::post('/tax/update/{id}', [TaxController::class, 'update']);

    //manage-purchase
    Route::resource('manage-purchase', PurchaseController::class);
    Route::post('/manage-purchase-get-data', [PurchaseController::class, 'getData1'])->name('manage-purchase.get-data');
    Route::get('/manage-purchase/destroy/{product}', [PurchaseController::class, 'destroy'])->name('manage-purchase.delete');
    Route::post('/update-product-data', [PurchaseController::class, 'updateProducts']);
    Route::get('/purchase', [PurchaseController::class, 'index2'])->name('purchase.index');
    Route::post('/purchase-get-data', [PurchaseController::class, 'getData'])->name('purchase.get-data');

    //manage-sale
    Route::resource('manage-sale', SaleController::class);
    Route::post('/manage-sale-get-data', [SaleController::class, 'getData1'])->name('manage-sale.get-data');
    Route::get('/manage-sale/destroy/{product}', [SaleController::class, 'destroy'])->name('manage-sale.delete');
    Route::post('/update-product-data', [SaleController::class, 'updateProducts']);
    Route::get('/sale', [SaleController::class, 'index2'])->name('sale.index');
    Route::post('/sale-get-data', [SaleController::class, 'getData'])->name('sale.get-data');
    Route::get('/get-sub-categories/{categoryId}', [SaleController::class, 'subCategory']);
    Route::get('/get-products/{subCategoryId}', [SaleController::class, 'product']);

    //setting
    Route::resource('setting', SettingController::class);
    Route::get('/setting/destroy/{product}', [SettingController::class, 'destroy'])->name('setting.delete');
    Route::get('setting-get-data', [SettingController::class, 'getData'])->name('setting.get-data');

    //report
    Route::get('sale-index-report', [SaleController::class, 'reportIndex'])->name('saleReport.index');
    Route::post('sale-report', [SaleController::class, 'report'])->name('sale.report');
    Route::get('purchase-index-report', [PurchaseController::class, 'reportIndex'])->name('purchaseReport.index');
    Route::post('purchase-report', [PurchaseController::class, 'report'])->name('purchase.report');
    Route::get('purchase-show/{purchaseId}', [PurchaseController::class, 'invoice'])->name('purchase.show');
    Route::get('sale-show/{saleId}', [SaleController::class, 'invoice'])->name('sale.show');
    Route::post('/sale-quantity', [SaleController::class, 'quantity'])->name('sale.quantity');

    Route::get('purchase-due/{purchaseId}', [PurchaseController::class, 'dueDetail'])->name('purchase.due');
    Route::get('sale-due/{saleId}', [SaleController::class, 'dueDetail'])->name('sale.due');

	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::post('/users-get-data', [UserController::class, 'getData'])->name('users.get-data');
    Route::post('/roles-get-data', [RoleController::class, 'getData'])->name('roles.get-data');
});
