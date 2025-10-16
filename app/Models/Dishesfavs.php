<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dishesfavs extends Model
{
    protected $table = "dishes_favs";
    protected $primaryKey = "id";
    
    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'dishes_favs', 'dish_id', 'user_id')
                    ->withTimestamps();
    }


}
