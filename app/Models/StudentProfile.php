<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class StudentProfile extends Model
{
    //
    use HasApiTokens, Notifiable;
    protected $fillable  = [
        'siswa_id',
        'nama',
        'nis',
    ];
}
