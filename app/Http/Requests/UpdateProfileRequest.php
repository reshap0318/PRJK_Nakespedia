<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $model = new User();
        $userId = Auth::id();
        return [
            'name'      => 'required',
            'email'     =>  [
                                'required',
                                Rule::unique($model->getConnectionName().".".$model->getTable(), "email")->ignore($userId)
                            ],
            'username'  =>  [
                                'required',
                                Rule::unique($model->getConnectionName().".".$model->getTable(), "username")->ignore($userId)
                            ],
            'password'  =>  [
                                in_array($this->method(), ['PUT', 'PATCH']) ? "nullable" : "required", 
                                "string", 
                                "min:8", 
                                "max:16", 
                                Password::min(8)->letters()->numbers()
                            ],
            'confirm_password'  =>  [
                                        in_array($this->method(), ['PUT', 'PATCH']) ? "nullable" : "required", 
                                        "same:password"
                                    ],
            'avatar'    => 'nullable|mimes:png,jpg,jpeg,gif'
        ];
    }
}
