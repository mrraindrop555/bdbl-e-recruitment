<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Index');
});
Route::get('/result', function () {
    return view('Result');
});
Route::get('/detail', function () {
    return view('Detail');
});
Route::get('/shortlisted', function () {
    return view('shortlisted');
});
Route::get('/admin', function () {
    return view('admin/adminindex');
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