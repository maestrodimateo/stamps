<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Models\GeoEntity;
use Illuminate\Foundation\Http\FormRequest;

class GeoEntityRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('geo_entities')->ignore($this->geoEntity)],
            'code' => ['nullable', Rule::unique('geo_entities')->ignore($this->geoEntity), 'size:2'],
            'type' => [Rule::in(GeoEntity::TYPES), 'required'],
            'parent_id' => 'nullable|exists:geo_entities,id',
        ];
    }

    /**
     * Custom error messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire',
            'name.unique' => 'Le nom est déjà choisi',
            'code.unique' => 'Ce code ISO a déjà été choisi.',
            'code.size' => 'Renseignez deux caractères',
            'type.in' => "Type non pris en compte",
            'type.required' => "Le type est obligatoire",
            'parent_id.exists' => "Entité géographique inexistante",
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
