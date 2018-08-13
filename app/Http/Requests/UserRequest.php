<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'user.email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed'],
            'user.name' => ['required',  'max:30', Rule::unique('users', 'name')],
            'user.nick_name' => ['required',  'max:30', Rule::unique('users', 'nick_name')],
            'role' => ['required'],
            'user.mobile'   => ['nullable', 'max:30'],
            'user.image'    => ['nullable', 'image', 'max:2048'],
        ];

        if($this->method() == 'PUT'){
            $rules = [
                'user.email' => [],
                'user.nick_name' => ['required',  'max:30', Rule::unique('users', 'nick_name')->ignore($this->route('user'))],
                'password' => ['nullable', 'confirmed'],
            ];
        }
        return $rules;
    }
}
