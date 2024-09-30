<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::post('/login', function () {
    // Logic to authenticate the user
    return redirect('/dashboard'); // Redirect to the dashboard after successful login
});

Route::get('/dashboard', function () {
    return view('dashboard'); // Return the dashboard view for GET requests
});


