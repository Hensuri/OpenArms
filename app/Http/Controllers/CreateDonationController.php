<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;
use App\Models\User; 

class CreateDonationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan user sudah login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $donations = Donation::where('creator_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('myDonation', compact('donations'));
    }

    public function show()
    {
        return view('createDonations');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donation-name' => 'required|string|max:255',
            'donation-target' => 'required|numeric',
            'donation-description' => 'required|string',
            'category' => 'required|string',
            'cover_image' => 'nullable|mimes:jpg,jpeg,png|max:10240',
        ], [
            'cover_image.mimes' => 'Cover image hanya boleh berupa file PNG, JPG, atau JPEG',
            'cover_image.max' => 'Ukuran file maksimal 10MB.',
        ]);

        $path = null;
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
        }

        Donation::create([
            'name' => $request->input('donation-name'),
            'target_amount' => $request->input('donation-target'),
            'description' => $request->input('donation-description'),
            'category' => $request->input('category'),
            'cover_image' => $path,
            'creator_id' => Auth::id(),
        ]);

        return redirect()->route('myDonationList')->with('success', 'Donation created successfully!');
    }
}
