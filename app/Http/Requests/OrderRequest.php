<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'order.type_id' => ['required', 'integer'],
            'order.doing'   => ['required', 'integer'],
            'order.open_price'  => ['required', 'numeric'],
            'order.stop_price'  => ['required', 'numeric'],
            'order.earn_price'  => ['required', 'numeric'],
            'order.position'  => ['required', 'integer'],
        ];
        switch ($this->method()) {
            case 'POST': {
                return $rules;
            }
            case 'PUT': {
                return $rules;
            }
            case 'PATCH':
            case 'GET':
            case 'DELETE':
            default: {
                return [];
            };
        }
    }
}
