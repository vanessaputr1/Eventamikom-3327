@extends('layouts.admin', ['title' => 'Kelola Organizer'])

@section('content')

<header class="mb-10">
    <h1 class="text-3xl font-black text-slate-800">
        Kelola Organizer
    </h1>

    <p class="text-slate-500 mt-2">
        Kelola seluruh organizer yang terdaftar di AmikomEventHub.
    </p>
</header>

@if(session('success'))
<div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-6 py-4 text-green-700 font-semibold">
    {{ session('success') }}
</div>
@endif

{{-- Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
        <p class="text-sm text-slate-500">Total Organizer</p>
        <h2 class="mt-3 text-4xl font-black text-slate-800">
            {{ $organizers->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
        <p class="text-sm text-slate-500">Approved</p>
        <h2 class="mt-3 text-4xl font-black text-green-600">
            {{ $organizers->where('status','approved')->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
        <p class="text-sm text-slate-500">Pending</p>
        <h2 class="mt-3 text-4xl font-black text-yellow-500">
            {{ $organizers->where('status','pending')->count() }}
        </h2>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
        <p class="text-sm text-slate-500">Total Event</p>
        <h2 class="mt-3 text-4xl font-black text-indigo-600">
            {{ $organizers->sum(fn($item) => $item->events->count()) }}
        </h2>
    </div>

</div>

<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">

    <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center">

        <div>
            <h2 class="text-xl font-black">
                Daftar Organizer
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Informasi organizer beserta status akun.
            </p>
        </div>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-slate-50">

                <tr class="text-left text-xs uppercase tracking-wider text-slate-500">

                    <th class="px-8 py-4">No</th>
                    <th class="px-8 py-4">Organizer</th>
                    <th class="px-8 py-4">Email</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Transaksi</th>
                    <th class="px-8 py-4">Aksi</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($organizers as $organizer)

                <tr class="hover:bg-slate-50 transition">

                    <td class="px-8 py-6 font-bold text-slate-500">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-8 py-6">

                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-black">

                                {{ strtoupper(substr($organizer->name,0,2)) }}

                            </div>

                            <div>

                                <p class="font-bold text-slate-800">
                                    {{ $organizer->name }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    Organizer Event
                                </p>

                            </div>

                        </div>

                    </td>

                    <td class="px-8 py-6 text-slate-600">
                        {{ $organizer->user->email }}
                    </td>

                    <td class="px-8 py-6">

                        @if($organizer->status=='approved')

                        <span class="rounded-full bg-green-100 text-green-700 px-4 py-2 text-xs font-bold">
                            Approved
                        </span>

                        @elseif($organizer->status=='pending')

                        <span class="rounded-full bg-yellow-100 text-yellow-700 px-4 py-2 text-xs font-bold">
                            Pending
                        </span>

                        @else

                        <span class="rounded-full bg-red-100 text-red-700 px-4 py-2 text-xs font-bold">
                            Suspended
                        </span>

                        @endif

                    </td>

                    <td class="px-8 py-6">

                        <span class="font-bold text-indigo-600">
                            {{ $organizer->events->count() }}
                        </span>

                    </td>

                    <td class="px-8 py-6">

                        <span class="font-bold text-slate-700">
                            {{ $organizer->transactions->count() }}
                        </span>

                    </td>

                    <td class="px-8 py-6">

                        <form action="{{ route('admin.organizers.update',$organizer) }}"
                            method="POST"
                            class="space-y-3">

                            @csrf
                            @method('PUT')

                            <select
                                name="status"
                                class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm">

                                <option value="pending"
                                    {{ $organizer->status=='pending' ? 'selected' : '' }}>
                                    Pending
                                </option>

                                <option value="approved"
                                    {{ $organizer->status=='approved' ? 'selected' : '' }}>
                                    Approved
                                </option>

                                <option value="suspended"
                                    {{ $organizer->status=='suspended' ? 'selected' : '' }}>
                                    Suspended
                                </option>

                            </select>

                            <button
                                type="submit"
                                class="w-full rounded-xl bg-indigo-600 py-2 font-bold text-white hover:bg-indigo-700 transition">

                                Update

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" class="px-8 py-10 text-center text-slate-500">

                        Belum ada organizer.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-8">

    {{ $organizers->links() }}

</div>

@endsection