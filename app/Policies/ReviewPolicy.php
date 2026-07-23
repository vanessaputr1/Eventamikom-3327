<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'organizer']);
    }

    public function view(User $user, Review $review): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return $user->role === 'organizer'
            && $review->event?->organizer_id === $user->organizer?->id;
    }

    public function update(User $user, Review $review): bool
    {
        return $user->role === 'admin';
    }
}
