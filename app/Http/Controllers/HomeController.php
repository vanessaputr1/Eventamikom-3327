<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //method index
    public function index()
    {
        return view('welcome');
    }
}
