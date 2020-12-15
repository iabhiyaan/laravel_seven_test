<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
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

/**
 * Custom Login and password reset
 */
Route::group([], function () {
   Route::get('login', [LoginController::class, 'login'])->name('login');
   Route::post('postLogin', [LoginController::class, 'postLogin'])->name('postLogin');
   Route::get('password-reset', [PasswordResetController::class, 'resetForm'])->name('password-reset');
   Route::post('send-email-link', [PasswordResetController::class, 'sendEmailLink'])->name('sendEmailLink');
   Route::get('reset-password/{token}', [PasswordResetController::class, 'passwordResetForm'])->name('passwordResetForm');
   Route::post('update-password', [PasswordResetController::class, 'updatePassword'])->name('updatePassword');
   Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::group(
   [
      'prefix' => 'admin',
      'middleware' => 'auth',
   ],
   function () {
      // prefix => admin makes url admin/

      Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

      // User with `role => admin` has access for following controllers

      Route::group(['middleware' => 'role'], function () {
         Route::post('image-process', [PostController::class, 'imageProcess'])->name('imageProcess');
         Route::post('crop-modal', [PostController::class, 'imageCropModal'])->name('imageCropModal');
         Route::post('crop-process', [PostController::class, 'imageCropProcess'])->name('imageCropProcess');
         Route::resources([
            'user' => UserController::class,
            'category' => CategoryController::class,
            'post' => PostController::class,
         ]);
      });
   }
);

Route::get('/', function () {
   return 'home';
})->name('home');
