<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request) {
        $incomingFields = $request->validate([
            'name' => ['required', Rule::unique('users', 'name')],
            'email' => ['required', 'min:8', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:200']

        ]);
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        $user = User::create($incomingFields);
        Auth::login($user);
        
        return redirect('/');

    }
    public function logout() {
        Auth::logout();
        return redirect('/');

    }
    public function login(Request $request) {
        $incomingFields = $request->validate([
            'loginname' => 'required',
            'loginpassword' => 'required'

        ]);
        if(Auth::attempt(['name'=>$incomingFields['loginname'], 'password'=>$incomingFields['loginpassword']])) {
            $request->session()->regenerate();

        }
        return redirect('/');
    }
    //update user income
    public function updateIncome(Request $request) {
        $incomingField = $request->validate([
            'income' => ['required', 'numeric', 'min:0'],

        ]);
        Auth::user()->update([
        'income' => $incomingField['income']

    ]);

        return redirect('/');
    }
    //adding category
    public function addCategory(Request $request) {
        $incomingField = $request->validate([
            'name' => 'required',

        ]);
        
        Category::create($incomingField);

        return redirect('/');
    }
    //add expenses
    public function addExpenses(Request $request) {
        $incomingField = $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'category_id' => 'required'

        ]);
        Expense::create($incomingField);

        return redirect('/');
    }
    public function deleteExpense(Expense $expense) {
        $expense->delete();
        return redirect('/');

    }

}