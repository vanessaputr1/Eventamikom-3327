@extends('layouts.organizer', ['title' => 'Review Event'])

@section('content')

<div class="space-y-8">

    <!-- Header -->
    <div>
        <h1 class="text-3xl font-black text-slate-800">
            Review Event
        </h1>
        <p class="text-slate-500 mt-1">
            Lihat seluruh ulasan dari peserta event Anda.
        </p>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">
                        Rata-rata Rating
                    </p>

                    <h2 class="text-4xl font-black text-yellow-500 mt-2">
                        ⭐ {{ number_format($averageRating,1) }}
                    </h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center text-3xl">
                    ⭐
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">
                        Total Review
                    </p>

                    <h2 class="text-4xl font-black text-indigo-600 mt-2">
                        {{ $totalReviews }}
                    </h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-indigo-100 flex items-center justify-center text-3xl">
                    💬
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">
                        Review Positif
                    </p>

                    <h2 class="text-4xl font-black text-emerald-600 mt-2">
                        {{ $fourStar + $fiveStar }}
                    </h2>
                </div>

                <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                    👍
                </div>
            </div>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-100">
            <h3 class="font-bold text-lg">
                Daftar Review
            </h3>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr class="text-left text-sm text-slate-500">

                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">Review</th>
                        <th class="px-6 py-4">Tanggal</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($reviews as $review)

                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-5 font-semibold">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-5">

                            <div class="font-semibold text-slate-800">
                                {{ $review->event->title }}
                            </div>

                        </td>

                        <td class="px-6 py-5">

                            <div class="font-medium">
                                {{ $review->customer_name }}
                            </div>

                        </td>

                        <td class="px-6 py-5">

                            <div class="flex gap-1 text-yellow-400 text-lg">

                                @for($i=1;$i<=5;$i++)

                                    @if($i <= $review->rating)
                                        ★
                                    @else
                                        <span class="text-slate-300">★</span>
                                    @endif

                                @endfor

                            </div>

                        </td>

                        <td class="px-6 py-5">

                            <div class="max-w-sm text-slate-600">
                                {{ $review->comment }}
                            </div>

                        </td>

                        <td class="px-6 py-5 text-slate-500">

                            {{ $review->created_at->format('d M Y') }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="py-16 text-center">

                            <div class="text-6xl mb-4">
                                ⭐
                            </div>

                            <h3 class="text-xl font-bold text-slate-700">
                                Belum Ada Review
                            </h3>

                            <p class="text-slate-500 mt-2">
                                Review pelanggan akan muncul di sini setelah event selesai.
                            </p>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($reviews->hasPages())

        <div class="px-6 py-4 border-t border-slate-100">

            {{ $reviews->links() }}

        </div>

        @endif

    </div>

</div>

@endsection