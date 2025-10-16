<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getFullName()
    {
        return $this->getName() . " " . $this->getSurname();
    }

    // public function favoriteDishes()
    // {
    //     return $this->belongsToMany(Dish::class, 'dish_id', 'dishes_favs', 'dish_id', 'user_id', 'dish_id')->withTimestamps();
    // }
    
    public function favoriteDishes()
    {
        return $this->belongsToMany(
            Dish::class,
            'dishes_favs',
            'user_id',
            'dish_id',
            'id',
            'dish_id'
        );
    }

}
