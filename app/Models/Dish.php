<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class Dish extends Model
{
    use HasFactory, Encryptable;

    protected $fillable = ['dishes_name', 'dishes_description', 'dishes_image_path', 'user_id'];
    protected $encryptable = ['dishes_description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreateur()
    {
        return $this->user ? $this->user->getFullName() : "Inconnu";
    }

    public function getDishId()
    {
        return $this->dish_id;
    }

    public function getNameDish()
    {
        return $this->dishes_name;
    }

    public function getDescriptionDish()
    {
        return $this->dishes_description;
    }

    public function getPathDish()
    {
        return $this->dishes_image_path;
    }

    public function favoredBy()
    {
        return $this->belongsToMany(
            User::class,
            'dishes_favs',
            'dish_id',
            'user_id',
            'dish_id',
            'id'
        );
    }

    
}
