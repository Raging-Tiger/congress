<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'login'])->name('home');

Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index']);

Route::get('/notifications/add', [App\Http\Controllers\NotificationController::class, 'create']);
Route::post('/notifications/add', [App\Http\Controllers\NotificationController::class, 'create']);
Route::match(['get', 'post'],'/notifications/added', [App\Http\Controllers\NotificationController::class, 'store']);
Route::post('/notifications/edit/{id}', [App\Http\Controllers\NotificationController::class, 'edit']);
Route::get('/notifications/edit/{id}', [App\Http\Controllers\NotificationController::class, 'edit']);
Route::match(['get', 'post'],'/notifications/edited', [App\Http\Controllers\NotificationController::class, 'update']);
Route::match(['get', 'post'], '/notifications/delete', [App\Http\Controllers\NotificationController::class, 'destroy']);

Route::get('/lang/{locale}', LanguageController::class);

Route::get('/events/create', [App\Http\Controllers\EventController::class, 'create']);
Route::post('/events/create', [App\Http\Controllers\EventController::class, 'create']);
Route::match(['get', 'post'],'/events/added', [App\Http\Controllers\EventController::class, 'store']);
Route::get('/events/manage', [App\Http\Controllers\EventController::class, 'index']);


Route::match(['get', 'post'],'/billing_plans', [App\Http\Controllers\BillingPlanController::class, 'index']);
Route::get('/billing_plans/create', [App\Http\Controllers\BillingPlanController::class, 'create']);
Route::post('/billing_plans/create', [App\Http\Controllers\BillingPlanController::class, 'create']);
Route::match(['get', 'post'],'/billing_plans/added', [App\Http\Controllers\BillingPlanController::class, 'store']);