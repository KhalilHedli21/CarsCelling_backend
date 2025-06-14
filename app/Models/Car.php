<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'make',
        'model',
        'year',
        'price',
        'mileage',
        'fuel_type',
        'transmission',
        'description',
        'color',
        'location',
        'condition',
        'status',
        'features',
        'user_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'year' => 'integer',
        'mileage' => 'integer',
        'features' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}