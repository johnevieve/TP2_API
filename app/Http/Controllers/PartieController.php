<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartieRequest;
use App\Http\Resources\PartieResource;
use App\Models\Partie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Classe du contrôlleur des parties.
 */
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

                $valide = true;

                for ($i = 0; $i < $taille; $i++) {
                    $x = $horizontal ? $coordonneeX + $i : $coordonneeX;
                    $y = $horizontal ? $coordonneeY : chr(ord($coordonneeY) + $i);

                    if (isset($arrayCoordonnees[$x][$y]) || $x > 10 || $y > 'J') {
                        $valide = false;
                        break;
                    }
                }

            } while (!$valide);

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
     * Stockez une ressource d'une partie nouvellement créée dans le stockage.
     *
     * @param StorePartieRequest $request Demande requie.
     * @return JsonResponse Réponce en JSON.
     */
    public function store(StorePartieRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->authorize('create', Partie::class);

        $partie = Partie::create([
            'user_id' => Auth::id(),
            'adversaire' => $validated['adversaire'],
            'bateaux' => $this->placerBateaux()
        ]);

        return (new PartieResource($partie))->response()->setStatusCode(201);
    }

    /**
     * Supprimez la ressource d'une partie spécifiée du stockage.
     *
     * @param $id "Id" de la partie.
     * @return JsonResponse Réponce en JSON.
     */
    public function destroy($id): JsonResponse
    {
        $partie = Partie::findOrFail($id);
        $this->authorize('delete', $partie);
        Partie::destroy($id);

        return (new PartieResource($partie))->response()->setStatusCode(200);
    }
}
