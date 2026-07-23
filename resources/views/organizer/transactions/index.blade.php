@extends('layouts.organizer', ['title' => 'Transaksi'])

@section('content')

<div class="space-y-8">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-800">
                Transaksi Event
            </h1>
            <p class="text-slate-500 mt-1">
                Kelola seluruh transaksi pembelian tiket event Anda.
            </p>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-slate-500 text-sm">
                        Total Pendapatan
                    </p>

                    <h2 class="mt-2 text-3xl font-black text-indigo-600">
                        Rp {{ number_format($totalRevenue,0,',','.') }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center">

                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4 1.343 4 3-1.79 3-4 3m0-12V4m0 16v-2" />
                    </svg>

                </div>

            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between">

                <div>

                    <p class="text-slate-500 text-sm">
                        Pembayaran Berhasil
                    </p>

                    <h2 class="mt-2 text-3xl font-black text-green-600">
                        {{ $paidCount }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center">

                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M5 13l4 4L19 7" />
                    </svg>

                </div>

            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <div class="flex items-center justify-between">

                <div>

                    <p class="text-slate-500 text-sm">
                        Pending
                    </p>

                    <h2 class="mt-2 text-3xl font-black text-yellow-500">
                        {{ $pendingCount }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center">

                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3" />
                    </svg>

                </div>

            </div>
        </div>

    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-100">

            <h3 class="text-xl font-black text-slate-800">
                Daftar Transaksi
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr class="text-left text-sm uppercase tracking-wider text-slate-500">

                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Order ID</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($transactions as $trx)

                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-5">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-5 font-semibold">
                            {{ $trx->order_id }}
                        </td>

                        <td class="px-6 py-5">

                            {{ $trx->event->title ?? '-' }}

                        </td>

                        <td class="px-6 py-5">

                            {{ $trx->customer_name }}

                        </td>

                        <td class="px-6 py-5 text-slate-500">

                            {{ $trx->customer_email }}

                        </td>

                        <td class="px-6 py-5 font-bold text-indigo-600">

                            Rp {{ number_format($trx->total_price,0,',','.') }}

                        </td>

                        <td class="px-6 py-5">

                            @if(in_array($trx->status,['success','settlement','capture','paid']))

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                Berhasil
                            </span>

                            @elseif($trx->status=='pending')

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                Pending
                            </span>

                            @elseif($trx->status=='expire')

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                Expired
                            </span>

                            @else

                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                                {{ ucfirst($trx->status) }}
                            </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="py-16 text-center">

                            <div class="flex flex-col items-center">

                                <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 7h18M5 7l1 12h12l1-12" />
                                </svg>

                                <h3 class="font-bold text-lg text-slate-600">
                                    Belum ada transaksi
                                </h3>

                                <p class="text-slate-400 mt-2">
                                    Transaksi pembelian tiket akan muncul di sini.
                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="px-6 py-5 border-t border-slate-100">

            {{ $transactions->links() }}

        </div>

    </div>

</div>

@endsection