<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FirebaseAuthController;
use App\Http\Controllers\PhotoController;
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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('dashboard/chat', [ChatController::class, 'index']);
Route::post('dashboard/chat', [ChatController::class, 'chat'])->name('chat');
Route::post('/dashboard/sendjson', [FirebaseAuthController::class, 'sendJsonToFirebase']);
Route::get('/dashboard/construct', [FirebaseAuthController::class, '__construct']);
Route::post('/dashboard/firebase', [FirebaseAuthController::class, 'createCustomToken']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route::resources('/', [PhotoController::class, '']);
require __DIR__ . '/auth.php';
