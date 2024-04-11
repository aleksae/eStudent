<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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
        $stanje_racuna = DB::table('uplate')
        ->selectRaw('SUM(iznos) as stanje')
        ->where('user_id', Auth::user()->id)
        ->first();
        $stanje_racuna = $stanje_racuna->stanje;
        return view('home', ['stanje_racuna'=>$stanje_racuna]);
    }
}
