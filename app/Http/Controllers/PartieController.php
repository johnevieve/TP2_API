<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartieRequest;
use App\Http\Resources\PartieResource;
use App\Models\Partie;
use Illuminate\Http\JsonResponse;

class PartieController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartieRequest $request): JsonResponse //PartieResource
    {
        $partie = Partie::create($request->validated());
        $partie->bateaux = null;

        return response()->json($partie, 201);
        // return new PartieResource($partie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse //PartieResource
    {
        $partie = Partie::find($id);
        $partie->bateaux = null;
        Partie::destroy($id);

        return response()->json($partie);
        //return new PartieResource($partie);
    }
}
