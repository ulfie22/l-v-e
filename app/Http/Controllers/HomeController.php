<?php

namespace App\Http\Controllers;

use App\Messages;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $mess = Messages::all()->last();
        $media = $mess->getMedia('message-images');
        $i = $media[0];
        $u = $i->getFullUrl();
        return view('home', ['url' => $u]);
    }
}
