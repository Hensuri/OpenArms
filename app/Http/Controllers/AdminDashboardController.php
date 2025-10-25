<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    // tampilkan semua donation
    public function index()
    {
        // Ambil semua data donasi
        $donations = Donation::orderBy('created_at', 'desc')->get();

        // Hitung total berdasarkan status
        $totalApplicants = $donations->count();
        $inChecking = $donations->where('status', 'pending')->count();
        $accepted = $donations->where('status', 'approved')->count();
        $rejected = $donations->where('status', 'rejected')->count();

        // Kirim ke view
        return view('AdminDashboard', compact('donations', 'totalApplicants', 'inChecking', 'accepted', 'rejected'));
    }

    // approve donation
    public function approve($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->status = 'approved';
        $donation->save();

        return redirect()->route('adminDonation')->with('success', 'Donation approved successfully!');
    }

    public function reject($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->status = 'rejected';
        $donation->save();

        return redirect()->route('adminDonation')->with('error', 'Donation rejected.');
    }

}
