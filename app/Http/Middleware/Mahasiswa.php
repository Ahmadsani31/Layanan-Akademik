<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Mahasiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {

            if (Auth::guard('mahasiswa')) {
                return $next($request);
            }elseif( Auth::guard('admin')){
                return redirect()->route('dashboard-pet');
            }
        }else{
            return redirect('/mahasiswa/login');
        }
    }
}
