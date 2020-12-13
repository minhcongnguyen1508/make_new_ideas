<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'cf_password' => 'required|same:new_password'
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'Bạn chưa nhập Mật khẩu cũ',
            'new_password.required' => 'Bạn chưa nhập Mật khẩu mới',
            'new_password.min' => 'Mật khẩu phải có ít nhất 6 kí tự',
            'new_password.regex' => 'Mật khẩu phải có 1 kí tự hoa và 1 kí tự đặc biệt',
            'cf_password.required' => 'Bạn chưa nhập lại Mật khẩu',
            'cf_password.same' => 'Mật khẩu nhập lại không giống Mật khẩu mới'
        ];
    }
}
