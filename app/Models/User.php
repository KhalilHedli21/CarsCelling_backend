<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Car;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = ['name', 'email', 'password'];

    public function cars() {
        return $this->hasMany(Car::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function messages() {
        return $this->hasMany(Message::class, 'sender_id');
    }
}