<!DOCTYPE html>
<html>
<head>
    <title>Katalog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-100 min-h-screen">

<!-- NAVBAR -->
<nav class="bg-white shadow-md p-4 flex justify-between items-center">
    <div class="font-bold text-lg text-blue-500">
        EventAmikom
    </div>
    <div class="space-x-6">
        <a href="/" class="hover:text-blue-500">Home</a>
        <a href="/profil" class="hover:text-blue-500">Profil</a>
        <a href="/katalog" class="text-blue-500 font-bold">Katalog</a>
        <a href="/bantuan" class="hover:text-blue-500">Bantuan</a>
        <a href="/kontak" class="hover:text-blue-500">Kontak</a>
    </div>
</nav>

<!-- CONTENT -->
<div class="p-10">

    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">
        Katalog Event
    </h1>

    <!-- GRID CARD -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- CARD 1 -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition">
            <div class="p-4">
                <h2 class="font-bold text-lg">Workshop Web</h2>
                <p class="text-sm text-gray-600">Belajar Laravel dari dasar</p>
                <button class="mt-3 bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                    Detail
                </button>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition">
            <!-- <img src=""> -->
            <div class="p-4">
                <h2 class="font-bold text-lg">Seminar AI</h2>
                <p class="text-sm text-gray-600">Mengenal AI & Machine Learning</p>
                <button class="mt-3 bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">
                    Detail
                </button>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition">
            <!-- <img src=""> -->
            <div class="p-4">
                <h2 class="font-bold text-lg">Bootcamp Coding</h2>
                <p class="text-sm text-gray-600">Belajar coding intensif 7 hari</p>
                <button class="mt-3 bg-purple-500 text-white px-4 py-1 rounded hover:bg-purple-600">
                    Detail
                </button>
            </div>
        </div>

    </div>

</div>

</body>
</html>