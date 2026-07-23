<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $event->load([
            'category',
            'reviews' => fn($query) => $query->latest(),
        ]);

        $reviewAverage = round($event->reviews()->avg('rating') ?? 0, 1);
        $reviewCount = $event->reviews()->count();

        /*
        |--------------------------------------------------------------------------
        | Review hanya boleh H+1
        |--------------------------------------------------------------------------
        */
        $isReviewAllowed = now()->greaterThanOrEqualTo(
            $event->date->copy()->addDay()->startOfDay()
        );

        $userEmail = Auth::user()?->email;

        $userReview = null;

        if ($userEmail) {
            $userReview = $event->reviews()
                ->where('customer_email', $userEmail)
                ->first();
        }

        $hasSuccessfulTransaction = false;

        if ($userEmail) {
            $hasSuccessfulTransaction = Transaction::where('event_id', $event->id)
                ->where('customer_email', $userEmail)
                ->whereIn('status', [
                    'success',
                    'settlement',
                    'capture'
                ])
                ->exists();
        }

        return view('event-detail', compact(
            'event',
            'reviewAverage',
            'reviewCount',
            'isReviewAllowed',
            'hasSuccessfulTransaction',
            'userReview'
        ));
    }

    public function storeReview(StoreReviewRequest $request, Event $event)
    {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Review hanya boleh H+1
        |--------------------------------------------------------------------------
        */
        $isReviewAllowed = now()->greaterThanOrEqualTo(
            $event->date->copy()->addDay()->startOfDay()
        );

        if (!$isReviewAllowed) {
            return back()->with(
                'error',
                'Review hanya dapat diberikan mulai H+1 setelah event selesai.'
            );
        }

        $userHasTransaction = Transaction::where('event_id', $event->id)
            ->where('customer_email', $validated['customer_email'])
            ->whereIn('status', [
                'success',
                'settlement',
                'capture'
            ])
            ->exists();

        if (!$userHasTransaction) {
            return back()->with(
                'error',
                'Anda belum pernah membeli tiket untuk event ini atau pembayaran belum berhasil.'
            );
        }

        $existingReview = $event->reviews()
            ->where('customer_email', $validated['customer_email'])
            ->first();

        if ($existingReview) {

            $existingReview->update([
                'customer_name' => $validated['customer_name'],
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]);

            return back()->with(
                'success',
                'Review berhasil diperbarui.'
            );
        }

        $event->reviews()->create([
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with(
            'success',
            'Review berhasil ditambahkan.'
        );
    }
}
