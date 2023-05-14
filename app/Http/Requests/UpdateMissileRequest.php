<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe pour l'authorisation et les validations d'une mise à jour d'un missile.
 */
class UpdateMissileRequest extends FormRequest
{
    /**
     * Déterminez si l'utilisateur est autorisé à faire cette demande.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtenez les règles de validation qui s'appliquent à la demande.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> array de validation
     */
    public function rules(): array
    {
        return [
            'resultat' => 'required|numeric|between:0,6'
        ];
    }
}
