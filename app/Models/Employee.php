<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable =
    [
        'first_name',
        'last_name',
        'email',
        'password',
        'position'
    ];
}
