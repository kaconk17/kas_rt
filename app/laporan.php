<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class laporan extends Model
{
    protected $fillable = [
        'id_laporan',
        'tgl_laporan',
        'id_input',
        'periode',
        'saldo_awal',
        'total_masuk',
        'total_keluar',
        'saldo_akhir',
        'keterangan',
        
    ];

    public $incrementing = false;
    protected $table = 'laporan';
    protected $primaryKey = "id_laporan";
}
