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

        $driver = DB::connection()->getDriverName();

        if ($driver === 'pgsql') {
            $monthSql = "EXTRACT(MONTH FROM created_at)";
        } else {
            $monthSql = "MONTH(created_at)";
        }

        $userChart = User::where('role', 'user')
            ->selectRaw("$monthSql as month, COUNT(*) as total")
            ->groupByRaw($monthSql)
            ->orderBy('month')
            ->pluck('total', 'month');

        /*
|--------------------------------------------------------------------------
| Grafik Event
|--------------------------------------------------------------------------
*/

        $eventChart = Event::selectRaw("$monthSql as month, COUNT(*) as total")
            ->groupByRaw($monthSql)
            ->orderBy('month')
            ->pluck('total', 'month');
    }
}
