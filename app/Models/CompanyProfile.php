<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    //
    protected $fillable = [
        'company_id',
        'name_company',
        'logo',
        'password',
        'status',
    ];
}
