<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'transmission' => 'required|in:automatic,manual',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid',
            'color' => 'required|string|max:50',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'features' => 'array',
            'features.*' => 'string|max:255',
            'location' => 'required|string|max:255',
            'condition' => 'required|in:new,used',
            'status' => 'required|in:available,sold,pending'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'brand.required' => 'The car brand is required.',
            'model.required' => 'The car model is required.',
            'year.required' => 'The manufacturing year is required.',
            'year.integer' => 'The year must be a valid number.',
            'year.min' => 'The year must be after 1900.',
            'year.max' => 'The year cannot be in the future.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price cannot be negative.',
            'mileage.required' => 'The mileage is required.',
            'mileage.integer' => 'The mileage must be a valid number.',
            'mileage.min' => 'The mileage cannot be negative.',
            'transmission.required' => 'The transmission type is required.',
            'transmission.in' => 'The transmission must be either automatic or manual.',
            'fuel_type.required' => 'The fuel type is required.',
            'fuel_type.in' => 'The fuel type must be one of: petrol, diesel, electric, or hybrid.',
            'color.required' => 'The color is required.',
            'description.required' => 'The description is required.',
            'images.*.image' => 'The file must be an image.',
            'images.*.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
            'images.*.max' => 'The image may not be greater than 2MB.',
            'location.required' => 'The location is required.',
            'condition.required' => 'The condition is required.',
            'condition.in' => 'The condition must be either new or used.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be one of: available, sold, or pending.'
        ];
    }
} 