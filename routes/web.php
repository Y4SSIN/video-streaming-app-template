<?php

use App\Http\Controllers\UploadVideoController;
use App\Http\Controllers\VideoController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// If the application needs authentication for the videos and/or channels, then make sure to add it to the middleware below.

Route::resource('channels', 'ChannelController');

Route::get('videos/{video}', [VideoController::class, 'show']);
Route::put('videos/{video}', [VideoController::class, 'updateViews']);

// We make sure that all these routes need authentication first before they can be visited.

Route::middleware(['auth'])->group(function () {
    Route::post('channels/{channel}/videos', [UploadVideoController::class, 'store']);
    Route::get('channels/{channel}/videos', [UploadVideoController::class, 'index'])->name('channel.upload');
    Route::resource('channels/{channel}/subscriptions', 'SubscriptionController')->only(['store', 'destroy']);
});