<?php

namespace App\Http\Controllers;

use App\Admin;
use App\LogPengaduan;
use App\Mahasiswa;
use App\Pengaduan;
use App\ProsesPengaduan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
class PimpinanController extends Controller
{
    public function index()
    {
        $pengaduan = Pengaduan::all();
        $total = $pengaduan->count();
        $pengaduan_proses = Pengaduan::where('status','=','DIPROSES')->get();
        $proses = $pengaduan_proses->count();

        $pengaduan_close = Pengaduan::where('status','=','SELESAI')->get();
        $close = $pengaduan_close->count();

        return view('pimpinan.dashboard',compact('total','proses','close'));
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            $data = Pengaduan::where('status','=','SELESAI')->get();
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
                        $action = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id='.$data->id.' data-original-title="Edit" class="edit btn btn-sm btn-primary edit-detail">
                        <i class="fa fa-eye"></i> Detail
                        </a><a href="laporan-print/'.$data->id.' "target="_blank" class="btn btn-default btn-sm detailPinjaman"><i class="fa fa-print"></i> Print</a>';
                        return $action;
                        })
                    // ->addColumn('image', 'image')
                    ->rawColumns(['action','layanan','mahasiswa','keterangan','status'])
                    ->make(true);
        }
        return view('pimpinan.laporan');
    }

    public function detail(Request $request, $id)
    {



        if ($request->ajax()) {
            $pengaduan = '';
            $log= '';



                $data = Pengaduan::where('id', $id)->get();

                $peng = Pengaduan::findOrFail($id);

        foreach($data as $row)
        {
            $pengaduan .= '
            <tr>
            <td>'.$row->kode_tiket.'</td>
            <td>'.$row->jenis_layanan.'</td>
            <td>'.$row->keterangan.'</td>
            <td><img src=/images/pengaduan/'.$row->image_pengaduan.' width="100" class="img-thumbnail" /></td>

            <td><span class="badge bg-success">'.$row->status.'</span></td>
            </tr>
            ';
        }

        $datalog = LogPengaduan::where('pengaduan_id',$id)->get();
        foreach($datalog as $lg)
        {
            $log .= '
            <tr>
            <td>'.$lg->petugas->name.'</td>
            <td>'.$lg->keterangan.'</td>
            <td>'.$lg->created_at->format('D, d-M-y H:i').'</td>
            </tr>
            ';
        }
        $mah = Mahasiswa::findOrFail($peng->mahasiswa_id);
        $pet = Admin::findOrFail($lg->petugas_id);
        $tg = ProsesPengaduan::where('pengaduan_id', $id)->first();

        $data = array(
            'table_data'  => $pengaduan,
            'table_log'  => $log,

            'nama' => $mah->name,
            'no_induk' => $mah->no_induk,
            'email' => $mah->email,
            'falkultas' => $mah->falkultas,
            'jurusan' => $mah->jurusan,

            'kode_tiket' => $peng->kode_tiket,
            'image_pengaduan' => $peng->image_pengaduan,
            'waktu' => $peng->created_at->format('d-m-Y'),

            'nama_pet' => $pet->name,
            'email_pet' => $pet->email,

            'tangapan' => $tg->keterangan,

           );
        }


        // $p = Pengaduan::findOrFail($id);
        // $p = ProsesPengaduan::with('pengaduan')->where('id',$id)->get();
        return response()->json($data);
    }

    public function chart()
    {
      $result = DB::table('pengaduans')
                  ->where('status','=','SELESAI')
                  ->orderBy('created_at', 'ASC')
                  ->get();
      return response()->json($result);
    }
}
