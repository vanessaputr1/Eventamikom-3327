@extends('layouts.admin', ['title' => 'Kelola Kategori'])

@section('content')
<main class="flex-1 p-10 overflow-y-auto">
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10">
        <div>
            <h1 class="text-3xl font-black">Kelola Kategori</h1>
            <p class="text-slate-500 font-medium">
                Tambahkan, ubah, dan hapus kategori event.
            </p>
        </div>

        <!-- Button Tambah -->
        <button id="openCreateModal"
            class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-white font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition">
            + Tambah Kategori
        </button>
    </header>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-3xl text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="p-8 border-b">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h2 class="text-xl font-bold">Daftar Kategori</h2>
                    <p class="text-slate-500 mt-2">
                        ID, nama, tanggal dibuat, dan tanggal diperbarui.
                    </p>
                </div>

                <!-- Live Search -->
                <form class="flex items-center gap-2 w-full sm:w-auto">

                    <input type="text"
                        id="searchInput"
                        placeholder="Cari kategori..."
                        autocomplete="off"
                        class="h-12 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 w-full sm:w-64 transition">
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Dibuat</th>
                        <th class="px-6 py-4">Diubah</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y border-t">

                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50 transition category-row">

                            <td class="px-6 py-5 text-sm font-bold text-slate-700">
                                {{ $category->id }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-600 category-name">
                                {{ $category->name }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-500">
                                {{ $category->created_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-500">
                                {{ $category->updated_at->format('d M Y') }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-600 flex items-center gap-2">

                                <!-- Edit -->
                                <button type="button"
                                    class="edit-category inline-flex items-center justify-center rounded-xl border border-indigo-100 bg-indigo-50 p-3 text-indigo-600 hover:bg-indigo-100 transition"
                                    data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}"
                                    aria-label="Edit kategori">

                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>

                                <!-- Delete -->
                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                    method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Hapus kategori ini?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-xl bg-rose-50 p-3 text-rose-600 hover:bg-rose-100 transition"
                                        aria-label="Hapus kategori">

                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5"
                                class="px-6 py-10 text-center text-slate-500">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div id="createModal"
        class="fixed inset-0 hidden items-center justify-center bg-slate-900/50 p-4 z-50">

        <div class="w-full max-w-lg rounded-3xl bg-white shadow-2xl overflow-hidden">

            <div class="flex items-center justify-between border-b px-6 py-5">
                <div>
                    <h3 class="text-xl font-bold">Tambah Kategori</h3>
                    <p class="text-slate-500 text-sm">
                        Tambahkan kategori baru.
                    </p>
                </div>

                <button id="closeCreateModal"
                    class="text-slate-500 hover:text-slate-900">
                    Tutup
                </button>
            </div>

            <form action="{{ route('admin.categories.store') }}"
                method="POST"
                class="space-y-6 p-6">

                @csrf

                <div>
                    <label for="name"
                        class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Kategori
                    </label>

                    <input type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition">

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-white font-bold hover:bg-indigo-700 transition">
                        Tambah Kategori
                    </button>

                    <button type="button"
                        id="cancelCreateModal"
                        class="w-full inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal"
        class="fixed inset-0 hidden items-center justify-center bg-slate-900/50 p-4 z-50">

        <div class="w-full max-w-lg rounded-3xl bg-white shadow-2xl overflow-hidden">

            <div class="flex items-center justify-between border-b px-6 py-5">
                <div>
                    <h3 class="text-xl font-bold">Edit Kategori</h3>
                    <p class="text-slate-500 text-sm">
                        Ubah nama kategori.
                    </p>
                </div>

                <button id="closeModal"
                    class="text-slate-500 hover:text-slate-900">
                    Tutup
                </button>
            </div>

            <form id="editForm"
                method="POST"
                class="space-y-6 p-6">

                @csrf
                @method('PUT')

                <div>
                    <label for="edit_name"
                        class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Kategori
                    </label>

                    <input type="text"
                        name="name"
                        id="edit_name"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition">
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-white font-bold hover:bg-indigo-700 transition">
                        Simpan Perubahan
                    </button>

                    <button type="button"
                        id="cancelEdit"
                        class="w-full inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // CREATE MODAL
        const createModal = document.getElementById('createModal');
        const openCreateModal = document.getElementById('openCreateModal');
        const closeCreateModal = document.getElementById('closeCreateModal');
        const cancelCreateModal = document.getElementById('cancelCreateModal');

        const openCreate = () => {
            createModal.classList.remove('hidden');
            createModal.classList.add('flex');
        };

        const closeCreate = () => {
            createModal.classList.add('hidden');
            createModal.classList.remove('flex');
        };

        openCreateModal.addEventListener('click', openCreate);
        closeCreateModal.addEventListener('click', closeCreate);
        cancelCreateModal.addEventListener('click', closeCreate);

        createModal.addEventListener('click', (e) => {
            if (e.target === createModal) {
                closeCreate();
            }
        });

        // EDIT MODAL        
        const editButtons = document.querySelectorAll('.edit-category');
        const modal = document.getElementById('editModal');
        const closeModal = document.getElementById('closeModal');
        const cancelEdit = document.getElementById('cancelEdit');
        const editForm = document.getElementById('editForm');
        const editName = document.getElementById('edit_name');

        const openModal = (id, name) => {
            editForm.action = `/admin/categories/${id}`;
            editName.value = name;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        };

        const close = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                openModal(button.dataset.id, button.dataset.name);
            });
        });

        closeModal.addEventListener('click', close);
        cancelEdit.addEventListener('click', close);

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                close();
            }
        });

        // LIVE SEARCH
        const searchInput = document.getElementById('searchInput');
        const categoryRows = document.querySelectorAll('.category-row');

        searchInput.addEventListener('keyup', function () {

            const keyword = this.value.toLowerCase();

            categoryRows.forEach(row => {

                const categoryName = row
                    .querySelector('.category-name')
                    .textContent
                    .toLowerCase();

                if (categoryName.includes(keyword)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

    });
</script>
@endsection