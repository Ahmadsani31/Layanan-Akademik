<?php

namespace App\Http\Controllers;

use App\LogPengaduan;
use App\Pengaduan;
use App\ProsesPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Pengaduan::where('status','=','DIPROSES')->get();
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
                        $action = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id='.$data->id.' data-original-title="Edit" class="edit btn btn-sm btn-primary edit-proses">
                        PROSES
                    </a>';
                        return $action;
                        })
                    // ->addColumn('image', 'image')
                    ->rawColumns(['action','layanan','mahasiswa','keterangan','status'])
                    ->make(true);
        }
        return view('petugas.pengaduan-proses');
    }

    public function view($id)
    {
        $peng = Pengaduan::findOrFail($id);

        if ($peng->status == 'TERKIRIM') {
            DB::transaction(function () use($id, $peng){
                $nilai = [
                    'status'       => 'DITERIMA',
                ];
                Pengaduan::updateOrCreate(['id' => $id], $nilai);

                $log_data=[
                    'pengaduan_id' => $id,
                    'mahasiswa_id' =>$peng->mahasiswa_id,
                    'petugas_id' => Auth::user()->id,
                    'keterangan' => 'DITERIMA',
                ];
                LogPengaduan::create($log_data);
            });
        }

        return response()->json($peng);
    }

    public function proses($id)
    {
        $peng = Pengaduan::findOrFail($id);

        DB::transaction(function () use($id, $peng) {
            $nilai = [
                'status'       => 'DIPROSES',
            ];
            Pengaduan::updateOrCreate(['id' => $id], $nilai);

            $log_data=[
                'pengaduan_id' => $id,
                'mahasiswa_id' =>$peng->mahasiswa_id,
                'petugas_id' => Auth::user()->id,
                'keterangan' => 'DIPROSES',
            ];
            LogPengaduan::create($log_data);
        });


        return response()->json($peng);
    }

    public function close(Request $request){

        DB::transaction(function () use($request) {

            $nilai = [
                'status'       => 'SELESAI',
            ];
            Pengaduan::updateOrCreate(['id' => $request->id_pengajuan], $nilai);
            $log_data=[
                'pengaduan_id' => $request->id_pengajuan,
                'mahasiswa_id' => $request->id_mahasiswa,
                'petugas_id' => Auth::user()->id,
                'keterangan' => 'SELESAI',
            ];
            LogPengaduan::create($log_data);

            $validatedData = [
                'pengaduan_id' => $request->id_pengajuan,
                'mahasiswa_id' =>$request->id_mahasiswa,
                'petugas_id' => Auth::user()->id,
                'keterangan' => $request->ket,

            ];
            ProsesPengaduan::create($validatedData);
        });

    }
}
