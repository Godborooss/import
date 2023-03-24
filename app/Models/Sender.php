<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'user_id',

    ];

    public function pack()
    {
        return $this->hasOne(Receiver::class);
    }
}
