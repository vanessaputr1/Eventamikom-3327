<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;

/*
|--------------------------------------------------------------------------
| User Area
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/event/{event}', [EventController::class, 'show'])
    ->name('events.show');

// Checkout
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::post('/checkout/{event}', [CheckoutController::class, 'store'])
    ->name('checkout.store');

// My Ticket
Route::get('/my-ticket', [TicketController::class, 'show'])
    ->name('ticket');

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // Login
    Route::get('/', [AdminAuthController::class, 'showLogin']);
    Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('login.post');

    // Register
    Route::get('/register', [AdminAuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AdminAuthController::class, 'register'])
        ->name('register.post');

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'admin'
], function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Kelola Kategori
    Route::resource('categories', AdminCategoryController::class)
        ->except(['show']);

    // Kelola Partner
    Route::resource('partners', AdminPartnerController::class)
        ->except(['show', 'create', 'edit']);

    // Kelola Event
    Route::resource('events', AdminEventController::class);

    // Laporan Transaksi
    Route::get('/transactions', [DashboardController::class, 'transactions'])
        ->name('transactions.index');
});