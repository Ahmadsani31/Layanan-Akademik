<?php

namespace App\Http\Controllers;

use App\Pengaduan;
use App\ProsesPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PengaduanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:mahasiswa');
    }
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

        return view('mahasiswa.pengaduan-index');
    }

    public function dataPengaduan(Request $request){

    }

    public function create()
    {
        return view('mahasiswa.pengaduan-create');
    }

    public function pengaduanStore(Request $request)
    {
        // dd($request->file('image_pengaduan'));
        request()->validate([
            'image_pengaduan' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
       ]);


        $uploadId = $request->upload_id;
       $no = rand(1000,9999);

        if ($request->jenis_layanan == 'akademik') {
            $code = 'AKD-'.$no;
        }else if($request->jenis_layanan == 'keuangan'){
            $code = 'KEU-'.$no;
        }

        $details = ['mahasiswa_id' => Auth::guard('mahasiswa')->user()->id,
                    'kode_tiket' => $code,
                    'jenis_layanan' => $request->jenis_layanan,
                    'keterangan' => $request->keteragan,

                ];

        if ($files = $request->file('image_pengaduan')) {

           //delete old file

           //insert new file
           $destinationPath = 'images/pengaduan/'; // upload path
           $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
           $files->move($destinationPath, $profileImage);
           $details['image_pengaduan'] = "$profileImage";
        }

        Pengaduan::create($details);

        return redirect()->route('pengaduan-index')
        ->with('success','Product created successfully.');
    }


}
