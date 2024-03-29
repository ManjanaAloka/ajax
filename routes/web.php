<?php

use App\Http\Controllers\StudentController;
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
    return view('home');
});

Route::group(['prefix' => 'student'], function () {
    Route::get('/showData', [StudentController::class, 'showData'])->name('showData');
    Route::post('/store', [StudentController::class, 'store'])->name('saveStudent');
    Route::post('/findData', [StudentController::class, 'findData'])->name('findData');
    Route::post('/update', [StudentController::class, 'updateStd'])->name('updateData');
    Route::get('/delStudent', [StudentController::class, 'delStudent'])->name('delStudent');
});
