<?php

namespace App\Http\Controllers;

use App\Pengaduan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pengaduan::where('status','=','TERKIRIM')->
            orWhere('status','=','DITERIMA')
            ->get();
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
                        $action = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id='.$data->id.' data-original-title="Edit" class="edit btn btn-sm btn-primary edit-product">
                        Show
                    </a>';
                        return $action;
                        })
                    // ->addColumn('image', 'image')
                    ->rawColumns(['action','layanan','mahasiswa','keterangan','status'])
                    ->make(true);
        }

        $pengaduan = Pengaduan::all();
        $total = $pengaduan->count();
        $pengaduan_proses = Pengaduan::where('status','=','DIPROSES')->get();
        $proses = $pengaduan_proses->count();

        $pengaduan_close = Pengaduan::where('status','=','SELESAI')->get();
        $close = $pengaduan_close->count();
        return view('petugas.dashboard', compact('total','proses','close'));
    }
}
