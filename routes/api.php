<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthCheckController;
use Illuminate\Support\Facades\Route;

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

Route::get('/health-check', [HealthCheckController::class, 'check']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
});

Route::middleware('authenticate')->group(function () {
    require 'modules/checkIn.php';
    require 'modules/user.php';

    Route::get('/address/{zipCode}', [AddressController::class, 'getAddressByZipCode']);
});

Route::any('/{any}', function () {
    return response()->json(['message' => 'Invalid router'], 404);
})->where('any', '.*');
