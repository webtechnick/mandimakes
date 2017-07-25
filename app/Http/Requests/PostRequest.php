<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostRequest extends FormRequest
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
                    'body' => 'required',
                    'published_at' => 'required|date',
                ];
            default:
                return [
                    'title' => 'required|unique:posts|max:255',
                    'body' => 'required',
                    'published_at' => 'required|date',
                ];
        }
    }
}
