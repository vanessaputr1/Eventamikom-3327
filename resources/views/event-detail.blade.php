@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">

    <!-- Left: Poster -->
    <div class="lg:col-span-1">
        <div class="sticky top-32">

            <img
                src="{{ $event->poster_path ? asset('storage/' . $event->poster_path) : asset('assets/concert.png') }}"
                alt="{{ $event->title }}"
                class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

            <div class="mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <h4 class="font-bold mb-4">Kategori Event</h4>

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                        {{ strtoupper(substr($event->category->name ?? 'EV', 0, 2)) }}
                    </div>

                    <div>
                        <p class="font-bold text-slate-800">
                            {{ $event->category->name ?? 'Event' }}
                        </p>

                        <p class="text-xs text-slate-500">
                            Event Category
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Right: Details -->
    <div class="lg:col-span-2 space-y-12">

        <div class="space-y-4">

            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                {{ $event->category->name ?? 'Event' }}
            </span>

            <h1 class="text-4xl md:text-5xl font-black leading-tight">
                {{ $event->title }}
            </h1>

            <div class="flex flex-wrap gap-6 text-slate-500 font-medium">

                <div class="flex items-center gap-2">

                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>

                    <span>
                        {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}
                    </span>

                </div>

                <div class="flex items-center gap-2">

                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                        </path>

                    </svg>

                    <span>
                        {{ $event->location }}
                    </span>

                </div>

            </div>

        </div>

        <!-- Description -->
        <div class="prose prose-slate max-w-none">

            <h3 class="text-2xl font-bold mb-4">
                Deskripsi Event
            </h3>

            <p class="text-lg text-slate-600 leading-relaxed">
                {{ $event->description }}
            </p>

        </div>

        <!-- Ticket Box -->
        <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">

                <div>

                    <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">
                        Harga Tiket
                    </p>

                    <h2 class="text-5xl font-black">
                        @if($event->price == 0)

                        <span class="text-green-600 font-bold text-3xl">

                            GRATIS

                        </span>

                        @else

                        <span class="text-white font-bold text-3xl">

                            Rp {{ number_format($event->price,0,',','.') }}

                        </span>

                        @endif
                        <span class="text-lg font-medium text-indigo-200">
                            / orang
                        </span>
                    </h2>

                    <p class="mt-4 text-indigo-100 flex items-center gap-2">

                        <svg class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>

                        </svg>

                        Sisa stok:
                        <span class="font-bold underline">
                            {{ $event->stock }} Tiket lagi!
                        </span>

                    </p>

                </div>

                <div>

                    <a href="{{ route('checkout.create', $event->id) }}"
                        class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">

                        Pesan Sekarang

                    </a>

                </div>

            </div>

            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>

        </div>

        <!-- Reviews -->
        <div class="space-y-6 rounded-[2rem] border border-slate-200 bg-white p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-black text-slate-900">Ulasan Event</h3>
                    <p class="text-sm text-slate-500">Rata-rata {{ $reviewAverage }} dari {{ $reviewCount }} review</p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-black text-indigo-600">{{ $reviewAverage }}</p>
                    <p class="text-xs text-slate-500">Skor rating</p>
                </div>
            </div>

            @if($event->reviews->count())
            <div class="space-y-4">
                @foreach($event->reviews as $review)
                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="font-bold text-slate-800">{{ $review->customer_name ?: 'Pengguna' }}</p>
                            <p class="text-xs text-slate-500">{{ $review->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="text-amber-500 font-bold">{{ str_repeat('★', $review->rating) }}</div>
                    </div>
                    <p class="mt-3 text-sm text-slate-600">{{ $review->comment ?: 'Tidak ada komentar.' }}</p>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-slate-500">Belum ada review untuk event ini.</p>
            @endif

            @if($isReviewAllowed && $hasSuccessfulTransaction)
            <div class="rounded-2xl border border-indigo-100 bg-indigo-50 p-5">
                <div class="flex items-center justify-between gap-3">
                    <h4 class="text-lg font-bold text-slate-900">{{ $userReview ? 'Edit Review' : 'Tulis Review' }}</h4>
                    @if($userReview)
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">Review sudah ada</span>
                    @endif
                </div>
                <form action="{{ route('events.review', $event->id) }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', $userReview?->customer_name ?? auth()->user()?->name) }}" class="w-full rounded-xl border border-slate-200 px-4 py-3" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email', $userReview?->customer_email ?? auth()->user()?->email) }}" class="w-full rounded-xl border border-slate-200 px-4 py-3" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Rating</label>
                        <select name="rating" class="w-full rounded-xl border border-slate-200 px-4 py-3" required>
                            <option value="">Pilih rating</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('rating', $userReview?->rating) == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                                @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Komentar</label>
                        <textarea name="comment" rows="4" class="w-full rounded-xl border border-slate-200 px-4 py-3" placeholder="Berikan ulasan Anda...">{{ old('comment', $userReview?->comment) }}</textarea>
                    </div>
                    <button type="submit" class="rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white">{{ $userReview ? 'Perbarui Review' : 'Kirim Review' }}</button>
                </form>
            </div>
            @endif
        </div>
        @if(!$isReviewAllowed)
        <div class="rounded-2xl border border-yellow-200 bg-yellow-50 p-5">
            <p class="font-bold text-yellow-800">
                Review belum dapat diberikan.
            </p>

            <p class="mt-2 text-sm text-yellow-700">
                Review hanya dapat diberikan mulai <strong>H+1 setelah event selesai</strong>.
            </p>
        </div>
        @elseif(!$hasSuccessfulTransaction)
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
            <p class="font-bold text-red-700">
                Anda belum dapat memberikan review.
            </p>

            <p class="mt-2 text-sm text-red-600">
                Review hanya dapat diberikan oleh peserta yang telah membeli tiket dengan pembayaran berhasil.
            </p>
        </div>
        @endif

        <!-- Ticket Policy -->
        <div class="space-y-4">

            <h3 class="text-xl font-bold">
                Kebijakan Tiket
            </h3>

            <ul class="space-y-3 text-slate-500">

                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7">
                        </path>
                    </svg>

                    E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                </li>

                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7">
                        </path>
                    </svg>

                    Tiket dapat discan di pintu masuk (Check-in).
                </li>

                <li class="flex items-start gap-2 text-rose-500">
                    <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>

                    Tiket yang sudah dibeli tidak dapat direfund.
                </li>

            </ul>

        </div>

    </div>

</main>
@endsection