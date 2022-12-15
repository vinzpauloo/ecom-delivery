<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'max:50',
            'permit' => 'unique:restaurants|max:20',
            'building_number' => 'max:10',
            'street' => 'max:50',
            'city' => 'max:50',
            'branch' => 'max:50',
            'landline' => 'max:20',
            'mobile' => 'max:20',
            'social_link' => 'max:255',
            'photo' => 'max:30',
            'long' => 'max:255|required_with:lat',
            'lat' => 'max:255|required_with:long',
        ];
    }
}
