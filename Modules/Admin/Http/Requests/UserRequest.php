<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Admin\Models\Person;

class UserRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['password' => Str::random(6)]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [ 'required', 'email:rfc', Rule::unique('users')->ignore($this->user) ],
            'username' => [ 'required', 'alpha_num', Rule::unique('users')->ignore($this->user) ],
            'file' => 'image|nullable|max:512',
            'role_id' => 'required|exists:roles,id',
            'person.name' => 'string|required',
            'person.maiden_name' => 'string|nullable',
            'person.firstname' => 'string|nullable',
            'person.birthdate' => 'date|required',
            'person.gender' => ['required', Rule::in(array_values(Person::GENDERS))],
            'person.phone' => 'required|numeric',
            'person.geo_entity_id' => 'required|exists:geo_entities,id',
        ];
    }

    /**
     * Custom messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => "l'email est obligatoire",
            'email.email' => "Renseignez un email valide",
            'email.unique' => "Cet email est déjà pris",

            'username.required' => "Le nom d'utilisateur est obligatoire",
            'username.unique' => "Nom d'utilisateur déjà pris",
            'username.alpha_num' => "Ne renseignez que des chiffres ou des lettres",

            'role_id.required' => 'Renseignez le role',
            'role_id.exists' => "Ce role n'est pas repertorié",

            'person.name.string' => "Renseignez des caractères alphabétiques",
            'person.name.required' => "Renseignez le nom",
            'person.maiden_name.string' => "Renseignez des caractères alphabétiques",
            'person.birthdate.required' => "Renseignez la date de naissance",
            'person.birthdate.date' => "Renseignez une date valide",
            'person.firstname.string' => "Renseignez des caractères alphabétiques",
            'person.phone.required' => 'Renseignez le numéro de téléphone',
            'person.phone.numeric' => 'Ne renseignez que des chiffres',
            'person.geo_entity_id.required' => 'Renseignez le lieu de naissance',
            'person.geo_entity_id.exists' => "Ce lieu n'est pas repertorié",
            'person.gender.in' => "Sexe non pris en compte",
            'person.gender.required' => "Renseignez le ",
            'file.image' => 'Renseignez une image valide',
            'file.max' => 'La taille maximale est de 512 ko'
        ];
    }

}
