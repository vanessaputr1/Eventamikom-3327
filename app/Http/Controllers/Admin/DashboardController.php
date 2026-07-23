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
        | Grafik User & Event (MySQL + PostgreSQL)
        |--------------------------------------------------------------------------
        */

        $driver = DB::connection()->getDriverName();

        if ($driver === 'pgsql') {
            $monthExpression = "EXTRACT(MONTH FROM created_at)";
        } else {
            $monthExpression = "MONTH(created_at)";
        }

        $userChart = User::where('role', 'user')
            ->selectRaw("$monthExpression AS month, COUNT(*) AS total")
            ->groupByRaw($monthExpression)
            ->orderByRaw($monthExpression)
            ->get();

        $eventChart = Event::selectRaw("$monthExpression AS month, COUNT(*) AS total")
            ->groupByRaw($monthExpression)
            ->orderByRaw($monthExpression)
            ->get();

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

        $userData = array_fill(0, 12, 0);
        $eventData = array_fill(0, 12, 0);

        foreach ($userChart as $item) {
            $month = (int) $item->month;

            if ($month >= 1 && $month <= 12) {
                $userData[$month - 1] = (int) $item->total;
            }
        }

        foreach ($eventChart as $item) {
            $month = (int) $item->month;

            if ($month >= 1 && $month <= 12) {
                $eventData[$month - 1] = (int) $item->total;
            }
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