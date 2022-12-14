<?php

use App\Http\Controllers\api\ClienteController;
use App\Http\Controllers\WebhooksController;
use Illuminate\Http\Request;
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
Route::get('/login/{game}/{email}', [ClienteController::class, 'check'])->name('check');
Route::get('/login/{game}/{user}/{email}', [ClienteController::class, 'checkPerUser'])->name('check.peruser');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('/{method}/{game}/{iduser}', [WebhooksController::class, 'index'])->name('webhooks.index');

