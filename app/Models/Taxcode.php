<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxcode extends Model
{
    use HasFactory;
    protected $fillable = [
        'nameofproduct',
        'taxcode',
        'user_id',

    ];
}
