@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')

<main class="max-w-3xl mx-auto px-6 py-20">

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-10 text-center">

        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-green-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h2 class="text-3xl font-black mb-6">
            Terima Kasih!
        </h2>

        @if($transaction->total_price == 0)

            <div class="bg-green-50 border border-green-300 rounded-2xl p-6 text-left">

                <h3 class="text-xl font-bold text-green-700 mb-3">
                    🎉 Pendaftaran Event Gratis Berhasil
                </h3>

                <p class="mb-4 text-slate-700">
                    Anda berhasil mendaftar tanpa melakukan pembayaran.
                </p>

                <div class="space-y-2">

                    <p><strong>Order ID :</strong> {{ $transaction->order_id }}</p>

                    <p><strong>Email :</strong> {{ $transaction->customer_email }}</p>

                    <p><strong>Status :</strong> Tiket berhasil dibuat.</p>

                </div>

                <hr class="my-5">

                <ul class="space-y-2 text-green-700">

                    <li>✅ Pembeli langsung diarahkan ke halaman sukses.</li>

                    <li>✅ E-Ticket berhasil dibuat secara otomatis.</li>

                    <li>✅ Stok tiket telah dikurangi.</li>

                </ul>

            </div>

        @else

            <div class="bg-indigo-50 border border-indigo-300 rounded-2xl p-6 text-left">

                <h3 class="text-xl font-bold text-indigo-700 mb-3">
                    ✅ Pembayaran Berhasil
                </h3>

                <p class="text-slate-700">

                    Pembayaran untuk pesanan

                    <strong>{{ $transaction->order_id }}</strong>

                    berhasil diproses.

                </p>

                <p class="mt-3">

                    E-Ticket akan dikirim ke email

                    <strong>{{ $transaction->customer_email }}</strong>

                    setelah pembayaran terkonfirmasi.

                </p>

            </div>

        @endif

        <a href="{{ route('home') }}"
            class="inline-block mt-8 px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700">

            Kembali ke Beranda

        </a>

    </div>

</main>

@endsection