<?php

namespace App\Http\Controllers;

use App\Pengaduan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Pengaduan::all();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('waktu', function($data){
                        $waktu = $data->created_at->format('D, d M y');
                        return $waktu;
                        })
                    ->editColumn('layanan', function($data){
                        $type = $data->jenis_layanan;
                        return $type;
                    })
                    ->editColumn('kode', function($data){
                        $kode = $data->kode_tiket;
                        return $kode;
                    })
                    ->editColumn('mahasiswa', function($data){
                        $mahasiswa = $data->mahasiswa->name;
                        return $mahasiswa;
                    })
                    ->editColumn('keterangan', function($data){
                        $keterangan = $data->keterangan;
                        return $keterangan;
                    })
                    ->editColumn('image', function($data){
                        $image = $data->image_pengaduan;
                        return $image;
                    })
                    ->editColumn('status', function($data){
                        if ($data->status == 'TERKIRIM') {
                            $status = '<span class="badge bg-info">'.$data->status.'</span>';

                            }else if ($data->status == 'DITERIMA') {
                                $status = '<span class="badge bg-warning">'.$data->status.'</span>';

                            }else if ($data->status == 'DIPROSES') {
                                $status = '<span class="badge bg-primary">'.$data->status.'</span>';

                            }else if ($data->status == 'SELESAI') {
                                $status = '<span class="badge bg-success">'.$data->status.'</span>';
                            }
                        return $status;
                    })
                    ->addColumn('action', function($data){
                        $action = '<button type="button" id="deleteType" data-id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fa fa-eraser"></i></button>';
                        return $action;
                        })
                    // ->addColumn('image', 'image')
                    ->rawColumns(['action','layanan','mahasiswa','keterangan','status'])
                    ->make(true);
        }

        return view('welcome');
    }
}
