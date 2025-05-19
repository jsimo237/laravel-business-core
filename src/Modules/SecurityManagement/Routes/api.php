<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth/hello', function () {
    return response()->json(['message' => 'Hello from API']);
});