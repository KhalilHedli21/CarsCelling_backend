<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'make', 'model', 'year', 'price', 'mileage', 
        'fuel_type', 'transmission', 'description', 'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function images() {
        return $this->hasMany(CarImage::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}