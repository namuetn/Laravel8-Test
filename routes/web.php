<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChangePass;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    $brands = DB::table('brands')->get();
    $about = DB::table('home_abouts')->first();

    return view('home', compact('brands', 'about'));
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/home', function () {
    echo "This is home page";
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/contact1', [ContactController::class, 'test'])->name('contact1');

// Category Route
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class, 'Edit'])->name('edit.category');
Route::post('/category/update/{id}', [CategoryController::class, 'Update'])->name('update.category');

// Brand Route
Route::get('/brand/all', [BrandController::class, 'AllBrand'])->name('all.brand');
Route::post('/brand/add', [BrandController::class, 'Storebrand'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'Edit'])->name('edit.brand');
Route::post('/brand/update/{id}', [BrandController::class, 'Update'])->name('update.brand');
Route::get('/brand/delete/{id}', [BrandController::class, 'Delete'])->name('update.brand');

// Multi Image Route
Route::get('/multi/image', [BrandController::class, 'Multipic'])->name('multi.image');
Route::post('/multi/add', [BrandController::class, 'StoreImg'])->name('store.image');

// Admin All Route
Route::get('/home/slider', [HomeController::class, 'HomeSlider'])->name('home.slider');
Route::get('/add/slider', [HomeController::class, 'AddSlider'])->name('add.slider');
Route::post('/store/slider', [HomeController::class, 'StoreSlider'])->name('store.slider');
Route::get('/edit/slider/{id}', [HomeController::class, 'EditSlider'])->name('edit.slider');
Route::post('/update/slider/{id}', [HomeController::class, 'UpdateSlider'])->name('update.slider');
Route::get('/delete/slider/{id}', [HomeController::class, 'DeleteSlider'])->name('delete.slider');

// Home About Route
Route::get('/home/about', [AboutController::class, 'HomeAbout'])->name('home.about');
Route::get('/add/about', [AboutController::class, 'AddAbout'])->name('add.about');
Route::post('/store/about', [AboutController::class, 'StoreAbout'])->name('store.about');
Route::get('/edit/about/{id}', [AboutController::class, 'EditAbout'])->name('edit.about');
Route::post('/update/about/{id}', [AboutController::class, 'UpdateAbout'])->name('update.about');
Route::get('/delete/about/{id}', [AboutController::class, 'DeleteAbout'])->name('delete.about');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = User::all();

    return view('admin.index');
})->name('dashboard');

Route::get('/user/logout', [BrandController::class, 'Logout'])->name('user.logout');

// Change Password and user profile
Route::get('/user/password', [ChangePass::class, 'ChangePassword'])->name('change.password');
Route::post('/password/update', [ChangePass::class, 'UpdatePassword'])->name('password.update');
