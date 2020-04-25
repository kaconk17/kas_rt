<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $fillable = [
        'id_record',
        'id_masuk',
        'id_keluar',
        'jenis',
        'tgl_transaksi',
        'jumlah',
        'periode',
        'keterangan',
        
    ];

    public $incrementing = false;
    protected $table = 'transaksi';
    protected $primaryKey = "id_record";
}
