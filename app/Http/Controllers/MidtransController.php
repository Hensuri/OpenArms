<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Donation;
use App\Models\User;
use App\Models\TransactionLog;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans di constructor
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function create(Request $request)
    {
        $order_id = 'TRX-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));
        $donation = Donation::where('id', $request->donation_id)->first();
        $donator = User::where('id', $request->donator)->first();

        $params = ['transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'username' => $donator->username,
            ],
            'Donation_Name' => $donation->name
        ];

        $data = [
            'order_id' => $order_id,
            'user_id' => $donator->id,
            'donation_id' => $donation->id,
            'gross_amount' => $request->amount,
            'is_anon' => $request->isAnonymous,
        ];

        try {
            Log::info($params);
            $snapToken = Snap::getSnapToken($params);
            TransactionLog::create($data);
            return [
                'snap_token' => $snapToken,  
            ];
        } catch (\Exception $e) {
            
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        
    }
}
