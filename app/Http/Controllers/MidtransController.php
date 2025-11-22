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

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $request->amount,
            ],
            'item_details' => [
                [
                    'id' => $donation->id,
                    'price' => $request->amount,
                    'quantity' => 1,
                    'name' => $donation->name,
                ],
            ],
        ];

        $data = [
            'order_id' => $order_id,
            'donation_id' => $donation->id,
            'gross_amount' => $request->amount,
            'is_anon' => $request->isAnonymous,
        ];
        Log::info($donator);

        if ($donator) {
            $data['user_id'] = $donator->id;
            $params['customer_details'] = [
                'first_name' => $donator->username,
                'email' => $donator->email,
            ];
        }
        else{
            $data['is_anon'] = 1;
        }

        try {
            // Log::info($params);
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

    public function callback(Request $request)
    {
        Log::info('Midtrans callback received:', $request->all());

        $serverKey = env('MIDTRANS_SERVER_KEY');

        $signatureKey = hash('sha512',
            $request->order_id . 
            $request->status_code . 
            $request->gross_amount . 
            $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            Log::info('Midtrans callback signature key invalid');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = TransactionLog::where('order_id', $request->order_id)->first();

        if (!$transaction) {
            Log::info('There\'s no transaction on here');
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        switch ($request->transaction_status) {
            case 'capture':
            case 'settlement':
                $transaction->status = 'success';
                break;
            case 'pending':
                $transaction->status = 'pending';
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $transaction->status = 'failed';
                break;
        }
        $transaction->save();
        return response()->json(['message' => 'Callback processed']);
    }
}
