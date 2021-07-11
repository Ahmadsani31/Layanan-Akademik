<?php

namespace App\Http\Controllers\AuthMah;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    protected $guardName = 'mahasiswa';

    public function index()
    {
        return view('mahasiswa.auth.login');
    }

    public function __construct()
    {
        $this->middleware('guest:mahasiswa')->except('logout');
    }

    public function username()
    {
        return 'no_induk';
    }

    public function loginStore(Request $request)
    {
// dd($request);

        $rules = [
            'no_induk'              => 'required',
            'password'              => 'required|string'
        ];

        $messages = [
            'no_induk.required'     => 'No Induk Mahasiswa wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'no_induk'     => $request->input('no_induk'),
            'password'  => $request->input('password'),
        ];


        if(Auth::guard('mahasiswa')->attempt($data))
            {
                return redirect()->intended(route('dashboard-mah'));
            }else{
            return redirect()->back()->withInput($request->only('no_induk'));

            }

    }

    public function singout(Request $request)
    {
        // dd($request);
        // $this->guard('costumer')->except('logout');
        Auth::guard('mahasiswa')->logout(); // menghapus session yang aktif
        // Session::flush();
        return redirect('/');
    }
}
