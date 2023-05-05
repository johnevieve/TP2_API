<?php

namespace App\Http\Controllers;

use App\Http\Resources\MissileResource;
use App\Models\Missile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MissileController extends Controller
{
    private function randomCoordonnee($id): string
    {
        $recherche = true;
        $taillePossible = 2;
        do {
            $coordonnee = chr(ord('A') + rand(1, 10) - 1) . '-' . rand(1, 10);
            $missile = Missile::where('coordonnee', $coordonnee)->where('partie_id', $id)->first();

            if ($missile === null) {
                $recherche = false;
            }
        } while ($recherche);

        return $coordonnee;
    }

    private function targetCoordonnee($id, $coordonneeTarget): ?string
    {
        $recherche = true;
        $coordonneesAdjacentes = $this->coordonneesAdjacentes($coordonneeTarget);

        do {
            if (empty($coordonneesAdjacentes)) {
                return null;
            }
            $randomIndex = array_rand($coordonneesAdjacentes);
            $coordonnee = $coordonneesAdjacentes[$randomIndex];
            array_splice($coordonneesAdjacentes, $randomIndex, 1);

            $missile = Missile::where('coordonnee', $coordonnee)->where('partie_id', $id)->first();
            if ($missile === null) {
                $recherche = false;
            }

        } while ($recherche);


        return $coordonnee;
    }

    private function coordonneesAdjacentes($coordonneeTarget): array
    {
        $ligne = intval(substr($coordonneeTarget, 2));
        $colonne = ord(substr($coordonneeTarget, 0, 1)) - ord('A') + 1;

        $coordonneesAdjacentes = [];

        if ($ligne > 1) {
            $coordonneesAdjacentes[] = chr($colonne + 64) . '-' . ($ligne - 1);
        }

        if ($ligne < 10) {
            $coordonneesAdjacentes[] = chr($colonne + 64) . '-' . ($ligne + 1);
        }

        if ($colonne > 1) {
            $coordonneesAdjacentes[] = chr($colonne + 63) . '-' . $ligne;
        }

        if ($colonne < 10) {
            $coordonneesAdjacentes[] = chr($colonne + 65) . '-' . $ligne;
        }

        return $coordonneesAdjacentes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id): JsonResponse
    {
        $missiles = Missile::where('partie_id', $id)
            ->where('resultat', 1)
            ->get();

        $coordonnee = null;

        if (!$missiles->isEmpty()) {
            $coordonnee = $this->targetCoordonnee($id, $missiles->first()->coordonnee);
        }

        if (empty($coordonnees)) {
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $coordonnee): JsonResponse
    {
        $missile = Missile::where('partie_id', $id)
            ->where('coordonnee', $coordonnee)
            ->firstOrFail();

        $missile->update(['resultat' => $request->input('resultat')]);

        return (new MissileResource($missile))->response()->setStatusCode(200);
    }
}
