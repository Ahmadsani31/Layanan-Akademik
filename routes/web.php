<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Auth::routes();


    // Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['prefix' => 'petugas'], function(){

Route::get('/login','Auth\LoginController@showLoginForm')->name('login-pet');
Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('register-pet');

        Route::get('/dashboard', 'HomeController@index')->name('dashboard-pet')->middleware('admin');
        Route::get('/dashboard-proses', 'PetugasController@index')->name('dashboard-proses')->middleware('admin');
        Route::get('/pengaduan-show/{id}', 'PetugasController@view')->middleware('admin');
        Route::get('/pengaduan-proses/{id}', 'PetugasController@proses')->middleware('admin');
        Route::get('/pengaduan-detail/{id}', 'LaporanPengaduan@detail')->middleware('admin');

        Route::get('/pengaduan-proses', 'PetugasController@index')->name('pengaduan-proses')->middleware('admin');
        Route::post('/pengaduan-close', 'PetugasController@close')->name('pengaduan-close')->middleware('admin');

        Route::get('/laporan-pengaduan', 'LaporanPengaduan@index')->name('laporan-pengaduan')->middleware('admin');

});




// Route::post('petugas/loginStore','Auth\RegisterController@login')->name('login');
// Route::post('petugas/registerStore','Auth\LoginController@register')->name('register');


Route::group(['prefix' => 'mahasiswa'], function(){

Route::get('/login','AuthMah\LoginController@index')->name('login-mah');
Route::get('/register','AuthMah\RegisterController@index')->name('register-mah');
Route::post('/loginStore','AuthMah\LoginController@loginStore')->name('loginStore-mah');
Route::post('/registerStore','AuthMah\RegisterController@registerStore')->name('registerStore-mah');

            Route::get('/dashboard', 'MahasiswaController@index')->name('dashboard-mah')->middleware('mahasiswa');
            Route::get('/pengaduan-index', 'PengaduanController@index')->name('pengaduan-index')->middleware('mahasiswa');
            Route::get('/pengaduan-create', 'PengaduanController@create')->name('pengaduan-create')->middleware('mahasiswa');
            Route::post('/pengaudan-store','PengaduanController@pengaduanStore')->name('pengaduan-store')->middleware('mahasiswa');

Route::post('singout','AuthMah\LoginController@singout')->name('mahasiswa.logout');
    });


    Route::get('pimpinan/dashboard', 'PimpinanController@index')->name('dashboard-pim');
    Route::get('pimpinan/laporan', 'PimpinanController@show')->name('laporan-pim');
    Route::get('pimpinan/laporan-detail/{id}', 'LaporanPengaduan@detail');
    Route::get('pimpinan/laporan-print/{id}', 'PrintController@print')->name('laporan-print');

    Route::get('pimpinan/chart', 'PimpinanController@chart')->name('laporan-chart');

