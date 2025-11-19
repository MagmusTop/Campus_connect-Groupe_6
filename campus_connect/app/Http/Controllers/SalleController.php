<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $salles = Salle::all();

        return view('salles.index', compact('salles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('salles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255','unique:salles,nom'],
            'capacite' => ['required', 'integer', 'max:255'],
            "localisation" => 'string|max:255',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $salle = new Salle();
        $salle->nom = $request->input('nom');
        $salle->capacite = $request->input('capacite');
        if (!$request->has('localisation')) {
            return redirect()->back()->withErrors('Le champ localisation est requis.');
        }
        $salle->localisation = $request->input('localisation');
        if ($request->has('description')) {
            $salle->description = $request->input('description');
        }
        $salle->save();

        return redirect()->route('salles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Salle $salle)
    {
        //
        return view('salles.show', compact('salle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salle $salle)
    {
        //
        return view('salles.form', compact('salle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salle $salle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salle $salle)
    {
        //
    }
}
