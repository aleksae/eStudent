<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = 'username';
    }
    public function username()
    {
        return $this->username;
    }
    protected function authenticated(Request $request, $user) {
        if(!((DB::table('studenti')->where('id_korisnika', $user->id)->get())->isEmpty())){
            return redirect('/');
        }else if(!((DB::table('nastavnici')->where('id_korisnik', $user->id)->get())->isEmpty())){
            $string = $user->ime."-".$user->prezime."-".($user->id*37+17);
            return redirect()->route('zap.profil',$string);
        }else if(!((DB::table('ostali_zaposleni')->where('id_korisnik', $user->id)->get())->isEmpty())){
            return redirect()->route('ss.pregled_rokova');
        }

   }
}

