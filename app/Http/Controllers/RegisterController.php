<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[0-9]/',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[^A-Za-z0-9]/',
                'not_regex:/(.)\1{2,}/',
            ],
        ], [
            'password.regex' => 'The password must contain at least one number and one special character.',
            'password.min' => 'The password must be at least 8 characters.',
            'name.unique' => 'This username has already been taken.',
            'email.unique' => 'This email has already been taken.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')
            ->with('success', 'Success, continue login');
    }
}
