<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/start', function () {
    return view('start');
});

// Parameters using routes
Route::get('/portfolio/{firstname}', function ($firstname) {
    return $firstname;
});