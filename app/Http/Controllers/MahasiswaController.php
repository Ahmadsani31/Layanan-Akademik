<?php

namespace App\Http\Controllers;

use App\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $peng = Pengaduan::where('mahasiswa_id', Auth::guard('mahasiswa')->user()->id)->get();
        $selesai = Pengaduan::where('mahasiswa_id', Auth::guard('mahasiswa')->user()->id)->
                            where('status','=','SELESAI')->get();

        $tots = $selesai->count();
        $tot = $peng->count();

        return view('mahasiswa.dashboard',compact('tot','tots'));
    }
}
