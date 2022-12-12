<?php

use App\Http\Controllers\ClientBotsController;
use App\Http\Controllers\GameBotsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagement;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('games', GameBotsController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);

// Route::resource('users', UserManagement::class)
//     ->only(['index', 'store'])
//     ->middleware(['auth', 'verified']);

Route::resource('clientes', ClientBotsController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);
Route::middleware('auth')->group(function () {

    Route::get('/users', [UserManagement::class, 'index'])->name('users.index');
    Route::post('/users', [UserManagement::class, 'store'])->name('users.store');
    Route::post('/users/edit/{id}', [UserManagement::class, 'edit'])->name('users.edit');
    Route::get('/users/show/{id}', [UserManagement::class, 'show'])->name('users.show');
    Route::post('/users/update/{id}', [UserManagement::class, 'update'])->name('users.update');
    Route::post('/users/delete/{id}', [UserManagement::class, 'delete'])->name('users.delete');
    Route::get('/users/games/{id}', [UserManagement::class, 'destroy'])->name('users.destroy');
    Route::get('/users/clientes/{id}', [UserManagement::class, 'clientes'])->name('users.clientes');

    Route::get('/user/bots/{id}', [UserManagement::class, 'games'])->name('user.bots');
    Route::get('/user/nogameuser/{id}', [UserManagement::class, 'getGamesofUserNoHave'])->name('user.games.nobots');
    Route::get('/user/gamesuser/{id}', [UserManagement::class, 'games'])->name('user.games.bots');
    Route::post('/user/storegametouser', [UserManagement::class, 'storeGameToUser'])->name('user.games.store');
    Route::post('/user/deletegameuser/{id}', [UserManagement::class, 'deleteGameToUser'])->name('user.games.delete');



    Route::get('/user/webhooks/{id}', [UserManagement::class, 'getWebHooks'])->name('user.webhooks');
    Route::post('/user/webhooks/store', [UserManagement::class, 'storeWebHook'])->name('user.webhook.store');
    Route::post('/user/webhook/delete/{id}', [UserManagement::class, 'deleteWebHook'])->name('user.webhook.delete');


    Route::post('/client/new', [ClientBotsController::class, 'store'])->name('client.store');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
