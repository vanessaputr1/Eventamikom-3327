<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        if (!Auth::check()) {
            return redirect()->route('login', ['redirect' => route('checkout.create', $event)]);
        }

        if (Auth::user()->role !== 'user') {
            Auth::logout();
            return redirect()->route('login', ['redirect' => route('checkout.create', $event)]);
        }

        $categories = \App\Models\Category::all();

        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($event->stock <= 0) {
            return back()->with(
                'error',
                'Mohon maaf, tiket untuk acara ini sudah habis.'
            );
        }

        $orderId = 'TRX-' . time() . '-' . Str::random(5);

        /*
    |--------------------------------------------------------------------------
    | EVENT GRATIS
    |--------------------------------------------------------------------------
    */

        if ($event->price == 0) {

            $transaction = Transaction::create([
                'event_id'        => $event->id,
                'organizer_id'    => $event->organizer_id,
                'order_id'        => $orderId,
                'customer_name'   => $request->customer_name,
                'customer_email'  => $request->customer_email,
                'customer_phone'  => $request->customer_phone,
                'total_price'     => 0,
                'status'          => 'success',
            ]);

            // Kurangi stok
            $event->decrement('stock');

            // Langsung ke halaman sukses
            return redirect()->route('checkout.success', $orderId);
        }

        /*
    |--------------------------------------------------------------------------
    | EVENT BERBAYAR
    |--------------------------------------------------------------------------
    */

        $totalPrice = $event->price + 5000;

        $transaction = Transaction::create([
            'event_id'        => $event->id,
            'organizer_id'    => $event->organizer_id,
            'order_id'        => $orderId,
            'customer_name'   => $request->customer_name,
            'customer_email'  => $request->customer_email,
            'customer_phone'  => $request->customer_phone,
            'total_price'     => $totalPrice,
            'status'          => 'Pending',
        ]);

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ];

        try {

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $transaction->update([
                'snap_token' => $snapToken
            ]);

            return redirect()->route(
                'checkout.payment',
                $transaction->order_id
            );
        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Gagal memproses pembayaran : ' . $e->getMessage()
            );
        }
    }

    public function payment($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')
            ->where('order_id', $order_id)
            ->firstOrFail();

        /*
    |--------------------------------------------------------------------------
    | Jika Event Gratis
    |--------------------------------------------------------------------------
    */

        if ($transaction->total_price == 0) {

            return view(
                'checkout.success',
                compact('transaction', 'categories')
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Event Berbayar
    |--------------------------------------------------------------------------
    */

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;

        try {

            $midtransStatus = \Midtrans\Transaction::status($order_id);

            if (
                in_array(
                    $midtransStatus->transaction_status,
                    ['capture', 'settlement']
                )
            ) {

                if ($transaction->status != 'success') {

                    $transaction->update([
                        'status' => 'success'
                    ]);

                    // stok dikurangi sekali saja
                    $transaction->event->decrement('stock');
                }
            }
        } catch (\Exception $e) {

            return redirect()
                ->route('home')
                ->with(
                    'error',
                    'Transaksi gagal diverifikasi.'
                );
        }

        return view(
            'checkout.success',
            compact('transaction', 'categories')
        );
    }
}
