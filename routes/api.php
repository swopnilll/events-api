<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function () {
    return response()->json([
        'id' => 1,
        'name' => 'Mock User',
        'email' => 'mockuser@example.com',
    ]);
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
