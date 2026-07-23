@extends('layouts.organizer')

@section('title', 'Organizer Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-black text-slate-900">Dashboard Organizer</h1>
        <p class="text-slate-500">Ringkasan event, transaksi, dan review milik organizer.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <p class="text-sm text-slate-500">Total Event</p>
            <h2 class="text-2xl font-black">{{ $totalEvents }}</h2>
        </div>
        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <p class="text-sm text-slate-500">Event Aktif</p>
            <h2 class="text-2xl font-black">{{ $activeEvents }}</h2>
        </div>
        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <p class="text-sm text-slate-500">Tiket Terjual</p>
            <h2 class="text-2xl font-black">{{ $ticketsSold }}</h2>
        </div>
        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <p class="text-sm text-slate-500">Total Pendapatan</p>
            <h2 class="text-2xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        </div>
        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <p class="text-sm text-slate-500">Jumlah Review</p>
            <h2 class="text-2xl font-black">{{ $reviewCount }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <h3 class="text-xl font-black mb-4">Transaksi Terbaru</h3>
            <div class="space-y-3">
                @forelse($recentTransactions as $transaction)
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="flex justify-between">
                            <span class="font-bold">{{ $transaction->event->title ?? '-' }}</span>
                            <span class="text-xs text-slate-500">{{ $transaction->status }}</span>
                        </div>
                        <p class="text-sm text-slate-500">{{ $transaction->customer_name }} • {{ $transaction->customer_email }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada transaksi.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 p-6">
            <h3 class="text-xl font-black mb-4">Statistik Review</h3>
            <div class="space-y-3">
                <p class="text-sm text-slate-500">Rata-rata Rating</p>
                <h2 class="text-2xl font-black text-indigo-600">{{ $averageRating }}</h2>
                <p class="text-sm text-slate-500">Review milik event organizer Anda.</p>
            </div>
        </div>
    </div>
</div>
@endsection
