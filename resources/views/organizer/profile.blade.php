@extends('layouts.organizer', ['title' => 'Profil'])

@section('content')

<div class="container mx-auto px-6 py-8">

    <div class="bg-white rounded-xl shadow p-8">

        <div class="flex items-center gap-5">

            <div class="w-20 h-20 rounded-full bg-indigo-600 flex items-center justify-center text-white text-3xl font-bold">
                {{ strtoupper(substr($organizer->name,0,1)) }}
            </div>

            <div>

                <h2 class="text-3xl font-bold">
                    {{ $organizer->name }}
                </h2>

                <p class="text-gray-500">
                    {{ auth()->user()->email }}
                </p>

            </div>

        </div>

        <hr class="my-8">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            <div class="bg-indigo-50 rounded-xl p-5">

                <div class="text-sm text-gray-500">
                    Rating
                </div>

                <div class="text-3xl font-bold text-indigo-600">
                    ⭐ {{ $rating }}
                </div>

            </div>

            <div class="bg-indigo-50 rounded-xl p-5">

                <div class="text-sm text-gray-500">
                    Total Review
                </div>

                <div class="text-3xl font-bold">
                    {{ $totalReview }}
                </div>

            </div>

            <div class="bg-indigo-50 rounded-xl p-5">

                <div class="text-sm text-gray-500">
                    Total Event
                </div>

                <div class="text-3xl font-bold">
                    {{ $totalEvent }}
                </div>

            </div>

            <div class="bg-indigo-50 rounded-xl p-5">

                <div class="text-sm text-gray-500">
                    Tiket Terjual
                </div>

                <div class="text-3xl font-bold">
                    {{ $ticketsSold }}
                </div>

            </div>

        </div>

    </div>

</div>

@endsection