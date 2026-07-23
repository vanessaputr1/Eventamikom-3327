<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    /**
     * Daftar seluruh organizer
     */
    public function index()
    {
        $organizers = Organizer::with(['user', 'events', 'transactions'])
            ->latest()
            ->paginate(10);

        return view('admin.organizers.index', compact('organizers'));
    }

    /**
     * Approve / Suspend Organizer
     */
    public function update(Request $request, Organizer $organizer)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,suspended',
        ]);

        $organizer->update([
            'status' => $request->status,
        ]);

        return back()->with(
            'success',
            'Status organizer berhasil diperbarui.'
        );
    }
}
