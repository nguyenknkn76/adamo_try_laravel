<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',         // Add id to fillable
        'name',
        'country',
        'admin1',
        'lat',
        'lon',
        'pop',
    ];
}
