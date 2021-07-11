<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProsesPengaduan extends Model
{
    protected $table = 'proses_pengaduans';

    protected $guarded = [];

    public function pengaduan()
    {
        return $this->hasOne(Pengaduan::class,'id','pengaduan_id');
    }
}
