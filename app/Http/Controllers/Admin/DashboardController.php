<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalEvents = Event::count();

        $activeEvents = Event::whereDate('date', '>=', now())->count();

        $pendingOrders = Transaction::where('status', 'pending')->count();

        $ticketsSold = Transaction::whereIn('status', [
            'success',
            'settlement',
            'capture'
        ])->count();

        $totalRevenue = Transaction::whereIn('status', [
            'success',
            'settlement',
            'capture'
        ])->sum('total_price');

        /*
        |--------------------------------------------------------------------------
        | Transaksi Terbaru
        |--------------------------------------------------------------------------
        */

        $recentTransactions = Transaction::with('event')
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Grafik User
        |--------------------------------------------------------------------------
        */

        $userChart = User::where('role', 'user')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        /*
        |--------------------------------------------------------------------------
        | Grafik Event
        |--------------------------------------------------------------------------
        */

        $eventChart = Event::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        $userData = [];
        $eventData = [];

        for ($i = 1; $i <= 12; $i++) {

            $userData[] = $userChart[$i] ?? 0;

            $eventData[] = $eventChart[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEvents',
            'activeEvents',
            'pendingOrders',
            'ticketsSold',
            'totalRevenue',
            'recentTransactions',
            'months',
            'userData',
            'eventData'
        ));
    }
}
