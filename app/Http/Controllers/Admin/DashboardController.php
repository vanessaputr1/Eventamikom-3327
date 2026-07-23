<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = 0;
        $totalEvents = 0;
        $activeEvents = 0;
        $pendingOrders = 0;
        $ticketsSold = 0;
        $totalRevenue = 0;

        $recentTransactions = collect();

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