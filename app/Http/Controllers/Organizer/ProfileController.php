<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Review;
use App\Models\Transaction;

class ProfileController extends Controller
{
    public function index()
    {
        $organizer = Auth::user()->organizer;

        $eventIds = Event::where('organizer_id', $organizer->id)
            ->pluck('id');

        $rating = round(
            Review::whereIn('event_id', $eventIds)
                ->where('is_hidden', false)
                ->avg('rating') ?? 0,
            1
        );

        $totalReview = Review::whereIn('event_id', $eventIds)
            ->where('is_hidden', false)
            ->count();

        $totalEvent = Event::where('organizer_id', $organizer->id)
            ->count();

        $ticketsSold = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', [
                'success',
                'settlement',
                'capture'
            ])
            ->count();

        return view('organizer.profile', compact(
            'organizer',
            'rating',
            'totalReview',
            'totalEvent',
            'ticketsSold'
        ));
    }
}
