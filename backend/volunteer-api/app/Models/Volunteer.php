<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'country_code',
        'mobile',
        'profile_image',
        'status'
    ];
}
