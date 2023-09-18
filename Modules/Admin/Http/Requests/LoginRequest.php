<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'identity' => 'required',
            'password' => 'required'
        ];
    }

    /**
     * More actions after the validations
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        if (filter_var($this->identity, FILTER_VALIDATE_EMAIL)) {
            $this->merge(['email' => $this->identity]);
            return;
        }

        $this->merge(['username' => $this->identity]);
    }

    /**
     * Get the errors messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'identity.required' => "Identifiant obligatoire",
            'password.required' => 'Le mot de passe est obligatoire',
        ];
    }
}
