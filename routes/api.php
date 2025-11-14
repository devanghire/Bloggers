<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;

Route::post('login',[AuthController::class,'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {

    Route::post('create_blog', [BlogController::class, 'create']);
    Route::post('edit_blog', [BlogController::class, 'edit']);
    Route::post('blog_list', [BlogController::class, 'list']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('blog_like', [BlogController::class, 'like']);
    Route::get('delete_blog', [BlogController::class, 'delete']);
});
