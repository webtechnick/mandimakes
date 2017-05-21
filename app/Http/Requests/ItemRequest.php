<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {
            case 'PATCH':
                return [
                    'title' => 'required|max:255',
                    'price_dollars' => 'required|numeric',
                    'description' => 'required',
                ];
            default:
                return [
                    'title' => 'required|unique:items|max:255',
                    'price_dollars' => 'required|numeric',
                    'description' => 'required',
                ];
        }
    }
}
