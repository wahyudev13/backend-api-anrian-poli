<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntrianPoliPKU extends Model
{
    use HasFactory;
    protected $primaryKey = 'no_rawat';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'antrian_poli_pku';
    protected $fillable = ['no_rawat','waktu'];
}
