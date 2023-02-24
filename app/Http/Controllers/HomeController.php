<?php

namespace App\Http\Controllers;

use App\Models\client_bots;
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
        return view('home');
    }

    public function CheckClientBotsStatus() {
        $now = date('Y-m-d H:i:s');
        client_bots::where('status', '1')->where('termino', '<', $now)->update(['status' => '0']);


    }
}
