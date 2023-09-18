<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'label' => ['required', Rule::unique('roles')->ignore(optional($this->role)->id)],
            'description' => 'nullable|string',
            'permissions' => 'array|min:1|required',
            'permissions.*' => 'exists:permissions,id',
        ];
    }

    public function messages()
    {
        return [
            'label.required' => 'Le libellé est obligatoire',
            'label.unique' => 'Ce libellé est déjà utilisé',
            'permissions.required' => 'Vous n\'avez renseigné aucunes permissions',
            'permissions.array' => 'Renseignez une liste de permissions',
            'permissions.min' => 'Renseignez au moins une permission',
            'permissions.*.exists' => 'Permission inexistante',
        ];
    }
}
