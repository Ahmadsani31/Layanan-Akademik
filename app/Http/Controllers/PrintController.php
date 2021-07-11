<?php

namespace App\Http\Controllers;

use App\Admin;
use App\LogPengaduan;
use App\Mahasiswa;
use App\Pengaduan;
use App\ProsesPengaduan;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function print(Request $request, $id)
    {

        $peng = Pengaduan::findOrFail($id);
        $p = Pengaduan::where('id',$id)->get();
        $log = LogPengaduan::where('pengaduan_id',$id)->get();
        $tg = ProsesPengaduan::where('pengaduan_id', $id)->first();

        $mah = Mahasiswa::findOrFail($peng->mahasiswa_id);
        $pet = Admin::findOrFail($tg->petugas_id);

        return view('pimpinan.laporan-print',compact('peng','p','log','tg','mah','pet'));
    }
}
