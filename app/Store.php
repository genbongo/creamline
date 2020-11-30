<?php

namespace App;

use App\Area;
use App\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Store extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'store_name', 'store_address', 'user_id', 'area_id',
    ];

    public function area()
    {
    	return $this->belongsTo(Area::class);
    }

    public function owner()
    {
    	return $this->belongsTo(User::class);
    }
}
