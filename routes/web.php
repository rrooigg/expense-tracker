<?php

use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = Category::all();
    return view('register', ['user'=>Auth::user()], ['categories'=> $categories]);
});

//register & log in
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

//income
Route::post('/add-income', [UserController::class, 'updateIncome']);
//category
Route::post('/add-category', [UserController::class, 'addCategory']);