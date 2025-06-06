<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use Notifiable, HasApiTokens;
    protected $fillable = ["name","password", "admin_id"];
}
