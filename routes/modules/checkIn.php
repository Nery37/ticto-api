<?php

declare(strict_types=1);

use App\Enums\RoleEnum;
use App\Http\Controllers\Api\UserCheckInsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'check-in'], function () {
    Route::get('', [UserCheckInsController::class, 'indexSubordinateCheckIns'])
    ->middleware(['role:' . RoleEnum::ADMINISTRATOR->value])
    ->name('check-in-list');
    Route::post('', [UserCheckInsController::class, 'storeCheckIn'])->name('check-in-store');
    Route::get('/today', [UserCheckInsController::class, 'getUserCheckInsToday'])->name('check-in-today');
});
