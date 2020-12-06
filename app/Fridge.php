<?php

namespace App;

use App\Store;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Fridge extends Model
{
    protected $fillable = [
        'user_id', 'model', 'description', 'location', 'status'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'location');
    }
}
