<?php

use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = Category::all();
    $expenses = Expense::all();
    //to calculate balance
    $total_expenses = Expense::sum('amount');
    $income = Auth::user()->income;

    return view('register', [
        'user'=>Auth::user(),
        'categories'=> $categories,
        'expenses' => $expenses,
        'total_expenses' => $total_expenses,
        'income' => $income

    ]);
});

//register & log in
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

//income
Route::post('/add-income', [UserController::class, 'updateIncome']);
//category
Route::post('/add-category', [UserController::class, 'addCategory']);
//expenses
Route::post('/add-expenses', [UserController::class, 'addExpenses']);
Route::delete('/delete-expense/{expense}', [UserController::class, 'deleteExpense']);