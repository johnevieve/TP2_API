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
    public function store(StorePartieRequest $request): JsonResponse
    {
        $partie = Partie::create($request->validated());
        $partie->bateaux = null;

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
