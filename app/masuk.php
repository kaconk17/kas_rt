<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class masuk extends Model
{
    protected $fillable = [
        'id_masuk',
        'id_input',
        'id_warga',
        'tgl_bayar',
        'jenis',
        'jumlah',
        'periode',
        'keterangan',
        
    ];

    public $incrementing = false;
    protected $table = 'kas_masuk';
    protected $primaryKey = "id_masuk";
}
