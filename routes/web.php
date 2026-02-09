<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Parameters using routes
Route::get('/portfolio/{firstname}', function ($firstname) {
    return $firstname;
});