<?php

namespace App\Http\Controllers;

use App\Forum;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $latestAnnouncement = Forum::findOrFail(1)
            ->latestAnnouncement();
        return view('home', compact('latestAnnouncement'));
    }
}
