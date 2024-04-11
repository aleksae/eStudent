<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveraDaLiJeStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::user()) return back() ->withErrors(['error'=>'Нисте пријављени.']);
        if(Auth::user()->isStudent()) return $next($request);
        else return back() ->withErrors(['error'=>'Немате право да приступите овој страници јер нисте студент.']);
    }
}
