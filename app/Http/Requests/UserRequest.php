<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $model = new User();
        return [
            'name'      => 'required',
            'email'     =>  [
                                'required',
                                Rule::unique($model->getConnectionName().".".$model->getTable(), "email")
                                ->when(in_array($this->method(), ['PUT', 'PATCH']), function($q)
                                {
                                    $user = $this->route()->parameter('user');
                                    return $q->ignore($user);
                                })
                            ],
            'username'  =>  [
                                'required',
                                Rule::unique($model->getConnectionName().".".$model->getTable(), "username")
                                ->when(in_array($this->method(), ['PUT', 'PATCH']), function($q)
                                {
                                    $user = $this->route()->parameter('user');
                                    return $q->ignore($user);
                                })
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
            'avatar'    => 'nullable|mimes:png,jpg,jpeg,gif',
            'role'      => ['required', Rule::in(array_keys(User::ROLE_TEXT))]
        ];
    }
}
