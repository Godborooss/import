<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'hvhh',
        'user_id',

    ];

    public function pack()
    {
        return $this->hasOne(Pack::class);
    }


}
