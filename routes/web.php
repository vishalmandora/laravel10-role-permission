<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('loginas/{id}', function ($id) {
    auth()->loginUsingId($id);

    return redirect('/');
});

Route::get('logout', function () {
    auth()->logout();

    return redirect('/');
});

Route::get('login', function () {
    //Trick laravel to have fake login route
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('companies', App\Http\Controllers\CompanyController::class);
    Route::resource('employers', App\Http\Controllers\EmployerController::class);
    Route::resource('campaigns', App\Http\Controllers\CampaignController::class);
//    Route::resource('message-templates', App\Http\Controllers\MessageTemplateController::class);
    Route::get('teams', App\Http\Controllers\TeamController::class);
    Route::get('unlocked-contacts', App\Http\Controllers\UnlockedContactController::class);

    Route::get('users', App\Http\Controllers\UserController::class);
    Route::get('business-owners', [App\Http\Controllers\UserController::class, 'owners']);
    Route::get('business-users', [App\Http\Controllers\UserController::class, 'users']);

    Route::get('roles', App\Http\Controllers\RoleController::class);
    Route::get('permissions', App\Http\Controllers\PermissionController::class);
});
