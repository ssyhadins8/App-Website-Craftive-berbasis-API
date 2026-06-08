<?php
namespace App\Http\Controllers\Buyer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric',
            'proof_image' => 'required|string'
        ]);

        $order = Order::where('buyer_id', Auth::guard('api')->id())->findOrFail($request->order_id);

        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $request->amount,
            'proof_image' => $request->proof_image,
            'status' => 'pending'
        ]);

        return response()->json($payment, 201);
    }
}