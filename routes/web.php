<?php

use App\Http\Controllers\AdminVacancyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VacancyController;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Route;

//index redirect
Route::get('/', function () {
    return redirect('/vacancy');
});

Route::resource('/vacancy', VacancyController::class);
Route::get('/result', [VacancyController::class, 'result']);

Route::get('/detail', function () {
    return view('Detail');
});
Route::get('/shortlisted', function () {
    return view('shortlisted');
});
Route::get('/adminresult', function () {
    return view('admin/adminresult');
});
Route::get('/adminshortlisted', function () {
    return view('admin/adminshortlisted');
});
Route::get('/adminDetail', function () {
    return view('admin/adminDetail');
});


Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'destroy']);

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', function () {
            return redirect('/admin/vacancy');
        });
        Route::resource('/vacancy', AdminVacancyController::class);
    });
