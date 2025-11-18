<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use App\Models\Reservation;
use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $reservations = Reservation::all();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $sales=Salle::all();
        $equipements = Equipement::all();
        return view('reservations.create', compact('sales','equipements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'salle_id' => 'nullable',
            "equipement_id" => "nullable",
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:heure_debut',
            'motif' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $reservation = new Reservation();
        $reservation->salle_id = $request->input('salle_id');
        $reservation->date_debut = $request->input('date_reservation') . ' ' . $request->input('heure_debut');
        $reservation->date_fin = $request->input('date_reservation') . ' ' . $request->input('heure_fin');
        $reservation->motif = $request->input('motif');
        $reservation->statut = 'en_attente';
        
        return redirect()->route('reservations.index')->with('success', 'Réservation créée avec succès et en attente de validation.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}