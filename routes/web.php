<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;

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
    return view('landing');
})->name('landing');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', function() {
            return redirect()->route('admin.home');
        });
        Route::get('/home', function () {
            return view('welcome');
        })->name('admin.home');
        Route::get('/test', function () {
            return view('welcome');
        })->name('admin.test');
        Route::get('/violations/create', function () {
            return view('form');
        })->name('admin.form');

        Route::get('/violations', [FormController::class, 'showForm'])->name('admin.result');

        Route::get('/quicklog', function () {
            return view('quicklog');
        })->name('admin.quicklog');

        Route::post('/quicklog', [FormController::class, 'receipt']);
        Route::post('/input', [FormController::class, 'store'])->name('admin.store');
        Route::get('/edit/{selectedId}', [FormController::class, 'edit'])->name('edit');
        
        // for search
        Route::get('/search',[FormController::class, 'search'])->name('admin.search');

        // for filtering
        Route::get('/filter', [FormController::class, 'filter'])->name('filter');

        // for test search something
        Route::post('/patron/search', [FormController::class, 'findPatron']);

        // get card num
        Route::post('/select', [FormController::class, 'select'])->name('admin.select');




        
    });
});
// Route::get('/cvsu_ils/sample', function () {
//     return view('file');
// });

// Route::get('/cvsu_ils/sample3', function () {
//     return view('third');
// });