<?php

namespace App\Http\Requests;

use App\Traits\Flashes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    use Flashes;

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
        return [
            'password' => 'required',
            'new_password' => 'required|confirmed',
        ];
    }

    /**
     * custom
     * @param  [type] $validator [description]
     * @return [type]            [description]
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->invalidPassword()) {
                $validator->errors()->add('password', 'Password is incorrect');
            }
        });

        if ($validator->fails()) {
            $this->badFlash('Unable to update account.');
        }
    }

    /**
     * current password is invalid
     * @return [type] [description]
     */
    public function invalidPassword()
    {
        return !(Hash::check($this->input('password'), auth()->user()->password));
    }
}
