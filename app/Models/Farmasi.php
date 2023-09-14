<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmasi extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = "no_antrian";
    protected $fillable = [
        'id',
        'no_urut',
        'ketegori',
        'status',
        'post_date',
        'created_at',
        'updated_at'

    ];

}
