<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Organizer Dashboard' }} - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 flex min-h-screen">
    <aside class="w-72 bg-indigo-900 text-indigo-100 flex flex-col p-6 space-y-6 sticky top-0 h-screen">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
            <span class="text-xl font-bold text-white tracking-tight">Organizer Panel</span>
        </div>
        <nav class="flex-1 space-y-2">
            <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-indigo-800 transition">Dashboard</a>
            <a href="{{ route('organizer.events.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-indigo-800 transition">Event Saya</a>
            <a href="{{ route('organizer.transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-indigo-800 transition">Transaksi</a>
            <a href="{{ route('organizer.reviews.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-indigo-800 transition">Review</a>
            <a href="{{ route('organizer.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold hover:bg-indigo-800 transition">Profil</a>
        </nav>
        <form action="{{ route('organizer.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full rounded-2xl bg-white text-slate-900 px-4 py-3 font-bold">Logout</button>
        </form>
    </aside>
    <main class="flex-1 p-10 overflow-y-auto">
        @yield('content')
    </main>
</body>
</html>
