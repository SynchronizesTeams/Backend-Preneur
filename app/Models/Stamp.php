<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    protected $fillable = [
        'siswa_id',
        'company_id',
        'stamp_id',
        'company_stamp',
    ];
}
