<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartieRequest;
use App\Http\Resources\PartieResource;
use App\Models\Partie;

class PartieController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartieRequest $request): PartieResource
    {
        $partie = Partie::create($request->validated());
        return new PartieResource($partie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Partie::destroy($id);
    }
}
