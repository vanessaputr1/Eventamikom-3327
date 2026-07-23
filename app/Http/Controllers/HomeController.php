<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Partner;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $partners = Schema::hasTable('partners') ? Partner::latest()->get() : collect();
        $categories = Schema::hasTable('categories') ? Category::latest()->get() : collect();
        $events = Schema::hasTable('events') ? Event::latest()->get() : collect();

        return view('welcome', compact(
            'partners',
            'categories',
            'events'
        ));
    }
}