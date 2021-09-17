<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\FoobarController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\PageLayoutController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\UserInterfaceController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Auth\ChangePasswordController;

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

// Main Page Route
// Route::get('/', [DashboardController::class,'dashboardEcommerce'])->name('dashboard-ecommerce')->middleware('role:user');
Route::get('/', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics');

Auth::routes(['verify' => true]);

Route::middleware('role:administrator')->group(function () {
  Route::get('user/data-list', [UserController::class, 'dataList'])->name('user.data.list');
  Route::get('user/{user}/change-password', [UserController::class, 'changePassword'])->name('user.change.password');
  Route::post('user/{user}/change-password-store', [UserController::class, 'changePasswordStore'])->name('user.change.password.store');

  Route::resource('user', UserController::class);

  Route::get('change-password', [ChangePasswordController::class, 'index'])->name('change-password.index');
  Route::put('change-password', [ChangePasswordController::class, 'change'])->name('change-password.store');
});
