<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{

    protected $table = 'pengaduans';

    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class,'id','mahasiswa_id');
    }
}
