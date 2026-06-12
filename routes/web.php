<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/tentang', function () {
//     return '<h1>Ini adalah Halaman Tentang Aplikasi Event Hub</h1>';
// });

// Route::get('/kontak', function () {
//     return view('contact');
// });

// Route::get('/profil', function () {
//     return view('profil');
// });

// Route::get('/katalog', function () {
//     return view('katalog');
// });

// Route::get('/bantuan', function () {
//     return view('bantuan');
// });

// Rute User Area
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/event/1', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [TicketController::class, 'show'])->name('ticket');

// Rute Admin Auth
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Login & Register (tidak perlu auth)
    Route::get('/', [AdminAuthController::class, 'showLogin']);
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register.post');
    
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Rute Admin Area (memerlukan auth admin)
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Kelola Kategori
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Kelola Partner
    Route::resource('partners', AdminPartnerController::class)->except(['show', 'create', 'edit']);

    // Kelola Event
    // Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    Route::resource('events', AdminEventController::class);
    
    // Laporan Transaksi
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions.index');
});