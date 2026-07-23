<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::query()
            ->with(['event.category', 'event.organizer.user', 'user'])
            ->latest();

        if (Auth::user()?->role === 'organizer') {
            $query->whereHas('event', function ($eventQuery) {
                $eventQuery->where('organizer_id', Auth::user()->organizer?->id);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('comment', 'like', "%{$search}%")
                    ->orWhereHas('event', function ($eventQuery) use ($search) {
                        $eventQuery->where('title', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('organizer')) {
            $query->whereHas('event.organizer', function ($organizerQuery) use ($request) {
                $organizerQuery->where('id', $request->organizer);
            });
        }

        if ($request->filled('event')) {
            $query->where('event_id', $request->event);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $reviews = $query->paginate(20)->appends($request->query());
        $organizers = \App\Models\Organizer::with('user')->get();
        $events = \App\Models\Event::orderBy('title')->get();

        return view('admin.reviews.index', compact('reviews', 'organizers', 'events'));
    }

    public function moderate(Request $request, Review $review)
    {
        $request->validate([
            'is_hidden' => ['required', 'boolean'],
        ]);

        $review->update([
            'is_hidden' => $request->boolean('is_hidden'),
            'moderated_by' => Auth::id(),
        ]);

        return back()->with('success', $request->boolean('is_hidden') ? 'Review berhasil disembunyikan.' : 'Review berhasil ditampilkan kembali.');
    }
}
