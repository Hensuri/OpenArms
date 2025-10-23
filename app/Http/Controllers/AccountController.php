<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function edit()
    {
        return view('EditAccount');
    }

    public function update(Request $request)
    {
        $user = $request->user();
        if ($request->hasFile('profile_picture')) {
            $f = $request->file('profile_picture');
            Log::info('Profile picture upload attempt', [
                'clientMime' => $f->getClientMimeType(),
                'mime' => $f->getMimeType(),
                'ext' => $f->getClientOriginalExtension(),
                'size' => $f->getSize(),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'current_password' => ['required'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:5120'], 
        ], [
            'username.unique' => 'This username is already taken.',
            'current_password.required' => 'Please enter your current password to confirm changes.',
            'profile_picture.image' => 'The profile picture must be an image file.',
            'profile_picture.mimes' => 'Unsupported file format (allowed: png, jpg, jpeg, gif).',
            'profile_picture.max' => 'The profile picture may not be greater than 5MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The provided password does not match our records.'])->withInput();
        }

        $user->username = $request->input('username');

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            try {
                $path = $file->store('profile_pictures', 'public');
                
                Log::info('Profile picture stored', [
                    'path' => $path,
                    'full_url' => asset('storage/' . $path)
                ]);

                if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
                
                $user->profile_picture = $path;
            } catch (\Exception $e) {
                Log::error('Profile picture upload failed', ['error' => $e->getMessage()]);
                return redirect()->back()->withErrors(['profile_picture' => 'Failed to upload profile picture. Please try again.'])->withInput();
            }
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
