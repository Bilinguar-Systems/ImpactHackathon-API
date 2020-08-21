<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function registerUser(Request $request) {
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'nullable|max:255',
            'middle_name' => 'nullable|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:8'
        ]);

        return User::create($request->all());
    }

    public function getMe(Request $request) {
        return Auth::user();
    }

    public function getUser($user_id) {
        return User::where('id', '=', $user_id)->first();
    }

    public function getUsers() {
        return User::paginate(10);
    }
}
