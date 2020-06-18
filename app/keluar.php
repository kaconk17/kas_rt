<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class keluar extends Model
{
    protected $fillable = [
        'id_keluar',
        'id_input',
        'tgl_keluar',
        'jumlah',
        'periode',
        'keterangan',
        'tgl_closing',
        
    ];

    public $incrementing = false;
    protected $table = 'kas_keluar';
    protected $primaryKey = "id_keluar";
}
