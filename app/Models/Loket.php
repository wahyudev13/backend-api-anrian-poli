<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loket extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'kd';
    protected $table = 'mlite_antrian_loket';
    protected $fillable = [
        'kd',
        'type',
        'noantrian',
        'no_rkm_medis',
        'postdate',
        'start_time',
        'end_time',
        'status',
        'loket'
    ];
}
