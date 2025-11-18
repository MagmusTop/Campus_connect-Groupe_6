<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Equipement;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $equipements = Equipement::all();
        return view('equipements.index', compact('equipements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = collect([
            (object)[
                'id' => 1,
                'nom' => 'Vidéoprojecteur HD',
                'quantite' => 8,
                'description' => 'Vidéoprojecteur haute définition 1080p avec entrées HDMI et VGA',
                'categorie' => (object)['name' => 'Audiovisuel'],
                'reservations' => collect()
            ],
            (object)[
                'id' => 2,
                'nom' => 'Ordinateur Portable',
                'quantite' => 15,
                'description' => 'PC Portable Dell Latitude pour présentations et travaux pratiques',
                'categorie' => (object)['name' => 'Informatique'],
                'reservations' => collect()
            ],
            (object)[
                'id' => 3,
                'nom' => 'Tablette Graphique',
                'quantite' => 5,
                'description' => 'Tablettes Wacom Intuos pour cours de design et infographie',
                'categorie' => (object)['name' => 'Informatique'],
                'reservations' => collect()
            ]
        ]);
        return view('equipements.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipement $equipement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipement $equipement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipement $equipement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipement $equipement)
    {
        //
    }
}
