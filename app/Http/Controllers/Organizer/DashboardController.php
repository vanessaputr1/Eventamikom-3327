<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $organizer = Auth::user()->organizer;

        if (!$organizer) {
            abort(403, 'Organizer tidak ditemukan.');
        }

        // Total Event
        $totalEvents = Event::where(
            'organizer_id',
            $organizer->id
        )->count();

        // Event Aktif (event yang tanggalnya belum lewat)
        $activeEvents = Event::where(
            'organizer_id',
            $organizer->id
        )
        ->where('date', '>=', now())
        ->count();

        // Tiket Terjual
        $ticketsSold = Transaction::where(
            'organizer_id',
            $organizer->id
        )
        ->where('status', 'paid')
        ->count();

        // Total Pendapatan
        $totalRevenue = Transaction::where(
            'organizer_id',
            $organizer->id
        )
        ->where('status', 'paid')
        ->sum('total_price');

        // Jumlah Review
        $reviewCount = Review::whereHas('event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })->count();

        // Rating rata-rata
        $averageRating = Review::whereHas('event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })->avg('rating');

        $averageRating = round($averageRating ?? 0, 1);

        // Transaksi terbaru
        $recentTransactions = Transaction::with('event')
            ->where('organizer_id', $organizer->id)
            ->latest()
            ->take(5)
            ->get();

        return view('organizer.dashboard', compact(
            'totalEvents',
            'activeEvents',
            'ticketsSold',
            'totalRevenue',
            'reviewCount',
            'recentTransactions',
            'averageRating'
        ));
    }
}