<?php

namespace App\Http\Controllers;

//use App\Http\Requests\StoreMissileRequest;
use App\Http\Requests\UpdateMissileRequest;
use App\Http\Resources\MissileResource;
use App\Models\Missile;
use App\Models\Partie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Classe du contrôlleur des missiles.
 */
class MissileController extends Controller
{
    private function randomCoordonnee($id): string
    {
        do {
            $coordonnee = chr(ord('A') + rand(1, 10) - 1) . '-' . rand(1, 10);
            $missile = Missile::where('coordonnee', $coordonnee)->where('partie_id', $id)->first();
        } while ($missile != null);

        return $coordonnee;
    }

    private function targetCoordonnee($id, $coordonneeTarget): ?string
    {
        $directions = array('haut', 'bas', 'gauche', 'droite');
        shuffle($directions);

        foreach ($directions as $direction) {
            $coordonneeTargetArray = str_split($coordonneeTarget);
            switch ($direction) {
                case 'haut' :
                    if ($coordonneeTargetArray[0] > 'A') {
                        $coordonneeTargetArray[0] = chr(ord($coordonneeTargetArray[0]) - 1);
                    }
                    break;
                case 'bas' :
                    if ($coordonneeTargetArray[0] < 'J') {
                        $coordonneeTargetArray[0] = chr(ord($coordonneeTargetArray[0]) + 1);
                    }
                    break;
                case 'gauche' :
                    if ($coordonneeTargetArray[2] > 1) {
                        $coordonneeTargetArray[2] = $coordonneeTargetArray[2] - 1;
                    }
                    break;
                default :
                    if ($coordonneeTargetArray[2] < 10) {
                        $coordonneeTargetArray[2] = $coordonneeTargetArray[2] + 1;
                    }
                    break;
            }
            if (Missile::where('coordonnee', implode($coordonneeTargetArray))->where('partie_id', $id)->first() === null) {
                return implode($coordonneeTargetArray);
            }
        }
        return null;
    }

    /**
     * Stockez une ressource de missile nouvellement créée dans le stockage.
     *
     * @param $id "Id" de la partie.
     * @return JsonResponse Réponce en JSON
     */
    public function store($id): JsonResponse
    {
        $partie = Partie::where('id', $id)->firstOrFail();

        $this->authorize('create', [Missile::class, $partie]);

        $missiles = Missile::where('partie_id', $id)
            ->where('resultat', 1)
            ->get();

        $coordonnee = null;

        foreach ($missiles as $missile) {
            $coordonnee = $this->targetCoordonnee($id, $missile['coordonnee']);

            if ($coordonnee != null) {
                break;
            }
        }

        if ($coordonnee === null) {
            $coordonnee = $this->randomCoordonnee($id);
        }

        $missile = Missile::create([
            'partie_id' => $id,
            'coordonnee' => $coordonnee,
            'resultat' => null
        ]);

        return (new MissileResource($missile))->response()->setStatusCode(201);
    }

    /**
     * Mettez à jour la ressource du missile spécifiée dans le stockage.
     *
     * @param UpdateMissileRequest $request Demande requie
     * @param $id "Id" de la partie.
     * @param $coordonnee "Coordonne" du missile.
     * @return JsonResponse Réponce en JSON.
     */
    public function update(UpdateMissileRequest $request, $id, $coordonnee): JsonResponse
    {
        $partie = Partie::where('id', $id)->firstOrFail();

        $this->authorize('create', [Missile::class, $partie]);

        $validated = $request->validated();

        $missile = Missile::where('partie_id', $id)
            ->where('coordonnee', $coordonnee)
            ->firstOrFail();

        $missile->update(['resultat' => $validated['resultat']]);

        return (new MissileResource($missile))->response()->setStatusCode(200);
    }
}
