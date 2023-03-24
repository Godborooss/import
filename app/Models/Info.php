<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $fillable = [
        'container_number',
        'currency',
        'car_number',
        'method',
        'pack_id',
    ];
    public function info()
    {

        return $this->belongsTo(Pack::class);
    }
}
