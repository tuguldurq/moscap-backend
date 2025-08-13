<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArtistsController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\PublisherController;
use App\Http\Controllers\Api\EmergencyContactController;
use App\Http\Controllers\Api\ManagerController;
use App\Http\Controllers\Api\HeirController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Admin\ArtistController;
use App\Http\Controllers\Api\SongController;
use App\Http\Controllers\Api\SearchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function (){
    Route::post('/upload', [UploadController::class, 'store']);

    Route::resource('/publishers', PublisherController::class)->only(['store']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);

        Route::resource('emergency', EmergencyContactController::class);
        Route::resource('managers', ManagerController::class);
        Route::resource('heirs', HeirController::class)->only(['store', 'index', 'update']);
        Route::resource('songs', SongController::class);

    });
    
    Route::resource('/news', NewsController::class);

    // admin route
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function(){
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::resource('artists', ArtistController::class)->only(['index', 'show', 'store', 'update']);
        // Route::resource('/admin/artist', ArtistController::class)->only(['store', 'update']);
        Route::get('/admin/users', [App\Http\Controllers\Api\Admin\UserController::class, 'index']);
        
        Route::get('/admin/songs', [App\Http\Controllers\Api\Admin\SongController::class, 'index']);
        Route::post('/admin/songs', [App\Http\Controllers\Api\Admin\SongController::class, 'store']);
        Route::put('/admin/songs/{id}', [App\Http\Controllers\Api\Admin\SongController::class, 'update']);

    });

    Route::get('/repertory', [SearchController::class, 'repertory']);
    Route::get('/repertory/all', [SearchController::class, 'all']);

    Route::prefix('auth')->group(function (){
        Route::post('/login',  [AuthController::class, 'login']);
        Route::post('/artist/signup',  [AuthController::class, 'signupArtist']);
        Route::post('/publisher/signup',  [AuthController::class, 'signupPublisher']);
        Route::post('/update/password', [AuthController::class, 'updatePassword'])->middleware('auth:sanctum');
        Route::post('/forget/password', [AuthController::class, 'forgetPassword']);
        Route::post('/reset/password', [AuthController::class, 'resetPassword'])->name('password.reset');
    });

});
