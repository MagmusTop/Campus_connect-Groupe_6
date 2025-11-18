<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $equipements = Equipement::all();
        foreach( $equipements as $equipement){
            $categoy= Category::where('id',$equipement->Categorie_id)->first();
    
            $equipement->categorie=$categoy;
        }
        return view('equipements.index', compact('equipements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::where('type', 'equipement')->get();
        return view('equipements.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255'],
            'quantite' => ['required', 'integer', 'max:255'],
            'description' => '',
            'categorie' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $categorieInput = $request->input('categorie');

        // Si c'est un entier -> chercher par id
        if (is_numeric($categorieInput)) {
            $category = Category::find($categorieInput);
        } else {
            // si c'est une string -> chercher par nom ou créer
            if (Category::where('nom', $categorieInput)->where('type','equipement')->exists()) {
                $category = Category::where('nom', $categorieInput)->where('type','equipement')->first();
            } else {
            $category = Category::Create(['nom' => $categorieInput,'type'=>'equipement']);
            }
        }

        if ($request->input('description')) {
            $description = $request->input('description');
        } else {
            $description = null;
        }

        // Créer l'équipement en liant l'id de la catégorie trouvée/créée
        $equipement = new Equipement;
        $equipement->nom = $request->nom;
        $equipement->quantite = $request->quantite;
        $equipement->description = $description;
        $equipement->categorie()->associate($category);
        $equipement->save();
        return redirect()->route('equipements.index')->with('success', 'Matériel créé avec succès!'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipement $equipement)
    {
        //
        $equipement = Equipement::find($equipement->id);
        $categoy= Category::where('id',$equipement->Categorie_id)->first();
        $equipement->categorie=$categoy;
        return view('equipements.show', compact('equipement'));
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
