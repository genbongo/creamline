<?php

namespace App;

use App\Order;
use App\Store;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'area_name', 'area_code'
    ];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function staff()
    {
        return $this->hasMany(User::class);
    }

    public function clients()
    {
        $owner_ids =  $this->stores->pluck('user_id');

        return User::find($owner_ids);
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Store::class);
    }
}
