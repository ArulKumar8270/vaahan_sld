<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RegistrationsController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\SubDistributorController;
use App\Http\Controllers\ManufacturerUserController;
use App\Http\Controllers\DistributorUserController;
use App\Http\Controllers\SubDistributorUserController;
use App\Http\Controllers\DealerUserController;
use App\Http\Controllers\DealerController;

// Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1'], function () {

// });
Route::middleware('auth:api')->group( function () {
    // Route::get('category_prompts', [CategoryController::class,'index']);
    //Route::get('contents', [ContentController::class,'index']);
    // Route::post('/logout', [LoginController::class, 'logout']);
});
// Route::middleware('auth:sanctum')->post('/auth/verifyauth', function (Request $request) {
//     return $request->user();
// });

// Routes with middleware 'auth:sanctum'
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/profile/getUser', [UserController::class, 'getUser']);
    Route::get('/getAllUser', [UserController::class, 'index']);
    Route::get('/profile/approveUser', [UserController::class, 'approveUser']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::resource('/distributor', 'DistributorController');
    Route::resource('/subdistributor', 'SubDistributorController');
});

// Custom middleware to handle unauthenticated requests
Route::middleware('auth:sanctum')->get('/unauthenticated', function () {
    return response()->json(['error' => 'Unauthenticated'], 401);
})->name('login');

// Register the default authentication guard
Route::get('/login', function () {
    return response()->json(['error' => 'Unauthenticated'], 401);
})->name('login');

// Routes with middleware 'app:Wlweb'
Route::group(['middleware' => 'app:Vgnweb'], function () {
    Route::post('/auth/register', [LoginController::class, 'register']);
    Route::put('/auth/update/{id}', [LoginController::class, 'update']);
    Route::post('/auth/login', [LoginController::class, 'index']);
    Route::resource('/document', 'DocumentController');
    Route::resource('/registrations', 'RegistrationsController');
    Route::resource('/role', 'RoleController');
});

Route::resource('/transportations', 'TransportationController');
Route::resource('/manufacturerUser', 'ManufacturerUserController');
Route::resource('/distributorUser', 'DistributorUserController');
Route::resource('/subDistributorUser', 'SubDistributorUserController');
Route::resource('/dealerUser', 'DealerUserController');
Route::resource('/dealer', 'DealerController');
Route::post('/reset-pasword', [DealerUserController::class, 'resetPassword']);