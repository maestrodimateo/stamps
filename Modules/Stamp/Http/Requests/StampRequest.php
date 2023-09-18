<?php

namespace Modules\Stamp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StampRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_id' => 'required|exists:types,id',
        ];
    }

    /**
     * Actions avec validarions
     *
     * @return void
     */
    protected function passedValidation()
    {
        $this->merge(['user_id' => auth()->user()->id]);
    }

    public function messages()
    {
        return [
            'type_id.required' => 'Champ obligatoire',
            'type_id.exists' => 'Type inconnu',
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
