<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CompanyProfile extends Model
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'company_id',
        'name_company',
        'logo',
        'password',
        'status',
    ];
}
