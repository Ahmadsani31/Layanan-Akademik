<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
                if (Auth::user()->level == "petugas") {
                    return $next($request);
                }elseif(Auth::user()->level == "pimpinan") {
                    return redirect()->route('dashboard-pim');
                }
            }elseif( Auth::guard('mahasiswa')){
                return redirect()->route('dashboard-mah');
            }
        }else{
            return redirect('/petugas/login');
        }
    }
}
