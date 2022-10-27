<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Namapasien extends Model
{
    use HasFactory;
    protected $table = 'pasien';
    protected $fillable = ['no_reg','no_rawat','tgl_registrasi','jam_reg','kd_dokter','no_rkm_medis','kd_poli','p_jawab',
    'almt_pj','hubunganpj','biaya_reg','stts','stts_daftar','status_lanjut','kd_pj','umurdaftar','sttsumur',
    'status_bayar','status_poli'];
}
