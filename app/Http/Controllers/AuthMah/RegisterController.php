<?php

namespace App\Http\Controllers\AuthMah;

use App\Http\Controllers\Controller;
use App\Mahasiswa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    public function index()
    {
        return view('mahasiswa.auth.register');
    }

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function username()
    {
        return 'no_induk';
    }

    public function registerStore(Request $request)
    {
        // dd($request);
        $rules = [
            'name'                  => 'required',
            'no_induk'              => 'required|unique:mahasiswas,no_induk',
            'email'                 => 'required|email',
            'nope'                  => 'required',
            'password'              => 'required|confirmed',
            'falkultas'              => 'required',
            'jurusan'               => 'required',


        ];

        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'falkutas.required'        => 'Falkutas wajib diisi',
            'jurusan.required'        => 'Jursan wajib diisi',
            'nope.required'        => 'No Hp wajib diisi',
            'no_induk.required'        => 'No Induk mahasiswa wajib diisi',
            'no_induk.unique'          => 'No Induk mahasiswa sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $mahasiswa = new Mahasiswa();
        $mahasiswa->name = ucwords(strtolower($request->name));
        $mahasiswa->email = strtolower($request->email);
        $mahasiswa->no_induk = $request->no_induk;
        $mahasiswa->password = Hash::make($request->password);
        $mahasiswa->email_verified_at = \Carbon\Carbon::now();
        $mahasiswa->nope = $request->nope;
        $mahasiswa->falkultas = $request->falkultas;
        $mahasiswa->jurusan = $request->jurusan;
        $mahasiswa->level = 'mahasiswa';
        $simpan = $mahasiswa->save();

        if($simpan){
            Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
            return redirect()->route('login-mah');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('register-mah');
        }
    }
}
