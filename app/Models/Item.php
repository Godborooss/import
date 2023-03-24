<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'qty',
        'price',
        'netto',
        'brutto',
        'package',
        'country',
        'pack_id',
        'taxcode',
        'nameofproduct',

    ];
    public function item()
    {

        return $this->belongsTo(Pack::class);
    }
}
