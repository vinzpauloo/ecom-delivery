<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidMobilePhone;

class MerchantRegisterRequest extends FormRequest
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
            'mobile' => ['required', 'numeric', 'unique:users', new ValidMobilePhone],
            'email' => 'required|email:rfc,dns|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
