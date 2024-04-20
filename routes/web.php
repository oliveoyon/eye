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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ExcelUploadController::class, 'index'])->name('index');


Route::get('/upload', [ExcelUploadController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload', [ExcelUploadController::class, 'upload'])->name('upload');

Route::get('/upload-second', [ExcelUploadController::class, 'showUploadFormForSecond'])->name('upload.form.second');
Route::post('/upload-second', [ExcelUploadController::class, 'uploadSecond'])->name('upload.second');
Route::get('/patient-list', [ExcelUploadController::class, 'index'])->name('index');
Route::get('/patient-details/{id}', [ExcelUploadController::class, 'details'])->name('details');
Route::post('/formdata', [ExcelUploadController::class, 'formdata'])->name('formdata');

Route::get('/getGenderDistribution', [ExcelUploadController::class, 'getGenderDistribution'])->name('getGenderDistribution');
Route::get('/visionInfoTable', [ExcelUploadController::class, 'visionInfoTable'])->name('visionInfoTable');
Route::get('/visionInfoTablebySex', [ExcelUploadController::class, 'visionInfoTablebySex'])->name('visionInfoTablebySex');
Route::get('/showCorrectedVisionData', [ExcelUploadController::class, 'showCorrectedVisionData'])->name('showCorrectedVisionData');
Route::get('/type-of-error', [ExcelUploadController::class, 'typeOfErrorData'])->name('typeOfErrorData');
Route::get('/type-of-error-age-data', [ExcelUploadController::class, 'typeOfErrorAgeData'])->name('type_of_error_age_data');
Route::get('/sphericalPowerByAge', [ExcelUploadController::class, 'sphericalPowerByAge'])->name('sphericalPowerByAge');
Route::get('/deleteRows', [ExcelUploadController::class, 'deleteRows'])->name('deleteRows');
