<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xmlimport extends Model
{
    use HasFactory;
    protected $fillable = [
        'countrycode',
        'xmlpack_id',
        'description',


    ];
}
