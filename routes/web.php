<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: application/json');

use App\Http\Controllers\ClientBotsController;
use App\Http\Controllers\DashboardController;
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
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return view('auth.login');
});

Route::resource('games', GameBotsController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified' , 'can:admin']);

Route::resource('clientes', ClientBotsController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);
Route::middleware('auth')->group(function () {

    Route::get('/users', [UserManagement::class, 'index'])->middleware('can:admin')->name('users.index');
    Route::post('/users', [UserManagement::class, 'store'])->name('users.store');
    Route::post('/users/edit/{id}', [UserManagement::class, 'edit'])->name('users.edit');
    Route::get('/users/show/{id}', [UserManagement::class, 'show'])->name('users.show');
    Route::post('/users/update/{id}', [UserManagement::class, 'update'])->name('users.update');
    Route::post('/users/delete/{id}', [UserManagement::class, 'delete'])->name('users.delete');
    Route::get('/users/games/{id}', [UserManagement::class, 'destroy'])->name('users.destroy');
    Route::get('/users/clientes/{id}', [UserManagement::class, 'clientes'])->name('users.clientes');

    Route::get('/user/bots/{id}', [UserManagement::class, 'games'])->middleware('can:admin')->name('user.bots');
    Route::get('/user/nogameuser/{id}', [UserManagement::class, 'getGamesofUserNoHave'])->name('user.games.nobots');
    Route::get('/user/gamesuser/{id}', [UserManagement::class, 'games'])->name('user.games.bots');
    Route::post('/user/storegametouser', [UserManagement::class, 'storeGameToUser'])->middleware('can:admin')->name('user.games.store');
    Route::post('/user/deletegameuser/{id}', [UserManagement::class, 'deleteGameToUser'])->middleware('can:admin')->name('user.games.delete');

    Route::post('/cliente/ativar/{id}', [UserManagement::class, 'activeCliente'])->name('cliente.ative');
    Route::post('/cliente/desativar/{id}', [UserManagement::class, 'desactiveCliente'])->name('cliente.desative');


    Route::get('/user/webhooks/{id}', [UserManagement::class, 'getWebHooks'])->name('user.webhooks');
    Route::post('/user/webhooks/store', [UserManagement::class, 'storeWebHook'])->name('user.webhook.store');
    Route::post('/user/webhook/delete/{id}', [UserManagement::class, 'deleteWebHook'])->name('user.webhook.delete');

    Route::get('/client/show/{id}', [ClientBotsController::class, 'show'])->name('client.show');
    Route::post('/client/new', [ClientBotsController::class, 'store'])->name('client.store');
    Route::post('/client/edit', [ClientBotsController::class, 'editClient'])->name('client.edit');
    Route::post('/client/delete/{id}', [ClientBotsController::class, 'delete'])->name('client.delete');

    Route::get('/user/show/{id}', [UserManagement::class, 'show'])->name('user.show');
    Route::post('/user/edit', [UserManagement::class, 'editUser'])->name('user.edit');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
