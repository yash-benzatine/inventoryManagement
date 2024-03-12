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
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;

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
	// Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	// Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	// Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
	// Route::get('/{page}', [PageController::class, 'index'])->name('page');
    Route::resource('category', CategoryController::class);
    Route::post('/category-get-data', [CategoryController::class, 'getData'])->name('category.get-data');
    Route::get('/category/destroy/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Route::resource('sub-category', SubCategoryController::class);
    Route::get('/sub-category/index', [SubCategoryController::class, 'index'])->name('sub-category.index');
    Route::post('/sub-category-get-data', [SubCategoryController::class, 'getData'])->name('subCategory.get-data');
    Route::get('/sub-category/destroy/{category}', [SubCategoryController::class, 'destroy'])->name('sub-category.destroy');
    Route::get('/sub-category/create', [SubCategoryController::class, 'create'])->name('sub-category.create');
    Route::post('/sub-category/store', [CategoryController::class, 'store'])->name('sub-category.store');
    Route::get('/sub-category/edit/{categoryId}', [SubCategoryController::class, 'edit'])->name('sub-category.edit');
    Route::post('/sub-category/update', [SubCategoryController::class, 'update'])->name('sub-category.update');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
