<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;

    protected $fillable = [
        'nameofpack',
        'user_id',
        'receiver_id',
        'sender_id',
        'broker_id',
        'container',
        'method',
        'shipping_term',
        'currency',
        'car_number'

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }




    public function item()
    {
        return $this->hasOne(Item::class);
    }

    public function receiver()
    {

        return $this->belongsTo(Receiver::class);
    }
    public function broker()
    {

        return $this->belongsTo(Broker::class);
    }
    public function sender()
    {

        return $this->belongsTo(Sender::class);
    }

}
