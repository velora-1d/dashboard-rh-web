<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;
use App\Models\Syahriah;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('services.midtrans.is_production', false);
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;
    }

    public function getSnapToken(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'item_name' => 'required|string',
            'month' => 'required|string',
            'year' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $orderId = 'SYH-' . time() . '-' . $user->id;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => $user->nama_santri,
                'email' => 'santri@riyadlulhuda.com', // Dummy if not available
            ],
            'item_details' => [
                [
                    'id' => 'SYH-' . $request->month . $request->year,
                    'price' => $request->amount,
                    'quantity' => 1,
                    'name' => $request->item_name,
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $redirectUrl = Snap::getSnapUrl($params); // Use getSnapUrl to get redirect URL directly

            return response()->json([
                'status' => 'success',
                'token' => $snapToken,
                'redirect_url' => $redirectUrl,
                'order_id' => $orderId
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
