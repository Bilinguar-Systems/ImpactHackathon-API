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
        return $this->getUser(Auth::user()->id);
    }

    public function getUser($user_id) {
        return User::where('id', '=', $user_id)
            ->with('address')
            ->first();
    }

    public function getUsers() {
        return User::paginate(10);
    }

    public function searchUsers(Request $request) {
        $term = $request->get('term', null);

        $users = User::query();

        $users->orWhere(function ($query) use ($term) {
            $query->orWhere('first_name', 'like', '%' . $term . '%')
                ->orWhere('last_name', 'like', '%' . $term . '%')
                ->orWhere('middle_name', 'like', '%' . $term . '%')
                ->orWhere('email', 'like', '%' . $term . '%');
        });

        $users = $users->paginate(10);

        return $users;
    }

    public function verifyUserId($user_id) {
        $user = User::where('id', '=', $user_id)->firstOrFail();
        $user->is_id_verified = true;
        $user->save();

        return $user;
    }

}
