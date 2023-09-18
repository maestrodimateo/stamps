<?php

namespace Modules\Stamp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label' => ['required', Rule::unique('types')->ignore($this->type)],
            'price' => 'integer|min:0|required'
        ];
    }

    public function messages()
    {
        return [
            'label.required' => 'Ce champs est obligatoire',
            'label.unique' => 'Ce libellé existe déjà',
            'price.required' => 'Ce champs est obligatoire',
            'price.integer' => 'Renseignez une valeur numérique',
            'price.min' => 'Renseignez au moins 0'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
