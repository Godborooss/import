<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xmlpack extends Model
{
    use HasFactory;
    protected $fillable = [
        'exporter',
        'use_id',

    ];
}
