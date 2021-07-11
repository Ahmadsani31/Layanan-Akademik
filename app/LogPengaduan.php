<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPengaduan extends Model
{
    protected $table = 'log_pengaduans';

    protected $guarded = [];

    public function pengaduan()
    {
        return $this->hasOne(Pengaduan::class,'id','pengaduan_id');
    }

    public function petugas()
    {
        return $this->hasOne(Admin::class,'id','petugas_id');
    }
}
