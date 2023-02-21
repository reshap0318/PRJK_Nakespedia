<?php

namespace App\Http\Requests;

use App\Models\PesertaModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PesertaRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $model = new PesertaModel();
        return [
            'no_reg' => [
                            'alpha_num',
                            'max:6',
                            'min:6',
                            'required',
                            Rule::unique($model->getConnectionName().".".$model->getTable(), "no_reg")
                            ->when(in_array($this->method(), ['PUT', 'PATCH']), function($q)
                            {
                                $peserta = $this->route()->parameter('peserta');
                                return $q->ignore($peserta);
                            })
                        ],
            'name'          => 'required',
            'origin'        => 'required',
            'event_title'   => 'required'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::id()
        ]);
    }
}
