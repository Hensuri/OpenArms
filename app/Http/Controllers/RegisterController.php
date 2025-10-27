<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function show()
    {
        return view('Regist');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
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
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.not_regex' => 'The password must not contain three repeating characters in a row.',
            'username.unique' => 'This username has already been taken.',
            'email.unique'  => 'This email has already been taken.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')
            ->with('success', 'Success, continue login');
    }
}
