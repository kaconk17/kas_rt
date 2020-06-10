<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogModel extends Model
{
    protected $table = 'tb_log';
    protected $primaryKey = "id_log";
    public $incrementing = false;
    protected $casts = [
        'message' => 'array',
    ];
    protected $fillable = [
        'id_log',
        'id_user',
        'activity',
        'message',
    ];
}
