<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\OrganizerController as AdminOrganizerController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Organizer\AuthController as OrganizerAuthController;
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\Organizer\TransactionController as OrganizerTransactionController;
use App\Http\Controllers\Organizer\ReviewController as OrganizerReviewController;
use App\Http\Controllers\Organizer\ProfileController as OrganizerProfileController;
/*
|--------------------------------------------------------------------------
| User Area
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/event/{event}', [EventController::class, 'show'])
    ->name('events.show');

Route::post('/event/{event}/review', [EventController::class, 'storeReview'])
    ->name('events.review');

Route::get('/login', [UserAuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [UserAuthController::class, 'login'])
    ->name('user.login.post');

Route::get('/login/google', [UserAuthController::class, 'redirectToGoogle'])
    ->name('user.login.google');

Route::get('/login/google/callback', [UserAuthController::class, 'handleGoogleCallback'])
    ->name('user.login.google.callback');

Route::post('/logout', [UserAuthController::class, 'logout'])
    ->name('user.logout');

// Checkout
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::post('/checkout/{event}', [CheckoutController::class, 'store'])
    ->name('checkout.store');
Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

// My Ticket
Route::get('/my-ticket', [TicketController::class, 'show'])
    ->name('ticket');

Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);

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

Route::group(['prefix' => 'organizer', 'as' => 'organizer.'], function () {
    Route::get('/login', [OrganizerAuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [OrganizerAuthController::class, 'login'])
        ->name('login.post');

    Route::post('/logout', [OrganizerAuthController::class, 'logout'])
        ->name('logout');
});

Route::group([
    'prefix' => 'organizer',
    'as' => 'organizer.',
    'middleware' => 'organizer'
], function () {
    Route::get('/dashboard', [OrganizerDashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('events', OrganizerEventController::class);

    Route::get('/transactions', [OrganizerTransactionController::class, 'index'])
        ->name('transactions.index');

    Route::get('/reviews', [OrganizerReviewController::class, 'index'])
        ->name('reviews.index');

    Route::get('/profile', [OrganizerProfileController::class, 'index'])
    ->name('profile');
    
    Route::get('/register', [OrganizerAuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [OrganizerAuthController::class, 'register'])
        ->name('register.post');
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

    Route::get('/organizers', [AdminOrganizerController::class, 'index'])
        ->name('organizers.index');

    Route::put('/organizers/{organizer}', [AdminOrganizerController::class, 'update'])
        ->name('organizers.update');

    Route::get('/reviews', [AdminReviewController::class, 'index'])
        ->name('reviews.index');

    Route::patch('/reviews/{review}/moderate', [AdminReviewController::class, 'moderate'])
        ->name('reviews.moderate');
});
