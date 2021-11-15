<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Plan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $plans = Plan::all();
        return view('content.index', ['plans' => $plans]);
    }

    public function listings()
    {
        $listings = Listing::where(['status' => 'active'])->get();
        return view('content.listings', ['listings' => $listings]);
    }
}
