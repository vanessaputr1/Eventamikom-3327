<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $organizer = Auth::user()->organizer;

        $reviews = Review::with(['event', 'user'])
            ->whereHas('event', function ($query) use ($organizer) {
                $query->where('organizer_id', $organizer->id);
            })
            ->latest()
            ->paginate(10);

        $averageRating = Review::whereHas('event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })->avg('rating');

        $averageRating = round($averageRating ?? 0, 1);

        $totalReviews = Review::whereHas('event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })->count();

        $fiveStar = Review::whereHas('event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })->where('rating', 5)->count();

        $fourStar = Review::whereHas('event', function ($query) use ($organizer) {
            $query->where('organizer_id', $organizer->id);
        })->where('rating', 4)->count();

        return view('organizer.reviews.index', compact(
            'reviews',
            'averageRating',
            'totalReviews',
            'fiveStar',
            'fourStar'
        ));
    }
}