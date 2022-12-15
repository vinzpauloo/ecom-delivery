<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidMobilePhone;

class CustomerRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string', 'max:12', 'unique:users'],
            'password' => 'required|string|min:6|confirmed',
            'first_name' => 'required|string|min:6|max:20',
            'last_name' => 'required|string|min:6|max:20',

            'email' => 'required|email:rfc,dns|max:255|unique:users',
            'photo' => 'string|min:6|max:255',
            'house_number' => 'decimal|min:6|max:7',
            'street_name' => 'string|min:3|max:70',
            'barangay' => 'required|string|min:3|max:70',
            'city' => 'required|string|min:3|max:70',
            'is_delivery' => 'required|boolean',
        ];
    }
}
