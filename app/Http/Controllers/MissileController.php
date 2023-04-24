<?php

namespace App\Http\Controllers;

use App\Http\Resources\MissileResource;
use App\Models\Missile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MissileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store($id): JsonResponse //MissileResource
    {
        //$missiles = Missile::where('partie_id', $id)->get();

        $coordonnee = chr(ord('A') + rand(1, 10) - 1) . '-' . rand(1, 10);

        $missile = Missile::create([
            'partie_id' => $id,
            'coordonnee' => $coordonnee,
            'resultat' => null
        ]);

        return response()->json($missile, 201);
        //return new MissileResource($missile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Missile $missile): JsonResponse
    {
        return response()->json(null);
    }
}
