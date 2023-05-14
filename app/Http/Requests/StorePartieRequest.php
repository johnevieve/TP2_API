<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe pour l'authorisation et les validations du storage d'une partie.
 */
class StorePartieRequest extends FormRequest
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
            'adversaire' => 'required'
        ];
    }
}
