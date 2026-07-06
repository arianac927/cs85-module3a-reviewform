<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contactform.php', function() {
    require base_path('contactform.php');
});