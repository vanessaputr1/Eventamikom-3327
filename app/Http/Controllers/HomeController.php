<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Category;
use App\Models\Event;

class HomeController extends Controller
{
    // method index
    public function index()
    {
        $partners = Partner::latest()->get();
        $categories = Category::latest()->get();
        $events = Event::latest()->get();

        return view('welcome', compact(
            'partners',
            'categories',
            'events'
        ));
    }
}