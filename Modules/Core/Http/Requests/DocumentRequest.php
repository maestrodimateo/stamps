<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|file|mimes:png,jpg,pdf,svg|max:1024',
            'documentable_id' => 'required|uuid'
        ];
    }

    /**
     * Custom messages
     *
     * @return void
     */
    public function messages()
    {
        return [
            'file.required' => 'Fichier obligatoire',
            'file.file' => 'Renseignez un fichier valide',
            'file.mimes' => 'Renseignez un fichier au format png, jpg, pdf ou svg',
            'file.max' => 'La taille maximum est de 1M',
            'documentable_id.required' => 'Renseignez l\'objet propriétaire de ce fichier',
            'documentable_id.uuid' => 'Renseignez un identifiant valide',
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
