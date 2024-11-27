<?php

use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\AdminVacancyController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VacancyController;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Route;

//index redirect
Route::get('/', function () {
    return redirect('/vacancy');
});

Route::resource('/vacancy', VacancyController::class);
Route::get('/vacancy/{vacancy}/apply', [VacancyController::class, 'apply']);
Route::post('/vacancy/{vacancy}/applicaiton', [ApplicationController::class, 'store'])->name('application');
Route::get('/result', [VacancyController::class, 'result']);
Route::get('/result/{vacancy}', [ApplicationController::class, 'index'])->name('result');

Route::get('/resubmission/{application}', [ApplicationController::class, 'showResubmissionForm']);


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

Route::get('/login', function(){
    if (Auth::user()){
        return redirect('/admin/vacancy');
    } else {
        return view(
            'Login'
        );
    }
});
// Route::get('/login', [AuthController::class, 'create'])->name('login');
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
        Route::post('/vacancy/{vacancy}/archive', [AdminVacancyController::class, 'archive']);
        Route::post('/vacancy/{vacancy}/toggle', [AdminVacancyController::class, 'toggleStatus']);
        Route::get('/result', [AdminVacancyController::class, 'result']);
        Route::get('/result/{vacancy}', [AdminApplicationController::class, 'index']);
        Route::get('/application/{application}', [AdminApplicationController::class, 'show']);
        Route::post('/vacancy/{vacancy}/shortlist', [AdminVacancyController::class, 'shortlist']);
        Route::get('/vacancy/{vacancy}/download', [AdminVacancyController::class, 'export']);
    });
