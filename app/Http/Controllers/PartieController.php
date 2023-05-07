<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartieRequest;
use App\Http\Resources\PartieResource;
use App\Models\Partie;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PartieController extends Controller
{


    private function placerBateaux()
    {
        $bateaux = [
            'porte-avions' => [],
            'cuirasse' => [],
            'destroyer' => [],
            'sous-marin' => [],
            'patrouilleur' => []
        ];

        $tailles = [
            'porte-avions' => 5,
            'cuirasse' => 4,
            'destroyer' => 3,
            'sous-marin' => 3,
            'patrouilleur' => 2
        ];

        $arrayCoordonnees = [];

        foreach ($bateaux as $nom => &$coordonnees) {
            $taille = $tailles[$nom];

            do {
                $coordonneeX = rand(1, 10);
                $coordonneeY = chr(ord('A') + rand(0, 9));
                $horizontal = rand(0, 1);

                $valid = true;

                for ($i = 0; $i < $taille; $i++) {
                    $x = $horizontal ? $coordonneeX + $i : $coordonneeX;
                    $y = $horizontal ? $coordonneeY : chr(ord($coordonneeY) + $i);

                    if (isset($arrayCoordonnees[$x][$y]) || $x > 10 || $y > 'J') {
                        $valid = false;
                        break;
                    }
                }

            } while (!$valid);

            for ($i = 0; $i < $taille; $i++) {
                $x = $horizontal ? $coordonneeX + $i : $coordonneeX;
                $y = $horizontal ? $coordonneeY : chr(ord($coordonneeY) + $i);
                $arrayCoordonnees[$x][$y] = true;
                $coordonnees[] = "$y-$x";
            }
        }

        return $bateaux;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartieRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $partie = Partie::create([
            'adversaire' => $validated['adversaire'],
            'user_id' => Auth::id()
        ]);
        $partie->bateaux = $this->placerBateaux();

        return (new PartieResource($partie))->response()->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $partie = Partie::find($id);
        $partie->bateaux = null;
        Partie::destroy($id);

        return (new PartieResource($partie))->response()->setStatusCode(200);
    }
}
