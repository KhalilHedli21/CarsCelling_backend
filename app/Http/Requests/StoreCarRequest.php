<?php

// app/Http/Requests/StoreCarRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer|min:1900',
            'price' => 'required|numeric',
            'mileage' => 'required|integer',
            'fuel_type' => 'required|string',
            'transmission' => 'required|string',
            'description' => 'nullable|string'
        ];
    }
}