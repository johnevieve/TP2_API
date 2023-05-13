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
            if(Missile::where('coordonnee', implode($coordonneeTargetArray))->where('partie_id', $id)->first() === null) {
                return implode($coordonneeTargetArray);
            }
        }
        return null;
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

        foreach ($missiles as $missile){
            //var_dump($missile['coordonnee']);
            $coordonnee = $this->targetCoordonnee($id, $missile['coordonnee']);

            if($coordonnee != null) {
                break;
            }
        }

        if ($coordonnee === null) {
            //var_dump($coordonnee);
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
