<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['name' => 'E-Commerce API', 'status' => 'ready']);
});
