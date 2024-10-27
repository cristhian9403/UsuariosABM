<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Controllers\UsersController;
use App\Http\Controllers\FileDownloadController;




Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::group(['middleware' => ['auth', 'role:admin']], function () {

    Route::get('users', UsersController::class)
        ->name('users');
    Route::get('/download-file/{path}', [FileDownloadController::class, 'downloadFile'])
        ->where('path', '.*')
        ->name('download.file');


});
Route::group(['middleware' => ['auth']], function () {
    Route::DELETE('/delete-user/{user}', [UsersController::class, 'deleteUser']);
});






require __DIR__ . '/auth.php';
