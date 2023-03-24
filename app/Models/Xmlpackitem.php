<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xmlpackitem extends Model
{
    use HasFactory;

    protected $fillable = [

        'xmlpack_id',
        'name',
        'code',
        'qty',
        'brutto',
        'netto',
        'price',
        'country_name',
        'country_code',
        'currency_name',
        'currency_rate',
        'unit_name',
        'company_name',
        'company_from',
        'package_quantity',

    ];
}
