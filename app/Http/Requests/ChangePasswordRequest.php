<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CurrentPasswordCheckRule;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'old_password' => ['required', new CurrentPasswordCheckRule()],
            'new_password' => 'required|min:6',
            'cf_password' => 'required|same:new_password'
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Current password is required!',
            'new_password.required' => 'New password is required!',
            'new_password.min' => 'Password must be at least 6 characters!',
            'cf_password.required' => 'Confirm password is required!',
            'cf_password.same' => 'The confirm  password is not the same as the new password!'
        ];
    }
}
