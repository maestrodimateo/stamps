<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Renseignez le mot de passe actuel',
            'current_password.current_password' => 'Le mot de passe actuel n\'est pas correct',
            'password.required' => 'Renseignez le nouveau de passe',
            'password.confirmed' => 'Les mot de passes ne correspondent pas',
            'password_confirmation.required' => 'Confirmez le mot de passe',
        ];
    }
}
