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

/* Main page (index) route */
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'login'])->name('home');

/* Notification routes */
Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index']);
Route::get('/notifications/add', [App\Http\Controllers\NotificationController::class, 'create']);
Route::post('/notifications/add', [App\Http\Controllers\NotificationController::class, 'create']);
Route::match(['get', 'post'],'/notifications/added', [App\Http\Controllers\NotificationController::class, 'store']);
Route::post('/notifications/edit/{id}', [App\Http\Controllers\NotificationController::class, 'edit']);
Route::get('/notifications/edit/{id}', [App\Http\Controllers\NotificationController::class, 'edit']);
Route::match(['get', 'post'],'/notifications/edited', [App\Http\Controllers\NotificationController::class, 'update']);
Route::match(['get', 'post'], '/notifications/delete', [App\Http\Controllers\NotificationController::class, 'destroy']);

/* Localization route */
Route::get('/lang/{locale}', LanguageController::class);

/* Event routes */
Route::get('/events/create', [App\Http\Controllers\EventController::class, 'create']);
Route::post('/events/create', [App\Http\Controllers\EventController::class, 'create']);
Route::match(['get', 'post'],'/events/added', [App\Http\Controllers\EventController::class, 'store']);
Route::get('/events', [App\Http\Controllers\EventController::class, 'index']);
Route::get('/events/manage', [App\Http\Controllers\EventController::class, 'admin_index']);
Route::get('/events/{id}', [App\Http\Controllers\EventController::class, 'show']);
Route::match(['get', 'post'],'/events/{id}/register', [App\Http\Controllers\EventController::class, 'register']);
Route::match(['get', 'post'],'/events/{id}/register/added', [App\Http\Controllers\EventController::class, 'storeRegistration']);


/* Billing plan routes */
Route::match(['get', 'post'],'/billing_plans', [App\Http\Controllers\BillingPlanController::class, 'index']);
Route::get('/billing_plans/create', [App\Http\Controllers\BillingPlanController::class, 'create']);
Route::post('/billing_plans/create', [App\Http\Controllers\BillingPlanController::class, 'create']);
Route::match(['get', 'post'],'/billing_plans/added', [App\Http\Controllers\BillingPlanController::class, 'store']);

/* Bills routes */
Route::get('/bills', [App\Http\Controllers\BillController::class, 'index']);
Route::match(['get', 'post'], '/bills/download', [App\Http\Controllers\BillController::class, 'downloadInvoice']);
Route::match(['get', 'post'],'/upload_confirmation', [App\Http\Controllers\BillController::class, 'uploadConfirmation']);
Route::match(['get', 'post'],'/bills/manage', [App\Http\Controllers\BillController::class, 'adminIndex']);
Route::match(['get', 'post'],'/bills/manage/payment/{id}', [App\Http\Controllers\BillController::class, 'displayPayment']);
Route::match(['get', 'post'],'/bills/manage/edit/{id}', [App\Http\Controllers\BillController::class, 'edit']);
Route::match(['get', 'post'],'/bills/manage/edit/{id}/save', [App\Http\Controllers\BillController::class, 'update']);

Route::get('/articles', [App\Http\Controllers\ArticleController::class, 'index']);
Route::match(['get', 'post'],'/articles/{id}/upload', [App\Http\Controllers\ArticleController::class, 'uploadArticle']);
Route::match(['get', 'post'],'/articles/upload/added', [App\Http\Controllers\ArticleController::class, 'storeArticle']);
//Route::match(['get', 'post'],'/article_upload_confirmation/{id}', [App\Http\Controllers\ArticleController::class, 'uploadConfirmation']);


Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
Route::post('/users',[App\Http\Controllers\UserController::class, 'search']);
Route::match(['get', 'post'],'/users/{id}',[App\Http\Controllers\UserController::class, 'edit']);
Route::match(['get', 'post'],'/users/{id}/save', [App\Http\Controllers\UserController::class, 'update']);
