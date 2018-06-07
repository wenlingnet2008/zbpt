<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'room.name' => ['required'],
            'room.logo' => ['nullable', 'image'],
            'room.open' => ['required', 'integer'],
            'room.user_id' => ['required', 'integer'],
            'roles' => ['required', 'array'],
        ];
        return $rules;
    }
}
