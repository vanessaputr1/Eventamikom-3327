<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $organizer = Auth::user()->organizer;

        $transactions = Transaction::with('event')
            ->where('organizer_id', $organizer->id)
            ->latest()
            ->paginate(10);

        $totalRevenue = Transaction::where('organizer_id', $organizer->id)
            ->where('status', 'paid')
            ->sum('total_price');

        $paidCount = Transaction::where('organizer_id', $organizer->id)
            ->where('status', 'paid')
            ->count();

        $pendingCount = Transaction::where('organizer_id', $organizer->id)
            ->where('status', 'pending')
            ->count();

        return view('organizer.transactions.index', compact(
            'transactions',
            'totalRevenue',
            'paidCount',
            'pendingCount'
        ));
    }
}