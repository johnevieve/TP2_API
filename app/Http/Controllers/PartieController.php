<?php

namespace App\Http\Controllers;

use App\Http\Resources\PartieCollection;
use App\Http\Resources\PartieResource;
use App\Models\Missile;
use App\Models\Partie;
use Illuminate\Http\Request;

class PartieController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : PartieResource
    {
        // todo validation
        $partie = Partie::create();
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
