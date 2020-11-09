<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileEditRequest extends FormRequest
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
        return [
            'username'=>'required|min:3|max:32',
            'email'=>['required', Rule::unique((new User)->getTable())->ignore(Auth::user()->id ?? null)],
            'avatar'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Please enter username!',
            'username.min' => 'Please enter username from 3 to 32 character!',
            'username.max' => 'Please enter username from 3 to 32 character!',
            'email.required' => 'Please enter email!',
            'email.unique' => 'Email has existed!',
            'avatar.image' => 'Avatar have to image!',
            'avatar.mimes' => 'Avatar have to .jpeg, .png, .jpg, .gif, .svg',
            'avatar.max' => 'Avatar max 2048MB!'
        ];
    }
}
