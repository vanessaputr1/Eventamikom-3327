@extends('layouts.admin')

@section('title', 'Kelola Review')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-900">Kelola Review</h1>
            <p class="text-slate-500">Pantau, filter, dan moderasi review peserta secara aman.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari event / user / komentar" class="rounded-xl border border-slate-200 px-4 py-3">

            <select name="organizer" class="rounded-xl border border-slate-200 px-4 py-3">
                <option value="">Semua Organizer</option>
                @foreach($organizers as $organizer)
                    <option value="{{ $organizer->id }}" {{ request('organizer') == $organizer->id ? 'selected' : '' }}>{{ $organizer->name }}</option>
                @endforeach
            </select>

            <select name="event" class="rounded-xl border border-slate-200 px-4 py-3">
                <option value="">Semua Event</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ request('event') == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                @endforeach
            </select>

            <select name="rating" class="rounded-xl border border-slate-200 px-4 py-3">
                <option value="">Semua Rating</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                @endfor
            </select>

            <input type="date" name="date" value="{{ request('date') }}" class="rounded-xl border border-slate-200 px-4 py-3">

            <button type="submit" class="md:col-span-5 rounded-xl bg-indigo-600 text-white font-bold px-5 py-3">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-slate-50 text-slate-600 text-xs uppercase">
                <tr>
                    <th class="px-6 py-4">Nama Event</th>
                    <th class="px-6 py-4">Organizer</th>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Rating</th>
                    <th class="px-6 py-4">Komentar</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Moderasi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($reviews as $review)
                    <tr class="border-t border-slate-100">
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $review->event->title ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $review->event->organizer->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $review->customer_name }}<br><span class="text-xs">{{ $review->customer_email }}</span></td>
                        <td class="px-6 py-4 text-amber-500 font-black">{{ str_repeat('★', $review->rating) }}</td>
                        <td class="px-6 py-4 text-slate-600 max-w-sm">{{ $review->comment ?: '-' }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $review->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.reviews.moderate', $review->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="is_hidden" class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                                    <option value="0" {{ !$review->is_hidden ? 'selected' : '' }}>Tampilkan</option>
                                    <option value="1" {{ $review->is_hidden ? 'selected' : '' }}>Sembunyikan</option>
                                </select>
                                <button type="submit" class="mt-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-bold text-white">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500">Belum ada review.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection
