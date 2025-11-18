<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $annonces = Annonce::all();
        foreach( $annonces as $annonce){
            $categoy= Category::where('id',$annonce->Categorie_id)->first();
            $user = User::where('id',$annonce->user_id)->first();
            $annonce->categorie=$categoy;
            $annonce->user=$user;
        }
        $categories = Category::where('type', 'annonce')->get();
        return view('annonces.index', compact(['annonces','categories']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::where('type', 'annonce')->get();

        return view('annonces.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'titre' => ['required', 'string', 'max:255'],
            'categorie' => 'required',
            'contenu' => ['required', 'string'],
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
                $category = Category::where('nom', $categorieInput)->where('type','annonce')->first();
            } else {
            $category = Category::Create(['nom' => $categorieInput,'type'=>'annonce']);
            }
        }

        if (! $category) {
            return back()->withErrors(['categorie' => 'Catégorie invalide'])->withInput();
        }

        if ($request->input('description')) {
            $description = $request->input('description');
        } else {
            $description = null;
        }

        // Créer l'équipement en liant l'id de la catégorie trouvée/créée
        $annonce = new Annonce;
        $annonce->titre = $request->titre;
        $annonce->user_id = $request->user()->id;
        $annonce->contenu = $request->contenu;
        $annonce->categorie()->associate($category);
        $annonce->save();
        return redirect()->route('annonces.index')->with('success', 'annonce créé avec succès!'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Annonce $annonce)
    {
        //
        $annonce = Annonce::where('id', $annonce->id)->first();
        $category = Category::where('id', $annonce->Categorie_id)->first();
        $user = User::where('id', $annonce->user_id)->first();
        $annonce->categorie = $category;
        $annonce->user = $user;
        return view('annonces.show', compact('annonce'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Annonce $annonce)
    {
        //
        $annonce = Annonce::where('id', $annonce->id)->first();
        $category = Category::where('id', $annonce->Categorie_id)->first();
        $annonce->categorie = $category;
        $categories = Category::where('type', 'annonce')->get();
        return view('annonces.edit', compact(['annonce','categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Annonce $annonce)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Annonce $annonce)
    {
        //
    }
}
