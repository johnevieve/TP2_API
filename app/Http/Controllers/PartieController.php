<?php

namespace App\Http\Controllers;

use App\Http\Resources\PartieCollection;
use App\Http\Resources\PartieResource;
use App\Models\Partie;
use Illuminate\Http\Request;

class PartieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : PartieResource
    {
        // todo validation
        $patie = Partie::created();
        return new PartieResource($patie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Partie $partie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partie $partie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partie $partie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partie $partie)
    {
        //
    }
}
