<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;
    protected $table = 'antripoli_custom';
    protected $fillable = ['kd_dokter','kd_poli','status','no_rawat','no_reg','no_rkm_medis','updated_at','tgl'];
}
