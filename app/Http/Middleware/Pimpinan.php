<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Pimpinan
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

            if (Auth::guard('admin')) {
                if (Auth::user()->level == "pimpinan") {
                    return $next($request);
                }elseif(Auth::user()->level == "petugas") {
                    return redirect()->route('dashboard-pet');
                }
            }elseif( Auth::guard('mahasiswa')){
                return redirect()->route('dashboard-mah');
            }
        }else{
            return redirect('/petugas/login');
        }
    }
}
