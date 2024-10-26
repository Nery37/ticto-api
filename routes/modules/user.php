<?php

declare(strict_types=1);

use App\Enums\RoleEnum;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('user-info', [UsersController::class, 'userInfo'])->name('user-info');

Route::group(['prefix' => 'user', 'middleware' => ['role:' . RoleEnum::ADMINISTRATOR->value]], function () {
    Route::get('', [UsersController::class, 'index'])->name('user-list');
    Route::get('{id}', [UsersController::class, 'show'])->name('user-show');
    Route::post('', [UsersController::class, 'storeUser'])->name('user-store');
    Route::put('{id}', [UsersController::class, 'updateUser'])->name('user-update');
    Route::delete('{id}', [UsersController::class, 'destroy'])->name('user-delete');
});
