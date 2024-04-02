<?php

use App\Http\Controllers\ExcelUploadController;
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

Route::get('/upload', [ExcelUploadController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload', [ExcelUploadController::class, 'upload'])->name('upload');

Route::get('/upload-second', [ExcelUploadController::class, 'showUploadFormForSecond'])->name('upload.form.second');
Route::post('/upload-second', [ExcelUploadController::class, 'uploadSecond'])->name('upload.second');
Route::get('/patient-list', [ExcelUploadController::class, 'index'])->name('index');
Route::get('/patient-details/{id}', [ExcelUploadController::class, 'details'])->name('details');
Route::post('/formdata', [ExcelUploadController::class, 'formdata'])->name('formdata');
